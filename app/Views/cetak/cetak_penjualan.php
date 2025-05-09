<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 20px;
        color: #000;
    }

    .invoice {
        max-width: 400px;
        margin: auto;
        padding: 15px;
        border: 1px solid #ccc;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 15px;
    }

    .invoice-header h2 {
        margin: 0;
        font-size: 20px;
    }

    .invoice-header p {
        margin: 0;
        font-size: 12px;
    }

    .invoice-info,
    .invoice-total {
        width: 100%;
        margin-bottom: 15px;
    }

    .invoice-info td {
        padding: 4px 0;
    }

    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .items-table th,
    .items-table td {
        border-bottom: 1px dashed #ccc;
        padding: 5px 0;
        text-align: left;
    }

    .items-table th {
        font-weight: bold;
    }

    .invoice-total td {
        padding: 4px 0;
    }

    .text-end {
        text-align: right;
    }

    .thank-you {
        text-align: center;
        font-style: italic;
        font-size: 13px;
        margin-top: 10px;
    }

    @media print {
        body {
            margin: 0;
        }

        .invoice {
            border: none;
        }
    }
    </style>
</head>

<body>

    <div class="invoice">
        <div class="invoice-header">
            <h2>Urban Store</h2>
            <p>Jl. Jalan No.123, Jember<br>Telp: (021) 12345678</p>
        </div>

        <table class="invoice-info">
            <tr>
                <td>No. Invoice:</td>
                <td><?= @$no_invoice ?></td>
            </tr>
            <tr>
                <td>Tanggal:</td>
                <td><?= @$tanggal ?></td>
            </tr>
            <tr>
                <td>Kasir:</td>
                <td><?= @$kasir ?></td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th class="text-end">Jumlah</th>
                    <th class="text-end">Harga</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p) : ?>
                <tr>
                    <td><?= $p['nama'] ?></td>
                    <td class="text-end"><?= $p['jumlah'] ?></td>
                    <td class="text-end"><?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($p['harga'] * $p['jumlah'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <table class="invoice-total">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-end"><?= number_format(@$sub_total, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td><strong>Diskon</strong></td>
                <td class="text-end"><?= number_format(@$diskon, 0, ',', '.') ?></td>
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
            Terima kasih atas pembelian Anda!
        </div>
    </div>

</body>

</html>