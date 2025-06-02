<?php

namespace App\Controllers;

use App\Models\ModelKategori;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKerusakan;
use App\Models\ModelPelanggan;

class NotifikasiService extends BaseController

{

    protected $PelangganModel;

    public function __construct()
    {
        $this->PelangganModel = new ModelPelanggan();
    }

    public function index()
    {
        $data = array(
            'body' => 'notifikasi/pengambilan_service',
            'pelanggan' => $this->PelangganModel->getPelangganWithService()
        );
        return view('template', $data);
    }
}
