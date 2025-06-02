<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKerusakan;
use App\Models\ModelKartuStok;
use App\Models\ModelPelanggan;
use App\Models\ModelService;
use App\Models\ModelServiceKerusakan;
use App\Models\ModelServiceSparepart;
use App\Models\ModelStokBarang;
use App\Models\ModelHppBarang;
use App\Models\ModelStokAwal;

class Riwayat_Service extends BaseController

{

    protected $AuthModel;
    protected $KerusakanModel;
    protected $KartuStokModel;
    protected $PelangganModel;
    protected $ServiceModel;
    protected $ServiceKerusakanModel;
    protected $ServiceSparepartModel;
    protected $StokBarangModel;
    protected $HppBarangModel;
    protected $StokAwalModel;



    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KerusakanModel = new ModelKerusakan();
        $this->KartuStokModel = new ModelKartuStok();
        $this->PelangganModel = new ModelPelanggan();
        $this->ServiceModel = new ModelService();
        $this->ServiceKerusakanModel = new ModelServiceKerusakan();
        $this->ServiceSparepartModel = new ModelServiceSparepart();
        $this->StokBarangModel = new ModelStokBarang();
        $this->HppBarangModel = new ModelHppBarang();
        $this->StokAwalModel = new ModelStokAwal();
    }

    public function index()
    {

        $data =  array(

            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'service' => $this->ServiceModel->getRiwayatService(),
            'body'  => 'riwayat/service'
        );
        return view('template', $data);
    }

    public function detail_service($idservice)
    {

        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $oldkerusakan = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $oldsparepart = $this->ServiceSparepartModel->getSerModelServiceSparepartByServiceId($idservice);
        $lama_garansi = $this->ServiceSparepartModel->getGaransiHariByServiceId($idservice);
        $data =  array(
            'akun' => $akun,
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'idservice' => $idservice,
            'old_service_pelanggan' => $this->ServiceModel->getByIdWithPelanggan($idservice),
            'oldkerusakan' => $oldkerusakan,
            'oldsparepart' => $oldsparepart,
            'lama_garansi' => $lama_garansi ? (int)$lama_garansi->garansi_hari : null,
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'sparepart' => $this->StokBarangModel->getSparepart(),
            'body'  => 'riwayat/table/service'
        );
        return view('template', $data);
    }


    public function update_kelengkapan_service()
    {
        //kerusakan

        $fungsiTerpilih = $this->request->getPost('fungsi');
        $keterangan = $this->request->getPost('keterangan');
        $idservice = $this->request->getPost('idservice');

        date_default_timezone_set('Asia/Jakarta');
        $created_at = date('Y-m-d H:i:s');


        $kerusakanLama = $this->ServiceKerusakanModel
            ->where('service_idservice', $idservice)
            ->findAll();

        $fungsiLama = array_map(function ($item) {
            return $item->fungsi_idfungsi;
        }, $kerusakanLama);


        if (!$fungsiTerpilih) {
            $this->ServiceKerusakanModel
                ->where('service_idservice', $idservice)
                ->delete();
        } else {

            foreach ($fungsiLama as $idFungsiLama) {
                if (!in_array($idFungsiLama, $fungsiTerpilih)) {
                    $this->ServiceKerusakanModel
                        ->where('service_idservice', $idservice)
                        ->where('fungsi_idfungsi', $idFungsiLama)
                        ->delete();
                }
            }


            foreach ($fungsiTerpilih as $idfungsi) {
                $catatan = $keterangan[$idfungsi] ?? null;


                $existing = $this->ServiceKerusakanModel
                    ->where('service_idservice', $idservice)
                    ->where('fungsi_idfungsi', $idfungsi)
                    ->first();

                if ($existing) {

                    $this->ServiceKerusakanModel->update($existing->idservice_kerusakan, ['keterangan' => $catatan]);
                } else {

                    $datak = array(
                        'fungsi_idfungsi' => $idfungsi,
                        'keterangan' => $catatan,
                        'service_idservice' => $idservice,
                        'created_at' => $created_at,
                    );
                    $this->ServiceKerusakanModel->insert($datak);
                }
            }
        }


        //sparepart
        $produkData = $this->request->getPost('produk');
        $produkBaru = [];

        // data lama
        $sparepartLama = $this->ServiceSparepartModel
            ->where('service_idservice', $idservice)
            ->findAll();


        $barangLama = array_map(function ($item) {
            return $item->barang_idbarang;
        }, $sparepartLama);


        foreach ($produkData as $produk) {
            $id     = $produk['id'];
            $jumlah = $produk['jumlah'];
            $harga  = $produk['harga'];
            $diskon_item = $produk['diskon'];
            $total  = $produk['total'];

            $produkBaru[] = $id;

            $datahppbarang = $this->HppBarangModel->getById($id);
            $hpp = $datahppbarang->hpp ?? 0;

            $datastokawal = $this->StokAwalModel->getById($id);
            $satuan_terkecil = $datastokawal ? $datastokawal->satuan_terkecil : 'pcs';

            $datas = array(
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

            // Cek apakah sudah ada data sparepart dengan barang_idbarang ini
            $existing = $this->ServiceSparepartModel
                ->where('service_idservice', $idservice)
                ->where('barang_idbarang', $id)
                ->first();

            if ($existing) {
                $this->ServiceSparepartModel->update($existing->idservice_sparepart, $datas);
            } else {
                $this->ServiceSparepartModel
                    ->insert($datas);
            }
        }

        // Hapus data sparepart yang sebelumnya ada tapi sekarang tidak dikirim lagi
        foreach ($barangLama as $idbarangLama) {
            if (!in_array($idbarangLama, $produkBaru)) {
                $this->ServiceSparepartModel
                    ->where('service_idservice', $idservice)
                    ->where('barang_idbarang', $idbarangLama)
                    ->delete();
            }
        }

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

        session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
        return redirect()->to(base_url('riwayat_service'));
    }
}
