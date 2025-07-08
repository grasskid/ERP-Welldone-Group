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

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2"></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-template-modal">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Tugas</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Deskripsi</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Mulai</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Selesai</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>
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
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-template-modal" data-id="<?= esc($row->idtemplate_tugas) ?>"
                            data-nama="<?= esc($row->nama_tugas) ?>" data-deskripsi="<?= esc($row->deskripsi) ?>"
                            data-start="<?= esc($row->start_date) ?>" data-end="<?= esc($row->end_date) ?>">
                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Input Template Tugas -->
<div class="modal fade" id="input-template-modal" tabindex="-1" aria-labelledby="inputTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('insert_tugas_template') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputTemplateModalLabel">Input Template Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_tugas" class="form-label">Nama Tugas</label>
                        <input type="text" class="form-control" name="nama_tugas" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <!-- You can add ID_JABATAN field here if needed -->
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

<!-- Modal Edit Template Tugas -->
<div class="modal fade" id="edit-template-modal" tabindex="-1" aria-labelledby="editTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('update_tugas_template') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTemplateModalLabel">Edit Template Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idtemplate_tugas" id="edit_idtemplate_tugas">
                    <div class="mb-3">
                        <label for="edit_nama_tugas" class="form-label">Nama Tugas</label>
                        <input type="text" class="form-control" name="nama_tugas" id="edit_nama_tugas" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="2"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" id="edit_start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" id="edit_end_date" required>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#zero_config').addEventListener('click', function(e) {
        const button = e.target.closest('.edit-button');
        if (button) {
            document.getElementById('edit_idtemplate_tugas').value = button.getAttribute('data-id');
            document.getElementById('edit_nama_tugas').value = button.getAttribute('data-nama');
            document.getElementById('edit_deskripsi').value = button.getAttribute('data-deskripsi');
            document.getElementById('edit_start_date').value = button.getAttribute('data-start');
            document.getElementById('edit_end_date').value = button.getAttribute('data-end');
        }
    });
});
</script>