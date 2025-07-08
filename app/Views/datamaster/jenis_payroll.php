<!-- Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Payroll</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Payroll</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Card & Input Button -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-payroll-modal">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <!-- Table -->
    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama Payroll</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($Payroll)): ?>
                <?php foreach ($Payroll as $row): ?>
                <tr>
                    <td><?= esc($row->nama_payroll) ?></td>
                    <td><?= esc($row->status_payroll) ?></td>
                    <td><?= esc($row->keterangan) ?></td>
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-payroll-modal" data-id="<?= esc($row->idjenis_payroll) ?>"
                            data-nama="<?= esc($row->nama_payroll) ?>" data-status="<?= esc($row->status_payroll) ?>"
                            data-keterangan="<?= esc($row->keterangan) ?>">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                            data-bs-target="#delete-payroll-modal" data-id="<?= esc($row->idjenis_payroll) ?>">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Input Payroll -->
<div class="modal fade" id="input-payroll-modal" tabindex="-1" aria-labelledby="inputPayrollModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('insert_payroll') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Payroll</label>
                        <input type="text" class="form-control" name="nama_payroll" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="text" class="form-control" name="status_payroll">
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Payroll -->
<div class="modal fade" id="edit-payroll-modal" tabindex="-1" aria-labelledby="editPayrollModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('update_Payroll') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idjenis_payroll" id="edit_id">
                    <div class="mb-3">
                        <label>Nama Payroll</label>
                        <input type="text" class="form-control" name="nama_payroll" id="edit_nama">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="text" class="form-control" name="status_payroll" id="edit_status">
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="edit_keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Delete Payroll -->
<div class="modal fade" id="delete-payroll-modal" tabindex="-1" aria-labelledby="deletePayrollModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('delete_Payroll') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Payroll</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idjenis_payroll" id="delete_id">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script: Fill Modal Fields -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#zero_config').addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-button');
        const deleteBtn = e.target.closest('.delete-button');

        if (editBtn) {
            document.getElementById('edit_id').value = editBtn.getAttribute('data-id');
            document.getElementById('edit_nama').value = editBtn.getAttribute('data-nama');
            document.getElementById('edit_status').value = editBtn.getAttribute('data-status');
            document.getElementById('edit_keterangan').value = editBtn.getAttribute('data-keterangan');
        }

        if (deleteBtn) {
            document.getElementById('delete_id').value = deleteBtn.getAttribute('data-id');
        }
    });
});
</script>