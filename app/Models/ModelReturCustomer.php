<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReturCustomer extends Model
{
    protected $table = 'retur_pelanggan';
    protected $primaryKey = 'idretur_pelanggan';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idretur_pelanggan',
        'no_retur_pelanggan',
        'tanggal',
        'jumlah',
        'satuan',
        'barang_idbarang',
        'detail_penjualan_iddetail_penjualan',
        'input_by'
    ];

    public function getReturCustomer()
    {
        return $this->findAll();
    }

    public function insert_ReturCustomer($data)
    {
        return $this->insert($data);
    }

    public function getById($id)
    {
        return $this->where(['idretur_pelanggan' => $id])->first();
    }
}