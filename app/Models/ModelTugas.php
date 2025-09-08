<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTugas extends Model
{
    protected $table = 'tugas';
    protected $primaryKey = 'idtugas';
    protected $returnType = 'object';
    protected $allowedFields = ['idtugas', 'nama_tugas', 'deskripsi', 'foto_tugas', 'status_template', 'start_date', 'end_date', 'akun_ID_AKUN', 'status', 'created_at', 'updated_at', 'template_penilaian_idtemplate_penilaian', 'jumlah', 'template_kpi_idtemplate_kpi',];

    public function getTugas()
    {
        return $this->findAll();
    }

    public function getTugasByAkun($id_akun)
    {
        return $this->select('tugas.*, akun.NAMA_AKUN, akun.ID_UNIT, unit.NAMA_UNIT, unit.idunit')
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->join('unit', 'unit.idunit = akun.ID_UNIT')
            ->where('akun_ID_AKUN', $id_akun)
            ->findAll();
    }


    public function getAllTugasWithAkun2($id_akun, $tanggal_awal = null, $tanggal_akhir = null, $id_unit = null)
    {
        $builder = $this->select('tugas.*, akun.NAMA_AKUN, akun.ID_UNIT, unit.NAMA_UNIT')
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->join('unit', 'unit.idunit = akun.ID_UNIT');


        if ($tanggal_awal && $tanggal_akhir) {
            $builder->where('DATE(tugas.created_at) >=', $tanggal_awal);
            $builder->where('DATE(tugas.created_at) <=', $tanggal_akhir);
        }

        if ($id_unit) {
            $builder->where('akun.ID_UNIT', $id_unit);
        }

        return $builder->findAll();
    }




    public function getTugasByAkun2($idakun, $tanggal_awal = null, $tanggal_akhir = null)
    {
        $builder = $this->select('tugas.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->where('tugas.akun_ID_AKUN', $idakun);


        if ($tanggal_awal) {
            $builder->where('DATE(tugas.created_at) >=', $tanggal_awal);
        }
        if ($tanggal_akhir) {
            $builder->where('DATE(tugas.created_at) <=', $tanggal_akhir);
        }

        return $builder->orderBy('tugas.created_at', 'DESC')->findAll();
    }



    public function getAllTugasWithAkun()
    {
        return $this->select('tugas.*, akun.NAMA_AKUN')
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->findAll();
    }


    public function insert_Tugas($data)
    {
        return $this->insert($data);
    }

    public function getById($idtugas)
    {
        return $this->find($idtugas);
    }

    public function deleteById($idtemplate_tugas)
    {
    return $this->delete($idtemplate_tugas);
    }

}