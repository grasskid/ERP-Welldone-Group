<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategoriAsset extends Model
{
    protected $table = 'kategori_asset';
    protected $primaryKey = 'idkategori_asset';
    protected $returnType = 'object';
    protected $allowedFields = ['idkategori_asset', 'kategori_asset', 'deleted', 'created_on', 'updated_on'];

    public function getKategoriAsset()
    {

        return $this->where('deleted', '0')->findAll();
    }

    public function insertAsset($data)
    {
        return $this->insert($data);
    }

    public function getById($idkategori_asset)
    {
        return $this->where(['idkategori_asset' => $idkategori_asset])->first();
    }
}
