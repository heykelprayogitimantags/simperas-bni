<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;

class Asset extends BaseController
{
    protected $assetModel;
    protected $session;

    public function __construct()
    {
        $this->assetModel = new AssetModel();
        $this->session = \Config\Services::session();
    }

    /**
     * ============================
     * LIST ASSET
     * ============================
     */
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $type    = $this->request->getGet('type');
        $status  = $this->request->getGet('status');

        // ⭐ Build query dengan model (bukan builder)
        if ($keyword) {
            $this->assetModel->groupStart()
                             ->like('asset_name', $keyword)
                             ->orLike('asset_code', $keyword)
                             ->orLike('brand', $keyword)
                             ->orLike('serial_number', $keyword)
                             ->groupEnd();
        }

        if ($type) {
            $this->assetModel->where('asset_type', $type);
        }

        if ($status) {
            $this->assetModel->where('status', $status);
        }

        // Order by
        $this->assetModel->orderBy('created_at', 'DESC');

        // ⭐ Pagination
        $assets = $this->assetModel->paginate(10, 'default');

        // ⭐ Statistik - Ambil semua data sekali
        $allAssets = $this->assetModel->findAll();
        
        $totalAssets = count($allAssets);
        $totalHardware = count(array_filter($allAssets, function($asset) {
            return $asset['asset_type'] === 'hardware';
        }));
        $totalSoftware = count(array_filter($allAssets, function($asset) {
            return $asset['asset_type'] === 'software';
        }));

        $data = [
            'title' => 'Kelola Asset',
            'user' => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'assets' => $assets,
            'pager'  => $this->assetModel->pager,

            'keyword' => $keyword,
            'type_filter' => $type,
            'status_filter' => $status,

            // Statistik
            'total_assets'   => $totalAssets,
            'total_hardware' => $totalHardware,
            'total_software' => $totalSoftware,
        ];

        return view('asset/index', $data);
    }

    /**
     * ============================
     * FORM TAMBAH ASSET
     * ============================
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Asset',
            'user' => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
        ];

        return view('asset/create', $data);
    }

    /**
     * ============================
     * SIMPAN ASSET
     * ============================
     */
    public function store()
    {
        $rules = [
            'asset_type' => 'required|in_list[hardware,software]',
            'asset_name' => 'required|min_length[3]|max_length[100]',
            'brand' => 'permit_empty|max_length[50]',
            'serial_number' => 'permit_empty|max_length[100]',
            'purchase_date' => 'permit_empty|valid_date',
            'warranty_end_date' => 'permit_empty|valid_date',
            'location' => 'permit_empty|max_length[100]',
            'status' => 'required|in_list[baik,rusak_ringan,rusak_berat]',
            'specifications' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $assetType = $this->request->getPost('asset_type');
        $assetCode = $this->assetModel->generateAssetCode($assetType);

        $data = [
            'asset_code' => $assetCode,
            'asset_type' => $assetType,
            'asset_name' => $this->request->getPost('asset_name'),
            'brand' => $this->request->getPost('brand'),
            'serial_number' => $this->request->getPost('serial_number'),
            'purchase_date' => $this->request->getPost('purchase_date') ?: null,
            'warranty_end_date' => $this->request->getPost('warranty_end_date') ?: null,
            'location' => $this->request->getPost('location'),
            'status' => $this->request->getPost('status'),
            'specifications' => $this->request->getPost('specifications'),
        ];

        $this->assetModel->insert($data);

        return redirect()->to('/asset')
            ->with('success', 'Asset berhasil ditambahkan dengan kode: ' . $assetCode);
    }

    /**
     * ============================
     * DETAIL ASSET
     * ============================
     */
    public function detail($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/asset')->with('error', 'Asset tidak ditemukan');
        }

        // Get maintenance logs for this asset
        $maintenanceLogModel = new \App\Models\MaintenanceLogModel();
        $maintenanceLogs = $maintenanceLogModel
            ->select('maintenance_logs.*, users.full_name as technician_name, tickets.ticket_number')
            ->join('users', 'users.user_id = maintenance_logs.technician_id', 'left')
            ->join('tickets', 'tickets.ticket_id = maintenance_logs.ticket_id', 'left')
            ->where('maintenance_logs.asset_id', $id)
            ->orderBy('maintenance_logs.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Detail Asset',
            'user' => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'asset' => $asset,
            'maintenance_logs' => $maintenanceLogs,
        ];

        return view('asset/detail', $data);
    }

    /**
     * ============================
     * FORM EDIT
     * ============================
     */
    public function edit($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/asset')->with('error', 'Asset tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Asset',
            'user' => [
                'full_name'  => $this->session->get('full_name'),
                'role'       => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'asset' => $asset,
        ];

        return view('asset/edit', $data);
    }

    /**
     * ============================
     * UPDATE ASSET
     * ============================
     */
    public function update($id)
    {
        if (!$this->assetModel->find($id)) {
            return redirect()->to('/asset')->with('error', 'Asset tidak ditemukan');
        }

        $rules = [
            'asset_name' => 'required|min_length[3]|max_length[100]',
            'brand' => 'permit_empty|max_length[50]',
            'serial_number' => 'permit_empty|max_length[100]',
            'purchase_date' => 'permit_empty|valid_date',
            'warranty_end_date' => 'permit_empty|valid_date',
            'location' => 'permit_empty|max_length[100]',
            'status' => 'required|in_list[baik,rusak_ringan,rusak_berat,retired]',
            'specifications' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'asset_name' => $this->request->getPost('asset_name'),
            'brand' => $this->request->getPost('brand'),
            'serial_number' => $this->request->getPost('serial_number'),
            'purchase_date' => $this->request->getPost('purchase_date') ?: null,
            'warranty_end_date' => $this->request->getPost('warranty_end_date') ?: null,
            'location' => $this->request->getPost('location'),
            'status' => $this->request->getPost('status'),
            'specifications' => $this->request->getPost('specifications'),
        ];

        $this->assetModel->update($id, $data);

        return redirect()->to('/asset/detail/' . $id)
            ->with('success', 'Asset berhasil diperbarui');
    }

    /**
     * ============================
     * HAPUS ASSET
     * ============================
     */
    public function delete($id)
    {
        if (!$this->assetModel->find($id)) {
            return redirect()->to('/asset')->with('error', 'Asset tidak ditemukan');
        }

        // Check if asset has related tickets
        $ticketModel = new \App\Models\TicketModel();
        $hasTickets = $ticketModel->where('asset_id', $id)->countAllResults() > 0;

        if ($hasTickets) {
            return redirect()->to('/asset')
                ->with('error', 'Asset tidak dapat dihapus karena memiliki tiket terkait');
        }

        // Check if asset has maintenance logs
        $maintenanceLogModel = new \App\Models\MaintenanceLogModel();
        $hasLogs = $maintenanceLogModel->where('asset_id', $id)->countAllResults() > 0;

        if ($hasLogs) {
            return redirect()->to('/asset')
                ->with('error', 'Asset tidak dapat dihapus karena memiliki log maintenance terkait');
        }

        $this->assetModel->delete($id);

        return redirect()->to('/asset')->with('success', 'Asset berhasil dihapus');
    }

    /**
     * ============================
     * AJAX GET ASSET
     * ============================
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

    public function export()
    {
        return redirect()->to('/asset')
            ->with('info', 'Fitur export akan segera tersedia');
    }
}