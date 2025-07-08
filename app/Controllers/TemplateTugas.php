<?php

namespace App\Controllers;

use App\Models\ModelTugasTemplate;
use App\Models\ModelAuth;

class TemplateTugas extends BaseController
{
    protected $AuthModel;
    protected $TugasTemplateModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->TugasTemplateModel = new ModelTugasTemplate();
    }

    public function index()
    {
        $data = [
            'body' => 'HR/template_tugas',
            'tugas_template' => $this->TugasTemplateModel->getTugasTemplate()
        ];
        return view('template', $data);
    }

    public function insert()
    {
        $data = [
            'nama_tugas' => $this->request->getPost('nama_tugas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            // Optional: include ID_JABATAN if your form includes it
            // 'ID_JABATAN' => $this->request->getPost('ID_JABATAN')
        ];

        $this->TugasTemplateModel->insertTugasTemplate($data);
        session()->setFlashdata('sukses', 'Berhasil menambahkan Template Tugas');
        return redirect()->to(base_url('template_tugas'));
    }

    public function update()
    {
        $id = $this->request->getPost('idtemplate_tugas');
        $data = [
            'nama_tugas' => $this->request->getPost('nama_tugas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            // Optional: include ID_JABATAN if needed
        ];

        $this->TugasTemplateModel->update($id, $data);
        session()->setFlashdata('sukses', 'Berhasil mengupdate Template Tugas');
        return redirect()->to(base_url('template_tugas'));
    }
}