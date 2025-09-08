<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Pembayaran Hutang</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pembayaran Hutang</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <form action="<?= base_url('export_aging_piutang') ?>" method="post" enctype="multipart/form-data">
        <div class="px-4 py-3 border-bottom">
            <button type="submit" class="btn btn-danger"
                style="margin-left: 20px; display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Export
            </button>
            <a href="<?php echo base_url('daftar_piutang') ?>">
                <button type="button" class="btn btn-warning"
                    style="display: inline-flex; color: white; align-items: center;">
                    <iconify-icon icon="solar:wallet-money-line-duotone" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>Daftar Tagihan
                </button>
            </a>
            <a href="<?php echo base_url('umur_piutang') ?>">
                <button type="button" class="btn btn-success"
                    style="display: inline-flex; color: white; align-items: center;">
                    <iconify-icon icon="solar:wallet-money-line-duotone" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>Umur Hutang
                </button>
            </a>

        </div>


        <div class="row my-3 mx-1">
            <div class="mb-3 px-4">
                <label class="ms-3 me-2">Tanggal Awal:</label>
                <input name="tanggal_awal" type="date" id="startDate" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">

                <label class="ms-3 me-2">Tanggal Akhir:</label>
                <input name="tanggal_akhir" type="date" id="endDate" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">

                <label class="ms-3 me-2">Nama Unit:</label>
                <select name="nama_unit" id="unitSelect" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">
                    <option value="">Semua Unit</option>
                    <?php
                    $unitList = [];
                    foreach ($aging as $row) {
                        if (!in_array($row->nama_unit, $unitList)) {
                            $unitList[] = $row->nama_unit;
                            echo '<option value="' . esc($row->nama_unit) . '">' . esc($row->nama_unit) . '</option>';
                        }
                    }
                    ?>
                </select>

                <button type="button" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
                <input type="hidden" id="hiddenNamaUnit" name="hiddenNamaUnit">
            </div>
        </div>
    </form>





    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Kode Piutang</th>
                    <th>Tanggal</th>
                    <th>Nama Unit</th>
                    <th>Nama Pegawai</th>
                    <th>Jatuh Tempo</th>
                    <th>Jumlah Hutang</th>
                    <th>Sisa Hutang</th>
                    <th>0-30 Hari</th>
                    <th>31-60 Hari</th>
                    <th>61-90 Hari</th>
                    <th>>90 Hari</th>
                    <th>Input By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($aging as $row): ?>
                    <tr>
                        <td><?= $row->kode_piutang ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($row->tanggal))) ?></td>
                        <td><?= $row->nama_unit ?></td>
                        <td><?= $row->nama_pegawai ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($row->jatuh_tempo))) ?></td>
                        <td><?= number_format($row->jumlah_hutang, 0, ',', '.') ?></td>
                        <td><?= number_format($row->sisa_hutang, 0, ',', '.') ?></td>
                        <td><?= number_format($row->{'0_30_hari'}, 0, ',', '.') ?></td>
                        <td><?= number_format($row->{'31_60_hari'}, 0, ',', '.') ?></td>
                        <td><?= number_format($row->{'61_90_hari'}, 0, ',', '.') ?></td>
                        <td><?= number_format($row->lebih_90_hari, 0, ',', '.') ?></td>
                        <td><?= $row->nama_input ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>






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

        const unitSelect = document.getElementById('unitSelect');
        if (unitSelect.options.length > 1) {
            unitSelect.selectedIndex = 1;
        }

        filterData();
    };

    function filterData() {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        const selectedUnit = document.getElementById('unitSelect').value.toLowerCase();

        const rows = document.querySelectorAll('#zero_config tbody tr');
        rows.forEach(row => {
            const dateCell = row.children[1];
            const unitCell = row.children[2];
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
        document.getElementById('unitSelect').value = '';
        filterData();
    }
</script>