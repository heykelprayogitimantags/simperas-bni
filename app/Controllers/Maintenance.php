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

        $builder = $this->maintenanceLogModel->builder();
        $builder->select('maintenance_logs.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                ->join('users', 'users.user_id = maintenance_logs.technician_id');

        // Filter role
        if ($role === 'teknisi') {
            $builder->where('maintenance_logs.technician_id', $userId);
        }

        // Filter bulan
        if ($month) {
            $builder->like('DATE(maintenance_logs.created_at)', $month);
        }

        // Search
        if ($keyword) {
            $builder->groupStart()
                    ->like('assets.asset_name', $keyword)
                    ->orLike('maintenance_logs.diagnosis', $keyword)
                    ->orLike('maintenance_logs.action_taken', $keyword)
                    ->groupEnd();
        }

        // 🔥 FIX UTAMA: EKSEKUSI QUERY
        $logs = $builder
            ->orderBy('maintenance_logs.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Log Maintenance',
            'user'  => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $role,
                'department' => $this->session->get('department'),
            ],
            'logs'          => $logs,
            'keyword'       => $keyword,
            'month_filter'  => $month,

            // Statistik
            'total_logs' => $role === 'teknisi'
                ? $this->maintenanceLogModel->where('technician_id', $userId)->countAllResults()
                : $this->maintenanceLogModel->countAll(),

            'this_month' => $role === 'teknisi'
                ? $this->maintenanceLogModel->getMyMaintenanceThisMonth($userId)
                : $this->maintenanceLogModel->getMaintenanceThisMonth(),

            'total_cost' => $this->maintenanceLogModel->getTotalCostThisMonth(),
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

        $builder = $this->maintenanceLogModel->builder();
        $builder->select('maintenance_logs.*, assets.asset_name, assets.asset_code')
                ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                ->where('maintenance_logs.technician_id', $userId);

        if ($month) {
            $builder->like('DATE(maintenance_logs.created_at)', $month);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('assets.asset_name', $keyword)
                    ->orLike('maintenance_logs.diagnosis', $keyword)
                    ->groupEnd();
        }

        // 🔥 FIX UTAMA
        $logs = $builder
            ->orderBy('maintenance_logs.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Riwayat Pekerjaan Saya',
            'user'  => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'logs'         => $logs,
            'keyword'      => $keyword,
            'month_filter' => $month,

            'total_work' => $this->maintenanceLogModel
                ->where('technician_id', $userId)
                ->countAllResults(),

            'this_month' => $this->maintenanceLogModel->getMyMaintenanceThisMonth($userId),
        ];

        return view('maintenance/history', $data);
    }
}
