<?php

namespace App\Controllers;

use App\Models\ModelPresensi;
use App\Models\ModelAuth;
use App\Models\ModelPenilaian;
use App\Models\ModelTugas;
use App\Models\ModelUnit;
use Config\Database;

class DashboardHRD extends BaseController
{
    protected $PresensiModel;
    protected $AuthModel;
    protected $PenilaianModel;
    protected $TugasModel;
    protected $UnitModel;
    protected $db;

    public function __construct()
    {
        $this->PresensiModel = new ModelPresensi();
        $this->AuthModel = new ModelAuth();
        $this->PenilaianModel = new ModelPenilaian();
        $this->TugasModel = new ModelTugas();
        $this->UnitModel = new ModelUnit();
        $this->db = Database::connect();
    }

    public function index()
    {
        // Get filter parameters
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d');
        $unitId = $this->request->getGet('unit_id');

        // Get units for dropdown
        $units = $this->UnitModel->findAll();

        // Build query conditions
        $unitCondition = [];
        if ($unitId) {
            $unitCondition = ['unit.idunit' => $unitId];
        }

        // Total Pegawai
        $totalPegawai = $this->AuthModel
            ->where('deleted', 0);
        
        if ($unitId) {
            $totalPegawai->where('ID_UNIT', $unitId);
        }
        
        $totalPegawai = $totalPegawai->countAllResults(false);

        // Total Presensi (dalam rentang tanggal)
        $totalPresensi = $this->db->table('presensi')
            ->select('presensi.*, akun.ID_UNIT, unit.idunit')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('DATE(presensi.waktu_masuk) >=', $startDate)
            ->where('DATE(presensi.waktu_masuk) <=', $endDate);
        
        if ($unitId) {
            $totalPresensi->where('unit.idunit', $unitId);
        }
        
        $totalPresensi = $totalPresensi->countAllResults(false);

        // Reset the model for next query
        $this->TugasModel->resetQuery();

        // Total Tugas
        $totalTugas = $this->TugasModel
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->where('DATE(tugas.created_at) >=', $startDate)
            ->where('DATE(tugas.created_at) <=', $endDate);
        
        if ($unitId) {
            $totalTugas->where('ID_UNIT', $unitId);
        }
        
        $totalTugas = $totalTugas->countAllResults(false);

        // Reset the model for next query
        $this->TugasModel->resetQuery();
        
        // Tugas Selesai
        $tugasSelesai = $this->TugasModel
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->where('status', 'selesai')
            ->where('DATE(created_at) >=', $startDate )
            ->where('DATE(created_at) <=', $endDate);
        
        if ($unitId) {
            $tugasSelesai->where('ID_UNIT', $unitId);
        }
        
        $tugasSelesai = $tugasSelesai->countAllResults(false);

        // Reset the model for next query
        $this->TugasModel->resetQuery();

        // Chart data - Presensi per hari
        $presensiData = $this->db->table('presensi')
            ->select("DATE(presensi.waktu_masuk) as tanggal, COUNT(*) as jumlah")
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('DATE(presensi.waktu_masuk) >=', $startDate)
            ->where('DATE(presensi.waktu_masuk) <=', $endDate);
        
        if ($unitId) {
            $presensiData->where('unit.idunit', $unitId);
        }
        
        $presensiData = $presensiData->groupBy('DATE(presensi.waktu_masuk)')
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->getResult();

        $chartLabels = [];
        $chartValues = [];
        foreach ($presensiData as $row) {
            $chartLabels[] = date('d M Y', strtotime($row->tanggal));
            $chartValues[] = (int) $row->jumlah;
        }

        // Status Presensi
        $statusPresensi = $this->db->table('presensi')
            ->select('presensi.status_kehadiran, COUNT(*) as jumlah')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('DATE(presensi.waktu_masuk) >=', $startDate)
            ->where('DATE(presensi.waktu_masuk) <=', $endDate);
        
        if ($unitId) {
            $statusPresensi->where('unit.idunit', $unitId);
        }
        
        $statusPresensi = $statusPresensi->groupBy('presensi.status_kehadiran')
            ->get()
            ->getResult();

        $statusLabels = [];
        $statusCounts = [];
        foreach ($statusPresensi as $row) {
            $statusLabels[] = $row->status_kehadiran ?? 'Tidak Ada Status';
            $statusCounts[] = (int) $row->jumlah;
        }

        // Top 5 Pegawai dengan Presensi Terbanyak
        $topPegawai = $this->db->table('presensi')
            ->select('akun.NAMA_AKUN, COUNT(*) as jumlah')
            ->join('akun', 'akun.ID_AKUN = presensi.akun_idakun', 'left')
            ->join('unit', 'unit.idunit = akun.ID_UNIT', 'left')
            ->where('DATE(presensi.waktu_masuk) >=', $startDate)
            ->where('DATE(presensi.waktu_masuk) <=', $endDate);
        
        if ($unitId) {
            $topPegawai->where('unit.idunit', $unitId);
        }
        
        $topPegawai = $topPegawai->groupBy('presensi.akun_idakun')
            ->orderBy('jumlah', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        $pegawaiLabels = array_map(fn($row) => $row->NAMA_AKUN ?? 'Unknown', $topPegawai);
        $pegawaiData = array_map(fn($row) => (int) ($row->jumlah ?? 0), $topPegawai);

        // Status Tugas
        $statusTugas = $this->TugasModel
            ->select('status, COUNT(*) as jumlah')
            ->join('akun', 'akun.ID_AKUN = tugas.akun_ID_AKUN')
            ->where('created_at >=', $startDate . ' 00:00:00')
            ->where('created_at <=', $endDate . ' 23:59:59');
        
        if ($unitId) {
            $statusTugas->where('akun.ID_UNIT', $unitId);
        }
        
        $statusTugas = $statusTugas->groupBy('status')
            ->findAll();

        // Reset the model for next query
        $this->TugasModel->resetQuery();

        $tugasStatusLabels = [];
        $tugasStatusCounts = [];
        foreach ($statusTugas as $row) {
            $tugasStatusLabels[] = ucfirst($row->status ?? 'Unknown');
            $tugasStatusCounts[] = (int) $row->jumlah;
        }

        $data = [
            'title' => 'Dashboard HRD',
            'body' => 'dashboard/dashboard_hrd',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'unit_id' => $unitId,
            'units' => $units,
            'total_pegawai' => $totalPegawai,
            'total_presensi' => $totalPresensi,
            'total_tugas' => $totalTugas,
            'tugas_selesai' => $tugasSelesai,
            'chart_labels' => $chartLabels,
            'chart_values' => $chartValues,
            'status_labels' => $statusLabels,
            'status_counts' => $statusCounts,
            'pegawai_labels' => $pegawaiLabels,
            'pegawai_data' => $pegawaiData,
            'tugas_status_labels' => $tugasStatusLabels,
            'tugas_status_counts' => $tugasStatusCounts,
        ];

        return view('template', $data);
    }
}

