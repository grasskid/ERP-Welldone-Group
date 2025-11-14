<?php

namespace App\Controllers;

use App\Models\ModelService;
use App\Models\ModelPelanggan;
use App\Models\ModelUnit;

class DashboardService extends BaseController
{
    protected $ServiceModel;
    protected $PelangganModel;
    protected $UnitModel;

    public function __construct()
    {
        $this->ServiceModel = new ModelService();
        $this->PelangganModel = new ModelPelanggan();
        $this->UnitModel = new ModelUnit();
    }

    public function index()
    {
        // Get filter parameters
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d');
        $unitId = $this->request->getGet('unit_id');

        // Get units for dropdown
        $units = $this->UnitModel->findAll();

        // Build query conditions
        $unitCondition = $unitId ? ['unit_idunit' => $unitId] : [];

        // Total Pendapatan Service (status_service = 4 = selesai)
        $totalPendapatan = $this->ServiceModel
            ->where('DATE(tanggal_selesai) >=', $startDate)
            ->where('DATE(tanggal_selesai) <=', $endDate)
            ->where('status_service', 4)
            ->where($unitCondition)
            ->selectSum('harus_dibayar')
            ->first()->harus_dibayar ?? 0;

        // Total Service Selesai
        $totalServiceSelesai = $this->ServiceModel
            ->where('DATE(tanggal_selesai) >=', $startDate)
            ->where('DATE(tanggal_selesai) <=', $endDate)
            ->where('status_service', 4)
            ->where($unitCondition)
            ->countAllResults(false);

        // Total Service Proses
        $totalServiceProses = $this->ServiceModel
            ->where('DATE(created_at) >=', $startDate)
            ->where('DATE(created_at) <=', $endDate)
            ->where('status_service', '!=', 4)
            ->where('status_service', '!=', 5) // 5 = dibatalkan
            ->where($unitCondition)
            ->countAllResults(false);

        // Total Service Bisa Diambil
        $totalBisaDiambil = $this->ServiceModel
            ->where('DATE(tanggal_bisa_diambil) <=', $endDate)
            ->where('status_service', 4)
            ->where('bayar >=', 'harus_dibayar', false)
            ->where($unitCondition)
            ->countAllResults(false);

        // Rata-rata Service
        $rataService = $totalServiceSelesai > 0 ? ($totalPendapatan / $totalServiceSelesai) : 0;

        // Chart data - pendapatan per hari
        $chartData = $this->ServiceModel
            ->select("DATE(tanggal_selesai) as tanggal, SUM(harus_dibayar) as total")
            ->where('DATE(tanggal_selesai) >=', $startDate)
            ->where('DATE(tanggal_selesai) <=', $endDate)
            ->where('status_service', 4)
            ->where($unitCondition)
            ->groupBy('DATE(tanggal_selesai)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $chartLabels = [];
        $chartValues = [];
        foreach ($chartData as $row) {
            if ($row->tanggal && $row->tanggal != '0000-00-00') {
                $chartLabels[] = date('d M Y', strtotime($row->tanggal));
                $chartValues[] = (float) $row->total;
            }
        }

        // Status Service Chart
        $statusData = $this->ServiceModel
            ->select('status_service, COUNT(*) as jumlah')
            ->where($unitCondition)
            ->groupBy('status_service')
            ->findAll();

        $statusLabels = [];
        $statusCounts = [];
        $statusMap = [
            1 => 'Menunggu',
            2 => 'Proses',
            3 => 'Selesai (Belum Bayar)',
            4 => 'Selesai',
            5 => 'Dibatalkan'
        ];

        foreach ($statusData as $row) {
            $statusLabels[] = $statusMap[$row->status_service] ?? 'Unknown';
            $statusCounts[] = (int) $row->jumlah;
        }

        // Service per Teknisi
        $teknisiData = $this->ServiceModel
            ->select('akun.NAMA_AKUN, COUNT(*) as jumlah')
            ->join('akun', 'akun.ID_AKUN = service.service_by', 'left')
            ->where('DATE(service.tanggal_selesai) >=', $startDate)
            ->where('DATE(service.tanggal_selesai) <=', $endDate)
            ->where('service.status_service', 4)
            ->where($unitCondition)
            ->groupBy('service.service_by')
            ->orderBy('jumlah', 'DESC')
            ->limit(5)
            ->findAll();

        $teknisiLabels = array_map(fn($row) => $row->NAMA_AKUN ?? 'Unknown', $teknisiData);
        $teknisiDataCounts = array_map(fn($row) => (int) ($row->jumlah ?? 0), $teknisiData);

        $data = [
            'title' => 'Dashboard Service',
            'body' => 'dashboard/dashboard_service',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'unit_id' => $unitId,
            'units' => $units,
            'total_pendapatan' => $totalPendapatan,
            'total_service_selesai' => $totalServiceSelesai,
            'total_service_proses' => $totalServiceProses,
            'total_bisa_diambil' => $totalBisaDiambil,
            'rata_service' => $rataService,
            'chart_labels' => $chartLabels,
            'chart_values' => $chartValues,
            'status_labels' => $statusLabels,
            'status_counts' => $statusCounts,
            'teknisi_labels' => $teknisiLabels,
            'teknisi_data' => $teknisiDataCounts,
        ];

        return view('template', $data);
    }
}

