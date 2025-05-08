<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelReturCustomer;
use App\Models\ModelDetailPenjualan;

class Retur_Customer extends BaseController

{

    protected $KategoriModel;
    protected $AuthModel;
    protected $ReturCustomerModel;
    protected $DetailPenjualanModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
        $this->ReturCustomerModel = new ModelReturCustomer();
        $this->DetailPenjualanModel = new ModelDetailPenjualan();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'retur_pelanggan' => $this->ReturCustomerModel->getReturCustomer(),
            'detail_penjualan' => $this->DetailPenjualanModel->getDetailPenjualan(),
            'body'  => 'retur/retur_customer'
        );
        return view('template', $data);
    }

    public function insert()
    {
        $no_retur_pelanggan = $this->request->getPost('kode_invoice');
        $tanggal = date('Y-m-d');
        $jumlah = $this->request->getPost('jumlah');
        $jumlahval = $this->request->getPost('jumlahval');
        $satuan = $this->request->getPost('satuan');
        $barang_idbarang = $this->request->getPost('barang_idbarang');
        $iddetail_penjualan = $this->request->getPost('iddetail_penjualan');

        if ($jumlah > $jumlahval) {
            session()->setFlashdata('gagal', 'Jumlah Retur Tidak Boleh Lebih dari Jumlah yang Dibeli');
            return redirect()->to(base_url('/retur_customer'));
        }

        $data = array(
            'no_retur_pelanggan' => $no_retur_pelanggan,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'barang_idbarang' => $barang_idbarang,
            'detail_penjualan_iddetail_penjualan' => $iddetail_penjualan,
            'input_by' => session('ID_AKUN')
        );
        $result = $this->ReturCustomerModel->insert_ReturCustomer($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
            return redirect()->to(base_url('/retur_customer'));
        }
    }
}
