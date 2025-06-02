<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKerusakan;
use App\Models\ModelKartuStok;
use App\Models\ModelPelanggan;
use App\Models\ModelService;
use App\Models\ModelServiceKerusakan;
use App\Models\ModelServiceSparepart;
use App\Models\ModelStokBarang;
use App\Models\ModelHppBarang;
use App\Models\ModelStokAwal;

class Expired_service extends BaseController

{

    protected $AuthModel;
    protected $KerusakanModel;
    protected $KartuStokModel;
    protected $PelangganModel;
    protected $ServiceModel;
    protected $ServiceKerusakanModel;
    protected $ServiceSparepartModel;
    protected $StokBarangModel;
    protected $HppBarangModel;
    protected $StokAwalModel;



    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KerusakanModel = new ModelKerusakan();
        $this->KartuStokModel = new ModelKartuStok();
        $this->PelangganModel = new ModelPelanggan();
        $this->ServiceModel = new ModelService();
        $this->ServiceKerusakanModel = new ModelServiceKerusakan();
        $this->ServiceSparepartModel = new ModelServiceSparepart();
        $this->StokBarangModel = new ModelStokBarang();
        $this->HppBarangModel = new ModelHppBarang();
        $this->StokAwalModel = new ModelStokAwal();
    }

    public function index()
    {
        $data =  array(

            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'service' => $this->ServiceModel->getRiwayatService(),
            'body'  => 'riwayat/expired_service'
        );
        return view('template', $data);
    }
}