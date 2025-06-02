<?php

namespace App\Controllers;

use App\Models\ModelKategori;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKerusakan;

class Kerusakan extends BaseController

{

    protected $KategoriModel;
    protected $AuthModel;
    protected $KerusakanModel;


    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
        $this->KerusakanModel = new ModelKerusakan();
    }

    public function index()
    {

        $data =  array(
            'kerusakan' => $this->KerusakanModel->getKerusakan(),
            'body'  => 'datamaster/kerusakan'
        );
        return view('template', $data);
    }

    public function insert_kerusakan()
    {

        $nama_kerusakan = $this->request->getPost('nama_kerusakan');

        $data = array(

            'nama_fungsi' => $nama_kerusakan,
            'delete' => '0'
        );

        $result = $this->KerusakanModel->insert_kerusakan($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/kerusakan'));
        }
    }

    public function update_kerusakan()
    {

        $id_kerusakan  = $this->request->getPost('id_kerusakan');
        $nama_kerusakan = $this->request->getPost('nama_kerusakan');

        $data = array(

            'nama_fungsi' => $nama_kerusakan,
            'delete' => '0'
        );

        $result = $this->KerusakanModel->update($id_kerusakan, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/kerusakan'));
        }
    }

    public function delete_kerusakan()
    {
        $id_kerusakan = $this->request->getPost('id_kerusakan');
        $data = array(
            'deleted' => '1'
        );
        $result = $this->KerusakanModel->update($id_kerusakan, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Hapus');
            return redirect()->to(base_url('/kerusakan'));
        }
    }
}
