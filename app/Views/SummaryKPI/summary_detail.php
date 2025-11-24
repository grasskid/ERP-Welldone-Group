<h5>Checklist Pekerjaan</h5>
<?php if ($detail_checklist): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Aspek Penilaian</th>
            <th>Bobot</th>
            <th>Target</th>
            <th>realisasi</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail_checklist as $item): ?>
        <tr>
            <td><?= esc($item->aspek_penilaian) ?></td>
            <td><?= esc($item->bobot) ?>%</td>
            <td><?= esc($item->target) ?></td>
            <td><?= esc($item->skor) ?></td>
            <td>
                <?php
                        if ($item->target > 0 && $item->bobot > 0) {
                            $score = ($item->skor / $item->target) * $item->bobot / 100;
                            echo number_format($score, 2) . "%";
                        } else {
                            echo "-";
                        }
                        ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Tidak ada data checklist pekerjaan</p>
<?php endif; ?>


<h5>Performance Grading</h5>
<?php if ($detail_grading): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Indikator</th>
            <th>Bobot</th>
            <th>Target</th>
            <th>realisasi</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detail_grading as $item): ?>
        <tr>
            <td><?= esc($item->kpi_utama) ?></td>
            <td><?= esc($item->bobot) ?>%</td>
            <td><?= esc($item->target) ?></td>
            <td><?= esc($item->realisasi) ?></td>
            <td>
                <?php
                        if ($item->target > 0 && $item->bobot > 0) {
                            $score = $item->realisasi / $item->target * $item->bobot;
                            echo number_format($score, 2) . "%";
                        } else {
                            echo "-";
                        }
                        ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <tfoot>
        <tr>
            <td colspan="4" class="text-center"><b>Grading Karyawan Score</b></td>
            <td>
                <?php
                    $total_score = 0;
                    foreach ($detail_grading as $item) {
                        $total_score += $item->score;
                    }
                    echo number_format($total_score, 2) . "%";
                    ?>
            </td>
        </tr>
    </tfoot>
    </tbody>
</table>
<?php else: ?>
<p>Tidak ada data performance grading</p>
<?php endif; ?>

<h5>Key Performance Indicator</h5>
<?php if ($detail_kpi): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>KPI Utama</th>
            <th>Bobot</th>
            <th>Target</th>
            <th>realisasi</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        <?php

            foreach ($detail_kpi as $item): ?>
        <tr>
            <td><?= esc($item->kpi_utama) ?></td>
            <td><?= esc($item->bobot) ?>%</td>
            <td><?= esc($item->target) ?></td>
            <td><?= esc($item->realisasi) ?></td>
            <td><b>
                    <?php
                            if ($item->target > 0 && $item->bobot > 0) {
                                $score = $item->realisasi / $item->target * $item->bobot;
                                echo number_format($score, 2) . "%";
                            } else {
                                echo "-";
                            }
                            ?>
                </b></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-center"><b>KPI Score Karyawan</b></td>
            <td><b>
                    <?php
                        $total_score = 0;
                        foreach ($detail_kpi as $item) {
                            $total_score += $item->score;
                        }
                        echo number_format($total_score, 2) . "%";
                        ?>
                </b></td>
        </tr>
    </tfoot>
</table>
<?php else: ?>
<p>Tidak ada data key performance indicator</p>
<?php endif; ?>