<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelKategori;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelAuth;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Produk extends BaseController

{

    protected $BarangModel;
    protected $KategoriModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->BarangModel = new ModelBarang();
        $this->KategoriModel = new ModelKategori();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'produk' => $this->BarangModel->getBarang(),
            'kategori' => $this->KategoriModel->getKategoriTanpaId7(),
            'body'  => 'datamaster/produk'
        );
        return view('template', $data);
    }


    public function insert_produk()
    {

        $nama_barang = $this->request->getPost('nama_barang');
        $harga      = str_replace('.', '', $this->request->getPost('harga'));
        $harga_beli      = str_replace('.', '', $this->request->getPost('harga_beli'));
        $input = $this->request->getPost('input_by');
        $stok_minimum = $this->request->getPost('stok_minimum');
        $kategori = $this->request->getPost('kategori');
        $data_kategori = $this->KategoriModel->getByName($kategori);

        $idkategori = $data_kategori->id;
        $kode_kategori = $data_kategori->idkategori;

        $lastBarang = $this->BarangModel->getLastBarangByKategori($idkategori);

        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_barang, strlen($kode_kategori));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $formattedNumber = str_pad($newNumber, 2, '0', STR_PAD_LEFT);

        $kode_barang = $kode_kategori . $formattedNumber;
        $status_ppn = $this->request->getPost('status_ppn');
        $warna = $this->request->getPost('warna');


        $data = array(
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'harga' => $harga,
            'harga_beli' => $harga_beli,
            'input' => $input,
            'stok_minimum' => $stok_minimum,
            'idkategori' => $idkategori,
            'warna' => $warna,
            'status' => "1",
            'status_ppn' => $status_ppn,
            'deleted' => '0'

        );

        $result = $this->BarangModel->insert_Barang($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
            return redirect()->to(base_url('/produk'));
        }
    }

    public function update_produk()
    {
        $idbarang = $this->request->getPost('id_barang');
        $nama_barang = $this->request->getPost('nama_barang');
        $harga      = str_replace('.', '', $this->request->getPost('harga'));
        $harga_beli      = str_replace('.', '', $this->request->getPost('harga_beli'));
        $input = $this->request->getPost('input_by');
        $kategori = $this->request->getPost('kategori');
        $stok_minimum = $this->request->getPost('stok_minimum');


        $barangLama = $this->BarangModel->find($idbarang);


        $data_kategori = $this->KategoriModel->getByName($kategori);
        $idkategori_baru = $data_kategori->id;
        $kode_kategori_baru = $data_kategori->idkategori;

        $idkategori = $barangLama->idkategori;
        $kode_barang = $barangLama->kode_barang;


        if ($idkategori != $idkategori_baru) {

            $lastBarang = $this->BarangModel->getLastBarangByKategori($idkategori_baru);

            if ($lastBarang) {
                $lastNumber = (int) substr($lastBarang->kode_barang, strlen($kode_kategori_baru));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $formattedNumber = str_pad($newNumber, 2, '0', STR_PAD_LEFT);
            $kode_barang = $kode_kategori_baru . $formattedNumber;


            $idkategori = $idkategori_baru;
        }

        $status_ppn = (int)$this->request->getPost('status_ppn');
        $warna = $this->request->getPost('warna');

        $data = array(
            'nama_barang' => $nama_barang,
            'harga' => $harga,
            'harga_beli' => $harga_beli,
            'idkategori' => $idkategori,
            'kode_barang' => $kode_barang,
            'status_ppn' => $status_ppn,
            'warna' => $warna,
            'deleted' => '0',
            'input_by' => $input,
            'stok_minimum' => $stok_minimum,
        );

        $result = $this->BarangModel->update($idbarang, $data);

        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/produk'));
        }
    }



    public function export_produk()
    {

        $produk = $this->BarangModel->getBarang();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['Kode Barang', 'Nama Barang', 'Harga', 'Harga Beli', 'Kategori', 'Status PPN', 'Input'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Styling Header
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCE6F1');

        // Data
        $row = 2;
        foreach ($produk as $product) {
            $ppn = ($product->status_ppn === '1') ? 'PPN' : (($product->status_ppn === '0') ? 'NON PPN' : 'Belum Diset');

            $sheet->setCellValue('A' . $row, $product->kode_barang);
            $sheet->setCellValue('B' . $row, $product->nama_barang);
            $sheet->setCellValue('C', $row, $product->warna);
            $sheet->setCellValue('D' . $row, $product->harga);
            $sheet->setCellValue('E' . $row, $product->harga_beli);
            $sheet->setCellValue('F' . $row, $product->nama_kategori);
            $sheet->setCellValue('G' . $row, $ppn);
            $sheet->setCellValue('H' . $row, $product->input);
            $row++;
        }

        // Auto width
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $sheet->getStyle('A1:H' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Freeze header
        $sheet->freezePane('A2');

        // File name (safe format)
        $filename = 'data_produk_' . date('Ymd') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function import_produk()
    {
        $file = $this->request->getFile('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        $db = Database::connect();

        // Simpan lastNumber per kategori (by primary id)
        $lastNumbers = [];

        for ($i = 1; $i < count($rows); $i++) {
            $nama_barang    = addslashes($rows[$i][0]);
            $harga          = str_replace(',', '', $rows[$i][1]);
            $harga_beli     = str_replace(',', '', $rows[$i][2]);
            $warna          = addslashes($rows[$i][3]);
            $idkategori_raw = addslashes($rows[$i][4]);
            $status_ppn_raw = strtoupper(trim(addslashes($rows[$i][5])));
            $status_ppn     = ($status_ppn_raw === 'PPN') ? 1 : 0;
            $input          = addslashes($rows[$i][6]);

            // Ambil data kategori berdasar kode kategori dari file
            $dataKategori = $this->KategoriModel->getById($idkategori_raw);
            if (!$dataKategori) continue;

            $idnyakategori  = $dataKategori->id;
            $kode_kategori  = $dataKategori->idkategori;

            if (! isset($lastNumbers[$idnyakategori])) {
                $lastBarang = $this->BarangModel->getLastBarangByKategori($idnyakategori);
                $lastNumbers[$idnyakategori] = $lastBarang
                    ? (int) substr($lastBarang->kode_barang, strlen($kode_kategori))
                    : 0;
            }

            $lastNumbers[$idnyakategori]++;
            $formattedNumber = str_pad($lastNumbers[$idnyakategori], 2, '0', STR_PAD_LEFT);
            $kode_barang     = $kode_kategori . $formattedNumber;

            // Sesuaikan query untuk menambahkan kolom `warna`
            $sql = "INSERT INTO barang 
        (kode_barang, nama_barang, harga, harga_beli, warna, input, idkategori, status, status_ppn, deleted) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, 1, ?, 0)";

            $db->query($sql, [
                $kode_barang,
                $nama_barang,
                $harga,
                $harga_beli,
                $warna,
                $input,
                $idnyakategori,
                $status_ppn
            ]);
        }

        session()->setFlashdata('sukses', 'Data Berhasil Disimpan');
        return redirect()->to(base_url('/produk'));
    }




    public function delete_produk()
    {
        $id_barang = $this->request->getPost('id_barang');
        $data = array(
            'deleted' => '1'
        );
        $result = $this->BarangModel->update($id_barang, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Hapus');
            return redirect()->to(base_url('/produk'));
        }
    }
}
