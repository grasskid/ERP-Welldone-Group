<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'ID_AKUN';
    protected $returnType = 'object';
    protected $allowedFields = ['ID_AKUN', 'ID,UNIT', 'ID_PANGKAT', 'ID_JABATAN', 'ID_GEDUNG', 'NOID', 'KTP', 'EMAIL', 'PASSWORD', 'ROLES', 'IS_DOKTER', 'NAMA_AKUN', 'ALAMAT', 'JENIS_KELAMIN', 'TELEPON', 'HP', 'AGAMA', 'STATUS_PEGAWAI'];

    function get_allakun()
    {
        $db = db_connect()->table($this->table);
        $db->join('pangkat', 'pangkat.ID_PANGKAT=akun.ID_PANGKAT');
        $db->join('gedung', 'gedung.ID_GEDUNG=akun.ID_GEDUNG');
        $db->join('jabatan', 'jabatan.ID_JABATAN=akun.ID_JABATAN');
        if (session()->get('ID_GEDUNG') != 0) {
            $db->where('akun.ID_GEDUNG', session()->get('ID_GEDUNG'));
        }
        $db->orderBy('akun.ID_GEDUNG', 'ASC');
        return $db->get();
    }

    public function getAkunPegawai()
    {
        return $this->select('akun.*, jabatan.NAMA_JABATAN, unit.NAMA_UNIT')
            ->join('jabatan', 'jabatan.ID_JABATAN = akun.ID_JABATAN', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('akun.STATUS_PEGAWAI', 1)
            ->findAll();
    }



    public function getAkunFrontliner($id_jabatan = 37)
    {
        return $this->where('ID_JABATAN', $id_jabatan)->findAll();
    }


    public function cekUsername($username)
    {
        $db = db_connect()->table($this->table)
            ->where("NOID", $username)
            ->orWhere("KTP", $username)
            ->orWhere("EMAIL", $username);
        return $db->get();
    }

    public function get_unit($id)
    {
        $db = db_connect()->table("unit")->where("idunit", $id);
        return $db->get()->getRowArray();
    }

    public function getJabatan()
    {
        $db = db_connect()->table("jabatan");
        return $db->get()->getResultObject();
    }

    public function get_nama_jabatan($id)
    {
        $db = db_connect()->table("jabatan")->where("ID_JABATAN", $id);
        return $db->get()->getRowArray();
    }

    public function insert_akun($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function getById($id)
    {
        return $this->where(['ID_AKUN' => $id])->first();
    }

    function getRolesAktif()
    {
        return $this->db->table('menu')
            // ->where(array("url !=" => null))
            ->get()->getResultObject();
    }

    function getRolesJabatan($roles)
    {
        return $this->db->table('menu')->whereIn('idmenu', $roles)->get()->getResultObject();
    }

    function getAkun($idunit = null)
    {
        $query = $this->db->table('akun');
        if ($idunit !== null && $idunit !== '') {
            $query->where(array("ID_UNIT" => $idunit));
        }
        $query->where(array("STATUS_PEGAWAI" => 1));
        $query->join('unit', 'unit.idunit=akun.ID_UNIT');
        $query->join('jabatan', 'jabatan.ID_JABATAN=akun.ID_JABATAN');
        return $query->get()->getResultObject();
    }

    function updatePass($id, $data)
    {
        return $this->db->table($this->table)->where('NOID', $id)->update($data);
    }


    public function getdataakun()
    {
        return $this->findAll();
    }
}
