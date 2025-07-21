<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAsset extends Model
{
    protected $table = 'asset';
    protected $primaryKey = 'idasset';
    protected $returnType = 'object';
    protected $allowedFields = ['idasset', 'asset_code', 'asset', 'tanggal_perolehan', 'nilai_perolehan', 'penyusutan_bulanan', 'nilai_sekarang', 'kondisi', 'keterangan'];

    public function getAsset()
    {
        return $this->findAll();
    }

    public function insert_Asset($data)
    {
        return $this->insert($data);
    }
}
