<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use App\Models\ModelPelanggan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelAuth;

class Pelanggan extends BaseController

{

    protected $PhoneModel;
    protected $PelangganModel;
    protected $AuthModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->PelangganModel = new ModelPelanggan();
        $this->AuthModel = new ModelAuth();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'phone' => $this->PhoneModel->getPhone(),
            'body'  => 'datamaster/pelanggan',
            'pelanggan' => $this->PelangganModel->getPelanggan()
        );
        return view('template', $data);
    }


    public function insert_pelanggan()
    {

        $nik = $this->request->getPost('nik');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $no_hp = $this->request->getPost('no_hp');

        $data = array(
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'deleted' => '0'
        );
        $result = $this->PelangganModel->insert_Pelanggan($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/pelanggan'));
        }
    }

    public function update_pelanggan()
    {
        $id_pelanggan = $this->request->getPost('id_pelanggan');
        $nik = $this->request->getPost('nik');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $no_hp = $this->request->getPost('no_hp');

        $data = array(
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'deleted' => '0'
        );
        $result = $this->PelangganModel->update($id_pelanggan, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
            return redirect()->to(base_url('/pelanggan'));
        }
    }

    public function delete_pelanggan()
    {
        $id_pelanggan = $this->request->getPost('id_pelanggan');
        $data = array(
            'deleted' => '1'
        );
        $result = $this->PelangganModel->update($id_pelanggan, $data);
        if ($result) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Hapus');
            return redirect()->to(base_url('/pelanggan'));
        }
    }

    public function export_pelanggan()
    {
        $pelanggan = $this->PelangganModel->getPelanggan();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'NIK');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Nomor Handphone');


        // Data
        $row = 2;
        foreach ($pelanggan as $customer) {
            $sheet->setCellValue('A' . $row, $customer->nik);
            $sheet->setCellValue('B' . $row, $customer->nama);
            $sheet->setCellValue('C' . $row, $customer->alamat);
            $sheet->setCellValue('D' . $row, $customer->no_hp);
            $row++;
        }

        // Output Excel
        $filename = 'data_pelanggan_' . date('d/m/Y/His') . '.xlsx';

        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function import_pelanggan()
    {

        $file = $this->request->getFile('file');

        // Load spreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Koneksi DB
        $db = Database::connect();

        // Skip header (baris pertama)
        for ($i = 1; $i < count($rows); $i++) {
            $nik = addslashes($rows[$i][0]);
            $nama = addslashes($rows[$i][1]);
            $alamat = addslashes($rows[$i][2]);
            $no_hp = addslashes($rows[$i][3]);


            $sql = "INSERT INTO pelanggan (nik, nama, alamat, no_hp, deleted) 
                    VALUES ('$nik', '$nama', '$alamat', '$no_hp', '0')";

            $db->query($sql);
        }

        session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
        return redirect()->to(base_url('/pelanggan'));
    }
}
