<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRiwayatAsset extends Model
{
    protected $table = 'riwayat_asset';
    protected $primaryKey = 'idriwayat_asset';
    protected $returnType = 'object';
    protected $allowedFields = ['idriwayat_asset', 'asset_idasset', 'penyusutan', 'nilai_riwayat', 'tanggal_penyusutan'];

    public function getRiwayatAsset()
    {
        return $this->select('
                riwayat_asset.*, 
                asset.asset AS nama_asset, 
                asset.asset_code, 
                asset.tanggal_perolehan, 
                asset.nilai_perolehan
            ')
            ->join('asset', 'asset.idasset = riwayat_asset.asset_idasset')
            ->where('asset.deleted', 0)
            ->findAll();
    }

    public function getById($idriwayatasset)
    {
        return $this->where(['idriwayat_asset' => $idriwayatasset])->first();
    }
}
