<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaintenanceLogModel;
use App\Models\TicketModel;
use App\Models\AssetModel;
use App\Models\UserModel;

class Maintenance extends BaseController
{
    protected $maintenanceLogModel;
    protected $ticketModel;
    protected $assetModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->maintenanceLogModel = new MaintenanceLogModel();
        $this->ticketModel = new TicketModel();
        $this->assetModel = new AssetModel();
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display maintenance log list (Admin / Teknisi)
     */
    public function index()
    {
        $role   = $this->session->get('role');
        $userId = $this->session->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $month   = $this->request->getGet('month') ?: date('Y-m');

        // ⭐ PERBAIKAN: JOIN langsung ke assets (sesuai struktur DB)
        $this->maintenanceLogModel
            ->select('maintenance_logs.*, 
                     assets.asset_name, 
                     assets.asset_code,
                     tickets.ticket_number,
                     users.full_name as technician_name')
            ->join('assets', 'assets.asset_id = maintenance_logs.asset_id', 'left')
            ->join('tickets', 'tickets.ticket_id = maintenance_logs.ticket_id', 'left')
            ->join('users', 'users.user_id = maintenance_logs.technician_id', 'left')
            ->orderBy('maintenance_logs.created_at', 'DESC');

        // Filter role
        if ($role === 'teknisi') {
            $this->maintenanceLogModel->where('maintenance_logs.technician_id', $userId);
        }

        // Filter bulan
        if ($month) {
            $this->maintenanceLogModel->like('DATE(maintenance_logs.created_at)', $month);
        }

        // Search
        if ($keyword) {
            $this->maintenanceLogModel->groupStart()
                    ->like('assets.asset_name', $keyword)
                    ->orLike('maintenance_logs.diagnosis', $keyword)
                    ->orLike('maintenance_logs.action_taken', $keyword)
                    ->groupEnd();
        }

        // Get data dengan pagination
        $logs = $this->maintenanceLogModel->paginate(10, 'default');

        // Statistik
        $currentMonth = $month ?? date('Y-m');
        
        // Total logs
        if ($role === 'teknisi') {
            $totalLogsBuilder = $this->maintenanceLogModel->builder();
            $totalLogs = $totalLogsBuilder->where('technician_id', $userId)->countAllResults();
        } else {
            $totalLogs = $this->maintenanceLogModel->countAll();
        }
        
        // Monthly logs
        $monthlyLogsBuilder = $this->maintenanceLogModel->builder();
        if ($role === 'teknisi') {
            $monthlyLogsBuilder->where('technician_id', $userId);
        }
        $monthlyLogs = $monthlyLogsBuilder->like('DATE(created_at)', $currentMonth)
                                          ->countAllResults();
        
        // Monthly cost
        $monthlyCostBuilder = $this->maintenanceLogModel->builder();
        if ($role === 'teknisi') {
            $monthlyCostBuilder->where('technician_id', $userId);
        }
        $monthlyCostResult = $monthlyCostBuilder->selectSum('cost')
                                                ->like('DATE(created_at)', $currentMonth)
                                                ->get()
                                                ->getRowArray();
        $monthlyCost = $monthlyCostResult['cost'] ?? 0;

        $data = [
            'title' => 'Log Maintenance',
            'user'  => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $role,
                'department' => $this->session->get('department'),
            ],
            'logs'   => $logs,
            'pager'  => $this->maintenanceLogModel->pager,
            'keyword' => $keyword,
            'month_filter' => $month,

            // Statistik
            'total_logs'   => $totalLogs,
            'monthly_logs' => $monthlyLogs,
            'monthly_cost' => $monthlyCost,
        ];

        return view('maintenance/index', $data);
    }

    
    /**
     * My work history (Teknisi)
     */
    public function history()
    {
        $userId = $this->session->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $month   = $this->request->getGet('month') ?: date('Y-m');

        // Build query
        $this->maintenanceLogModel
            ->select('maintenance_logs.*, 
                     assets.asset_name, 
                     assets.asset_code,
                     tickets.ticket_number')
            ->join('assets', 'assets.asset_id = maintenance_logs.asset_id', 'left')
            ->join('tickets', 'tickets.ticket_id = maintenance_logs.ticket_id', 'left')
            ->where('maintenance_logs.technician_id', $userId)
            ->orderBy('maintenance_logs.created_at', 'DESC');

        if ($month) {
            $this->maintenanceLogModel->like('DATE(maintenance_logs.created_at)', $month);
        }

        if ($keyword) {
            $this->maintenanceLogModel->groupStart()
                    ->like('assets.asset_name', $keyword)
                    ->orLike('maintenance_logs.diagnosis', $keyword)
                    ->groupEnd();
        }

        // Get data dengan pagination
        $logs = $this->maintenanceLogModel->paginate(10, 'default');

        // Statistik
        $currentMonth = $month ?? date('Y-m');
        
        $totalWorkBuilder = $this->maintenanceLogModel->builder();
        $totalWork = $totalWorkBuilder->where('technician_id', $userId)->countAllResults();
        
        $monthlyWorkBuilder = $this->maintenanceLogModel->builder();
        $monthlyWork = $monthlyWorkBuilder->where('technician_id', $userId)
                                          ->like('DATE(created_at)', $currentMonth)
                                          ->countAllResults();

        $data = [
            'title' => 'Riwayat Pekerjaan Saya',
            'user'  => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'logs'   => $logs,
            'pager'  => $this->maintenanceLogModel->pager,
            'keyword' => $keyword,
            'month_filter' => $month,

            'total_work'   => $totalWork,
            'monthly_work' => $monthlyWork,
        ];

        return view('maintenance/history', $data);
    }

    /**
     * Show update form for a ticket
     */
    public function update($ticketId)
    {
        $role = $this->session->get('role');
        
        if (!in_array($role, ['admin', 'teknisi'])) {
            return redirect()->to('/maintenance')
                           ->with('error', 'Anda tidak memiliki akses');
        }

        // Get ticket detail
        $ticket = $this->ticketModel->getTicketDetail($ticketId);

        if (!$ticket) {
            return redirect()->to('/maintenance')
                           ->with('error', 'Tiket tidak ditemukan');
        }

        // Get existing maintenance logs for this ticket
        $logs = $this->maintenanceLogModel->getLogsByTicket($ticketId);

        $data = [
            'title' => 'Update Perbaikan',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'ticket' => $ticket,
            'logs' => $logs,
        ];

        return view('maintenance/update', $data);
    }

    /**
     * Save maintenance log
     */
    public function save($ticketId)
    {
        $role = $this->session->get('role');
        
        if (!in_array($role, ['admin', 'teknisi'])) {
            return redirect()->to('/maintenance')
                           ->with('error', 'Anda tidak memiliki akses');
        }

        // Get ticket untuk ambil asset_id
        $ticket = $this->ticketModel->find($ticketId);
        
        if (!$ticket) {
            return redirect()->back()
                           ->with('error', 'Tiket tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        // ⭐ PERBAIKAN: Sesuai field di database
        $rules = [
            'diagnosis' => 'required|min_length[10]',
            'action_taken' => 'required|min_length[10]',
            'parts_used' => 'permit_empty|max_length[255]',
            'cost' => 'required|numeric',
            'start_time' => 'required|valid_date',
            'end_time' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        // ⭐ PERBAIKAN: Field sesuai struktur database
        $data = [
            'ticket_id' => $ticketId,
            'asset_id' => $ticket['asset_id'], // Ambil dari ticket
            'technician_id' => $this->session->get('user_id'),
            'diagnosis' => $this->request->getPost('diagnosis'),
            'action_taken' => $this->request->getPost('action_taken'),
            'parts_used' => $this->request->getPost('parts_used'),
            'cost' => $this->request->getPost('cost'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
        ];

        if ($this->maintenanceLogModel->insert($data)) {
            // Update ticket status to in_progress
            $this->ticketModel->update($ticketId, ['status' => 'in_progress']);

            return redirect()->to('/maintenance/update/' . $ticketId)
                           ->with('success', 'Log maintenance berhasil ditambahkan');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menyimpan log maintenance');
        }
    }
}