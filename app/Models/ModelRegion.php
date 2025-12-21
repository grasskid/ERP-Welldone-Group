<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRegion extends Model
{
    protected $table = 'districts';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'regency_id', 'name'];

    public function getRegion()
    {
        return $this->db->table('districts d')
            ->select('
                d.id   AS district_id,
                d.name AS district_name,
                r.id   AS regency_id,
                r.name AS regency_name,
                p.id   AS province_id,
                p.name AS province_name
            ')
            ->join('regencie r', 'r.id = d.regency_id')
            ->join('provinces p', 'p.id = r.province_id')
            ->orderBy('p.name', 'ASC')
            ->orderBy('r.name', 'ASC')
            ->orderBy('d.name', 'ASC')
            ->get()
            ->getResult();
    }

    public function getProvinces()
    {
        return $this->db->table('provinces')
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();
    }

    public function getRegenciesByProvinceName($provinceName)
    {
        return $this->db->table('regencie r')
            ->join('provinces p', 'p.id = r.province_id')
            ->where('p.name', $provinceName)
            ->select('r.name')
            ->orderBy('r.name', 'ASC')
            ->get()
            ->getResult();
    }

    public function getDistrictsByRegencyName($regencyName)
    {
        return $this->db->table('districts d')
            ->join('regencie r', 'r.id = d.regency_id')
            ->where('r.name', $regencyName)
            ->select('d.name')
            ->orderBy('d.name', 'ASC')
            ->get()
            ->getResult();
    }
}