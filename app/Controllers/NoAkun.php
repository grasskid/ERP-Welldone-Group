<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelUnit;
use App\Models\ModelNoAkun;

class NoAkun extends BaseController

{
    protected $AuthModel;
    protected $UnitModel;

    protected $NoAkunModel;



    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->UnitModel = new ModelUnit();
        $this->NoAkunModel = new ModelNoAkun();
    }

    public function index()
    {
        $data = array(
            'body' => 'datamaster/noakun',
            'noakun' => $this->NoAkunModel->getAkun()
        );
        return view('template', $data);
    }

    public function insert()
    {
        $noakun = $this->request->getPost('no_akun');
        $nama_akun = $this->request->getPost('nama_akun');
        $jenis_akun = $this->request->getPost('jenis_akun');


        $existing = $this->NoAkunModel->where('no_akun', $noakun)->first();

        if ($existing) {
            session()->setFlashdata('gagal', 'Nomor Akun sudah digunakan!');
            return redirect()->back()->withInput();
        }

        $data = [
            'no_akun' => $noakun,
            'nama_akun' => $nama_akun,
            'jenis_akun' => $jenis_akun
        ];

        $this->NoAkunModel->insert($data);
        session()->setFlashdata('sukses', 'Berhasil Tambahkan Data');
        return redirect()->to(base_url('datamaster_akun'));
    }

    public function update()
    {
        $noakun = $this->request->getPost('noakun');
        $nama_akun = $this->request->getPost('nama_noakun');
        $jenis_akun = $this->request->getPost('jenis_noakun');

        $data = [
            'nama_akun' => $nama_akun,
            'jenis_akun' => $jenis_akun
        ];

        $this->NoAkunModel->update($noakun, $data);
        session()->setFlashdata('sukses', 'Berhasil Tambahkan Data');
        return redirect()->to(base_url('datamaster_akun'));
    }
}
