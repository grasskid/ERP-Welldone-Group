<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelService extends Model
{
    protected $table = 'service';
    protected $primaryKey = 'idservice';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idservice',
        'no_service',
        'no_hp',
        'imei',
        'alamat',
        'keluhan',
        'keterangan',
        'passcode',
        'type_passcode',
        'email_icloud',
        'password_icloud',
        'status_service',
        'total_service',
        'total_diskon',
        'harus_dibayar',
        'garansi_hari',
        'pelanggan_id_pelanggan',
        'unit_idunit',
        'service_by',
        'input_by',
        'created_at',
        'updated_at'
    ];

    public function getAllService()
    {
        return $this->findAll();
    }

    public function getByIdWithPelanggan($id)
    {
        return $this->select('service.*, pelanggan.nama')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan')
            ->where('service.idservice', $id)
            ->first();
    }


    public function getRiwayatService()
    {
        return $this->select('service.*, pelanggan.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan')
            ->findAll();
    }


    public function insertService($data)
    {
        return $this->insert($data);
    }

    public function getServiceByStatus($status)
    {
        return $this->where('status_service', $status)->findAll();
    }

    public function updateService($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteService($id)
    {
        return $this->delete($id);
    }


    public function getServiceWithLaba()
    {
        return $this->select('
            service.*,
            SUM(service_sparepart.hpp_penjualan) AS total_hpp_penjualan,
            (service.harus_dibayar - SUM(service_sparepart.hpp_penjualan)) AS laba_service,
            akun.NAMA_AKUN AS nama_teknisi
        ')
            ->join('service_sparepart', 'service_sparepart.service_idservice = service.idservice', 'left')
            ->join('akun', 'akun.ID_AKUN = service.service_by', 'left')
            ->where('service.status_service', 4)
            ->groupBy('service.idservice')
            ->findAll();
    }
}
