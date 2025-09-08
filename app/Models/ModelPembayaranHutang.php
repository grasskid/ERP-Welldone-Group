<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembayaranHutang extends Model
{
    protected $table = 'pembayaran_hutang';
    protected $primaryKey = 'idpembayaran_hutang';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idpembayaran_hutang',
        'tanggal_bayar',
        'bayar',
        'bayar_tunai',
        'bayar_bank',
        'sisa_hutang',
        'pembelian_idpembelian',
        'bank_idbank',
        'input_by',
    ];

    public function getAll()
    {
        return $this->select('
                pembayaran_hutang.*,
                pembelian.jatuh_tempo,
                pembelian.no_nota_supplier,
                pembelian.unit_idunit,
                unit.NAMA_UNIT,
                akun.NAMA_AKUN as nama_input
            ')
            ->join('pembelian', 'pembelian.idpembelian = pembayaran_hutang.pembelian_idpembelian', 'left')
            ->join('unit', 'unit.idunit = pembelian.unit_idunit', 'left')
            ->join('akun', 'akun.ID_AKUN = pembayaran_hutang.input_by', 'left')
            ->findAll();
    }


    public function getFiltered($tanggalAwal = null, $tanggalAkhir = null, $namaUnit = null)
    {
        $builder = $this->select('
            pembayaran_hutang.*,
            pembelian.jatuh_tempo,
            pembelian.no_nota_supplier,
            pembelian.unit_idunit,
            unit.NAMA_UNIT,
            akun.NAMA_AKUN as nama_input
        ')
            ->join('pembelian', 'pembelian.idpembelian = pembayaran_hutang.pembelian_idpembelian', 'left')
            ->join('unit', 'unit.idunit = pembelian.unit_idunit', 'left')
            ->join('akun', 'akun.ID_AKUN = pembayaran_hutang.input_by', 'left');

        // Filter tanggal jika ada
        if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
            $builder->where('pembayaran_hutang.tanggal_bayar >=', $tanggalAwal)
                ->where('pembayaran_hutang.tanggal_bayar <=', $tanggalAkhir);
        } elseif (!empty($tanggalAwal)) {
            $builder->where('pembayaran_hutang.tanggal_bayar >=', $tanggalAwal);
        } elseif (!empty($tanggalAkhir)) {
            $builder->where('pembayaran_hutang.tanggal_bayar <=', $tanggalAkhir);
        }

        // Filter nama unit jika ada
        if (!empty($namaUnit)) {
            $builder->where('unit.NAMA_UNIT', $namaUnit);
        }

        return $builder->findAll();
    }


    public function getById($id)
    {
        return $this->select('
                pembayaran_hutang.*,
                pembelian.jatuh_tempo,
                pembelian.unit_idunit,
                unit.NAMA_UNIT
            ')
            ->join('pembelian', 'pembelian.idpembelian = pembayaran_hutang.pembelian_idpembelian', 'left')
            ->join('unit', 'unit.idunit = pembelian.unit_idunit', 'left')
            ->where('pembayaran_hutang.idpembayaran_hutang', $id)
            ->first();
    }

    public function insertPembayaran($data)
    {
        return $this->insert($data);
    }

    public function updatePembayaran($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deletePembayaran($id)
    {
        return $this->delete($id);
    }

    public function getChartHutang($unitId = null, $months = 6)
{
    $builder = $this->select("
            DATE_FORMAT(pembayaran_hutang.tanggal_bayar, '%Y-%m') as bulan,
            SUM(pembayaran_hutang.bayar) as total_bayar,
            SUM(pembayaran_hutang.sisa_hutang) as total_sisa
        ")
        ->join('pembelian', 'pembelian.idpembelian = pembayaran_hutang.pembelian_idpembelian', 'left')
        ->groupBy("DATE_FORMAT(pembayaran_hutang.tanggal_bayar, '%Y-%m')")
        ->orderBy("bulan", "ASC");

    if (!empty($unitId)) {
        $builder->where('pembelian.unit_idunit', $unitId);
    }

    $builder->where('pembayaran_hutang.tanggal_bayar >=', date('Y-m-01', strtotime("-{$months} months")));

    return $builder->findAll();
}

}