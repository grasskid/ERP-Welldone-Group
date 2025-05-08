<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailPembelian extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'iddetail_pembelian';
    protected $returnType = 'object';
    protected $allowedFields = [
        'iddetail_pembelian',
        'no_batch',
        'tanggal',
        'jumlah',
        'hrg_beli',
        'diskon',
        'ppn',
        'hitung_hpp',
        'total_harga',
        'satuan_beli',
        'barang_idbarang',
        'pembelian_idpembelian'
    ];

    public function getDetail()
    {
        return $this->findAll();
    }

    // public function getDetailByTanggal($tanggal_awal = null, $tanggal_akhir = null)
    // {
    //     $builder = $this->db->table($this->table);

    //     $builder->select('detail_pembelian.*, barang.nama_barang');

    //     $builder->join('barang', 'barang.idbarang = detail_pembelian.barang_idbarang');

    //     if ($tanggal_awal && $tanggal_akhir) {

    //         $builder->where('detail_pembelian.tanggal >=', $tanggal_awal);
    //         $builder->where('detail_pembelian.tanggal <=', $tanggal_akhir);
    //     }


    //     $builder->orderBy('detail_pembelian.tanggal', 'DESC');
    //     return $builder->get()->getResult();
    // }

    // public function getDetailAll()
    // {
    //     $builder = $this->db->table($this->table);

    //     $builder->select('detail_pembelian.*, barang.nama_barang');
    //     $builder->join('barang', 'barang.idbarang = detail_pembelian.barang_idbarang');

    //     $builder->orderBy('detail_pembelian.tanggal', 'DESC');

    //     return $builder->get()->getResult();
    // }

    public function getDetailAll()
    {
        return $this->db->table('detail_pembelian')
            ->select('
                detail_pembelian.*,
                detail_pembelian.tanggal,
                barang.nama_barang
            ')
            ->join('pembelian', 'pembelian.idpembelian = detail_pembelian.pembelian_idpembelian')
            ->join('barang', 'barang.idbarang = detail_pembelian.barang_idbarang')
            ->orderBy('detail_pembelian.tanggal', 'DESC')
            ->get()
            ->getResult();
    }

    public function insert_detail($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this->where(['iddetail_pembelian' => $id])->first();
    }
}