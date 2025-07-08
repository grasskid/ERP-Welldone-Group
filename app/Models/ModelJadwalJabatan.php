<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJadwalJabatan extends Model
{
    protected $table = 'jadwal_jabatan';
    protected $primaryKey = 'idjadwal_jabatan';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idjadwal_jabatan',
        'jj_idjadwal_masuk',
        'jj_idjabatan',

    ];

    public function getAll()
    {
        return $this->findAll();
    }

    public function getById($id)
    {
        return $this->where(['idjadwal_jabatan' => $id])->first();
    }

    public function insertJadwal($data)
    {
        return $this->insert($data);
    }
}
