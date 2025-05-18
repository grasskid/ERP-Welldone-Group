<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\ModelStokOpname;
use App\Models\ModelStokOpnameDraft;

class StokOpname extends BaseController

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
            'stokopname' => $this->StokOpnameModel->getStokOpname(),
            'stokopnamedraft' => $this->StokOpnameDraftModel->getStokOpname(),
            'body'  => 'stok/stok_opname'
        );
        return view('template', $data);
    }

    public function loadTable()
    {
        $table = $this->request->getGet('table');

        if ($table === 'tabledaraft') {
            $data['stok'] = $this->KartuStokModel->getKartuStok();
            return view('stok/table/stok_opnamedraft_table', $data);
        } elseif ($table === 'tablefix') {
            $data['stok'] = $this->KartuStokModel->getKartuStok();
            $data['stokopname'] = $this->StokOpnameDraftModel->getStokOpnameDraft();
            return view('stok/table/stok_opname_table', $data);
        }

        return 'Invalid table name';
    }

    public function simpan()
{
    $data = $this->request->getPost('data');

    if ($data && is_array($data)) {
        foreach ($data as $row) {
            $this->StokOpnameDraftModel->insert_StokOpnameDraft([
                'tanggal' => date('Y-m-d'),
                'hpp' => 0,
                'jumlah_real' => $row['jumlah_real'],
                'jumlah_komp' => $row['jumlah_komp'],
                'jumlah_selisih' => $row['jumlah_real'] - $row['jumlah_komp'],
                'satuan_terkecil' => '',
                'barang_idbarang' => $row['barang_idbarang'],
                'unit_idunit' => $row['unit_idunit']
            ]);
        }
    }

    return redirect()->to(base_url('stok_opname'))->with('message', 'Data stok opname berhasil disimpan.');
}

public function simpanFix()
{
    $tanggalHariIni = date('Y-m-d');

    $existing = $this->StokOpnameModel
        ->where('tanggal', $tanggalHariIni)
        ->countAllResults();

    if ($existing > 0) {
        return redirect()->to(base_url('stok_opname'))
            ->with('error', 'Stok opname untuk hari ini sudah pernah disimpan.');
    }

    // Continue with insertion
    $jumlah_real = $this->request->getPost('jumlah_real');
    $jumlah_komp = $this->request->getPost('jumlah_komp');
    $barang_id = $this->request->getPost('barang_idbarang');
    $unit_id = $this->request->getPost('unit_idunit');

    if (is_array($jumlah_real)) {
        for ($i = 0; $i < count($jumlah_real); $i++) {
            $this->StokOpnameModel->insert_StokOpnameFix([
                'tanggal' => $tanggalHariIni,
                'hpp' => 0,
                'jumlah_real' => $jumlah_real[$i],
                'jumlah_komp' => $jumlah_komp[$i],
                'jumlah_selisih' => $jumlah_real[$i] - $jumlah_komp[$i],
                'satuan_terkecil' => '',
                'barang_idbarang' => $barang_id[$i],
                'unit_idunit' => $unit_id[$i]
            ]);
        }
    }

    return redirect()->to(base_url('stok_opname'))->with('message', 'Data stok opname berhasil disimpan.');
}

}