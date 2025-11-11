<?php

namespace App\Controllers;

use App\Models\ModelJurnal;
use App\Models\ModelKasMasuk;
use App\Models\ModelKasKeluar;
use App\Models\ModelPembayaranHutang;
use App\Models\ModelPiutang;
use App\Models\ModelUnit;
use Config\Database;

class DashboardKeuangan extends BaseController
{
    protected $JurnalModel;
    protected $KasMasukModel;
    protected $KasKeluarModel;
    protected $HutangModel;
    protected $PiutangModel;
    protected $UnitModel;
    protected $db;

    public function __construct()
    {
        $this->JurnalModel = new ModelJurnal();
        $this->KasMasukModel = new ModelKasMasuk();
        $this->KasKeluarModel = new ModelKasKeluar();
        $this->HutangModel = new ModelPembayaranHutang();
        $this->PiutangModel = new ModelPiutang();
        $this->UnitModel = new ModelUnit();
        $this->db = Database::connect();
    }

    public function index()
    {
        // Get filter parameters
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d');
        $unitId = $this->request->getGet('unit_id');

        // Get units for dropdown
        $units = $this->UnitModel->findAll();

        // Build query conditions for unit
        $unitCondition = [];
        if ($unitId) {
            $unitCondition = ['id_unit' => $unitId];
        }

        // Total Kas Masuk
        $totalKasMasuk = $this->KasMasukModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate);
        
        if ($unitId) {
            $totalKasMasuk->where('idunit', $unitId);
        }
        
        $totalKasMasuk = $totalKasMasuk->selectSum('jumlah')
            ->first()->jumlah ?? 0;

        // Total Kas Keluar
        $totalKasKeluar = $this->KasKeluarModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate);
        
        if ($unitId) {
            $totalKasKeluar->where('idunit', $unitId);
        }
        
        $totalKasKeluar = $totalKasKeluar->selectSum('jumlah')
            ->first()->jumlah ?? 0;

        // Saldo Kas
        $saldoKas = $totalKasMasuk - $totalKasKeluar;

        // Total Debet
        $totalDebet = $this->JurnalModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->where($unitCondition)
            ->selectSum('debet')
            ->first()->debet ?? 0;

        // Total Kredit
        $totalKredit = $this->JurnalModel
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->where($unitCondition)
            ->selectSum('kredit')
            ->first()->kredit ?? 0;

        // Total Hutang (sisa hutang dari pembelian)
        $hutangQuery = $this->db->table('pembelian')
            ->selectSum('sisa');

        if ($unitId) {
            $hutangQuery->where('unit_idunit', $unitId);
        }
        $totalHutang = $hutangQuery->get()->getRow()->sisa ?? 0;

        // Total Piutang (sisa hutang dari piutang)
        $piutangQuery = $this->db->table('piutang')
            ->selectSum('sisa_hutang')
            ->where('status', 1); // 1 = aktif
        
        if ($unitId) {
            $piutangQuery->where('unit_idunit', $unitId);
        }
        
        $totalPiutang = $piutangQuery->get()->getRow()->sisa_hutang ?? 0;

        // Chart data - Kas Masuk/Keluar per hari
        $kasMasukData = $this->KasMasukModel
            ->select("DATE(tanggal) as tanggal, SUM(jumlah) as total")
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate);
        
        if ($unitId) {
            $kasMasukData->where('idunit', $unitId);
        }
        
        $kasMasukData = $kasMasukData->groupBy('DATE(tanggal)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $kasKeluarData = $this->KasKeluarModel
            ->select("DATE(tanggal) as tanggal, SUM(jumlah) as total")
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate);
        
        if ($unitId) {
            $kasKeluarData->where('idunit', $unitId);
        }
        
        $kasKeluarData = $kasKeluarData->groupBy('DATE(tanggal)')
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        // Merge dates for chart
        $allDates = [];
        foreach ($kasMasukData as $row) {
            $allDates[$row->tanggal] = ['masuk' => (float) $row->total, 'keluar' => 0];
        }
        foreach ($kasKeluarData as $row) {
            if (isset($allDates[$row->tanggal])) {
                $allDates[$row->tanggal]['keluar'] = (float) $row->total;
            } else {
                $allDates[$row->tanggal] = ['masuk' => 0, 'keluar' => (float) $row->total];
            }
        }
        ksort($allDates);

        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];
        foreach ($allDates as $date => $values) {
            $chartLabels[] = date('d M Y', strtotime($date));
            $chartMasuk[] = $values['masuk'];
            $chartKeluar[] = $values['keluar'];
        }

        // Kategori Kas Masuk
        $kategoriMasuk = $this->KasMasukModel
            ->select('kategori_kas.kategori, SUM(kas_masuk.jumlah) as total')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_masuk.kategori_idkategori')
            ->where('kas_masuk.tanggal >=', $startDate)
            ->where('kas_masuk.tanggal <=', $endDate);
        
        if ($unitId) {
            $kategoriMasuk->where('kas_masuk.idunit', $unitId);
        }
        
        $kategoriMasuk = $kategoriMasuk->groupBy('kategori_kas.kategori')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->findAll();

        $kategoriMasukLabels = array_map(fn($row) => $row->kategori ?? 'Unknown', $kategoriMasuk);
        $kategoriMasukData = array_map(fn($row) => (float) ($row->total ?? 0), $kategoriMasuk);

        // Laba Rugi berdasarkan Jurnal
        $labaRugiJurnal = $this->JurnalModel->getLabaRugiFromJurnal($startDate, $endDate, $unitId);

        // Laba Rugi berdasarkan Transaksi
        $labaRugiTransaksi = $this->getLabaRugiFromTransaksi($startDate, $endDate, $unitId);

        $data = [
            'title' => 'Dashboard Keuangan',
            'body' => 'dashboard/dashboard_keuangan',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'unit_id' => $unitId,
            'units' => $units,
            'total_kas_masuk' => $totalKasMasuk,
            'total_kas_keluar' => $totalKasKeluar,
            'saldo_kas' => $saldoKas,
            'total_debet' => $totalDebet,
            'total_kredit' => $totalKredit,
            'total_hutang' => $totalHutang ?? 0,
            'total_piutang' => $totalPiutang ?? 0,
            'chart_labels' => $chartLabels,
            'chart_masuk' => $chartMasuk,
            'chart_keluar' => $chartKeluar,
            'kategori_masuk_labels' => $kategoriMasukLabels,
            'kategori_masuk_data' => $kategoriMasukData,
            'laba_rugi_jurnal' => $labaRugiJurnal,
            'laba_rugi_transaksi' => $labaRugiTransaksi,
        ];

        return view('template', $data);
    }

    /**
     * Mendapatkan data laba rugi dari transaksi (POS, Service, Kas Masuk, Kas Keluar)
     */
    private function getLabaRugiFromTransaksi($tanggal_awal = null, $tanggal_akhir = null, $id_unit = null)
    {
        // 1. Pendapatan dari Penjualan (POS)
        $builder_penjualan = $this->db->table('penjualan');
        $builder_penjualan->selectSum('total_penjualan', 'total');
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_penjualan->where('DATE(tanggal) >=', $tanggal_awal)
                ->where('DATE(tanggal) <=', $tanggal_akhir);
        }
        if ($id_unit) {
            $builder_penjualan->where('unit_idunit', $id_unit);
        }
        $penjualan = $builder_penjualan->get()->getRow();
        $total_penjualan = $penjualan->total ?? 0;

        // 2. Pendapatan dari Service
        $builder_service = $this->db->table('service');
        $builder_service->selectSum('harus_dibayar', 'total');
        $builder_service->where('status_service', 4); // hanya service yang sudah selesai
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_service->where('DATE(created_at) >=', $tanggal_awal)
                ->where('DATE(created_at) <=', $tanggal_akhir);
        }
        if ($id_unit) {
            $builder_service->where('unit_idunit', $id_unit);
        }
        $service = $builder_service->get()->getRow();
        $total_service = $service->total ?? 0;

        // 3. Pendapatan dari Kas Masuk (yang jenisnya pendapatan)
        $builder_kas_masuk = $this->db->table('kas_masuk');
        $builder_kas_masuk->selectSum('jumlah', 'total');
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_kas_masuk->where('tanggal >=', $tanggal_awal)
                ->where('tanggal <=', $tanggal_akhir);
        }
        if ($id_unit) {
            $builder_kas_masuk->where('idunit', $id_unit);
        }
        $kas_masuk = $builder_kas_masuk->get()->getRow();
        $total_kas_masuk = $kas_masuk->total ?? 0;

        // 4. Biaya dari Kas Keluar
        $builder_kas_keluar = $this->db->table('kas_keluar');
        $builder_kas_keluar->selectSum('jumlah', 'total');
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_kas_keluar->where('tanggal >=', $tanggal_awal)
                ->where('tanggal <=', $tanggal_akhir);
        }
        if ($id_unit) {
            $builder_kas_keluar->where('idunit', $id_unit);
        }
        $kas_keluar = $builder_kas_keluar->get()->getRow();
        $total_kas_keluar = $kas_keluar->total ?? 0;

        // 5. HPP Penjualan (dari detail penjualan) - HPP dikalikan dengan jumlah
        $builder_hpp = $this->db->table('detail_penjualan');
        $builder_hpp->select('SUM(hpp_penjualan * jumlah) as total', false);
        $builder_hpp->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan');
        
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_hpp->where('DATE(penjualan.tanggal) >=', $tanggal_awal)
                ->where('DATE(penjualan.tanggal) <=', $tanggal_akhir);
        }
        
        if ($id_unit) {
            $builder_hpp->where('penjualan.unit_idunit', $id_unit);
        }
        
        $hpp = $builder_hpp->get()->getRow();
        $total_hpp = $hpp->total ?? 0;

        // 6. HPP Service (dari service_sparepart) - HPP dikalikan dengan jumlah
        $builder_hpp_service = $this->db->table('service_sparepart');
        $builder_hpp_service->select('SUM(hpp_penjualan * jumlah) as total', false);
        $builder_hpp_service->join('service', 'service.idservice = service_sparepart.service_idservice');
        $builder_hpp_service->where('service.status_service', 4); // hanya service yang sudah selesai
        
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_hpp_service->where('DATE(service.created_at) >=', $tanggal_awal)
                ->where('DATE(service.created_at) <=', $tanggal_akhir);
        }
        
        if ($id_unit) {
            $builder_hpp_service->where('service.unit_idunit', $id_unit);
        }
        
        $hpp_service = $builder_hpp_service->get()->getRow();
        $total_hpp_service = $hpp_service->total ?? 0;

        // Hitung total pendapatan dan biaya
        $total_pendapatan = $total_penjualan + $total_service + $total_kas_masuk;
        $total_biaya = $total_kas_keluar + $total_hpp + $total_hpp_service;
        $laba_rugi = $total_pendapatan - $total_biaya;

        return [
            'pendapatan' => [
                'penjualan' => $total_penjualan,
                'service' => $total_service,
                'kas_masuk' => $total_kas_masuk,
                'total' => $total_pendapatan
            ],
            'biaya' => [
                'kas_keluar' => $total_kas_keluar,
                'hpp_penjualan' => $total_hpp,
                'hpp_service' => $total_hpp_service,
                'total' => $total_biaya
            ],
            'laba_rugi' => $laba_rugi
        ];
    }
}

