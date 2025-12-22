<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelReturCustomer;
use App\Models\ModelDetailPenjualan;
use App\Models\ModelJurnal;

class Retur_Customer extends BaseController

{

    protected $KategoriModel;
    protected $AuthModel;
    protected $ReturCustomerModel;
    protected $DetailPenjualanModel;
    protected $JurnalModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
        $this->ReturCustomerModel = new ModelReturCustomer();
        $this->DetailPenjualanModel = new ModelDetailPenjualan();
        $this->JurnalModel = new ModelJurnal();
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
        $tanggal = date('Y-m-d');
        $tanggal_retur =  $this->request->getPost('tanggal_pengembalian');
        $waktu = date('H:i:s');
        $datetime = $tanggal_retur . ' ' . $waktu;
        $datauser = $this->AuthModel->getById(session('ID_AKUN'));
        $useridunit = $datauser->ID_UNIT;

        // Generate no_retur_pelanggan
        $lastRetur = $this->ReturCustomerModel
            ->where('unit_idunit', $useridunit)
            ->like('DATE(tanggal)', $tanggal_retur)
            ->orderBy('no_retur_pelanggan', 'DESC')
            ->first();

        if ($lastRetur) {
            $lastKode = substr($lastRetur->no_retur_pelanggan, -3);
            $newKode = str_pad((int)$lastKode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newKode = '001';
        }

        $ymd = date('Ymd');
        $no_retur_pelanggan = 'RTC' . $useridunit . $ymd . $newKode;

        // Begin processing items
        $items = $this->request->getPost('items');
        $total_harga = 0;
        $total_ppn = 0;

        foreach ($items as $item) {
            if (isset($item['selected']) && $item['selected'] == '1') {
                $jumlah_retur = (int) $item['jumlah_retur'];
                $jumlah = (int) $item['jumlah'];
                $satuan = $item['satuan'];
                $barang_idbarang = $item['barang_idbarang'];
                $iddetail_penjualan = (int) $item['iddetail_penjualan'];
                $unit_idunit = (int) $item['unit_idunit'];

                if ($jumlah_retur > $jumlah) {
                    session()->setFlashdata('gagal', 'Jumlah Retur Tidak Boleh Lebih dari Jumlah yang Dibeli');
                    return redirect()->to(base_url('/retur_customer'));
                }

                // Get harga & ppn from detail_penjualan
                $detail = $this->DetailPenjualanModel->getById($iddetail_penjualan);
                $harga = $detail->harga_penjualan ?? 0;
                $ppn = $detail->ppn ?? 0;

                $sub_total = $jumlah_retur * $harga;
                $ppn_total = $jumlah_retur * $ppn;

                $total_harga += $sub_total;
                $total_ppn += $ppn_total;

                $data = [
                    'no_retur_pelanggan' => $no_retur_pelanggan,
                    'tanggal' => $tanggal_retur,
                    'jumlah' => $jumlah_retur,
                    'satuan' => $satuan,
                    'barang_idbarang' => $barang_idbarang,
                    'detail_penjualan_iddetail_penjualan' => $iddetail_penjualan,
                    'unit_idunit' => $unit_idunit,
                    'input_by' => session('ID_AKUN')
                ];
                $this->ReturCustomerModel->insert_ReturCustomer($data);
            }
        }

        // Insert Jurnal (similar to Penjualan)
        $ar_nilai = [$total_harga, $total_ppn];
        $this->JurnalModel->insertJurnal(
            $tanggal_retur,
            'retur_penjualan',
            $ar_nilai,
            "Retur Penjualan",
            $iddetail_penjualan,
            'retur_pelanggan'
        );

        session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/retur_customer'));
    }
}
