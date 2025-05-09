<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'idpembelian';
    protected $returnType = 'object';
    protected $allowedFields = ['idpembelian', 'no_nota_supplier', 'foto_nota', 'tanggal_masuk', 'sisa', 'status', 'total_transaksi', 'total_diskon', 'total_ppn', 'total_bayar', 'bayar', 'unit_idunit', 'suplier_id_suplier', 'pelanggan_id_pelanggan', 'input_by'];


    public function getPembelian()
    {
        return $this->findAll();
    }

    public function insert_Pembelian($data)
    {
        $this->insert($data);
        return $this->insertID();
    }



    public function getById($id_pelanggan)
    {
        return $this->where(['id_pelanggan' => $id_pelanggan])->first();
    }
}
