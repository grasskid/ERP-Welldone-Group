<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKasKeluar extends Model
{
    protected $table = 'kas_keluar';
    protected $primaryKey = 'idkas_keluar';
    protected $returnType = 'object';
    protected $allowedFields = ['idkas_keluar', 'tanggal', 'kategori_idkategori', 'deskripsi', 'jumlah', 'penerima', 'idunit', 'created_on', 'updated_on'];

    public function getKasKeluar()
    {
    return $this->select('kas_keluar.*, kategori_kas.kategori')
                ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_keluar.kategori_idkategori')
                ->findAll();
    }

    public function insert_KasKeluar($data)
    {
        return $this->insert($data);
    }

    public function getById($idkas_keluar)
    {
        return $this->where(['idkas_keluar' => $idkas_keluar])->first();
    }

}