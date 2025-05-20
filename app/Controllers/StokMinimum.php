<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelStokBarang;

class StokMinimum extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $StokBarangModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->StokBarangModel = new ModelStokBarang();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'stok' => $this->KartuStokModel->getKartuStokWithKategori(),
            'body'  => 'stok/stok_minimum'
        );
        return view('template', $data);
    }

    public function update()
    {
        $idunit = $this->request->getPost('idunit');
        $idbarang = $this->request->getPost('idbarang');
        $stokminimum = $this->request->getPost('stokminimum');


        if (!$idunit || !$idbarang || !$stokminimum) {
            session()->setFlashdata('error', 'Semua field wajib diisi.');
            return redirect()->back();
        }


        $result = $this->StokBarangModel->updateStokMinimum($idunit, $idbarang, $stokminimum);

        if ($result) {
            session()->setFlashdata('sukses', 'Data berhasil disimpan');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan data');
        }

        return redirect()->to(base_url('/stok_minimum'));
    }
}
