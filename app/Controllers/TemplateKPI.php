<?php

namespace App\Controllers;

use App\Models\ModelAuth;
use App\Models\ModelJabatan;
use App\Models\ModelTemplateKpi;

class TemplateKPI extends BaseController
{
    protected $AuthModel;
    protected $JabatanModel;
    protected $TemplateKpiModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->JabatanModel = new ModelJabatan();
        $this->TemplateKpiModel = new ModelTemplateKpi();
    }

    public function index()
    {
        $data = array(
            'jabatan' => $this->JabatanModel->getJabatan(),
            'templatekpi' => $this->TemplateKpiModel->getTemplateKPI(),
            'body' => 'penilaian/template_kpi',
        );
        return view('template', $data);
    }

    public function index2()
    {
        $data = array(
            'jabatan' => $this->JabatanModel->getJabatan(),
            'templatekpi' => $this->TemplateKpiModel->getTemplateGrading(),
            'body' => 'penilaian/template_grading',
        );
        return view('template', $data);
    }

    public function insert()
    {
        $data = [
            'template_kpi' => $this->request->getPost('template_kpi'),
            'bobot' => $this->request->getPost('bobot'),
            'formula' => $this->request->getPost('formula'),
            'jabatan_idjabatan' => $this->request->getPost('jabatan_idjabatan'),
            'created_on' => date('Y-m-d H:i:s'),
        ];

        $this->TemplateKpiModel->insert($data);
        return redirect()->to(base_url('template_kpi'))->with('sukses', 'Data berhasil disimpan');
    }

    public function update()
    {
        $id = $this->request->getPost('idtemplate_kpi');

        $data = [
            'template_kpi' => $this->request->getPost('template_kpi'),
            'bobot' => $this->request->getPost('bobot'),
            'formula' => $this->request->getPost('formula'),
            'jabatan_idjabatan' => $this->request->getPost('jabatan_idjabatan'),
            'update_on' => date('Y-m-d H:i:s'),
        ];

        $this->TemplateKpiModel->update($id, $data);
        return redirect()->to(base_url('template_kpi'))->with('sukses', 'Data berhasil diperbarui');
    }

    public function delete()
    {
        $id = $this->request->getPost('idtemplate_kpi');
        $this->TemplateKpiModel->delete($id);
        return redirect()->to(base_url('template_kpi'))->with('sukses', 'Data berhasil dihapus');
    }
}