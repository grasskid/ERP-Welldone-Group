<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTugasTemplate extends Model
{
    protected $table = 'tugas_template';
    protected $primaryKey = 'idtemplate_tugas';
    protected $returnType = 'object';
    protected $allowedFields = ['idtemplate_tugas', 'nama_tugas', 'deskripsi', 'start_date', 'end_date', 'ID_JABATAN'];

    public function getTugasTemplate()
    {
        return $this->findAll();
    }

    public function getTugasTemplateByAkun($id_akun)
    {
        return $this->select('tugas_template.*, akun.NAMA_AKUN, akun.ID_UNIT, unit.NAMA_UNIT, unit.idunit')
            ->join('akun', 'akun.ID_JABATAN = tugas_template.ID_JABATAN')
            ->join('unit', 'unit.idunit = akun.ID_UNIT')
            ->where('akun.ID_AKUN', $id_akun)
            ->findAll();
    }

    public function getAllTugasWithAkun()
    {
        return $this->select('tugas_template.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_JABATAN = tugas_template.ID_JABATAN')
            ->findAll();
    }

    public function insert_TugasTemplate($data)
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