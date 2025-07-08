<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPresensi extends Model
{
    protected $table = 'presensi';
    protected $primaryKey = 'idpresensi';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idpresensi',
        'waktu_masuk',
        'waktu_pulang',
        'jam_jadwal_masuk',
        'jam_jadwal_pulang',
        'jam_toleransi',
        'status_absensi',
        'lat',
        'long',
        'ip',
        'foto',
        'foto_pulang',
        'idjadwal_masuk',
        'akun_idakun',
        'unit_idunit',
        'created_at',
        'updated_at',
        'jarak',
        'status_kehadiran'
    ];

    public function getAll()
    {
        return $this->select('presensi.*, 
                          jadwal_masuk.nama_jadwal, 
                          akun.NAMA_AKUN, 
                          akun.ID_UNIT, 
                          unit.NAMA_UNIT,
                          unit.LATITUDE, 
                          unit.LONGTITUDE')
            ->join('jadwal_masuk', 'jadwal_masuk.idjadwal_masuk = presensi.idjadwal_masuk', 'left')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->findAll();
    }



    public function getPresensiHariIni($akunId, $tanggalHariIni)
    {
        return $this->select('presensi.*, 
                          jadwal_masuk.nama_jadwal, 
                          akun.NAMA_AKUN, 
                          akun.ID_UNIT, 
                          unit.NAMA_UNIT,
                          unit.LATITUDE, 
                          unit.LONGTITUDE')
            ->join('jadwal_masuk', 'jadwal_masuk.idjadwal_masuk = presensi.idjadwal_masuk', 'left')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('presensi.akun_idakun', $akunId)
            ->where('DATE(presensi.waktu_masuk)', $tanggalHariIni)
            ->findAll();
    }



    public function filterexport($tanggalAwal, $tanggalAkhir)
    {
        $tanggalAkhir .= ' 23:59:59';

        return $this->select('presensi.*, 
                              jadwal_masuk.nama_jadwal, 
                              akun.NAMA_AKUN, 
                              akun.ID_UNIT, 
                              unit.NAMA_UNIT,
                              unit.LATITUDE, 
                              unit.LONGTITUDE')
            ->join('jadwal_masuk', 'jadwal_masuk.idjadwal_masuk = presensi.idjadwal_masuk', 'left')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('presensi.created_at >=', $tanggalAwal)
            ->where('presensi.created_at <=', $tanggalAkhir)
            ->findAll();
    }




    public function getById($id)
    {
        return $this->where(['idpresensi' => $id])->first();
    }

    public function getByIdAkun($id)
    {
        return $this->select('presensi.*, 
                              jadwal_masuk.nama_jadwal, 
                              akun.NAMA_AKUN, 
                              akun.ID_UNIT, 
                              unit.NAMA_UNIT,
                              unit.LATITUDE, 
                              unit.LONGTITUDE')
            ->join('jadwal_masuk', 'jadwal_masuk.idjadwal_masuk = presensi.idjadwal_masuk', 'left')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('presensi.akun_idakun', $id)
            ->findAll();
    }



    public function insertPresensi($data)
    {
        return $this->insert($data);
    }

    public function getByAkun($akun_id)
    {
        return $this->where(['akun_idakun' => $akun_id])->findAll();
    }

    public function getUnconfirmed()
    {
        return $this->where(['status_absensi' => 0])->findAll();
    }

    public function getConfirmed()
    {
        return $this->where(['status_absensi' => 1])->findAll();
    }
}
