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
}
