<!-- Page Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Template Tugas</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Template Tugas</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Card Content -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-template-modal">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tugas_template)): ?>
                <?php foreach ($tugas_template as $row): ?>
                <tr>
                    <td><?= esc($row->nama_tugas) ?></td>
                    <td><?= esc($row->deskripsi) ?></td>
                    <td><?= esc($row->start_date) ?></td>
                    <td><?= esc($row->end_date) ?></td>
                    <td><?= esc($row->NAMA_JABATAN ?? '-') ?></td>
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-template-modal" data-id="<?= esc($row->idtemplate_tugas) ?>"
                            data-nama="<?= esc($row->nama_tugas) ?>" data-deskripsi="<?= esc($row->deskripsi) ?>"
                            data-start="<?= esc($row->start_date) ?>" data-end="<?= esc($row->end_date) ?>"
                            data-jabatan="<?= esc($row->ID_JABATAN) ?>">
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

<!-- Modal Input Template -->
<div class="modal fade" id="input-template-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('insert_tugas_template') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Input Template Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Tugas</label>
                        <select name="nama_tugas" class="form-select select2" required>
                            <option value="">-- Pilih Tugas --</option>
                            <?php foreach ($penilaian_template as $p): ?>
                            <option value="<?= $p->aspek_penilaian ?>"><?= esc($p->aspek_penilaian) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="ID_JABATAN" class="form-select select2" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $j): ?>
                            <option value="<?= $j->ID_JABATAN ?>"><?= esc($j->NAMA_JABATAN) ?></option>
                            <?php endforeach; ?>
                        </select>
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

<!-- Modal Edit Template -->
<div class="modal fade" id="edit-template-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('update_tugas_template') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Template Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idtemplate_tugas" id="edit_idtemplate_tugas">
                    <div class="mb-3">
                        <label>Nama Tugas</label>
                        <select name="nama_tugas" id="edit_nama_tugas" class="form-select select2" required>
                            <option value="">-- Pilih Tugas --</option>
                            <?php foreach ($penilaian_template as $p): ?>
                            <option value="<?= $p->aspek_penilaian ?>"><?= esc($p->aspek_penilaian) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="mb-3">
                        <label>Nama Tugas</label>
                        <input type="text" class="form-control" name="nama_tugas" id="edit_nama_tugas" required>
                    </div> -->
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="2"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" id="edit_start_date" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" id="edit_end_date" required>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="ID_JABATAN" class="form-select select2" id="edit_id_jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $j): ?>
                            <option value="<?= $j->ID_JABATAN ?>"><?= esc($j->NAMA_JABATAN) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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

<!-- Select2 Assets -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- JS Logic -->
<script>
$(document).ready(function() {
    // Activate Select2 in both modals
    $('#input-template-modal .select2').select2({
        dropdownParent: $('#input-template-modal')
    });
    $('#edit-template-modal .select2').select2({
        dropdownParent: $('#edit-template-modal')
    });

    // Fill modal form with button data
    $('#zero_config').on('click', '.edit-button', function() {
        const btn = $(this);
        $('#edit_idtemplate_tugas').val(btn.data('id'));
        $('#edit_nama_tugas').val(btn.data('nama'));
        $('#edit_deskripsi').val(btn.data('deskripsi'));
        $('#edit_start_date').val(btn.data('start'));
        $('#edit_end_date').val(btn.data('end'));
        $('#edit_id_jabatan').val(btn.data('jabatan')).trigger('change');
    });
});
</script>