<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table            = 'assets';
    protected $primaryKey       = 'asset_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
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
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

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

    public function filterAssets($keyword = null, $type = null, $status = null)
{
    if ($keyword) {
        $this->groupStart()
             ->like('asset_name', $keyword)
             ->orLike('asset_code', $keyword)
             ->orLike('brand', $keyword)
             ->orLike('serial_number', $keyword)
             ->groupEnd();
    }

    if ($type) {
        $this->where('asset_type', $type);
    }

    if ($status) {
        $this->where('status', $status);
    }

    return $this->orderBy('created_at', 'DESC');
}


    /**
     * Generate asset code
     */
    public function generateAssetCode($type = 'hardware')
    {
        $prefix = ($type === 'hardware') ? 'HW' : 'SW';
        $year   = date('Y');

        $lastAsset = $this->builder()
                          ->like('asset_code', $prefix . '-' . $year)
                          ->orderBy('asset_id', 'DESC')
                          ->get()
                          ->getFirstRow('array');

        $newNumber = $lastAsset
            ? ((int) substr($lastAsset['asset_code'], -3) + 1)
            : 1;

        return $prefix . '-' . $year . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Asset detail
     */
    public function getAssetDetail($assetId)
    {
        return $this->find($assetId);
    }

    /**
     * Assets near warranty expiry
     */
    public function getAssetsNearWarrantyExpiry($days = 30)
    {
        $dateLimit = date('Y-m-d', strtotime("+{$days} days"));

        return $this->builder()
                    ->where('warranty_end_date <=', $dateLimit)
                    ->where('warranty_end_date >=', date('Y-m-d'))
                    ->where('status !=', 'retired')
                    ->orderBy('warranty_end_date', 'ASC')
                    ->get()
                    ->getResultArray();
    }
}
