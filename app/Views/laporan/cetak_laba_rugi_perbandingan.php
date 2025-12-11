<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi - Perbandingan Unit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
        }

        .report-title {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }

        .period {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: none;
        }

        .description {
            width: 60%;
        }

        .amount {
            width: 40%;
            text-align: right;
        }

        .section-header {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .sub-item {
            padding-left: 20px;
        }

        .total {
            font-weight: bold;
            border-top: 1px solid #000;
        }

        .negative {
            color: #ff0000;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
        }

        @media print {
            body {
                margin: 0;
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">WELLDONE NON PON</div>
        <div class="report-title">Laporan Laba/Rugi (Perbandingan Unit)</div>
        <div class="period">
            Dari <?= $tanggal_awal ? date('d M Y', strtotime($tanggal_awal)) : '01 ' . date('M Y') ?>
            s/d <?= $tanggal_akhir ? date('d M Y', strtotime($tanggal_akhir)) : date('d M Y') ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="description">Keterangan</th>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <th class="amount"><?= esc($nama_unit) ?></th>
                <?php endforeach; ?>
                <th class="amount">Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- PENDAPATAN OPERASIONAL -->
            <tr class="section-header">
                <td class="description">PENDAPATAN</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount"></td>
                <?php endforeach; ?>
                <td class="amount"></td>
            </tr>
            <tr class="section-header">
                <td class="description">Pendapatan Operasional</td>
                <?php 
                $total_pendapatan_operasional_row = 0;
                foreach ($units_info as $id_unit => $nama_unit): 
                    $total = $data_per_unit[$id_unit]['total_pendapatan'];
                    $total_pendapatan_operasional_row += $total;
                ?>
                    <td class="amount"><?= number_format($total, 2, ',', '.') ?></td>
                <?php endforeach; ?>
                <td class="amount"><?= number_format($total_pendapatan_operasional_row, 2, ',', '.') ?></td>
            </tr>

            <?php
            // Get all unique account numbers from all units
            $all_pendapatan_accounts = [];
            foreach ($data_per_unit as $id_unit => $data) {
                foreach ($data['pendapatan'] as $item) {
                    if (!isset($all_pendapatan_accounts[$item->no_akun])) {
                        $all_pendapatan_accounts[$item->no_akun] = [
                            'no_akun' => $item->no_akun,
                            'nama_akun' => $item->nama_akun,
                        ];
                    }
                }
            }
            ksort($all_pendapatan_accounts);
            ?>

            <?php foreach ($all_pendapatan_accounts as $account): ?>
                <tr class="sub-item">
                    <td class="description"><?= esc($account['nama_akun']) ?></td>
                    <?php 
                    $row_total = 0;
                    foreach ($units_info as $id_unit => $nama_unit): 
                        $saldo = 0;
                        foreach ($data_per_unit[$id_unit]['pendapatan'] as $item) {
                            if ($item->no_akun == $account['no_akun']) {
                                $saldo = $item->saldo;
                                break;
                            }
                        }
                        $row_total += $saldo;
                    ?>
                        <td class="amount <?= $saldo < 0 ? 'negative' : '' ?>">
                            <?= number_format($saldo, 2, ',', '.') ?>
                        </td>
                    <?php endforeach; ?>
                    <td class="amount <?= $row_total < 0 ? 'negative' : '' ?>">
                        <?= number_format($row_total, 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr class="section-header">
                <td class="description">Jumlah Pendapatan</td>
                <?php 
                $total_pendapatan_row = 0;
                foreach ($units_info as $id_unit => $nama_unit): 
                    $total = $data_per_unit[$id_unit]['total_pendapatan'];
                    $total_pendapatan_row += $total;
                ?>
                    <td class="amount"><?= number_format($total, 2, ',', '.') ?></td>
                <?php endforeach; ?>
                <td class="amount"><?= number_format($total_pendapatan_row, 2, ',', '.') ?></td>
            </tr>

            <tr>
                <td colspan="<?= count($units_info) + 2 ?>">&nbsp;</td>
            </tr>

            <!-- BEBAN POKOK PENJUALAN -->
            <tr class="section-header">
                <td class="description">BEBAN POKOK PENJUALAN</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount"></td>
                <?php endforeach; ?>
                <td class="amount"></td>
            </tr>

            <?php
            // Get all unique account numbers from all units for biaya
            $all_biaya_accounts = [];
            foreach ($data_per_unit as $id_unit => $data) {
                foreach ($data['biaya'] as $item) {
                    if (!isset($all_biaya_accounts[$item->no_akun])) {
                        $all_biaya_accounts[$item->no_akun] = [
                            'no_akun' => $item->no_akun,
                            'nama_akun' => $item->nama_akun,
                        ];
                    }
                }
            }
            ksort($all_biaya_accounts);
            ?>

            <?php foreach ($all_biaya_accounts as $account): ?>
                <tr class="sub-item">
                    <td class="description"><?= esc($account['nama_akun']) ?></td>
                    <?php 
                    $row_total = 0;
                    foreach ($units_info as $id_unit => $nama_unit): 
                        $saldo = 0;
                        foreach ($data_per_unit[$id_unit]['biaya'] as $item) {
                            if ($item->no_akun == $account['no_akun']) {
                                $saldo = $item->saldo;
                                break;
                            }
                        }
                        $row_total += $saldo;
                    ?>
                        <td class="amount"><?= number_format($saldo, 2, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="amount"><?= number_format($row_total, 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>

            <tr class="section-header">
                <td class="description">Jumlah Beban Pokok Penjualan</td>
                <?php 
                $total_biaya_row = 0;
                foreach ($units_info as $id_unit => $nama_unit): 
                    $total = $data_per_unit[$id_unit]['total_biaya'];
                    $total_biaya_row += $total;
                ?>
                    <td class="amount"><?= number_format($total, 2, ',', '.') ?></td>
                <?php endforeach; ?>
                <td class="amount"><?= number_format($total_biaya_row, 2, ',', '.') ?></td>
            </tr>

            <tr>
                <td colspan="<?= count($units_info) + 2 ?>">&nbsp;</td>
            </tr>

            <!-- LABA KOTOR -->
            <?php 
            $laba_kotor_per_unit = [];
            $total_laba_kotor_all = 0;
            foreach ($units_info as $id_unit => $nama_unit): 
                $laba_kotor = $data_per_unit[$id_unit]['total_pendapatan'] - $data_per_unit[$id_unit]['total_biaya'];
                $laba_kotor_per_unit[$id_unit] = $laba_kotor;
                $total_laba_kotor_all += $laba_kotor;
            endforeach;
            ?>
            <tr class="section-header">
                <td class="description">LABA KOTOR</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount <?= $laba_kotor_per_unit[$id_unit] < 0 ? 'negative' : '' ?>">
                        <?= number_format($laba_kotor_per_unit[$id_unit], 2, ',', '.') ?>
                    </td>
                <?php endforeach; ?>
                <td class="amount <?= $total_laba_kotor_all < 0 ? 'negative' : '' ?>">
                    <?= number_format($total_laba_kotor_all, 2, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td colspan="<?= count($units_info) + 2 ?>">&nbsp;</td>
            </tr>

            <!-- BEBAN OPERASIONAL -->
            <tr class="section-header">
                <td class="description">BEBAN OPERASIONAL</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount"></td>
                <?php endforeach; ?>
                <td class="amount"></td>
            </tr>

            <!-- Default beban operasional (bisa disesuaikan dengan data aktual) -->
            <tr class="sub-item">
                <td class="description">Beban Operasional</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Listrik</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Gaji dll</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Operasional Lainnya</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>

            <tr class="section-header">
                <td class="description">Jumlah Beban Operasional</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>

            <tr>
                <td colspan="<?= count($units_info) + 2 ?>">&nbsp;</td>
            </tr>

            <!-- PENDAPATAN OPERASIONAL -->
            <?php 
            $laba_operasional_per_unit = [];
            $total_laba_operasional_all = 0;
            foreach ($units_info as $id_unit => $nama_unit): 
                $laba_operasional = $laba_kotor_per_unit[$id_unit] - 0; // 0 adalah total beban operasional
                $laba_operasional_per_unit[$id_unit] = $laba_operasional;
                $total_laba_operasional_all += $laba_operasional;
            endforeach;
            ?>
            <tr class="section-header">
                <td class="description">PENDAPATAN OPERASIONAL</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount <?= $laba_operasional_per_unit[$id_unit] < 0 ? 'negative' : '' ?>">
                        <?= number_format($laba_operasional_per_unit[$id_unit], 2, ',', '.') ?>
                    </td>
                <?php endforeach; ?>
                <td class="amount <?= $total_laba_operasional_all < 0 ? 'negative' : '' ?>">
                    <?= number_format($total_laba_operasional_all, 2, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td colspan="<?= count($units_info) + 2 ?>">&nbsp;</td>
            </tr>

            <!-- PENDAPATAN DAN BEBAN NON OPERASIONAL -->
            <tr class="section-header">
                <td class="description">PENDAPATAN DAN BEBAN NON OPERASIONAL</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount"></td>
                <?php endforeach; ?>
                <td class="amount"></td>
            </tr>
            <tr class="sub-item">
                <td class="description">Pendapatan Non Operasional</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Non Operasional</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>
            <tr class="section-header">
                <td class="description">Jumlah Pendapatan dan Beban Non Operasional</td>
                <?php foreach ($units_info as $id_unit => $nama_unit): ?>
                    <td class="amount">0,00</td>
                <?php endforeach; ?>
                <td class="amount">0,00</td>
            </tr>

            <tr>
                <td colspan="<?= count($units_info) + 2 ?>">&nbsp;</td>
            </tr>

            <!-- LABA BERSIH -->
            <tr class="section-header total">
                <td class="description">LABA BERSIH</td>
                <?php 
                foreach ($units_info as $id_unit => $nama_unit): 
                    $laba_rugi = $data_per_unit[$id_unit]['laba_rugi'];
                ?>
                    <td class="amount <?= $laba_rugi < 0 ? 'negative' : '' ?>">
                        <?= number_format($laba_rugi, 2, ',', '.') ?>
                    </td>
                <?php endforeach; ?>
                <td class="amount <?= $total_laba_rugi_all < 0 ? 'negative' : '' ?>">
                    <?= number_format($total_laba_rugi_all, 2, ',', '.') ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">
            Cetak Laporan Ulang
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 14px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
