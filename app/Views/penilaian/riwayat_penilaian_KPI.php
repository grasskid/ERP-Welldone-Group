<!-- Header Card -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Penilaian KPI</h4>
    </div>
</div>

<!-- Filter + Export -->
<div class="card w-100 position-relative overflow-hidden mb-4">
    <div class="card-body px-4 pt-4 pb-2 mb-1">
        <form action="<?= base_url('export_riwayat_garding') ?>" method="post">
            <button type="submit" class="btn btn-danger mb-3">
                <iconify-icon icon="solar:export-broken" width="24" height="24"></iconify-icon>
                Export
            </button>

            <div class="mb-3">
                <label class="me-2">Tanggal Awal:</label>
                <input type="date" id="startDate" class="form-control d-inline"
                    style="width:auto; display:inline-block;" onchange="filterData()">

                <label class="ms-3 me-2">Tanggal Akhir:</label>
                <input type="date" id="endDate" class="form-control d-inline" style="width:auto; display:inline-block;"
                    onchange="filterData()">

                <button type="button" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
            </div>
        </form>
    </div>


    <!-- Table -->
    <div class="card-body px-4 pt-4 pb-2 mb-1">
        <div class="row px-4 mb-3">
            <div class="table-responsive mb-4 px-4">
                <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>No</th>
                            <th>Pegawai</th>
                            <th>Jabatan</th>
                            <th>Unit</th>
                            <th>Tanggal Penilaian</th>
                            <th>Total Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($grouped_riwayat)): ?>
                        <?php $no = 1; ?>
                        <?php foreach($grouped_riwayat as $key => $items): ?>
                        <?php
                                    list($pegawai_nama, $created_on, $jabatan_nama, $unit_nama) = explode('|', $key);
                                    $total_score = 0;
                                    foreach($items as $item) {
                                        foreach($item->detail as $detail) {
                                            $total_score += (float)$detail->score;
                                        }
                                    }
                                ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($pegawai_nama) ?></td>
                            <td><?= esc($jabatan_nama) ?></td>
                            <td><?= esc($unit_nama) ?></td>
                            <td><?= esc(date('d-m-Y H:i', strtotime($created_on))) ?></td>
                            <td><strong><?= $total_score ?></strong></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalDetail<?= md5($key) ?>">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada riwayat penilaian</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<?php foreach($grouped_riwayat as $key => $items): ?>
<?php list($pegawai_nama, $created_on, $jabatan_nama, $unit_nama) = explode('|', $key); ?>
<div class="modal fade" id="modalDetail<?= md5($key) ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Penilaian KPI - <?= esc($pegawai_nama) ?> (<?= esc($jabatan_nama) ?> -
                    <?= esc($unit_nama) ?>)
                    - <?= esc(date('d-m-Y H:i', strtotime($created_on))) ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>KPI Utama</th>
                                <th>Bobot</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_score = 0; ?>
                            <?php foreach($items as $item): ?>
                            <?php foreach($item->detail as $detail): ?>
                            <?php $total_score += (float)$detail->score; ?>
                            <tr>
                                <td><?= esc($detail->kpi_utama ?? '-') ?></td>
                                <td><?= esc($detail->bobot ?? '-') ?></td>
                                <td><?= esc($detail->target ?? '-') ?></td>
                                <td><?= esc($detail->realisasi ?? '-') ?></td>
                                <td><?= esc($detail->score ?? 0) ?></td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if(!empty($item->aspek_detail) && $item->kpi_utama === 'Checklist Pekerjaan'): ?>
                            <tr>
                                <td colspan="5">
                                    <table class="table table-sm table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Aspek Penilaian</th>
                                                <th>Skor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($item->aspek_detail as $aspek): ?>
                                            <tr>
                                                <td><?= esc($aspek->aspek_penilaian ?? '-') ?></td>
                                                <td><?= esc($aspek->skor ?? 0) ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>

                            <tr>
                                <td colspan="4" class="text-end"><strong>Total Score</strong></td>
                                <td><strong><?= $total_score ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
$(document).ready(function() {
    $('#zero_config').DataTable();
});

// Filter tanggal range
function filterData() {
    const start = document.getElementById('startDate').value;
    const end = document.getElementById('endDate').value;
    const rows = document.querySelectorAll('#zero_config tbody tr');

    rows.forEach(row => {
        const dateCell = row.children[4];
        if (!dateCell) return;

        const dateText = dateCell.textContent.trim();
        if (!dateText) return;

        const parts = dateText.split(/[-\s:]/);
        const rowDate = new Date(parts[2], parts[1] - 1, parts[0], parts[3] || 0, parts[4] || 0);

        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        let dateMatch = true;
        if (startDate && rowDate < startDate) dateMatch = false;
        if (endDate && rowDate > endDate) dateMatch = false;

        row.style.display = dateMatch ? '' : 'none';
    });
}

function resetFilter() {
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    filterData();
}
</script>