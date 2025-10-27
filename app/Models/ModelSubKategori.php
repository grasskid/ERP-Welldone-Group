<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSubKategori extends Model
{
    protected $table = 'sub_kategori';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'nama_sub_kategori', 'id_kategori_parent', 'delete'];

    public function getSubKategori()
    {
        return $this->where('delete', 0)->findAll();
    }
<<<<<<< HEAD
    //
    public function getSubKategoriByParent($id_kategori_parent)
    {
        return $this->where('delete', 0)
            ->where('id_kategori_parent', $id_kategori_parent)
            ->findAll();
=======

    public function getSubKategoriByParent($id_kategori_parent)
    {
        return $this->where('delete', 0)
                    ->where('id_kategori_parent', $id_kategori_parent)
                    ->findAll();
>>>>>>> 991fc15cd495b8ffe4d5673847f07a6325d608bc
    }

    public function insert_SubKategori($data)
    {
        // Remove id_sub_kategori from data as it will be auto-generated
        unset($data['id_sub_kategori']);
        return $this->insert($data);
    }

    public function getById($id_sub_kategori)
    {
        return $this->where(['id' => $id_sub_kategori])->first();
    }

    public function getByName($nama_sub_kategori)
    {
        return $this->where(['nama_sub_kategori' => $nama_sub_kategori])->first();
    }

    public function updateSubKategori($id, $data)
    {
        return $this->update($id, $data);
    }
}
