<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTemplatePenilaian extends Model
{
    protected $table            = 'template_penilaian';
    protected $primaryKey       = 'idtemplate_penilaian';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'aspek_penilaian',
        'keterangan_penilaian',
        'jabatan_idjabatan',
        'idtemplate_kpi'
    ];

    public function getTemplatePenilaian()
    {
        return $this->select('template_penilaian.*, 
                              jabatan.NAMA_JABATAN as jabatan, 
                              template_kpi.template_kpi as aspek_kpi')
            ->join('jabatan', 'jabatan.ID_JABATAN = template_penilaian.jabatan_idjabatan', 'left')
            ->join('template_kpi', 'template_kpi.idtemplate_kpi = template_penilaian.idtemplate_kpi', 'left')
            ->findAll();
    }

    public function insertTemplatePenilaian($data)
    {
        return $this->insert($data);
    }
}
