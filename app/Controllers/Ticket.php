<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\AssetModel;
use App\Models\UserModel;
use App\Models\MaintenanceLogModel;

class Ticket extends BaseController
{
    protected $ticketModel;
    protected $assetModel;
    protected $userModel;
    protected $maintenanceLogModel;
    protected $session;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->assetModel = new AssetModel();
        $this->userModel = new UserModel();
        $this->maintenanceLogModel = new MaintenanceLogModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display ticket list (for all roles)
     */
    public function index()
    {
        $role = $this->session->get('role');
        $userId = $this->session->get('user_id');
        
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');
        
        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, assets.asset_name, assets.asset_code, users.full_name as reporter_name')
                ->join('assets', 'assets.asset_id = tickets.asset_id')
                ->join('users', 'users.user_id = tickets.reported_by');
        
        // Filter by role
        if ($role === 'pegawai') {
            // Pegawai only see their own tickets
            $builder->where('tickets.reported_by', $userId);
        }
        // Admin & Teknisi see all tickets
        
        // Apply filters
        if ($keyword) {
            $builder->groupStart()
                    ->like('tickets.ticket_number', $keyword)
                    ->orLike('tickets.title', $keyword)
                    ->orLike('tickets.description', $keyword)
                    ->orLike('assets.asset_name', $keyword)
                    ->groupEnd();
        }
        
        if ($status) {
            $builder->where('tickets.status', $status);
        }
        
        if ($priority) {
            $builder->where('tickets.priority', $priority);
        }
        
        $data = [
            'title' => 'Daftar Tiket',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            
            'pager' => $this->ticketModel->pager,
            'keyword' => $keyword,
            'status_filter' => $status,
            'priority_filter' => $priority,
            
            // Statistics
            'total_tickets' => $this->ticketModel->countAll(),
            'pending' => $this->ticketModel->where('status', 'pending')->countAllResults(),
            'in_progress' => $this->ticketModel->where('status', 'in_progress')->countAllResults(),
            'completed' => $this->ticketModel->where('status', 'completed')->countAllResults(),
        ];

        return view('ticket/index', $data);
    }

    /**
     * Show create form (for pegawai)
     */
    public function create()
    {
        // Get all assets with status 'baik' or 'rusak_ringan'
        $assets = $this->assetModel->whereIn('status', ['baik', 'rusak_ringan', 'rusak_berat'])
                                   ->orderBy('asset_name', 'ASC')
                                   ->findAll();
        
        $data = [
            'title' => 'Lapor Kerusakan',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'assets' => $assets,
        ];

        return view('ticket/create', $data);
    }

    /**
     * Store new ticket
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'asset_id' => 'required|numeric',
            'title' => 'required|min_length[5]|max_length[200]',
            'description' => 'required|min_length[10]',
            'priority' => 'required|in_list[low,medium,high]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        // Generate ticket number
        $ticketNumber = $this->ticketModel->generateTicketNumber();

        $data = [
            'ticket_number' => $ticketNumber,
            'asset_id' => $this->request->getPost('asset_id'),
            'reported_by' => $this->session->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 'pending',
        ];

        if ($this->ticketModel->insert($data)) {
            return redirect()->to('/ticket/my-tickets')
                           ->with('success', 'Tiket berhasil dibuat dengan nomor: ' . $ticketNumber);
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal membuat tiket');
        }
    }

    /**
     * Show ticket detail
     */
    public function detail($id)
    {
        $ticket = $this->ticketModel->getTicketDetail($id);

        if (!$ticket) {
            return redirect()->to('/ticket')
                           ->with('error', 'Tiket tidak ditemukan');
        }

        // Check permission
        $role = $this->session->get('role');
        $userId = $this->session->get('user_id');
        
        if ($role === 'pegawai' && $ticket['reported_by'] != $userId) {
            return redirect()->to('/ticket')
                           ->with('error', 'Anda tidak memiliki akses ke tiket ini');
        }

        // Get maintenance logs for this ticket
        $maintenanceLogs = $this->maintenanceLogModel->getLogsByTicket($id);

        $data = [
            'title' => 'Detail Tiket',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'ticket' => $ticket,
            'maintenance_logs' => $maintenanceLogs,
        ];

        return view('ticket/detail', $data);
    }

    /**
     * Update ticket status (for admin/teknisi)
     */
    public function updateStatus($id)
    {
        $role = $this->session->get('role');
        
        if (!in_array($role, ['admin', 'teknisi'])) {
            return redirect()->to('/ticket')
                           ->with('error', 'Anda tidak memiliki akses untuk mengubah status');
        }

        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->to('/ticket')
                           ->with('error', 'Tiket tidak ditemukan');
        }

        $newStatus = $this->request->getPost('status');
        
        if (!in_array($newStatus, ['pending', 'in_progress', 'completed'])) {
            return redirect()->back()
                           ->with('error', 'Status tidak valid');
        }

        if ($this->ticketModel->update($id, ['status' => $newStatus])) {
            return redirect()->to('/ticket/detail/' . $id)
                           ->with('success', 'Status tiket berhasil diperbarui');
        } else {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui status');
        }
    }

    /**
     * My tickets (for pegawai)
     */
    public function myTickets()
    {
        $userId = $this->session->get('user_id');
        
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        
        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, assets.asset_name, assets.asset_code')
                ->join('assets', 'assets.asset_id = tickets.asset_id')
                ->where('tickets.reported_by', $userId);
        
        if ($keyword) {
            $builder->groupStart()
                    ->like('tickets.ticket_number', $keyword)
                    ->orLike('tickets.title', $keyword)
                    ->groupEnd();
        }
        
        if ($status) {
            $builder->where('tickets.status', $status);
        }
        
        $data = [
            'title' => 'Tiket Saya',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'pager' => $this->ticketModel->pager,
            'keyword' => $keyword,
            'status_filter' => $status,
            
            // My statistics
            'total' => $this->ticketModel->where('reported_by', $userId)->countAllResults(),
            'pending' => $this->ticketModel->where('reported_by', $userId)->where('status', 'pending')->countAllResults(),
            'in_progress' => $this->ticketModel->where('reported_by', $userId)->where('status', 'in_progress')->countAllResults(),
            'completed' => $this->ticketModel->where('reported_by', $userId)->where('status', 'completed')->countAllResults(),
        ];

        return view('ticket/my_tickets', $data);
    }

    /**
     * Delete ticket (admin only)
     */
    public function delete($id)
    {
        $role = $this->session->get('role');
        
        if ($role !== 'admin') {
            return redirect()->to('/ticket')
                           ->with('error', 'Hanya admin yang dapat menghapus tiket');
        }

        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->to('/ticket')
                           ->with('error', 'Tiket tidak ditemukan');
        }

        // Check if has maintenance logs
        $hasLogs = $this->maintenanceLogModel->where('ticket_id', $id)->countAllResults() > 0;

        if ($hasLogs) {
            return redirect()->to('/ticket')
                           ->with('error', 'Tiket tidak dapat dihapus karena memiliki log maintenance terkait');
        }

        if ($this->ticketModel->delete($id)) {
            return redirect()->to('/ticket')
                           ->with('success', 'Tiket berhasil dihapus');
        } else {
            return redirect()->to('/ticket')
                           ->with('error', 'Gagal menghapus tiket');
        }
    }

    /**
     * Get asset details (AJAX)
     */
    public function getAsset($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Asset tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $asset
        ]);
    }
}