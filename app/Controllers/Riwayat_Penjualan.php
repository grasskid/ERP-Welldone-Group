<?php

namespace App\Controllers;

use App\Models\ModelKategori;
use App\Models\ModelDetailPembelian;
use App\Models\ModelDetailPenjualan;
use App\Models\ModelPenjualan;
use Config\Database;
use App\Models\ModelAuth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Riwayat_Penjualan extends BaseController

{

    protected $KategoriModel;
    protected $DetailPembelianModel;
    protected $DetailPenjualanModel;
    protected $PenjualanModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->KategoriModel = new ModelKategori();
        $this->DetailPembelianModel = new ModelDetailPembelian();
        $this->DetailPenjualanModel = new ModelDetailPenjualan();
        $this->PenjualanModel = new ModelPenjualan();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data = [
            'akun' => $akun,
            'kategori' => $this->KategoriModel->getKategori(),
            'detail_penjualan' => $this->DetailPenjualanModel->getDetailPenjualan(),
            'body' => 'riwayat/penjualan'
        ];

        return view('template', $data);
    }

    public function export()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $unit = $this->request->getPost('unit');
        $tanggal_awal = $this->request->getPost('tanggal_awal');;
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        $datapenjualan = $this->DetailPenjualanModel->exportfilter($tanggal_awal, $tanggal_akhir, $unit);


        // Header
        $sheet->setCellValue('A1', 'Kode Invoice');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Unit');
        $sheet->setCellValue('F1', 'Diskon');
        $sheet->setCellValue('G1', 'Harga Penjualan');
        $sheet->setCellValue('H1', 'Sub Total');

        // Data 
        $row = 2;
        foreach ($datapenjualan as $item) {
            $sheet->setCellValue('A' . $row, $item->kode_invoice);
            $sheet->setCellValue('B' . $row, $item->tanggal);
            $sheet->setCellValue('C' . $row, $item->nama_barang);
            $sheet->setCellValue('D' . $row, $item->jumlah);
            $sheet->setCellValue('E' . $row, $item->NAMA_UNIT);
            $sheet->setCellValue('F' . $row, $item->diskon_penjualan);
            $sheet->setCellValue('G' . $row, $item->harga_penjualan);
            $sheet->setCellValue('H' . $row, $item->sub_total);
            $row++;
        }

        // Output Excel
        $filename = 'Riwayat_Penjualan_' . date('Ymd_His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    public function cetak_struk($kode_invoice)
    {
        $datapenjualan = $this->DetailPenjualanModel->getDetailPenjualanByInvoice($kode_invoice);
        $produkData = [];
        foreach ($datapenjualan as $item) {
            $produkData[] = [
                'nama' => $item->nama_barang,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga_penjualan
            ];
        }

        $datapenjualan2 = $this->PenjualanModel->getByKodeInvoice($kode_invoice);
        $tanggal = $datapenjualan2->tanggal;
        $userdata = $this->AuthModel->getById($datapenjualan2->input_by);
        $namauser = $userdata->NAMA_AKUN;
        $no_invoice = $kode_invoice;
        $sub_total_cetak = $datapenjualan2->total_penjualan + $datapenjualan2->diskon;
        $nilaidiskon = $datapenjualan2->diskon;
        $total_penjualan = $datapenjualan2->total_penjualan;
        $bayar = $datapenjualan2->bayar;
        $kembalian_cetak = max(0, $bayar - $total_penjualan);



        $data = array(

            'produk' => $produkData,
            'tanggal' => $tanggal,
            'kasir'  => $namauser,
            'no_invoice' => $no_invoice,
            'sub_total' => $sub_total_cetak,
            'diskon' => $nilaidiskon,
            'total' => $total_penjualan,
            'bayar' => $bayar,
            'kembalian' => $kembalian_cetak,

        );

        $html = view('cetak/cetak_penjualan', $data);

        error_reporting(0);

        $mpdf = new \Mpdf\Mpdf(['curlUserAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:108.0) Gecko/20100101 Firefox/108.0']);

        ob_end_clean();

        $mpdf->curlAllowUnsafeSslRequests = true;

        $this->response->setHeader('Content-Type', 'application/pdf');

        $this->response->setHeader('Content-Transfer-Encoding', 'binary');

        $this->response->setHeader('Accept-Ranges', 'bytes');

        $mpdf->WriteHTML($html);

        return redirect()->to($mpdf->Output());
    }
}
    

    // public function index()
    // {
    //     $tanggal_awal = $this->request->getGet('tanggal_awal');
    //     $tanggal_akhir = $this->request->getGet('tanggal_akhir');
    //     $kode_invoice = $this->request->getGet('kode_invoice'); // Get invoice code if present
    
    //     $detail_penjualan = $this->DetailPenjualanModel->getDetailByTanggal($tanggal_awal, $tanggal_akhir);
    
    //     $penjualan = [];
    //     if ($kode_invoice) {
    //         $penjualan = $this->DetailPenjualanModel->getDetailPenjualanByKodeInvoice($kode_invoice);
    //     }
    
    //     $data = [
    //         'penjualan' => $penjualan,
    //         'kategori' => $this->KategoriModel->getKategori(),
    //         'detail_penjualan' => $detail_penjualan,
    //         'body' => 'riwayat/penjualan'
    //     ];
    
    //     return view('template', $data);
    // }
