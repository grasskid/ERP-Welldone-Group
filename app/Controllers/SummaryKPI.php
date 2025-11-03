<?php

namespace App\Controllers;

use App\Models\ModelSuplier;
use App\Models\ModelUnit;
use App\Models\ModelAuth;
use App\Models\ModelSummaryKPI;

class SummaryKPI extends BaseController
{
    protected $AuthModel;
    protected $UnitModel;
    protected $SummaryKPIModel;

    public function __construct()
    {
        $this->AuthModel = new ModelAuth();
        $this->UnitModel = new ModelUnit();
        $this->SummaryKPIModel = new ModelSummaryKPI();
    }

    public function summary_kpi()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));
        
        // Get month filters from request, default to last 6 months
        $startMonth = $this->request->getGet('start_month');
        $endMonth = $this->request->getGet('end_month');
        $id_unit = $this->request->getGet('id_unit');

        if (!$startMonth) {
            $startMonth = date('Y-m', strtotime('-5 months'));
        }
        if (!$endMonth) {
            $endMonth = date('Y-m');
        }

        // Get data from view
        $rawData = $this->SummaryKPIModel->getSummaryKPI($startMonth, $endMonth, $id_unit);
        
        // Get months in range for columns
        $months = $this->SummaryKPIModel->getMonthsInRange($startMonth, $endMonth);
        
        // Pivot data: group by employee/KPI and create columns for each month
        $pivotedData = [];
        $monthLabels = [];

        // Create month labels for display
        foreach ($months as $month) {
            $monthLabels[$month] = date('M Y', strtotime($month . '-01'));
        }

        // Process raw data and pivot it
        foreach ($rawData as $row) {
            // Assuming the view has columns like: pegawai_id, nama_pegawai, kpi, bulan (YYYY-MM), nilai/score
            // Adjust these field names based on your actual view structure
            $key = $row->ID_AKUN ?? $row->NAMA_AKUN ?? null;
            $kpiName = 'KPI';
            $bulan = date('Y-m', strtotime($row->tanggal ??  date('Y-m')));
            $nilai = $row->score ?? 0;

            if (!$key) continue;

            $rowKey = $key . '|' . $kpiName;
            
            if (!isset($pivotedData[$rowKey])) {
                $pivotedData[$rowKey] = [
                    'pegawai_id' => $row->ID_AKUN ?? null,
                    'nama_unit' => $row->NAMA_UNIT ?? null,
                    'nama_pegawai' => $row->NAMA_AKUN ?? '',
                    'nama_jabatan' => $row->NAMA_JABATAN ?? '',
                    'kpi' => $kpiName,
                    'months' => []
                ];
            }

            $pivotedData[$rowKey]['months'][$bulan] = $nilai;
        }
        // die(json_encode($pivotedData));

        // Fill missing months with 0 or null
        foreach ($pivotedData as &$row) {
            foreach ($months as $month) {
                if (!isset($row['months'][$month])) {
                    $row['months'][$month] = null;
                }
            }
        }

        $data = [
            'title' => 'Summary KPI',
            'body' => 'SummaryKPI/summary_kpi',
            'akun' => $akun,
            'unit' => $this->UnitModel->getUnit(),
            'pivotedData' => $pivotedData,
            'months' => $months,
            'monthLabels' => $monthLabels,
            'start_month' => $startMonth,
            'end_month' => $endMonth
        ];

        // die(json_encode($data['unit']));

        return view('template', $data);
    }

    public function summary_grading()
    {
        $akun = $this->AuthModel->getById(session('ID_AKUN'));

        // Get month filters from request, default to last 6 months
        $startMonth = $this->request->getGet('start_month');
        $endMonth = $this->request->getGet('end_month');
        $id_unit = $this->request->getGet('id_unit');

        if (!$startMonth) {
            $startMonth = date('Y-m', strtotime('-5 months'));
        }
        if (!$endMonth) {
            $endMonth = date('Y-m');
        }

        // Get data from view
        $rawData = $this->SummaryKPIModel->getSummaryGrading($startMonth, $endMonth, $id_unit);

        // Get months in range for columns
        $months = $this->SummaryKPIModel->getMonthsInRange($startMonth, $endMonth);

        // Pivot data: group by employee/KPI and create columns for each month
        $pivotedData = [];
        $monthLabels = [];

        // Create month labels for display
        foreach ($months as $month) {
            $monthLabels[$month] = date('M Y', strtotime($month . '-01'));
        }

        // Process raw data and pivot it
        foreach ($rawData as $row) {
            // Assuming the view has columns like: pegawai_id, nama_pegawai, kpi, bulan (YYYY-MM), nilai/score
            // Adjust these field names based on your actual view structure
            $key = $row->ID_AKUN ?? $row->NAMA_AKUN ?? null;
            $kpiName = 'KPI';
            $bulan = date('Y-m', strtotime($row->tanggal ??  date('Y-m')));
            $nilai = $row->score ?? 0;

            if (!$key) continue;

            $rowKey = $key . '|' . $kpiName;

            if (!isset($pivotedData[$rowKey])) {
                $pivotedData[$rowKey] = [
                    'pegawai_id' => $row->ID_AKUN ?? null,
                    'nama_unit' => $row->NAMA_UNIT ?? null,
                    'nama_pegawai' => $row->NAMA_AKUN ?? '',
                    'nama_jabatan' => $row->NAMA_JABATAN ?? '',
                    'kpi' => $kpiName,
                    'months' => []
                ];
            }

            $pivotedData[$rowKey]['months'][$bulan] = $nilai;
        }
        // die(json_encode($pivotedData));

        // Fill missing months with 0 or null
        foreach ($pivotedData as &$row) {
            foreach ($months as $month) {
                if (!isset($row['months'][$month])) {
                    $row['months'][$month] = null;
                }
            }
        }

        $data = [
            'title' => 'Summary Grading',
            'body' => 'SummaryKPI/summary_grading',
            'akun' => $akun,
            'unit' => $this->UnitModel->getUnit(),
            'pivotedData' => $pivotedData,
            'months' => $months,
            'monthLabels' => $monthLabels,
            'start_month' => $startMonth,
            'end_month' => $endMonth
        ];

        // die(json_encode($data['unit']));

        return view('template', $data);
    }

    public function summary_detail()
    {
        $id_akun = $this->request->getPost('id_akun');
        $month = $this->request->getPost('month');
        $detail_checklist = $this->SummaryKPIModel->getDetailChecklist($id_akun, $month);
        $detail_grading = $this->SummaryKPIModel->getDetailGrading($id_akun, $month);
        $detail_kpi = $this->SummaryKPIModel->getDetailKPI($id_akun, $month);
        $data = [
            'detail_checklist' => $detail_checklist,
            'detail_grading' => $detail_grading,
            'detail_kpi' => $detail_kpi,
        ];
        return view('SummaryKPI/summary_detail', $data);
    }
}
