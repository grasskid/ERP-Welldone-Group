<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelUnit;

class Kartu_Stok extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $UnitModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->UnitModel = new ModelUnit();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'stok' => $this->KartuStokModel->getKartuStokWithKategori(),
            'body'  => 'stok/kartu_stok',
            'unit' => $this->UnitModel->getUnit()
        );
        return view('template', $data);
    }

    public function export()
    {
        $tanggalAwal = $this->request->getPost('tanggal_awal');
        $tanggalAkhir = $this->request->getPost('tanggal_akhir');
        $unit = $this->request->getPost('unit');
        $statusPpn = $this->request->getPost('status_ppn');

        if (empty($tanggalAwal)) {
            $tanggalAwal = $this->KartuStokModel->getMinTanggalStok();
        }

        if (empty($tanggalAkhir)) {
            $tanggalAkhir = date('Y-m-d');
        }

        $stok = $this->KartuStokModel->exportfilter($tanggalAwal, $tanggalAkhir, $unit, $statusPpn);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Header Titles
        $headers = ['Kode Barang', 'Nama Barang', 'Status PPN', 'Unit', 'Stok Dasar', 'Tanggal Stok Dasar', 'Total Pembelian', 'Total Penjualan', 'Total Retur Pelanggan', 'Total Retur Supplier', 'Stok Akhir'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Apply bold & center to header row
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCE6F1');

        // Data Rows
        $row = 2;
        foreach ($stok as $item) {
            $sheet->setCellValue('A' . $row, $item->kode_barang);
            $sheet->setCellValue('B' . $row, $item->nama_barang);
            $sheet->setCellValue('C' . $row, ((int)$item->status_ppn === 1) ? 'PPN' : 'NON PPN');
            $sheet->setCellValue('D' . $row, $item->nama_unit);
            $sheet->setCellValue('E' . $row, $item->stok_dasar);
            $sheet->setCellValue('F' . $row, $item->tanggal_stok_dasar);
            $sheet->setCellValue('G' . $row, $item->total_pembelian);
            $sheet->setCellValue('H' . $row, $item->total_penjualan);
            $sheet->setCellValue('I' . $row, $item->total_retur_pelanggan);
            $sheet->setCellValue('J' . $row, $item->total_retur_supplier);
            $sheet->setCellValue('K' . $row, $item->stok_akhir);
            $row++;
        }

        // Auto-width for all columns A to K
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Apply border to all data (including header)
        $sheet->getStyle('A1:K' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Freeze header row
        $sheet->freezePane('A2');

        // File name logic
        $unitLabel = $unit ?: 'all_unit';
        $ppnLabel = $statusPpn ?: 'all_ppn';
        $tglAwalFormatted = date('Ymd', strtotime($tanggalAwal));
        $tglAkhirFormatted = date('Ymd', strtotime($tanggalAkhir));
        $filename = 'kartu_stok_' . $unitLabel . '_' . $ppnLabel . '_' . $tglAwalFormatted . '-' . $tglAkhirFormatted . '.xlsx';

        // Output headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
