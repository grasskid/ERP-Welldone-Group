<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'idpenjualan';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idpenjualan',
        'kode_invoice',
        'tanggal',
        'keterangan',
        'total_penjualan',
        'diskon',
        'harus_dibayar',
        'waktu_penjualan',
        'bayar',
        'id_pelanggan',
        'total_ppn',
        'created_on',
        'input_by',
        'sales_by',
        'unit_idunit'
    ];



    public function getPenjualan()
    {
        return $this->findAll();
    }



    public function insert_Penjualan($data)
    {
        return $this->insert($data);
    }

    public function getById($idpenjulan)
    {
        return $this->where(['idpenjulan' => $idpenjulan])->first();
    }


    public function getByKodeInvoice($kode_invoice)
    {
        return $this->where(['kode_invoice' => $kode_invoice])->first();
    }

    public function getPendapatan($unit_id = null, $per_bulan = false)
{
    if ($per_bulan) {
        $this->select("DATE_FORMAT(created_at, '%Y-%m') AS bulan, SUM(total_penjualan) AS total")
             ->groupBy("bulan")
             ->orderBy("bulan", "ASC");

        if ($unit_id) {
            $this->where('unit_idunit', $unit_id);
        }

        return $this->findAll();
    }

    $this->selectSum('total_penjualan');

    if ($unit_id) {
        $this->where('unit_idunit', $unit_id);
    }

    return $this->first()->total_penjualan ?? 0;
}

}