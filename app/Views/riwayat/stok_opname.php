<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Stok Opname</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Stok Opname</li>
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

    <form action="<?php echo base_url('riwayat_stok_opname/export') ?>" method="post" enctype="multipart/form-data">
        <button type="submit" class="btn btn-danger" style="margin-left: 20px; display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;"></iconify-icon>
            Export
        </button>
        <br><br>

        <div style="display: flex; justify-content: left; margin-left: 20px; gap: 20px;">
            <!-- Filter Tanggal & Unit -->
            <div class="mb-4">
                <label for="unitFilter">Filter Unit:</label>
                <select style="width: 200px;" name="unit" id="unitFilter" onchange="filterData()" class="form-control">
                    <option value="">Semua Unit</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="startDate">Tanggal Awal:</label>
                <input style="width: 200px;" name="tanggal_awal" type="date" id="startDate" onchange="filterData()" class="form-control">
            </div>

            <div class="mb-4">
                <label for="endDate">Tanggal Akhir:</label>
                <input style="width: 200px;" name="tanggal_akhir" type="date" id="endDate" onchange="filterData()" class="form-control">
            </div>
            <div class="mb-4">
                <label for="blabla" style="color: transparent; text-decoration: none; ;">a</label>
                <br>
                <button type="button" id="blabla" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
            </div>

        </div>

    </form>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Unit</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Jumlah Real</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Jumlah Komputer</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Jumlah Selisih</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stokopname)): ?>
                    <?php foreach ($stokopname as $row): ?>
                        <tr>
                            <td><?= esc($row->tanggal) ?></td>
                            <td><?= esc($row->nama_barang) ?></td>
                            <td><?= esc($row->NAMA_UNIT) ?></td>
                            <td><?= esc($row->jumlah_real) ?></td>
                            <td><?= esc($row->jumlah_komp) ?></td>
                            <td><?= esc($row->jumlah_selisih) ?></td>
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


<!-- Filter Script -->
<script>
    let table;

    document.addEventListener('DOMContentLoaded', function() {

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





        // Inisialisasi DataTable
        table = $('#zero_config').DataTable();

        // Custom filter function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const selectedUnit = document.getElementById('unitFilter').value.toLowerCase();

            const tanggal = data[0]; // kolom tanggal (format: dd-mm-yyyy)
            const unit = data[2].toLowerCase(); // kolom unit

            // Parsing tanggal
            const parts = tanggal.split('-');
            const rowDate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`);

            let start = startDate ? new Date(startDate) : null;
            let end = endDate ? new Date(endDate) : null;

            let dateMatch = true;
            if (start && rowDate < start) dateMatch = false;
            if (end && rowDate > end) dateMatch = false;

            let unitMatch = selectedUnit === "" || unit === selectedUnit;

            return dateMatch && unitMatch;
        });

        // Isi dropdown unit dari data tabel
        const unitSet = new Set();
        table.rows().every(function() {
            const unit = this.data()[2].trim();
            if (unit) unitSet.add(unit);
        });

        const unitFilter = document.getElementById('unitFilter');
        Array.from(unitSet).sort().forEach(unit => {
            const option = document.createElement('option');
            option.value = unit.toLowerCase();
            option.textContent = unit;
            unitFilter.appendChild(option);
        });
    });

    function filterData() {
        table.draw(); // Memicu ulang filter DataTable
    }

    function resetFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('unitFilter').value = '';
        table.draw();
    }
</script>