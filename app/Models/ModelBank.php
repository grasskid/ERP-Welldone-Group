<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBank extends Model
{
    protected $table = 'bank';
    protected $primaryKey = 'idbank';
    protected $returnType = 'object';
    protected $allowedFields = ['idbank', 'nama_bank', 'atas_nama', 'norek', 'gambar_qris', 'created_on', 'updated_on'];

    public function getBank()
    {

        return $this->findAll();
    }
}