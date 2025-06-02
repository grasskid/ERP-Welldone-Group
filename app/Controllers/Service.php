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
        $idservice = session('idservice') ?? null;
        $oldkerusakan = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $oldsparepart = $this->ServiceSparepartModel->getSerModelServiceSparepartByServiceId($idservice);
        $data =  array(
            'akun' => $akun,
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

    public function kerusakan_table()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'body'  => 'transaksi/table/kerusakan_table'
        );
        return view('template', $data);
    }

    public function sparepart_table()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'sparepart' => $this->BarangModel->getBarangSparepart(),
            'body'  => 'transaksi/table/sparepart_table'
        );
        return view('template', $data);
    }

    public function insert_service()
    {
        $idservice = $this->request->getPost('idservice');

        if (session()->has('idservice')) {
            session()->setFlashdata('gagal', 'Gagal! Selesaikan pembayaran terlebih dahulu untuk input data baru.');
            return redirect()->back();
        }


        $idpelanggan  = $this->request->getPost('selectedidpelanggan');
        $no_hp = $this->request->getPost('no_hp');
        $imei = $this->request->getPost('imei');
        $tipe_passcode = $this->request->getPost('tipe_passcode');
        $passcode = $this->request->getPost('passcode');
        $email_icloud = $this->request->getPost('email_icloud');
        $password_icloud = $this->request->getPost('password_icloud');
        $alamat = $this->request->getPost('alamat');
        $keluhan = $this->request->getPost('keluhan');
        $keterangan = $this->request->getPost('keterangan');

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
            'alamat' => $alamat,
            'keluhan' => $keluhan,
            'keterangan' => $keterangan,
            'type_passcode' => $tipe_passcode,
            'passcode' => $passcode,
            'email_icloud' => $email_icloud,
            'password_icloud' => $password_icloud,
            'status_service' => 1,
            'pelanggan_id_pelanggan' => $idpelanggan,
            'unit_idunit' => $idunit,
            'input_by' => $idakun,
            'created_at' => $created_at,
        );
        $result = $this->ServiceModel->insertService($data);
        if ($result) {
            $idservice = $this->ServiceModel->insertID();
            session()->set('idservice', $idservice);
            session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
            return redirect()->to(base_url('/service#kerusakan-tab'));
        }
    }

    public function insert_kelengkapan_service()
    {
        //kerusakan
        $fungsiTerpilih = $this->request->getPost('fungsi');
        $keterangan = $this->request->getPost('keterangan');
        $idservice = $this->request->getPost('idservice');

        date_default_timezone_set('Asia/Jakarta');
        $created_at = date('Y-m-d H:i:s');

        if (!empty($fungsiTerpilih)) {
            foreach ($fungsiTerpilih as $idfungsi) {
                $catatan = $keterangan[$idfungsi] ?? '';
                $datak = [
                    'fungsi_idfungsi' => $idfungsi,
                    'keterangan' => $catatan,
                    'service_idservice' => $idservice,
                    'created_at' => $created_at,
                ];
                $this->ServiceKerusakanModel->insert_SerModelServiceKerusakan($datak);
            }
        }
        // jika tidak ada yang dipilih: tidak lakukan apa-apa

        //sparepart
        $produkData = $this->request->getPost('produk');
        if (!empty($produkData)) {
            foreach ($produkData as $produk) {
                $id     = $produk['id'];
                $jumlah = $produk['jumlah'];
                $harga  = $produk['harga'];
                $diskon_item = $produk['diskon'];
                $total  = $produk['total'];

                $datahppbarang = $this->HppBarangModel->getById($id);
                $hpp = $datahppbarang->hpp ?? 0;

                $datastokawal = $this->StokAwalModel->getById($id);
                $satuan_terkecil = $datastokawal ? $datastokawal->satuan_terkecil : 'pcs';

                $datas = [
                    'jumlah' => $jumlah,
                    'harga_penjualan' => $harga,
                    'sub_total' => $total * $jumlah,
                    'hpp_penjualan' => $hpp,
                    'satuan_jual' => $satuan_terkecil,
                    'diskon_penjualan' => $diskon_item,
                    'service_idservice' => $idservice,
                    'barang_idbarang' => $id,
                    'unit_idunit' => session('ID_UNIT')
                ];

                $this->ServiceSparepartModel->insert_SerModelServiceSparepart($datas);
            }
        }
        // jika tidak ada yang dipilih: tidak lakukan apa-apa

        //pembayaran
        $service_by = $this->request->getPost('service_by_pembayaran');
        $diskon_pembayaran = $this->request->getPost('diskon_pembayaran');
        $garansi = (int) $this->request->getPost('garansi');
        $total_harga_pembayaran = $this->request->getPost('total_harga_pembayaran');
        $status_service = $this->request->getPost('status_service_pembayaran');

        $datap = array(
            'status_service' => $status_service,
            'total_service' => $total_harga_pembayaran,
            'total_diskon' => $diskon_pembayaran,
            'harus_dibayar' => $total_harga_pembayaran,
            'garansi_hari' => $garansi,
            'service_by' => 1
        );
        $resultend =  $this->ServiceModel->updateService($idservice, $datap);

        session()->remove('idservice');
        session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
        return redirect()->to(base_url('/service'));
    }

    public function insert_sparepart()
    {

        $produkData = $this->request->getPost('produk');

        $idservice = $this->request->getPost('idservice');
        $total_harga_str = $this->request->getPost('total_harga');
        $diskon_str = $this->request->getPost('diskon');
        $harga_akhir_str = $this->request->getPost('harga_akhir');


        $total_harga = (int) str_replace('.', '', $total_harga_str);
        $diskon = (int) str_replace('.', '', $diskon_str);
        $harga_akhir = (int) str_replace('.', '', $harga_akhir_str);


        $garansi = (int) $this->request->getPost('garansi');

        $data1 = array(
            'total_service' => $harga_akhir,
            'total_diskon' => $diskon,
            'harus_dibayar' => $harga_akhir,
            'garansi_hari' => $garansi,
        );


        $this->ServiceModel->updateService($idservice, $data1);

        foreach ($produkData as $produk) {
            $id     = $produk['id'];
            $jumlah = $produk['jumlah'];
            $harga  = $produk['harga'];
            $diskon_item = $produk['diskon'];
            $total  = $produk['total'];

            $datahppbarang = $this->HppBarangModel->getById($id);
            $hpp = $datahppbarang->hpp ?? 0;

            $datastokawal = $this->StokAwalModel->getById($id);
            $satuan_terkecil = $datastokawal ? $datastokawal->satuan_terkecil : 'pcs';



            $data = array(
                'jumlah' => $jumlah,
                'harga_penjualan' => $harga,
                'sub_total' => $total * $jumlah,
                'hpp_penjualan' => $hpp,
                'satuan_jual' => $satuan_terkecil,
                'diskon_penjualan' => $diskon_item,
                'service_idservice' => $idservice,
                'barang_idbarang' => $id,
                'unit_idunit' => session('ID_UNIT')
            );

            $this->ServiceSparepartModel->insert_SerModelServiceSparepart($data);
        }

        session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
        return redirect()->to(base_url('/service'));
    }
}
