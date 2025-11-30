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

        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-01');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-t');
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

        $applyTanggalFilter = function ($builder, string $column) use ($tanggal_awal, $tanggal_akhir) {
            if ($tanggal_awal && $tanggal_akhir) {
                $builder->where("DATE({$column}) >=", $tanggal_awal)
                    ->where("DATE({$column}) <=", $tanggal_akhir);
            } elseif ($tanggal_awal) {
                $builder->where("DATE({$column}) >=", $tanggal_awal);
            } elseif ($tanggal_akhir) {
                $builder->where("DATE({$column}) <=", $tanggal_akhir);
            }
        };

        // Pendapatan: Penjualan
        $builder_penjualan = $db->table('penjualan');
        $builder_penjualan->selectSum('total_penjualan', 'total');
        $applyTanggalFilter($builder_penjualan, 'penjualan.tanggal');
        if ($id_unit) {
            $builder_penjualan->where('penjualan.unit_idunit', $id_unit);
        }
        $penjualan = $builder_penjualan->get()->getRow();
        $total_penjualan = $penjualan->total ?? 0;

        $penjualan_detail_builder = $db->table('penjualan')
            ->select('penjualan.kode_invoice, penjualan.tanggal, penjualan.total_penjualan, unit.NAMA_UNIT as nama_unit, pelanggan.nama as nama_pelanggan')
            ->join('unit', 'unit.idunit = penjualan.unit_idunit', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left');
        $applyTanggalFilter($penjualan_detail_builder, 'penjualan.tanggal');
        if ($id_unit) {
            $penjualan_detail_builder->where('penjualan.unit_idunit', $id_unit);
        }
        $penjualan_detail = $penjualan_detail_builder
            ->orderBy('penjualan.tanggal', 'DESC')
            ->get()->getResult();

        // Pendapatan: Service
        $builder_service = $db->table('service');
        $builder_service->selectSum('harus_dibayar', 'total')
            ->where('status_service', 4);
        $applyTanggalFilter($builder_service, 'service.created_at');
        if ($id_unit) {
            $builder_service->where('service.unit_idunit', $id_unit);
        }
        $service = $builder_service->get()->getRow();
        $total_service = $service->total ?? 0;

        $service_detail_builder = $db->table('service')
            ->select('service.no_service, service.created_at, service.harus_dibayar, unit.NAMA_UNIT as nama_unit, pelanggan.nama as nama_pelanggan')
            ->join('unit', 'unit.idunit = service.unit_idunit', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan', 'left')
            ->where('service.status_service', 4);
        $applyTanggalFilter($service_detail_builder, 'service.created_at');
        if ($id_unit) {
            $service_detail_builder->where('service.unit_idunit', $id_unit);
        }
        $service_detail = $service_detail_builder
            ->orderBy('service.created_at', 'DESC')
            ->get()->getResult();

        // Pendapatan: Kas Masuk
        $builder_kas_masuk = $db->table('kas_masuk');
        $builder_kas_masuk->selectSum('jumlah', 'total');
        $applyTanggalFilter($builder_kas_masuk, 'kas_masuk.tanggal');
        if ($id_unit) {
            $builder_kas_masuk->where('kas_masuk.idunit', $id_unit);
        }
        $kas_masuk = $builder_kas_masuk->get()->getRow();
        $total_kas_masuk = $kas_masuk->total ?? 0;

        $kas_masuk_detail_builder = $db->table('kas_masuk')
            ->select('kas_masuk.tanggal, kategori_kas.kategori, kas_masuk.deskripsi, kas_masuk.jumlah, unit.NAMA_UNIT as nama_unit')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_masuk.kategori_idkategori', 'left')
            ->join('unit', 'unit.idunit = kas_masuk.idunit', 'left');
        $applyTanggalFilter($kas_masuk_detail_builder, 'kas_masuk.tanggal');
        if ($id_unit) {
            $kas_masuk_detail_builder->where('kas_masuk.idunit', $id_unit);
        }
        $kas_masuk_detail = $kas_masuk_detail_builder
            ->orderBy('kas_masuk.tanggal', 'DESC')
            ->get()->getResult();

        // Biaya: Kas Keluar
        $builder_kas_keluar = $db->table('kas_keluar');
        $builder_kas_keluar->selectSum('jumlah', 'total');
        $applyTanggalFilter($builder_kas_keluar, 'kas_keluar.tanggal');
        if ($id_unit) {
            $builder_kas_keluar->where('kas_keluar.idunit', $id_unit);
        }
        $kas_keluar = $builder_kas_keluar->get()->getRow();
        $total_kas_keluar = $kas_keluar->total ?? 0;

        $kas_keluar_detail_builder = $db->table('kas_keluar')
            ->select('kas_keluar.tanggal, kategori_kas.kategori, kas_keluar.deskripsi, kas_keluar.jumlah, unit.NAMA_UNIT as nama_unit')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_keluar.kategori_idkategori', 'left')
            ->join('unit', 'unit.idunit = kas_keluar.idunit', 'left');
        $applyTanggalFilter($kas_keluar_detail_builder, 'kas_keluar.tanggal');
        if ($id_unit) {
            $kas_keluar_detail_builder->where('kas_keluar.idunit', $id_unit);
        }
        $kas_keluar_detail = $kas_keluar_detail_builder
            ->orderBy('kas_keluar.tanggal', 'DESC')
            ->get()->getResult();

        // Biaya: HPP Penjualan
        $builder_hpp = $db->table('detail_penjualan');
        $builder_hpp->select('SUM(detail_penjualan.hpp_penjualan * detail_penjualan.jumlah) as total', false)
            ->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan');
        $applyTanggalFilter($builder_hpp, 'penjualan.tanggal');
        if ($id_unit) {
            $builder_hpp->where('penjualan.unit_idunit', $id_unit);
        }
        $hpp = $builder_hpp->get()->getRow();
        $total_hpp = $hpp->total ?? 0;

        $hpp_detail_builder = $db->table('detail_penjualan')
            ->select('penjualan.kode_invoice, penjualan.tanggal, barang.nama_barang, detail_penjualan.jumlah, detail_penjualan.hpp_penjualan, (detail_penjualan.hpp_penjualan * detail_penjualan.jumlah) as total_hpp, unit.NAMA_UNIT as nama_unit')
            ->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan')
            ->join('barang', 'barang.idbarang = detail_penjualan.barang_idbarang', 'left')
            ->join('unit', 'unit.idunit = detail_penjualan.unit_idunit', 'left');
        $applyTanggalFilter($hpp_detail_builder, 'penjualan.tanggal');
        if ($id_unit) {
            $hpp_detail_builder->where('penjualan.unit_idunit', $id_unit);
        }
        $hpp_detail = $hpp_detail_builder
            ->orderBy('penjualan.tanggal', 'DESC')
            ->get()->getResult();

        // Biaya: HPP Service
        $builder_hpp_service = $db->table('service_sparepart');
        $builder_hpp_service->select('SUM(service_sparepart.hpp_penjualan * service_sparepart.jumlah) as total', false)
            ->join('service', 'service.idservice = service_sparepart.service_idservice')
            ->where('service.status_service', 4);
        $applyTanggalFilter($builder_hpp_service, 'service.created_at');
        if ($id_unit) {
            $builder_hpp_service->where('service.unit_idunit', $id_unit);
        }
        $hpp_service = $builder_hpp_service->get()->getRow();
        $total_hpp_service = $hpp_service->total ?? 0;

        $hpp_service_detail_builder = $db->table('service_sparepart')
            ->select('service.no_service, service.created_at, barang.nama_barang, service_sparepart.jumlah, service_sparepart.hpp_penjualan, (service_sparepart.hpp_penjualan * service_sparepart.jumlah) as total_hpp, unit.NAMA_UNIT as nama_unit')
            ->join('service', 'service.idservice = service_sparepart.service_idservice')
            ->join('barang', 'barang.idbarang = service_sparepart.barang_idbarang', 'left')
            ->join('unit', 'unit.idunit = service_sparepart.unit_idunit', 'left')
            ->where('service.status_service', 4);
        $applyTanggalFilter($hpp_service_detail_builder, 'service.created_at');
        if ($id_unit) {
            $hpp_service_detail_builder->where('service.unit_idunit', $id_unit);
        }
        $hpp_service_detail = $hpp_service_detail_builder
            ->orderBy('service.created_at', 'DESC')
            ->get()->getResult();

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
            'detail' => [
                'pendapatan' => [
                    'penjualan' => $penjualan_detail,
                    'service' => $service_detail,
                    'kas_masuk' => $kas_masuk_detail,
                ],
                'biaya' => [
                    'kas_keluar' => $kas_keluar_detail,
                    'hpp_penjualan' => $hpp_detail,
                    'hpp_service' => $hpp_service_detail,
                ],
            ],
            'laba_rugi' => $laba_rugi
        ];
    }

    public function laporan_standar()
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
            'body' => 'laporan/laba_rugi_standar'
        ];

        return view('template', $data);
    }

    public function cetak_standar()
    {
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?: null;
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?: null;
        $id_unit = $this->request->getGet('id_unit') ?: null;

        $data_laba_rugi = [];
        
        $data_laba_rugi = $this->JurnalModel->getLabaRugiFromJurnal($tanggal_awal, $tanggal_akhir, $id_unit);
        

        $nama_unit = "Semua Cabang";
        if ($id_unit) {
            $unit = $this->UnitModel->find($id_unit);
            $nama_unit = $unit ? $unit->NAMA_UNIT : "Semua Cabang";
        }

        $data = [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'nama_unit' => $nama_unit,
            'data_laba_rugi' => $data_laba_rugi,
        ];
        // die(json_encode($data));
        return view('laporan/cetak_laba_rugi_standar', $data);
    }
}


