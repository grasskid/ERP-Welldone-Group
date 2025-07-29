<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenilaianKPI extends Model
{
    protected $table = 'penilaian_kpi';
    protected $primaryKey = 'idpenilaian_kpi';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idpenilaian_kpi',
        'kpi_utama',
        'bobot',
        'target',
        'realisasi',
        'score',
        'pegawai_idpegawai',
        'tanggal_penilaian_kpi',
        'created_on',
        'updated_on'
    ];

    public function insertKPI($kpi_utama, $bobot, $target, $ar_target, $score, $pegawai_idpegawai, $tanggal_penilaian_kpi)
    {
        $data = [
            'kpi_utama'             => $kpi_utama,
            'bobot'                 => $bobot,
            'target'                => $target,
            'realisasi'             => $ar_target[0] ?? 0,
            'score'                 => $score[0] ?? 0,
            'pegawai_idpegawai'     => $pegawai_idpegawai,
            'tanggal_penilaian_kpi' => date('Y-m-d', strtotime($tanggal_penilaian_kpi)),
            'created_on'            => date('Y-m-d H:i:s'),
            'updated_on'            => date('Y-m-d H:i:s'),
        ];

        return $this->insert($data);
    }

    public function getAllKPI()
    {
        return $this->select('penilaian_kpi.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = penilaian_kpi.pegawai_idpegawai', 'left')
            ->findAll();
    }

    public function getById($idpenilaian_kpi)
    {
        return $this->where(['idpenilaian_kpi' => $idpenilaian_kpi])->first();
    }

    public function getByPegawai($pegawai_id)
    {
        return $this->where(['pegawai_idpegawai' => $pegawai_id])->findAll();
    }
}