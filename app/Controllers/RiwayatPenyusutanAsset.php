<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelUnit;
use App\Models\ModelJurnal;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Mpdf\Mpdf;
use App\Models\ModelRiwayatAsset;

class RiwayatPenyusutanAsset extends BaseController
{
    protected $PhoneModel;
    protected $AuthModel;
    protected $UnitModel;
    protected $JurnalModel;
    protected $RiwayatAssetModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->AuthModel = new ModelAuth();
        $this->UnitModel = new ModelUnit();
        $this->JurnalModel = new ModelJurnal();
        $this->RiwayatAssetModel = new ModelRiwayatAsset();
    }

    public function index()
    {
        $data = array(
            'penyusutan' => $this->RiwayatAssetModel->getRiwayatAsset(),
            'body' => 'riwayat/penyusutan_asset'
        );
        return view('template', $data);
    }
}
