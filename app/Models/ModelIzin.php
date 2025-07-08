<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelIzin extends Model
{
    protected $table = 'izin';
    protected $primaryKey = 'idizin';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idizin',
        'alasan',
        'status',
        'tanggal_mulai',
        'uuid_atasan',
        'pegawai_uuid',
        'tanggal_akhir',
        'file',
        'balasan',
        'jenis_perizinan_idjenis_perizinan'
    ];


    public function getAll()
    {
        return $this->findAll();
    }


    public function getById($id)
    {
        return $this->where(['idizin' => $id])->first();
    }

    public function insertIzin($data)
    {
        return $this->insert($data);
    }

    // Ambil data izin berdasarkan pegawai
    public function getByPegawai($uuid)
    {
        return $this->where(['pegawai_uuid' => $uuid])->findAll();
    }

    // Ambil data izin berdasarkan status
    public function getByStatus($status)
    {
        return $this->where(['status' => $status])->findAll();
    }

    // Ambil data izin beserta jenis perizinannya
    public function getWithJenisPerizinan()
    {
        return $this->select('izin.*, jenis_perizinan.jenis_izin')
            ->join('jenis_perizinan', 'jenis_perizinan.idjenis_perizinan = izin.jenis_perizinan_idjenis_perizinan')
            ->findAll();
    }

    // Ambil data izin pegawai tertentu dengan jenis perizinan
    public function getByPegawaiWithJenis($uuid)
    {
        return $this->select('izin.*, jenis_perizinan.jenis_izin')
            ->join('jenis_perizinan', 'jenis_perizinan.idjenis_perizinan = izin.jenis_perizinan_idjenis_perizinan')
            ->where('pegawai_uuid', $uuid)
            ->findAll();
    }
}
