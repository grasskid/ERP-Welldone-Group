<?php
$grouped_penjualan = [];
foreach ($detail_penjualan as $row) {
    $grouped_penjualan[$row->kode_invoice][] = $row;
}
?>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Retur Penjualan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Retur</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2 mb-1"></div>


    <!-- Filter Dropdown dan Tanggal -->
    <div class="mb-3 px-4">
        <label class="me-2">Nama Unit:</label>
        <select id="unitFilter" class="form-select d-inline" style="width: auto; display: inline-block;" onchange="filterData()">
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
        <input type="date" id="startDate" class="form-control d-inline" style="width: auto; display: inline-block;" onchange="filterData()">

        <label class="ms-3 me-2">Tanggal Akhir:</label>
        <input type="date" id="endDate" class="form-control d-inline" style="width: auto; display: inline-block;" onchange="filterData()">

        <button onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
    </div>


    <div class="row px-4 mb-3">
        <div class="table-responsive mb-4 px-4">
            <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Nama Unit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grouped_penjualan)): ?>
                        <?php foreach ($grouped_penjualan as $kode_invoice => $items): ?>
                            <?php $first = $items[0]; ?>
                            <tr>
                                <td><?= esc($kode_invoice) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($first->tanggal))) ?></td>
                                <td><?= esc($first->nama_barang) ?>, ...</td>
                                <td><?= esc($first->NAMA_UNIT) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= esc($kode_invoice) ?>"
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
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($grouped_penjualan as $kode_invoice => $items): ?>
    <!-- Modal for each invoice -->
    <div class="modal fade" id="modalDetail<?= esc($kode_invoice) ?>" tabindex="-1"
        aria-labelledby="modalLabel<?= esc($kode_invoice) ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan - Invoice <?= esc($kode_invoice) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('insert_retur_customer') ?>" method="post">
                        <input type="hidden" name="kode_invoice" value="<?= esc($kode_invoice) ?>">
                        <div class="table-responsive">
                            <table class="table table-bordered detail-table" id="detailTable<?= esc($kode_invoice) ?>">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Jual</th>
                                        <th>Diskon</th>
                                        <th>SubTotal</th>
                                        <th>Jumlah Retur</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $index => $item): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="items[<?= $index ?>][selected]" value="1">
                                                <input type="hidden" name="items[<?= $index ?>][iddetail_penjualan]" value="<?= esc($item->iddetail_penjualan) ?>">
                                            </td>
                                            <td><?= esc($item->nama_barang) ?></td>
                                            <td><?= esc($item->jumlah) ?></td>
                                            <td><?= esc(number_format($item->harga_penjualan, 0, ',', '.')) ?></td>
                                            <td><?= esc(number_format($item->diskon_penjualan, 0, ',', '.')) ?></td>
                                            <td><?= esc(number_format($item->sub_total, 0, ',', '.')) ?></td>
                                            <td>
                                                <input type="number" class="form-control" name="items[<?= $index ?>][jumlah_retur]" min="1" max="<?= esc($item->jumlah) ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="items[<?= $index ?>][satuan]" value="<?= esc($item->satuan_jual) ?>" readonly>

                                                <input type="hidden" name="items[<?= $index ?>][jumlah]" value="<?= esc($item->jumlah) ?>">
                                                <input type="hidden" name="items[<?= $index ?>][barang_idbarang]" value="<?= esc($item->barang_idbarang) ?>">
                                                <input type="hidden" name="items[<?= $index ?>][unit_idunit]" value="<?= esc($item->unit_idunit) ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-success">Simpan Retur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('#zero_config').DataTable();
        $('.detail-table').DataTable();
    });
</script>

<!-- JavaScript untuk filter -->
<script>
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