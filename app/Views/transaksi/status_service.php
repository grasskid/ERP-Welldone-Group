<?php setlocale(LC_TIME, 'id_ID.UTF-8'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lacak Servis iPhone</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background: #f9f9f9;
    }

    .container {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        max-width: 500px;
        margin: auto;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-top: 0;
    }

    .info,
    .status {
        margin-bottom: 20px;
    }

    .label {
        font-weight: bold;
        color: #666;
    }

    .value {
        margin-bottom: 10px;
    }

    .step {
        border-left: 4px solid #ccc;
        padding-left: 10px;
        margin-bottom: 15px;
        position: relative;
    }

    .step::before {
        content: "";
        position: absolute;
        left: -10px;
        top: 4px;
        width: 12px;
        height: 12px;
        background: #ccc;
        border-radius: 50%;
    }

    .step.active::before {
        background: #4CAF50;
    }

    .step.active {
        border-color: #4CAF50;
    }

    .step time {
        font-size: 0.9em;
        color: #888;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Lacak Servis iPhone</h2>
        <div class="info">
            <div class="label">Nomor Servis</div>
            <div class="value"><?= $service->no_service ?><?= $service->status_service ?></div>
            <div class="label">Nama Pelanggan</div>
            <div class="value"><?= $service->nama ?></div>
            <div class="label">Jenis Servis</div>
            <div class="value"><?= $service->keluhan ?></div>
            <div class="label">Tanggal Service</div>
            <div class="value"><?= $service->created_at ?></div>
        </div>
        <div class="status">
            <div class="label">Status</div>

            <div class="step <?= ($service->status_service >= 1) ? 'active' : '' ?>">
                <div><strong><?= strftime('%A, %d %B %Y', strtotime($service->created_at)) ?></strong></div>
                <div>Permintaan servis diterima</div>
            </div>

            <div class="step <?= ($service->status_service >= 2) ? 'active' : '' ?>">
                <div><strong><?= ($service->status_service >= 2) ? '...' : '-' ?></strong></div>
                <div>Dalam proses perbaikan</div>
            </div>

            <div class="step <?= ($service->status_service >= 3) ? 'active' : '' ?>">
                <div><strong><?= ($service->status_service >= 3) ? '...' : '-' ?></strong></div>
                <div>Pengambilan</div>
            </div>

            <div class="step <?= ($service->status_service >= 4) ? 'active' : '' ?>">
                <div><strong><?= ($service->status_service >= 4) ? '...' : '-' ?></strong></div>
                <div>Selesai - Siap diambil</div>
            </div>
        </div>

    </div>
</body>

</html>