<?php

namespace App\Controllers;

use App\Models\Core;
use Config\Database;
use App\Models\ModelAuth;
use App\Models\ModelKartuStok;
use App\Models\ModelPenjualan;
use App\Models\ModelPelanggan;
use App\Models\ModelService;
use App\Models\ModelPresensi;
use App\Models\ModelJadwalMasuk;
use App\Models\ModelUnit;
use App\Models\ModelPenilaianKPI;
use App\Models\ModelPenilaian;
use App\Models\ModelTemplateKpi;

class Absensi extends BaseController

{

    protected $AuthModel;
    protected $KartuStokModel;
    protected $PenjualanModel;
    protected $PelangganModel;
    protected $ServiceModel;
    protected $PresensiModel;
    protected $JadwalMasukModel;
    protected $UnitModel;
    protected $PenilaianKPIModel;
    protected $PenilaianModel;
    protected $TemplateKpiModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->KartuStokModel = new ModelKartuStok();
        $this->PenjualanModel = new ModelPenjualan();
        $this->PelangganModel = new ModelPelanggan();
        $this->ServiceModel = new ModelService();
        $this->PresensiModel = new ModelPresensi();
        $this->JadwalMasukModel = new ModelJadwalMasuk();
        $this->UnitModel = new ModelUnit();
        $this->PenilaianKPIModel = new ModelPenilaianKPI();
        $this->PenilaianModel = new ModelPenilaian();
        $this->TemplateKpiModel = new ModelTemplateKpi();
    }

    public function index()
    {
        $akunId = session('ID_AKUN');
        date_default_timezone_set('Asia/Jakarta');
        $tanggalHariIni = date('Y-m-d');

        $dataunit = $this->UnitModel->getById(session('ID_UNIT'));


        $data = [
            'body' => 'absensi/absensi',
            'jadwalmasuk' => $this->JadwalMasukModel->getAllbyunit(),
            'presensiHariIni' => $this->PresensiModel->getPresensiHariIni(session('ID_AKUN'), $tanggalHariIni),
            'dataunit' => $dataunit,
            'data_latlong' => $this->AuthModel->getLatLongByAkun($akunId)
        ];



        return view('template', $data);
    }



    public function kirim_lokasi_masuk()
    {
        date_default_timezone_set('Asia/Jakarta');
        $lat = $this->request->getPost('latitude');
        $long = $this->request->getPost('longitude');
        $idjadwalmasuk = $this->request->getPost('idjadwal_masuk');
        $jam_jadwal_masuk = $this->request->getPost('jam_masuk');
        $jam_jadwal_pulang = $this->request->getPost('jam_pulang');
        $jam_toleransi = $this->request->getPost('jam_toleransi');
        $foto_kehadiran = $this->request->getFile('foto_kehadiran');
        $akunId = session('ID_AKUN');

        $waktuMasuk = date('H:i:s');
        $tsMasuk = strtotime($waktuMasuk);
        $tsJadwalMasuk = strtotime($jam_jadwal_masuk);
        $tsToleransi = strtotime($jam_toleransi);

        $selisihDetik = $tsMasuk - $tsJadwalMasuk;

        if ($selisihDetik <= 59) {
            $statusKehadiran = 0;
        } elseif ($tsMasuk < $tsToleransi) {
            $statusKehadiran = 1;
        } else {
            $statusKehadiran = 2;
        }


        $dataunit = $this->UnitModel->getById(session('ID_UNIT'));
        $radius = $dataunit->RADIUS;
        $latUnit = $dataunit->LATITUDE;
        $longUnit = $dataunit->LONGTITUDE;


        $tanggalHariIni = date('Y-m-d');


        //  Cek jarak dari titik unit
        $jarakKm = $this->hitungJarakKm($lat, $long, $latUnit, $longUnit);
        $radiusKm = floatval($radius) / 1000;
        $jarakmeter = $jarakKm * 1000;



        if ($jarakmeter > floatval($radius)) {
            session()->setFlashdata('gagal', 'Lokasi Anda terlalu jauh dari titik absen. Maksimal ' . $radius . ' meter.');
            return redirect()->to(base_url('absensi'));
        }

        // Cek apakah sudah absen hari ini
        $presensiHariIni = $this->PresensiModel
            ->where('akun_idakun', $akunId)
            ->where('idjadwal_masuk', $idjadwalmasuk)
            ->where('DATE(waktu_masuk)', $tanggalHariIni)
            ->first();

        if ($presensiHariIni) {
            session()->setFlashdata('gagal', 'Anda sudah melakukan absen masuk untuk jadwal ini hari ini.');
            return redirect()->to(base_url('absensi'));
        }



        //  Upload foto
        $namaFoto = null;
        if ($foto_kehadiran && $foto_kehadiran->isValid() && !$foto_kehadiran->hasMoved()) {
            $ext = $foto_kehadiran->getClientExtension();
            $timestamp = date('Ymd_His');
            $namaFoto = 'absen_' . $akunId . '_' . $timestamp . '.' . $ext;

            $foto_kehadiran->move(ROOTPATH . 'public/foto_presensi', $namaFoto);
        }


        $data = [
            'waktu_masuk' => date('Y-m-d H:i:s'),
            'jam_jadwal_masuk' => $jam_jadwal_masuk,
            'jam_jadwal_pulang' => $jam_jadwal_pulang,
            'jam_toleransi' => $jam_toleransi,
            'status_absensi' => 0,
            'lat' => $lat,
            'long' => $long,
            'ip' => $this->request->getIPAddress(),
            'foto' => $namaFoto,
            'idjadwal_masuk' => $idjadwalmasuk,
            'akun_idakun' => $akunId,
            'unit_idunit' => session('ID_UNIT'),
            'created_at' => date('Y-m-d H:i:s'),
            'jarak' => $jarakmeter,
            'status_kehadiran' => $statusKehadiran
        ];

        $pegawai_idpegawai = session('ID_AKUN');
        $jabatan_id = session('ID_JABATAN');
        $tanggal_penilaian_kpi = date('Y-m-d H:i:s');

        $template = $this->TemplateKpiModel->getByJabatanAndNama($jabatan_id, 'Kehadiran & Disiplin Waktu ');

        // if ($template) {
        //     $kpi_utama = $template->template_kpi;
        //     $bobot = $template->bobot;
        //     $target = $template->target;
        //     $realisasi = ["1"];
        //     $score = ["1"];

        //     $this->PenilaianKPIModel->insertKPI(
        //         $kpi_utama,
        //         $bobot,
        //         $target,
        //         $realisasi,
        //         $score,
        //         $pegawai_idpegawai,
        //         $tanggal_penilaian_kpi
        //     );
        // }


        $this->PresensiModel->insertPresensi($data);
        session()->setFlashdata('sukses', 'Absen masuk berhasil!');
        return redirect()->to(base_url('absensi'));
    }




    private function getAlamatFromCoordinates($lat, $long)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$long";

        $opts = [
            "http" => [
                "header" => "User-Agent: CI4-Absensi-App"
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response);

        return $data->display_name ?? 'Alamat tidak ditemukan';
    }

    //absen pulang
    public function kirim_lokasi_pulang()
    {
        date_default_timezone_set('Asia/Jakarta');
        $idpresensi = $this->request->getPost('idpresensi');

        $foto_kehadiran = $this->request->getFile('foto_kehadiran');
        $namaFoto = null;

        if ($foto_kehadiran && $foto_kehadiran->isValid() && !$foto_kehadiran->hasMoved()) {
            $ext = $foto_kehadiran->getClientExtension();
            $timestamp = date('Ymd_His');
            $namaFoto = 'absen_' . $idpresensi . '_' . $timestamp . '.' . $ext;

            // Jalankan move() dan pastikan berhasil
            if ($foto_kehadiran->move(ROOTPATH . 'public/foto_presensi', $namaFoto)) {
                // Jika upload berhasil, baru jalankan query update
                $data = [
                    'foto_pulang'   => $namaFoto,
                    'waktu_pulang'  => date('Y-m-d H:i:s'),
                ];
                $this->PresensiModel->update($idpresensi, $data);

                session()->setFlashdata('sukses', 'Absen pulang berhasil!');
                return redirect()->to(base_url('absensi'));
            } else {
                // Jika upload gagal
                session()->setFlashdata('error', 'Gagal mengupload foto. Silakan coba lagi.');
                return redirect()->back()->withInput();
            }
        } else {
            // Jika file tidak valid
            session()->setFlashdata('error', 'File foto tidak valid atau belum dipilih.');
            return redirect()->back()->withInput();
        }
    }



    private function hitungJarakKm($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Radius bumi dalam kilometer
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }
}
