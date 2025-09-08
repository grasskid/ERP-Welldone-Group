<?php

namespace App\Controllers;

use App\Models\ModelAsset;
use App\Models\ModelPhone;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelRiwayatAsset;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelKategoriAsset;



class KategoriAsset extends BaseController

{

    protected $PhoneModel;
    protected $AuthModel;
    protected $AssetModel;
    protected $RiwayatAssetModel;
    protected $KategoriAssetModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->AuthModel = new ModelAuth();
        $this->AssetModel = new ModelAsset();
        $this->RiwayatAssetModel = new ModelRiwayatAsset();
        $this->KategoriAssetModel = new ModelKategoriAsset();
    }

    public function index()
    {
        $data = array(
            'body' => 'datamaster/kategori_asset',
            'kategori_asset' => $this->KategoriAssetModel->getKategoriAsset()
        );
        return view('template', $data);
    }


    public function insert()
    {
        $namakategori = $this->request->getPost('kategori_asset');
        $data = array(
            'kategori_asset' => $namakategori,
            'deleted' => '0'
        );
        $this->KategoriAssetModel->insertAsset($data);
        session()->setFlashData('sukses', 'Data berhasil disimpan');
        return redirect()->to(base_url('kategori_asset'));
    }

    public function udpatekategori()
    {
        $id_kategori_asset = $this->request->getPost('id_kategori_asset');
        $namakategori = $this->request->getPost('kategori_asset');
        $data = array(
            'kategori_asset' => $namakategori
        );
        $this->KategoriAssetModel->update($id_kategori_asset, $data);
        session()->setFlashData('sukses', 'Data berhasil disimpan');
        return redirect()->to(base_url('kategori_asset'));
    }

    public function deletekategori()
    {
        $id_kategori_asset = $this->request->getPost('id_kategori_asset');
        $namakategori = $this->request->getPost('kategori_asset');
        $data = array(

            'deleted' => '1'
        );
        $this->KategoriAssetModel->update($id_kategori_asset, $data);
        session()->setFlashData('sukses', 'Data berhasil disimpan');
        return redirect()->to(base_url('kategori_asset'));
    }
}
