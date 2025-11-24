<?php

namespace App\Controllers;

use App\Models\ModelTugasTemplate;
use App\Models\ModelAuth;
use App\Models\ModelJabatan;
use App\Models\ModelTemplatePenilaian;

class TemplateTugas extends BaseController
{
    protected $AuthModel;
    protected $TugasTemplateModel;
    protected $JabatanModel;
    protected $PenilaianTemplateModel;

    public function __construct()
    {
        $this->AuthModel              = new ModelAuth();
        $this->TugasTemplateModel     = new ModelTugasTemplate();
        $this->JabatanModel           = new ModelJabatan();
        $this->PenilaianTemplateModel = new ModelTemplatePenilaian();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $idakun = $akun->ID_AKUN;

        $data = [
            'body' => 'HR/template_tugas',
            'tugas_template' => $this->TugasTemplateModel->getTugasTemplateByAkun($idakun),
            'penilaian_template' => $this->PenilaianTemplateModel->getTemplatePenilaian(),
            'jabatan' => (new ModelJabatan())->getJabatan()
        ];
        return view('template', $data);
    }

    public function insert()
    {
        $jabatanId = $this->request->getPost('ID_JABATAN');
        $namaTugas = $this->request->getPost('nama_tugas');

        $templatePenilaian = $this->PenilaianTemplateModel
            ->where('jabatan_idjabatan', $jabatanId)
            ->where('aspek_penilaian', $namaTugas)
            ->first();

        $data = [
            'nama_tugas'  => $namaTugas,
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'start_date'  => $this->request->getPost('start_date'),
            'end_date'    => $this->request->getPost('end_date'),
            'ID_JABATAN'  => $jabatanId,
            'template_penilaian_idtemplate_penilaian' => $templatePenilaian ? $templatePenilaian->idtemplate_penilaian : null
        ];

        $this->TugasTemplateModel->insertTugasTemplate($data);
        session()->setFlashdata('sukses', 'Berhasil menambahkan Template Tugas');
        return redirect()->to(base_url('template_tugas'));
    }

    public function update()
    {
        $id = $this->request->getPost('idtemplate_tugas');

        $data = [
            'nama_tugas'  => $this->request->getPost('nama_tugas'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'start_date'  => $this->request->getPost('start_date'),
            'end_date'    => $this->request->getPost('end_date'),
            'ID_JABATAN'  => $this->request->getPost('ID_JABATAN') // From form input
        ];

        $this->TugasTemplateModel->update($id, $data);
        session()->setFlashdata('sukses', 'Berhasil mengupdate Template Tugas');
        return redirect()->to(base_url('template_tugas'));
    }
}