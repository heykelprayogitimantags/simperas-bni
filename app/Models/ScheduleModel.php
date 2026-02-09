<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table            = 'maintenance_schedules';
    protected $primaryKey       = 'schedule_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'asset_id',
        'maintenance_type',
        'scheduled_date',
        'scheduled_time',
        'estimated_duration',
        'technician_id',
        'status',
        'notes'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'asset_id'       => 'required|numeric',
        'scheduled_date' => 'required|valid_date',
        'maintenance_type' => 'required|in_list[preventive,corrective,predictive]',
        'status'         => 'required|in_list[scheduled,in_progress,completed,cancelled]',
    ];

    protected $validationMessages = [
        'asset_id' => [
            'required' => 'Asset harus dipilih',
        ],
        'scheduled_date' => [
            'required'   => 'Tanggal jadwal harus diisi',
            'valid_date' => 'Format tanggal tidak valid',
        ],
    ];

    /**
     * Get schedules with asset and technician info
     */
    public function getSchedulesWithDetails($limit = null)
    {
        $builder = $this->select('maintenance_schedules.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                        ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                        ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                        ->orderBy('maintenance_schedules.scheduled_date', 'ASC');
        
        if ($limit) {
            return $builder->limit($limit)->get()->getResultArray();
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get upcoming schedules
     */
    public function getUpcomingSchedules($days = 7)
    {
        $today = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+{$days} days"));
        
        return $this->select('maintenance_schedules.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                    ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                    ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                    ->where('maintenance_schedules.scheduled_date >=', $today)
                    ->where('maintenance_schedules.scheduled_date <=', $endDate)
                    ->whereIn('maintenance_schedules.status', ['scheduled', 'in_progress'])
                    ->orderBy('maintenance_schedules.scheduled_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get schedules by asset
     */
    public function getSchedulesByAsset($assetId)
    {
        return $this->select('maintenance_schedules.*, users.full_name as technician_name')
                    ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                    ->where('maintenance_schedules.asset_id', $assetId)
                    ->orderBy('maintenance_schedules.scheduled_date', 'DESC')
                    ->findAll();
    }

    /**
     * Get schedules by technician
     */
    public function getSchedulesByTechnician($technicianId)
    {
        return $this->select('maintenance_schedules.*, assets.asset_name, assets.asset_code')
                    ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                    ->where('maintenance_schedules.technician_id', $technicianId)
                    ->whereIn('maintenance_schedules.status', ['scheduled', 'in_progress'])
                    ->orderBy('maintenance_schedules.scheduled_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get schedule detail
     */
    public function getScheduleDetail($scheduleId)
    {
        return $this->select('maintenance_schedules.*, assets.asset_name, assets.asset_code, assets.asset_type, users.full_name as technician_name')
                    ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                    ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                    ->where('maintenance_schedules.schedule_id', $scheduleId)
                    ->first();
    }

    /**
     * Get overdue schedules
     */
    public function getOverdueSchedules()
    {
        $today = date('Y-m-d');
        
        return $this->select('maintenance_schedules.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                    ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                    ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                    ->where('maintenance_schedules.scheduled_date <', $today)
                    ->whereIn('maintenance_schedules.status', ['scheduled', 'in_progress'])
                    ->orderBy('maintenance_schedules.scheduled_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get today's schedules
     */
    public function getTodaySchedules()
    {
        $today = date('Y-m-d');
        
        return $this->select('maintenance_schedules.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                    ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                    ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                    ->where('maintenance_schedules.scheduled_date', $today)
                    ->whereIn('maintenance_schedules.status', ['scheduled', 'in_progress'])
                    ->orderBy('maintenance_schedules.scheduled_time', 'ASC')
                    ->findAll();
    }

    /**
     * Update schedule status
     */
    public function updateScheduleStatus($scheduleId, $status)
    {
        return $this->update($scheduleId, ['status' => $status]);
    }

    /**
     * Check schedule conflict
     */
    public function hasConflict($technicianId, $date, $time, $duration, $excludeId = null)
    {
        $builder = $this->where('technician_id', $technicianId)
                        ->where('scheduled_date', $date)
                        ->whereIn('status', ['scheduled', 'in_progress']);
        
        if ($excludeId) {
            $builder->where('schedule_id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }
}