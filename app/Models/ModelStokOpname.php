<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStokOpname extends Model
{
    protected $table = 'stok_opname';
    protected $primaryKey = 'idstok_opname';
    protected $returnType = 'object';
    protected $allowedFields = ['idstok_opname', 'tanggal', 'hpp', 'jumlah_real', 'jumlah_komp', 'jumlah_selisih', 'satuan_terkecil', 'barang_idbarang', 'unit_idunit'];

    public function getStokOpname()
    {
        return $this->findAll();
    }

    public function getByIdBarang($id)
    {
        return $this->where(['barang_idbarang' => $id])->first();
    }


    public function insert_StokOpnameFix($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this->where(['idstok_opname' => $id])->first();
    }

    public function getStokOpnameAll()
    {
        return $this->select('
            stok_opname.*, 
            barang.kode_barang, 
            barang.nama_barang, 
            barang.jenis_hp,  
            barang.warna, 
            unit.NAMA_UNIT
        ')
            ->join('barang', 'barang.idbarang = stok_opname.barang_idbarang')
            ->join('unit', 'unit.idunit = stok_opname.unit_idunit')
            ->orderBy('stok_opname.tanggal', 'DESC')
            ->findAll();
    }


    public function exportfilter($tanggalAwal = null, $tanggalAkhir = null, $namaUnit = null)
    {
        $builder = $this->select('
            stok_opname.*, 
            barang.kode_barang, 
            barang.nama_barang, 
            barang.jenis_hp,  
            barang.warna, 
            unit.NAMA_UNIT
        ')
            ->join('barang', 'barang.idbarang = stok_opname.barang_idbarang')
            ->join('unit', 'unit.idunit = stok_opname.unit_idunit');


        if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {

            $tanggalAkhir .= ' 23:59:59';
            $builder->where('stok_opname.tanggal >=', $tanggalAwal)
                ->where('stok_opname.tanggal <=', $tanggalAkhir);
        }

        if (!empty($namaUnit)) {
            $builder->where('unit.NAMA_UNIT', $namaUnit);
        }

        return $builder->orderBy('stok_opname.tanggal', 'DESC')->findAll();
    }
}
