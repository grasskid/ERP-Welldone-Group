<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelKategori;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelAuth;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelBundle;
use App\Models\ModelDetailBundle;

class Bundle extends BaseController

{

    protected $BarangModel;
    protected $KategoriModel;
    protected $AuthModel;
    protected $BundleModel;
    protected $DetailBundleModel;

    public function __construct()
    {
        $this->BarangModel = new ModelBarang();
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
        $this->BundleModel = new ModelBundle();
        $this->DetailBundleModel = new ModelDetailBundle();
    }

    public function index()
    {
        $data = array(
            'body' => 'bundle/list',
            'barang' => $this->BarangModel->semuaBarang(),
            'bundle' => $this->BundleModel->getBundle(),
            'detail_bundle' => $this->DetailBundleModel->getDetailBundle()
        );

        return view('template', $data);
    }

    public function input()
    {
        $data = array(
            'body' => 'bundle/input',
            'barang' => $this->BarangModel->semuaBarang(),
            'bundle' => $this->BundleModel->getBundle(),
            'detail_bundle' => $this->DetailBundleModel->getDetailBundle()
        );

        return view('template', $data);
    }


    public function insert()
    {
        $barang = $this->request->getPost('barang');
        $nama_bundle = $this->request->getPost('nama_bundle');
        $harga_total = (int) $this->request->getPost('harga_total');

        $data1 = array(
            'nama_bundle' => $nama_bundle,
            'harga_total' => $harga_total,
            'harga_jual' => $harga_total
        );
        $idbundle = $this->BundleModel->insert($data1, true);

        if ($barang) {
            foreach ($barang['kode_barang'] as $i => $kode) {
                $databarang = $this->BarangModel->getBykode($kode);
                $idbarang = $databarang->idbarang;
                $data2 = [
                    'bundle_idbundle' => $idbundle,
                    'barang_idbarang' => $idbarang,
                    'jumlah' => (int) $barang['jumlah'][$i],
                    'harga' => str_replace(['Rp', '.', ' '], '', $barang['harga'][$i]),
                ];
                $this->DetailBundleModel->insert($data2);
            }
        }
        session()->setFlashData('sukses', 'Berhasil Input Data');
        return redirect()->to(base_url('bundle'));
    }

    public function edit($id)
    {
        $bundleLama = $this->BundleModel->getById($id);
        $detailBundleLama = $this->DetailBundleModel->getByBundleId($id);

        $data = array(
            'body' => 'bundle/edit',
            'bundle' => $bundleLama,
            'idbundlenya' => $id,
            'barang' => $this->BarangModel->semuaBarang(),
            'detail_bundle' => $detailBundleLama
        );
        return view('template', $data);
    }


    public function update()
    {
        $barang = $this->request->getPost('barang');
        $nama_bundle = $this->request->getPost('nama_bundle');
        $harga_total = (int) $this->request->getPost('harga_total');
        $idbundle = $this->request->getPost('idbundlenya');

        // Update bundle
        $data1 = [
            'nama_bundle' => $nama_bundle,
            'harga_total' => $harga_total,
            'harga_jual' => $harga_total
        ];
        $this->BundleModel->update($idbundle, $data1);

        // Ambil detail lama
        $detailLama = $this->DetailBundleModel->where('bundle_idbundle', $idbundle)->findAll();
        $detailLamaMap = [];
        foreach ($detailLama as $d) {
            $detailLamaMap[$d->barang_idbarang] = $d;
        }

        $barangBaruIds = [];

        if ($barang && isset($barang['kode_barang'])) {
            foreach ($barang['kode_barang'] as $i => $kode) {
                $databarang = $this->BarangModel->getBykode($kode);
                $idbarang = $databarang->idbarang;
                $barangBaruIds[] = $idbarang;

                $data2 = [
                    'bundle_idbundle' => $idbundle,
                    'barang_idbarang' => $idbarang,
                    'jumlah' => (int) $barang['jumlah'][$i],
                    'harga' => str_replace(['Rp', '.', ' '], '', $barang['harga'][$i]),
                ];

                if (isset($detailLamaMap[$idbarang])) {
                    // update jika sudah ada
                    $this->DetailBundleModel->update($detailLamaMap[$idbarang]->iddetail_bundle, $data2);
                } else {
                    // insert jika baru
                    $this->DetailBundleModel->insert($data2);
                }
            }
        }

        // Hapus detail yang sudah tidak ada di data baru
        foreach ($detailLama as $d) {
            if (!in_array($d->barang_idbarang, $barangBaruIds)) {
                $this->DetailBundleModel->delete($d->iddetail_bundle);
            }
        }

        session()->setFlashData('sukses', 'Berhasil Update Data');
        return redirect()->to(base_url('bundle'));
    }




    public function delete()
    {
        $idbundle = $this->request->getPost('idbundle');
        $this->BundleModel->delete($idbundle);
        $this->DetailBundleModel->deleteByBundle($idbundle);
    }
}
