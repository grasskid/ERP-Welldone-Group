<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelReturCustomer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\ModelService;

class RiwayatLabaService extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $AuthModel;
    protected $ReturCustomerModel;
    protected $ServiceModel;


    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
        $this->ReturCustomerModel = new ModelReturCustomer();
        $this->ServiceModel = new ModelService();
    }

    public function index()
    {
        $service = $this->ServiceModel->getServiceWithLaba();
        $data = array(
            'service' => $service,
            'body' => 'riwayat/laba_service'
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
        $dataservice = $this->ServiceModel->filterexportlaba($tanggal_awal, $tanggal_akhir);

        // Header kolom
        $headers = [
            'A1' => 'No. Service',
            'B1' => 'Tanggal Masuk',
            'C1' => 'Total Service',
            'D1' => 'Total DIskon',
            'E1' => 'Sub Total',
            'F1' => 'Laba Service',
            'G1' => 'Nama Teknisi'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Styling header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE2EFDA'); // Warna hijau muda

        // Tulis data ke baris berikutnya
        $row = 2;
        foreach ($dataservice as $item) {
            $sheet->setCellValue('A' . $row, $item->no_service);
            $sheet->setCellValue('B' . $row, $item->created_at);
            $sheet->setCellValue('C' . $row, $item->total_service);
            $sheet->setCellValue('D' . $row, $item->total_diskon);
            $sheet->setCellValue('E' . $row, $item->harus_dibayar);
            $sheet->setCellValue('F' . $row, $item->laba_service);
            $sheet->setCellValue('G' . $row, $item->nama_teknisi);
            $row++;
        }

        // Border seluruh tabel
        $sheet->getStyle('A1:G' . ($row - 1))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto-width untuk semua kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Format tanggal kolom B
        $sheet->getStyle('B2:B' . ($row - 1))
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');

        // Freeze header
        $sheet->freezePane('A2');

        // Nama file
        $filename = 'Riwayat_Laba_Service_' . date('Ymd_His') . '.xlsx';

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
