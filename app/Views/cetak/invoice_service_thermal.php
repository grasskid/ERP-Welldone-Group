<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Service - Thermal</title>
    <style>
    body {
        font-family: monospace, Arial, sans-serif;
        font-size: 11px;
        margin: 0;
        padding: 5px;
        color: #000;
        width: 240px;
        /* ~80mm paper */
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 4px 0;
    }

    .section-title {
        font-weight: bold;
        margin-top: 6px;
        margin-bottom: 2px;
        text-decoration: underline;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4px;
    }

    td {
        padding: 1px 0;
        vertical-align: top;
    }

    .right {
        text-align: right;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="center">
        <div class="bold"><?= @$dataunit->NAMA_UNIT ?></div>
        <div>
            <?= @$dataunit->JALAN_UNIT . ', ' . @$dataunit->KABUPATEN_UNIT ?><br>
            Telp: <?= @$dataunit->NOTELP ?>
        </div>
    </div>
    <div class="line"></div>

    <!-- Info Pengguna -->
    <div class="section-title">Info Pengguna</div>
    <div>Nama : <?= @$human->nama_pelanggan ?></div>
    <div>Teknisi : <?= @$human->nama_service_by ?></div>

    <!-- Jenis Struk -->
    <!-- <div class="section-title">Jenis Struk</div> -->
    <div>
        <?php if (@$service->tanggal_claim_garansi != null): ?>
        Garansi Service
        <?php else: ?>
        Service Handphone
        <?php endif; ?>
    </div>

    <!-- Detail Sparepart -->
    <div class="section-title">Detail Sparepart</div>
    <table>
        <tbody>
            <?php if (@$service->tanggal_claim_garansi != null): ?>
            <?php foreach ($sparepart as $spr): ?>

            <tr>
                <td colspan="2"><?= $spr->nama_barang ?>x<?= $spr->jumlah_tambahan_garansi ?></td>
                <td class="right">Rp.<?= number_format($spr->harga_penjualan_garansi, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="2">Diskon</td>
                <td class="right">Rp.<?= $spr->diskon_penjualan_garansi ?></td>
            </tr>
            <tr>
                <td colspan="2">Subtotal</td>
                <td class="right">Rp.<?= number_format($spr->sub_total_garansi, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="line"></div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <?php foreach ($sparepart as $spr): ?>
            <?php
                        $diskon_non_garansi   = $spr->diskon_penjualan - $spr->diskon_penjualan_garansi;
                        $sub_total_non_garansi = $spr->sub_total - $spr->sub_total_garansi;
                        $jumlah_non_garansi   = $spr->jumlah - $spr->jumlah_tambahan_garansi;
                    ?>
            <tr>
                <td colspan="2"><?= $spr->nama_barang ?></td>
            </tr>
            <tr>
                <td>Harga x <?= $jumlah_non_garansi ?></td>
                <td class="right">Rp.<?= number_format($spr->harga_penjualan, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td class="right">Rp.<?= $diskon_non_garansi ?></td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td class="right">Rp.<?= number_format($sub_total_non_garansi, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="line"></div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Info Kerusakan -->
    <div class="section-title">Info Kerusakan</div>
    <?php foreach ($kerusakan as $krs): ?>
    <div>Fungsi : <?= $krs->nama_fungsi ?></div>
    <div>Keterangan : <?= $krs->keterangan ?></div>
    <div class="line"></div>
    <?php endforeach; ?>
    <br>
    <br>
    <br>
    <br>
    <!-- QR Code -->
    <?php if (isset($qrImageUrl)): ?>
    <div class="center">
        <img src="<?= $qrImageUrl ?>" width="100" alt="QR Code">
        <div style="font-size: 10px;">Scan untuk detail service</div>
    </div>
    <?php endif; ?>

    <div class="line"></div>
</body>

</html>