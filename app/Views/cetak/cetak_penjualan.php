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
                <td>#INV-001</td>
            </tr>
            <tr>
                <td>Tanggal:</td>
                <td>04-05-2025</td>
            </tr>
            <tr>
                <td>Kasir:</td>
                <td>Mawar</td>
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
                <tr>
                    <td>Produk A</td>
                    <td class="text-end">2</td>
                    <td class="text-end">10.000</td>
                    <td class="text-end">20.000</td>
                </tr>
                <tr>
                    <td>Produk B</td>
                    <td class="text-end">1</td>
                    <td class="text-end">15.000</td>
                    <td class="text-end">15.000</td>
                </tr>
            </tbody>
        </table>

        <table class="invoice-total">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-end">35.000</td>
            </tr>
            <tr>
                <td><strong>Diskon</strong></td>
                <td class="text-end">5.000</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td class="text-end"><strong>33.000</strong></td>
            </tr>
            <tr>
                <td><strong>Bayar</strong></td>
                <td class="text-end">50.000</td>
            </tr>
            <tr>
                <td><strong>Kembalian</strong></td>
                <td class="text-end">17.000</td>
            </tr>
        </table>

        <div class="thank-you">
            Terima kasih atas pembelian Anda!
        </div>
    </div>

    data :

    <?php foreach ($produk as $produk) : ?>
        <?= $produk['nama'] ?>
        <?= $produk['jumlah'] ?>
        <?= $produk['harga'] ?>
        <?= ($produk['harga'] * $produk['jumlah']) ?>
    <?php endforeach ?>

    <?php echo @$tanggal ?>
    <?php echo @$kasir ?>
    <?php echo @$no_invoice ?>
    <?php echo @$sub_total ?>
    <?php echo @$diskon ?>
    <?php echo @$total ?>
    <?php echo @$bayar ?>
    <?php echo @$kembalian ?>


</body>

</html>