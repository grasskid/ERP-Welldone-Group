<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelPembelian;
use App\Models\ModelStokAwal;
use App\Models\ModelDetailPembelian;
use App\Models\ModelSuplier;
use App\Models\ModelMutasiStok;
use App\Models\ModelUnit;
use App\Models\ModelHppBarang;
use App\Models\ModelDetailMutasi;

class Riwayat_MutasiStok extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $BarangModel;
    protected $KategoriModel;
    protected $SuplierModel;
    protected $PembelianModel;
    protected $StokAwalModel;
    protected $DetailPembelianModel;
    protected $MutasiStokModel;
    protected $UnitModel;
    protected $HppBarangModel;
    protected $DetailMutasiModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->BarangModel = new ModelBarang();
        $this->KategoriModel = new ModelKategori();
        $this->SuplierModel = new ModelSuplier();
        $this->PembelianModel = new ModelPembelian();
        $this->StokAwalModel = new ModelStokAwal();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->MutasiStokModel = new ModelMutasiStok();
        $this->UnitModel = new ModelUnit();
        $this->HppBarangModel = new ModelHppBarang();
        $this->DetailMutasiModel = new ModelDetailMutasi();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'stok' => $this->KartuStokModel->getKartuStok(),
            'produk' => $this->BarangModel->getAllBarang(),
            'kategori' => $this->KategoriModel->getKategori(),
            'suplier' => $this->SuplierModel->getSuplier(),
            'unit' => $this->UnitModel->getUnit(),
            'detail_mutasi' => $this->DetailMutasiModel->getFullDetailMutasi(),
            'body'  => 'riwayat/riwayat_mutasi'
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

        $datamutasi = $this->DetailMutasiModel->exportfilter($tanggal_awal, $tanggal_akhir, $unit);

        // Header
        $sheet->setCellValue('A1', 'No. Mutasi');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Unit Asal');
        $sheet->setCellValue('D1', 'Unit Tujuan');
        $sheet->setCellValue('E1', 'Barang');


        // Data 
        $row = 2;
        foreach ($datamutasi as $item) {
            $sheet->setCellValue('A' . $row, $item->no_nota_mutasi);
            $sheet->setCellValue('B' . $row, $item->mutasi_tanggal_kirim);
            $sheet->setCellValue('C' . $row, $item->nama_unit_kirim);
            $sheet->setCellValue('D' . $row, $item->nama_unit_terima);
            $sheet->setCellValue('E' . $row, $item->nama_barang);;
            $row++;
        }

        // Output Excel
        $filename = 'Riwayat_Mutasi_' . date('Ymd_His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
