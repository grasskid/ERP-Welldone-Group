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
        return $this->select('penilaian_kpi.*, akun.NAMA_AKUN, template_kpi.template_kpi AS nama_template')
            ->join('akun', 'akun.ID_AKUN = penilaian_kpi.pegawai_idpegawai', 'left')
            ->join('template_kpi', 'template_kpi.template_kpi = penilaian_kpi.kpi_utama', 'left')
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

    public function getJumlahByTemplateKPI($id_akun = null)
    {
        $builder = $this->db->table('tugas')
            ->select('
            template_kpi.idtemplate_kpi,
            template_kpi.template_kpi,
            tugas.jumlah
        ')
            ->join('template_kpi', 'template_kpi.idtemplate_kpi = tugas.template_kpi_idtemplate_kpi', 'left')
            ->where('tugas.status', 4); // only status = 4

        if ($id_akun) {
            $builder->where('tugas.akun_ID_AKUN', $id_akun);
        }

        return $builder->get()->getResult();
    }
}
