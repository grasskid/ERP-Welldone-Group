<?php

namespace App\Controllers;

use App\Models\ModelJadwalMasuk;
use App\Models\ModelAuth;

class JadwalMasuk extends BaseController
{
    protected $JadwalMasukModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->JadwalMasukModel = new ModelJadwalMasuk();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $data = [
            'akun' => $akun,
            'body' => 'absensi/jadwal_masuk',
            'jadwal' => $this->JadwalMasukModel->getAll()
        ];
        return view('template', $data);
    }

    public function insert_jadwal()
    {
        $data = $this->request->getPost([
            'nama_jadwal',
            'jam_masuk',
            'jam_pulang',
            'total_jamkerja',
            'jml_wfh',
            'jml_wfo',
            'jenis',
            'toleransi'
        ]);

        if ($this->JadwalMasukModel->insert($data)) {
            return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan jadwal.');
        }
    }

    public function update_jadwal()
    {
        $id = $this->request->getPost('idjadwal_masuk');

        $data = $this->request->getPost([
            'nama_jadwal',
            'jam_masuk',
            'jam_pulang',
            'total_jamkerja',
            'jml_wfh',
            'jml_wfo',
            'jenis',
            'toleransi'
        ]);

        if ($this->JadwalMasukModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui jadwal.');
        }
    }

    public function delete_jadwal()
    {
        $id = $this->request->getPost('idjadwal_masuk');

        if ($this->JadwalMasukModel->delete($id)) {
            return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus jadwal.');
        }
    }
}