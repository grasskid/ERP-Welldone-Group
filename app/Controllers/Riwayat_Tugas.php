<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelTugas;
use App\Models\ModelUnit;

class Riwayat_Tugas extends BaseController

{

    protected $AuthModel;
    protected $TugasModel;
    protected $UnitModel;


    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->TugasModel = new ModelTugas();
        $this->UnitModel = new ModelUnit();
    }

    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $idakun = $akun->ID_AKUN;

        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $id_unit       = $this->request->getGet('id_unit');

        $data = array(
            'akun'     => $akun,
            'tugas'    => $this->TugasModel->getAllTugasWithAkun2($idakun, $tanggal_awal, $tanggal_akhir, $id_unit),
            'units'    => $this->UnitModel->getUnit(),
            'tanggal_awal'  => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_unit'       => $id_unit,
            'body'     => 'HR/riwayat_tugas'
        );

        return view('template', $data);
    }
}
