<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNoAkun extends Model
{
    protected $table = 'no_akun';
    protected $primaryKey = 'no_akun';
    protected $returnType = 'object';
    protected $allowedFields = ['no_akun', 'nama_akun', 'jenis_akun'];

    public function getAkun()
    {

        return $this->findAll();
    }

    public function getByNoAkun($no_akun)
    {
        return $this->where('no_akun', $no_akun)->first();
    }
}
