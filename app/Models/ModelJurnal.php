<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJurnal extends Model
{
    protected $table = 'jurnal';
    protected $primaryKey = 'idjurnal';
    protected $returnType = 'object';
    protected $allowedFields = ['idjurnal', 'tanggal', 'no_akun', 'nama_akun', 'debet', 'kredit', 'keterangan', 'id_referensi','tabel_referensi', 'id_unit', 'id_akun'];

    public function insertJurnal($tanggal, $kode_template, $ar_value, $keterangan, $id_referensi, $tabel_referensi, $id_unit = null)
    {
        $id_akun = session('ID_AKUN');
        if ($id_unit == null) {
            $id_unit = session('ID_UNIT');
        }
        $template = $this->table('template_jurnal')->where('kode_template', $kode_template)->get()->getRow();
        $ar_insert = array();
        foreach ($template as $value) {
            $data = array(
                'tanggal' => $tanggal,
                'no_akun' => $value->no_akun,
                'nama_akun' => $value->nama_akun,
                'keterangan' => $keterangan,
                'id_referensi' => $id_referensi,
                'tabel_referensi' => $tabel_referensi,
                'id_unit' => $id_unit,
                'id_akun' => $id_akun
            );
            if ($value->debet_kredit == 'debet') {
                $data['debet'] = $ar_value[$value->array_value];
            } else {
                $data['kredit'] = $ar_value[$value->array_value];
            }
            $ar_insert[] = $data;
        }
        return $this->insertBatch($ar_insert);
    }
}
