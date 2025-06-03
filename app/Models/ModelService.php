<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelService extends Model
{
    protected $table = 'service';
    protected $primaryKey = 'idservice';
    protected $returnType = 'object';
    protected $allowedFields = [
        'idservice',
        'no_service',
        'no_hp',
        'imei',
        'alamat',
        'keluhan',
        'keterangan',
        'passcode',
        'type_passcode',
        'email_icloud',
        'password_icloud',
        'status_service',
        'total_service',
        'total_diskon',
        'harus_dibayar',
        'bayar',
        'garansi_hari',
        'pelanggan_id_pelanggan',
        'unit_idunit',
        'service_by',
        'input_by',
        'tanggal_selesai',
        'tanggal_proses',
        'created_at',
        'updated_at'
    ];

    public function getAllService()
    {
        return $this->findAll();
    }

    public function getByIdWithPelanggan($id)
    {
        return $this->select('service.*, pelanggan.nama')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan')
            ->where('service.idservice', $id)
            ->first();
    }


    public function getRiwayatService()
    {
        return $this->select('service.*, pelanggan.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan')
            ->findAll();
    }

    public function getExpiredService()
    {
        return $this->select('service.*, pelanggan.nama as nama_pelanggan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan')
            ->where('tanggal_selesai IS NOT NULL')
            ->findAll();
    }

    public function getExpiredServiceByRange($tanggal_awal, $tanggal_akhir)
    {

        $tanggal_awal .= ' 00:00:00';
        $tanggal_akhir .= ' 23:59:59';

        return $this->select('service.*, pelanggan.nama as nama_pelanggan, akun.NAMA_AKUN as nama_service_by')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan')
            ->join('akun', 'akun.ID_AKUN = service.service_by')
            ->where('tanggal_selesai IS NOT NULL')
            ->where('tanggal_selesai >=', $tanggal_awal)
            ->where('tanggal_selesai <=', $tanggal_akhir)
            ->findAll();
    }



    public function insertService($data)
    {
        return $this->insert($data);
    }

    public function getServiceByStatus($status)
    {
        return $this->where('status_service', $status)->findAll();
    }

    public function updateService($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteService($id)
    {
        return $this->delete($id);
    }


    public function getServiceWithLaba()
    {
        return $this->select('
            service.*,
            SUM(service_sparepart.hpp_penjualan) AS total_hpp_penjualan,
            (service.harus_dibayar - SUM(service_sparepart.hpp_penjualan) - service.total_diskon) AS laba_service,
            akun.NAMA_AKUN AS nama_teknisi
        ')
            ->join('service_sparepart', 'service_sparepart.service_idservice = service.idservice', 'left')
            ->join('akun', 'akun.ID_AKUN = service.service_by', 'left')
            ->where('service.status_service', 4)
            ->groupBy('service.idservice')
            ->findAll();
    }

    //kerusakan
    public function getKerusakanWithFungsi($idservice)
    {
        return $this->db->table('service_kerusakan')
            ->select('service_kerusakan.idservice_kerusakan, service_kerusakan.keterangan, fungsi.idfungsi, fungsi.nama_fungsi')
            ->join('fungsi', 'fungsi.idfungsi = service_kerusakan.fungsi_idfungsi')
            ->where('service_kerusakan.service_idservice', $idservice)
            ->get()
            ->getResult();
    }

    //sparepart
    public function getSparepartWithBarang($idservice)
    {
        return $this->db->table('service_sparepart')
            ->select('
            service_sparepart.idservice_sparepart,
            service_sparepart.harga_penjualan,
            service_sparepart.sub_total,
            service_sparepart.diskon_penjualan,
            service_sparepart.barang_idbarang,
            barang.nama_barang
        ')
            ->join('barang', 'barang.idbarang = service_sparepart.barang_idbarang')
            ->where('service_sparepart.service_idservice', $idservice)
            ->get()
            ->getResult();
    }

    //pelanggan teknisi
    public function getServiceWithAkunAndPelanggan($idservice)
    {
        return $this->db->table('service')
            ->select('
            service.*,
            akun.NAMA_AKUN AS nama_service_by,
            pelanggan.nama AS nama_pelanggan
        ')
            ->join('akun', 'akun.ID_AKUN = service.service_by', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan', 'left')
            ->where('service.idservice', $idservice)
            ->get()
            ->getRow();
    }




    public function filterexport($tanggal_awal = null, $tanggal_akhir = null)
    {
        $builder = $this->db->table('service')
            ->select('
            service.*,
            akun.NAMA_AKUN AS nama_service_by,
            pelanggan.nama AS nama_pelanggan
        ')
            ->join('akun', 'akun.ID_AKUN = service.service_by', 'left')
            ->join('pelanggan', 'pelanggan.id_pelanggan = service.pelanggan_id_pelanggan', 'left');



        if ($tanggal_awal && $tanggal_akhir) {

            $tanggal_akhir .= ' 23:59:59';
            $builder->where('service.created_at >=', $tanggal_awal)
                ->where('service.created_at <=', $tanggal_akhir);
        }

        return $builder->get()->getResult();
    }

    public function filterexportlaba($tanggal_awal = null, $tanggal_akhir = null)
    {
        $builder = $this->select('
            service.*,
            SUM(service_sparepart.hpp_penjualan) AS total_hpp_penjualan,
            (service.harus_dibayar - SUM(service_sparepart.hpp_penjualan)) AS laba_service,
            akun.NAMA_AKUN AS nama_teknisi
        ')
            ->join('service_sparepart', 'service_sparepart.service_idservice = service.idservice', 'left')
            ->join('akun', 'akun.ID_AKUN = service.service_by', 'left')
            ->where('service.status_service', 4);

        if ($tanggal_awal && $tanggal_akhir) {

            $tanggal_akhir .= ' 23:59:59';
            $builder->where('service.created_at >=', $tanggal_awal)
                ->where('service.created_at <=', $tanggal_akhir);
        }

        return $builder->groupBy('service.idservice')->findAll();
    }
}
