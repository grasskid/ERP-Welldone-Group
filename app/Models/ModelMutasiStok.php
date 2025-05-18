<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMutasiStok extends Model
{
    protected $table = 'mutasi';
    protected $primaryKey = 'idmutasi';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idmutasi',
        'no_nota_mutasi',
        'tanggal_kirim',
        'tanggal_terima',
        'status',
        'kirim_idunit',
        'terima_idunit',
        'input_by',
        'created_on',
        'updated_on',

    ];

    public function getMutasiStok()
    {
        return $this->findAll();
    }

    public function insert_MutasiStok($data)
    {
        return $this->insert($data);
    }

    public function getById($idmutasi)
    {
        return $this->where(['idmutasi' => $idmutasi])->first();
    }
}
