<?php

namespace App\Controllers;

use App\Models\ModelPhone;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Config\Database;
use App\Models\ModelBarang;
use App\Models\ModelAuth;
use App\Models\ModelUnit;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ModelNamaHandphone;

class NamaHandphone extends BaseController

{

    protected $PhoneModel;
    protected $BarangModel;
    protected $AuthModel;
    protected $NamaHandphoneModel;
    protected $UnitModel;

    public function __construct()
    {
        $this->PhoneModel = new ModelPhone();
        $this->BarangModel = new ModelBarang();
        $this->AuthModel = new ModelAuth();
        $this->NamaHandphoneModel = new ModelNamaHandphone();
        $this->UnitModel = new ModelUnit();
    }

    public function index()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $data =  array(
            'akun' => $akun,
            'namahandphone' => $this->NamaHandphoneModel->getNamaHandphone(),
            'body'  => 'datamaster/namahandphone',
            'unit' => $this->UnitModel->getUnit()
        );

        return view('template', $data);
    }

    // baru 
    public function insertNamaHandphone()
    {
        $nama   = $this->request->getPost('nama');
        $type   = $this->request->getPost('type');
        $size      = $this->request->getPost('size');

        $data = [
            'nama' => $nama,
            'type'       => $type,
            'size'   => $size
        ];

        $result = $this->NamaHandphoneModel->insert($data);
        if ($result) {
            session()->setFlashdata('sukses', 'Berhasil Menambahkan Data');
            return redirect()->to(base_url('/namahandphone'));
        }
    }

    public function udpateNamaHandphone()
    {
        $id     = $this->request->getPost('id');
        $nama   = $this->request->getPost('nama');
        $type   = $this->request->getPost('type');
        $size   = $this->request->getPost('size');

        $data = [
            'nama' => $nama,
            'type'       => $type,
            'size'   => $size
        ];
        if ($this->NamaHandphoneModel->update($id, $data)) {
            session()->setFlashdata('sukses', 'Data Berhasil Di Simpan');
        } else {
            session()->setFlashdata('gagal', 'Data Gagal Di Simpan');
        }
        return redirect()->to(base_url('/namahandphone'));
    }

    public function deleteNamaHandphone()
    {
        $id = $this->request->getPost('id');
        $result =  $this->NamaHandphoneModel->delete($id);
        if ($result) {
            session()->setFlashData('sukses', 'Data Berhasil Diperbarui');
            return redirect()->to(base_url('/namahandphone'));
        } else {
            session()->setFlashData('gagal', 'Gagal memperbarui data.');
            return redirect()->back()->withInput();
        }
    }


    public function export_handphone()
    {
        $produk = $this->NamaHandphoneModel->getNamaHandphone();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['No', 'Nama', 'Type', 'Spesifikasi'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        // Styling Header
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:D1')->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFDCE6F1');

        // Data
        $row = 2;
        $no = 1;
        foreach ($produk as $product) {

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $product->nama);
            $sheet->setCellValue('C' . $row, $product->type);
            $sheet->setCellValue('D' . $row, $product->size);   // Jika kolom spesifikasi bernama 'size'

            $row++;
        }

        // Auto width
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border
        $sheet->getStyle('A1:D' . ($row - 1))
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Freeze header
        $sheet->freezePane('A2');

        // File name
        $filename = 'data_handphone_' . date('Ymd') . '.xlsx';

        // Set header download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function import_handphone()
    {
        $file = $this->request->getFile('file');

        // Load spreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Koneksi DB
        $db = Database::connect();

        // Mulai dari baris ke-1 (skip header)
        for ($i = 1; $i < count($rows); $i++) {

            // Pastikan tidak memproses baris kosong
            if (empty($rows[$i][0]) && empty($rows[$i][1]) && empty($rows[$i][2])) {
                continue;
            }

            $nama = addslashes($rows[$i][0]);
            $type = addslashes($rows[$i][1]);
            $size = addslashes($rows[$i][2]);

            $sql = "INSERT INTO nama_handphone (nama, type, size) 
                VALUES ('$nama', '$type', '$size')";

            $db->query($sql);
        }

        session()->setFlashdata('sukses', 'Data Handphone Berhasil Diimport');
        return redirect()->to(base_url('namahandphone'));
    }
}
