<?php

namespace App\Controllers;

use App\Models\AssetModel; // Sesuaikan dengan nama model aset Anda

class Report extends BaseController
{
    public function index()
    {
        $model = new AssetModel();
        
        // Mengambil data untuk ditampilkan di preview laporan
        $data['assets'] = $model->findAll();
        $data['title']  = "Laporan Inventaris Aset";

        return view('report/index', $data);
    }

    public function exportPdf()
    {
        // Nantinya diisi script Dompdf atau library PDF lainnya
    }
}