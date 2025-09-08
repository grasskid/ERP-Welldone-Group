<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTugasTemplate extends Model
{
    protected $table = 'tugas_template';
    protected $primaryKey = 'idtemplate_tugas';
    protected $returnType = 'object';
    protected $allowedFields = ['idtemplate_tugas', 'nama_tugas', 'deskripsi', 'start_date', 'end_date', 'ID_JABATAN', 'template_penilaian_idtemplate_penilaian', 'template_kpi_idtemplate_kpi'];

    public function getTugasTemplate()
    {
        return $this->findAll();
    }

public function getTugasTemplateByAkun()
{
    return $this->select('
        tugas_template.*,
        jabatan.NAMA_JABATAN,
        unit.NAMA_UNIT
    ')
    ->join('jabatan', 'jabatan.ID_JABATAN = tugas_template.ID_JABATAN', 'left')
    ->join('akun', 'akun.ID_JABATAN = tugas_template.ID_JABATAN', 'left')
    ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
    ->groupBy('tugas_template.idtemplate_tugas') // prevent duplication
    ->findAll();
}

    public function getAllTugasWithAkun()
    {
        return $this->select('tugas_template.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_JABATAN = tugas_template.ID_JABATAN')
            ->findAll();
    }

    public function insertTugasTemplate($data)
    {
        return $this->insert($data);
    }

    public function getById($idtugas_template)
    {
        return $this->find($idtugas_template);
    }

    public function deleteByAkunAndStatus($akunId)
    {
        return $this->join('akun', 'akun.ID_JABATAN = tugas_template.ID_JABATAN')
            ->where('akun.ID_AKUN', $akunId)
            ->delete();
    }
}