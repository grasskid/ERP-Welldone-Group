<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelKategori;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelAuth;

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
        $harga      = str_replace(',', '', $this->request->getPost('harga'));
        $input = $this->request->getPost('input_by');
        $lokasi = $this->request->getPost('lokasi');

        $kategori = $this->request->getPost('kategori');
        $data_kategori = $this->KategoriModel->getByName($kategori);

        var_dump($data_kategori);

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


        $data = array(
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'harga' => $harga,
            'lokasi' => $lokasi,
            'input' => $input,
            'idkategori' => $idkategori,
            'status' => "1",
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
        $lokasi = $this->request->getPost('lokasi');
        $nama_barang = $this->request->getPost('nama_barang');
        $harga      = str_replace(',', '', $this->request->getPost('harga'));
        $input = $this->request->getPost('input_by');
        $kategori = $this->request->getPost('kategori');


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


        $data = array(
            'nama_barang' => $nama_barang,
            'harga' => $harga,
            'input' => $input,
            'lokasi' => $lokasi,
            'idkategori' => $idkategori,
            'kode_barang' => $kode_barang,
            'deleted' => '0'
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
        $sheet->setCellValue('A1', 'Kode Barang');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Harga');
        $sheet->setCellValue('D1', 'Kategori');
        $sheet->setCellValue('E1', 'Input');

        // Data
        $row = 2;
        foreach ($produk as $product) {
            $sheet->setCellValue('A' . $row, $product->kode_barang);
            $sheet->setCellValue('B' . $row, $product->nama_barang);
            $sheet->setCellValue('C' . $row, $product->harga);
            $sheet->setCellValue('D' . $row, $product->nama_kategori);
            $sheet->setCellValue('E' . $row, $product->input);
            $row++;
        }

        // Output Excel
        $filename = 'data_produk_' . date('d/m/Y') . '.xlsx';


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

        // Load spreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Koneksi DB
        $db = Database::connect();

        // Siapkan penampung last number per kategori
        $lastNumbers = [];

        // Skip header (baris pertama)
        for ($i = 1; $i < count($rows); $i++) {
            $nama_barang = addslashes($rows[$i][0]);
            $harga = (int) $rows[$i][1];
            $lokasi = addslashes($rows[$i][2]);
            $input = addslashes($rows[$i][3]);
            $idkategori = addslashes($rows[$i][4]);

            // Ambil kode_kategori berdasarkan idkategori
            $kategori = $db->table('kategori')->where('id', $idkategori)->get()->getRow();
            if (!$kategori) {
                continue; // Jika kategori tidak ditemukan, skip baris ini
            }
            $kode_kategori = $kategori->idkategori;

            // Cek last number kategori ini
            if (!isset($lastNumbers[$idkategori])) {
                // Pertama kali, ambil kode_barang terakhir dari DB
                $lastBarang = $db->table('barang')
                    ->where('idkategori', $idkategori)
                    ->orderBy('kode_barang', 'DESC')
                    ->get()
                    ->getRow();

                if ($lastBarang) {
                    $lastNumber = (int) substr($lastBarang->kode_barang, strlen($kode_kategori));
                } else {
                    $lastNumber = 0;
                }

                $lastNumbers[$idkategori] = $lastNumber;
            }

            // Tambahkan 1 untuk kode baru
            $lastNumbers[$idkategori]++;
            $formattedNumber = str_pad($lastNumbers[$idkategori], 2, '0', STR_PAD_LEFT);

            // Buat kode_barang
            $kode_barang = $kode_kategori . $formattedNumber;

            // Masukkan ke database
            $sql = "INSERT INTO barang (kode_barang, nama_barang, harga ,input, idkategori, deleted) 
                    VALUES ('$kode_barang', '$nama_barang', '$harga' ,'$input', '$idkategori', '0')";

            $db->query($sql);
        }

        session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
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
