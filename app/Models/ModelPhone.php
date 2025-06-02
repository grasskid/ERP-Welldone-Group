<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPhone extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga', 'harga_beli', 'input', 'idkategori', 'imei', 'jenis_hp', 'hpp', 'internal', 'warna', 'status_ppn', 'status', 'deleted', 'status_barang'];

    public function getPhoneActive()
    {
        return $this->where('idkategori', 1)
            ->where('status', '1')
            ->where('deleted', '0')
            ->findAll();
    }
    public function getPhoneWaiting()
    {
        return $this->where('idkategori', 1)
            ->where('status', '0')
            ->where('deleted', '0')
            ->findAll();
    }
    public function getPhone()
    {
        return $this->where('idkategori', 1)
            ->where('deleted', '0')
            ->findAll();
    }

    public function insert_Phone($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this->where(['id_phone' => $id])->first();
    }
}
