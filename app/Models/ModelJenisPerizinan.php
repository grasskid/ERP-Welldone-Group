<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJenisPerizinan extends Model
{
    protected $table = 'jenis_perizinan';
    protected $primaryKey = 'idjenis_perizinan';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idjenis_perizinan',
        'jenis_izin'
    ];

    public function getAll()
    {
        return $this->findAll();
    }

    public function getById($id)
    {
        return $this->where(['idjenis_perizinan' => $id])->first();
    }

    public function insertJenisPerizinan($data)
    {
        return $this->insert($data);
    }

    public function getByName($jenis_izin)
    {
        return $this->where(['jenis_izin' => $jenis_izin])->first();
    }
}
