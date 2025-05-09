<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelReturCustomer extends Model
{
    protected $table = 'retur_pelanggan';
    protected $primaryKey = 'idretur_pelanggan';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idretur_pelanggan',
        'no_retur_pelanggan',
        'tanggal',
        'jumlah',
        'satuan',
        'barang_idbarang',
        'detail_penjualan_iddetail_penjualan',
        'input_by'
    ];

    public function getReturCustomer()
    {
        return $this->findAll();
    }

    public function insert_ReturCustomer($data)
    {
        return $this->insert($data);
    }

    public function getById($id)
    {
        return $this->where(['idretur_pelanggan' => $id])->first();
    }

    public function getReturPenjualan()
    {
        return $this->db->table('retur_pelanggan')
            ->select('
            retur_pelanggan.*,
            detail_penjualan.*,
            barang.nama_barang')
            ->join('detail_penjualan', 'detail_penjualan.iddetail_penjualan = retur_pelanggan.detail_penjualan_iddetail_penjualan')
            ->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan')
            ->join('barang', 'barang.idbarang = detail_penjualan.barang_idbarang')
            ->get()
            ->getResult();
    }
}
