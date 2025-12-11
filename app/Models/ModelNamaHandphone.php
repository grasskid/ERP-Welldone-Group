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
        //for push ulang
        return $this->findAll();
    }

    public function insertNamaHandphone($data)
    {
        return $this->insert($data);
    }

    public function updateNamaHandphone($id, $data)
    {
        return $this->db->table($this->table)
            ->where('id', $id)
            ->update($data);
    }


    public function deleteNamaHandphone($id)
    {
        return $this->delete($id);
    }

    public function getNamaHandphoneById($id)
    {
        return $this
            ->where('nama_handphone.id', $id)
            ->first();
    }
}
