<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelServiceSparepart extends Model
{
    protected $table = 'service_sparepart';
    protected $primaryKey = 'idservice_sparepart';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idservice_sparepart',
        'jumlah',
        'harga_penjualan',
        'sub_total',
        'hpp_penjualan',
        'satuan_jual',
        'diskon_penjualan',
        'service_idservice',
        'barang_idbarang',
        'unit_idunit'
    ];

    public function getSerModelServiceSparepart()
    {
        return $this->findAll();
    }

    public function getSerModelServiceSparepartByServiceId($idservice)
    {
        return $this->db->table('service_sparepart')
            ->select('service_sparepart.*, barang.nama_barang, service.garansi_hari')
            ->join('barang', 'barang.idbarang = service_sparepart.barang_idbarang')
            ->join('service', 'service.idservice = service_sparepart.service_idservice')
            ->where('service_sparepart.service_idservice', $idservice)
            ->get()->getResult();
    }

    public function getGaransiHariByServiceId($idservice)
    {
        return $this->db->table('service')
            ->select('garansi_hari')
            ->where('idservice', $idservice)
            ->get()
            ->getRow();
    }







    public function insert_SerModelServiceSparepart($data)
    {
        return $this->insert($data);
    }
}
