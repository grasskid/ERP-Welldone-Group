<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Daftar Handphone</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Handphone</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-handphone-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="card-body px-4 pt-4 pb-2">
        <div class="table-responsive mb-4">
            <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">ID</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama Handphone</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Type</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Size</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($namahandphone)): ?>
                    <?php foreach ($namahandphone as $row): ?>
                    <tr>
                        <td><?= esc($row->id) ?></td>
                        <td><?= esc($row->nama) ?></td>
                        <td><?= esc($row->type) ?></td>
                        <td><?= esc($row->size) ?></td>
                        <td>
                            <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                data-bs-target="#edit-handphone-modal" data-id="<?= esc($row->id) ?>"
                                data-nama="<?= esc($row->nama) ?>" data-type="<?= esc($row->type) ?>"
                                data-size="<?= esc($row->size) ?>">
                                <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24">
                                </iconify-icon>
                            </button>
                            <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                data-bs-target="#delete-handphone-modal" data-id="<?= esc($row->id) ?>">
                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24">
                                </iconify-icon>
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
</div>

<!-- Modal Input Handphone -->
<div class="modal fade" id="input-handphone-modal" tabindex="-1" aria-labelledby="inputHandphoneModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputHandphoneModalLabel">Input Data Handphone</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('insert_handphone') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID Handphone</label>
                        <input type="text" class="form-control" id="id" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Handphone</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <input type="text" class="form-control" id="size" name="size" required>
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

<!-- Modal Edit Handphone -->
<div class="modal fade" id="edit-handphone-modal" tabindex="-1" aria-labelledby="editHandphoneModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editHandphoneModalLabel">Edit Data Handphone</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('update_handphone') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Handphone</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="edit_type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_size" class="form-label">Size</label>
                        <input type="text" class="form-control" id="edit_size" name="size" required>
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

<!-- Modal Delete Handphone -->
<div class="modal fade" id="delete-handphone-modal" tabindex="-1" aria-labelledby="deleteHandphoneModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="deleteHandphoneModalLabel">Delete Data Handphone</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('delete_handphone') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="id">
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
            document.getElementById('edit_id').value = button.getAttribute('data-id');
            document.getElementById('edit_nama').value = button.getAttribute('data-nama');
            document.getElementById('edit_type').value = button.getAttribute('data-type');
            document.getElementById('edit_size').value = button.getAttribute('data-size');
        }

        if (e.target.closest('.delete-button')) {
            const button = e.target.closest('.delete-button');
            document.getElementById('delete_id').value = button.getAttribute('data-id');
        }
    });
});
</script>