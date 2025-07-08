<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelProsesService extends Model
{
    protected $table = 'proses_service';
    protected $primaryKey = 'idproses_service';
    protected $returnType = 'object';
    protected $allowedFields = ['idproses_service', 'service_idservice', 'status_statusproses', 'updated_at'];


    public function getProses()
    {
        return $this->findAll();
    }

    public function insertProses($data)
    {
        return $this->insert($data);
    }


    public function getProsesByServiceID($serviceID)
    {

        $data = $this->where('service_idservice', $serviceID)
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        if (empty($data)) {
            return null;
        }

        // Alias: proses_terkini
        $proses_terkini = $data[0]->status_statusproses;

        // Alias: tanggal_mulai_proses (updated_at paling awal saat status_statusproses == 3)
        $tanggal_mulai_proses = null;
        foreach (array_reverse($data) as $item) {
            if ($item->status_statusproses == 3) {
                $tanggal_mulai_proses = $item->updated_at;
                break;
            }
        }

        return (object)[
            'data_proses' => $data,
            'proses_terkini' => $proses_terkini,
            'tanggal_mulai_proses' => $tanggal_mulai_proses
        ];
    }

    public function deleteByServiceId($idservice)
    {
        return $this->where('service_idservice', $idservice)->delete();
    }
}
