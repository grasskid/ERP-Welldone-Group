<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'idkategori', 'nama_kategori', 'delete'];

    public function getKategori()
    {
        return $this->where('delete', 0)->findAll();
    }

    public function getKategoriTanpaId7()
    {
        return $this->where('delete', '0')
            ->where('id !=', 1)
            ->findAll();
    }


    public function insert_Kategori($data)
    {
        return $this->insert($data);
    }

    public function getById($idkategori)
    {
        return $this->where(['idkategori' => $idkategori])->first();
    }

    public function getByName($nama_kategori)
    {
        return $this->where(['nama_kategori' => $nama_kategori])->first();
    }
}
