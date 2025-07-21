<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategoriKas extends Model
{
    protected $table = 'kategori_kas';
    protected $primaryKey = 'idkategori_kas';
    protected $returnType = 'object';
    protected $allowedFields = ['idkategori_kas', 'kategori', 'kode_template_jurnal', 'jenis_kas'];

    public function getKategoriKas()
    {
        return $this->findAll();
    }

    public function insert_KategoriKas($data)
    {
        return $this->insert($data);
    }

    public function getById($idkategori_kas)
    {
        return $this->where(['idkategori_kas' => $idkategori_kas])->first();
    }

}