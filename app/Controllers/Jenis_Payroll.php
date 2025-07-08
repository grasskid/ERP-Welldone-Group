<?php

namespace App\Controllers;

use App\Models\ModelPayroll;
use App\Models\ModelAuth;

class Jenis_Payroll extends BaseController
{
    protected $PayrollModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->PayrollModel = new ModelPayroll();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $data = [
            'akun'    => $akun,
            'Payroll' => $this->PayrollModel->getPayroll(),
            'body'    => 'datamaster/jenis_payroll'
        ];
        return view('template', $data);
    }

    public function insert_Payroll()
    {
        $data = [
            'idjenis_payroll' => $this->request->getPost('idjenis_payroll'),
            'nama_payroll'    => $this->request->getPost('nama_payroll'),
            'status_payroll'  => $this->request->getPost('status_payroll'),
            'keterangan'      => $this->request->getPost('keterangan')
        ];

        $result = $this->PayrollModel->insert_Payroll($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
        }
        return redirect()->to(base_url('/jenis_payroll'));
    }

    public function update_Payroll()
    {
        $id = $this->request->getPost('idjenis_payroll');

        $data = [
            'nama_payroll'   => $this->request->getPost('nama_payroll'),
            'status_payroll' => $this->request->getPost('status_payroll'),
            'keterangan'     => $this->request->getPost('keterangan')
        ];

        $result = $this->PayrollModel->update($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Diupdate');
        }
        return redirect()->to(base_url('/jenis_payroll'));
    }

    public function delete_Payroll()
    {
        $id = $this->request->getPost('idjenis_payroll');

        $result = $this->PayrollModel->delete($id);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Dihapus');
        }
        return redirect()->to(base_url('/jenis_payroll'));
    }
}