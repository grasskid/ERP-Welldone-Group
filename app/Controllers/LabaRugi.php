<?php

namespace App\Controllers;

use App\Models\ModelAuth;
use App\Models\ModelUnit;
use App\Models\ModelJurnal;
use App\Models\ModelPenjualan;
use App\Models\ModelService;
use App\Models\ModelKasMasuk;
use App\Models\ModelKasKeluar;

class LabaRugi extends BaseController
{
    protected $AuthModel;
    protected $UnitModel;
    protected $JurnalModel;
    protected $PenjualanModel;
    protected $ServiceModel;
    protected $KasMasukModel;
    protected $KasKeluarModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->UnitModel = new ModelUnit();
        $this->JurnalModel = new ModelJurnal();
        $this->PenjualanModel = new ModelPenjualan();
        $this->ServiceModel = new ModelService();
        $this->KasMasukModel = new ModelKasMasuk();
        $this->KasKeluarModel = new ModelKasKeluar();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $unit = $this->UnitModel->getUnit();

        $tanggal_awal = $this->request->getGet('tanggal_awal') ?: null;
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?: null;
        $id_unit = $this->request->getGet('id_unit') ?: null;
        $jenis_laporan = $this->request->getGet('jenis_laporan') ?: 'jurnal'; // 'jurnal' atau 'transaksi'

        // Data untuk laporan berdasarkan jurnal
        $data_jurnal = [];
        if ($jenis_laporan == 'jurnal') {
            $data_jurnal = $this->JurnalModel->getLabaRugiFromJurnal($tanggal_awal, $tanggal_akhir, $id_unit);
        }

        // Data untuk laporan berdasarkan transaksi
        $data_transaksi = [];
        if ($jenis_laporan == 'transaksi') {
            $data_transaksi = $this->getLabaRugiFromTransaksi($tanggal_awal, $tanggal_akhir, $id_unit);
        }

        $data = [
            'akun' => $akun,
            'unit' => $unit,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_unit' => $id_unit,
            'jenis_laporan' => $jenis_laporan,
            'data_jurnal' => $data_jurnal,
            'data_transaksi' => $data_transaksi,
            'body' => 'laporan/laba_rugi'
        ];

        return view('template', $data);
    }

    /**
     * Mendapatkan data laba rugi dari transaksi (POS, Service, Kas Masuk, Kas Keluar)
     */
    private function getLabaRugiFromTransaksi($tanggal_awal = null, $tanggal_akhir = null, $id_unit = null)
    {
        $db = \Config\Database::connect();

        // 1. Pendapatan dari Penjualan (POS)
        $builder_penjualan = $db->table('penjualan');
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
        $builder_service = $db->table('service');
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
        // Asumsikan kas masuk dengan kategori tertentu adalah pendapatan
        $builder_kas_masuk = $db->table('kas_masuk');
        $builder_kas_masuk->selectSum('jumlah', 'total');
        if ($tanggal_awal && $tanggal_akhir) {
            $builder_kas_masuk->where('tanggal >=', $tanggal_awal)
                ->where('tanggal <=', $tanggal_akhir);
        }
        if ($id_unit) {
            $builder_kas_masuk->where('idunit', $id_unit);
        }
        // Filter berdasarkan jenis akun atau kategori (disesuaikan dengan kebutuhan)
        // Untuk sementara, kita ambil semua kas masuk sebagai pendapatan tambahan
        $kas_masuk = $builder_kas_masuk->get()->getRow();
        $total_kas_masuk = $kas_masuk->total ?? 0;

        // 4. Biaya dari Kas Keluar
        $builder_kas_keluar = $db->table('kas_keluar');
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
        $builder_hpp = $db->table('detail_penjualan');
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
        $builder_hpp_service = $db->table('service_sparepart');
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

