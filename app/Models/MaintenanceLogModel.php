<?php

namespace App\Models;

use CodeIgniter\Model;

class MaintenanceLogModel extends Model
{
    protected $table            = 'maintenance_logs';
    protected $primaryKey       = 'log_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ticket_id',
        'asset_id',
        'technician_id',
        'diagnosis',
        'action_taken',
        'parts_used',
        'cost',
        'start_time',
        'end_time'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'asset_id'      => 'required|numeric',
        'technician_id' => 'required|numeric',
        'diagnosis'     => 'required|min_length[10]',
        'action_taken'  => 'required|min_length[10]',
    ];

    protected $validationMessages = [
        'diagnosis' => [
            'required'   => 'Diagnosis harus diisi',
            'min_length' => 'Diagnosis minimal 10 karakter',
        ],
        'action_taken' => [
            'required'   => 'Action taken harus diisi',
            'min_length' => 'Action taken minimal 10 karakter',
        ],
    ];

    /**
     * Get recent maintenance logs
     */
    public function getRecentLogs($limit = 10)
    {
        return $this->select('maintenance_logs.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                    ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                    ->join('users', 'users.user_id = maintenance_logs.technician_id')
                    ->orderBy('maintenance_logs.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get my recent logs (for technician)
     */
    public function getMyRecentLogs($technicianId, $limit = 10)
    {
        return $this->select('maintenance_logs.*, assets.asset_name, assets.asset_code')
                    ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                    ->where('maintenance_logs.technician_id', $technicianId)
                    ->orderBy('maintenance_logs.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get maintenance logs this month
     */
    public function getMaintenanceThisMonth()
    {
        $startOfMonth = date('Y-m-01 00:00:00');
        $endOfMonth = date('Y-m-t 23:59:59');
        
        return $this->where('created_at >=', $startOfMonth)
                    ->where('created_at <=', $endOfMonth)
                    ->countAllResults();
    }

    /**
     * Get my maintenance this month (for technician)
     */
    public function getMyMaintenanceThisMonth($technicianId)
    {
        $startOfMonth = date('Y-m-01 00:00:00');
        $endOfMonth = date('Y-m-t 23:59:59');
        
        return $this->where('technician_id', $technicianId)
                    ->where('created_at >=', $startOfMonth)
                    ->where('created_at <=', $endOfMonth)
                    ->countAllResults();
    }

    /**
     * Get logs by asset
     */
    public function getLogsByAsset($assetId)
    {
        return $this->select('maintenance_logs.*, users.full_name as technician_name')
                    ->join('users', 'users.user_id = maintenance_logs.technician_id')
                    ->where('maintenance_logs.asset_id', $assetId)
                    ->orderBy('maintenance_logs.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get logs by ticket
     */
    public function getLogsByTicket($ticketId)
    {
        return $this->select('maintenance_logs.*, users.full_name as technician_name, assets.asset_name')
                    ->join('users', 'users.user_id = maintenance_logs.technician_id')
                    ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                    ->where('maintenance_logs.ticket_id', $ticketId)
                    ->orderBy('maintenance_logs.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get total cost this month
     */
    public function getTotalCostThisMonth()
    {
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t');
        
        $result = $this->selectSum('cost')
                       ->where('DATE(created_at) >=', $startOfMonth)
                       ->where('DATE(created_at) <=', $endOfMonth)
                       ->first();
        
        return $result['cost'] ?? 0;
    }

    /**
     * Calculate maintenance duration
     */
    public function calculateDuration($logId)
    {
        $log = $this->find($logId);
        
        if (!$log || !$log['start_time'] || !$log['end_time']) {
            return 0;
        }
        
        $start = strtotime($log['start_time']);
        $end = strtotime($log['end_time']);
        
        return round(($end - $start) / 60); // in minutes
    }
}