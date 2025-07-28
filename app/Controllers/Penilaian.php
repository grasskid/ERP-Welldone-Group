<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use App\Models\ModelPelanggan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelTemplatePenilaian;
use App\Models\ModelPenilaian;

class Penilaian extends BaseController

{

    protected $PhoneModel;
    protected $PelangganModel;
    protected $AuthModel;
    protected $TemplatePenilaianModel;
    protected $PenilaianModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->PelangganModel = new ModelPelanggan();
        $this->AuthModel = new ModelAuth();
        $this->TemplatePenilaianModel = new ModelTemplatePenilaian();
        $this->PenilaianModel = new ModelPenilaian();
    }

    public function index()
    {
        $data = array(
            'penilaian' => $this->PenilaianModel->getPenilaian(),
            'akun' => $this->AuthModel->getdataakun(),
            'body' => 'penilaian/penilaian',
        );
        return view('template', $data);
    }

    public function insert_penilaian()
    {
        $aspek = $this->request->getPost('aspek');
        $keterangan = $this->request->getPost('keterangan');
        $skor = $this->request->getPost('skor');
        $pegawai_idpegawai = $this->request->getPost('pegawai_idpegawai');
        $tanggal_penilaian = $this->request->getPost('tanggal_penilaian');

        $data = array(
            'aspek' => $aspek,
            'keterangan' => $keterangan,
            'skor' => $skor,
            'pegawai_idpegawai' => $pegawai_idpegawai,
            'tanggal_penilaian' => $tanggal_penilaian
        );
        $this->PenilaianModel->insertPenilaian($data);
        session()->setFlashData('sukses', 'Data Berhasil Ditambahkan');
        return redirect()->to(base_url('penilaian'));
    }


    public function update_penilaian()
    {

        $aspek = $this->request->getPost('aspek');
        $keterangan = $this->request->getPost('keterangan');
        $skor = $this->request->getPost('skor');
        $pegawai_idpegawai = $this->request->getPost('pegawai_idpegawai');
        $tanggal_penilaian = $this->request->getPost('tanggal_penilaian');
        $idpenilaian = $this->request->getPost('idpenilaian');

        $data = array(
            'aspek' => $aspek,
            'keterangan' => $keterangan,
            'skor' => $skor,
            'pegawai_idpegawai' => $pegawai_idpegawai,
            'tanggal_penilaian' => $tanggal_penilaian
        );
        $this->PenilaianModel->update($idpenilaian, $data);
        session()->setFlashData('sukses', 'Data Berhasil Diupdate');
        return redirect()->to(base_url('penilaian'));
    }

    public function delete_penilaian()
    {
        $idpenilaian = $this->request->getPost('id_penilaian');
        $this->PenilaianModel->delete($idpenilaian);
        session()->setFlashData('sukses', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('penilaian'));
    }

    public function export_penilaian()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $tanggal_awal  = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        $penilaianModel = new ModelPenilaian();
        $datapenilaian = $penilaianModel->getPenilaianByTanggal($tanggal_awal, $tanggal_akhir);

        // Set Header Excel
        $headers = [
            'A1' => 'Nama Akun',
            'B1' => 'Aspek',
            'C1' => 'Keterangan',
            'D1' => 'Skor',
            'E1' => 'Tanggal Penilaian',
            'F1' => 'Dibuat Pada',
            'G1' => 'Diupdate Pada',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCE6F1');

        $row = 2;
        foreach ($datapenilaian as $item) {
            $sheet->setCellValue('A' . $row, $item->NAMA_AKUN ?? '-');
            $sheet->setCellValue('B' . $row, $item->aspek);
            $sheet->setCellValue('C' . $row, $item->keterangan);
            $sheet->setCellValue('D' . $row, $item->skor);
            $sheet->setCellValue('E' . $row, date('d-m-Y', strtotime($item->tanggal_penilaian)));
            $sheet->setCellValue('F' . $row, date('d-m-Y H:i:s', strtotime($item->created_on ?? '-')));
            $sheet->setCellValue('G' . $row, date('d-m-Y H:i:s', strtotime($item->updated_on ?? '-')));
            $row++;
        }

        // Auto width
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $sheet->getStyle('A1:G' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->freezePane('A2');

        $filename = 'Data_Penilaian_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
