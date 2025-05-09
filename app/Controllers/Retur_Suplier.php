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
        $datauser = $this->AuthModel->getById(session('ID_AKUN'));
        $useridunit = $datauser->ID_UNIT;


        $tanggal = date('Y-m-d');
        $input_by = session('ID_AKUN');

        //noretur
        $lastRetur = $this->ReturSuplierModel
            ->where('unit_idunit', $useridunit)
            ->like('tanggal', $tanggal)
            ->orderBy('no_retur_suplier', 'DESC')
            ->first();

        if ($lastRetur) {
            $lastKode = substr($lastRetur['no_retur_suplier'], -3);
            $newKode = str_pad((int)$lastKode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newKode = '001';
        }

        $ymd = date('Ymd');
        $no_retur_suplier = 'RTS' . $useridunit . $ymd . $newKode;
        //noretur

        $items = $this->request->getPost('items');

        foreach ($items as $item) {
            if (isset($item['selected']) && $item['selected'] == '1') {
                $jumlah_retur = (int) $item['jumlah_retur'];
                $jumlah = (int) $item['jumlah'];
                $satuan = $item['satuan'];
                $barang_idbarang = $item['barang_idbarang'];
                $iddetail_pembelian = (int) $item['iddetail_pembelian'];
                $unit_idunit = (int) $item['unit_idunit'];


                if ($jumlah_retur > $jumlah) {
                    session()->setFlashdata('gagal', 'Jumlah Retur Tidak Boleh Lebih dari Jumlah yang Dibeli');
                    return redirect()->to(base_url('/retur_suplier'));
                }

                $data = array(
                    'no_retur_suplier' => $no_retur_suplier,
                    'tanggal' => $tanggal,
                    'jumlah' => $jumlah_retur,
                    'satuan' => $satuan,
                    'barang_idbarang' => $barang_idbarang,
                    'detail_pembelian_iddetail_pembelian' => $iddetail_pembelian,
                    'input_by' => $input_by,
                    'unit_idunit' => $unit_idunit,
                );
                $result = $this->ReturSuplierModel->insert_ReturSuplier($data);
            }
        }
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
            return redirect()->to(base_url('/retur_suplier'));
        }
    }
}
