<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPhone extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga', 'input', 'idkategori', 'imei', 'jenis_hp', 'hpp', 'internal', 'warna', 'status', 'deleted'];

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
