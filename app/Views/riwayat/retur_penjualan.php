<?php
$grouped_penjualan = [];
foreach ($retur_penjualan as $row) {
    $grouped_penjualan[$row->no_retur_pelanggan][] = $row;
}
?>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Retur Penjualan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat Retur</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2 mb-1"></div>

    <form action="<?php echo base_url('riwayat_retur_penjualan/export') ?>" method="post" enctype="multipart/form-data">
        <button type="submit" class="btn btn-danger" style="margin-left: 20px; display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;"></iconify-icon>
            Export
        </button>
        <br><br>

        <!-- Filter Tanggal -->
        <div class="mb-3 px-4">
            <label class="me-2">Nama Unit:</label>
            <select name="unit" id="unitFilter" class="form-select d-inline" style="width: auto; display: inline-block;" onchange="filterData()">
                <option value="">Semua Unit</option>
                <?php
                $unitList = [];
                foreach ($grouped_penjualan as $items) {
                    $unitName = $items[0]->NAMA_UNIT;
                    if (!in_array($unitName, $unitList)) {
                        $unitList[] = $unitName;
                        echo '<option value="' . esc($unitName) . '">' . esc($unitName) . '</option>';
                    }
                }
                ?>
            </select>

            <label class="ms-3 me-2">Tanggal Awal:</label>
            <input name="tanggal_awal" type="date" id="startDate" class="form-control d-inline" style="width: auto; display: inline-block;" onchange="filterData()">

            <label class="ms-3 me-2">Tanggal Akhir:</label>
            <input name="tanggal_akhir" type="date" id="endDate" class="form-control d-inline" style="width: auto; display: inline-block;" onchange="filterData()">

            <button type="button" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
        </div>
    </form>

    <div class="row px-4 mb-3">
        <div class="table-responsive mb-4 px-4">
            <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>No. Retur Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Nama Unit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grouped_penjualan)): ?>
                        <?php foreach ($grouped_penjualan as $no_retur_pelanggan => $items): ?>
                            <?php $first = $items[0]; ?>
                            <tr>
                                <td><?= esc($no_retur_pelanggan) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($first->tanggal))) ?></td>
                                <td><?= esc($first->nama_barang) ?>, ...</td>
                                <td><?= esc($first->NAMA_UNIT) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= esc($no_retur_pelanggan) ?>"
                                        style="display: inline-flex; align-items: center;">
                                        <iconify-icon icon="solar:folder-favourite-bookmark-broken" width="24" height="24">
                                        </iconify-icon>
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($grouped_penjualan as $no_retur_pelanggan => $items): ?>
    <!-- Modal for each No. Retur Pelanggan -->
    <div class="modal fade" id="modalDetail<?= esc($no_retur_pelanggan) ?>" tabindex="-1"
        aria-labelledby="modalLabel<?= esc($no_retur_pelanggan) ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan - No. Retur Pelanggan <?= esc($no_retur_pelanggan) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered detail-table" id="detailTable<?= esc($no_retur_pelanggan) ?>">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>SubTotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?= esc($item->nama_barang) ?></td>
                                        <td><?= esc($item->jumlah) ?></td>
                                        <td><?= esc(number_format($item->harga_penjualan, 0, ',', '.')) ?></td>
                                        <td><?= esc(number_format($item->diskon_penjualan, 0, ',', '.')) ?></td>
                                        <td><?= esc(number_format($item->sub_total, 0, ',', '.')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('#zero_config').DataTable();
        $('#detailTable').DataTable({

        });

    });
</script>

<!-- JavaScript untuk filter -->
<script>
    window.onload = function() {
        const endDateInput = document.getElementById('endDate');
        const startDateInput = document.getElementById('startDate');

        const today = new Date();
        const fifteenDaysAgo = new Date();
        fifteenDaysAgo.setDate(today.getDate() - 15);


        const toDateInputValue = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        startDateInput.value = toDateInputValue(fifteenDaysAgo);
        endDateInput.value = toDateInputValue(today);

        const unitSelect = document.getElementById('unitFilter');
        if (unitSelect.options.length > 1) {
            unitSelect.selectedIndex = 1;
        }

        filterData();
    };

    function filterData() {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        const selectedUnit = document.getElementById('unitFilter').value.toLowerCase();

        const rows = document.querySelectorAll('#zero_config tbody tr');
        rows.forEach(row => {
            const dateCell = row.children[1];
            const unitCell = row.children[3];
            if (!dateCell || !unitCell) return;

            // Ambil dan parsing tanggal
            const dateText = dateCell.textContent.trim();
            const parts = dateText.split('-');
            const rowDate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`); // ubah ke Y-m-d

            const startDate = start ? new Date(start) : null;
            const endDate = end ? new Date(end) : null;

            // Ambil dan cocokan nama unit
            const unitName = unitCell.textContent.trim().toLowerCase();
            const unitMatch = selectedUnit === "" || unitName === selectedUnit;

            let dateMatch = true;
            if (startDate && rowDate < startDate) dateMatch = false;
            if (endDate && rowDate > endDate) dateMatch = false;

            // Tampilkan baris jika dua-duanya match
            row.style.display = (unitMatch && dateMatch) ? '' : 'none';
        });
    }

    function resetFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('unitFilter').value = '';
        filterData();
    }
</script>