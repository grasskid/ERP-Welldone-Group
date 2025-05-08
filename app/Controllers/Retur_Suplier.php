<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelReturSuplier;
use App\Models\ModelDetailPembelian;

class Retur_Suplier extends BaseController

{
    protected $KategoriModel;
    protected $AuthModel;
    protected $ReturSuplierModel;
    protected $DetailPembelianModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
        $this->ReturSuplierModel = new ModelReturSuplier();
        $this->DetailPembelianModel = new ModelDetailPembelian();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'detail_pembelian' => $this->DetailPembelianModel->getDetailAll(),
            'retur_suplier' => $this->ReturSuplierModel->getReturPembelian(),
            'body'  => 'retur/retur_suplier'
        );
        return view('template', $data);
        // return $this->response->setJSON($data);
    }

    public function insert()
    {
        $no_retur_suplier = $this->request->getPost('no_batch');
        $tanggal = date('Y-m-d');
        $jumlah = $this->request->getPost('jumlah');
        $jumlahval = $this->request->getPost('jumlahval');
        $satuan = $this->request->getPost('satuan');
        $barang_idbarang = $this->request->getPost('barang_idbarang');
        $detail_pembelian_iddetail_pembelian = $this->request->getPost('iddetail_pembelian');
        $input_by = session('ID_AKUN');
        // dd($detail_pembelian_iddetail_pembelian);


        if ($jumlah > $jumlahval) {
            session()->setFlashdata('gagal', 'Jumlah Retur Tidak Boleh Lebih dari Jumlah yang Dibeli');
            return redirect()->to(base_url('/retur_suplier'));
        }
        $data = array(
            'no_retur_suplier' => $no_retur_suplier,
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'barang_idbarang' => $barang_idbarang,
            'detail_pembelian_iddetail_pembelian' => $detail_pembelian_iddetail_pembelian,
            'input_by' => $input_by
        );
        $result = $this->ReturSuplierModel->insert_ReturSuplier($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
            return redirect()->to(base_url('/retur_suplierr'));
        }
    }
    
}