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

class Riwayat_ReturPenjualan extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $AuthModel;
    protected $ReturCustomerModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->AuthModel = new ModelAuth();
        $this->ReturCustomerModel = new ModelReturCustomer();
    }

    public function index()
    {

        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $returpenjualan = $this->ReturCustomerModel->getReturPenjualan();

        $data = array(
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'retur_penjualan' => $returpenjualan,
            'body'  => 'riwayat/retur_penjualan'
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

        $datapembelian = $this->ReturCustomerModel->exportfilter($tanggal_awal, $tanggal_akhir, $unit);

        // Header
        $sheet->setCellValue('A1', 'No. Retur Pelanggan');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Unit');

        // Data 
        $row = 2;
        foreach ($datapembelian as $item) {
            $sheet->setCellValue('A' . $row, $item->no_retur_pelanggan);
            $sheet->setCellValue('B' . $row, $item->tanggal);
            $sheet->setCellValue('C' . $row, $item->nama_barang);
            $sheet->setCellValue('D' . $row, $item->jumlah);
            $sheet->setCellValue('E' . $row, $item->NAMA_UNIT);;
            $row++;
        }

        // Output Excel
        $filename = 'Riwayat_Retur_Penjualan_' . date('Ymd_His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
