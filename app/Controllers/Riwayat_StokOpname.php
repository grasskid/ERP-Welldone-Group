<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\ModelStokOpname;
use App\Models\ModelStokOpnameDraft;

class Riwayat_StokOpname extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $StokOpnameModel;
    protected $StokOpnameDraftModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->StokOpnameModel = new ModelStokOpname();
        $this->StokOpnameDraftModel = new ModelStokOpnameDraft();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'stok' => $this->KartuStokModel->getKartuStok(),
            'stokopname' => $this->StokOpnameModel->getStokOpnameAll(),
            'stokopnamedraft' => $this->StokOpnameDraftModel->getStokOpname(),
            'body'  => 'riwayat/stok_opname'
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

        $dataopname = $this->StokOpnameModel->exportfilter($tanggal_awal, $tanggal_akhir, $unit);

        // Header
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Nama Unit');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah Komputer');
        $sheet->setCellValue('E1', 'Jumlah Real');
        $sheet->setCellValue('F1', 'Jumlah Selisih');

        // Data 
        $row = 2;
        foreach ($dataopname as $item) {
            $sheet->setCellValue('A' . $row, $item->tanggal);
            $sheet->setCellValue('B' . $row, $item->NAMA_UNIT);
            $sheet->setCellValue('C' . $row, $item->nama_barang);
            $sheet->setCellValue('D' . $row, $item->jumlah_komp);
            $sheet->setCellValue('E' . $row, $item->jumlah_real);
            $sheet->setCellValue('F' . $row, $item->jumlah_selisih);
            $row++;
        }

        // Output Excel
        $filename = 'Riwayat_Stok_Opname_' . date('Ymd_His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
