<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKerusakan;
use App\Models\ModelStokBarang;
use App\Models\ModelPelanggan;
use App\Models\ModelService;
use App\Models\ModelServiceKerusakan;
use App\Models\ModelServiceSparepart;
use App\Models\ModelStokAwal;
use App\Models\ModelHppBarang;

class Service extends BaseController

{

    protected $AuthModel;
    protected $KerusakanModel;
    protected $StokBarangModel;
    protected $PelangganModel;
    protected $ServiceModel;
    protected $ServiceKerusakanModel;
    protected $ServiceSparepartModel;
    protected $StokAwalModel;
    protected $HppBarangModel;


    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KerusakanModel = new ModelKerusakan();
        $this->StokBarangModel = new ModelStokBarang();
        $this->PelangganModel = new ModelPelanggan();
        $this->ServiceModel = new ModelService();
        $this->ServiceKerusakanModel = new ModelServiceKerusakan();
        $this->ServiceSparepartModel = new ModelServiceSparepart();
        $this->StokAwalModel = new ModelStokAwal();
        $this->HppBarangModel = new ModelHppBarang();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $teknisi = $this->AuthModel->getdataakun();
        $idservice = session('idservice') ?? null;
        $oldkerusakan = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $oldsparepart = $this->ServiceSparepartModel->getSerModelServiceSparepartByServiceId($idservice);
        $data =  array(
            'akun' => $akun,
            'teknisi' => $teknisi,
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'idservice' => $idservice,
            'old_service_pelanggan' => $this->ServiceModel->getByIdWithPelanggan($idservice),
            'oldkerusakan' => $oldkerusakan,
            'oldsparepart' => $oldsparepart,
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'sparepart' => $this->StokBarangModel->getSparepart(),
            'body'  => 'transaksi/service'
        );
        return view('template', $data);
    }

    public function indexedit($idservice)
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $teknisi = $this->AuthModel->getdataakun();

        $oldkerusakan = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $oldsparepart = $this->ServiceSparepartModel->getSerModelServiceSparepartByServiceId($idservice);
        $data =  array(
            'akun' => $akun,
            'teknisi' => $teknisi,
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'idservice' => $idservice,
            'old_service_pelanggan' => $this->ServiceModel->getByIdWithPelanggan($idservice),
            'oldkerusakan' => $oldkerusakan,
            'oldsparepart' => $oldsparepart,
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'sparepart' => $this->StokBarangModel->getSparepart(),
            'body'  => 'transaksi/service'
        );
        return view('template', $data);
    }




    public function insert_service()
    {
        $idservice = $this->request->getPost('idservice');

        if (session()->has('idservice')) {
            session()->setFlashdata('gagal', 'Gagal! Selesaikan inputan terkini terlebih dahulu untuk input data baru.');
            return redirect()->back();
        }


        $idpelanggan  = $this->request->getPost('selectedidpelanggan');
        $no_hp = $this->request->getPost('no_hp');
        $imei = $this->request->getPost('imei');
        $dp_bayar = $this->rupiahToInt($this->request->getPost('dp_bayar'));
        $tipe_passcode = $this->request->getPost('tipe_passcode');
        $passcode = $this->request->getPost('passcode');
        $email_icloud = $this->request->getPost('email_icloud');
        $password_icloud = $this->request->getPost('password_icloud');
        $alamat = $this->request->getPost('alamat');
        $keluhan = $this->request->getPost('keluhan');
        $keterangan = $this->request->getPost('keterangan');
        $estimasi_biaya = $this->request->getPost('estimasi_biaya');

        $idunit = session('ID_UNIT');
        $idakun = session('ID_AKUN');

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Ymd');
        $tanggal_cek = date('Y-m-d');
        $created_at = date('Y-m-d H:i:s');


        // noservice
        $lastService = $this->ServiceModel
            ->where('unit_idunit', $idunit)
            ->like('DATE(created_at)', $tanggal_cek)
            ->orderBy('no_service', 'DESC')
            ->first();

        if ($lastService) {
            $lastKode = substr($lastService->no_service, -3);
            $newKode = str_pad((int)$lastKode + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newKode = '001';
        }


        $no_service =  'SRV' . $idunit . $tanggal . $newKode;
        // noservice

        $data = array(
            'no_service' => $no_service,
            'no_hp' => $no_hp,
            'imei' => $imei,
            'dp_bayar' => $dp_bayar,
            'alamat' => $alamat,
            'keluhan' => $keluhan,
            'keterangan' => $keterangan,
            'type_passcode' => $tipe_passcode,
            'passcode' => $passcode,
            'email_icloud' => $email_icloud,
            'password_icloud' => $password_icloud,
            'pelanggan_id_pelanggan' => $idpelanggan,
            'estimasi_biaya' => $estimasi_biaya,
            'unit_idunit' => $idunit,
            'input_by' => $idakun,
            'created_at' => $created_at,
        );
        $result = $this->ServiceModel->insertService($data);
        if ($result) {
            $idservice = $this->ServiceModel->insertID();
            session()->set('idservice', $idservice);
            session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
            return redirect()->to('/service?tab=kerusakan')->with('success', 'Data kerusakan berhasil diperbarui.');
        }
    }


    public function insert_kerusakan()
    {
        $fungsiTerpilih = $this->request->getPost('fungsi');
        $keteranganInput = $this->request->getPost('keterangan');
        $idservice = $this->request->getPost('idservice_k');

        if (empty($fungsiTerpilih)) {
            return redirect()->to('/service?tab=sparepart')->with('info', 'Tidak ada kerusakan yang dipilih.');
        }

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        // Ambil data kerusakan lama dari database
        $dataLama = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $fungsiLama = []; // format: idfungsi => keterangan
        foreach ($dataLama as $item) {
            $fungsiLama[$item->fungsi_idfungsi] = $item->keterangan;
        }

        $fungsiTerpilihMap = array_flip($fungsiTerpilih); // untuk pencarian cepat

        // 1. Tambah atau update yang baru
        foreach ($fungsiTerpilih as $idfungsi) {
            $catatan = $keteranganInput[$idfungsi] ?? '';

            if (array_key_exists($idfungsi, $fungsiLama)) {
                // Cek apakah keterangan berubah
                if (trim($fungsiLama[$idfungsi]) !== trim($catatan)) {
                    $this->ServiceKerusakanModel->updateKeterangan($idservice, $idfungsi, $catatan);
                }
                unset($fungsiLama[$idfungsi]); // tidak akan dihapus
            } else {
                // Tambah baru
                $this->ServiceKerusakanModel->insert_SerModelServiceKerusakan([
                    'fungsi_idfungsi' => $idfungsi,
                    'keterangan' => $catatan,
                    'service_idservice' => $idservice,
                    'created_at' => $now,
                ]);
            }
        }

        // 2. Hapus yang sudah tidak dipilih
        foreach ($fungsiLama as $idfungsi => $keteranganLama) {
            $this->ServiceKerusakanModel->deleteByServiceAndFungsi($idservice, $idfungsi);
        }

        return redirect()->to('/service?tab=sparepart')->with('success', 'Data kerusakan berhasil diperbarui.');
    }


    public function insert_sparepart()
    {
        $produkData = $this->request->getPost('produk');
        $idservice = $this->request->getPost('idservice_s');


        $existingItems = $this->ServiceSparepartModel->getByServiceId($idservice);
        $existingMap = [];

        foreach ($existingItems as $item) {
            $existingMap[$item->barang_idbarang] = $item;
        }

        $submittedIds = [];

        if (!empty($produkData)) {
            foreach ($produkData as $produk) {
                $id     = $produk['id'];
                $jumlah = (int) $produk['jumlah'];
                $harga  = $this->rupiahToInt($produk['harga']);
                $diskon_item = $this->rupiahToInt($produk['diskon']);
                $total  = $this->rupiahToInt($produk['total']);
                $submittedIds[] = $id;

                $datahppbarang = $this->HppBarangModel->getById($id);
                $hpp = $datahppbarang->hpp ?? 0;

                $datastokawal = $this->StokAwalModel->getById($id);
                $satuan_terkecil = $datastokawal->satuan_terkecil ?? 'pcs';

                $datas = [
                    'jumlah' => $jumlah,
                    'harga_penjualan' => $harga,
                    'harga_penjualan_garansi' => 0,
                    'sub_total' => $total,
                    'hpp_penjualan' => $hpp,
                    'satuan_jual' => $satuan_terkecil,
                    'diskon_penjualan' => $diskon_item,
                    'service_idservice' => $idservice,
                    'barang_idbarang' => $id,
                    'unit_idunit' => session('ID_UNIT'),
                    'diskon_penjualan_garansi' => 0,
                    'jumlah_tambahan_garansi' => 0,
                    'sub_total_garansi' => 0
                ];

                if (array_key_exists($id, $existingMap)) {
                    // ID sudah ada → Update
                    $this->ServiceSparepartModel
                        ->updateByServiceAndBarang($idservice, $id, $datas);
                } else {
                    // ID belum ada → Insert
                    $this->ServiceSparepartModel
                        ->insert_SerModelServiceSparepart($datas);
                }
            }
        }

        // Hapus data sparepart yang tidak lagi ada di form
        foreach ($existingMap as $barangId => $item) {
            if (!in_array($barangId, $submittedIds)) {
                $this->ServiceSparepartModel
                    ->deleteByServiceAndBarang($idservice, $barangId);
            }
        }
        return redirect()->to('/service?tab=pembayaran')->with('success', 'Data kerusakan berhasil diperbarui.');
    }



    public function insert_pembayaran()
    {

        //pembayaran
        $service_by = $this->request->getPost('service_by_pembayaran');
        $diskon_pembayaran = $this->rupiahToInt($this->request->getPost('diskon_pembayaran'));
        $garansi = (int) $this->request->getPost('garansi');
        $total_harga_pembayaran = $this->rupiahToInt($this->request->getPost('total_harga_pembayaran'));
        $status_service = $this->request->getPost('status_service_pembayaran');
        $service_by_pembayaran = $this->request->getPost('service_by_pembayaran');
        $bayar_pembayaran = $this->rupiahToInt($this->request->getPost('bayar_pembayaran'));
        $dp_pembayaran = $this->rupiahToInt($this->request->getPost('dp_pembayaran'));
        $idservice = $this->request->getPost('idservice_p');

        $datap = array(

            'total_service' => $total_harga_pembayaran,
            'total_diskon' => $diskon_pembayaran,
            'dp_bayar' => $dp_pembayaran,
            'harus_dibayar' => $total_harga_pembayaran,
            'garansi_hari' => $garansi,
            'bayar' => $bayar_pembayaran,
            'service_by' => $service_by_pembayaran,
            'total_service_garansi' => 0,
            'biaya_tambahan_garansi' => 0,
            'total_diskon_garansi' => 0,
            'harga_penjualan_garansi' => 0
        );
        $resultend =  $this->ServiceModel->updateService($idservice, $datap);

        session()->remove('idservice');
        session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
        return redirect()->to(base_url('/service'));
    }


    function rupiahToInt($rupiah)
    {

        $cleaned = str_replace(['Rp', '.', ' '], '', $rupiah);


        return (int) preg_replace('/[^0-9]/', '', $cleaned);
    }
}
