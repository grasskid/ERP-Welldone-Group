<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use Config\Database;
use App\Models\ModelAuth;

class Approval extends BaseController

{

    protected $PhoneModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));

        $data =  array(
            'akun' => $akun,
            'phone' => $this->PhoneModel->getPhone(),
            'body'  => 'admin/approval'
        );
        return view('template', $data);
    }

    public function approve($id_phone)
    {

        $data = array(
            'status' => '1'
        );

        $result = $this->PhoneModel->update($id_phone, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/approval'));
        }
    }

    public function decline($id_phone)
    {
        $result = $this->PhoneModel->delete($id_phone);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/approval'));
        }
    }
}
