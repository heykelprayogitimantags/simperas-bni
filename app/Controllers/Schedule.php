<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleModel;
use App\Models\AssetModel;
use App\Models\UserModel;

class Schedule extends BaseController
{
    protected $scheduleModel;
    protected $assetModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->assetModel = new AssetModel();
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display schedule list
     */
    public function index()
    {
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        $month = $this->request->getGet('month') ?: date('Y-m');
        
        $builder = $this->scheduleModel->builder();
        $builder->select('maintenance_schedules.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left');
        
        // Filter by month
        if ($month) {
            $builder->like('maintenance_schedules.scheduled_date', $month);
        }
        
        // Filter by status
        if ($status) {
            $builder->where('maintenance_schedules.status', $status);
        }
        
        // Filter by type
        if ($type) {
            $builder->where('maintenance_schedules.maintenance_type', $type);
        }
        
       // Ambil data filter terlebih dahulu agar variabel tidak undefined
    $status = $this->request->getVar('status');
    $type   = $this->request->getVar('type');
    $month  = $this->request->getVar('month');

    // PERBAIKAN: Ambil data pagination langsung dari model (BUKAN dari $builder)
    // Simpan ke variabel $schedules sebelum masuk ke array $data
    $schedules = $this->scheduleModel
        ->orderBy('maintenance_schedules.scheduled_date', 'ASC')
        ->orderBy('maintenance_schedules.scheduled_time', 'ASC')
        ->paginate(15);

    $data = [
        'title' => 'Jadwal Perawatan',
        'user'  => [
            'full_name'  => $this->session->get('full_name'),
            'role'       => $this->session->get('role'),
            'department' => $this->session->get('department'),
        ],
        'schedules'     => $schedules, // Variabel ini sekarang sudah terdefinisi
        'pager'         => $this->scheduleModel->pager, // Objek pager untuk link halaman
        'status_filter' => $status,
        'type_filter'   => $type,
        'month_filter'  => $month,
        
        // Statistik
        'total_schedules' => $this->scheduleModel->countAll(),
        'scheduled'       => $this->scheduleModel->where('status', 'scheduled')->countAllResults(),
        'in_progress'     => $this->scheduleModel->where('status', 'in_progress')->countAllResults(),
        'completed'       => $this->scheduleModel->where('status', 'completed')->countAllResults(),
        'overdue'         => count($this->scheduleModel->getOverdueSchedules()),
        
        // Today & upcoming
        'today_schedules'    => $this->scheduleModel->getTodaySchedules(),
        'upcoming_schedules' => $this->scheduleModel->getUpcomingSchedules(7),
    ];

    return view('schedule/index', $data);
    }
    /**
     * Show create form
     */
    public function create()
    {
        // Get assets
        $assets = $this->assetModel->where('status !=', 'retired')
                                   ->orderBy('asset_name', 'ASC')
                                   ->findAll();
        
        // Get technicians
        $technicians = $this->userModel->where('role', 'teknisi')
                                       ->where('is_active', true)
                                       ->orderBy('full_name', 'ASC')
                                       ->findAll();
        
        $data = [
            'title' => 'Buat Jadwal Perawatan',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'assets' => $assets,
            'technicians' => $technicians,
        ];

        return view('schedule/create', $data);
    }

    /**
     * Store new schedule
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'asset_id' => 'required|numeric',
            'maintenance_type' => 'required|in_list[preventive,corrective,predictive]',
            'scheduled_date' => 'required|valid_date',
            'scheduled_time' => 'permit_empty',
            'estimated_duration' => 'permit_empty|numeric',
            'technician_id' => 'permit_empty|numeric',
            'notes' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $data = [
            'asset_id' => $this->request->getPost('asset_id'),
            'maintenance_type' => $this->request->getPost('maintenance_type'),
            'scheduled_date' => $this->request->getPost('scheduled_date'),
            'scheduled_time' => $this->request->getPost('scheduled_time') ?: null,
            'estimated_duration' => $this->request->getPost('estimated_duration') ?: null,
            'technician_id' => $this->request->getPost('technician_id') ?: null,
            'status' => 'scheduled',
            'notes' => $this->request->getPost('notes'),
        ];

        // Check conflict if technician assigned
        if ($data['technician_id'] && $data['scheduled_time'] && $data['estimated_duration']) {
            if ($this->scheduleModel->hasConflict($data['technician_id'], $data['scheduled_date'], $data['scheduled_time'], $data['estimated_duration'])) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Teknisi sudah memiliki jadwal pada waktu tersebut');
            }
        }

        if ($this->scheduleModel->insert($data)) {
            return redirect()->to('/schedule')
                           ->with('success', 'Jadwal perawatan berhasil dibuat');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal membuat jadwal');
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $schedule = $this->scheduleModel->find($id);

        if (!$schedule) {
            return redirect()->to('/schedule')
                           ->with('error', 'Jadwal tidak ditemukan');
        }

        // Get assets
        $assets = $this->assetModel->where('status !=', 'retired')
                                   ->orderBy('asset_name', 'ASC')
                                   ->findAll();
        
        // Get technicians
        $technicians = $this->userModel->where('role', 'teknisi')
                                       ->where('is_active', true)
                                       ->orderBy('full_name', 'ASC')
                                       ->findAll();
        
        $data = [
            'title' => 'Edit Jadwal Perawatan',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'schedule' => $schedule,
            'assets' => $assets,
            'technicians' => $technicians,
        ];

        return view('schedule/edit', $data);
    }

    /**
     * Update schedule
     */
    public function update($id)
    {
        $schedule = $this->scheduleModel->find($id);

        if (!$schedule) {
            return redirect()->to('/schedule')
                           ->with('error', 'Jadwal tidak ditemukan');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'asset_id' => 'required|numeric',
            'maintenance_type' => 'required|in_list[preventive,corrective,predictive]',
            'scheduled_date' => 'required|valid_date',
            'scheduled_time' => 'permit_empty',
            'estimated_duration' => 'permit_empty|numeric',
            'technician_id' => 'permit_empty|numeric',
            'status' => 'required|in_list[scheduled,in_progress,completed,cancelled]',
            'notes' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $data = [
            'asset_id' => $this->request->getPost('asset_id'),
            'maintenance_type' => $this->request->getPost('maintenance_type'),
            'scheduled_date' => $this->request->getPost('scheduled_date'),
            'scheduled_time' => $this->request->getPost('scheduled_time') ?: null,
            'estimated_duration' => $this->request->getPost('estimated_duration') ?: null,
            'technician_id' => $this->request->getPost('technician_id') ?: null,
            'status' => $this->request->getPost('status'),
            'notes' => $this->request->getPost('notes'),
        ];

        // Check conflict if technician assigned
        if ($data['technician_id'] && $data['scheduled_time'] && $data['estimated_duration']) {
            if ($this->scheduleModel->hasConflict($data['technician_id'], $data['scheduled_date'], $data['scheduled_time'], $data['estimated_duration'], $id)) {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Teknisi sudah memiliki jadwal pada waktu tersebut');
            }
        }

        if ($this->scheduleModel->update($id, $data)) {
            return redirect()->to('/schedule')
                           ->with('success', 'Jadwal berhasil diperbarui');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui jadwal');
        }
    }

    /**
     * Delete schedule
     */
    public function delete($id)
    {
        $schedule = $this->scheduleModel->find($id);

        if (!$schedule) {
            return redirect()->to('/schedule')
                           ->with('error', 'Jadwal tidak ditemukan');
        }

        // Only allow delete if status is scheduled
        if ($schedule['status'] !== 'scheduled') {
            return redirect()->to('/schedule')
                           ->with('error', 'Hanya jadwal dengan status "Scheduled" yang dapat dihapus');
        }

        if ($this->scheduleModel->delete($id)) {
            return redirect()->to('/schedule')
                           ->with('success', 'Jadwal berhasil dihapus');
        } else {
            return redirect()->to('/schedule')
                           ->with('error', 'Gagal menghapus jadwal');
        }
    }

    /**
     * Update schedule status
     */
    public function updateStatus($id)
    {
        $schedule = $this->scheduleModel->find($id);

        if (!$schedule) {
            return redirect()->to('/schedule')
                           ->with('error', 'Jadwal tidak ditemukan');
        }

        $newStatus = $this->request->getPost('status');
        
        if (!in_array($newStatus, ['scheduled', 'in_progress', 'completed', 'cancelled'])) {
            return redirect()->back()
                           ->with('error', 'Status tidak valid');
        }

        if ($this->scheduleModel->update($id, ['status' => $newStatus])) {
            return redirect()->to('/schedule')
                           ->with('success', 'Status jadwal berhasil diperbarui');
        } else {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui status');
        }
    }

    /**
     * Calendar view
     */
    public function calendar()
    {
        $month = $this->request->getGet('month') ?: date('Y-m');
        
        // Get all schedules for the month
        $schedules = $this->scheduleModel->builder()
                          ->select('maintenance_schedules.*, assets.asset_name, users.full_name as technician_name')
                          ->join('assets', 'assets.asset_id = maintenance_schedules.asset_id')
                          ->join('users', 'users.user_id = maintenance_schedules.technician_id', 'left')
                          ->like('maintenance_schedules.scheduled_date', $month)
                          ->get()
                          ->getResultArray();
        
        $data = [
            'title' => 'Kalender Jadwal Perawatan',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'schedules' => $schedules,
            'month' => $month,
        ];

        return view('schedule/calendar', $data);
    }
}