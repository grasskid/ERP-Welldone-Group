<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'ID_JABATAN';
    protected $returnType = 'object';
    protected $allowedFields = ['ID_JABATAN', 'NAMA_JABATAN', 'ROLES_JABATAN'];

    public function getJabatan()
    {

        return $this->findAll();
    }
}
