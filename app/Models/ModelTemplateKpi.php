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
        'formula',
        'jabatan_idjabatan',
        'created_on',
        'updated_on'
    ];

    public function getTemplateKPI()
    {
        return $this->findAll();
    }
}
