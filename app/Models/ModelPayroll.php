<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPayroll extends Model
{
    protected $table = 'jenis_payroll';
    protected $primaryKey = 'idjenis_payroll';
    protected $returnType = 'object';
    protected $allowedFields = ['idjenis_payroll', 'nama_payroll', 'status_payroll', 'keterangan'];

    public function getPayroll()
    {
        return $this->findAll();
    }

    public function insert_Payroll($data)
    {
        return $this->insert($data);
    }

    public function getById($idjenis_payroll)
    {
        return $this->where(['idjenis_payroll' => $idjenis_payroll])->first();
    }

}