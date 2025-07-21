<?php

namespace App\Controllers;

use App\Models\ModelKategoriKas;
use Config\Database;
use App\Models\ModelAuth;

class Kategori_Kas extends BaseController
{
    protected $KategoriKasModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriKasModel = new ModelKategoriKas();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $data = array(
            'akun' => $akun,
            'kategorikas' => $this->KategoriKasModel->getKategoriKas(),
            'body' => 'jurnal/kategori_kas'
        );
        return view('template', $data);
    }

    public function insert_kategori()
    {
        $idkategori_kas = $this->request->getPost('idkategori_kas');
        $kategori = $this->request->getPost('kategori');
        $kode_template_jurnal = $this->request->getPost('kode_template_jurnal');
        $jenis_kas = $this->request->getPost('jenis_kas');

        $data = array(
            'idkategori_kas' => $idkategori_kas,
            'kategori' => $kategori,
            'kode_template_jurnal' => $kode_template_jurnal,
            'jenis_kas' => $jenis_kas,
        );

        $result = $this->KategoriKasModel->insert_KategoriKas($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
            return redirect()->to(base_url('/kategori_kas'));
        }
    }

    public function update_kategori()
    {
        $id = $this->request->getPost('idkategori_kas');
        $kategori = $this->request->getPost('kategori');
        $kode_template_jurnal = $this->request->getPost('kode_template_jurnal');
        $jenis_kas = $this->request->getPost('jenis_kas');

        $data = array(
            'kategori' => $kategori,
            'kode_template_kas' => $kode_template_kas,
            'jenis_kas' => $jenis_kas,
        );

        $result = $this->KategoriKasModel->update($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Diupdate');
            return redirect()->to(base_url('/kategori_kas'));
        }
    }

    public function delete_kategori()
    {
        $id = $this->request->getPost('idkategori_kas');

        $data = array(
            'delete' => '1'
        );

        $result = $this->KategoriKasModel->update($id, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Dihapus');
            return redirect()->to(base_url('/kategori_kas'));
        }
    }
}