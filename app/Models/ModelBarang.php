<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga', 'harga_beli', 'input', 'idkategori', 'id_sub_kategori', 'imei', 'stok_minimum', 'jenis_hp', 'internal', 'warna', 'status', 'deleted', 'status_ppn', 'nama_barang_id'];
<<<<<<< HEAD
    // 
=======

>>>>>>> 991fc15cd495b8ffe4d5673847f07a6325d608bc
    public function getBarang()
    {
        return $this->select('barang.*, kategori.nama_kategori, sub_kategori.nama_sub_kategori')
            ->join('kategori', 'kategori.id = barang.idkategori')
            ->join('sub_kategori', 'sub_kategori.id = barang.id_sub_kategori', 'left')
            ->where('barang.deleted', '0')
            ->where('kategori.delete', '0')
            ->where('barang.idkategori !=', 1)
            ->findAll();
    }

    public function semuaBarang()
    {
        return $this
            ->where('barang.deleted', 0)
            ->findAll();
    }

    public function getAllBarang()
    {
        $id_unit = session('ID_UNIT');
        return $this->select('barang.*, kategori.nama_kategori, stok_barang.stok_akhir')
            ->join('kategori', 'kategori.id = barang.idkategori')
            ->join('stok_barang', 'stok_barang.idbarang = barang.idbarang AND stok_barang.id_unit = ' . (int)$id_unit, 'left')
            ->where('barang.deleted', 0)
            ->where('kategori.delete', 0)
            ->findAll();
    }



    public function getAllBarang2()
    {
        $id_unit = session('ID_UNIT');
        return $this
            ->select('barang.*, kategori.nama_kategori, stok_barang.stok_akhir')
            ->join('kategori', 'kategori.id = barang.idkategori')
            ->join('stok_barang', 'stok_barang.idbarang = barang.idbarang AND stok_barang.id_unit = ' . (int)$id_unit, 'left')
            ->where('barang.deleted', 0)
            ->where('kategori.delete', 0)->where('stok_barang.stok_akhir >', 0)->findAll();
    }


    public function insert_Barang($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this
            ->where('barang.idbarang', $id)
            ->first();
    }

    public function getBykode($kodeBarang)
    {
        return $this
            ->where(['kode_barang' => $kodeBarang])
            ->first();
    }

    public function getLastBarangByKategori($idkategori)
    {
        return $this->db->table('barang')
            ->where('idkategori', $idkategori)
            ->orderBy('kode_barang', 'DESC')
            ->get()
            ->getFirstRow();
    }

    public function getBarangSparepart()
    {
        return $this->select('barang.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = barang.idkategori')
            ->where('barang.idkategori', 3)->findAll();
    }
}
