<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use App\Models\ModelPelanggan;
use App\Models\ModelPenilaianKPI;
use App\Models\ModelAuth;
use App\Models\ModelTemplatePenilaian;
use App\Models\ModelTemplateKpi;
use App\Models\ModelPenilaian;
use App\Models\ModelPenjualan;
use App\Models\ModelPresensi;
use App\Models\ModelDetailPenjualan;
use App\Models\ModelPenilaianDetail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KeyPerformance extends BaseController
{
    protected $AuthModel;
    protected $TemplatePenilaianModel;
    protected $PenilaianKPIModel;
    protected $TemplateKpiModel;
    protected $PenilaianModel;
    protected $PenjualanModel;
    protected $PresensiModel;
    protected $DetailPenjualanModel;
    protected $PenilaianDetailModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->TemplatePenilaianModel = new ModelTemplatePenilaian();
        $this->PenilaianKPIModel = new ModelPenilaianKPI();
        $this->TemplateKpiModel = new ModelTemplateKpi();
        $this->PenilaianModel = new ModelPenilaian();
        $this->PenjualanModel = new ModelPenjualan();
        $this->PresensiModel = new ModelPresensi();
        $this->DetailPenjualanModel = new ModelDetailPenjualan();
        $this->PenilaianDetailModel = new ModelPenilaianDetail();
    }

public function index()
{
    $pegawai_id = $this->request->getGet('pegawai_idpegawai');
    $templatekpi = [];
    $skorMap = [];
    $isUpdate = false;
    $unit_idunit = null;
    $kpiExistingMap = [];
    $idpenilaianList = [];
    $levelList = [];
    $templateIdList = [];
    $prefillList = [];

    if ($pegawai_id) {
        $pegawai = $this->AuthModel->getById($pegawai_id);

        if ($pegawai && isset($pegawai->ID_JABATAN)) {
            $templatekpi = $this->TemplateKpiModel->getByJabatanLevel2($pegawai->ID_JABATAN);
            $unit_idunit = $pegawai->ID_UNIT ?? null;

            $tanggalPenilaian = $this->request->getGet('tanggal_penilaian_kpi') ?? date('Y-m-d');
            $bulan = date('m', strtotime($tanggalPenilaian));
            $tahun = date('Y', strtotime($tanggalPenilaian));
            $startDate = date('Y-m-01', strtotime("$tahun-$bulan-01"));
            $endDate   = date('Y-m-t', strtotime("$tahun-$bulan-01"));

            // Get all penilaian for this pegawai and this month
            $penilaianList = $this->PenilaianKPIModel
                ->where('pegawai_idpegawai', $pegawai_id)
                ->where('tanggal_penilaian_kpi >=', $startDate)
                ->where('tanggal_penilaian_kpi <=', $endDate)
                ->findAll();

            // Build map by template ID AND month
            foreach ($penilaianList as $p) {
                $kpiExistingMap[$p->template_kpi_idtemplate_kpi] = $p;
                $idpenilaianList[] = $p->idpenilaian_kpi;
                $levelList[] = $p->level;

                // Fill skorMap for pre-filling form
                $skorMap[$p->template_kpi_idtemplate_kpi] = $p->score ?? '';
            }

            // Prefill data for each template
            foreach ($templatekpi as $tpl) {
                $templateIdList[] = $tpl->idtemplate_kpi;

                // Only mark as existing if a penilaian exists for this template this month
                $existing = $kpiExistingMap[$tpl->idtemplate_kpi] ?? null;

                $prefillList[$tpl->idtemplate_kpi] = [
                    'idpenilaian_kpi' => $existing->idpenilaian_kpi ?? '',
                    'realisasi'       => $existing->realisasi ?? '',
                    'level'           => $existing->level ?? $tpl->level,
                ];
            }

            // Only true if every displayed template already has a penilaian this month
            $isUpdate = !empty($templatekpi) && !array_diff($templateIdList, array_keys($kpiExistingMap));


        }
    }

    $data = [
        'penilaiankpi'       => $penilaianList ?? [],
        'akun'               => $this->AuthModel->getdataakun(),
        'pegawai_idpegawai'  => $pegawai_id,
        'templatekpi'        => $templatekpi,
        'skorMap'            => $skorMap,
        'isUpdate'           => $isUpdate,
        'unit_idunit'        => $unit_idunit,
        'idpenilaianList'    => $idpenilaianList,
        'levelList'          => $levelList,
        'templateIdList'     => $templateIdList,
        'prefillList'        => $prefillList,
        'body'               => 'penilaian/key_performance',
    ];

    return view('template', $data);
}

public function insert_penilaian()
{
    $kpiList        = $this->request->getPost('kpi_utama');
    $bobotList      = $this->request->getPost('bobot');
    $targetList     = $this->request->getPost('target');
    $realisasiList  = $this->request->getPost('realisasi');
    $scoreList      = $this->request->getPost('score');
    $levelList      = $this->request->getPost('level');
    $unitIdList     = $this->request->getPost('unit_idunit');
    $templateIdList = $this->request->getPost('template_kpi_idtemplate_kpi');

    $pegawai_id = $this->request->getPost('pegawai_idpegawai');
    $tanggal    = $this->request->getPost('tanggal_penilaian_kpi');

    if ($kpiList && is_array($kpiList)) {
        $batchInsert = [];

        foreach ($kpiList as $i => $kpi) {
            $batchInsert[] = [
                'kpi_utama'                   => $kpi,
                'bobot'                       => $bobotList[$i] ?? null,
                'target'                      => $targetList[$i] ?? null,
                'realisasi'                   => $realisasiList[$i] ?? 0,
                'score'                       => $scoreList[$i] ?? 0,
                'level'                       => $levelList[$i] ?? null,
                'unit_idunit'                 => $unitIdList[$i] ?? null,
                'template_kpi_idtemplate_kpi' => $templateIdList[$i] ?? null,
                'pegawai_idpegawai'           => $pegawai_id,
                'tanggal_penilaian_kpi'       => $tanggal,
                'created_on'                  => date('Y-m-d H:i:s'),
            ];
        }

        $this->PenilaianKPIModel->insertBatch($batchInsert);
    }

    session()->setFlashdata('sukses', 'Data Berhasil Ditambahkan');
    return redirect()->to(base_url('key_performance'));
}




public function update_penilaian()
{
    $ids            = $this->request->getPost('idpenilaian_kpi'); // existing ids
    $kpiList        = $this->request->getPost('kpi_utama');
    $bobotList      = $this->request->getPost('bobot');
    $targetList     = $this->request->getPost('target');
    $realisasiList  = $this->request->getPost('realisasi');
    $scoreList      = $this->request->getPost('score');
    $levelList      = $this->request->getPost('level');
    $unitIdList     = $this->request->getPost('unit_idunit');
    $templateIdList = $this->request->getPost('template_kpi_idtemplate_kpi');

    $pegawai_id     = $this->request->getPost('pegawai_idpegawai');
    $tanggal        = $this->request->getPost('tanggal_penilaian_kpi');

    if (!$ids || !is_array($ids)) {
        session()->setFlashdata('error', 'Data tidak lengkap atau ID tidak ditemukan.');
        return redirect()->to(base_url('penilaian_kpi'));
    }

    // Delete existing records based on pegawai_id and date range
    $bulan = date('m', strtotime($tanggal));
    $tahun = date('Y', strtotime($tanggal));
    $startDate = date('Y-m-01', strtotime("$tahun-$bulan-01"));
    $endDate   = date('Y-m-t', strtotime("$tahun-$bulan-01"));

    $this->PenilaianKPIModel
        ->where('pegawai_idpegawai', $pegawai_id)
        ->where('tanggal_penilaian_kpi >=', $startDate)
        ->where('tanggal_penilaian_kpi <=', $endDate)
        ->delete();

    // Insert fresh rows
    foreach ($kpiList as $i => $kpi) {
        $this->PenilaianKPIModel->insert([
            'kpi_utama'                    => $kpi,
            'bobot'                        => $bobotList[$i] ?? null,
            'target'                       => $targetList[$i] ?? null,
            'realisasi'                    => $realisasiList[$i] ?? 0,
            'score'                        => $scoreList[$i] ?? 0,
            'level'                        => $levelList[$i] ?? null,
            'unit_idunit'                  => $unitIdList[$i] ?? null,
            'template_kpi_idtemplate_kpi'  => $templateIdList[$i] ?? null,
            'pegawai_idpegawai'            => $pegawai_id,
            'tanggal_penilaian_kpi'        => $tanggal,
            'created_on'                   => date('Y-m-d H:i:s'),
        ]);
    }

    session()->setFlashdata('sukses', 'Data Berhasil Diubah');
    return redirect()->to(base_url('key_performance'));
}


}