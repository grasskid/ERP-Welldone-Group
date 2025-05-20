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
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'produk' => $this->BarangModel->getAllBarang(),
            'kategori' => $this->KategoriModel->getKategori(),
            'suplier' => $this->SuplierModel->getSuplier(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'body'  => 'transaksi/penjualan'
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

        //invoice otomatis

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
        $bayar = $this->sanitizeCurrency($this->request->getPost('bayar'));
        $created_on = $waktu_penjualan;
        $total_ppn = $this->sanitizeCurrency($this->request->getPost('total-ppn'));

        $unit_idunit = 1;
        $hutang = $this->sanitizeCurrency($this->request->getPost('hutang'));
        $keterangan = '';
        if ($hutang == 0) {
            $keterangan = 'Lunas';
        } else {
            $keterangan = 'Belum Lunas';
        }

        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $nik = $this->request->getPost('nik');
        $nomor = $this->request->getPost('nomor');
        $id_pelanggan = $this->request->getPost('id_pelanggan');

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




        $data1 = array(
            'kode_invoice' => $no_invoice,
            'tanggal' => $tanggal_waktu,
            'keterangan' => $keterangan,
            'total_penjualan' => $total_penjualan,
            'diskon' => $diskon,
            'harus_dibayar' => $harus_dibayar,
            'waktu_penjualan' => $waktu_penjualan,
            'bayar' => $bayar,
            'created_on' => $created_on,
            'input_by' => session('ID_AKUN'),
            'sales_by' => session('ID_AKUN'),
            'unit_idunit' => $unit_idunit,
            'id_pelanggan' => $id_pelanggan,
            'total_ppn' => $total_ppn,
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


        $result = $this->PenjualanModel->insert_Penjualan($data1);
        $idPenjualan = $this->PenjualanModel->insertID();
        foreach ($produkData as $produk) {

            $produkjumlah = $produk['jumlah'];
            $produkid = $produk['id'];
            $datastokawal = $this->StokAwalModel->getByIdBarang($produkid);


            $produkharga = $this->sanitizeCurrency($produk['harga']);
            $produkdiskon = $this->sanitizeCurrency($produk['diskon']);
            $nilaidiskon = $produkdiskon;
            $subtotalAwal = $produkharga * $produkjumlah;
            $sub_total = $subtotalAwal - $nilaidiskon;

            $harga_penjualan = $produkharga;
            $diskon_penjualan = $nilaidiskon;

            $datahpp = $this->HppBarangModel->getById($produkid);
            $hpp_penjualan  = $datahpp->hpp ?? 0;


            $penjualan_idpenjualan = $idPenjualan;
            $satuan_jual = $datastokawal->satuan_terkecil;

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

            $result2 = $this->DetailPenjualanModel->insert_detail($data2);
        }

        if ($result & $result2) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');

            $sub_total_cetak = $this->sanitizeCurrency($total_penjualan) + $this->sanitizeCurrency($nilaidiskon) - $total_ppn;
            $kembalian_cetak = max(0, $this->sanitizeCurrency($bayar) - $this->sanitizeCurrency($total_penjualan));
            $dataCustomer = $this->PelangganModel->getById($id_pelanggan);
            if ($dataCustomer !== null) {
                $namaCustomer = $dataCustomer->nama;
            } else {
                $namaCustomer = 'Pelanggan Umum';
            }
            $data3 = array(

                'produk' => $produkData,
                'tanggal' => $tanggal_waktu,
                'kasir'  => $namauser,
                'customer' => $namaCustomer,
                'total_ppn' => $total_ppn,
                'no_invoice' => $no_invoice,
                'sub_total' => $sub_total_cetak,
                'diskon' => $nilaidiskon,
                'total' => $total_penjualan,
                'bayar' => $bayar,
                'kembalian' => $kembalian_cetak,

            );


            $html = view('cetak/cetak_penjualan', $data3);

            error_reporting(0);

            $mpdf = new \Mpdf\Mpdf(['curlUserAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:108.0) Gecko/20100101 Firefox/108.0']);

            ob_end_clean();

            $mpdf->curlAllowUnsafeSslRequests = true;

            $this->response->setHeader('Content-Type', 'application/pdf');

            $this->response->setHeader('Content-Transfer-Encoding', 'binary');

            $this->response->setHeader('Accept-Ranges', 'bytes');

            $mpdf->WriteHTML($html);

            return redirect()->to($mpdf->Output());
        }
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
