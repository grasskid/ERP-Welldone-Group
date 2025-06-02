<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelHppBarang extends Model
{
    protected $table = 'hpp_barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['idbarang', 'kode_barang', 'idkategori', 'harga_beli', 'hpp'];

    public function getHppBarang()
    {
        return $this->findAll();
    }

    public function insert_HppBarang($data)
    {
        return $this->insert($data);
    }

    public function getById($idbarang)
    {
        return $this->where(['idbarang' => $idbarang])->first();
    }
}
