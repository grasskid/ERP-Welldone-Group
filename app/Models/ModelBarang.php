<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga', 'harga_beli', 'input', 'idkategori', 'imei', 'jenis_hp', 'internal', 'warna', 'status', 'deleted', 'status_ppn'];

    public function getBarang()
    {
        return $this->select('barang.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = barang.idkategori')
            ->where('barang.deleted', '0')
            ->where('kategori.delete', '0')
            ->where('barang.idkategori !=', 1)
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

        return $this->select('barang.*, kategori.nama_kategori, stok_barang.stok_akhir')
            ->join('kategori', 'kategori.id = barang.idkategori')
            ->join('stok_barang', 'stok_barang.idbarang = barang.idbarang AND stok_barang.id_unit = ' . (int)$id_unit, 'left')
            ->where('barang.deleted', 0)
            ->where('kategori.delete', 0)
            ->where('stok_barang.stok_akhir >', 0)
            ->findAll();
    }


    public function insert_Barang($data)
    {
        return $this->insert($data);
    }


    public function getById($idbarang)
    {
        return $this->where(['idbarang' => $idbarang])->first();
    }

    public function getBykode($kodeBarang)
    {
        return $this->where(['kode_barang' => $kodeBarang])->first();
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
            ->where('barang.idkategori', 3)
            ->findAll();
    }
}
