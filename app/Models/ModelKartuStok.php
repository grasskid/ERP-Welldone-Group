<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKartuStok extends Model
{
    protected $table = 'stok_barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idbarang',
        'idretur_pelanggan',
        'kode_barang',
        'id_unit',
        'nama_unit',
        'stok_dasar',
        'sumber_stok_dasar',
        'tanggal_stok_dasar',
        'total_pembelian',
        'total_penjualan',
        'total_retur_pelanggan',
        'total_retur_suplier',
        'stok_akhir'
    ];

    public function getKartuStok()
    {
        return $this->findAll();
    }



    public function insert_getKartuStok($data)
    {
        return $this->insert($data);
    }

    public function getById($id)
    {
        return $this->where(['idbarang' => $id])->first();
    }


    public function getKartuStokWithKategori()
    {
        return $this->select('stok_barang.*, barang.status_ppn, kategori.nama_kategori')
            ->join('barang', 'barang.kode_barang = stok_barang.kode_barang', 'left')
            ->join('kategori', 'kategori.id = barang.idkategori', 'left')
            ->where('barang.deleted', '0')
            ->where('kategori.delete', '0')
            ->findAll();
    }
}
