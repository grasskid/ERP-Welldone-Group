<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelReturCustomer;

class Riwayat_ReturPenjualan extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $AuthModel;
    protected $ReturCustomerModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
        $this->ReturCustomerModel = new ModelReturCustomer();
    }

    public function index()
    {

        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $returpenjualan = $this->ReturCustomerModel->getReturPenjualan();

        $data = array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'retur_penjualan' => $returpenjualan,
            'body'  => 'riwayat/retur_penjualan'
        );

        return view('template', $data);
    }
}
