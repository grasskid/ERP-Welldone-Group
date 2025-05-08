<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use App\Models\ModelDetailPenjualan;
use App\Models\ModelPenjualan;
use Config\Database;
use App\Models\ModelAuth;

class Riwayat_Penjualan extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $DetailPenjualanModel;
    protected $PenjualanModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->DetailPenjualanModel = new ModelDetailPenjualan();
        $this->PenjualanModel = new ModelPenjualan();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data = [
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'detail_penjualan' => $this->DetailPenjualanModel->getDetailPenjualan(),
            'body' => 'riwayat/penjualan'
        ];

        return view('template', $data);
    }
}
    

    // public function index()
    // {
    //     $tanggal_awal = $this->request->getGet('tanggal_awal');
    //     $tanggal_akhir = $this->request->getGet('tanggal_akhir');
    //     $kode_invoice = $this->request->getGet('kode_invoice'); // Get invoice code if present
    
    //     $detail_penjualan = $this->DetailPenjualanModel->getDetailByTanggal($tanggal_awal, $tanggal_akhir);
    
    //     $penjualan = [];
    //     if ($kode_invoice) {
    //         $penjualan = $this->DetailPenjualanModel->getDetailPenjualanByKodeInvoice($kode_invoice);
    //     }
    
    //     $data = [
    //         'penjualan' => $penjualan,
    //         'kategori' => $this->KategoriModel->getKategori(),
    //         'detail_penjualan' => $detail_penjualan,
    //         'body' => 'riwayat/penjualan'
    //     ];
    
    //     return view('template', $data);
    // }
