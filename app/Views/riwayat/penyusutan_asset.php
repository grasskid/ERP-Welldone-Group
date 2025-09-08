<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Penyusutan Asset</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Penyusutan Asset</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
    </div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Asset</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Perolehan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nilai Perolehan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nilai Penyusutan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nilai Sekarang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Penyusutan</h6>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php if (!empty($penyusutan)): ?>
                    <?php foreach ($penyusutan as $row): ?>
                        <tr>
                            <td><?= esc($row->nama_asset) ?></td>
                            <td><?= esc(date('d-m-Y', strtotime($row->tanggal_perolehan))) ?></td>
                            <td><?= esc('Rp ' . number_format($row->nilai_perolehan, 0, ',', '.')) ?></td>
                            <td><?= esc('Rp ' . number_format($row->penyusutan, 0, ',', '.')) ?></td>
                            <td><?= esc('Rp ' . number_format($row->nilai_riwayat, 0, ',', '.')) ?></td>

                            <td><?= esc(date('d-m-Y', strtotime($row->tanggal_penyusutan))) ?></td>
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