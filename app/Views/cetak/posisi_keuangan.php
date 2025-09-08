<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .saldo-zero {
            color: #aaa;
        }
    </style>
</head>

<body>
    <h3>Laporan Keuangan</h3>
    <p>Tanggal: <?= date('d-m-Y', strtotime($tanggal_awal)) ?> s/d <?= date('d-m-Y', strtotime($tanggal_akhir)) ?></p>

    <table>
        <thead>
            <tr>
                <th style="background-color: #aaa;">Kode Akun</th>
                <th style="background-color: #aaa;">Nama Akun</th>
                <th style="background-color: #aaa;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data_grand_parent)): ?>
                <!-- Grandparent -->
                <tr style="background-color: cadetblue">
                    <td><?= esc($data_grand_parent->no_akun) ?></td>
                    <td><?= esc($data_grand_parent->nama_akun) ?></td>
                    <td><?= number_format(abs($data_grand_parent->total_debet - $data_grand_parent->total_kredit), 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>

            <?php foreach ($data_parent as $row): ?>
                <tr style="background-color: antiquewhite">
                    <td><?= esc($row['parent_no_akun']) ?></td>
                    <td><?= esc($row['parent_nama_akun']) ?></td>
                    <td><?= number_format(abs($row['total_debet'] - $row['total_kredit']), 0, ',', '.') ?></td>
                </tr>
                <?php foreach ($row['children'] as $child): ?>
                    <tr>
                        <td><?= esc($child->no_akun) ?></td>
                        <td>↳ <?= esc($child->nama_akun) ?></td>
                        <td><?= number_format(abs($child->total_debet - $child->total_kredit), 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>