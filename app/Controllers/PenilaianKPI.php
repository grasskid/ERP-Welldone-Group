<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use App\Models\ModelPelanggan;
use App\Models\ModelPenilaianKPI;
use App\Models\ModelAuth;
use App\Models\ModelTemplatePenilaian;
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

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->TemplatePenilaianModel = new ModelTemplatePenilaian();
        $this->PenilaianKPIModel = new ModelPenilaianKPI();
    }

    public function index()
    {
        $data = [
            'penilaiankpi' => $this->PenilaianKPIModel->getAllKPI(),
            'akun' => $this->AuthModel->getdataakun(),
            'body' => 'penilaian/penilaian_kpi',
        ];
        return view('template', $data);
    }

    public function insert_penilaian()
    {
        $data = [
            'kpi_utama' => $this->request->getPost('kpi_utama'),
            'bobot' => $this->request->getPost('bobot'),
            'target' => $this->request->getPost('target'),
            'realisasi' => $this->request->getPost('realisasi'),
            'score' => $this->request->getPost('score'),
            'pegawai_idpegawai' => $this->request->getPost('pegawai_idpegawai'),
            'tanggal_penilaian_kpi' => $this->request->getPost('tanggal_penilaian_kpi'),
            'created_on' => date('Y-m-d H:i:s'),
        ];

        $this->PenilaianKPIModel->insertKPI($data);
        session()->setFlashdata('sukses', 'Data Berhasil Ditambahkan');
        return redirect()->to(base_url('penilaian'));
    }

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

        $tanggal_awal  = $this->request->getPost('tanggal_awal');
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