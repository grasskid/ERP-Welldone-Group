<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKasMasuk extends Model
{
    protected $table = 'kas_masuk';
    protected $primaryKey = 'idkas_masuk';
    protected $returnType = 'object';
    protected $allowedFields = ['idkas_masuk', 'tanggal', 'kategori_idkategori', 'deskripsi', 'jumlah', 'penerima', 'idunit', 'idbank', 'created_on', 'updated_on', 'jenis', 'no_akun'];

    public function getKasMasuk()
    {
        return $this->select('kas_masuk.*, kategori_kas.kategori, bank.nama_bank, bank.norek, unit.NAMA_UNIT')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_masuk.kategori_idkategori')
            ->join('bank', 'bank.idbank = kas_masuk.idbank', 'left')
            ->join('unit', 'unit.idunit = kas_masuk.idunit', 'left')
            ->findAll();
    }



    public function insert_KasMasuk($data)
    {
        return $this->insert($data);
    }


    public function getKasMasukFiltered($tanggal_awal = null, $tanggal_akhir = null, $nama_unit = null)
    {
        $builder = $this->select('kas_masuk.*, kategori_kas.kategori, bank.nama_bank, bank.norek, unit.NAMA_UNIT')
            ->join('kategori_kas', 'kategori_kas.idkategori_kas = kas_masuk.kategori_idkategori')
            ->join('bank', 'bank.idbank = kas_masuk.idbank', 'left')
            ->join('unit', 'unit.idunit = kas_masuk.idunit', 'left');

        // Filter tanggal
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $builder->where('kas_masuk.tanggal >=', $tanggal_awal)
                ->where('kas_masuk.tanggal <=', $tanggal_akhir);
        } elseif (!empty($tanggal_awal)) {
            $builder->where('kas_masuk.tanggal >=', $tanggal_awal);
        } elseif (!empty($tanggal_akhir)) {
            $builder->where('kas_masuk.tanggal <=', $tanggal_akhir);
        }

        // Filter unit
        if (!empty($nama_unit)) {
            $builder->where('unit.NAMA_UNIT', $nama_unit);
        }

        return $builder->findAll();
    }


    public function getById($idkas_masuk)
    {
        return $this->where(['idkas_masuk' => $idkas_masuk])->first();
    }
}
