<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        font-family: monospace, Arial, sans-serif;
        font-size: 11px;
        margin: 0;
        color: #000;
    }

    .invoice {
        width: 280px;
        /* 58mm paper */
        margin: auto;
        padding: 5px;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 8px;
    }

    .invoice-header h2 {
        margin: 0;
        font-size: 14px;
    }

    .invoice-header p {
        margin: 0;
        font-size: 10px;
    }

    .invoice-info,
    .invoice-total {
        width: 100%;
        margin-bottom: 6px;
        font-size: 11px;
    }

    .invoice-info td {
        padding: 2px 0;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
        font-size: 11px;
    }

    .items-table th,
    .items-table td {
        padding: 2px 0;
        text-align: left;
    }

    .items-table th {
        border-bottom: 1px dashed #000;
        font-weight: bold;
    }

    .items-table td {
        border-bottom: 1px dashed #ccc;
    }

    .invoice-total td {
        padding: 2px 0;
    }

    .text-end {
        text-align: right;
    }

    .thank-you {
        text-align: center;
        font-style: italic;
        font-size: 11px;
        margin-top: 6px;
    }

    .imei {
        font-size: 10px;
        font-style: italic;
        color: #444;
    }

    @media print {
        body {
            margin: 0;
        }

        .invoice {
            width: 100%;
            border: none;
        }
    }
    </style>
</head>

<body>

    <div class="invoice">
        <div class="invoice-header">
            <h2><?= @$dataunit->NAMA_UNIT ?></h2>
            <p>
                <?= @$dataunit->JALAN_UNIT . ', ' . @$dataunit->KABUPATEN_UNIT ?><br>
                Telp: <?= @$dataunit->NOTELP ?>
            </p>
        </div>

        <table class="invoice-info">
            <tr>
                <td>No. Invoice</td>
                <td>: <?= @$no_invoice ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= isset($tanggal) ? date('d-m-Y H:i:s', strtotime($tanggal)) : '-' ?></td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>: <?= @$kasir ?></td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>: <?= @$customer ?></td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th class="text-end">Jml</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Sub</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_diskon_semua = 0;
                $total_ppn_semua    = 0;

                if (!empty($produk)) :
                    foreach ($produk as $p) :
                        $harga  = isset($p['harga']) ? (int)str_replace(['Rp', '.', ' '], '', $p['harga']) : 0;
                        $jumlah = (int)($p['jumlah'] ?? 0);
                        $diskon = isset($p['diskon']) ? (int)str_replace(['Rp', '.', ' '], '', $p['diskon']) : 0;
                        $subtotal = $harga * $jumlah;
                        $subtotalSetelahDiskon = $subtotal - $diskon;
                        $ppn = (!empty($p['ppn'])) ? round($subtotalSetelahDiskon * 0.11) : 0;
                        $totalItem = $subtotalSetelahDiskon + $ppn;

                        $total_diskon_semua += $diskon;
                        $total_ppn_semua    += $ppn;
                ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($p['nama'] ?? '') ?>
                        <?php if (!empty($p['imei'])): ?>
                        <div class="imei">IMEI: <?= htmlspecialchars($p['imei']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="text-end"><?= $jumlah ?></td>
                    <td class="text-end"><?= number_format($harga, 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
                <?php if ($diskon > 0): ?>
                <tr>
                    <td colspan="3"><em>Diskon</em></td>
                    <td class="text-end">-<?= number_format($diskon, 0, ',', '.') ?></td>
                </tr>
                <?php endif ?>
                <?php if ($ppn > 0): ?>
                <tr>
                    <td colspan="3"><em>PPN 11%</em></td>
                    <td class="text-end"><?= number_format($ppn, 0, ',', '.') ?></td>
                </tr>
                <?php endif ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td class="text-end"><strong><?= number_format($totalItem, 0, ',', '.') ?></strong></td>
                </tr>
                <?php 
                    endforeach;
                else:
                ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada produk</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <table class="invoice-total">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-end"><?= number_format(@$sub_total, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td><strong>Total Diskon</strong></td>
                <td class="text-end">-<?= number_format($total_diskon_semua, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td><strong>Total PPN</strong></td>
                <td class="text-end">
                    <?= number_format((!empty($total_ppn) ? $total_ppn : $total_ppn_semua), 0, ',', '.') ?>
                </td>
            </tr>

            <tr>
                <td><strong>Total</strong></td>
                <td class="text-end"><strong><?= number_format(@$total, 0, ',', '.') ?></strong></td>
            </tr>
            <tr>
                <td><strong>Bayar</strong></td>
                <td class="text-end"><?= number_format(@$bayar, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td><strong>Kembalian</strong></td>
                <td class="text-end"><?= number_format(@$kembalian, 0, ',', '.') ?></td>
            </tr>
        </table>

        <div class="thank-you">
            *** Terima kasih atas pembelian Anda! ***
        </div>
    </div>

</body>

</html>