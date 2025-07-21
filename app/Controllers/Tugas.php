<?php

namespace App\Controllers;

use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelTugas;
use App\Models\ModelTugasTemplate;

class Tugas extends BaseController

{

    protected $AuthModel;
    protected $TugasModel;
    protected $TugasTemplateModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->TugasModel = new ModelTugas();
        $this->TugasTemplateModel = new ModelTugasTemplate();
    }

public function index()
{
    date_default_timezone_set('Asia/Jakarta');

    $akun = $this->AuthModel->getById(session('ID_AKUN'));
    $idakun = $akun->ID_AKUN;

    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');

    if (!$tanggal_awal || !$tanggal_akhir) {
        $default_awal = date('Y-m-d', strtotime('-1 month'));
        $default_akhir = date('Y-m-d');
        return redirect()->to(current_url() . "?tanggal_awal=$default_awal&tanggal_akhir=$default_akhir");
    }

    // ✅ Only get templates where user's ID_JABATAN matches
    $templates = $this->TugasTemplateModel
        ->where('ID_JABATAN', $akun->ID_JABATAN)
        ->findAll();

    foreach ($templates as $template) {
        $existing = $this->TugasModel
            ->where('nama_tugas', $template->nama_tugas)
            ->where('akun_ID_AKUN', $idakun)
            ->where('status_template', 1)
            ->first();

        if (!$existing) {
            $this->TugasModel->insert_Tugas([
                'nama_tugas'      => $template->nama_tugas,
                'deskripsi'       => $template->deskripsi,
                'start_date'      => $template->start_date,
                'end_date'        => $template->end_date,
                'status_template' => 1,
                'akun_ID_AKUN'    => $idakun,
                'status'          => 1,
                'created_at'      => date('Y-m-d H:i:s'),
            ]);
        }
    }

    $tugas = $this->TugasModel->getTugasByAkun2($idakun, $tanggal_awal, $tanggal_akhir);

    $data = [
        'akun' => $akun,
        'tugas' => $tugas,
        'tugastemplate' => $templates,
        'tanggal_awal' => $tanggal_awal,
        'tanggal_akhir' => $tanggal_akhir,
        'body' => 'HR/tugas'
    ];

    return view('template', $data);
}

    public function index2()
    {
        $akun =   $this->AuthModel->getById(session('ID_AKUN'));
        $idakun = $akun->ID_AKUN;

        $data =  array(
            'akun' => $akun,
            'tugas' => $this->TugasModel->getAllTugasWithAkun(),
            'tugastemplate' => $this->TugasTemplateModel->getTugasTemplateByAkun($idakun),
            'body'  => 'HR/alltugas'
        );
        return view('template', $data);
    }


    public function insert()
    {
        $nama_tugas = $this->request->getPost('nama_tugas');
        $deskripsi_tugas = $this->request->getPost('deskripsi_tugas');
        $foto_tugas = $this->request->getFile('foto_tugas');
        $akun_ID_AKUN = session('ID_AKUN');
        $status = $this->request->getPost('status');


        $created_at = (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');

        $fotoNama = null;

        if ($foto_tugas && $foto_tugas->isValid() && !$foto_tugas->hasMoved()) {
            //nama unik
            $fotoNama = uniqid('tugas_') . '.' . $foto_tugas->getExtension();
            $foto_tugas->move(ROOTPATH . 'public/foto_tugas', $fotoNama);
        }

        $data = [
            'nama_tugas' => $nama_tugas,
            'deskripsi' => $deskripsi_tugas,
            'foto_tugas' => $fotoNama,
            'akun_ID_AKUN' => $akun_ID_AKUN,
            'status' => $status,
            'created_at' => $created_at,
        ];

        $result = $this->TugasModel->insert_Tugas($data);
        if ($result) {
            session()->setFlashData('sukses', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('tugas'));
        } else {
            session()->setFlashData('gagal', 'Gagal menyimpan data.');
            return redirect()->back()->withInput();
        }
    }


    public function update()
    {
        $nama_tugas = $this->request->getPost('nama_tugas');
        $deskripsi_tugas = $this->request->getPost('deskripsi_tugas');
        $foto_tugas = $this->request->getFile('foto_tugas');
        $akun_ID_AKUN = session('ID_AKUN');
        $status = $this->request->getPost('status');
        $idtugas = $this->request->getPost('idtugas');

        $updated_at = (new \DateTime('now', new \DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');

        // Ambil data lama (objek karena returnType adalah 'object')
        $tugasLama = $this->TugasModel->find($idtugas);

        // Default pakai foto lama
        $fotoNama = $tugasLama->foto_tugas;

        if ($foto_tugas && $foto_tugas->isValid() && !$foto_tugas->hasMoved()) {
            // Nama unik untuk file baru
            $fotoNama = uniqid('tugas_') . '.' . $foto_tugas->getExtension();
            $foto_tugas->move(ROOTPATH . 'public/foto_tugas/', $fotoNama);

            // Hapus foto lama jika ada
            if (!empty($tugasLama->foto_tugas) && file_exists(ROOTPATH . 'public/foto_tugas/' . $tugasLama->foto_tugas)) {
                unlink(ROOTPATH . 'public/foto_tugas/' . $tugasLama->foto_tugas);
            }
        }

        $data = [
            'nama_tugas' => $nama_tugas,
            'deskripsi' => $deskripsi_tugas,
            'foto_tugas' => $fotoNama,
            'akun_ID_AKUN' => $akun_ID_AKUN,
            'status' => $status,
            'updated_at' => $updated_at,
        ];

        $result = $this->TugasModel->update($idtugas, $data);
        if ($result) {
            session()->setFlashData('sukses', 'Data Berhasil Diperbarui');
            return redirect()->to(base_url('tugas'));
        } else {
            session()->setFlashData('gagal', 'Gagal memperbarui data.');
            return redirect()->back()->withInput();
        }
    }



    public function delete()
    {
        $idtugas = $this->request->getPost('idtugas');
        $result =  $this->TugasModel->delete($idtugas);
        if ($result) {
            session()->setFlashData('sukses', 'Data Berhasil Diperbarui');
            return redirect()->to(base_url('tugas'));
        } else {
            session()->setFlashData('gagal', 'Gagal memperbarui data.');
            return redirect()->back()->withInput();
        }
    }

    public function clear_all()
    {
        $status = $this->request->getPost('status');
        $akun_ID_AKUN = $this->request->getPost('akun_ID_AKUN');
        $result = $this->TugasModel->deleteByAkunAndStatus($akun_ID_AKUN, $status);
        if ($result) {
            session()->setFlashData('sukses', 'Data Berhasil Diperbarui');
            return redirect()->to(base_url('tugas'));
        } else {
            session()->setFlashData('gagal', 'Gagal memperbarui data.');
            return redirect()->back()->withInput();
        }
    }

        public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $data = $this->request->getJSON();
            $id = $data->id;
            $status = $data->status;

            if ($this->TugasModel->update($id, ['status' => $status])) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'gagal' => 'Update failed']);
            }
        }

        return $this->response->setStatusCode(403);
    }

    public function saveTugas()
    {
        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads', $fileName);
        }

        $data = [
            'nama_tugas' => $this->request->getPost('nama_tugas'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file' => $fileName,
            'akun_ID_AKUN' => session('ID_AKUN'),
            'status' => $this->request->getPost('status')
        ];

        $this->TugasModel->insert_Tugas($data);

        return redirect()->to('/tugas');
    }

}