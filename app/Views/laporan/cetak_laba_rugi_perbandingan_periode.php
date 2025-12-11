<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi - Perbandingan Periode</title>
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
            width: 50%;
        }

        .amount {
            width: 25%;
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
        <div class="report-title">Laporan Laba/Rugi (Perbandingan Periode)</div>
        <div class="period">
            Periode 1: <?= $tanggal_awal_1 ? date('d M Y', strtotime($tanggal_awal_1)) : '' ?>
            s/d <?= $tanggal_akhir_1 ? date('d M Y', strtotime($tanggal_akhir_1)) : '' ?>
        </div>
        <div class="period">
            Periode 2: <?= $tanggal_awal_2 ? date('d M Y', strtotime($tanggal_awal_2)) : '' ?>
            s/d <?= $tanggal_akhir_2 ? date('d M Y', strtotime($tanggal_akhir_2)) : '' ?>
        </div>
        <div class="period">Cabang : <?= $nama_unit ?>, Mata Uang : Indonesian Rupiah</div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="description">Keterangan</th>
                <th class="amount">Periode 1</th>
                <th class="amount">Periode 2</th>
                <th class="amount">Selisih</th>
            </tr>
        </thead>
        <tbody>
            <!-- PENDAPATAN OPERASIONAL -->
            <tr class="section-header">
                <td class="description">PENDAPATAN</td>
                <td class="amount"></td>
                <td class="amount"></td>
                <td class="amount"></td>
            </tr>
            <tr class="section-header">
                <td class="description">Pendapatan Operasional</td>
                <td class="amount"><?= number_format($data_periode_1['total_pendapatan'], 2, ',', '.') ?></td>
                <td class="amount"><?= number_format($data_periode_2['total_pendapatan'], 2, ',', '.') ?></td>
                <?php 
                $selisih_pendapatan = $data_periode_2['total_pendapatan'] - $data_periode_1['total_pendapatan'];
                ?>
                <td class="amount <?= $selisih_pendapatan < 0 ? 'negative' : '' ?>">
                    <?= number_format($selisih_pendapatan, 2, ',', '.') ?>
                </td>
            </tr>

            <?php
            // Get all unique account numbers from both periods
            $all_pendapatan_accounts = [];
            foreach ($data_periode_1['pendapatan'] as $item) {
                if (!isset($all_pendapatan_accounts[$item->no_akun])) {
                    $all_pendapatan_accounts[$item->no_akun] = [
                        'no_akun' => $item->no_akun,
                        'nama_akun' => $item->nama_akun,
                    ];
                }
            }
            foreach ($data_periode_2['pendapatan'] as $item) {
                if (!isset($all_pendapatan_accounts[$item->no_akun])) {
                    $all_pendapatan_accounts[$item->no_akun] = [
                        'no_akun' => $item->no_akun,
                        'nama_akun' => $item->nama_akun,
                    ];
                }
            }
            ksort($all_pendapatan_accounts);
            ?>

            <?php foreach ($all_pendapatan_accounts as $account): ?>
                <?php
                $saldo_1 = 0;
                foreach ($data_periode_1['pendapatan'] as $item) {
                    if ($item->no_akun == $account['no_akun']) {
                        $saldo_1 = $item->saldo;
                        break;
                    }
                }
                $saldo_2 = 0;
                foreach ($data_periode_2['pendapatan'] as $item) {
                    if ($item->no_akun == $account['no_akun']) {
                        $saldo_2 = $item->saldo;
                        break;
                    }
                }
                $selisih = $saldo_2 - $saldo_1;
                ?>
                <tr class="sub-item">
                    <td class="description"><?= esc($account['nama_akun']) ?></td>
                    <td class="amount <?= $saldo_1 < 0 ? 'negative' : '' ?>">
                        <?= number_format($saldo_1, 2, ',', '.') ?>
                    </td>
                    <td class="amount <?= $saldo_2 < 0 ? 'negative' : '' ?>">
                        <?= number_format($saldo_2, 2, ',', '.') ?>
                    </td>
                    <td class="amount <?= $selisih < 0 ? 'negative' : '' ?>">
                        <?= number_format($selisih, 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr class="section-header">
                <td class="description">Jumlah Pendapatan</td>
                <td class="amount"><?= number_format($data_periode_1['total_pendapatan'], 2, ',', '.') ?></td>
                <td class="amount"><?= number_format($data_periode_2['total_pendapatan'], 2, ',', '.') ?></td>
                <td class="amount <?= $selisih_pendapatan < 0 ? 'negative' : '' ?>">
                    <?= number_format($selisih_pendapatan, 2, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <!-- BEBAN POKOK PENJUALAN -->
            <tr class="section-header">
                <td class="description">BEBAN POKOK PENJUALAN</td>
                <td class="amount"></td>
                <td class="amount"></td>
                <td class="amount"></td>
            </tr>

            <?php
            // Get all unique account numbers from both periods for biaya
            $all_biaya_accounts = [];
            foreach ($data_periode_1['biaya'] as $item) {
                if (!isset($all_biaya_accounts[$item->no_akun])) {
                    $all_biaya_accounts[$item->no_akun] = [
                        'no_akun' => $item->no_akun,
                        'nama_akun' => $item->nama_akun,
                    ];
                }
            }
            foreach ($data_periode_2['biaya'] as $item) {
                if (!isset($all_biaya_accounts[$item->no_akun])) {
                    $all_biaya_accounts[$item->no_akun] = [
                        'no_akun' => $item->no_akun,
                        'nama_akun' => $item->nama_akun,
                    ];
                }
            }
            ksort($all_biaya_accounts);
            ?>

            <?php foreach ($all_biaya_accounts as $account): ?>
                <?php
                $saldo_1 = 0;
                foreach ($data_periode_1['biaya'] as $item) {
                    if ($item->no_akun == $account['no_akun']) {
                        $saldo_1 = $item->saldo;
                        break;
                    }
                }
                $saldo_2 = 0;
                foreach ($data_periode_2['biaya'] as $item) {
                    if ($item->no_akun == $account['no_akun']) {
                        $saldo_2 = $item->saldo;
                        break;
                    }
                }
                $selisih = $saldo_2 - $saldo_1;
                ?>
                <tr class="sub-item">
                    <td class="description"><?= esc($account['nama_akun']) ?></td>
                    <td class="amount"><?= number_format($saldo_1, 2, ',', '.') ?></td>
                    <td class="amount"><?= number_format($saldo_2, 2, ',', '.') ?></td>
                    <td class="amount <?= $selisih < 0 ? 'negative' : '' ?>">
                        <?= number_format($selisih, 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            <tr class="section-header">
                <td class="description">Jumlah Beban Pokok Penjualan</td>
                <td class="amount"><?= number_format($data_periode_1['total_biaya'], 2, ',', '.') ?></td>
                <td class="amount"><?= number_format($data_periode_2['total_biaya'], 2, ',', '.') ?></td>
                <?php 
                $selisih_biaya = $data_periode_2['total_biaya'] - $data_periode_1['total_biaya'];
                ?>
                <td class="amount <?= $selisih_biaya < 0 ? 'negative' : '' ?>">
                    <?= number_format($selisih_biaya, 2, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <!-- LABA KOTOR -->
            <?php 
            $laba_kotor_1 = $data_periode_1['total_pendapatan'] - $data_periode_1['total_biaya'];
            $laba_kotor_2 = $data_periode_2['total_pendapatan'] - $data_periode_2['total_biaya'];
            $selisih_laba_kotor = $laba_kotor_2 - $laba_kotor_1;
            ?>
            <tr class="section-header">
                <td class="description">LABA KOTOR</td>
                <td class="amount <?= $laba_kotor_1 < 0 ? 'negative' : '' ?>">
                    <?= number_format($laba_kotor_1, 2, ',', '.') ?>
                </td>
                <td class="amount <?= $laba_kotor_2 < 0 ? 'negative' : '' ?>">
                    <?= number_format($laba_kotor_2, 2, ',', '.') ?>
                </td>
                <td class="amount <?= $selisih_laba_kotor < 0 ? 'negative' : '' ?>">
                    <?= number_format($selisih_laba_kotor, 2, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <!-- BEBAN OPERASIONAL -->
            <tr class="section-header">
                <td class="description">BEBAN OPERASIONAL</td>
                <td class="amount"></td>
                <td class="amount"></td>
                <td class="amount"></td>
            </tr>

            <!-- Default beban operasional (bisa disesuaikan dengan data aktual) -->
            <tr class="sub-item">
                <td class="description">Beban Operasional</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Listrik</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Gaji dll</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Operasional Lainnya</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>

            <tr class="section-header">
                <td class="description">Jumlah Beban Operasional</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <!-- PENDAPATAN OPERASIONAL -->
            <?php 
            $laba_operasional_1 = $laba_kotor_1 - 0; // 0 adalah total beban operasional
            $laba_operasional_2 = $laba_kotor_2 - 0;
            $selisih_laba_operasional = $laba_operasional_2 - $laba_operasional_1;
            ?>
            <tr class="section-header">
                <td class="description">PENDAPATAN OPERASIONAL</td>
                <td class="amount <?= $laba_operasional_1 < 0 ? 'negative' : '' ?>">
                    <?= number_format($laba_operasional_1, 2, ',', '.') ?>
                </td>
                <td class="amount <?= $laba_operasional_2 < 0 ? 'negative' : '' ?>">
                    <?= number_format($laba_operasional_2, 2, ',', '.') ?>
                </td>
                <td class="amount <?= $selisih_laba_operasional < 0 ? 'negative' : '' ?>">
                    <?= number_format($selisih_laba_operasional, 2, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <!-- PENDAPATAN DAN BEBAN NON OPERASIONAL -->
            <tr class="section-header">
                <td class="description">PENDAPATAN DAN BEBAN NON OPERASIONAL</td>
                <td class="amount"></td>
                <td class="amount"></td>
                <td class="amount"></td>
            </tr>
            <tr class="sub-item">
                <td class="description">Pendapatan Non Operasional</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>
            <tr class="sub-item">
                <td class="description">Beban Non Operasional</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>
            <tr class="section-header">
                <td class="description">Jumlah Pendapatan dan Beban Non Operasional</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
                <td class="amount">0,00</td>
            </tr>

            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>

            <!-- LABA BERSIH -->
            <?php 
            $selisih_laba_bersih = $data_periode_2['laba_rugi'] - $data_periode_1['laba_rugi'];
            ?>
            <tr class="section-header total">
                <td class="description">LABA BERSIH</td>
                <td class="amount <?= $data_periode_1['laba_rugi'] < 0 ? 'negative' : '' ?>">
                    <?= number_format($data_periode_1['laba_rugi'], 2, ',', '.') ?>
                </td>
                <td class="amount <?= $data_periode_2['laba_rugi'] < 0 ? 'negative' : '' ?>">
                    <?= number_format($data_periode_2['laba_rugi'], 2, ',', '.') ?>
                </td>
                <td class="amount <?= $selisih_laba_bersih < 0 ? 'negative' : '' ?>">
                    <?= number_format($selisih_laba_bersih, 2, ',', '.') ?>
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
