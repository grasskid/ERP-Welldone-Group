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
use App\Models\ModelProsesService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelJurnal;

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
    protected $ProsesServiceModel;
    protected $JurnalModel;



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
        $this->ProsesServiceModel = new ModelProsesService();
        $this->JurnalModel = new ModelJurnal();
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

    public function index2()
    {

        $data =  array(

            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'service' => $this->ServiceModel->getRiwayatServiceGaransi(),
            'body'  => 'riwayat/service_garansi'
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

    public function update_service_pelanggan()
    {
        $idservice = $this->request->getPost('idservice');
        $imei = $this->request->getPost('imei');
        $dp_bayar = $this->rupiahToInt($this->request->getPost('dp_bayar'));
        $tipe_passcode = $this->request->getPost('tipe_passcode');
        $passcode = $this->request->getPost('passcode');
        $email_icloud = $this->request->getPost('email_icloud');
        $password_icloud = $this->request->getPost('password_icloud');
        $keluhan = $this->request->getPost('keluhan');
        $keterangan = $this->request->getPost('keterangan');
        $estimasi_biaya = $this->request->getPost('estimasi_biaya');

        $data = array(
            'imei' => $imei,
            'tipe_passcode' => $tipe_passcode,
            'passcode' => $passcode,
            'email_icloud' => $email_icloud,
            'password_icloud' => $password_icloud,
            'keluhan' => $keluhan,
            'keterangan' => $keterangan,
            'estimasi_biaya' => $estimasi_biaya,

        );
        $this->ServiceModel->updateService($idservice, $data);
        return redirect()->to(base_url('detail/riwayat_service/' . $idservice . '?tab=kerusakan'))->with('success', 'Data kerusakan berhasil diperbarui.');
    }




    public function insert_kerusakan()
    {
        $fungsiTerpilih = $this->request->getPost('fungsi');
        $keteranganInput = $this->request->getPost('keterangan');
        $idservice = $this->request->getPost('idservice_k');

        if (empty($fungsiTerpilih)) {
            return redirect()->to(base_url('detail/riwayat_service/' . $idservice . '?tab=sparepart'))->with('info', 'Tidak ada kerusakan yang dipilih.');
        }

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        // Ambil data kerusakan lama dari database
        $dataLama = $this->ServiceKerusakanModel->getSerModelServiceKerusakanByServiceId($idservice);
        $fungsiLama = []; // format: idfungsi => keterangan
        foreach ($dataLama as $item) {
            $fungsiLama[$item->fungsi_idfungsi] = $item->keterangan;
        }

        $fungsiTerpilihMap = array_flip($fungsiTerpilih); // untuk pencarian cepat

        // 1. Tambah atau update yang baru
        foreach ($fungsiTerpilih as $idfungsi) {
            $catatan = $keteranganInput[$idfungsi] ?? '';

            if (array_key_exists($idfungsi, $fungsiLama)) {
                // Cek apakah keterangan berubah
                if (trim($fungsiLama[$idfungsi]) !== trim($catatan)) {
                    $this->ServiceKerusakanModel->updateKeterangan($idservice, $idfungsi, $catatan);
                }
                unset($fungsiLama[$idfungsi]); // tidak akan dihapus
            } else {
                // Tambah baru
                $this->ServiceKerusakanModel->insert_SerModelServiceKerusakan([
                    'fungsi_idfungsi' => $idfungsi,
                    'keterangan' => $catatan,
                    'service_idservice' => $idservice,
                    'created_at' => $now,
                ]);
            }
        }

        // 2. Hapus yang sudah tidak dipilih
        foreach ($fungsiLama as $idfungsi => $keteranganLama) {
            $this->ServiceKerusakanModel->deleteByServiceAndFungsi($idservice, $idfungsi);
        }

        return redirect()->to(base_url('detail/riwayat_service/' . $idservice . '?tab=sparepart'))->with('success', 'Data kerusakan berhasil diperbarui.');
    }


    public function insert_sparepart()
    {
        $produkData = $this->request->getPost('produk');
        $idservice = $this->request->getPost('idservice_s');


        $existingItems = $this->ServiceSparepartModel->getByServiceId($idservice);
        $existingMap = [];

        foreach ($existingItems as $item) {
            $existingMap[$item->barang_idbarang] = $item;
        }

        $submittedIds = [];

        if (!empty($produkData)) {
            foreach ($produkData as $produk) {
                $id     = $produk['id'];
                $jumlah = (int) $produk['jumlah'];
                $harga  = $this->rupiahToInt($produk['harga']);
                $diskon_item = $this->rupiahToInt($produk['diskon']);
                $total  = $this->rupiahToInt($produk['total']);
                $submittedIds[] = $id;

                $datahppbarang = $this->HppBarangModel->getById($id);
                $hpp = $datahppbarang->hpp ?? 0;

                $datastokawal = $this->StokAwalModel->getById($id);
                $satuan_terkecil = $datastokawal->satuan_terkecil ?? 'pcs';

                $datas = [
                    'jumlah' => $jumlah,
                    'harga_penjualan' => $harga,
                    'sub_total' => $total,
                    'hpp_penjualan' => $hpp,
                    'satuan_jual' => $satuan_terkecil,
                    'diskon_penjualan' => $diskon_item,
                    'service_idservice' => $idservice,
                    'barang_idbarang' => $id,
                    'unit_idunit' => session('ID_UNIT')
                ];

                if (array_key_exists($id, $existingMap)) {
                    // ID sudah ada → Update
                    $this->ServiceSparepartModel
                        ->updateByServiceAndBarang($idservice, $id, $datas);
                } else {
                    // ID belum ada → Insert
                    $this->ServiceSparepartModel
                        ->insert_SerModelServiceSparepart($datas);
                }
            }
        }

        // Hapus data sparepart yang tidak lagi ada di form
        foreach ($existingMap as $barangId => $item) {
            if (!in_array($barangId, $submittedIds)) {
                $this->ServiceSparepartModel
                    ->deleteByServiceAndBarang($idservice, $barangId);
            }
        }
        return redirect()->to(base_url('detail/riwayat_service/' . $idservice . '?tab=pembayaran'))->with('success', 'Data kerusakan berhasil diperbarui.');
    }



    public function insert_pembayaran()
    {

        //pembayaran
        $idservice = $this->request->getPost('idservice_p');
        $data_service = $this->ServiceModel->getServiceById($idservice);
        $service_by = $this->request->getPost('service_by_pembayaran');
        $diskon_pembayaran = $this->rupiahToInt($this->request->getPost('diskon_pembayaran'));
        $garansi = (int) $this->request->getPost('garansi');
        $total_harga_pembayaran = $this->rupiahToInt($this->request->getPost('total_harga_pembayaran'));
        $status_service = $this->request->getPost('status_service_pembayaran');
        $service_by_pembayaran = $this->request->getPost('service_by_pembayaran');
        $bayar_pembayaran = $this->rupiahToInt($this->request->getPost('bayar_pembayaran'));
        $dp_bayar = $data_service->dp_bayar;

        $harus_dibayar = $total_harga_pembayaran  - $dp_bayar;





        $datap = array(

            'total_service' => $total_harga_pembayaran,
            'total_diskon' => $diskon_pembayaran,
            'harus_dibayar' => $harus_dibayar,
            'garansi_hari' => $garansi,
            'bayar' => $bayar_pembayaran,
            'service_by' => $service_by_pembayaran
        );
        $resultend =  $this->ServiceModel->updateService($idservice, $datap);

        session()->remove('idservice');
        session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
        return redirect()->to(base_url('/riwayat_service'));
    }


    function rupiahToInt($rupiah)
    {

        $cleaned = str_replace(['Rp', '.', ' '], '', $rupiah);


        return (int) preg_replace('/[^0-9]/', '', $cleaned);
    }



    public function cetak_invoice($idservice)
    {
        helper('qr');


        $sparepart  = $this->ServiceModel->getSparepartWithBarang($idservice);
        $kerusakan  = $this->ServiceModel->getKerusakanWithFungsi($idservice);
        $human      = $this->ServiceModel->getServiceWithAkunAndPelanggan($idservice);
        $service    = $this->ServiceModel->getServiceById($idservice);


        $qrData = base_url('status_service/' . $idservice);
        $uniqueName = 'qr_' . md5($idservice . time()) . '.png';
        $qrImageUrl = generateQrToFile($qrData, $uniqueName);


        $data = [
            'sparepart'    => $sparepart,
            'service'      => $service,
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


    public function export2()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $tanggal_awal  = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        // Ambil data dari model
        $dataservice = $this->ServiceModel->filterExportGaransi($tanggal_awal, $tanggal_akhir);

        // Header kolom
        $headers = [
            'A1' => 'No. Service',
            'B1' => 'Tanggal Masuk',
            'C1' => 'Tanggal Claim Garansi',
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
            $sheet->setCellValue('C' . $row, $item->tanggal_claim_garansi);
            $sheet->setCellValue('D' . $row, $item->nama_pelanggan);
            $sheet->setCellValue('E' . $row, $item->total_service_garansi);
            $sheet->setCellValue('F' . $row, $item->total_diskon_garansi);
            $sheet->setCellValue('G' . $row, $item->harus_dibayar_garansi);
            $sheet->setCellValue('H' . $row, $item->bayar_garansi);
            $sheet->setCellValue('I' . $row, $item->nama_service_by_garansi);
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
        $filename = 'Riwayat_Service_Garansi' . date('Ymd_His') . '.xlsx';

        // Header untuk response browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        // Output file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }



    //proses service

    public function proses_service()
    {

        $data =  array(
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'service' => $this->ServiceModel->ProsesServiceAktif(),
            'body'  => 'riwayat/proses_service'
        );
        return view('template', $data);
    }

    public function update_status_proses()
    {
        $status_proses = $this->request->getPost('status_proses');
        $idservice = $this->request->getPost('idservice');

        $data = array(
            'status_service' => 2,
            'status_proses' => $status_proses
        );
        $result = $this->ServiceModel->updateService($idservice, $data);

        $wibTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $data2 = array(
            'service_idservice' => $idservice,
            'status_statusproses' => $status_proses,
            'updated_at' => $wibTime->format('Y-m-d H:i:s'),
        );
        $result2 = $this->ProsesServiceModel->insertProses($data2);

        if ($result && $result2) {
            session()->setFlashdata('sukses', 'Berhasil Memperbarui Status');
            return redirect()->to(base_url('proses_service'));
        }
    }

    public function update_bisa_diambil()
    {

        $idservice = $this->request->getPost('idservice');
        $wibTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $data = array(
            'status_service' => 3,
            'tanggal_bisa_diambil' => $wibTime->format('Y-m-d H:i:s'),
        );
        $result = $this->ServiceModel->updateService($idservice, $data);




        if ($result) {
            session()->setFlashdata('sukses', 'Berhasil Memperbarui Status');
            return redirect()->to(base_url('proses_service'));
        }
    }

    //end proses service


    //service bisa diambll
    public function service_bisa_diambil()
    {
        $data =  array(
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'service' => $this->ServiceModel->ServiceBisaDiambil(),
            'body'  => 'riwayat/bisa_diambil'
        );
        return view('template', $data);
    }

    public function update_sudah_diambil()
    {
        $idservice = $this->request->getPost('idservice');
        $wibTime = new \DateTime('now', new \DateTimeZone('Asia/Jakarta'));

        $dataservice = $this->ServiceModel->getServiceById($idservice);
        $harus_dibayar = $dataservice->harus_dibayar;
        $dp_bayar = $dataservice->dp_bayar;
        $created_at = $dataservice->created_at;
        $tanggal_saja = date('Y-m-d', strtotime($created_at));
        $total_service = $dataservice->total_service;

        $data = [
            'status_service' => 4,
            'tanggal_selesai' => $wibTime->format('Y-m-d H:i:s'),
        ];

        $result = $this->ServiceModel->updateService($idservice, $data);

        if ($result) {
            // Siapkan nilai-nilai sesuai urutan array_value di template
            $kas_diterima = $total_service - $dp_bayar;

            $ar_nilai = [
                0 => $kas_diterima,   // Kas
                1 => $dp_bayar,       // Diterima di muka
                2 => $total_service,  // Pendapatan
            ];

            $this->JurnalModel->insertJurnal(
                $tanggal_saja,
                'pembayaran_service_tunai',
                $ar_nilai,
                'Pembayaran Service Tunai',
                $idservice,
                'service'
            );

            session()->setFlashdata('sukses', 'Berhasil Memperbarui Status');
            return redirect()->to(base_url('bisa_diambil'));
        }
    }


    //end service bisa diambil

    // sudah diambil
    public function service_sudah_diambil()
    {
        $data =  array(
            'fungsi' => $this->KerusakanModel->getKerusakan(),
            'pelanggan' => $this->PelangganModel->getPelanggan(),
            'service' => $this->ServiceModel->ServiceSudahDiambil(),
            'body'  => 'riwayat/sudah_diambil'
        );
        return view('template', $data);
    }
}
