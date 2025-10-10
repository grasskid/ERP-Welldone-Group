<!-- Page Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Jadwal Masuk</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Jadwal Masuk</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Card Content -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-jadwal-modal">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div style="padding-left: 20px;" class="mb-3 d-flex gap-2">
        <select id="unitFilter" class="form-select" onchange="filterUnit()" style="width: 250px;">
            <option value="">-- Filter Berdasarkan Unit --</option>
            <?php foreach ($unit as $u): ?>
                <option value="<?= strtolower(esc($u->NAMA_UNIT)) ?>"><?= esc($u->NAMA_UNIT) ?></option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-secondary" onclick="resetUnitFilter()">Reset</button>
    </div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama Jadwal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Total Jam</th>
                    <th>WFH</th>
                    <th>WFO</th>
                    <th>Jenis</th>
                    <th>Toleransi</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($jadwal)): ?>
                    <?php foreach ($jadwal as $row): ?>
                        <tr>
                            <td><?= esc($row->nama_jadwal) ?></td>
                            <td><?= esc($row->jam_masuk) ?></td>
                            <td><?= esc($row->jam_pulang) ?></td>
                            <td><?= esc($row->total_jamkerja) ?></td>
                            <td><?= esc($row->jml_wfh) ?></td>
                            <td><?= esc($row->jml_wfo) ?></td>
                            <td><?= esc($row->jenis == 1 ? 'WFO' : 'WFH') ?></td>
                            <td><?= esc($row->toleransi) ?> menit</td>
                            <td><?= esc($row->NAMA_UNIT) ?> </td>
                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-jadwal-modal" data-id="<?= $row->idjadwal_masuk ?>"
                                    data-nama="<?= $row->nama_jadwal ?>" data-masuk="<?= $row->jam_masuk ?>"
                                    data-pulang="<?= $row->jam_pulang ?>" data-total="<?= $row->total_jamkerja ?>"
                                    data-wfh="<?= $row->jml_wfh ?>" data-wfo="<?= $row->jml_wfo ?>"
                                    data-jenis="<?= $row->jenis ?>" data-toleransi="<?= $row->toleransi ?>"
                                    data-unit="<?= $row->unit_idunit ?>">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-jadwal-modal" data-id="<?= $row->idjadwal_masuk ?>">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Input Jadwal -->
<div class="modal fade" id="input-jadwal-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('insert_jadwal') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input Jadwal Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="unit_idunit" class="form-label">Pilih Unit</label>
                    <select name="unit_idunit" id="unit_idunit" class="form-select" required>
                        <option value="">-- Pilih Unit --</option>
                        <?php foreach ($unit as $u): ?>
                            <option value="<?= esc($u->idunit) ?>">
                                <?= esc($u->NAMA_UNIT) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Nama Jadwal</label>
                    <input type="text" name="nama_jadwal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Jamkerja</label>
                    <input type="text" name="total_jamkerja" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jml WFH</label>
                    <input type="text" name="jml_wfh" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jml WFO</label>
                    <input type="text" name="jml_wfo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Toleransi</label>
                    <input type="text" name="toleransi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-control" required>
                        <option value="1">WFO</option>
                        <option value="2">WFH</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Jadwal -->
<div class="modal fade" id="edit-jadwal-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('update_jadwal') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Jadwal Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idjadwal_masuk" id="edit_id">

                <div class="mb-3">
                    <label for="edit_unit_idunit" class="form-label">Unit</label>
                    <select name="unit_idunit" id="edit_unit_idunit" class="form-select" required>
                        <option value="">-- Pilih Unit --</option>
                        <?php foreach ($unit as $u): ?>
                            <option value="<?= esc($u->idunit) ?>"><?= esc($u->NAMA_UNIT) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Nama Jadwal</label>
                    <input type="text" name="nama_jadwal" id="edit_nama_jadwal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" id="edit_jam_masuk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" id="edit_jam_pulang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Total Jamkerja</label>
                    <input type="text" name="total_jamkerja" id="edit_total_jamkerja" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jml WFH</label>
                    <input type="text" name="jml_wfh" id="edit_jml_wfh" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jml WFO</label>
                    <input type="text" name="jml_wfo" id="edit_jml_wfo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Toleransi</label>
                    <input type="text" name="toleransi" id="edit_toleransi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" id="edit_jenis" class="form-control" required>
                        <option value="1">WFO</option>
                        <option value="2">WFH</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Jadwal -->
<div class="modal fade" id="delete-jadwal-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('delete_jadwal') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus Jadwal Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idjadwal_masuk" id="delete_id">
                <p>Apakah Anda yakin ingin menghapus jadwal ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

<!-- DataTables & Modal Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#zero_config').DataTable();



        document.querySelector('#zero_config').addEventListener('click', function(e) {
            const btn = e.target.closest('button');
            if (!btn) return;

            if (btn.classList.contains('edit-button')) {
                document.getElementById('edit_id').value = btn.dataset.id;
                document.getElementById('edit_nama_jadwal').value = btn.dataset.nama;
                document.getElementById('edit_jam_masuk').value = btn.dataset.masuk;
                document.getElementById('edit_jam_pulang').value = btn.dataset.pulang;
                document.getElementById('edit_total_jamkerja').value = btn.dataset.total;
                document.getElementById('edit_jml_wfh').value = btn.dataset.wfh;
                document.getElementById('edit_jml_wfo').value = btn.dataset.wfo;
                document.getElementById('edit_jenis').value = btn.dataset.jenis;
                document.getElementById('edit_toleransi').value = btn.dataset.toleransi;

                // 🟢 Tambahan untuk dropdown unit
                const unitDropdown = document.getElementById('edit_unit_idunit');
                if (unitDropdown) {
                    unitDropdown.value = btn.dataset.unit;
                }
            }

            if (btn.classList.contains('delete-button')) {
                document.getElementById('delete_id').value = btn.dataset.id;
            }
        });
    });
</script>

<script>
    let table;

    window.onload = function() {
        table = $('#zero_config').DataTable();


        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const unitFilter = $('#unitFilter').val().toLowerCase();
            const unit = data[8].toLowerCase(); // index kolom NAMA_UNIT

            const matchUnit = !unitFilter || unit === unitFilter;
            return matchUnit;
        });

        // Render awal tabel
        table.draw();
    };

    function filterUnit() {
        table.draw();
    }

    function resetUnitFilter() {
        $('#unitFilter').val('');
        table.draw();
    }
</script>