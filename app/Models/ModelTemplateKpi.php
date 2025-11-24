<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTemplateKpi extends Model
{
    protected $table            = 'template_kpi';
    protected $primaryKey       = 'idtemplate_kpi';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'template_kpi',
        'bobot',
        'target',
        'formula',
        'jabatan_idjabatan',
        'created_on',
        'updated_on',
        'status',
        'level',
    ];

    public function getByJabatan($jabatan_id)
    {
        return $this->where('jabatan_idjabatan', $jabatan_id)
                    ->where('level', 1)
                    ->findAll();
    }

    public function getByJabatanAndNama($jabatan_id, $template_kpi)
    {
        return $this->where('jabatan_idjabatan', $jabatan_id)
                    ->where('template_kpi', $template_kpi)
                    ->where('level', 1)
                    ->first();
    }

    public function getByJabatanLevel2($jabatan_id)
{
    return $this->where('jabatan_idjabatan', $jabatan_id)
                ->where('level', 2)
                ->findAll();
}

    public function getTemplateKPI()
    {
        return $this->where('level', 1)
                    ->findAll();
    }

    public function getTemplateGrading()
    {
        return $this->where('level', 2)
                    ->findAll();
    }

    public function getById($id)
    {
        return $this->where('idtemplate_kpi', $id)->first();
    }
}