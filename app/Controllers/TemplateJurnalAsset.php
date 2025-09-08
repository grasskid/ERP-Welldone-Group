<?php

namespace App\Controllers;

use App\Models\ModelKasKeluar;
use App\Models\ModelAuth;
use App\Models\ModelKategoriKas;
use App\Models\ModelNoAkun;
use App\Models\ModelBank;
use App\Models\ModelJurnal;
use App\Models\ModelTemplateJurnal;
use App\Models\ModelKategoriAsset;

class TemplateJurnalAsset extends BaseController
{
    protected $KasKeluarModel;
    protected $AuthModel;
    protected $KategoriKasModel;
    protected $NoAkunModel;
    protected $BankModel;
    protected $JurnalModel;
    protected $TemplateJurnalModel;
    protected $KategoriAssetModel;

    public function __construct()
    {
        $this->KasKeluarModel = new ModelKasKeluar();
        $this->AuthModel = new ModelAuth();
        $this->KategoriKasModel = new ModelKategoriKas();
        $this->NoAkunModel = new ModelNoAkun();
        $this->BankModel = new ModelBank();
        $this->JurnalModel = new ModelJurnal();
        $this->TemplateJurnalModel = new ModelTemplateJurnal();
        $this->KategoriAssetModel = new ModelKategoriAsset();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));

        $data = [
            'akun' => $akun,
            'template_jurnal_asset' => $this->TemplateJurnalModel->getTemplateJurnal(),
            'kategori_asset' => $this->KategoriAssetModel->getKategoriAsset(),
            'no_akun' =>  $this->NoAkunModel->getAkun(),
            'body' => 'jurnal/template_jurnal_asset'
        ];

        return view('template', $data);
    }

    public function insert()
    {
        $akunData = $this->request->getPost('akun');
        foreach ($akunData as $data) {
            $noakun = $data['no_akun'];
            $jenisakun = $data['jenis_akun'];
            $namaakun = $data['nama_akun'];
            $debet_kredit  = $data['jenis_jurnal'];

            $idkategori = $data['kategori_idkategori'];
            $kode_template = 'asset_penyusutan_' . $idkategori;


            $datatemplate = [
                'kode_template' => $kode_template,
                'no_akun' => $noakun,
                'nama_akun' => $namaakun,
                'debet_kredit' => $debet_kredit,
                'array_value' => 0
            ];

            $this->TemplateJurnalModel->insertTemplateJurnal($datatemplate);
        }

        session()->setFlashdata('sukses', 'Data kas keluar berhasil disimpan.');
        return redirect()->to(base_url('/template_jurnal_asset'));
    }

    public function delete()
    {
        $idtemplate_jurnal = $this->request->getPost('idtemplate_jurnal');
        $this->TemplateJurnalModel->delete($idtemplate_jurnal);
        session()->setFlashdata('sukses', 'Data kas keluar berhasil dihapus.');
        return redirect()->to(base_url('/template_jurnal_asset'));
    }
}
