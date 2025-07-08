<?php

namespace App\Controllers;

use App\Models\Core;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use App\Models\ModelPenjualan;
use App\Models\ModelPelanggan;
use App\Models\ModelService;

class Home extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $PenjualanModel;
    protected $PelangganModel;
    protected $ServiceModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->PenjualanModel = new ModelPenjualan();
        $this->PelangganModel = new ModelPelanggan();
        $this->ServiceModel = new ModelService();
    }
    
public function index()
{
    $unit_id = $this->request->getGet('unit_idunit');

    $akun = $this->AuthModel->getById(session('ID_AKUN'));
    $unitModel = new \App\Models\ModelUnit();

    $months = [];
    $pendapatan_chart = [];
    $pendapatan_service_chart = [];

    for ($i = 5; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i month"));
        $months[] = date('M Y', strtotime($month));

        $total_pos = $this->PenjualanModel
            ->where('DATE_FORMAT(tanggal, "%Y-%m")', $month)
            ->where($unit_id ? ['unit_idunit' => $unit_id] : [])
            ->selectSum('total_penjualan')
            ->first()->total_penjualan ?? 0;

        $total_service = $this->ServiceModel
            ->where('DATE_FORMAT(tanggal_selesai, "%Y-%m")', $month)
            ->where(['status_service' => 4])
            ->where($unit_id ? ['unit_idunit' => $unit_id] : [])
            ->selectSum('harus_dibayar')
            ->get()
            ->getRow()
            ->harus_dibayar ?? 0;

        $pendapatan_chart[] = (float) $total_pos;
        $pendapatan_service_chart[] = (float) $total_service;
    }

    $data = array(
        'akun' => $akun,
        'unit_id' => $unit_id,
        'units' => $unitModel->findAll(),
        'stok' => $this->KartuStokModel->getKartuStokWithKategori(),
        'penjualan' => $this->PenjualanModel->getPendapatan($unit_id),
        'pendapatan_service' => $this->ServiceModel->getTotalPendapatanService($unit_id),
        'pelanggan' => count($this->PelangganModel->getPelanggan()),
        'pelanggan_service' => count($this->PelangganModel->getPelangganWithService()),
        'pelanggan_baru' => count($this->PelangganModel->getPelangganBaruBulanIni()),
        'months' => $months,
        'pendapatan_chart' => $pendapatan_chart,
        'pendapatan_service_chart' => $pendapatan_service_chart,
        'title' => 'Home',
        'body' => 'welcome_message'
    );

    return view('template', $data);
}

}