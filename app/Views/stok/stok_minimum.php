<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Stok Minimum</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Stok</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Stok Minimum</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">

    </div>

    <form action="<?php echo base_url('#') ?>" method="post" enctype="multipart/form-data">
        <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
            <!-- <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;"></iconify-icon>
                    Export
                </button>

                <a href="<?php echo base_url('format_excell/format_kartu_stok.xlsx') ?>"><button type="button"
                        class="btn btn-success" style="display: inline-flex; align-items: center;">
                        <iconify-icon icon="solar:download-broken" width="24" height="24" style="margin-right: 8px;">
                        </iconify-icon>
                        Download Format Excell
                    </button></a>
            </div> -->

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
            <input name="tanggal_awal" type="date" id="startDate" class="form-control d-inline"
                style="width: auto; display: inline-block;" onchange="filterKategori()">

            <label class="me-2 ms-2">Tanggal Akhir:</label>
            <input name="tanggal_akhir" type="date" id="endDate" class="form-control d-inline"
                style="width: auto; display: inline-block;" onchange="filterKategori()">





            <button type="button" onclick="resetKategoriFilter()" class="btn btn-sm btn-secondary ms-2">Reset</button>
        </div>
    </form>



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
                        <h6 class="fs-4 fw-semibold mb-0">Nama Kategori</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status PPN</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Minimum</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Stok Akhir</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
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
                    <td><?= esc($row->nama_kategori) ?></td>
                    <td><?= $row->status_ppn == 1 ? 'PPN' : 'Non PPN' ?></td>
                    <td><?= esc($row->stok_minimum) ?></td>
                    <td><b><?= esc($row->stok_akhir) ?></b></td>
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-stokminimum-modal" data-idbarang="<?= esc($row->idbarang) ?>"
                            data-unit="<?= esc($row->id_unit) ?>" data-stok_minimum="<?= esc($row->stok_minimum) ?>">
                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                        </button>
                    </td>
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


<div class="modal fade" id="edit-stokminimum-modal" tabindex="-1" aria-labelledby="editPelangganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('update_stokminimum') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="editstokminimumModalLabel">Edit Stok Minimum</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3"><label hidden>Id Unit</label><input hidden type="text" class="form-control"
                            name="idunit" id="edit-idunit" required></div>
                    <div class="mb-3"><label hidden>Idbarang</label><input hidden type="text" class="form-control"
                            name="idbarang" id="edit-idbarang" required></div>
                    <div class="mb-3"><label>Stok Minimum</label><input type="text" class="form-control"
                            name="stokminimum" id="stokminimum" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#zero_config').addEventListener('click', function(e) {
        const button = e.target.closest('.edit-button');
        if (button) {
            document.getElementById('edit-idbarang').value = button.getAttribute('data-idbarang');
            document.getElementById('edit-idunit').value = button.getAttribute('data-unit');
            document.getElementById('stokminimum').value = button.getAttribute('data-stok_minimum');
        }
    });
});
</script>




<script>
let table;

$(document).ready(function() {
    table = $('#zero_config').DataTable();

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        const ppnFilter = $('#ppnFilter').val().toLowerCase();
        const unitFilter = $('#unitFilter').val().toLowerCase();
        const start = $('#startDate').val();
        const end = $('#endDate').val();

        const unit = data[2]?.toLowerCase() || ""; // Kolom unit
        const ppn = data[4]?.toLowerCase() || ""; // Kolom ppn
        const tanggalText = data[5]?.trim(); // Kolom tanggal (dd-mm-yyyy)


        let rowDate = null;
        if (tanggalText && tanggalText.includes('-')) {
            const parts = tanggalText.split('-');
            if (parts.length === 3) {
                rowDate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`); // yyyy-mm-dd
            }
        }

        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        const matchUnit = !unitFilter || unit === unitFilter;
        const matchPPN = !ppnFilter || ppn === ppnFilter;

        let matchDate = true;
        if (rowDate instanceof Date && !isNaN(rowDate)) {
            if (startDate && rowDate < startDate) matchDate = false;
            if (endDate && rowDate > endDate) matchDate = false;
        }

        return matchUnit && matchPPN && matchDate;
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
window.onload = function() {
    const today = new Date();
    const fifteenDaysAgo = new Date();
    fifteenDaysAgo.setDate(today.getDate() - 15);

    const toDateInputValue = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    // Set default tanggal
    $('#startDate').val(toDateInputValue(fifteenDaysAgo));
    $('#endDate').val(toDateInputValue(today));

    // Set default pilihan PPN (index ke-1 = "PPN")
    const ppnSelect = document.getElementById('ppnFilter');
    if (ppnSelect.options.length > 1) {
        ppnSelect.selectedIndex = 1;
    }

    // Set default pilihan Unit (index ke-1 = unit pertama)
    const unitSelect = document.getElementById('unitFilter');
    if (unitSelect.options.length > 1) {
        unitSelect.selectedIndex = 1;
    }

    // Apply filter setelah semua default diset
    table.draw();
};
</script>






<script>
document.querySelectorAll('.currency').forEach(function(el) {
    new Cleave(el, {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
});
</script>