<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSuplier extends Model
{
    protected $table = 'suplier';
    protected $primaryKey = 'id_suplier';
    protected $returnType = 'object';
    protected $allowedFields = ['nama_suplier', 'alamat', 'no_hp', 'deleted'];

    public function getSuplier()
    {
        return $this->where('deleted', '0')->findAll();
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
