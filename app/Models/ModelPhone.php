<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPhone extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['kode_barang', 'stok_minimum', 'nama_barang', 'harga', 'harga_beli', 'input', 'idkategori', 'imei', 'jenis_hp', 'hpp', 'internal', 'warna', 'status_ppn', 'status', 'deleted', 'status_barang', 'nama_barang_id'];

    public function getPhoneActive()
    {
        return $this
            ->where('barang.idkategori', 1)
            ->where('barang.status', '1')
            ->where('barang.deleted', '0')
            ->findAll();
    }
    public function getPhoneWaiting()
    {
        return $this
            ->where('barang.idkategori', 1)
            ->where('barang.status', '0')
            ->where('barang.deleted', '0')
            ->findAll();
    }
    public function getPhone()
    {
        return $this
            ->where('barang.idkategori', 1)
            ->where('barang.deleted', '0')
            ->findAll();
    }

    public function insert_Phone($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this
            ->where('barang.idbarang', $id)
            ->first();
    }
}
