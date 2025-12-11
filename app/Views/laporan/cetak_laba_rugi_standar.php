<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
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
        <div class="report-title">Laba/Rugi (Standar)</div>
        <div class="period">
            Dari <?= $tanggal_awal ? date('d M Y', strtotime($tanggal_awal)) : '01 ' . date('M Y') ?>
            s/d <?= $tanggal_akhir ? date('d M Y', strtotime($tanggal_akhir)) : date('d M Y') ?>
        </div>
        <div>Cabang : <?= $nama_unit ?>, Mata Uang : Indonesian Rupiah</div>
    </div>

    <table>
        <!-- PENDAPATAN OPERASIONAL -->
        <tr class="section-header">
            <td class="description">PENDAPATAN</td>
            <td class="amount"></td>
        </tr>
        <tr class="section-header">
            <td class="description">Pendapatan Operasional</td>
            <td class="amount"><?= number_format($data_laba_rugi['total_pendapatan'], 2, ',', '.') ?></td>
        </tr>

        <?php foreach ($data_laba_rugi['pendapatan'] as $pendapatan): ?>
            <tr class="sub-item">
                <td class="description"><?= $pendapatan->nama_akun ?></td>
                <td class="amount <?= $pendapatan->saldo < 0 ? 'negative' : '' ?>">
                    <?= number_format($pendapatan->saldo, 2, ',', '.') ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr class="section-header">
            <td class="description">Jumlah Pendapatan</td>
            <td class="amount"><?= number_format($data_laba_rugi['total_pendapatan'], 2, ',', '.') ?></td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <!-- BEBAN POKOK PENJUALAN -->
        <tr class="section-header">
            <td class="description">BEBAN POKOK PENJUALAN</td>
            <td class="amount"></td>
        </tr>

        <?php foreach ($data_laba_rugi['beban_pokok_penjualan'] as $biaya): ?>
            <tr class="sub-item">
                <td class="description"><?= $biaya->nama_akun ?></td>
                <td class="amount"><?= number_format($biaya->saldo, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>

        <tr class="section-header">
            <td class="description">Jumlah Beban Pokok Penjualan</td>
            <td class="amount"><?= number_format($data_laba_rugi['total_beban_pokok_penjualan'], 2, ',', '.') ?></td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <!-- LABA KOTOR -->
        <?php $laba_kotor = $data_laba_rugi['total_pendapatan'] - $data_laba_rugi['total_biaya']; ?>
        <tr class="section-header">
            <td class="description">LABA KOTOR</td>
            <td class="amount <?= $laba_kotor < 0 ? 'negative' : '' ?>">
                <?= number_format($laba_kotor, 2, ',', '.') ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <!-- BEBAN OPERASIONAL -->
        <tr class="section-header">
            <td class="description">BEBAN OPERASIONAL</td>
            <td class="amount"></td>
        </tr>

        <?php foreach ($data_laba_rugi['beban_operasional'] as $biaya): ?>
            <tr class="sub-item">
                <td class="description"><?= $biaya->nama_akun ?></td>
                <td class="amount"><?= number_format($biaya->saldo, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="section-header">
            <td class="description">Jumlah Beban Operasional</td>
            <td class="amount"><?= number_format($data_laba_rugi['total_beban_operasional'], 2, ',', '.') ?></td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <!-- LABA OPERASIONAL -->
        <?php $laba_operasional = $laba_kotor - $data_laba_rugi['total_beban_operasional']; ?>
        <tr class="section-header">
            <td class="description">LABA OPERASIONAL</td>
            <td class="amount <?= $laba_operasional < 0 ? 'negative' : '' ?>">
                <?= number_format($laba_operasional, 2, ',', '.') ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <!-- PENDAPATAN DAN BEBAN NON OPERASIONAL -->
        <tr class="section-header">
            <td class="description">PENDAPATAN DAN BEBAN NON OPERASIONAL</td>
            <td class="amount"></td>
        </tr>
        
        <!-- Pendapatan Non Operasional -->
        <?php if (!empty($data_laba_rugi['pendapatan_non_operasional'])): ?>
            <?php foreach ($data_laba_rugi['pendapatan_non_operasional'] as $pendapatan_non): ?>
                <tr class="sub-item">
                    <td class="description"><?= $pendapatan_non->nama_akun ?></td>
                    <td class="amount <?= $pendapatan_non->saldo < 0 ? 'negative' : '' ?>">
                        <?= number_format($pendapatan_non->saldo, 2, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="section-header">
                <td class="description">Jumlah Pendapatan Non Operasional</td>
                <td class="amount"><?= number_format($data_laba_rugi['total_pendapatan_non_operasional'], 2, ',', '.') ?></td>
            </tr>
        <?php else: ?>
            <tr class="sub-item">
                <td class="description">Pendapatan Non Operasional</td>
                <td class="amount">0,00</td>
            </tr>
        <?php endif; ?>
        
        <!-- Beban Non Operasional -->
        <?php if (!empty($data_laba_rugi['beban_non_operasional'])): ?>
            <?php foreach ($data_laba_rugi['beban_non_operasional'] as $beban_non): ?>
                <tr class="sub-item">
                    <td class="description"><?= $beban_non->nama_akun ?></td>
                    <td class="amount"><?= number_format($beban_non->saldo, 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="section-header">
                <td class="description">Jumlah Beban Non Operasional</td>
                <td class="amount"><?= number_format($data_laba_rugi['total_beban_non_operasional'], 2, ',', '.') ?></td>
            </tr>
        <?php else: ?>
            <tr class="sub-item">
                <td class="description">Beban Non Operasional</td>
                <td class="amount">0,00</td>
            </tr>
        <?php endif; ?>
        
        <tr class="section-header">
            <td class="description">Jumlah Pendapatan dan Beban Non Operasional</td>
            <td class="amount">
                <?= number_format($data_laba_rugi['total_pendapatan_non_operasional'] - $data_laba_rugi['total_beban_non_operasional'], 2, ',', '.') ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>

        <!-- LABA BERSIH -->
        <tr class="section-header total">
            <td class="description">LABA BERSIH</td>
            <td class="amount <?= $data_laba_rugi['laba_rugi'] < 0 ? 'negative' : '' ?>">
                <?= number_format($data_laba_rugi['laba_rugi'], 2, ',', '.') ?>
            </td>
        </tr>
    </table>

    <div class="footer">
        <div>ACCURATE Accounting System Report</div>
        <div>Tercetak pada <?= date('d M Y - H:i') ?></div>
        <div>Halaman 1 dari 1</div>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">
            Cetak Laporan Ulang
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 14px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <!-- Debug informasi (akan disembunyikan saat print) -->
    <div class="no-print" style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border: 1px solid #dee2e6;">
        <h4>Informasi Data:</h4>
        <p><strong>Total Pendapatan:</strong> <?= number_format($data_laba_rugi['total_pendapatan'], 2, ',', '.') ?></p>
        <p><strong>Total Biaya:</strong> <?= number_format($data_laba_rugi['total_biaya'], 2, ',', '.') ?></p>
        <p><strong>Laba/Rugi:</strong> <?= number_format($data_laba_rugi['laba_rugi'], 2, ',', '.') ?></p>
    </div>
</body>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>