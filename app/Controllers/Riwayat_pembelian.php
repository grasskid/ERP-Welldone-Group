<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use Config\Database;
use App\Models\ModelAuth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Riwayat_pembelian extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {

        $detail_pembelian = $this->DetailPembelianModel->getDetailAll();
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));

        $data = array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'detail_pembelian' => $detail_pembelian,
            'body'  => 'riwayat/pembelian'
        );

        return view('template', $data);
    }

    public function export()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $unit = $this->request->getPost('unit');
        $tanggal_awal = $this->request->getPost('tanggal_awal');;
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        $datapembelian = $this->DetailPembelianModel->exportfilter($tanggal_awal, $tanggal_akhir, $unit);

        // Header
        $sheet->setCellValue('A1', 'No. Nota Suplier');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Unit');
        $sheet->setCellValue('F1', 'Diskon');
        $sheet->setCellValue('G1', 'PPN');
        $sheet->setCellValue('H1', 'Total Harga');

        // Data 
        $row = 2;
        foreach ($datapembelian as $item) {
            $sheet->setCellValue('A' . $row, $item->no_batch);
            $sheet->setCellValue('B' . $row, $item->tanggal);
            $sheet->setCellValue('C' . $row, $item->nama_barang);
            $sheet->setCellValue('D' . $row, $item->jumlah);
            $sheet->setCellValue('E' . $row, $item->NAMA_UNIT);
            $sheet->setCellValue('F' . $row, $item->diskon);
            $sheet->setCellValue('G' . $row, $item->ppn);
            $sheet->setCellValue('H' . $row, $item->total_harga);
            $row++;
        }

        // Output Excel
        $filename = 'Riwayat_Pembelian_' . date('Ymd_His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
