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

class SisiKeuangan extends BaseController
{
    protected $PhoneModel;
    protected $AuthModel;
    protected $UnitModel;
    protected $JurnalModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->AuthModel = new ModelAuth();
        $this->UnitModel = new ModelUnit();
        $this->JurnalModel = new ModelJurnal();
    }

    // laporan jurnal
    public function index()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        $unit = $this->UnitModel->getUnit();

        $tanggal_awal = $this->request->getGet('startDate') ?: null;
        $tanggal_akhir = $this->request->getGet('endDate') ?: null;
        $id_unit = $this->request->getGet('filterUnit') ?: null;

        $data = array(
            'akun' => $akun,
            'data_parent' => $this->JurnalModel->getSummaryPerParent($tanggal_awal, $tanggal_akhir, $id_unit),
            'data_grand_parent' => $this->JurnalModel->getTotalGrandparent($tanggal_awal, $tanggal_akhir, $id_unit),
            'data_unit' => $unit,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_unit' => $id_unit,
            'body' => 'jurnal/sisi_keuangan'
        );

        return view('template', $data);
    }

    public function export_pdf()
    {
        $tanggal_awal = $this->request->getGet('startDate');
        $tanggal_akhir = $this->request->getGet('endDate');
        $id_unit = $this->request->getGet('filterUnit');

        $data = [
            'data_parent' => $this->JurnalModel->getSummaryPerParent($tanggal_awal, $tanggal_akhir, $id_unit),
            'data_grand_parent' => $this->JurnalModel->getTotalGrandparent($tanggal_awal, $tanggal_akhir, $id_unit),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_unit' => $id_unit,
        ];



        $html = view('cetak/posisi_keuangan', $data);

        error_reporting(0);

        $mpdf = new \Mpdf\Mpdf(['curlUserAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:108.0) Gecko/20100101 Firefox/108.0']);

        ob_end_clean();

        $mpdf->curlAllowUnsafeSslRequests = true;

        $this->response->setHeader('Content-Type', 'application/pdf');

        $this->response->setHeader('Content-Transfer-Encoding', 'binary');

        $this->response->setHeader('Accept-Ranges', 'bytes');

        $mpdf->WriteHTML($html);

        return redirect()->to($mpdf->Output());
    }
}
