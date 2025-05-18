<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelPembelian;
use App\Models\ModelStokAwal;
use App\Models\ModelDetailPembelian;
use App\Models\ModelSuplier;
use App\Models\ModelMutasiStok;
use App\Models\ModelUnit;
use App\Models\ModelHppBarang;
use App\Models\ModelDetailMutasi;

class MutasiStok extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $BarangModel;
    protected $KategoriModel;
    protected $SuplierModel;
    protected $PembelianModel;
    protected $StokAwalModel;
    protected $DetailPembelianModel;
    protected $MutasiStokModel;
    protected $UnitModel;
    protected $HppBarangModel;
    protected $DetailMutasiModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->BarangModel = new ModelBarang();
        $this->KategoriModel = new ModelKategori();
        $this->SuplierModel = new ModelSuplier();
        $this->PembelianModel = new ModelPembelian();
        $this->StokAwalModel = new ModelStokAwal();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->MutasiStokModel = new ModelMutasiStok();
        $this->UnitModel = new ModelUnit();
        $this->HppBarangModel = new ModelHppBarang();
        $this->DetailMutasiModel = new ModelDetailMutasi();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'stok' => $this->KartuStokModel->getKartuStokWithKategori(),
            'produk' => $this->BarangModel->getAllBarang(),
            'kategori' => $this->KategoriModel->getKategori(),
            'suplier' => $this->SuplierModel->getSuplier(),
            'unit' => $this->UnitModel->getUnit(),
            'body'  => 'stok/mutasi_stok'
        );
        return view('template', $data);
    }

    public function insert()
    {

        $produkData = $this->request->getPost('produk');
        $kirim_idunit = $this->request->getPost('id_unit1_text');
        $terima_idunit = $this->request->getPost('id_unit2_text');

        if ($kirim_idunit == $terima_idunit) {
            session()->setFlashdata('gagal', 'Tidak dapat memilih unit yang sama');
            return redirect()->back();
        }


        date_default_timezone_set('Asia/Jakarta');

        $tanggal_kirim = $this->request->getPost('tanggal_kirim');
        $tanggal_terima = $this->request->getPost('tanggal_terima');

        $waktu_sekarang = date('H:i:s');

        $tanggal_kirim_datetime = $tanggal_kirim . ' ' . $waktu_sekarang;
        $tanggal_terima_datetime = $tanggal_terima . ' ' . $waktu_sekarang;




        $tanggal_kirim_ymd = date('ymd', strtotime($tanggal_kirim));


        // nomutasi
        $lastMutasi = $this->MutasiStokModel
            ->where('kirim_idunit', $kirim_idunit)
            ->like('tanggal_kirim', $tanggal_kirim_ymd)
            ->orderBy('no_nota_mutasi', 'DESC')
            ->first();

        if ($lastMutasi) {
            $lastKode = substr($lastMutasi['no_nota_mutasi'], -3);
            $newKode = str_pad((int)$lastKode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newKode = '001';
        }


        $no_nota_mutasi =  'MTS' . $kirim_idunit . $tanggal_kirim_ymd . $newKode;
        // nomutasi

        $data = array(
            'no_nota_mutasi' => $no_nota_mutasi,
            'tanggal_kirim' => $tanggal_kirim_datetime,
            'tanggal_terima' => $tanggal_terima_datetime,
            'kirim_idunit' => $kirim_idunit,
            'terima_idunit' => $terima_idunit,
            'status' => '0',
            'input_by' => session('ID_AKUN'),
            'created_on' => date('Y-m-d H:i:s'),
            'updated_on' => ''
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

        $result = $this->MutasiStokModel->insert_MutasiStok($data);
        $idMutasi = $this->MutasiStokModel->insertID();



        foreach ($produkData as $produk) {
            $datastokawal = $this->StokAwalModel->getByIdBarang($produk['id']);
            $databarang = $this->BarangModel->getById($produk['id']);
            $idbarang = $produk['id'];

            $satuan = $datastokawal->satuan_terkecil;

            $produkjumlahKirim = $produk['jumlah_kirim'];
            $produkjumlahTerima = $produk['jumlah_terima'];

            $datahpp = $this->HppBarangModel->getById($idbarang);
            $hpp = $datahpp->hpp ?? 0;



            $data2 = array(
                'tanggal_kirim' => $tanggal_kirim,
                'tanggal_terima' => $tanggal_terima,
                'jumlah_kirim' => $produkjumlahKirim,
                'jumlah_terima' => $produkjumlahTerima,
                'satuan' => $satuan,
                'hpp_barang' => $hpp,
                'barang_idbarang' => $idbarang,
                'kirim_idunit' => $kirim_idunit,
                'terima_idunit' => $terima_idunit,
                'mutasi_idmutasi' => $idMutasi

            );
            $result2 = $this->DetailMutasiModel->insert_DetailMutasiStok($data2);
        }

        if ($result & $result2) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/mutasi_stok'));
        }
    }
}
