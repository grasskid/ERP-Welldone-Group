<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelBarang;
use App\Models\ModelAuth;
use App\Models\ModelUnit;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelNamaHandphone;

class NamaHandphone extends BaseController

{

    protected $PhoneModel;
    protected $BarangModel;
    protected $AuthModel;
    protected $NamaHandphoneModel;
    protected $UnitModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->BarangModel = new ModelBarang();
        $this->AuthModel = new ModelAuth();
        $this->NamaHandphoneModel = new ModelNamaHandphone();
        $this->UnitModel = new ModelUnit();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'namahandphone' => $this->NamaHandphoneModel->getNamaHandphone(),
            'body'  => 'datamaster/namahandphone',
            'unit' => $this->UnitModel->getUnit()
        );

        return view('template', $data);
    }

    public function insert_namaphone()
    {
        $nama   = $this->request->getPost('nama');
        $type   = $this->request->getPost('type');
        $size      = $this->request->getPost('size');

        $data = [
            'nama' => $nama,
            'type'       => $type,
            'size'   => $size
        ];

        $result = $this->NamaHandphoneModel->insert($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
            return redirect()->to(base_url('/namahandphone'));
        }
    }

    public function update_namaphone()
    {
        $id     = $this->request->getPost('id');
        $nama   = $this->request->getPost('nama');
        $type   = $this->request->getPost('type');
        $size   = $this->request->getPost('size');

        $data = [
            'nama' => $nama,
            'type'       => $type,
            'size'   => $size
        ];
        if ($this->NamaHandphoneModel->update($id, $data)) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Di Simpan');
        }
        return redirect()->to(base_url('/namahandphone'));
    }

    public function delete_namaphone()
    {
        $id = $this->request->getPost('id');
        $result =  $this->NamaHandphoneModel->delete($id);
        if ($result) {
            session()->setFlashData('sukses', 'Data Berhasil Diperbarui');
            return redirect()->to(base_url('/namahandphone'));
        } else {
            session()->setFlashData('gagal', 'Gagal memperbarui data.');
            return redirect()->back()->withInput();
        }
    }
}