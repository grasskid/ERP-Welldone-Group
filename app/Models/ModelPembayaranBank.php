<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPembayaranBank extends Model
{
    protected $table = 'pembayaran_bank';
    protected $primaryKey = 'idpembayaran_bank';
    protected $returnType = 'object';
    protected $allowedFields = ['idpembayaran_bank', 'kode_pembayaran', 'jumlah', 'bank_idbank', 'tabel_referensi', 'id_referensi'];

    public function getAll()
    {
        return $this->findAll();
    }

    public function insertPembayaranBank($data)
    {
        return $this->insert($data);
    }

    public function getById($idpembayaran_bank)
    {
        return $this->where(['idpembayaran_bank' => $idpembayaran_bank])->first();
    }

    public function getByBankId($bank_idbank)
    {
        return $this->where(['bank_idbank' => $bank_idbank])->findAll();
    }

    public function getByReferensi($tabel_referensi, $id_referensi)
    {
        return $this->where([
            'tabel_referensi' => $tabel_referensi,
            'id_referensi' => $id_referensi
        ])->findAll();
    }

    public function updateByKodePembayaran(string $kodePembayaran, array $data): bool
    {
        return $this->where('kode_pembayaran', $kodePembayaran)
            ->set($data)
            ->update();
    }

    public function getByServiceBaru($idservice)
    {
        return $this->where('tabel_referensi', 'service_baru')
            ->where('id_referensi', $idservice)
            ->findAll();
    }

    public function getByServiceGaransi($idservice)
    {
        return $this->where('tabel_referensi', 'service_garansi_1')
            ->where('id_referensi', $idservice)
            ->findAll();
    }

    public function updateByReferensi($idReferensi, $data)
    {
        return $this->where('tabel_referensi', 'service_garansi_1')
            ->where('id_referensi', $idReferensi)
            ->set($data)
            ->update();
    }
}
