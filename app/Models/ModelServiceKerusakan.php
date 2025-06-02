<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelServiceKerusakan extends Model
{
    protected $table = 'service_kerusakan';
    protected $primaryKey = 'idservice_kerusakan';
    protected $returnType = 'object';
    protected $allowedFields = ['idservice_kerusakan', 'fungsi_idfungsi', 'keterangan', 'created_at', 'service_idservice'];

    public function getSerModelServiceKerusakan()
    {
        return $this->findAll();
    }

    public function getSerModelServiceKerusakanByServiceId($serviceId)
    {
        return $this->where('service_idservice', $serviceId)->findAll();
    }


    public function insert_SerModelServiceKerusakan($data)
    {
        return $this->insert($data);
    }
}
