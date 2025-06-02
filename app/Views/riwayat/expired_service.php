<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Expired Service</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Expired Service</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
    </div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2">
        </div>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">No Service</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Service</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Pelanggan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nomor Handphone</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Alamat</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($service)): ?>
                <?php
                    $found = false;
                    foreach ($service as $row):
                        $updatedAt = new DateTime($row->updated_at);
                        $threeMonthsAgo = (new DateTime())->modify('-3 months');
                        if ($updatedAt <= $threeMonthsAgo):
                            $found = true;
                    ?>
                <tr>
                    <td><?= esc($row->no_service) ?></td>
                    <td><?= esc($row->created_at) ?></td>
                    <td><?= esc($row->nama_pelanggan) ?></td>
                    <td><?= esc($row->no_hp) ?></td>
                    <td><?= esc($row->alamat) ?></td>
                </tr>
                <?php endif; endforeach; ?>
                <?php if (!$found): ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data yang lebih dari 3 bulan.</td>
                </tr>
                <?php endif; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>