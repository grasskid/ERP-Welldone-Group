<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;
use Config\Database;

class ModelSummaryKPI extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Get summary KPI data from view with month filter
     * @param string $startMonth Format: YYYY-MM
     * @param string $endMonth Format: YYYY-MM
     * @return array
     */
    public function getSummaryKPI($startMonth = null, $endMonth = null, $id_unit = null)
    {
        $builder = $this->db->table('summary_grading_kpi');

        // Filter by month if provided
        if ($startMonth) {
            $builder->where("tanggal >=", $startMonth);
        }
        if ($endMonth) {
            $builder->where("tanggal <=", $endMonth);
        }
        if ($id_unit) {
            $builder->where("ID_UNIT", $id_unit);
        }
        $builder->where("level", 2);
        return $builder->get()->getResult();
    }

    public function getSummaryGrading($startMonth = null, $endMonth = null, $id_unit = null)
    {
        $builder = $this->db->table('summary_grading_kpi');

        // Filter by month if provided
        if ($startMonth) {
            $builder->where("tanggal >=", $startMonth);
        }
        if ($endMonth) {
            $builder->where("tanggal <=", $endMonth);
        }
        if ($id_unit) {
            $builder->where("ID_UNIT", $id_unit);
        }
        $builder->where("level", 1);
        return $builder->get()->getResult();
    }

    public function getDetailChecklist($id_akun, $month)
    {
        $builder = $this->db->table('penilaian_detail');
        $builder->select('penilaian_detail.*, template_penilaian.aspek_penilaian');
        $builder->join('template_penilaian', 'template_penilaian.idtemplate_penilaian = penilaian_detail.template_penilaian_idtemplate_penilaian', 'left');
        $builder->where("pegawai_idpegawai", $id_akun);
        $builder->where("MONTH(tanggal_penilaian)", date('m', strtotime($month)));
        $builder->where("YEAR(tanggal_penilaian)", date('Y', strtotime($month)));
        $builder->orderBy("tanggal_penilaian", "ASC");
        return $builder->get()->getResult();
    }

    public function getDetailGrading($id_akun, $month)
    {
        $builder = $this->db->table('penilaian_kpi');
        $builder->where("pegawai_idpegawai", $id_akun);
        $builder->where("level", '1');
        $builder->where("MONTH(tanggal_penilaian_kpi)", date('m', strtotime($month)));
        $builder->where("YEAR(tanggal_penilaian_kpi)", date('Y', strtotime($month)));
        $builder->orderBy("tanggal_penilaian_kpi", "ASC");
        return $builder->get()->getResult();
    }

    public function getDetailKPI($id_akun, $month)
    {
        $builder = $this->db->table('penilaian_kpi');
        $builder->where("pegawai_idpegawai", $id_akun);
        $builder->where("level", '2');
        $builder->where("MONTH(tanggal_penilaian_kpi)", date('m', strtotime($month)));
        $builder->where("YEAR(tanggal_penilaian_kpi)", date('Y', strtotime($month)));
        $builder->orderBy("tanggal_penilaian_kpi", "ASC");
        return $builder->get()->getResult();
    }

    /**
     * Get unique months in range
     * @param string $startMonth Format: YYYY-MM
     * @param string $endMonth Format: YYYY-MM
     * @return array
     */
    public function getMonthsInRange($startMonth, $endMonth)
    {
        $months = [];
        $start = new \DateTime($startMonth . '-01');
        $end = new \DateTime($endMonth . '-01');
        $interval = new \DateInterval('P1M');
        $period = new \DatePeriod($start, $interval, $end->modify('+1 month'));

        foreach ($period as $dt) {
            $months[] = $dt->format('Y-m');
        }

        return $months;
    }
}