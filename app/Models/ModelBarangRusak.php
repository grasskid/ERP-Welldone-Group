<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangRusak extends Model
{
    protected $table = 'barang_rusak';
    protected $primaryKey = 'idbarang_rusak';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idbarang_rusak',
        'idpembelian',
        'no_nota_sup',
        'barang_idbarang',
        'tanggal_rusak',
        'unit_idunit',
        'input_by',
        'created_at',
        'keterangan'
    ];

    public function getBarangRusak()
    {
        return $this->select('
                barang_rusak.*, 
                barang.kode_barang, 
                barang.nama_barang, 
                barang.imei
            ')
            ->join('barang', 'barang.idbarang = barang_rusak.barang_idbarang', 'left')
            ->orderBy('barang_rusak.idbarang_rusak', 'DESC')
            ->findAll();
    }


    public function getById($idbarang_rusak)
    {
        return $this->select('
                barang_rusak.*, 
                barang.kode_barang, 
                barang.nama_barang, 
                barang.imei
            ')
            ->join('barang', 'barang.idbarang = barang_rusak.barang_idbarang', 'left')
            ->where('barang_rusak.idbarang_rusak', $idbarang_rusak)
            ->first();
    }
}
