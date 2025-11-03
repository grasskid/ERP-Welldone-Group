<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNamaHandphone extends Model
{
    protected $table = 'nama_handphone';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'nama', 'type', 'size'];

    public function getNamaHandphone()
    {
        return $this->findAll();
    }

    public function getNamaHandphoneById($id)
    {
        return $this
            ->where('nama_handphone.id', $id)
            ->first();
    }
}
