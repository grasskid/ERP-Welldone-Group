<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kartu_Stok extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'stok' => $this->KartuStokModel->getKartuStokWithKategori(),
            'body'  => 'stok/kartu_stok'
        );
        return view('template', $data);
    }

    public function export()
    {

        $stok = $this->KartuStokModel->getKartuStok();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Kode Barang');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Unit');
        $sheet->setCellValue('D1', 'Stok Dasar');
        $sheet->setCellValue('E1', 'Tanggal Stok Dasar');
        $sheet->setCellValue('F1', 'Total Pembelian');
        $sheet->setCellValue('G1', 'Total Penjualan');
        $sheet->setCellValue('H1', 'Total Retur Pelanggan');
        $sheet->setCellValue('I1', 'Total Retur Supplier');
        $sheet->setCellValue('J1', 'Stok Akhir');

        // Data
        $row = 2;
        foreach ($stok as $item) {
            $sheet->setCellValue('A' . $row, $item->kode_barang);
            $sheet->setCellValue('B' . $row, $item->nama_barang);
            $sheet->setCellValue('C' . $row, $item->nama_unit);
            $sheet->setCellValue('D' . $row, $item->stok_dasar);
            $sheet->setCellValue('E' . $row, $item->tanggal_stok_dasar);
            $sheet->setCellValue('F' . $row, $item->total_pembelian);
            $sheet->setCellValue('G' . $row, $item->total_penjualan);
            $sheet->setCellValue('H' . $row, $item->total_retur_pelanggan);
            $sheet->setCellValue('I' . $row, $item->total_retur_supplier);
            $sheet->setCellValue('J' . $row, $item->stok_akhir);
            $row++;
        }

        // Output Excel
        $filename = 'kartu_stok_' . date('Ymd_His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
