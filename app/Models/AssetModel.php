<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table            = 'assets';
    protected $primaryKey       = 'asset_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'asset_code',
        'asset_type',
        'asset_name',
        'brand',
        'serial_number',
        'purchase_date',
        'warranty_end_date',
        'location',
        'status',
        'specifications'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'asset_code' => 'required|is_unique[assets.asset_code,asset_id,{asset_id}]',
        'asset_type' => 'required|in_list[hardware,software]',
        'asset_name' => 'required|min_length[3]',
        'status'     => 'required|in_list[baik,rusak_ringan,rusak_berat,retired]',
    ];

    protected $validationMessages = [
        'asset_code' => [
            'required'  => 'Kode asset harus diisi',
            'is_unique' => 'Kode asset sudah digunakan',
        ],
        'asset_type' => [
            'required' => 'Tipe asset harus dipilih',
        ],
        'asset_name' => [
            'required'   => 'Nama asset harus diisi',
            'min_length' => 'Nama asset minimal 3 karakter',
        ],
    ];

    /**
     * Generate asset code
     */
    public function generateAssetCode($type = 'hardware')
    {
        $prefix = ($type === 'hardware') ? 'HW' : 'SW';
        $year = date('Y');
        
        // Get last number
        $lastAsset = $this->like('asset_code', $prefix . '-' . $year)
                          ->orderBy('asset_id', 'DESC')
                          ->first();
        
        if ($lastAsset) {
            $lastNumber = (int) substr($lastAsset['asset_code'], -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . '-' . $year . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get all assets with pagination
     */
    public function getAllAssets($perPage = 10)
    {
        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    /**
     * Get assets by type
     */
    public function getAssetsByType($type)
    {
        return $this->where('asset_type', $type)->findAll();
    }

    /**
     * Get assets by status
     */
    public function getAssetsByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }

    /**
     * Search assets
     */
    public function searchAssets($keyword)
    {
        return $this->like('asset_name', $keyword)
                    ->orLike('asset_code', $keyword)
                    ->orLike('brand', $keyword)
                    ->orLike('serial_number', $keyword)
                    ->findAll();
    }

    /**
     * Get asset with full details
     */
    public function getAssetDetail($assetId)
    {
        return $this->find($assetId);
    }

    /**
     * Get assets near warranty expiry
     */
    public function getAssetsNearWarrantyExpiry($days = 30)
    {
        $date = date('Y-m-d', strtotime("+{$days} days"));
        
        return $this->where('warranty_end_date <=', $date)
                    ->where('warranty_end_date >=', date('Y-m-d'))
                    ->where('status !=', 'retired')
                    ->findAll();
    }
}