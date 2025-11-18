<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStokHP extends Model
{
    protected $table = 'stok_hp';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id',
        'nama',
        'type',
        'size',
        'id_unit',
        'nama_unit',
        'stok_akhir',
        'stok_awal',
        'stok_opname',
        'total_pembelian',
        'total_mutasi_masuk',
        'total_retur_pelanggan',
        'total_penjualan',
        'total_mutasi_keluar',
        'total_retur_supplier',
        'total_kerusakan'
    ];

    public function getStokHP()
    {
        return $this->findAll();
    }

    public function insert_getStokHP($data)
    {
        return $this->insert($data);
    }

    public function getById($id)
    {
        return $this->where(['id' => $id])->first();
    }

}