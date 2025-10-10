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

class PenilaianKPI extends BaseController
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

        if ($pegawai_id) {
            $pegawai = $this->AuthModel->getById($pegawai_id);

            if ($pegawai && isset($pegawai->ID_JABATAN)) {
                $templatekpi = $this->TemplateKpiModel->getByJabatan($pegawai->ID_JABATAN);

                // Get penilaian
                $penilaianList = $this->PenilaianModel
                    ->where('pegawai_idpegawai', $pegawai_id)
                    ->findAll();

                foreach ($penilaianList as $p) {
                    $skorMap[$p->aspek]['realisasi'] = $p->skor;
                }

                $bulanIni = date('Y-m-01');
                $bulanAkhir = date('Y-m-t');

                //Omset

                $omsetResult = $this->PenjualanModel
                    ->selectSum('total_penjualan')
                    ->where('sales_by', $pegawai_id)
                    ->where('tanggal >=', $bulanIni)
                    ->where('tanggal <=', $bulanAkhir)
                    ->first();

                $omsetValue = $omsetResult->total_penjualan ?? 0;

                $skorMap['Penjualan(Omzet)']['realisasi'] = $omsetValue;

                $tanggalPenilaian = $this->request->getGet('tanggal_penilaian_kpi') ?? date('Y-m-d');

                $bulan = date('m', strtotime($tanggalPenilaian));
                $tahun = date('Y', strtotime($tanggalPenilaian));
                $startDate = date('Y-m-01', strtotime("$tahun-$bulan-01"));
                $endDate = date('Y-m-t', strtotime("$tahun-$bulan-01"));

                $onTimeResult = $this->PresensiModel
                    ->countOnTimeAbsensiPerBulan($pegawai_id, $startDate, $endDate);
                $onTimeCount = $onTimeResult->total_ontime ?? 0;
                $skorMap['Kedisiplinan']['realisasi'] = $onTimeCount;

                $absensiResult = $this->PresensiModel
                    ->countAbsensiPerBulan($pegawai_id, $startDate, $endDate);
                $jumlahAbsensi = $absensiResult->total_absensi ?? 0;
                $skorMap['Kehadiran']['realisasi'] = $jumlahAbsensi;

                $groomingResult = $this->PresensiModel
                    ->countGrooming($pegawai_id, $startDate, $endDate);
                $jumlahGrooming = $groomingResult->total_grooming ?? 0;
                $skorMap['Grooming']['realisasi'] = $jumlahGrooming;

                $categoryResult = $this->DetailPenjualanModel
                    ->countByCategory(2, $startDate, $endDate);
                $totalCategory = $categoryResult->total_category ?? 0;
                $skorMap['Up-selling dan Cross-selling']['realisasi'] = $totalCategory;

                //media
                $jumlahByTemplate = $this->PenilaianKPIModel->getJumlahByTemplateKPI($pegawai_id);

                foreach ($jumlahByTemplate as $row) {
                    $skorMap[$row->template_kpi]['realisasi'] = $row->jumlah;
                }


            }
        }

        $data = [
            'penilaiankpi' => [],
            'akun' => $this->AuthModel->getdataakun(),
            'pegawai_idpegawai' => $pegawai_id,
            'templatekpi' => $templatekpi,
            'skorMap' => $skorMap,
            'body' => 'penilaian/penilaian_kpi',
        ];

        return view('template', $data);
    }

    public function index_riwayat()
    {
        // Ambil semua penilaian_kpi
        $riwayat = $this->PenilaianKPIModel
            ->select('penilaian_kpi.*, penilaian_kpi.penilaian_idpenilaian, akun.NAMA_AKUN as pegawai_nama, jabatan.NAMA_JABATAN as jabatan_nama, unit.NAMA_UNIT as unit_nama')
            ->join('akun', 'akun.ID_AKUN = penilaian_kpi.pegawai_idpegawai', 'left')
            ->join('jabatan', 'jabatan.ID_JABATAN = akun.ID_JABATAN', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->orderBy('penilaian_kpi.created_on', 'ASC')
            ->findAll();


        foreach ($riwayat as $row) {
            // Ambil detail KPI sesuai penilaian_kpi
            $detail = $this->PenilaianKPIModel
                ->select('kpi_utama, bobot, target, realisasi, score')
                ->where('idpenilaian_kpi', $row->idpenilaian_kpi)
                ->orderBy('kpi_utama', 'ASC')
                ->findAll();

            $totalScore = 0;
            if (!empty($detail)) {
                foreach ($detail as $d) {
                    $totalScore += (float) $d->score;
                }
            }

            // Ambil aspek_detail dari penilaian_detail
            // ✅ Gunakan penilaian_idpenilaian yang ada di penilaian_kpi
            $aspek_detail = $this->PenilaianDetailModel
                ->select('template_penilaian.aspek_penilaian, penilaian_detail.skor')
                ->join('template_penilaian', 'template_penilaian.idtemplate_penilaian = penilaian_detail.template_penilaian_idtemplate_penilaian', 'left')
                ->where('penilaian_detail.penilaian_idpenilaian', $row->penilaian_idpenilaian)
                ->findAll();

            // Assign ke objek row
            $row->detail = $detail ?: [];
            $row->total_score = $totalScore;
            $row->aspek_detail = $aspek_detail ?: [];
        }

        // Group per pegawai + created_on + jabatan + unit
        $grouped_riwayat = [];
        foreach ($riwayat as $row) {
            $key = $row->pegawai_nama . '|' . $row->created_on . '|' . $row->jabatan_nama . '|' . $row->unit_nama;
            $grouped_riwayat[$key][] = $row;
        }

        $data = [
            'title' => 'Riwayat Penilaian KPI',
            'riwayat' => $riwayat,
            'grouped_riwayat' => $grouped_riwayat,
            'body' => 'penilaian/riwayat_penilaian_KPI',
        ];

        return view('template', $data);
        // return $this->response->setJSON($grouped_riwayat);

    }

public function export_penilaian_detail()
{
    $tanggal_awal = $this->request->getPost('tanggal_awal');
    $tanggal_akhir = $this->request->getPost('tanggal_akhir');

    // Build query safely (only add date filters if provided)
    $query = $this->PenilaianKPIModel
        ->select('penilaian_kpi.idpenilaian_kpi,
              penilaian_kpi.tanggal_penilaian_kpi,
              penilaian_kpi.kpi_utama,
              penilaian_kpi.bobot,
              penilaian_kpi.target,
              penilaian_kpi.realisasi,
              penilaian_kpi.score,
              penilaian_kpi.penilaian_idpenilaian,
              akun.NAMA_AKUN as pegawai_nama,
              jabatan.NAMA_JABATAN as jabatan_nama,
              unit.NAMA_UNIT as unit_nama')
        ->join('akun', 'akun.ID_AKUN = penilaian_kpi.pegawai_idpegawai', 'left')
        ->join('jabatan', 'jabatan.ID_JABATAN = akun.ID_JABATAN', 'left')
        ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
        ->orderBy('penilaian_kpi.tanggal_penilaian_kpi', 'DESC');

    if (!empty($tanggal_awal)) {
        $query->where('penilaian_kpi.tanggal_penilaian_kpi >=', $tanggal_awal);
    }
    if (!empty($tanggal_akhir)) {
        $query->where('penilaian_kpi.tanggal_penilaian_kpi <=', $tanggal_akhir);
    }

    $rows = $query->findAll();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    if (empty($rows)) {
        $sheet->setCellValue('A1', 'Tidak ada data untuk rentang tanggal yang dipilih.');
        $filename = 'Penilaian_KPI_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // Group by pegawai + tanggal + jabatan + unit
    $grouped = [];
    foreach ($rows as $r) {
        $pegawai = $r->pegawai_nama ?? '-';
        $tanggal = $r->tanggal_penilaian_kpi ?? '-';
        $jabatan = $r->jabatan_nama ?? '-';
        $unit = $r->unit_nama ?? '-';

        $key = $pegawai . '|' . $tanggal . '|' . $jabatan . '|' . $unit;
        $grouped[$key][] = $r;
    }

    $boldStyle = ['font' => ['bold' => true]];
    $headerFill = [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'DCE6F1']
    ];

    // 💠 Light Blue for Pegawai Section
    $pegawaiFill = [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'BDD7EE'] // Light blue
    ];

    $rowNum = 1;

    foreach ($grouped as $key => $items) {
        list($pegawai, $tanggal, $jabatan, $unit) = explode('|', $key);

        // 💠 Pegawai Section (with background color)
        $sheet->setCellValue('A' . $rowNum, 'Pegawai');
        $sheet->setCellValue('B' . $rowNum, $pegawai);
        $sheet->getStyle("A{$rowNum}:B{$rowNum}")->applyFromArray($boldStyle);
        $sheet->getStyle("A{$rowNum}:B{$rowNum}")->getFill()->applyFromArray($pegawaiFill);
        $rowNum++;

        $sheet->setCellValue('A' . $rowNum, 'Jabatan');
        $sheet->setCellValue('B' . $rowNum, $jabatan);
        $sheet->getStyle('A' . $rowNum)->applyFromArray($boldStyle);
        $sheet->getStyle("A{$rowNum}:B{$rowNum}")->getFill()->applyFromArray($pegawaiFill);
        $rowNum++;

        $sheet->setCellValue('A' . $rowNum, 'Unit');
        $sheet->setCellValue('B' . $rowNum, $unit);
        $sheet->getStyle('A' . $rowNum)->applyFromArray($boldStyle);
        $sheet->getStyle("A{$rowNum}:B{$rowNum}")->getFill()->applyFromArray($pegawaiFill);
        $rowNum++;

        $sheet->setCellValue('A' . $rowNum, 'Tanggal Penilaian');
        $sheet->setCellValue('B' . $rowNum, ($tanggal && $tanggal !== '-') ? date('d-m-Y', strtotime($tanggal)) : '-');
        $sheet->getStyle('A' . $rowNum)->applyFromArray($boldStyle);
        $sheet->getStyle("A{$rowNum}:B{$rowNum}")->getFill()->applyFromArray($pegawaiFill);
        $rowNum++;

        $rowNum++;

        // Detail header
        $sheet->setCellValue('A' . $rowNum, 'KPI Utama');
        $sheet->setCellValue('B' . $rowNum, 'Bobot');
        $sheet->setCellValue('C' . $rowNum, 'Target');
        $sheet->setCellValue('D' . $rowNum, 'Realisasi');
        $sheet->setCellValue('E' . $rowNum, 'Score');
        $sheet->getStyle("A{$rowNum}:E{$rowNum}")->applyFromArray($boldStyle);
        $sheet->getStyle("A{$rowNum}:E{$rowNum}")->getFill()->applyFromArray($headerFill);
        $rowNum++;

        $totalScore = 0.0;

        foreach ($items as $item) {
            $sheet->setCellValue('A' . $rowNum, $item->kpi_utama ?? '-');
            $sheet->setCellValue('B' . $rowNum, $item->bobot ?? '-');
            $sheet->setCellValue('C' . $rowNum, $item->target ?? '-');
            $sheet->setCellValue('D' . $rowNum, $item->realisasi ?? '-');
            $sheet->setCellValue('E' . $rowNum, $item->score ?? 0);
            $totalScore += (float) ($item->score ?? 0);
            $rowNum++;

            // ✅ Show aspek_detail only if KPI = Checklist Pekerjaan
            if ($item->kpi_utama === 'Checklist Pekerjaan' && !empty($item->penilaian_idpenilaian)) {
                $aspekList = $this->PenilaianDetailModel
                    ->select('template_penilaian.aspek_penilaian, penilaian_detail.skor')
                    ->join('template_penilaian', 'template_penilaian.idtemplate_penilaian = penilaian_detail.template_penilaian_idtemplate_penilaian', 'left')
                    ->where('penilaian_detail.penilaian_idpenilaian', $item->penilaian_idpenilaian)
                    ->findAll();

                if (!empty($aspekList)) {
                    $sheet->setCellValue('B' . $rowNum, 'Aspek Penilaian');
                    $sheet->setCellValue('C' . $rowNum, 'Skor');
                    $sheet->getStyle("B{$rowNum}:C{$rowNum}")->applyFromArray($boldStyle);
                    $rowNum++;

                    foreach ($aspekList as $aspek) {
                        $sheet->setCellValue('B' . $rowNum, $aspek->aspek_penilaian);
                        $sheet->setCellValue('C' . $rowNum, $aspek->skor);
                        $rowNum++;
                    }
                }
            }
        }

        // Total row
        $sheet->setCellValue('D' . $rowNum, 'Total Score');
        $sheet->setCellValue('E' . $rowNum, $totalScore);
        $sheet->getStyle("D{$rowNum}:E{$rowNum}")->applyFromArray($boldStyle);
        $rowNum += 2;
    }

    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $lastRow = $rowNum - 1;
    $sheet->getStyle("A1:E{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    $filename = 'Riwayat_Penilaian_KPI_' . date('Ymd_His') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


public function insert_penilaian()
{
    $kpiList       = $this->request->getPost('kpi_utama');
    $bobotList     = $this->request->getPost('bobot');
    $targetList    = $this->request->getPost('target');
    $realisasiList = $this->request->getPost('realisasi');
    $scoreList     = $this->request->getPost('score');

    $pegawai_id = $this->request->getPost('pegawai_idpegawai');
    $tanggal    = $this->request->getPost('tanggal_penilaian_kpi');

    // 1️⃣ Fetch or create parent "Checklist Pekerjaan"
    $parent = $this->PenilaianModel
        ->where('pegawai_idpegawai', $pegawai_id)
        ->where('tanggal_penilaian', $tanggal)
        ->where('aspek', 'Checklist Pekerjaan')
        ->first();

    if (!$parent) {
        $parent_id = $this->PenilaianModel->insert([
            'pegawai_idpegawai' => $pegawai_id,
            'tanggal_penilaian' => $tanggal,
            'aspek'            => 'Checklist Pekerjaan',
            'keterangan'       => 'Penilaian KPI',
            'created_on'       => date('Y-m-d H:i:s'),
        ]);
    } else {
        $parent_id = $parent->idpenilaian;
    }

    // 2️⃣ Insert KPI rows linked to parent
    if ($kpiList && is_array($kpiList)) {
       foreach ($kpiList as $i => $kpi) {
    $this->PenilaianKPIModel->insertKPI(
        $kpi,
        $bobotList[$i] ?? null,
        $targetList[$i] ?? null,
        [$realisasiList[$i] ?? 0],
        [$scoreList[$i] ?? 0],
        $pegawai_id,
        $tanggal,
        $parent_id // pass the parent id so it links
    );
}

    }

    session()->setFlashdata('sukses', 'Data Berhasil Ditambahkan');
    return redirect()->to(base_url('penilaian_kpi'));
}


    //     public function insert_penilaian()
// {
//     $kpiList = $this->request->getPost('kpi_utama');
//     $bobotList = $this->request->getPost('bobot');
//     $targetList = $this->request->getPost('target');
//     $realisasiList = $this->request->getPost('realisasi');
//     $scoreList = $this->request->getPost('score');

    //     $pegawai_id = $this->request->getPost('pegawai_idpegawai');
//     $tanggal = $this->request->getPost('tanggal_penilaian_kpi');

    //     if ($kpiList && is_array($kpiList)) {
//         foreach ($kpiList as $i => $kpi) {
//             $this->PenilaianKPIModel->insertKPI(
//                 $kpi,
//                 $bobotList[$i] ?? null,
//                 $targetList[$i] ?? null,
//                 [$realisasiList[$i] ?? 0],
//                 [$scoreList[$i] ?? 0],
//                 $pegawai_id,
//                 $tanggal
//             );
//         }
//     }

    //     session()->setFlashdata('sukses', 'Data Berhasil Ditambahkan');
//     return redirect()->to(base_url('penilaian_kpi'));
// }



    public function update_penilaian()
    {
        $id = $this->request->getPost('idpenilaian_kpi');

        $data = [
            'kpi_utama' => $this->request->getPost('kpi_utama'),
            'bobot' => $this->request->getPost('bobot'),
            'target' => $this->request->getPost('target'),
            'realisasi' => $this->request->getPost('realisasi'),
            'score' => $this->request->getPost('score'),
            'pegawai_idpegawai' => $this->request->getPost('pegawai_idpegawai'),
            'tanggal_penilaian_kpi' => $this->request->getPost('tanggal_penilaian_kpi'),
            'updated_on' => date('Y-m-d H:i:s'),
        ];

        $this->PenilaianKPIModel->update($id, $data);
        session()->setFlashdata('sukses', 'Data Berhasil Diupdate');
        return redirect()->to(base_url('penilaian'));
    }

    public function delete_penilaian()
    {
        $id = $this->request->getPost('idpenilaian_kpi');
        $this->PenilaianKPIModel->delete($id);
        session()->setFlashdata('sukses', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('penilaian'));
    }

    public function export_penilaian()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        $data = $this->PenilaianKPIModel
            ->where('tanggal_penilaian_kpi >=', $tanggal_awal)
            ->where('tanggal_penilaian_kpi <=', $tanggal_akhir)
            ->findAll();

        $headers = [
            'A1' => 'KPI Utama',
            'B1' => 'Bobot',
            'C1' => 'Target',
            'D1' => 'Realisasi',
            'E1' => 'Score',
            'F1' => 'Tanggal Penilaian',
            'G1' => 'Dibuat Pada',
            'H1' => 'Diupdate Pada',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCE6F1');

        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->kpi_utama);
            $sheet->setCellValue('B' . $row, $item->bobot);
            $sheet->setCellValue('C' . $row, $item->target);
            $sheet->setCellValue('D' . $row, $item->realisasi);
            $sheet->setCellValue('E' . $row, $item->score);
            $sheet->setCellValue('F' . $row, date('d-m-Y', strtotime($item->tanggal_penilaian_kpi)));
            $sheet->setCellValue('G' . $row, $item->created_on ? date('d-m-Y H:i:s', strtotime($item->created_on)) : '-');
            $sheet->setCellValue('H' . $row, $item->updated_on ? date('d-m-Y H:i:s', strtotime($item->updated_on)) : '-');
            $row++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getStyle('A1:H' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->freezePane('A2');

        $filename = 'Penilaian_KPI_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}