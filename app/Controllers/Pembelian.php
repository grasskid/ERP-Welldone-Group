<?php

namespace App\Controllers;

use App\Models\ModelBarang;

use App\Models\ModelKategori;
use App\Models\ModelPembelian;
use App\Models\ModelStokAwal;
use App\Models\ModelDetailPembelian;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelSuplier;
use App\Models\ModelAuth;
use App\Models\ModelPelanggan;
use App\Models\ModelHppBarang;

class Pembelian extends BaseController

{

    protected $BarangModel;
    protected $KategoriModel;
    protected $SuplierModel;
    protected $PembelianModel;
    protected $StokAwalModel;
    protected $DetailPembelianModel;
    protected $AuthModel;
    protected $PelangganModel;
    protected $HppBarangModel;
    public function __construct()
    {
        $this->BarangModel = new ModelBarang();
        $this->KategoriModel = new ModelKategori();
        $this->SuplierModel = new ModelSuplier();
        $this->PembelianModel = new ModelPembelian();
        $this->StokAwalModel = new ModelStokAwal();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
        $this->PelangganModel = new ModelPelanggan();
        $this->HppBarangModel = new ModelHppBarang();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'produk' => $this->BarangModel->getAllBarang(),
            'kategori' => $this->KategoriModel->getKategori(),
            'suplier' => $this->SuplierModel->getSuplier(),
            'body'  => 'transaksi/pembelian'
        );
        return view('template', $data);
    }

    function cleanRupiah($value)
    {

        $value = str_replace(['Rp', '.', ' '], '', $value);
        return (int) $value;
    }

    public function insert()
    {
        $produkData = $this->request->getPost('produk');

        date_default_timezone_set('Asia/Jakarta');

        $datauser = $this->AuthModel->getById(session('ID_AKUN'));
        $useridunit = $datauser->ID_UNIT;
        $namauser = $datauser->NAMA_AKUN;



        $suplier = $this->request->getPost('suplier');
        $id_suplier_text = $this->request->getPost('id_suplier_text');
        $id_pelanggan = $this->request->getPost('id_pelanggan');




        $nota_file = $this->request->getFile('nota_file');


        $tanggal_masuk = $this->request->getPost('tanggal_masuk');
        $jam_sekarang = date('H:i:s');
        $tanggal_masuk_full = $tanggal_masuk . ' ' . $jam_sekarang;




        $jatuh_tempot = $this->request->getPost('jatuh_tempo');
        $sisa = $this->cleanRupiah($this->request->getPost('hutang'));
        $total_harga = $this->cleanRupiah($this->request->getPost('total-harga'));
        $total_diskon = $this->cleanRupiah($this->request->getPost('total-diskon'));
        $total_ppn = $this->cleanRupiah($this->request->getPost('total-ppn'));
        $total_bayar = $this->cleanRupiah($this->request->getPost('bayar'));

        // dd($id_suplier_text);

        //invoice otomatis
        $ymd = date('Ymd');
        $tgl_hari_ini = date('Y-m-d');
        $jumlahHariIni = $this->PembelianModel
            ->where('tanggal_masuk', $tgl_hari_ini)
            ->where('unit_idunit', $useridunit)
            ->countAllResults();
        $urutan = str_pad($jumlahHariIni + 1, 4, '0', STR_PAD_LEFT);
        $no_nota = 'PCR' . $useridunit . $ymd . $urutan;;
        //end invoice otomatis


        $status = '';
        if ($sisa == 0) {
            $status = 'Lunas';
        } else {
            $status = 'Belum Lunas';
        }

        $foto_nota_name = null;
        if ($nota_file && $nota_file->isValid() && !$nota_file->hasMoved()) {
            $foto_nota_name = $nota_file->getRandomName();
            $nota_file->move(ROOTPATH . 'public/foto_nota', $foto_nota_name);
        }
        $input_by = session('ID_AKUN');


        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $nik = $this->request->getPost('nik');
        $nomor = $this->request->getPost('nomor');

        $resultp = true;
        if (empty($id_pelanggan)) {
            // Pastikan ada data yang diinput sebelum insert
            if (!empty($nama) || !empty($alamat) || !empty($nik) || !empty($nomor)) {

                $datapelanggan = $this->PelangganModel->getByNomor($nomor);

                if (empty($datapelanggan)) {

                    $datap = array(
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nik' => $nik,
                        'no_hp' => $nomor,
                        'deleted' => 0
                    );
                    $resultp = $this->PelangganModel->insert_Pelanggan($datap);
                    $id_pelanggan = $this->PelangganModel->insertID();
                } else {

                    $id_pelanggan = $datapelanggan->id_pelanggan;
                }
            }
        }




        $data = array(
            'suplier_id_suplier' => $id_suplier_text,
            'no_nota_supplier' => $no_nota,
            'foto_nota' =>  $foto_nota_name,
            'tanggal_masuk' => $tanggal_masuk,
            'sisa' => $sisa,
            'status' => $status,
            'total_transaksi' => $total_harga,
            'total_diskon' => $total_diskon,
            'total_ppn' => $total_ppn,
            'total_bayar' => $total_bayar,
            'bayar' => $total_bayar,
            'unit_idunit' => $useridunit,
            'pelanggan_id_pelanggan' => $id_pelanggan ?? null,
            'input_by' => $input_by
        );

        foreach ($produkData as $produk) {
            $produkid = $produk['id'];
            $namaproduk = $produk['nama'];
            $datastokawal = $this->StokAwalModel->getByIdBarang($produkid);

            if (!$datastokawal || $datastokawal->satuan_terkecil == null) {
                session()->setFlashdata('gagal', 'Barang dengan ID ' . $namaproduk . ' belum memiliki data satuan di stok awal.');
                return redirect()->back();
            }
        }


        $result = $this->PembelianModel->insert_Pembelian($data);
        $idPembelian = $this->PembelianModel->insertID();
        foreach ($produkData as $produk) {
            $datastokawal = $this->StokAwalModel->getByIdBarang($produk['id']);
            $databarang = $this->BarangModel->getById($produk['id']);

            $hrg_beli = $this->cleanRupiah($produk['harga_beli']);
            $produkjumlah = $produk['jumlah'];
            $produkdiskon = $this->cleanRupiah($produk['diskon']);
            $produkharga  = $this->cleanRupiah($produk['harga']);
            $nilaidiskon = $produkdiskon;
            $produkppn = $produk['ppn'] ?? null;
            $subtotalAwal = $produkharga * $produkjumlah;
            $subtotalSetelahDiskon = $subtotalAwal - $nilaidiskon;
            $nilaiPPN = !is_null($produkppn) ? $subtotalSetelahDiskon * 0.11 : 0;

            $produktotalharga = $subtotalSetelahDiskon + $nilaiPPN;
            $satuan_beli = $datastokawal->satuan_terkecil;

            $datahpp = $this->HppBarangModel->getById($produk['id']);
            $hitung_hpp  = $datahpp->hpp ?? 0;

            $data2 = array(
                'no_batch' => $no_nota,
                'tanggal' => $tanggal_masuk_full,
                'jumlah' => $produkjumlah,
                'hrg_beli' => $hrg_beli,
                'diskon' => $nilaidiskon,
                'ppn' => $nilaiPPN,
                'hitung_hpp' => $hitung_hpp,
                'total_harga' => $produktotalharga,
                'satuan_beli' => $satuan_beli,
                'barang_idbarang' => $produk['id'],
                'unit_idunit' => $useridunit,
                'pembelian_idpembelian' => $idPembelian,

            );

            $result2 = $this->DetailPembelianModel->insert_detail($data2);
        }

        if ($result & $result2) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/pembelian'));
        }
    }
}
