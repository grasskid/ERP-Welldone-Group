<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKerusakan extends Model
{
    protected $table = 'fungsi';
    protected $primaryKey = 'idfungsi';
    protected $returnType = 'object';
    protected $allowedFields = ['idfungsi', 'nama_fungsi', 'deleted'];

    public function getKerusakan()
    {
        return $this->where('deleted', 0)->findAll();
    }

    public function insert_Kerusakan($data)
    {
        return $this->insert($data);
    }
}
