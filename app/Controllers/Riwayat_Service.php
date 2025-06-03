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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Riwayat_Service extends BaseController

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
            'service' => $this->ServiceModel->getRiwayatService(),
            'body'  => 'riwayat/service'
        );
        return view('template', $data);
    }

    public function detail_service($idservice)
    {

        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $oldkerusakan = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $oldsparepart = $this->ServiceSparepartModel->getSerModelServiceSparepartByServiceId($idservice);
        $lama_garansi = $this->ServiceSparepartModel->getGaransiHariByServiceId($idservice);
        $teknisi = $this->AuthModel->getdataakun();
        $data =  array(
            'akun' => $akun,
            'teknisi' => $teknisi,
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'idservice' => $idservice,
            'old_service_pelanggan' => $this->ServiceModel->getByIdWithPelanggan($idservice),
            'oldkerusakan' => $oldkerusakan,
            'oldsparepart' => $oldsparepart,
            'lama_garansi' => $lama_garansi ? (int)$lama_garansi->garansi_hari : null,
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'sparepart' => $this->StokBarangModel->getSparepart(),
            'body'  => 'riwayat/table/service'
        );
        return view('template', $data);
    }


    public function update_kelengkapan_service()
    {
        //kerusakan

        $fungsiTerpilih = $this->request->getPost('fungsi');
        $keterangan = $this->request->getPost('keterangan');
        $idservice = $this->request->getPost('idservice');

        date_default_timezone_set('Asia/Jakarta');
        $created_at = date('Y-m-d H:i:s');


        $kerusakanLama = $this->ServiceKerusakanModel
            ->where('service_idservice', $idservice)
            ->findAll();

        $fungsiLama = array_map(function ($item) {
            return $item->fungsi_idfungsi;
        }, $kerusakanLama);


        if (!$fungsiTerpilih) {
            $this->ServiceKerusakanModel
                ->where('service_idservice', $idservice)
                ->delete();
        } else {

            foreach ($fungsiLama as $idFungsiLama) {
                if (!in_array($idFungsiLama, $fungsiTerpilih)) {
                    $this->ServiceKerusakanModel
                        ->where('service_idservice', $idservice)
                        ->where('fungsi_idfungsi', $idFungsiLama)
                        ->delete();
                }
            }


            foreach ($fungsiTerpilih as $idfungsi) {
                $catatan = $keterangan[$idfungsi] ?? null;


                $existing = $this->ServiceKerusakanModel
                    ->where('service_idservice', $idservice)
                    ->where('fungsi_idfungsi', $idfungsi)
                    ->first();

                if ($existing) {

                    $this->ServiceKerusakanModel->update($existing->idservice_kerusakan, ['keterangan' => $catatan]);
                } else {

                    $datak = array(
                        'fungsi_idfungsi' => $idfungsi,
                        'keterangan' => $catatan,
                        'service_idservice' => $idservice,
                        'created_at' => $created_at,
                    );
                    $this->ServiceKerusakanModel->insert($datak);
                }
            }
        }


        //sparepart
        $produkData = $this->request->getPost('produk');
        $produkBaru = [];

        // data lama
        $sparepartLama = $this->ServiceSparepartModel
            ->where('service_idservice', $idservice)
            ->findAll();


        $barangLama = array_map(function ($item) {
            return $item->barang_idbarang;
        }, $sparepartLama);


        foreach ($produkData as $produk) {
            $id     = $produk['id'];
            $jumlah = $produk['jumlah'];
            $harga  = $produk['harga'];
            $diskon_item = $produk['diskon'];
            $total  = $produk['total'];

            $produkBaru[] = $id;

            $datahppbarang = $this->HppBarangModel->getById($id);
            $hpp = $datahppbarang->hpp ?? 0;

            $datastokawal = $this->StokAwalModel->getById($id);
            $satuan_terkecil = $datastokawal ? $datastokawal->satuan_terkecil : 'pcs';

            $datas = array(
                'jumlah' => $jumlah,
                'harga_penjualan' => $harga,
                'sub_total' => $total * $jumlah,
                'hpp_penjualan' => $hpp,
                'satuan_jual' => $satuan_terkecil,
                'diskon_penjualan' => $diskon_item,
                'service_idservice' => $idservice,
                'barang_idbarang' => $id,
                'unit_idunit' => session('ID_UNIT')
            );

            // Cek apakah sudah ada data sparepart dengan barang_idbarang ini
            $existing = $this->ServiceSparepartModel
                ->where('service_idservice', $idservice)
                ->where('barang_idbarang', $id)
                ->first();

            if ($existing) {
                $this->ServiceSparepartModel->update($existing->idservice_sparepart, $datas);
            } else {
                $this->ServiceSparepartModel
                    ->insert($datas);
            }
        }

        // Hapus data sparepart yang sebelumnya ada tapi sekarang tidak dikirim lagi
        foreach ($barangLama as $idbarangLama) {
            if (!in_array($idbarangLama, $produkBaru)) {
                $this->ServiceSparepartModel
                    ->where('service_idservice', $idservice)
                    ->where('barang_idbarang', $idbarangLama)
                    ->delete();
            }
        }

        //pembayaran
        $service_by = $this->request->getPost('service_by_pembayaran');
        $diskon_pembayaran = $this->request->getPost('diskon_pembayaran');
        $garansi = (int) $this->request->getPost('garansi');
        $total_harga_pembayaran = $this->request->getPost('total_harga_pembayaran');
        $status_service = $this->request->getPost('status_service_pembayaran');
        $service_by_pembayaran = $this->request->getPost('service_by_pembayaran');
        $bayar = $this->request->getPost('bayar_pembayaran');

        $datap = array(
            'status_service' => $status_service,
            'total_service' => $total_harga_pembayaran,
            'total_diskon' => $diskon_pembayaran,
            'harus_dibayar' => $total_harga_pembayaran,
            'garansi_hari' => $garansi,
            'bayar' => $bayar,
            'service_by' => $service_by_pembayaran

        );
        $resultend =  $this->ServiceModel->updateService($idservice, $datap);

        session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
        return redirect()->to(base_url('riwayat_service'));
    }



    public function cetak_invoice($idservice)
    {
        helper('qr');


        $sparepart  = $this->ServiceModel->getSparepartWithBarang($idservice);
        $kerusakan  = $this->ServiceModel->getKerusakanWithFungsi($idservice);
        $human      = $this->ServiceModel->getServiceWithAkunAndPelanggan($idservice);


        $qrData = base_url('status_service/' . $idservice);
        $uniqueName = 'qr_' . md5($idservice . time()) . '.png';
        $qrImageUrl = generateQrToFile($qrData, $uniqueName);


        $data = [
            'sparepart'    => $sparepart,
            'kerusakan'    => $kerusakan,
            'human'        => $human,
            'qrImageUrl'   => $qrImageUrl
        ];


        $html = view('cetak/invoice_service', $data);


        error_reporting(0);
        $mpdf = new \Mpdf\Mpdf([
            'curlUserAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:108.0) Gecko/20100101 Firefox/108.0'
        ]);

        ob_end_clean();
        $mpdf->curlAllowUnsafeSslRequests = true;


        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader('Content-Transfer-Encoding', 'binary');
        $this->response->setHeader('Accept-Ranges', 'bytes');


        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;
    }



    public function export()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $tanggal_awal  = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        // Ambil data dari model
        $dataservice = $this->ServiceModel->filterexport($tanggal_awal, $tanggal_akhir);

        // Header kolom
        $headers = [
            'A1' => 'No. Service',
            'B1' => 'Tanggal Masuk',
            'C1' => 'Nama Pelanggan',
            'D1' => 'Total Service',
            'E1' => 'Total DIskon',
            'F1' => 'Sub Total',
            'G1' => 'Total Bayar',
            'H1' => 'Nama Teknisi'
        ];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Styling header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE2EFDA'); // Warna hijau muda

        // Tulis data ke baris berikutnya
        $row = 2;
        foreach ($dataservice as $item) {
            $sheet->setCellValue('A' . $row, $item->no_service);
            $sheet->setCellValue('B' . $row, $item->created_at);
            $sheet->setCellValue('C' . $row, $item->nama_pelanggan);
            $sheet->setCellValue('D' . $row, $item->total_service);
            $sheet->setCellValue('E' . $row, $item->total_diskon);
            $sheet->setCellValue('F' . $row, $item->harus_dibayar);
            $sheet->setCellValue('G' . $row, $item->bayar);
            $sheet->setCellValue('H' . $row, $item->nama_service_by);
            $row++;
        }

        // Border seluruh tabel
        $sheet->getStyle('A1:H' . ($row - 1))
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Auto-width untuk semua kolom
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Format tanggal kolom B
        $sheet->getStyle('B2:B' . ($row - 1))
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');

        // Freeze header
        $sheet->freezePane('A2');

        // Nama file
        $filename = 'Riwayat_Service_' . date('Ymd_His') . '.xlsx';

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
