<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Barang Rusak</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Barang Rusak</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Barang Rusak</li>
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
        <a href="<?php echo base_url('input_barang_rusak') ?>">
            <button type="button" class="btn btn-primary"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                    style="margin-right: 8px;"></iconify-icon>Input
            </button>
        </a>
    </div>

    <div hidden class="mb-3">
        <label for="filter-unit" class="form-label fw-semibold">Unit:</label>
        <select id="filter-unit" class="form-select w-auto d-inline-block">
            <?php foreach ($unit as $u): ?>
                <option value="<?= esc($u->NAMA_UNIT) ?>"
                    <?= session('ID_UNIT') == $u->idunit ? 'selected' : '' ?>>
                    <?= esc($u->NAMA_UNIT) ?>
                </option>
            <?php endforeach; ?>
            <option value="">Semua Unit</option>
        </select>



    </div>
    <div class="mb-3" style="padding-left: 20px;">

        <select disabled id="filter-unit2" class="form-select w-auto d-inline-block">
            <?php foreach ($unit as $u): ?>
                <option value="<?= esc($u->NAMA_UNIT) ?>"
                    <?= session('ID_UNIT') == $u->idunit ? 'selected' : '' ?>>
                    <?= esc($u->NAMA_UNIT) ?>
                </option>
            <?php endforeach; ?>
            <option value="">Semua Unit</option>
        </select>

    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">No Nota Supplier</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kode Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Imei</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Jumlah Rusak</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Rusak</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ID Unit</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Input By</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Dibuat Pada</h6>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php if (!empty($barang_rusak)): ?>
                    <?php foreach ($barang_rusak as $row): ?>
                        <tr>

                            <td><?= esc($row->no_nota_sup) ?></td>
                            <td><?= esc($row->kode_barang) ?></td>
                            <td><?= esc($row->nama_barang) ?></td>
                            <td><?= !empty($row->imei) ? esc($row->imei) : 'Tidak ada IMEI' ?></td>
                            <td><?= esc($row->jumlah) ?></td>
                            <td><?= esc($row->tanggal_rusak) ?></td>
                            <td><?= esc($row->nama_unit) ?></td>
                            <td><?= esc($row->nama_input) ?></td>
                            <td><?= esc($row->created_at) ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data barang rusak</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="edit-kategori-modal" tabindex="-1" aria-labelledby="editKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editKategoriModalLabel">Edit Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('update_kategori') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input hidden type="text" class="form-control" id="edit_id" name="idnya" required>
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- /.modal -->

<!-- Modal Input Kategori -->
<div class="modal fade" id="input-kategori-modal" tabindex="-1" aria-labelledby="inputKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputKategoriModalLabel">Input Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('insert_kategori') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="idkategori" class="form-label">ID Kategori</label>
                        <input type="text" class="form-control" id="idkategori" name="idkategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Kategori -->
<div class="modal fade" id="delete-kategori-modal" tabindex="-1" aria-labelledby="deleteKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="deleteKategoriModalLabel">Delete Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('delete_kategori') ?>" method="post">
                <div class="modal-body">
                    <input hidden id="delete_id" name=" idnya">
                    <p style="font-style: italic;">Apa anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#zero_config').addEventListener('click', function(e) {
            if (e.target.closest('.edit-button')) {
                const button = e.target.closest('.edit-button');
                const id = button.getAttribute('data-id');

                const nama_kategori = button.getAttribute('data-nama_kategori');
                document.getElementById('edit_id').value = id;

                document.getElementById('edit_nama_kategori').value = nama_kategori;
            }

            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                const id = button.getAttribute('data-id');
                document.getElementById('delete_id').value = id;
            }
        });
    });
</script>

<!-- // -->
<script>
    $(document).ready(function() {
        // Hanya inisialisasi kalau belum diinisialisasi
        var table;
        if (!$.fn.dataTable.isDataTable('#zero_config')) {
            table = $('#zero_config').DataTable({
                responsive: true
            });
        } else {
            table = $('#zero_config').DataTable(); // ambil instance yang sudah ada
        }

        // Filter dropdown
        $('#filter-unit').on('change', function() {
            var selectedUnit = $(this).val();
            table.column(6) // sesuaikan index kolom jika berubah
                .search(selectedUnit)
                .draw();
        });

        // Terapkan default (session) jika ada
        var defaultUnit = $('#filter-unit').find('option:selected').val();
        if (defaultUnit) {
            table.column(6).search(defaultUnit).draw();
        }
    });
</script>