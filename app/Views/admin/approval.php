<!-- Breadcrumb -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Approval</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Admin</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Approval</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Card -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
    </div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>IMEI</th>
                    <th>Jenis HP</th>
                    <th>Harga</th>

                    <th>Internal</th>
                    <th>Warna</th>
                    <th>Status</th>
                    <th>Input</th>

                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($phone)): ?>
                    <?php foreach ($phone as $row): ?>
                        <tr>
                            <td><?= esc($row->imei) ?></td>
                            <td><?= esc($row->jenis_hp) ?></td>
                            <td><?= 'Rp ' . number_format($row->harga, 0, ',', '.') ?></td>

                            <td><?= esc($row->internal) ?></td>
                            <td><?= esc($row->warna) ?></td>
                            <td>
                                <?php
                                if ($row->status == 0) {
                                    echo 'Menunggu';
                                } elseif ($row->status == 1) {
                                    echo 'Disetujui';
                                } else {
                                    echo 'Unknown Status';
                                }
                                ?>
                            </td>
                            <td><?= esc($row->input) ?></td>

                            <td class="text-center">
                                <?php if ($row->status == 0): ?>
                                    <a href="<?= base_url('approve/phone/' . esc($row->idbarang)) ?>">
                                        <button type="button" class="btn btn-success mb-1">Terima</button>
                                    </a>
                                    <a href="<?= base_url('decline/phone/' . esc($row->idbarang)) ?>">
                                        <button type="button" class="btn btn-warning">Tolak</button>
                                    </a>
                                <?php elseif ($row->status == 1): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Unknown</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>