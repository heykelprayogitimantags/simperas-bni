<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use App\Models\TicketModel;
use App\Models\MaintenanceLogModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $assetModel;
    protected $ticketModel;
    protected $maintenanceLogModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->assetModel = new AssetModel();
        $this->ticketModel = new TicketModel();
        $this->maintenanceLogModel = new MaintenanceLogModel();
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Main dashboard - redirect based on role
     */
    public function index()
    {
        $role = $this->session->get('role');

        switch ($role) {
            case 'admin':
                return redirect()->to('/dashboard/admin');
            case 'teknisi':
                return redirect()->to('/dashboard/teknisi');
            case 'pegawai':
                return redirect()->to('/dashboard/pegawai');
            default:
                return redirect()->to('/login');
        }
    }

    /**
     * Admin Dashboard
     */
    public function admin()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            
            // Asset Statistics
            'total_assets' => $this->assetModel->countAll(),
            'asset_by_status' => [
                'baik' => $this->assetModel->where('status', 'baik')->countAllResults(),
                'rusak_ringan' => $this->assetModel->where('status', 'rusak_ringan')->countAllResults(),
                'rusak_berat' => $this->assetModel->where('status', 'rusak_berat')->countAllResults(),
                'retired' => $this->assetModel->where('status', 'retired')->countAllResults(),
            ],
            'asset_by_type' => [
                'hardware' => $this->assetModel->where('asset_type', 'hardware')->countAllResults(),
                'software' => $this->assetModel->where('asset_type', 'software')->countAllResults(),
            ],
            
            // Ticket Statistics
            'total_tickets' => $this->ticketModel->countAll(),
            'ticket_by_status' => [
                'pending' => $this->ticketModel->where('status', 'pending')->countAllResults(),
                'in_progress' => $this->ticketModel->where('status', 'in_progress')->countAllResults(),
                'completed' => $this->ticketModel->where('status', 'completed')->countAllResults(),
            ],
            'ticket_by_priority' => [
                'low' => $this->ticketModel->where('priority', 'low')->countAllResults(),
                'medium' => $this->ticketModel->where('priority', 'medium')->countAllResults(),
                'high' => $this->ticketModel->where('priority', 'high')->countAllResults(),
            ],
            
            // Recent tickets
            'recent_tickets' => $this->ticketModel->getRecentTickets(5),
            
            // Maintenance this month
            'maintenance_this_month' => $this->maintenanceLogModel->getMaintenanceThisMonth(),
            
            // Total users
            'total_users' => $this->userModel->where('is_active', true)->countAllResults(),
            
            // Recent maintenance logs
            'recent_maintenance' => $this->maintenanceLogModel->getRecentLogs(5),
        ];

        return view('dashboard/admin', $data);
    }

    /**
     * Teknisi Dashboard
     */
    public function teknisi()
    {
        $userId = $this->session->get('user_id');

        $data = [
            'title' => 'Dashboard Teknisi',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            
            // Ticket statistics - nested format for view compatibility
            'my_tickets' => [
                'pending' => $this->ticketModel->where('status', 'pending')->countAllResults(),
                'in_progress' => $this->ticketModel->where('status', 'in_progress')->countAllResults(),
                'completed' => $this->ticketModel->where('status', 'completed')->countAllResults(),
            ],
            
            // Individual counts for teknisi_enhanced.php view
            'pending_tickets' => $this->ticketModel->where('status', 'pending')->countAllResults(),
            'in_progress_tickets' => $this->ticketModel->where('status', 'in_progress')->countAllResults(),
            'completed_this_month' => $this->maintenanceLogModel->getMyMaintenanceThisMonth($userId),
            'total_maintenance' => $this->maintenanceLogModel->where('technician_id', $userId)->countAllResults(),
            
            // Maintenance counts (for old view)
            'my_maintenance_count' => $this->maintenanceLogModel->where('technician_id', $userId)->countAllResults(),
            'my_maintenance_this_month' => $this->maintenanceLogModel->getMyMaintenanceThisMonth($userId),
            
            // Tickets to work on
            'assigned_tickets' => $this->ticketModel->getTicketsForTechnician(10),
            'pending_work' => $this->ticketModel->getTicketsForTechnician(5),
            
            // My recent work
            'my_recent_work' => $this->maintenanceLogModel->getMyRecentLogs($userId, 5),
            'recent_work' => $this->maintenanceLogModel->getMyRecentLogs($userId, 5),
            
            // Damaged assets
            'assets_need_attention' => [
                'rusak_ringan' => $this->assetModel->where('status', 'rusak_ringan')->countAllResults(),
                'rusak_berat' => $this->assetModel->where('status', 'rusak_berat')->countAllResults(),
            ],
            'damaged_assets' => $this->assetModel->whereIn('status', ['rusak_ringan'])->findAll(),
            'heavily_damaged' => $this->assetModel->where('status', 'rusak_berat')->countAllResults(),
            
            // Average duration
            'avg_duration' => $this->calculateAvgDuration($userId),
        ];

        return view('dashboard/teknisi', $data);
    }

    /**
     * Pegawai Dashboard
     */
    public function pegawai()
    {
        $userId = $this->session->get('user_id');

        $data = [
            'title' => 'Dashboard Pegawai',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            
            // My tickets - nested format for view
            'my_tickets' => [
                'total' => $this->ticketModel->where('reported_by', $userId)->countAllResults(),
                'pending' => $this->ticketModel->where('reported_by', $userId)->where('status', 'pending')->countAllResults(),
                'in_progress' => $this->ticketModel->where('reported_by', $userId)->where('status', 'in_progress')->countAllResults(),
                'completed' => $this->ticketModel->where('reported_by', $userId)->where('status', 'completed')->countAllResults(),
            ],
            
            // Individual counts (for compatibility)
            'total_tickets' => $this->ticketModel->where('reported_by', $userId)->countAllResults(),
            'pending_tickets' => $this->ticketModel->where('reported_by', $userId)->where('status', 'pending')->countAllResults(),
            'in_progress_tickets' => $this->ticketModel->where('reported_by', $userId)->where('status', 'in_progress')->countAllResults(),
            'completed_tickets' => $this->ticketModel->where('reported_by', $userId)->where('status', 'completed')->countAllResults(),
            
            // Recent tickets
            'my_recent_tickets' => $this->ticketModel->getMyTickets($userId, 5),
            'recent_tickets' => $this->ticketModel->getMyTickets($userId, 5),
            
            // Asset info
            'total_assets' => $this->assetModel->countAll(),
            'available_assets' => $this->assetModel->where('status', 'baik')->countAllResults(),
        ];

        return view('dashboard/pegawai', $data);
    }

    /**
     * Calculate average maintenance duration
     */
    private function calculateAvgDuration($technicianId)
    {
        $logs = $this->maintenanceLogModel
            ->select('start_time, end_time')
            ->where('technician_id', $technicianId)
            ->where('start_time IS NOT NULL')
            ->where('end_time IS NOT NULL')
            ->findAll();
        
        if (empty($logs)) {
            return 0;
        }
        
        $totalDuration = 0;
        $count = 0;
        
        foreach ($logs as $log) {
            if ($log['start_time'] && $log['end_time']) {
                $start = strtotime($log['start_time']);
                $end = strtotime($log['end_time']);
                if ($end > $start) {
                    $totalDuration += ($end - $start) / 60; // minutes
                    $count++;
                }
            }
        }
        
        return $count > 0 ? round($totalDuration / $count) : 0;
    }

    /**
     * Get dashboard stats (AJAX)
     */
    public function getStats()
    {
        $role = $this->session->get('role');
        $stats = [];

        switch ($role) {
            case 'admin':
                $stats = [
                    'total_assets' => $this->assetModel->countAll(),
                    'total_tickets' => $this->ticketModel->countAll(),
                    'pending_tickets' => $this->ticketModel->where('status', 'pending')->countAllResults(),
                ];
                break;
            
            case 'teknisi':
                $userId = $this->session->get('user_id');
                $stats = [
                    'pending_tickets' => $this->ticketModel->where('status', 'pending')->countAllResults(),
                    'my_completed' => $this->maintenanceLogModel->where('technician_id', $userId)->countAllResults(),
                ];
                break;
            
            case 'pegawai':
                $userId = $this->session->get('user_id');
                $stats = [
                    'my_tickets' => $this->ticketModel->where('reported_by', $userId)->countAllResults(),
                    'pending' => $this->ticketModel->where('reported_by', $userId)->where('status', 'pending')->countAllResults(),
                ];
                break;
        }

        return $this->response->setJSON($stats);
    }
}