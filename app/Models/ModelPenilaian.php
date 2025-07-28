<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenilaian extends Model
{
    protected $table            = 'penilaian';
    protected $primaryKey       = 'idpenilaian';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'aspek',
        'keterangan',
        'skor',
        'pegawai_idpegawai',
        'tanggal_penilaian',
        'created_on',
        'updated_on'
    ];

    public function getPenilaian()
    {
        return $this->select('penilaian.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = penilaian.pegawai_idpegawai', 'left')
            ->findAll();
    }

    public function insertPenilaian($data)
    {
        return $this->insert($data);
    }


    public function getPenilaianByTanggal($tanggalAwal, $tanggalAkhir)
    {
        return $this->select('penilaian.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = penilaian.pegawai_idpegawai', 'left')
            ->where('tanggal_penilaian >=', $tanggalAwal)
            ->where('tanggal_penilaian <=', $tanggalAkhir)
            ->findAll();
    }
}
