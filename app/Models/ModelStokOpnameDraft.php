<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelStokOpnameDraft extends Model
{
    protected $table = 'stok_opname_draft';
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


    public function insert_StokOpnameDraft($data)
    {
        return $this->insert($data);
    }


    public function getById($id)
    {
        return $this->where(['idstok_opname' => $id])->first();
    }

    public function getStokOpnameDraft()
{
    return $this->select('
            stok_opname_draft.*, 
            barang.kode_barang, 
            barang.nama_barang, 
            barang.jenis_hp, 
            barang.warna, 
            unit.NAMA_UNIT
        ')
        ->join('barang', 'barang.idbarang = stok_opname_draft.barang_idbarang')
        ->join('unit', 'unit.idunit = stok_opname_draft.unit_idunit')
        ->orderBy('stok_opname_draft.tanggal', 'DESC')
        ->findAll();
}


}