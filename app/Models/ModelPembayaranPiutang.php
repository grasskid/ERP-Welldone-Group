<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembayaranPiutang extends Model
{
    protected $table = 'pembayaran_piutang';
    protected $primaryKey = 'idpembayaran_piutang';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idpembayaran_piutang',
        'idpiutang',
        'jumlah_bayar',
        'sisa_hutang',
        'bayar_tunai',
        'bank_idbank',
        'bayar_bank',
        'input_by',
    ];


    public function getPembayaran()
    {
        return $this->select('pembayaran_piutang.*, 
                              piutang.tanggal, piutang.jatuh_tempo, 
                              piutang.unit_idunit, piutang.pegawai_idpegawai,
                              piutang.kode_piutang,
                              unit.NAMA_UNIT,
                              akun1.NAMA_AKUN as nama_pegawai,
                              akun2.NAMA_AKUN as nama_input')
            ->join('piutang', 'piutang.idpiutang = pembayaran_piutang.idpiutang', 'left')
            ->join('unit', 'unit.idunit = piutang.unit_idunit', 'left')
            ->join('akun as akun1', 'akun1.ID_AKUN = piutang.pegawai_idpegawai', 'left')
            ->join('akun as akun2', 'akun2.ID_AKUN = pembayaran_piutang.input_by', 'left')
            ->findAll();
    }






    public function getPembayaranFiltered($tanggal_awal = null, $tanggal_akhir = null, $id_unit = null)
    {
        $builder = $this->select('pembayaran_piutang.*, 
                                piutang.tanggal, piutang.jatuh_tempo, 
                                piutang.unit_idunit, piutang.pegawai_idpegawai,
                                piutang.kode_piutang,
                                unit.NAMA_UNIT,
                                akun1.NAMA_AKUN as nama_pegawai,
                                akun2.NAMA_AKUN as nama_input')
            ->join('piutang', 'piutang.idpiutang = pembayaran_piutang.idpiutang', 'left')
            ->join('unit', 'unit.idunit = piutang.unit_idunit', 'left')
            ->join('akun as akun1', 'akun1.ID_AKUN = piutang.pegawai_idpegawai', 'left')
            ->join('akun as akun2', 'akun2.ID_AKUN = pembayaran_piutang.input_by', 'left');

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $builder->where('piutang.tanggal >=', $tanggal_awal)
                ->where('piutang.tanggal <=', $tanggal_akhir);
        }

        if (!empty($id_unit)) {
            $builder->where('piutang.unit_idunit', $id_unit);
        }

        return $builder->findAll();
    }


    public function insert_Pembayaran($data)
    {
        return $this->insert($data);
    }


    public function getById($idpembayaran_piutang)
    {
        return $this->where(['idpembayaran_piutang' => $idpembayaran_piutang])->first();
    }


    public function getByPiutang($idpiutang)
    {
        return $this->where(['idpiutang' => $idpiutang])->findAll();
    }
}
