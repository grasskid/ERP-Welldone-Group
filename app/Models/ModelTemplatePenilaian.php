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
        'idtemplate_kpi',
        'target',
        'bobot'
    ];

    public function getTemplatePenilaian()
    {
        return $this->select('template_penilaian.*, 
          jabatan.NAMA_JABATAN as jabatan, 
          template_kpi.template_kpi as aspek_kpi,
          template_kpi.status as status')
            ->join('jabatan', 'jabatan.ID_JABATAN = template_penilaian.jabatan_idjabatan', 'left')
            ->join('template_kpi', 'template_kpi.idtemplate_kpi = template_penilaian.idtemplate_kpi', 'left')
            ->findAll();
    }

    public function insertTemplatePenilaian($data)
    {
        return $this->insert($data);
    }

    public function getById($id)
    {
        return $this->where('idtemplate_penilaian', $id)->first();
    }


    public function getTemplateByJabatan($idjabatan)
{
    return $this->select('
        template_penilaian.idtemplate_penilaian, 
        template_penilaian.aspek_penilaian, 
        template_penilaian.keterangan_penilaian, 
        template_penilaian.jabatan_idjabatan, 
        template_penilaian.idtemplate_kpi, 
        template_penilaian.target, 
        template_penilaian.bobot,
        template_kpi.status, 
        template_kpi.template_kpi AS aspek_kpi
    ')
    ->join('template_kpi', 'template_kpi.idtemplate_kpi = template_penilaian.idtemplate_kpi')
    ->where('template_penilaian.jabatan_idjabatan', $idjabatan)
    ->findAll();
}

}