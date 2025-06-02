<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $returnType = 'object';
    protected $allowedFields = ['id_pelanggan', 'nik', 'nama', 'alamat', 'no_hp', 'deleted'];

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

    public function getPelangganWithService()
    {
        return $this->select('pelanggan.*, service.no_service')
            ->join('service', 'service.pelanggan_id_pelanggan = pelanggan.id_pelanggan')
            ->where('pelanggan.deleted', '0')
            ->where('service.status_service', 4)
            ->findAll();
    }
}
