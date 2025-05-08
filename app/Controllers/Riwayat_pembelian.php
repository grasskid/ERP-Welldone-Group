<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use Config\Database;
use App\Models\ModelAuth;

class Riwayat_pembelian extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {

        $detail_pembelian = $this->DetailPembelianModel->getDetailAll();
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));

        $data = array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'detail_pembelian' => $detail_pembelian,
            'body'  => 'riwayat/pembelian'
        );

        return view('template', $data);
    }
}
