<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUnit extends Model
{
    //
    protected $table = 'unit';
    protected $primaryKey = 'idunit';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idunit',
        'NAMA_UNIT',
        'NOID_UNIT',
        'JALAN_UNIT',
        'KELURAHAN_UNIT',
        'KECAMATAN_UNIT',
        'KABUPATEN_UNIT',
        'PROVINSI_UNIT',
        'LATITUDE',
        'LONGTITUDE'
    ];

    //
    public function getUnit(): array
    {
        return $this->findAll();
    }

    public function getUnit2()
    {
        return $this->db->table('unit')
            ->get()->getResult();
    }


    public function insert_Unit($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this->where(['idunit' => $id])->first();
    }
}
