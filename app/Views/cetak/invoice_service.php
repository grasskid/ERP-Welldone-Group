<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            font-size: 13px;
            color: #333;
        }

        h2 {
            font-size: 14px;
            margin: 20px 0 5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }

        p {
            margin: 2px 0;
        }

        .label {
            font-weight: bold;
        }

        .center {
            text-align: center;
            margin-bottom: 10px;
        }

        .spacer {
            margin-top: 10px;
        }
    </style>
</head>


<body>
    <center>
        <div class="center">
            <p style="font-size: large; font-weight: bold;"><?php echo @$dataunit->NAMA_UNIT ?></h2>
            <p><?php echo @$dataunit->JALAN_UNIT . ', ' . @$dataunit->KABUPATEN_UNIT ?><br>Telp: <?php echo @$dataunit->NOTELP ?></p>

    </center>
    </div>
    <h2></h2>

    <?php if (isset($qrImageUrl)): ?>
        <div class="center">
            <img src="<?= $qrImageUrl ?>" width="120" alt="QR Code">
            <p style="font-size: 11px;">Scan untuk melihat detail service</p>
        </div>
    <?php endif; ?>

    <h2>Info Pengguna</h2>
    <p><span class="label">Nama:</span> <?= @$human->nama_pelanggan ?></p>
    <p><span class="label">Teknisi:</span> <?= @$human->nama_service_by ?></p>

    <h2>Jenis Struk</h2>
    <p>
        <?php if (@$service->tanggal_claim_garansi != null): ?>
            Garansi Service
        <?php else: ?>
            Service Handphone
        <?php endif; ?>
    </p>

    <h2>Detail Sparepart</h2>
    <?php if (@$service->tanggal_claim_garansi != null): ?>
        <?php foreach ($sparepart as $spr): ?>
            <p><span class="label">Nama Sparepart:</span> <?= $spr->nama_barang ?></p>
            <p><span class="label">Harga:</span> Rp.<?= number_format($spr->harga_penjualan_garansi, 0, ',', '.') ?></p>
            <p><span class="label">Jumlah:</span> <?= $spr->jumlah_tambahan_garansi ?></p>
            <p><span class="label">Diskon:</span> Rp.<?= $spr->diskon_penjualan_garansi ?></p>
            <p><span class="label">Subtotal:</span> Rp.<?= number_format($spr->sub_total_garansi, 0, ',', '.') ?></p>
            <div class="spacer"></div>
        <?php endforeach; ?>
    <?php else: ?>
        <?php foreach ($sparepart as $spr): ?>
            <?php
            $diskon_non_garansi = $spr->diskon_penjualan - $spr->diskon_penjualan_garansi;
            $sub_total_non_garansi = $spr->sub_total - $spr->sub_total_garansi;
            $jumlah_non_garansi = $spr->jumlah - $spr->jumlah_tambahan_garansi;
            ?>
            <p><span class="label">Nama Sparepart:</span> <?= $spr->nama_barang ?></p>
            <p><span class="label">Harga:</span> Rp.<?= number_format($spr->harga_penjualan, 0, ',', '.') ?></p>
            <p><span class="label">Jumlah:</span> <?= $jumlah_non_garansi ?></p>
            <p><span class="label">Diskon:</span> Rp.<?= $diskon_non_garansi ?></p>
            <p><span class="label">Subtotal:</span> Rp.<?= number_format($sub_total_non_garansi, 0, ',', '.') ?></p>
            <div class="spacer"></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2>Info Kerusakan</h2>
    <?php foreach ($kerusakan as $krs): ?>
        <p><span class="label">Fungsi:</span> <?= $krs->nama_fungsi ?></p>
        <p><span class="label">Keterangan:</span> <?= $krs->keterangan ?></p>
        <div class="spacer"></div>
    <?php endforeach; ?>

</body>

</html>