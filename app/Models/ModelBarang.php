<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    protected $returnType = 'object';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'harga', 'harga_beli', 'input', 'idkategori', 'imei', 'jenis_hp', 'hpp', 'internal', 'warna', 'status', 'deleted', 'status_ppn'];

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


    public function getMaxNumberByKategori($idkategori)
    {
        // Ambil kode kategori berdasarkan idkategori
        $kategori = $this->db->table('kategori')->select('idkategori')->where('id', $idkategori)->get()->getRow();

        if (!$kategori) {
            return 0;
        }

        $kode_kategori = $kategori->idkategori;
        $kode_length = strlen($kode_kategori);

        // Cari angka terbesar di belakang kode_barang
        $builder = $this->db->table('barang');
        $builder->select("MAX(CAST(SUBSTRING(kode_barang, $kode_length + 1) AS UNSIGNED)) AS max_number");
        $builder->where('idkategori', $idkategori);
        $query = $builder->get();
        $row = $query->getRow();

        return ($row && $row->max_number !== null) ? $row->max_number : 0;
    }
}
