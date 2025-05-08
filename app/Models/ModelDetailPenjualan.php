<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'iddetail_penjualan';
    protected $returnType = 'object';
    protected $allowedFields = [
        'iddetail_penjualan',
        'jumlah',
        'barang_idbarang',
        'harga_penjualan',
        'sub_total',
        'penjualan_idpenjualan',
        'hpp_penjualan',
        'satuan_jual',
        'diskon_penjualan'
    ];

    public function getDetail()
    {
        return $this->findAll();
    }

    public function insert_detail($data)
    {
        return $this->insert($data);
    }

    public function getById($id)
    {
        return $this->where(['iddetail_penjualan' => $id])->first();
    }

    public function getDetailPenjualan()
    {
        return $this->db->table('detail_penjualan')
            ->select('
                detail_penjualan.*,
                penjualan.kode_invoice,
                penjualan.tanggal,
                barang.nama_barang
            ')
            ->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan')
            ->join('barang', 'barang.idbarang = detail_penjualan.barang_idbarang')
            ->orderBy('penjualan.tanggal', 'DESC')
            ->get()
            ->getResult();
    }
}
