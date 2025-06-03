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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
            'service' => $this->ServiceModel->getExpiredService(),
            'body'  => 'riwayat/expired_service'
        );
        return view('template', $data);
    }


    public function export()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $tanggal_awal  = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        // Ambil data dari model
        $dataservice = $this->ServiceModel->getExpiredServiceByRange($tanggal_awal, $tanggal_akhir);

        // Header kolom
        $headers = [
            'A1' => 'No. Service',
            'B1' => 'Tanggal Masuk',
            'C1' => 'Tanggal Selesai',
            'D1' => 'Nama Pelanggan',
            'E1' => 'Total Service',
            'F1' => 'Total DIskon',
            'G1' => 'Sub Total',
            'H1' => 'Total Bayar',
            'I1' => 'Nama Teknisi'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Styling header
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE2EFDA'); // Warna hijau muda

        // Tulis data ke baris berikutnya
        $row = 2;
        foreach ($dataservice as $item) {
            $sheet->setCellValue('A' . $row, $item->no_service);
            $sheet->setCellValue('B' . $row, $item->created_at);
            $sheet->setCellValue('C' . $row, $item->tanggal_selesai);
            $sheet->setCellValue('D' . $row, $item->nama_pelanggan);
            $sheet->setCellValue('E' . $row, $item->total_service);
            $sheet->setCellValue('F' . $row, $item->total_diskon);
            $sheet->setCellValue('G' . $row, $item->harus_dibayar);
            $sheet->setCellValue('H' . $row, $item->bayar);
            $sheet->setCellValue('I' . $row, $item->nama_service_by);
            $row++;
        }

        // Border seluruh tabel
        $sheet->getStyle('A1:I' . ($row - 1))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto-width untuk semua kolom
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Format tanggal kolom B
        $sheet->getStyle('B2:B' . ($row - 1))
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');

        // Freeze header
        $sheet->freezePane('A2');

        // Nama file
        $filename = 'Riwayat_Expired_Service_' . date('Ymd_His') . '.xlsx';

        // Header untuk response browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Output file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
