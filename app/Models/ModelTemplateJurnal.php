<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTemplateJurnal extends Model
{
    protected $table = 'template_jurnal';
    protected $primaryKey = 'idtemplate_jurnal';
    protected $returnType = 'object';
    protected $allowedFields = ['idtemplate_jurnal', 'kode_template', 'no_akun', 'nama_akun', 'debet_kredit', 'array_value'];

    public function getTemplateJurnal()
    {
        return $this->like('kode_template', 'asset_penyusutan')
            ->findAll();
    }


    public function insertTemplateJurnal($data)
    {
        return $this->insert($data);
    }

    public function getById($idtemplate_jurnal)
    {
        return $this->where(['idtemplate_jurnal' => $idtemplate_jurnal])->first();
    }
}
