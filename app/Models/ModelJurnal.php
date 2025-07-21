<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJurnal extends Model
{
    protected $table = 'jurnal';
    protected $primaryKey = 'idjurnal';
    protected $returnType = 'object';
    protected $allowedFields = ['idjurnal', 'tanggal', 'no_akun', 'nama_akun', 'debet', 'kredit', 'keterangan', 'id_referensi', 'tabel_referensi', 'id_unit', 'id_akun'];

    public function insertJurnal($tanggal, $kode_template, $ar_value, $keterangan, $id_referensi, $tabel_referensi, $id_unit = null)
    {
        $id_akun = session('ID_AKUN');
        if ($id_unit == null) {
            $id_unit = session('ID_UNIT');
        }
        $template = db_connect()->table('template_jurnal')->where('kode_template', $kode_template)->get()->getResult();
        $ar_insert = array();
        foreach ($template as $value) {
            $data = array(
                'tanggal'           => date('Y-m-d', strtotime($tanggal)),
                'no_akun'           => $value->no_akun,
                'nama_akun'         => $value->nama_akun,
                'keterangan'        => $keterangan,
                'id_referensi'      => $id_referensi,
                'tabel_referensi'   => $tabel_referensi,
                'id_unit'           => $id_unit,
                'id_akun'           => $id_akun
            );
            if ($value->debet_kredit == 'debet') {
                $data['debet'] = $ar_value[$value->array_value];
                $data['kredit'] = 0;
            } else {
                $data['kredit'] = $ar_value[$value->array_value];
                $data['debet'] = 0;
            }
            $this->insert($data);
        }
        return true;
    }


    public function getJurnalWithUnit()
    {
        return $this->select('jurnal.*, unit.NAMA_UNIT')
            ->join('unit', 'unit.idunit = jurnal.id_unit', 'left')
            ->orderBy('jurnal.tanggal', 'DESC')
            ->findAll();
    }



    public function filterexport($tanggal_awal = null, $tanggal_akhir = null, $nama_unit = null)
    {
        $builder = $this->select('jurnal.*, unit.NAMA_UNIT')
            ->join('unit', 'unit.idunit = jurnal.id_unit', 'left');

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $builder->where('tanggal >=', $tanggal_awal)
                ->where('tanggal <=', $tanggal_akhir);
        }

        if (!empty($nama_unit)) {
            $builder->where('unit.NAMA_UNIT', $nama_unit);
        } else {

            $builder->where('unit.NAMA_UNIT IS NOT NULL');
        }

        return $builder->findAll();
    }


    public function insertJurnalfleksibel($tanggal, $kode_template, $ar_value, $keterangan, $id_referensi, $tabel_referensi, $id_unit = null)
    {
        $id_akun = session('ID_AKUN');
        if ($id_unit == null) {
            $id_unit = session('ID_UNIT');
        }

        $template = db_connect()->table('template_jurnal')
            ->where('kode_template', $kode_template)
            ->orderBy('idtemplate_jurnal', 'asc') // urutkan jika perlu
            ->get()->getResult();

        foreach ($template as $value) {
            $index = $value->array_value;

            // Validasi nilai, gunakan 0 jika offset tidak ditemukan
            $nilai = isset($ar_value[$index]) ? $ar_value[$index] : 0;

            $data = [
                'tanggal'         => date('Y-m-d', strtotime($tanggal)),
                'no_akun'         => $value->no_akun,
                'nama_akun'       => $value->nama_akun,
                'keterangan'      => $keterangan,
                'id_referensi'    => $id_referensi,
                'tabel_referensi' => $tabel_referensi,
                'id_unit'         => $id_unit,
                'id_akun'         => $id_akun,
                'debet'           => ($value->debet_kredit == 'debet') ? $nilai : 0,
                'kredit'          => ($value->debet_kredit == 'kredit') ? $nilai : 0,
            ];

            $this->insert($data);
        }

        return true;
    }


    public function getSummaryPerParent($tanggal_awal = null, $tanggal_akhir = null, $unit = null)
    {
        $db = \Config\Database::connect();

        // Ambil akun parent: prefix 3 digit + 7 nol
        $builderParent = $db->table('no_akun')
            ->select('no_akun, nama_akun')
            ->where('CHAR_LENGTH(no_akun)', 10)
            ->where('RIGHT(no_akun, 7)', '0000000'); // Ini parent yang valid

        $parents = $builderParent->get()->getResult();

        $result = [];

        foreach ($parents as $parent) {
            $parent_no = $parent->no_akun;

            $builder = $db->table('jurnal j');
            $builder->select("
            COALESCE(SUM(j.debet), 0) as total_debet,
            COALESCE(SUM(j.kredit), 0) as total_kredit
        ");
            $builder->like('j.no_akun', substr($parent_no, 0, 3), 'after'); // filter semua yang prefix sama

            // Tambah filter unit jika ada
            if ($unit !== null) {
                $builder->where('j.id_unit', $unit);
            }

            // Tambah filter tanggal jika ada
            if ($tanggal_awal !== null && $tanggal_akhir !== null) {
                $builder->where('j.tanggal >=', $tanggal_awal);
                $builder->where('j.tanggal <=', $tanggal_akhir);
            }

            $total = $builder->get()->getRow();

            $result[] = [
                'parent_no_akun' => $parent_no,
                'parent_nama_akun' => $parent->nama_akun,
                'total_debet' => $total->total_debet ?? 0,
                'total_kredit' => $total->total_kredit ?? 0,
            ];
        }

        return $result;
    }







    public function getTotalGrandparent($tanggal_awal = null, $tanggal_akhir = null, $unit = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('jurnal j');
        $builder->select("
        '1000000000' as no_akun,
        'ASET' as nama_akun,
        COALESCE(SUM(j.debet), 0) as total_debet,
        COALESCE(SUM(j.kredit), 0) as total_kredit
    ");
        $builder->like('j.no_akun', '10', 'after'); // prefix 10 = ASET

        if ($unit !== null) {
            $builder->where('j.id_unit', $unit);
        }

        if ($tanggal_awal !== null && $tanggal_akhir !== null) {
            $builder->where('j.tanggal >=', $tanggal_awal);
            $builder->where('j.tanggal <=', $tanggal_akhir);
        }

        return $builder->get()->getRow();
    }
}
