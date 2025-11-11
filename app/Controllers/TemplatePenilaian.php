<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use App\Models\ModelPelanggan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelTemplatePenilaian;
use App\Models\ModelJabatan;
use App\Models\ModelTemplateKpi;

class TemplatePenilaian extends BaseController
{
    protected $PhoneModel;
    protected $PelangganModel;
    protected $AuthModel;
    protected $TemplatePenilaianModel;
    protected $JabatanModel;
    protected $TemplateKpiModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->PelangganModel = new ModelPelanggan();
        $this->AuthModel = new ModelAuth();
        $this->TemplatePenilaianModel = new ModelTemplatePenilaian();
        $this->JabatanModel = new ModelJabatan();
        $this->TemplateKpiModel = new ModelTemplateKpi();
    }

    public function index()
    {
        $data = [
            'penilaian' => $this->TemplatePenilaianModel->getTemplatePenilaian(),
            'body' => 'penilaian/template_penilaian',
            'jabatan' => $this->JabatanModel->getJabatan(),
            'template' => $this->TemplateKpiModel->getTemplateKpi(),
        ];
        return view('template', $data);
    }

    public function insert()
    {
        $aspek_penilaian = 'Checklist Pekerjaan'; // 🔒 locked value
        $keterangan_penilaian = $this->request->getPost('keterangan');
        $jabatan_idjabatan = $this->request->getPost('jabatan_idjabatan');
        $idtemplate_kpi = $this->request->getPost('aspek_kpi');
        $target = $this->request->getPost('target');
        $bobot = $this->request->getPost('bobot');

        $data = [
            'aspek_penilaian' => $aspek_penilaian,
            'keterangan_penilaian' => $keterangan_penilaian,
            'jabatan_idjabatan' => $jabatan_idjabatan,
            'idtemplate_kpi' => $idtemplate_kpi,
            'target' => $target,
            'bobot' => $bobot,
        ];

        $this->TemplatePenilaianModel->insertTemplatePenilaian($data);
        return redirect()->to(base_url('template_penilaian'))->with('sukses', 'Data Berhasil Disimpan');
    }

    public function update()
    {
        $idtemplate_penilaian = $this->request->getPost('idtemplate_penilaian');
        $aspek_penilaian = 'Checklist Pekerjaan'; // 🔒 locked value
        $keterangan_penilaian = $this->request->getPost('keterangan');
        $jabatan_idjabatan = $this->request->getPost('jabatan_idjabatan');
        $idtemplate_kpi = $this->request->getPost('aspek_kpi');
        $target = $this->request->getPost('target');
        $bobot = $this->request->getPost('bobot');

        $data = [
            'aspek_penilaian' => $aspek_penilaian,
            'keterangan_penilaian' => $keterangan_penilaian,
            'jabatan_idjabatan' => $jabatan_idjabatan,
            'idtemplate_kpi' => $idtemplate_kpi,
            'target' => $target,
            'bobot' => $bobot,
        ];

        $this->TemplatePenilaianModel->update($idtemplate_penilaian, $data);
        return redirect()->to(base_url('template_penilaian'))->with('sukses', 'Data Berhasil Diperbarui');
    }

    public function delete()
    {
        $idtemplate_penilaian = $this->request->getPost('idtemplate_penilaian');
        $this->TemplatePenilaianModel->delete($idtemplate_penilaian);
        return redirect()->to(base_url('template_penilaian'))->with('sukses', 'Data Berhasil Dihapus');
    }
}