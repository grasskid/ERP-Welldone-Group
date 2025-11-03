<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelSubKategori;
use Config\Database;
use App\Models\ModelAuth;

class Kategori extends BaseController

{

    protected $KategoriModel;
    protected $SubKategoriModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->SubKategoriModel = new ModelSubKategori();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $kategori = $this->KategoriModel->getKategori();
        
        // Get sub-categories for each category
        foreach ($kategori as $kat) {
            $kat->sub_kategori = $this->SubKategoriModel->getSubKategoriByParent($kat->id);
        }
        
        $data =  array(
            'akun' => $akun,
            'kategori' => $kategori,
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

    // Sub-Kategori CRUD Methods
    public function insert_sub_kategori()
    {
        $nama_sub_kategori = $this->request->getPost('nama_sub_kategori');
        $id_kategori_parent = $this->request->getPost('id_kategori_parent');

        $data = array(
            'nama_sub_kategori' => $nama_sub_kategori,
            'id_kategori_parent' => $id_kategori_parent,
            'delete' => '0'
        );

        $result = $this->SubKategoriModel->insert_SubKategori($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Sub Kategori Berhasil Di Simpan');
            return redirect()->to(base_url('/kategori'));
        }
    }

    public function update_sub_kategori()
    {
        $id = $this->request->getPost('idnya');
        $nama_sub_kategori = $this->request->getPost('nama_sub_kategori');

        $data = array(
            'nama_sub_kategori' => $nama_sub_kategori,
            'delete' => '0'
        );

        $result = $this->SubKategoriModel->updateSubKategori($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Sub Kategori Berhasil Di Update');
            return redirect()->to(base_url('/kategori'));
        }
    }

    public function delete_sub_kategori()
    {
        $id = $this->request->getPost('idnya');
        $data = array(
            'delete' => '1'
        );
        $result = $this->SubKategoriModel->updateSubKategori($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Sub Kategori Berhasil Di Hapus');
            return redirect()->to(base_url('/kategori'));
        }
    }
}
