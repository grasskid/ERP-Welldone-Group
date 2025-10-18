<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelStokAwal;
use App\Models\ModelBarang;
use App\Models\ModelPelanggan;
use App\Models\ModelSuplier;
use App\Models\ModelAuth;
use App\Models\ModelUnit;
use Config\Database;

class StokAwal extends BaseController

{

    protected $KategoriModel;
    protected $StokAwalModel;
    protected $BarangModel;

    protected $UnitModel;
    protected $SuplierModel;
    protected $PelangganModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->StokAwalModel = new ModelStokAwal();
        $this->BarangModel = new ModelBarang();
        $this->UnitModel = new ModelUnit();
        $this->SuplierModel = new ModelSuplier();
        $this->PelangganModel = new ModelPelanggan();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));


        $allBarang = $this->BarangModel->getAllBarang();
        $stok = $this->StokAwalModel->getAllStok();


        $barangSudahAda = [];
        foreach ($stok as $stockItem) {
            $barangSudahAda[$stockItem->unit_idunit][] = $stockItem->barang_idbarang;
        }


        $barangTersedia = $allBarang;

        $unitData = $this->UnitModel->getUnit();
        

        $data = array(
            'akun' => $akun,
            'stok' => $stok,
            'barang' => $barangTersedia,
            'unit' => $unitData,
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'suplier' => $this->SuplierModel->getSuplier(),
            'body' => 'stok/stok_awal'
        );
        // die(json_encode($data));
        return view('template', $data);
    }


    public function insert()
    {
        $selectedProducts = $this->request->getPost('selected_products');
        $idUnit = $this->request->getPost("global_unit") ?? '';

        if ($selectedProducts) {
            foreach ($selectedProducts as $kodeBarang) {
                $jumlah = $this->request->getPost("jumlah")[$kodeBarang] ?? 0;

                //hidden sementara 
                // $hargaBeli = $this->request->getPost("harga_beli")[$kodeBarang] ?? 0;
                //hidden sementara

                $satuanTerkecil = $this->request->getPost("satuan_terkecil")[$kodeBarang] ?? '';
                $tipeRelasi = $this->request->getPost("tipe_relasi")[$kodeBarang] ?? '';
                $idSuplier = $this->request->getPost("id_suplier_text")[$kodeBarang] ?? 0;
                $idPelanggan = $this->request->getPost("id_pelanggan_text")[$kodeBarang] ?? 0;
                $databarang = $this->BarangModel->getBykode($kodeBarang);
                $idbarang = $databarang->idbarang;

                //sementara
                $hargaBeli = $databarang->harga_beli;

                $data = [
                    'tanggal' => date('Y-m-d'),
                    'jumlah' => $jumlah,
                    'barang_idbarang' => $idbarang,
                    'harga_beli' => $hargaBeli,
                    'satuan_terkecil' => $satuanTerkecil,
                    'unit_idunit' => $idUnit,
                    'suplier_id_suplier' => ($tipeRelasi === 'suplier') ? $idSuplier : 0,
                    'pelanggan_id_pelanggan' => ($tipeRelasi === 'pelanggan') ? $idPelanggan : 0
                ];


                $this->StokAwalModel->insert_Stok($data);
            }

            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/stok_awal'));
        } else {
            session()->setFlashdata('error', 'Tidak ada produk yang dipilih');
            return redirect()->to(base_url('/stok_awal'));
        }
    }
}
