<?php

namespace App\Controllers;

use App\Models\ModelAsset;
use App\Models\ModelPhone;
use Config\Database;
use App\Models\ModelAuth;



class Asset extends BaseController

{

    protected $PhoneModel;
    protected $AuthModel;
    protected $AssetModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->AuthModel = new ModelAuth();
        $this->AssetModel = new ModelAsset();
    }

    public function index()
    {
        $data = array(
            'body' => 'datamaster/asset',
            'asset' => $this->AssetModel->getAsset()
        );
        return view('template', $data);
    }


    public function insert_asset()
    {

        $asset_code = $this->request->getPost('asset_code');
        $asset = $this->request->getPost('asset');
        $tanggal_perolehan = $this->request->getPost('tanggal_perolehan');
        $nilai_perolehan = str_replace('.', '', $this->request->getPost('nilai_perolehan'));
        $penyusutan_bulanan = str_replace('.', '', $this->request->getPost('penyusutan_bulanan'));
        $nilai_sekarang = str_replace('.', '', $this->request->getPost('nilai_sekarang'));
        $kondisi = $this->request->getPost('kondisi');
        $keterangan = $this->request->getPost('keterangan');

        $data = [
            'asset_code' => $asset_code,
            'asset' => $asset,
            'tanggal_perolehan' => $tanggal_perolehan,
            'nilai_perolehan' => $nilai_perolehan,
            'penyusutan_bulanan' => $penyusutan_bulanan,
            'nilai_sekarang' => $nilai_sekarang,
            'kondisi' => $kondisi,
            'keterangan' => $keterangan,

        ];

        $result = $this->AssetModel->insert_Asset($data);

        if ($result) {
            session()->setFlashdata('sukses', 'Data Asset berhasil disimpan.');
        } else {
            session()->setFlashdata('gagal', 'Data Asset gagal disimpan.');
        }

        return redirect()->to(base_url('/asset'));
    }

    public function update_asset()
    {
        $idnya = $this->request->getPost('id_asset');
        $asset_code = $this->request->getPost('asset_code');
        $asset = $this->request->getPost('asset');
        $tanggal_perolehan = $this->request->getPost('tanggal_perolehan');
        $nilai_perolehan = str_replace('.', '', $this->request->getPost('nilai_perolehan'));
        $penyusutan_bulanan = str_replace('.', '', $this->request->getPost('penyusutan_bulanan'));
        $nilai_sekarang = str_replace('.', '', $this->request->getPost('nilai_sekarang'));
        $kondisi = $this->request->getPost('kondisi');
        $keterangan = $this->request->getPost('keterangan');




        $data = [
            'asset_code' => $asset_code,
            'asset' => $asset,
            'tanggal_perolehan' => $tanggal_perolehan,
            'nilai_perolehan' => $nilai_perolehan,
            'penyusutan_bulanan' => $penyusutan_bulanan,
            'nilai_sekarang' => $nilai_sekarang,
            'kondisi' => $kondisi,
            'keterangan' => $keterangan,

        ];

        $result = $this->AssetModel->update($idnya, $data);

        if ($result) {
            session()->setFlashdata('sukses', 'Data Asset berhasil disimpan.');
        } else {
            session()->setFlashdata('gagal', 'Data Asset gagal disimpan.');
        }

        return redirect()->to(base_url('/asset'));
    }

    public function delete_asset()
    {
        $idnya = $this->request->getPost('id_asset');
        $result = $this->AssetModel->delete($idnya);
        session()->setFlashdata('sukses', 'Data Asset berhasil dihapus.');
        return redirect()->to(base_url('/asset'));
    }

    function cleanRupiah($value)
    {

        $value = str_replace(['Rp', '.',], '', $value);
        return (int) $value;
    }
}
