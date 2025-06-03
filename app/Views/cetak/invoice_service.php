<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Service</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        color: #333;
    }

    .center {
        text-align: center;
        margin-top: 30px;
    }

    .section {
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }

    .section h2 {
        margin-top: 0;
        font-size: 18px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 5px;
    }

    .sparepart,
    .kerusakan {
        margin-bottom: 10px;
    }

    .label {
        font-weight: bold;
    }
    </style>
</head>

<body>

    <?php if (isset($qrImageUrl)): ?>
    <div class="center">
        <img src="<?= $qrImageUrl ?>" width="150" alt="QR Code">
        <p style="font-size: 12px;">Scan untuk melihat detail service</p>
    </div>
    <?php endif; ?>

    <div class="section">
        <h2>Info Pengguna</h2>
        <p><span class="label">Nama:</span> <?= @$human->nama_pelanggan ?></p>
        <p><span class="label">Teknisi:</span> <?= @$human->nama_service_by ?></p>
    </div>

    <div class="section">
        <h2>Detail Sparepart</h2>
        <?php foreach ($sparepart as $spr): ?>
        <div class="sparepart">
            <p><span class="label">Nama Sparepart:</span> <?= $spr->nama_barang ?></p>
            <p><span class="label">Harga:</span> Rp.<?= number_format($spr->harga_penjualan, 0, ',', '.') ?></p>
            <p><span class="label">Diskon:</span> Rp.<?= $spr->diskon_penjualan ?></p>
            <p><span class="label">Subtotal:</span> Rp.<?= number_format($spr->sub_total, 0, ',', '.') ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="section">
        <h2>Info Kerusakan</h2>
        <?php foreach ($kerusakan as $krs): ?>
        <div class="kerusakan">
            <p><span class="label">Fungsi:</span> <?= $krs->nama_fungsi ?></p>
            <p><span class="label">Keterangan:</span> <?= $krs->keterangan ?></p>
        </div>
        <?php endforeach; ?>
    </div>

</body>

</html>