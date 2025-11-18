<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Stok Handphone</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Stok</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Stok Handphone</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <form action="<?php echo base_url('export/kartu_stock') ?>" method="post" enctype="multipart/form-data">
        <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
            <div class="d-flex gap-2">
                <!-- <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>
                    Export
                </button> -->
            </div>
        </div>
        <br>

        <div class="mb-3 px-4">
            <label class="me-2">Filter PPN:</label>
            <select name="status_ppn" id="ppnFilter" class="form-select d-inline"
                style="width: auto; display: inline-block;" onchange="filterKategori()">
                <option value="">Semua</option>
                <option value="PPN">PPN</option>
                <option value="Non PPN">Non PPN</option>
            </select>

            <label class="me-2 ms-4">Nama Unit:</label>
            <select name="unit" id="unitFilter" class="form-select d-inline" style="width: auto; display: inline-block;"
                onchange="filterKategori()">
                <option value="">Semua Unit</option>
                <?php
                $selectedUnit = session('ID_UNIT');
                foreach ($unit as $row) {
                    $selected = ($row->idunit == $selectedUnit) ? 'selected' : '';
                    echo '<option value="' . esc($row->idunit) . '" ' . $selected . '>' . esc($row->NAMA_UNIT) . '</option>';
                }
                ?>
            </select>
        </div>
    </form>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ID</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Type</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Size</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Unit</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Awal</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Opname</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Total Pembelian</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Mutasi Masuk</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Mutasi Keluar</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Penjualan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Retur Pelanggan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Retur Suplier</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kerusakan</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Akhir</h6>
                    </th>
                </tr>
            </thead>

            <tbody id="produkTableBody">
                <?php if (!empty($stok)): ?>
                <?php foreach ($stok as $row): ?>
                <tr data-idunit="<?= esc($row->id_unit) ?>">

                    <td><?= esc($row->id) ?></td>
                    <td><?= esc($row->nama) ?></td>
                    <td><?= esc($row->type) ?></td>
                    <td><?= esc($row->size) ?></td>
                    <td><?= esc($row->nama_unit) ?></td>

                    <td><?= esc($row->stok_awal) ?></td>
                    <td><?= esc($row->stok_opname) ?></td>

                    <td><?= esc($row->total_pembelian) ?></td>
                    <td><?= esc($row->total_mutasi_masuk) ?></td>
                    <td><?= esc($row->total_mutasi_keluar) ?></td>
                    <td><?= esc($row->total_penjualan) ?></td>
                    <td><?= esc($row->total_retur_pelanggan) ?></td>
                    <td><?= esc($row->total_retur_supplier) ?></td>
                    <td><?= esc($row->total_kerusakan) ?></td>

                    <td><b><?= esc($row->stok_akhir) ?></b></td>

                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="20" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- FILTER SCRIPT (TIDAK DIUBAH) -->
<script>
$(document).ready(function() {
    const table = $('#zero_config').DataTable();

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        if (settings.nTable.id !== 'zero_config') return true;

        const ppnFilter = ($('#ppnFilter').val() || '').toLowerCase();
        const unitFilter = ($('#unitFilter').val() || '').trim();

        const rowNode = table.row(dataIndex).node();
        const unitIdInTable = $(rowNode).attr('data-idunit') || '';
        const ppn = (data[4] || '').toLowerCase();

        const matchUnit = !unitFilter || unitIdInTable == unitFilter;
        const matchPPN = !ppnFilter || ppn === ppnFilter;

        return matchUnit && matchPPN;
    });

    window.filterKategori = function() {
        table.draw();
    };

    window.resetKategoriFilter = function() {
        $('#ppnFilter').val('');
        $('#unitFilter').val('');
        table.search('').columns().search('').draw();
    };
});
</script>

<script>
document.querySelectorAll('.currency').forEach(function(el) {
    new Cleave(el, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
});
</script>