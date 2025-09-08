<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Kategori Asset</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Kategori</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Asset</li>
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-kategori-asset-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kategori Asset</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>
                    <!-- <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th> -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kategori_asset)): ?>
                    <?php foreach ($kategori_asset as $row): ?>
                        <tr>

                            <td><?= esc($row->kategori_asset) ?></td>
                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-kategori-asset-modal"
                                    data-idkategori_asset="<?= esc($row->idkategori_asset) ?>"
                                    data-kategori_asset="<?= esc($row->kategori_asset) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button>
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-kategori-asset-modal" data-idkategori_asset="<?= esc($row->idkategori_asset) ?>">
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
<div class="modal fade" id="edit-kategori-asset-modal" tabindex="-1" aria-labelledby="editkategori-assetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editkategori-assetModalLabel">Edit Data Kategori Asset</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('update_kategori_asset') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input hidden type="text" class="form-control" id="edit_id_kategori_asset" name="id_kategori_asset" required>
                        <label for="edit_kategori_asset" class="form-label">Kategori Asset</label>
                        <input type="text" class="form-control" id="edit_kategori_asset" name="kategori_asset" required>
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
<div class="modal fade" id="input-kategori-asset-modal" tabindex="-1" aria-labelledby="inputkategori-assetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputkategori-assetModalLabel">Input Data Kategori Asset</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('insert_kategori_asset') ?>" method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="kategori_asset" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="kategori_asset" name="kategori_asset" required>
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
<div class="modal fade" id="delete-kategori-asset-modal" tabindex="-1" aria-labelledby="deletekategori-assetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="deletekategori-assetModalLabel">Delete Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('delete_kategori_asset') ?>" method="post">
                <div class="modal-body">
                    <input hidden id="delete_id_kategori_asset" name="id_kategori_asset">
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
                const id = button.getAttribute('data-idkategori_asset');

                const nama_kategori = button.getAttribute('data-kategori_asset');
                document.getElementById('edit_id_kategori_asset').value = id;

                document.getElementById('edit_kategori_asset').value = nama_kategori;
            }

            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                const id = button.getAttribute('data-idkategori_asset');
                document.getElementById('delete_id_kategori_asset').value = id;
            }
        });
    });
</script>