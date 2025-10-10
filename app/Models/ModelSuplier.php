<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSuplier extends Model
{
    protected $table = 'suplier';
    protected $primaryKey = 'id_suplier';
    protected $returnType = 'object';
    protected $allowedFields = ['id_suplier', 'nama_suplier', 'alamat', 'no_hp', 'deleted', 'unit_idunit'];

    public function getSuplier()
    {
        return $this->select('suplier.*, unit.NAMA_UNIT as nama_unit')
            ->join('unit', 'unit.idunit = suplier.unit_idunit', 'left')
            ->where('suplier.deleted', '0')
            ->findAll();
    }


    public function insert_Suplier($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this->where(['id_suplier' => $id])->first();
    }
}
