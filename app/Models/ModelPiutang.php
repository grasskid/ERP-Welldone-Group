<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPiutang extends Model
{
    protected $table = 'piutang';
    protected $primaryKey = 'idpiutang';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idpiutang',
        'kode_piutang',
        'tanggal',
        'jumlah_hutang',
        'sisa_hutang',
        'status',
        'pegawai_idpegawai',
        'jatuh_tempo',
        'kirim_bank',
        'kirim_tunai',
        'input_by',
        'unit_idunit',
    ];


    public function getAgingPiutang()
    {
        $builder = $this->db->table($this->table);
        $builder->select("
        piutang.idpiutang,
        piutang.kode_piutang,
        piutang.tanggal,
        piutang.jatuh_tempo,
        piutang.jumlah_hutang,
        piutang.sisa_hutang,
        DATEDIFF(CURDATE(), piutang.jatuh_tempo) AS umur_hari,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) <= 30 THEN piutang.sisa_hutang ELSE 0 END AS `0_30_hari`,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) BETWEEN 31 AND 60 THEN piutang.sisa_hutang ELSE 0 END AS `31_60_hari`,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) BETWEEN 61 AND 90 THEN piutang.sisa_hutang ELSE 0 END AS `61_90_hari`,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) > 90 THEN piutang.sisa_hutang ELSE 0 END AS `lebih_90_hari`,
        akun_pegawai.NAMA_AKUN AS nama_pegawai,
        akun_input.NAMA_AKUN AS nama_input,
        unit.NAMA_UNIT AS nama_unit
    ");

        $builder->join('akun akun_pegawai', 'akun_pegawai.ID_AKUN = piutang.pegawai_idpegawai', 'left');
        $builder->join('akun akun_input', 'akun_input.ID_AKUN = piutang.input_by', 'left');
        $builder->join('unit', 'unit.idunit = piutang.unit_idunit', 'left');

        $builder->where('piutang.status', 0);
        $builder->orderBy('piutang.jatuh_tempo', 'ASC');

        return $builder->get()->getResult();
    }


    public function getAgingPiutangFiltered($tanggalAwal = null, $tanggalAkhir = null, $namaUnit = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select("
        piutang.idpiutang,
        piutang.kode_piutang,
        piutang.tanggal,
        piutang.jatuh_tempo,
        piutang.jumlah_hutang,
        piutang.sisa_hutang,
        DATEDIFF(CURDATE(), piutang.jatuh_tempo) AS umur_hari,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) <= 30 THEN piutang.sisa_hutang ELSE 0 END AS `0_30_hari`,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) BETWEEN 31 AND 60 THEN piutang.sisa_hutang ELSE 0 END AS `31_60_hari`,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) BETWEEN 61 AND 90 THEN piutang.sisa_hutang ELSE 0 END AS `61_90_hari`,
        CASE WHEN DATEDIFF(CURDATE(), piutang.jatuh_tempo) > 90 THEN piutang.sisa_hutang ELSE 0 END AS `lebih_90_hari`,
        akun_pegawai.NAMA_AKUN AS nama_pegawai,
        akun_input.NAMA_AKUN AS nama_input,
        unit.NAMA_UNIT AS nama_unit
    ");

        $builder->join('akun akun_pegawai', 'akun_pegawai.ID_AKUN = piutang.pegawai_idpegawai', 'left');
        $builder->join('akun akun_input', 'akun_input.ID_AKUN = piutang.input_by', 'left');
        $builder->join('unit', 'unit.idunit = piutang.unit_idunit', 'left');


        $builder->where('piutang.status', 0);


        if (!empty($tanggalAwal)) {
            $builder->where('piutang.tanggal >=', $tanggalAwal);
        }
        if (!empty($tanggalAkhir)) {
            $builder->where('piutang.tanggal <=', $tanggalAkhir);
        }


        if (!empty($namaUnit)) {
            $builder->where('unit.NAMA_UNIT', $namaUnit);
        }

        $builder->orderBy('piutang.jatuh_tempo', 'ASC');

        return $builder->get()->getResult();
    }



    public function getPiutang()
    {
        return $this->findAll();
    }


    public function getPiutangStatus0()
    {
        return $this->select('
            piutang.*,
            unit.NAMA_UNIT,
            akun_input.NAMA_AKUN as input_by_nama,
            akun_pegawai.NAMA_AKUN as pegawai_nama
        ')
            ->join('unit', 'unit.idunit = piutang.unit_idunit', 'left')
            ->join('akun as akun_input', 'akun_input.ID_AKUN = piutang.input_by', 'left')
            ->join('akun as akun_pegawai', 'akun_pegawai.ID_AKUN = piutang.pegawai_idpegawai', 'left')
            ->where('piutang.status', 0)
            ->findAll();
    }


    public function getPiutangStatus0Filtered($tanggalAwal = null, $tanggalAkhir = null, $idUnit = null)
    {
        $builder = $this->select('
            piutang.*,
            unit.NAMA_UNIT,
            akun_input.NAMA_AKUN as input_by_nama,
            akun_pegawai.NAMA_AKUN as pegawai_nama
        ')
            ->join('unit', 'unit.idunit = piutang.unit_idunit', 'left')
            ->join('akun as akun_input', 'akun_input.ID_AKUN = piutang.input_by', 'left')
            ->join('akun as akun_pegawai', 'akun_pegawai.ID_AKUN = piutang.pegawai_idpegawai', 'left')
            ->where('piutang.status', 0);

        // Jika tanggal awal dan akhir diisi, terapkan filter tanggal
        if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
            $builder->where('piutang.tanggal >=', $tanggalAwal)
                ->where('piutang.tanggal <=', $tanggalAkhir);
        }

        // Jika ID unit diisi, terapkan filter ID unit
        if (!empty($idUnit)) {
            $builder->where('piutang.unit_idunit', $idUnit);
        }

        return $builder->findAll();
    }


    public function insert_Piutang($data)
    {
        return $this->insert($data);
    }


    public function getById($idpiutang)
    {
        return $this->where(['idpiutang' => $idpiutang])->first();
    }

    public function getBelumLunas()
    {
        return $this->where(['status' => 0])->findAll();
    }
}
