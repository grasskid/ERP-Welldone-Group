<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKasKeluar extends Model
{
    protected $table = 'kas_keluar';
    protected $primaryKey = 'idkas_keluar';
    protected $returnType = 'object';
    protected $allowedFields = ['idkas_keluar', 'tanggal', 'kategori_idkategori', 'deskripsi', 'jumlah', 'penerima', 'idunit', 'idbank', 'created_on', 'updated_on', 'jenis', 'no_akun'];

    public function getKasKeluar()
    {
        return $this->select('kas_keluar.*, kategori_kas.kategori, bank.nama_bank, bank.norek, unit.NAMA_UNIT')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_keluar.kategori_idkategori')
            ->join('bank', 'bank.idbank = kas_keluar.idbank', 'left')
            ->join('unit', 'unit.idunit = kas_keluar.idunit', 'left')
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


    public function getKasKeluarFiltered($tanggal_awal = null, $tanggal_akhir = null, $nama_unit = null)
    {
        $builder = $this->select('kas_keluar.*, kategori_kas.kategori, bank.nama_bank, bank.norek, unit.NAMA_UNIT')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_keluar.kategori_idkategori')
            ->join('bank', 'bank.idbank = kas_keluar.idbank', 'left')
            ->join('unit', 'unit.idunit = kas_keluar.idunit', 'left');

        // Filter tanggal
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $builder->where('kas_keluar.tanggal >=', $tanggal_awal)
                ->where('kas_keluar.tanggal <=', $tanggal_akhir);
        } elseif (!empty($tanggal_awal)) {
            $builder->where('kas_keluar.tanggal >=', $tanggal_awal);
        } elseif (!empty($tanggal_akhir)) {
            $builder->where('kas_keluar.tanggal <=', $tanggal_akhir);
        }

        // Filter unit
        if (!empty($nama_unit)) {
            $builder->where('unit.NAMA_UNIT', $nama_unit);
        }

        return $builder->findAll();
    }
}
