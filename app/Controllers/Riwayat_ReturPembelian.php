<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelReturSuplier;

class Riwayat_ReturPembelian extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $AuthModel;
    protected $ReturSuplierModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
        $this->ReturSuplierModel = new ModelReturSuplier();
    }

    public function index()
    {

        $detail_pembelian = $this->DetailPembelianModel->getDetailAll();
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $returpembelian = $this->ReturSuplierModel->getReturPembelian();

        $data = array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'detail_pembelian' => $detail_pembelian,
            'returpembelian' => $returpembelian,
            'body'  => 'riwayat/retur_pembelian'
        );

        // dd($data['returpembelian']);
        return view('template', $data);
    }
}
