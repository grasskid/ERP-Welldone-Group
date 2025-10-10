<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenilaianDetail extends Model
{
    protected $table            = 'penilaian_detail';
    protected $primaryKey       = 'iddetail_penilaian';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'template_penilaian_idtemplate_penilaian',
        'skor',
        'pegawai_idpegawai',
        'tanggal_penilaian',
        'created_on',
        'updated_on',
        'penilaian_idpenilaian'
    ];

    public function getPenilaianDetail()
    {
        return $this->select('penilaian_detail.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = penilaian_detail.pegawai_idpegawai', 'left')
            ->findAll();
    }

    public function insertPenilaianDetail($data)
    {
        return $this->insert($data);
    }


    public function getPenilaianDetailByTanggal($tanggalAwal, $tanggalAkhir)
    {
        return $this->select('penilaian.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = penilaian.pegawai_idpegawai', 'left')
            ->where('tanggal_penilaian >=', $tanggalAwal)
            ->where('tanggal_penilaian <=', $tanggalAkhir)
            ->findAll();
    }
    
}