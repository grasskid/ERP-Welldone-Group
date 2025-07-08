<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJadwalMasuk extends Model
{
    protected $table = 'jadwal_masuk';
    protected $primaryKey = 'idjadwal_masuk';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idjadwal_masuk',
        'nama_jadwal',
        'jam_masuk',
        'jam_pulang',
        'total_jamkerja',
        'jml_wfh',
        'jml_wfo',
        'jenis',
        'toleransi'
    ];

    public function getAll()
    {
        return $this->findAll();
    }

    public function getById($id)
    {
        return $this->where(['idjadwal_masuk' => $id])->first();
    }

    public function insertJadwal($data)
    {
        return $this->insert($data);
    }

    public function getByJenis($jenis)
    {
        return $this->where('jenis', $jenis)->findAll();
    }

    public function getWFOOnly()
    {
        return $this->where('jenis', 1)->findAll(); // 1 = WFO
    }

    public function getWFHOnly()
    {
        return $this->where('jenis', 2)->findAll(); // 2 = WFH
    }
}
