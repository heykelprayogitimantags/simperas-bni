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
     * Display maintenance log list (Admin/Teknisi)
     */
  public function index()
{
    $role   = $this->session->get('role');
    $userId = $this->session->get('user_id');

    $keyword = $this->request->getGet('keyword');
    $month   = $this->request->getGet('month') ?? date('Y-m');

    // Query utama (list + pagination)
    $this->maintenanceLogModel
        ->select('maintenance_logs.*, assets.asset_name, assets.asset_code, users.full_name AS technician_name')
        ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
        ->join('users', 'users.user_id = maintenance_logs.technician_id');

    // Filter role teknisi
    if ($role === 'teknisi') {
        $this->maintenanceLogModel
            ->where('maintenance_logs.technician_id', $userId);
    }

    // Filter bulan
    if ($month) {
        $this->maintenanceLogModel
            ->like('maintenance_logs.created_at', $month);
    }

    // Search
    if ($keyword) {
        $this->maintenanceLogModel
            ->groupStart()
                ->like('assets.asset_name', $keyword)
                ->orLike('maintenance_logs.diagnosis', $keyword)
                ->orLike('maintenance_logs.action_taken', $keyword)
            ->groupEnd();
    }

    // PAGINATION
    $logs = $this->maintenanceLogModel
        ->orderBy('maintenance_logs.created_at', 'DESC')
        ->paginate(10);

    // ✅ AMBIL PAGER SEBELUM RESET MODEL
    $pager = $this->maintenanceLogModel->pager;

    // 🔁 MODEL BARU KHUSUS STATISTIK
    $statModel = new \App\Models\MaintenanceLogModel();

    $data = [
        'title' => 'Log Maintenance',
        'user' => [
            'full_name'  => $this->session->get('full_name'),
            'role'       => $role,
            'department' => $this->session->get('department'),
        ],
        'logs'   => $logs,
        'pager'  => $pager,          // ✅ TIDAK NULL
        'keyword'=> $keyword,
        'month'  => $month,          // konsisten utk view

        // Statistik
        'total_logs' => $role === 'teknisi'
            ? $statModel->where('technician_id', $userId)->countAllResults()
            : $statModel->countAllResults(),

        'this_month' => $role === 'teknisi'
            ? $statModel->getMyMaintenanceThisMonth($userId)
            : $statModel->getMaintenanceThisMonth(),

        'total_cost' => $statModel->getTotalCostThisMonth(),
    ];

    return view('maintenance/index', $data);
}


    /**
     * Show update form (from ticket)
     */
    public function update($ticketId)
    {
        $role = $this->session->get('role');
        
        if (!in_array($role, ['admin', 'teknisi'])) {
            return redirect()->to('/dashboard')
                           ->with('error', 'Anda tidak memiliki akses');
        }

        $ticket = $this->ticketModel->getTicketDetail($ticketId);

        if (!$ticket) {
            return redirect()->to('/ticket')
                           ->with('error', 'Tiket tidak ditemukan');
        }

        // Check if already has maintenance log for this ticket
        $existingLog = $this->maintenanceLogModel->where('ticket_id', $ticketId)->first();

        $data = [
            'title' => 'Update Maintenance',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'ticket' => $ticket,
            'existing_log' => $existingLog,
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
            return redirect()->to('/dashboard')
                           ->with('error', 'Anda tidak memiliki akses');
        }

        $ticket = $this->ticketModel->find($ticketId);

        if (!$ticket) {
            return redirect()->to('/ticket')
                           ->with('error', 'Tiket tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'diagnosis' => 'required|min_length[10]',
            'action_taken' => 'required|min_length[10]',
            'parts_used' => 'permit_empty',
            'cost' => 'permit_empty|decimal',
            'start_time' => 'permit_empty|valid_date',
            'end_time' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $data = [
            'ticket_id' => $ticketId,
            'asset_id' => $ticket['asset_id'],
            'technician_id' => $this->session->get('user_id'),
            'diagnosis' => $this->request->getPost('diagnosis'),
            'action_taken' => $this->request->getPost('action_taken'),
            'parts_used' => $this->request->getPost('parts_used'),
            'cost' => $this->request->getPost('cost') ?: null,
            'start_time' => $this->request->getPost('start_time') 
                ? date('Y-m-d H:i:s', strtotime($this->request->getPost('start_time'))) 
                : null,
            'end_time' => $this->request->getPost('end_time') 
                ? date('Y-m-d H:i:s', strtotime($this->request->getPost('end_time'))) 
                : null,
        ];

        // Check if already has log for this ticket
        $existingLog = $this->maintenanceLogModel->where('ticket_id', $ticketId)->first();

        if ($existingLog) {
            // Update existing log
            if ($this->maintenanceLogModel->update($existingLog['log_id'], $data)) {
                // Update ticket status to completed
                $this->ticketModel->update($ticketId, ['status' => 'completed']);
                
                return redirect()->to('/ticket/detail/' . $ticketId)
                               ->with('success', 'Log maintenance berhasil diperbarui');
            }
        } else {
            // Insert new log
            if ($this->maintenanceLogModel->insert($data)) {
                // Update ticket status
                $newStatus = $this->request->getPost('ticket_status') ?: 'completed';
                $this->ticketModel->update($ticketId, ['status' => $newStatus]);
                
                return redirect()->to('/ticket/detail/' . $ticketId)
                               ->with('success', 'Log maintenance berhasil disimpan');
            }
        }

        return redirect()->back()
                       ->withInput()
                       ->with('error', 'Gagal menyimpan log maintenance');
    }

    /**
     * Delete maintenance log (Admin only)
     */
    public function delete($id)
    {
        $role = $this->session->get('role');
        
        if ($role !== 'admin') {
            return redirect()->to('/maintenance')
                           ->with('error', 'Hanya admin yang dapat menghapus log');
        }

        $log = $this->maintenanceLogModel->find($id);

        if (!$log) {
            return redirect()->to('/maintenance')
                           ->with('error', 'Log tidak ditemukan');
        }

        if ($this->maintenanceLogModel->delete($id)) {
            return redirect()->to('/maintenance')
                           ->with('success', 'Log maintenance berhasil dihapus');
        } else {
            return redirect()->to('/maintenance')
                           ->with('error', 'Gagal menghapus log');
        }
    }

    /**
     * View log detail
     */
    public function detail($id)
    {
        $log = $this->maintenanceLogModel->select('maintenance_logs.*, assets.asset_name, assets.asset_code, users.full_name as technician_name, tickets.ticket_number, tickets.title as ticket_title')
                    ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                    ->join('users', 'users.user_id = maintenance_logs.technician_id')
                    ->join('tickets', 'tickets.ticket_id = maintenance_logs.ticket_id', 'left')
                    ->where('maintenance_logs.log_id', $id)
                    ->first();

        if (!$log) {
            return redirect()->to('/maintenance')
                           ->with('error', 'Log tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Log Maintenance',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'log' => $log,
        ];

        return view('maintenance/detail', $data);
    }

    /**
     * My work history (for teknisi)
     */
   public function history()
{
    $userId = $this->session->get('user_id');

    $keyword = $this->request->getGet('keyword');
    $month   = $this->request->getGet('month') ?? date('Y-m');

    $this->maintenanceLogModel
        ->select('maintenance_logs.*, assets.asset_name, assets.asset_code')
        ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
        ->where('maintenance_logs.technician_id', $userId);

    if ($month) {
        $this->maintenanceLogModel
            ->like('maintenance_logs.created_at', $month);
    }

    if ($keyword) {
        $this->maintenanceLogModel
            ->groupStart()
                ->like('assets.asset_name', $keyword)
                ->orLike('maintenance_logs.diagnosis', $keyword)
            ->groupEnd();
    }

    // PAGINATION
    $logs = $this->maintenanceLogModel
        ->orderBy('maintenance_logs.created_at', 'DESC')
        ->paginate(10);

    // ✅ AMBIL PAGER DI SINI
    $pager = $this->maintenanceLogModel->pager;

    // 🔁 MODEL BARU KHUSUS STATISTIK
    $statModel = new \App\Models\MaintenanceLogModel();

    $data = [
        'title' => 'Riwayat Pekerjaan Saya',
        'user' => [
            'full_name'  => $this->session->get('full_name'),
            'role'       => $this->session->get('role'),
            'department' => $this->session->get('department'),
        ],
        'logs'   => $logs,
        'pager'  => $pager,      // ✅ TIDAK NULL
        'keyword'=> $keyword,
        'month'  => $month,

        'total_work' => $statModel
            ->where('technician_id', $userId)
            ->countAllResults(),

        'this_month' => $statModel
            ->getMyMaintenanceThisMonth($userId),
    ];

    return view('maintenance/history', $data);
}

}