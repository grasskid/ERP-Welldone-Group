<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Service</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Service</li>
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
                        <h6 class="fs-4 fw-semibold mb-0">Nama Pelanggan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nomor Handphone</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Alamat</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($service)): ?>
                <?php foreach ($service as $row): ?>
                <tr>
                    <td><?= esc($row->no_service) ?></td>
                    <td><?= esc($row->nama_pelanggan) ?></td>
                    <td><?= esc($row->no_hp) ?></td>
                    <td><?= esc($row->alamat) ?></td>
                    <td>
                        <?php if ($row->status_service == 9): ?>
                        <button type="button" class="btn btn-warning edit-button" disabled>
                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                        </button>
                        <?php else: ?>
                        <a href="<?php echo base_url('detail/riwayat_service/' . $row->idservice) ?>">
                            <button type="button" class="btn btn-warning edit-button">
                                <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24">
                                </iconify-icon>
                            </button>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>