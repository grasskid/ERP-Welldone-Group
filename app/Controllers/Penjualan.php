<?php

namespace App\Controllers;

use App\Models\ModelBarang;


use App\Models\ModelDetailPenjualan;
use App\Models\ModelKategori;
use App\Models\ModelPembelian;
use App\Models\ModelStokAwal;
use App\Models\ModelDetailPembelian;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelSuplier;
use App\Models\ModelPenjualan;
use App\Models\ModelPelanggan;
use DateTime;
use Mpdf\Mpdf;
use App\Models\ModelAuth;
use App\Models\ModelHppBarang;
use App\Models\ModelStokBarang;
use App\Models\ModelJurnal;
use App\Models\ModelPenilaianKPI;
use App\Models\ModelPenilaian;
use App\Models\ModelTemplateKpi;
use App\Models\ModelUnit;
use App\Models\ModelBank;
use App\Models\ModelBundle;
use App\Models\ModelDetailBundle;
use App\Models\ModelPembayaranBank;


class Penjualan extends BaseController
{

    protected $BarangModel;
    protected $KategoriModel;
    protected $SuplierModel;
    protected $PenjualanModel;
    protected $StokAwalModel;
    protected $DetailPenjualanModel;
    protected $PelangganModel;
    protected $AuthModel;
    protected $HppBarangModel;
    protected $StokBarangModel;
    protected $JurnalModel;
    protected $ModelPenilaianKPI;
    protected $ModelPenilaian;
    protected $ModelTemplateKPI;
    protected $UnitModel;
    protected $PenilaianKPIModel;
    protected $PenilaianModel;
    protected $TemplateKpiModel;
    protected $BankModel;
    protected $BundleModel;
    protected $DetailBundelModel;
    protected $PembayaranBankModel;

    public function __construct()
    {
        $this->BarangModel = new ModelBarang();
        $this->KategoriModel = new ModelKategori();
        $this->SuplierModel = new ModelSuplier();
        $this->PenjualanModel = new ModelPenjualan();
        $this->StokAwalModel = new ModelStokAwal();
        $this->DetailPenjualanModel = new ModelDetailPenjualan();
        $this->PelangganModel = new ModelPelanggan();
        $this->AuthModel = new ModelAuth();
        $this->HppBarangModel = new ModelHppBarang();
        $this->StokBarangModel = new ModelStokBarang();
        $this->JurnalModel = new ModelJurnal();
        $this->PenilaianKPIModel = new ModelPenilaianKPI();
        $this->PenilaianModel = new ModelPenilaian();
        $this->TemplateKpiModel = new ModelTemplateKpi();
        $this->UnitModel = new ModelUnit();
        $this->BankModel = new ModelBank();
        $this->BundleModel = new ModelBundle();
        $this->DetailBundelModel = new ModelDetailBundle();
        $this->PembayaranBankModel = new ModelPembayaranBank();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $data = array(
            'akun' => $akun,
            'produk' => $this->StokBarangModel->getAllBarang2(),
            'frontliner' => $this->AuthModel->getAkunFrontliner(),
            'bank' => $this->BankModel->getBank(),
            'kategori' => $this->KategoriModel->getKategori(),
            'suplier' => $this->SuplierModel->getSuplier(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'bundle' => $this->BundleModel->getBundleWithDetail(),
            'body' => 'transaksi/penjualan',
        );

        return view('template', $data);
    }

    public function insert_penjualan()
    {

        $produkData = $this->request->getPost('produk');
        $datauser = $this->AuthModel->getById(session('ID_AKUN'));
        $useridunit = $datauser->ID_UNIT;
        $namauser = $datauser->NAMA_AKUN;

        //
        $tanggal = $this->request->getPost('tanggal_masuk');
        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = date('H:i:s');
        $datetime = DateTime::createFromFormat('d-m-Y', $tanggal);
        $tanggal_formatted = $datetime ? $datetime->format('Y-m-d') : date('Y-m-d'); // fallback

        $tanggal_waktu = $tanggal_formatted . ' ' . $waktu_sekarang;
        //
        $ymd = date('Ymd');
        $tgl_hari_ini = date('Y-m-d');

        // Ambil invoice terakhir hari ini 
        $lastInvoice = $this->PenjualanModel
            ->select('kode_invoice')
            ->where('DATE(tanggal)', $tgl_hari_ini)
            ->where('unit_idunit', $useridunit)
            ->orderBy('kode_invoice', 'DESC')
            ->first();
        if ($lastInvoice) {
            // Ambil 4 digit terakhir (urutan)
            $lastNumber = (int) substr($lastInvoice->kode_invoice, -4);
            $urutan = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $urutan = '0001';
        }

        $no_invoice = 'SLL' . $useridunit . $ymd . $urutan;
        //end invoice otomatis

        $total_penjualan = $this->sanitizeCurrency($this->request->getPost('total-harga'));
        $diskon = $this->sanitizeCurrency($this->request->getPost('total-diskon'));
        $harus_dibayar = $total_penjualan;
        $waktu_penjualan = date('Y-m-d H:i:s');
        // Ambil bayar tunai (tetap sama)
        $bayar_tunai = $this->sanitizeCurrency($this->request->getPost('bayar'));


        $bankData = $this->request->getPost('bank');


        $bankPembayaran = [];
        $totalBayarBank = 0;
        $kodePembayaran = date('Ymd') . session('ID_UNIT') . rand(1000, 9999);

        if (!empty($bankData) && is_array($bankData)) {
            foreach ($bankData as $b) {
                $jumlah = $this->sanitizeCurrency($b['jumlah'] ?? '0');
                if ($jumlah > 0) {
                    $bankPembayaran = array(
                        'kode_pembayaran' => $kodePembayaran,
                        'bank_idbank' => $b['id'],
                        'jumlah' => $jumlah,
                        'tabel_referensi' => 'penjualan'
                    );

                    $this->PembayaranBankModel->insertPembayaranBank($bankPembayaran);
                    $totalBayarBank += $jumlah;
                }
            }
        }


        $total_bayar = $bayar_tunai + $totalBayarBank;


        $created_on = $tanggal_waktu;
        $total_ppn = $this->sanitizeCurrency($this->request->getPost('total-ppn'));

        $unit_idunit = 1;
        $hutang = $this->sanitizeCurrency($this->request->getPost('hutang'));
        $keterangan = '';
        if ($hutang == 0) {
            $keterangan = 'Lunas';
        } else {
            $keterangan = 'Belum Lunas';
        }


        $id_pelanggan = $this->request->getPost('selectedidpelanggan');
        $sales_by = $this->request->getPost('sales_by');


        $data1 = array(
            'kode_invoice' => $no_invoice,
            'tanggal' => $tanggal_waktu,
            'keterangan' => $keterangan,
            'total_penjualan' => $total_penjualan,
            'diskon' => $diskon,
            'harus_dibayar' => $harus_dibayar,
            'waktu_penjualan' => $waktu_penjualan,
            'bayar' => $total_bayar,
            'bank_idbank' => $kodePembayaran,
            'bayar_bank' => $totalBayarBank,
            'bayar_tunai' => $bayar_tunai,
            'created_on' => $created_on,
            'input_by' => session('ID_AKUN'),
            'sales_by' => $sales_by,
            'unit_idunit' => $unit_idunit,
            'id_pelanggan' => $id_pelanggan,
            'total_ppn' => $total_ppn,
        );
        $this->PenjualanModel->insert_Penjualan($data1);
        $idPenjualan = $this->PenjualanModel->insertID();

        $pelengkap_pembayaranbank = array(
            'id_referensi' => $idPenjualan
        );
        $this->PembayaranBankModel->updateByKodePembayaran($kodePembayaran, $pelengkap_pembayaranbank);

        foreach ($produkData as $produk) {
            $produkid = $produk['id'];
            $namaproduk = $produk['nama'];
            $datastokawal = $this->StokAwalModel->getByIdBarang($produkid);

            if (!$datastokawal || $datastokawal->satuan_terkecil == null) {
                session()->setFlashdata('gagal', 'Barang dengan ID ' . $namaproduk . ' belum memiliki data satuan di stok awal.');
                return redirect()->back();
            }
        }

        $total_penjualan = array_sum(array_map(function ($p) {
            return $this->sanitizeCurrency($p['harga']) * $p['jumlah'];
        }, $produkData));







        foreach ($produkData as $produk) {
            $produkjumlah = $produk['jumlah'];
            $produkid = $produk['id'];
            $produkharga = $this->sanitizeCurrency($produk['harga']);
            $produkdiskon = $this->sanitizeCurrency($produk['diskon']);
            $nilaidiskon = $produkdiskon;
            $subtotalAwal = $produkharga * $produkjumlah;
            $sub_total = $subtotalAwal - $nilaidiskon;

            $harga_penjualan = $produkharga;
            $diskon_penjualan = $nilaidiskon;
            $penjualan_idpenjualan = $idPenjualan;
            $kode = $produk['kode'];
            $kenaPPN = isset($produk['ppn']) ? 1 : 0;

            $proporsi = $subtotalAwal / $total_penjualan;
            $bayar_tunai_item = round($proporsi * $bayar_tunai, 0);
            $bayar_bank_items = [];
            if (!empty($bankData)) {
                foreach ($bankData as $bank) {
                    $bayar_bank_items[] = [
                        'bank_idbank' => $bank['id'],
                        'jumlah' => round($proporsi * $this->sanitizeCurrency($bank['jumlah'] ?? '0'), 0)
                    ];
                }
            }
            if (strpos($kode, 'HP') === 0) {
                $isHandphone = 1;
            } else {
                $isHandphone = 0;
            }


            $kondisi = $produk['kondisi_barang'];
            $iskondisi = "";
            if ($kondisi == 1) {

                $iskondisi == 1;
            } elseif ($kondisi == 0) {

                $iskondisi == 0;
            }



            if (strpos($produkid, 'bundle') === 0) {

                $bundleId = (int) str_replace('bundle', '', $produkid);
                $detailBundle = $this->DetailBundelModel->getByBundleId($bundleId);

                foreach ($detailBundle as $item) {
                    $idBarangBundle = $item->barang_idbarang;
                    $jumlahBundle = $item->jumlah * $produkjumlah;

                    $datastokawal = $this->StokAwalModel->getByIdBarang($idBarangBundle);
                    $satuan_jual = $datastokawal->satuan_terkecil ?? null;

                    $datahpp = $this->HppBarangModel->getById($idBarangBundle);
                    $hpp_penjualan = $datahpp->hpp ?? 0;

                    $data2 = array(
                        'jumlah' => $jumlahBundle,
                        'barang_idbarang' => $idBarangBundle,
                        'harga_penjualan' => $harga_penjualan,
                        'sub_total' => $sub_total,
                        'penjualan_idpenjualan' => $penjualan_idpenjualan,
                        'hpp_penjualan' => $hpp_penjualan,
                        'satuan_jual' => $satuan_jual,
                        'diskon_penjualan' => $diskon_penjualan,
                        'unit_idunit' => $unit_idunit,
                        'bundle' => 1
                    );

                    $this->DetailPenjualanModel->insert_detail($data2);
                }
            } else {
                // barang biasa
                $datastokawal = $this->StokAwalModel->getByIdBarang($produkid);
                $satuan_jual = $datastokawal->satuan_terkecil ?? null;

                $datahpp = $this->HppBarangModel->getById($produkid);
                $hpp_penjualan = $datahpp->hpp ?? 0;

                $data2 = array(
                    'jumlah' => $produkjumlah,
                    'barang_idbarang' => $produkid,
                    'harga_penjualan' => $harga_penjualan,
                    'sub_total' => $sub_total,
                    'penjualan_idpenjualan' => $penjualan_idpenjualan,
                    'hpp_penjualan' => $hpp_penjualan,
                    'satuan_jual' => $satuan_jual,
                    'diskon_penjualan' => $diskon_penjualan,
                    'unit_idunit' => $unit_idunit,
                );

                $this->DetailPenjualanModel->insert_detail($data2);

                //jurnal non bundle
                //jika non hp (sementara dianggap acc)
                //jika acc cash tanpa bank non ppn








            }
        }


        session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');



        $sub_total_cetak = $this->sanitizeCurrency($total_penjualan) - $this->sanitizeCurrency($nilaidiskon) + $total_ppn;
        $kembalian_cetak = max(0, $this->sanitizeCurrency($total_bayar) - $this->sanitizeCurrency($total_penjualan));
        $dataCustomer = $this->PelangganModel->getById($id_pelanggan);
        if ($dataCustomer !== null) {
            $namaCustomer = $dataCustomer->nama;
        } else {
            $namaCustomer = 'Pelanggan Umum';
        }
        $data3 = array(

            'produk' => $produkData,
            'tanggal' => $tanggal_waktu,
            'kasir' => $namauser,
            'customer' => $namaCustomer,
            'total_ppn' => $total_ppn,
            'no_invoice' => $no_invoice,
            'sub_total' => $sub_total_cetak,
            'diskon' => $nilaidiskon,
            'total' => $total_penjualan,
            'bayar' => $total_bayar,
            'kembalian' => $kembalian_cetak,
            'dataunit' => $this->UnitModel->getById(session('ID_UNIT'))

        );


        $action = $this->request->getPost('action');

        if ($action == 'simpan_thermal') {
            // cetak thermal
            $html = view('cetak/cetak_penjualan_thermal', $data3);
        } else {
            // cetak default
            $html = view('cetak/cetak_penjualan', $data3);
        }

        error_reporting(0);

        $mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);

$uploadPath = FCPATH . 'uploads/';
if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0777, true);
}

$filename = 'Struk-' . $no_invoice . '.pdf';
$pdfPath = $uploadPath . $filename;
$mpdf->Output($pdfPath, 'F');

// save pdf url in flashdata
session()->setFlashdata('pdf_url', base_url('uploads/' . $filename));

// redirect back
return redirect()->to(base_url('penjualan'));

    }




    function sanitizeCurrency($value)
    {

        $cleaned = str_replace(['Rp', '.', ' '], '', $value);
        return (float) $cleaned;
    }

    public function search_by_hp()
    {
        $no_hp = $this->request->getGet('no_hp');
        $pelanggan = $this->PelangganModel
            ->where('no_hp', $no_hp)
            ->where('deleted', '0')
            ->first();

        return $this->response->setJSON([
            'found' => (bool) $pelanggan,
            'pelanggan' => $pelanggan
        ]);
    }
}