<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use App\Models\TicketModel;
use App\Models\MaintenanceLogModel;
use App\Models\UserModel;

class Report extends BaseController
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
     * Display report generation page
     */
    public function index()
    {
        $data = [
            'title' => 'Generate Laporan',
            'user' => [
                'full_name' => $this->session->get('full_name'),
                'role' => $this->session->get('role'),
                'department' => $this->session->get('department'),
            ],
            // Statistics for preview
            'total_assets' => $this->assetModel->countAll(),
            'total_tickets' => $this->ticketModel->countAll(),
            'total_maintenance' => $this->maintenanceLogModel->countAll(),
            'total_users' => $this->userModel->countAll(),
        ];

        return view('report/index', $data);
    }

    /**
     * Generate Asset Report
     */
    public function assets()
    {
        $format = $this->request->getGet('format') ?: 'pdf';
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');
        
        $builder = $this->assetModel->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        if ($type) {
            $builder->where('asset_type', $type);
        }
        
        $assets = $builder->orderBy('asset_code', 'ASC')->findAll();
        
        if ($format === 'excel') {
            return $this->exportAssetsExcel($assets);
        } else {
            return $this->exportAssetsPDF($assets);
        }
    }

    /**
     * Generate Maintenance Report
     */
    public function maintenance()
    {
        $format = $this->request->getGet('format') ?: 'pdf';
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $technicianId = $this->request->getGet('technician_id');
        
        $builder = $this->maintenanceLogModel->builder();
        $builder->select('maintenance_logs.*, assets.asset_name, assets.asset_code, users.full_name as technician_name')
                ->join('assets', 'assets.asset_id = maintenance_logs.asset_id')
                ->join('users', 'users.user_id = maintenance_logs.technician_id');
        
        if ($startDate && $endDate) {
            $builder->where('DATE(maintenance_logs.created_at) >=', $startDate)
                    ->where('DATE(maintenance_logs.created_at) <=', $endDate);
        }
        
        if ($technicianId) {
            $builder->where('maintenance_logs.technician_id', $technicianId);
        }
        
        $logs = $builder->orderBy('maintenance_logs.created_at', 'DESC')->findAll();
        
        // Calculate summary
        $totalCost = 0;
        $totalDuration = 0;
        foreach ($logs as $log) {
            $totalCost += $log['cost'] ?? 0;
            if ($log['start_time'] && $log['end_time']) {
                $start = strtotime($log['start_time']);
                $end = strtotime($log['end_time']);
                $totalDuration += ($end - $start) / 60; // minutes
            }
        }
        
        $summary = [
            'total_records' => count($logs),
            'total_cost' => $totalCost,
            'total_duration' => $totalDuration,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        
        if ($format === 'excel') {
            return $this->exportMaintenanceExcel($logs, $summary);
        } else {
            return $this->exportMaintenancePDF($logs, $summary);
        }
    }

    /**
     * Generate Ticket Report
     */
    public function tickets()
    {
        $format = $this->request->getGet('format') ?: 'pdf';
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');
        
        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, assets.asset_name, assets.asset_code, users.full_name as reporter_name')
                ->join('assets', 'assets.asset_id = tickets.asset_id')
                ->join('users', 'users.user_id = tickets.reported_by');
        
        if ($startDate && $endDate) {
            $builder->where('DATE(tickets.created_at) >=', $startDate)
                    ->where('DATE(tickets.created_at) <=', $endDate);
        }
        
        if ($status) {
            $builder->where('tickets.status', $status);
        }
        
        if ($priority) {
            $builder->where('tickets.priority', $priority);
        }
        
        $tickets = $builder->orderBy('tickets.created_at', 'DESC')->findAll();
        
        // Calculate summary
        $summary = [
            'total_tickets' => count($tickets),
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 0,
            'high_priority' => 0,
            'medium_priority' => 0,
            'low_priority' => 0,
        ];
        
        foreach ($tickets as $ticket) {
            $summary[$ticket['status']]++;
            $summary[$ticket['priority'] . '_priority']++;
        }
        
        if ($format === 'excel') {
            return $this->exportTicketsExcel($tickets, $summary);
        } else {
            return $this->exportTicketsPDF($tickets, $summary);
        }
    }

    /**
     * Export Assets to PDF
     */
    private function exportAssetsPDF($assets)
    {
        // Load TCPDF library
        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8');
        
        // Set document information
        $pdf->SetCreator('PT BNI - Sistem Maintenance');
        $pdf->SetAuthor('Admin');
        $pdf->SetTitle('Laporan Asset');
        
        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('helvetica', 'B', 16);
        
        // Title
        $pdf->Cell(0, 10, 'LAPORAN ASSET', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'PT Bank Negara Indonesia (Persero) Tbk', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Tanggal: ' . date('d F Y'), 0, 1, 'C');
        $pdf->Ln(5);
        
        // Table header
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetFillColor(255, 127, 0); // Orange
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(30, 7, 'Kode Asset', 1, 0, 'C', 1);
        $pdf->Cell(60, 7, 'Nama Asset', 1, 0, 'C', 1);
        $pdf->Cell(25, 7, 'Tipe', 1, 0, 'C', 1);
        $pdf->Cell(40, 7, 'Brand', 1, 0, 'C', 1);
        $pdf->Cell(50, 7, 'Lokasi', 1, 0, 'C', 1);
        $pdf->Cell(25, 7, 'Status', 1, 1, 'C', 1);
        
        // Table data
        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        
        $fill = false;
        foreach ($assets as $asset) {
            $pdf->SetFillColor(245, 245, 245);
            $pdf->Cell(30, 6, $asset['asset_code'], 1, 0, 'L', $fill);
            $pdf->Cell(60, 6, substr($asset['asset_name'], 0, 35), 1, 0, 'L', $fill);
            $pdf->Cell(25, 6, ucfirst($asset['asset_type']), 1, 0, 'C', $fill);
            $pdf->Cell(40, 6, $asset['brand'] ?: '-', 1, 0, 'L', $fill);
            $pdf->Cell(50, 6, substr($asset['location'] ?: '-', 0, 25), 1, 0, 'L', $fill);
            $pdf->Cell(25, 6, ucwords(str_replace('_', ' ', $asset['status'])), 1, 1, 'C', $fill);
            $fill = !$fill;
        }
        
        // Summary
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, 'Total Asset: ' . count($assets), 0, 1, 'R');
        
        // Output PDF
        $filename = 'Laporan_Asset_' . date('Y-m-d_His') . '.pdf';
        $pdf->Output($filename, 'D');
    }

    /**
     * Export Assets to Excel
     */
    private function exportAssetsExcel($assets)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title
        $sheet->setCellValue('A1', 'LAPORAN ASSET');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        
        $sheet->setCellValue('A2', 'PT Bank Negara Indonesia (Persero) Tbk');
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        
        $sheet->setCellValue('A3', 'Tanggal: ' . date('d F Y'));
        $sheet->mergeCells('A3:G3');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        
        // Header row
        $sheet->setCellValue('A5', 'Kode Asset');
        $sheet->setCellValue('B5', 'Nama Asset');
        $sheet->setCellValue('C5', 'Tipe');
        $sheet->setCellValue('D5', 'Brand');
        $sheet->setCellValue('E5', 'Serial Number');
        $sheet->setCellValue('F5', 'Lokasi');
        $sheet->setCellValue('G5', 'Status');
        
        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FF7F00']],
            'alignment' => ['horizontal' => 'center'],
        ];
        $sheet->getStyle('A5:G5')->applyFromArray($headerStyle);
        
        // Data rows
        $row = 6;
        foreach ($assets as $asset) {
            $sheet->setCellValue('A' . $row, $asset['asset_code']);
            $sheet->setCellValue('B' . $row, $asset['asset_name']);
            $sheet->setCellValue('C' . $row, ucfirst($asset['asset_type']));
            $sheet->setCellValue('D' . $row, $asset['brand'] ?: '-');
            $sheet->setCellValue('E' . $row, $asset['serial_number'] ?: '-');
            $sheet->setCellValue('F' . $row, $asset['location'] ?: '-');
            $sheet->setCellValue('G' . $row, ucwords(str_replace('_', ' ', $asset['status'])));
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Add border
        $sheet->getStyle('A5:G' . ($row - 1))->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']],
            ],
        ]);
        
        // Summary
        $sheet->setCellValue('F' . ($row + 1), 'Total Asset:');
        $sheet->setCellValue('G' . ($row + 1), count($assets));
        $sheet->getStyle('F' . ($row + 1) . ':G' . ($row + 1))->getFont()->setBold(true);
        
        // Save file
        $filename = 'Laporan_Asset_' . date('Y-m-d_His') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Export Maintenance to PDF
     */
    private function exportMaintenancePDF($logs, $summary)
    {
        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8');
        
        $pdf->SetCreator('PT BNI - Sistem Maintenance');
        $pdf->SetTitle('Laporan Maintenance');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        
        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'LAPORAN MAINTENANCE', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'PT Bank Negara Indonesia (Persero) Tbk', 0, 1, 'C');
        
        if ($summary['start_date'] && $summary['end_date']) {
            $pdf->Cell(0, 5, 'Periode: ' . date('d M Y', strtotime($summary['start_date'])) . ' - ' . date('d M Y', strtotime($summary['end_date'])), 0, 1, 'C');
        }
        
        $pdf->Ln(5);
        
        // Summary Box
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(90, 6, 'Total Perbaikan: ' . $summary['total_records'], 1, 0, 'L', 1);
        $pdf->Cell(90, 6, 'Total Biaya: Rp ' . number_format($summary['total_cost'], 0, ',', '.'), 1, 0, 'L', 1);
        $pdf->Cell(90, 6, 'Total Durasi: ' . round($summary['total_duration']) . ' menit', 1, 1, 'L', 1);
        $pdf->Ln(3);
        
        // Table header
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetFillColor(255, 127, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(25, 7, 'Tanggal', 1, 0, 'C', 1);
        $pdf->Cell(40, 7, 'Asset', 1, 0, 'C', 1);
        $pdf->Cell(35, 7, 'Teknisi', 1, 0, 'C', 1);
        $pdf->Cell(65, 7, 'Diagnosis', 1, 0, 'C', 1);
        $pdf->Cell(65, 7, 'Action', 1, 0, 'C', 1);
        $pdf->Cell(25, 7, 'Biaya', 1, 1, 'C', 1);
        
        // Table data
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetTextColor(0, 0, 0);
        
        $fill = false;
        foreach ($logs as $log) {
            $pdf->SetFillColor(245, 245, 245);
            $pdf->Cell(25, 6, date('d/m/Y', strtotime($log['created_at'])), 1, 0, 'C', $fill);
            $pdf->Cell(40, 6, substr($log['asset_name'], 0, 20), 1, 0, 'L', $fill);
            $pdf->Cell(35, 6, substr($log['technician_name'], 0, 18), 1, 0, 'L', $fill);
            $pdf->Cell(65, 6, substr($log['diagnosis'], 0, 40), 1, 0, 'L', $fill);
            $pdf->Cell(65, 6, substr($log['action_taken'], 0, 40), 1, 0, 'L', $fill);
            $pdf->Cell(25, 6, number_format($log['cost'] ?? 0, 0), 1, 1, 'R', $fill);
            $fill = !$fill;
        }
        
        $filename = 'Laporan_Maintenance_' . date('Y-m-d_His') . '.pdf';
        $pdf->Output($filename, 'D');
    }

    /**
     * Export Maintenance to Excel (similar structure)
     */
    private function exportMaintenanceExcel($logs, $summary)
    {
        // Implementation similar to exportAssetsExcel
        // ... (code implementation)
    }

    /**
     * Export Tickets to PDF (similar structure)
     */
    private function exportTicketsPDF($tickets, $summary)
    {
        // Implementation similar to exportMaintenancePDF
        // ... (code implementation)
    }

    /**
     * Export Tickets to Excel (similar structure)
     */
    private function exportTicketsExcel($tickets, $summary)
    {
        // Implementation similar to exportAssetsExcel
        // ... (code implementation)
    }
}