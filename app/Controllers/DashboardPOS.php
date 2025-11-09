<?php

namespace App\Controllers;

use App\Models\ModelPenjualan;
use App\Models\ModelPelanggan;
use App\Models\ModelKartuStok;
use App\Models\ModelUnit;

class DashboardPOS extends BaseController
{
    protected $PenjualanModel;
    protected $PelangganModel;
    protected $KartuStokModel;
    protected $UnitModel;

    public function __construct()
    {
        $this->PenjualanModel = new ModelPenjualan();
        $this->PelangganModel = new ModelPelanggan();
        $this->KartuStokModel = new ModelKartuStok();
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

        // Total Penjualan
        $totalPenjualan = $this->PenjualanModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->where($unitCondition)
            ->selectSum('total_penjualan')
            ->first()->total_penjualan ?? 0;

        // Total Transaksi
        $totalTransaksi = $this->PenjualanModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->where($unitCondition)
            ->countAllResults(false);

        // Total Pelanggan
        $totalPelanggan = $this->PelangganModel
            ->where('deleted', '0')
            ->countAllResults(false);

        // Rata-rata Transaksi
        $rataTransaksi = $totalTransaksi > 0 ? ($totalPenjualan / $totalTransaksi) : 0;

        // Chart data - penjualan per hari
        $chartData = $this->PenjualanModel
            ->select("DATE(tanggal) as tanggal, SUM(total_penjualan) as total")
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->where($unitCondition)
            ->groupBy('DATE(tanggal)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $chartLabels = [];
        $chartValues = [];
        foreach ($chartData as $row) {
            $chartLabels[] = date('d M Y', strtotime($row->tanggal));
            $chartValues[] = (float) $row->total;
        }

        // Produk Terlaris
        $produkTerlaris = $this->KartuStokModel->getKartuStokTerlaris();
        $produkLabels = array_map(fn($row) => $row->kode_barang ?? 'Unknown', $produkTerlaris);
        $produkData = array_map(fn($row) => (float) ($row->total_penjualan ?? 0), $produkTerlaris);

        // Top Sales
        $topSales = $this->PenjualanModel
            ->select('akun.NAMA_AKUN, SUM(penjualan.total_penjualan) as total')
            ->join('akun', 'akun.ID_AKUN = penjualan.sales_by', 'left')
            ->where('penjualan.tanggal >=', $startDate)
            ->where('penjualan.tanggal <=', $endDate)
            ->where($unitCondition)
            ->groupBy('penjualan.sales_by')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->findAll();

        $salesLabels = array_map(fn($row) => $row->NAMA_AKUN ?? 'Unknown', $topSales);
        $salesData = array_map(fn($row) => (float) ($row->total ?? 0), $topSales);

        $data = [
            'title' => 'Dashboard POS',
            'body' => 'dashboard/dashboard_pos',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'unit_id' => $unitId,
            'units' => $units,
            'total_penjualan' => $totalPenjualan,
            'total_transaksi' => $totalTransaksi,
            'total_pelanggan' => $totalPelanggan,
            'rata_transaksi' => $rataTransaksi,
            'chart_labels' => $chartLabels,
            'chart_values' => $chartValues,
            'produk_labels' => $produkLabels,
            'produk_data' => $produkData,
            'sales_labels' => $salesLabels,
            'sales_data' => $salesData,
        ];

        return view('template', $data);
    }
}

