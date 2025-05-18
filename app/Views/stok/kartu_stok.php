<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Kartu Stok</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Stok</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Kartu Stok</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">

    </div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2">
            <a href="<?= base_url('export/kartu_stock') ?>" class="btn btn-danger"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>Export
            </a>
            <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#samedata-modal"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:import-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Import
            </button> -->
            <a href="<?php echo base_url('format_excell/format_kartu_stok.xlsx') ?>"><button type="button"
                    class="btn btn-success" style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:download-broken" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>
                    Download Format Excell
                </button></a>
        </div>
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-produk-modal">
            Input
        </button> -->
    </div>
    <br>
    <div class="mb-3 px-4">
        <label class="me-2">Filter PPN:</label>
        <select id="ppnFilter" class="form-select d-inline" style="width: auto; display: inline-block;" onchange="filterKategori()">
            <option value="">Semua</option>
            <option value="PPN">PPN</option>
            <option value="Non PPN">Non PPN</option>
        </select>


        <label class="me-2 ms-4">Nama Unit:</label>
        <select id="unitFilter" class="form-select d-inline" style="width: auto; display: inline-block;" onchange="filterKategori()">
            <option value="">Semua Unit</option>
            <?php
            $unitList = [];
            foreach ($stok as $row) {
                if (!in_array($row->nama_unit, $unitList)) {
                    $unitList[] = $row->nama_unit;
                    echo '<option value="' . esc($row->nama_unit) . '">' . esc($row->nama_unit) . '</option>';
                }
            }
            ?>
        </select>

        <label class="me-2 ms-4">Tanggal Awal:</label>
        <input type="date" id="startDate" class="form-control d-inline" style="width: auto; display: inline-block;" onchange="filterKategori()">

        <label class="me-2 ms-2">Tanggal Akhir:</label>
        <input type="date" id="endDate" class="form-control d-inline" style="width: auto; display: inline-block;" onchange="filterKategori()">





        <button onclick="resetKategoriFilter()" class="btn btn-sm btn-secondary ms-2">Reset</button>
    </div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kode Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Unit</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Dasar</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Kategori</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status PPN</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Stok Dasar</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Total Pembelian</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Total Penjualan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Total Retur Pelanggan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Total Retur Suplier</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Akhir</h6>
                    </th>
                </tr>
            </thead>
            <tbody id="produkTableBody">
                <?php if (!empty($stok)): ?>
                    <?php foreach ($stok as $row): ?>
                        <tr>
                            <td><?= esc($row->kode_barang) ?></td>
                            <td><?= esc($row->nama_barang) ?></td>
                            <td><?= esc($row->nama_unit) ?></td>
                            <td><?= esc($row->stok_dasar) ?></td>
                            <td><?= esc($row->nama_kategori) ?></td>
                            <td><?= $row->status_ppn == 1 ? 'PPN' : 'Non PPN' ?></td>
                            <td><?= esc(date('d-m-Y', strtotime($row->tanggal_stok_dasar))) ?></td>
                            <td><?= esc($row->total_pembelian) ?></td>
                            <td><?= esc($row->total_penjualan) ?></td>
                            <td><?= esc($row->total_retur_pelanggan) ?></td>
                            <td><?= esc($row->total_retur_supplier) ?></td>
                            <td><?= esc($row->stok_akhir) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    let table;

    $(document).ready(function() {
        table = $('#zero_config').DataTable();

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const ppnFilter = $('#ppnFilter').val().toLowerCase();
            const unitFilter = $('#unitFilter').val().toLowerCase();
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            const unit = data[2].toLowerCase(); // kolom Unit
            const ppn = data[5].toLowerCase(); // kolom PPN
            const tanggal = data[6]; // kolom Tanggal Stok Dasar (format: dd-mm-yyyy)

            const [day, month, year] = tanggal.split("-");
            const rowDate = new Date(`${year}-${month}-${day}`); // Convert ke format yyyy-mm-dd

            let matchPPN = !ppnFilter || ppn === ppnFilter;
            let matchUnit = !unitFilter || unit === unitFilter;

            let matchDate = true;
            if (startDate) {
                matchDate = matchDate && rowDate >= new Date(startDate);
            }
            if (endDate) {
                matchDate = matchDate && rowDate <= new Date(endDate);
            }

            return matchPPN && matchUnit && matchDate;
        });
    });

    function filterKategori() {
        table.draw();
    }

    function resetKategoriFilter() {
        $('#ppnFilter').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#unitFilter').val('');
        table.draw();
    }
</script>




<script>
    document.querySelectorAll('.currency').forEach(function(el) {
        new Cleave(el, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    });
</script>