<?php

namespace App\Controllers;

use App\Models\ModelSuplier;
use App\Models\ModelUnit;
use App\Models\ModelAuth;

class Supplier extends BaseController
{
    protected $SuplierModel;
    protected $AuthModel;
    protected $UnitModel;

    public function __construct()
    {
        $this->SuplierModel = new ModelSuplier();
        $this->AuthModel = new ModelAuth();
        $this->UnitModel = new ModelUnit();
    }
    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data = [
            'title' => 'Supplier',
            'akun' => $akun,
            'body' => 'datamaster/supplier',
            'suplier' => $this->SuplierModel->getSuplier(),
            'unit' => $this->UnitModel->getUnit()

        ];
        return view('template', $data);
    }

    public function insert_suplier()
    {
        $nama_suplier = $this->request->getPost('nama_suplier');
        $alanat = $this->request->getPost('alamat');
        $no_hp = $this->request->getPost('no_hp');
        $data = array(
            'nama_suplier' => $nama_suplier,
            'alamat' => $alanat,
            'no_hp' => $no_hp,
            'deleted' => '0',
            'unit_idunit' => session('ID_UNIT')
        );
        $result = $this->SuplierModel->insert_Suplier($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/supplier'));
        }
    }

    public function update_suplier()
    {
        $id_suplier = $this->request->getPost('id_suplier');
        $nama_suplier = $this->request->getPost('nama_suplier');
        $alanat = $this->request->getPost('alamat');
        $no_hp = $this->request->getPost('no_hp');

        $data = array(
            'nama_suplier' => $nama_suplier,
            'alamat' => $alanat,
            'no_hp' => $no_hp,
            'deleted' => '0'
        );
        $result = $this->SuplierModel->update($id_suplier, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/supplier'));
        }
    }

    public function delete_suplier()
    {
        $id_suplier = $this->request->getPost('id_suplier');
        $data = array(
            'deleted' => '1'
        );
        $result = $this->SuplierModel->update($id_suplier, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Hapus');
            return redirect()->to(base_url('/supplier'));
        }
    }
}
