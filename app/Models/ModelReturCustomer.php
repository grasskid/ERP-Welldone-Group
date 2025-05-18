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
        'unit_idunit',
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
            barang.nama_barang,
            unit.NAMA_UNIT')
            ->join('detail_penjualan', 'detail_penjualan.iddetail_penjualan = retur_pelanggan.detail_penjualan_iddetail_penjualan')
            ->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan')
            ->join('barang', 'barang.idbarang = detail_penjualan.barang_idbarang')->join('unit', 'unit.idunit = retur_pelanggan.unit_idunit')
            ->get()
            ->getResult();
    }

    public function exportfilter($tanggalAwal = null, $tanggalAkhir = null, $namaUnit = null)
    {
        $builder = $this->db->table('retur_pelanggan')
            ->select('
                retur_pelanggan.*,
                detail_penjualan.*,
                barang.nama_barang,
                unit.NAMA_UNIT')
            ->join('detail_penjualan', 'detail_penjualan.iddetail_penjualan = retur_pelanggan.detail_penjualan_iddetail_penjualan')
            ->join('penjualan', 'penjualan.idpenjualan = detail_penjualan.penjualan_idpenjualan')
            ->join('barang', 'barang.idbarang = detail_penjualan.barang_idbarang')
            ->join('unit', 'unit.idunit = retur_pelanggan.unit_idunit');


        if (!empty($tanggalAwal)) {
            $builder->where('retur_pelanggan.tanggal >=', $tanggalAwal);
        }


        if (!empty($tanggalAkhir)) {

            $tanggalAkhir .= ' 23:59:59';
            $builder->where('retur_pelanggan.tanggal <=', $tanggalAkhir);
        }


        if (!empty($namaUnit)) {
            $builder->like('unit.NAMA_UNIT', $namaUnit);
        }

        return $builder->get()->getResult();
    }
}
