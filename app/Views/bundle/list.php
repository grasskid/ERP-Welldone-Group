<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Bundle</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Bundle</li>
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
        <a href="<?php echo base_url('input_bundle') ?>">
            <button type="button" class="btn btn-primary"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                    style="margin-right: 8px;"></iconify-icon>Input
            </button>
        </a>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Bundle</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Harga Total</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Harga Jual</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bundle)): ?>
                    <?php foreach ($bundle as $row): ?>
                        <tr>

                            <td><?= esc($row->nama_bundle) ?></td>
                            <td>Rp <?= number_format($row->harga_total, 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($row->harga_jual, 0, ',', '.') ?></td>

                            <td>
                                <a href="<?php echo base_url('edit_bundle/' . $row->idbundle) ?>">
                                    <button type="button" class="btn btn-warning edit-button">
                                        <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-kerusakan-modal" data-idbundle="<?= esc($row->idbundle) ?>">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24">
                                    </iconify-icon>
                                </button>
                            </td>
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

<!-- Modal Edit Kategori -->
<!-- <div class="modal fade" id="edit-kerusakan-modal" tabindex="-1" aria-labelledby="editKerusakanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editKerusakanModalLabel">Edit Data Kerusakan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('update_kerusakan') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input hidden type="text" class="form-control" id="edit_id_kerusakan" name="id_kerusakan" required>
                        <label for="edit_nama_kerusakan" class="form-label">Nama Kerusakan</label>
                        <input type="text" class="form-control" id="edit_nama_kerusakan" name="nama_kerusakan" required>
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
</div> -->




<!-- /.modal -->






<!-- Modal Delete Kategori -->
<div class="modal fade" id="delete-kerusakan-modal" tabindex="-1" aria-labelledby="deleteKerusakanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="deleteKerusakanModalLabel">Delete Data Bundle</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('delete_bundle') ?>" method="post">
                <div class="modal-body">
                    <input hidden id="delete_id_bundle" name="idbundle">
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


            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                const idbundle = button.getAttribute('data-idbundle');
                document.getElementById('delete_id_bundle').value = idbundle;
            }
        });
    });
</script>

<script>

</script>