<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBundle extends Model
{
    protected $table = 'bundle';
    protected $primaryKey = 'idbundle';
    protected $returnType = 'object';
    protected $allowedFields = ['idbundle', 'nama_bundle', 'harga_total', 'harga_jual'];

    public function getBundle()
    {
        return $this->findAll();
    }


    public function getById($idbundle)
    {
        return $this->where(['idbundle' => $idbundle])->first();
    }

    public function getBundleWithDetail()
    {
        $result = $this->select('
            bundle.idbundle,
            bundle.nama_bundle,
            bundle.harga_total,
            bundle.harga_jual,
            detail_bundle.iddetail_bundle,
            detail_bundle.barang_idbarang,
            detail_bundle.jumlah,
            stok_barang.stok_akhir,
            barang.nama_barang
        ')
            ->join('detail_bundle', 'detail_bundle.bundle_idbundle = bundle.idbundle')
            ->join('stok_barang', 'stok_barang.idbarang = detail_bundle.barang_idbarang', 'left') // LEFT JOIN
            ->join('barang', 'barang.idbarang = detail_bundle.barang_idbarang', 'left')
            ->orderBy('bundle.idbundle')
            ->findAll();



        $bundles = [];
        foreach ($result as $row) {
            $idbundle = $row->idbundle;

            if (!isset($bundles[$idbundle])) {
                $bundles[$idbundle] = (object)[
                    'idbundle'    => $row->idbundle,
                    'nama_bundle' => $row->nama_bundle,
                    'harga_total' => $row->harga_total,
                    'harga_jual'  => $row->harga_jual,
                    'detail'      => [],
                    'status_stok' => 'Tersedia'
                ];
            }


            $bundles[$idbundle]->detail[] = (object)[
                'iddetail_bundle' => $row->iddetail_bundle,
                'barang_idbarang' => $row->barang_idbarang,
                'jumlah'          => $row->jumlah,
                'nama_barang'     => $row->nama_barang,
                'stok_akhir'      => $row->stok_akhir,
            ];


            if ($row->stok_akhir === null || $row->stok_akhir < $row->jumlah) {
                $bundles[$idbundle]->status_stok = 'Tidak Tersedia';
            }
        }

        return array_values($bundles);
    }
}
