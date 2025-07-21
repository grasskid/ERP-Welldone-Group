<?php

namespace App\Controllers;

use App\Models\ModelKasKeluar;
use App\Models\ModelAuth;
use App\Models\ModelKategoriKas;

class Kas_Keluar extends BaseController
{
    protected $KasKeluarModel;
    protected $AuthModel;
    protected $KategoriKasModel;

    public function __construct()
    {
        $this->KasKeluarModel = new ModelKasKeluar();
        $this->AuthModel = new ModelAuth();
        $this->KategoriKasModel = new ModelKategoriKas();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));

        $data = [
            'akun' => $akun,
            'kas_keluar' => $this->KasKeluarModel->getKasKeluar(),
            'kategori_kas' => $this->KategoriKasModel->getKategoriKas(),
            'body' => 'jurnal/kas_keluar'
        ];

        return view('template', $data);
    }

    public function insert_kas_keluar()
    {
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'kategori_idkategori' => $this->request->getPost('kategori_idkategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'penerima' => $this->request->getPost('penerima'),
            'idunit' => session('idunit'),
            'created_on' => date('Y-m-d H:i:s')
        ];

        $this->KasKeluarModel->insert_KasKeluar($data);
        session()->setFlashdata('sukses', 'Data kas keluar berhasil disimpan.');
        return redirect()->to(base_url('/kas_keluar'));
    }

    public function update_kas_keluar()
    {
        $id = $this->request->getPost('idkas_keluar');

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'kategori_idkategori' => $this->request->getPost('kategori_idkategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'penerima' => $this->request->getPost('penerima'),
            'updated_on' => date('Y-m-d H:i:s')
        ];

        $this->KasKeluarModel->update($id, $data);
        session()->setFlashdata('sukses', 'Data kas keluar berhasil diupdate.');
        return redirect()->to(base_url('/kas_keluar'));
    }

    public function delete_kas_keluar()
    {
        $id = $this->request->getPost('idkas_keluar');
        $this->KasKeluarModel->delete($id);
        session()->setFlashdata('sukses', 'Data kas keluar berhasil dihapus.');
        return redirect()->to(base_url('/kas_keluar'));
    }
}