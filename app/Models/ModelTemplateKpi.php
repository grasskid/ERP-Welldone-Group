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
        'updated_on'
    ];

    public function getByJabatanAndNama($jabatan_id, $template_kpi)
{
    return $this->where('jabatan_idjabatan', $jabatan_id)
                ->where('template_kpi', $template_kpi)
                ->first();
}

    public function getTemplateKPI()
    {
        return $this->findAll();
    }
}