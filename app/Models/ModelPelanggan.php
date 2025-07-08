<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $returnType = 'object';
    protected $allowedFields = ['id_pelanggan', 'nik', 'nama', 'alamat', 'kategori', 'no_hp', 'deleted', 'create_on'];

    public function getPelanggan()
    {
        return $this->where('deleted', '0')->findAll();
    }

    public function insert_Pelanggan($data)
    {
        return $this->insert($data);
    }

    public function getById($id_pelanggan)
    {
        return $this->where(['id_pelanggan' => $id_pelanggan])->first();
    }

    public function getByNomor($nomor)
    {
        return $this->where(['no_hp' => $nomor])->first();
    }

    public function getPelangganWithService($per_bulan = false)
{
    if ($per_bulan) {
        return $this->select("DATE_FORMAT(pelanggan.create_on, '%Y-%m') AS bulan, COUNT(DISTINCT pelanggan.id_pelanggan) AS total")
            ->join('service', 'service.pelanggan_id_pelanggan = pelanggan.id_pelanggan')
            ->where('pelanggan.deleted', '0')
            ->where('service.status_service', 4)
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
    }

    return $this->select('pelanggan.*, service.no_service')
        ->join('service', 'service.pelanggan_id_pelanggan = pelanggan.id_pelanggan')
        ->where('pelanggan.deleted', '0')
        ->where('service.status_service', 4)
        ->findAll();
}

public function getPelangganBaruBulanIni($per_bulan = false)
{
    if ($per_bulan) {
        return $this->select("DATE_FORMAT(create_on, '%Y-%m') AS bulan, COUNT(*) AS total")
            ->where('create_on >=', date('Y-m-d', strtotime('-12 months')))
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
    }

    $oneMonthAgo = date('Y-m-d', strtotime('-1 month'));
    return $this->where('create_on >=', $oneMonthAgo)->findAll();
}

}