<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBundle extends Model
{
    protected $table = 'detail_bundle';
    protected $primaryKey = 'iddetail_bundle';
    protected $returnType = 'object';
    protected $allowedFields = ['iddetail_bundle', 'bundle_idbundle', 'barang_idbarang', 'jumlah', 'harga'];

    public function getDetailBundle()
    {
        return $this->findAll();
    }

    public function deleteByBundle($idbundle)
    {
        return $this->where('bundle_idbundle', $idbundle)->delete();
    }


    public function getByBundleId($bundleId)
    {
        return $this->select('detail_bundle.*, barang.kode_barang, barang.nama_barang, barang.warna, barang.internal, barang.imei,barang.jenis_hp')
            ->join('barang', 'barang.idbarang = detail_bundle.barang_idbarang', 'left')
            ->where('detail_bundle.bundle_idbundle', $bundleId)
            ->findAll();
    }
}
