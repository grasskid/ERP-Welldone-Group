<!DOCTYPE html>
<html>

<head>
    <title>Laporan Posisi Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-danger {
            color: red;
        }

        .fw-semibold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">Laporan Posisi Keuangan</h2>

    <?php if (!empty($tanggal_awal) && !empty($tanggal_akhir)): ?>
        <p><strong>Periode:</strong> <?= date('d-m-Y', strtotime($tanggal_awal)) ?> s/d <?= date('d-m-Y', strtotime($tanggal_akhir)) ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Kode Parent</th>
                <th>Nama Akun Parent</th>
                <th class="text-end">Debit - Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_parent)): ?>
                <?php foreach ($data_parent as $row):
                    $saldo = $row['total_debet'] - $row['total_kredit'];
                    $saldoDisplay = number_format(abs($saldo), 0, ',', '.');
                    $saldoClass = $saldo < 0 ? 'text-danger' : '';
                ?>
                    <tr>
                        <td><?= esc($row['parent_no_akun']) ?></td>
                        <td><?= esc($row['parent_nama_akun']) ?></td>
                        <td class="text-end fw-semibold <?= $saldoClass ?>"><?= $saldoDisplay ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data keuangan.</td>
                </tr>
            <?php endif; ?>
        </tbody>

        <?php if (!empty($data_grand_parent)):
            $grandSaldo = $data_grand_parent->total_debet - $data_grand_parent->total_kredit;
            $grandSaldoDisplay = number_format(abs($grandSaldo), 0, ',', '.');
            $grandSaldoClass = $grandSaldo < 0 ? 'text-danger' : '';
        ?>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end"><strong>Total Grandparent (<?= esc($data_grand_parent->nama_akun) ?>)</strong></td>
                    <td class="text-end fw-semibold <?= $grandSaldoClass ?>"><?= $grandSaldoDisplay ?></td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>

</body>

</html>