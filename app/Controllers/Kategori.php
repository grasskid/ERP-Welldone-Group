<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use Config\Database;
use App\Models\ModelAuth;

class Kategori extends BaseController

{

    protected $KategoriModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'body'  => 'datamaster/kategori'
        );
        return view('template', $data);
    }

    public function insert_kategori()
    {
        $idkategori = $this->request->getPost('idkategori');
        $nama_kategori = $this->request->getPost('nama_kategori');

        $data = array(
            'idkategori' => $idkategori,
            'nama_kategori' => $nama_kategori,
            'delete' => '0'
        );

        $result = $this->KategoriModel->insert_kategori($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/kategori'));
        }
    }

    public function update_kategori()
    {
        $id = $this->request->getPost('idnya');

        $nama_kategori = $this->request->getPost('nama_kategori');

        $data = array(

            'nama_kategori' => $nama_kategori,
            'delete' => '0'
        );

        $result = $this->KategoriModel->update($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/kategori'));
        }
    }

    public function delete_kategori()
    {
        $id = $this->request->getPost('idnya');
        $idkategori = $this->request->getPost('idkategori');
        $data = array(
            'delete' => '1'
        );
        $result = $this->KategoriModel->update($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Hapus');
            return redirect()->to(base_url('/kategori'));
        }
    }
}
