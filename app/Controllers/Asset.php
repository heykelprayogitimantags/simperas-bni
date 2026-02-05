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
     * Display asset list
     */
   public function index()
{
    $keyword = $this->request->getGet('keyword');
    $type    = $this->request->getGet('type');
    $status  = $this->request->getGet('status');

    $assets = $this->assetModel
                   ->filterAssets($keyword, $type, $status)
                   ->paginate(10);

    $data = [
        'title' => 'Kelola Asset',
        'user' => [
            'full_name' => $this->session->get('full_name'),
            'role' => $this->session->get('role'),
            'department' => $this->session->get('department'),
        ],

        'assets' => $assets,
        'pager'  => $this->assetModel->pager,

        'keyword' => $keyword,
        'type_filter' => $type,
        'status_filter' => $status,

        // statistics (AMAN karena query baru)
        'total_assets'   => $this->assetModel->countAll(),
        'total_hardware' => $this->assetModel->where('asset_type', 'hardware')->countAllResults(),
        'total_software' => $this->assetModel->where('asset_type', 'software')->countAllResults(),
    ];

    return view('asset/index', $data);
}



    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Asset',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
        ];

        return view('asset/create', $data);
    }

    /**
     * Store new asset
     */
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'asset_type' => 'required|in_list[hardware,software]',
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
                           ->with('errors', $validation->getErrors());
        }

        // Generate asset code
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

        if ($this->assetModel->insert($data)) {
            return redirect()->to('/asset')
                           ->with('success', 'Asset berhasil ditambahkan dengan kode: ' . $assetCode);
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan asset');
        }
    }

    /**
     * Show asset detail
     */
    public function detail($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/asset')
                           ->with('error', 'Asset tidak ditemukan');
        }

        // Get maintenance history for this asset
        $maintenanceLogModel = new \App\Models\MaintenanceLogModel();
        $maintenanceLogs = $maintenanceLogModel->getLogsByAsset($id);

        $data = [
            'title' => 'Detail Asset',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'asset' => $asset,
            'maintenance_logs' => $maintenanceLogs,
        ];

        return view('asset/detail', $data);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/asset')
                           ->with('error', 'Asset tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Asset',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            'asset' => $asset,
        ];

        return view('asset/edit', $data);
    }

    /**
     * Update asset
     */
    public function update($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/asset')
                           ->with('error', 'Asset tidak ditemukan');
        }

        $validation = \Config\Services::validation();

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
                           ->with('errors', $validation->getErrors());
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

        if ($this->assetModel->update($id, $data)) {
            return redirect()->to('/asset/detail/' . $id)
                           ->with('success', 'Asset berhasil diperbarui');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui asset');
        }
    }

    /**
     * Delete asset
     */
    public function delete($id)
    {
        $asset = $this->assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/asset')
                           ->with('error', 'Asset tidak ditemukan');
        }

        // Check if asset has related tickets
        $ticketModel = new \App\Models\TicketModel();
        $hasTickets = $ticketModel->where('asset_id', $id)->countAllResults() > 0;

        if ($hasTickets) {
            return redirect()->to('/asset')
                           ->with('error', 'Asset tidak dapat dihapus karena memiliki tiket terkait. Gunakan status "Retired" sebagai gantinya.');
        }

        if ($this->assetModel->delete($id)) {
            return redirect()->to('/asset')
                           ->with('success', 'Asset berhasil dihapus');
        } else {
            return redirect()->to('/asset')
                           ->with('error', 'Gagal menghapus asset');
        }
    }

    /**
     * Get asset data (AJAX)
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

    /**
     * Export to Excel (akan dibuat nanti)
     */
    public function export()
    {
        // TODO: Implement export functionality
        return redirect()->to('/asset')
                       ->with('info', 'Fitur export akan segera tersedia');
    }
}