<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Nomor Akun</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Nomor Akun</li>
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-noakun-modal"
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
                        <h6 class="fs-4 fw-semibold mb-0">Nomor Akun</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Akun</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Jenis Akun</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php if (!empty($noakun)): ?>
                    <?php foreach ($noakun as $row): ?>
                        <tr>
                            <td><?= esc($row->no_akun) ?></td>
                            <td><?= esc($row->nama_akun) ?></td>
                            <td><?= esc($row->jenis_akun) ?></td>
                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-noakun-modal"
                                    data-no_akun="<?= esc($row->no_akun) ?>"
                                    data-nama_akun="<?= esc($row->nama_akun) ?>"
                                    data-jenis_akun="<?= esc($row->jenis_akun) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
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

<!-- Modal Edit no akun -->
<div class="modal fade" id="edit-noakun-modal" tabindex="-1" aria-labelledby="editnoakunModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editnoakunModalLabel">Edit Data noakun</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('update_noakun') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input hidden type="text" class="form-control" id="edit_noakun" name="noakun" required>
                        <label for="edit_nama_noakun" class="form-label">Nama Nomor Akun</label>
                        <input type="text" class="form-control" id="edit_nama_noakun" name="nama_noakun" required>
                    </div>
                    <div class="mb-3">

                        <label for="edit_jenis_noakun" class="form-label">Jenis Nomor Akun</label>
                        <input type="text" class="form-control" id="edit_jenis_noakun" name="jenis_noakun" required>
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

<!-- Modal Input noakun -->
<div class="modal fade" id="input-noakun-modal" tabindex="-1" aria-labelledby="inputnoakunModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputnoakunModalLabel">Input Data Nomor Akun</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('insert_noakun') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="no_akun" class="form-label">Nomor Akun</label>
                        <input type="text" class="form-control" id="no_akun" name="no_akun" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_akun" class="form-label">Nama Akun</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_akun" class="form-label">Jenis Akun</label>
                        <input type="text" class="form-control" id="jenis_akun" name="jenis_akun" required>
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
                const no_akun = button.getAttribute('data-no_akun');
                const nama_noakun = button.getAttribute('data-nama_akun');
                const jenis_akun = button.getAttribute('data-jenis_akun');

                document.getElementById('edit_noakun').value = no_akun
                document.getElementById('edit_nama_noakun').value = nama_noakun;
                document.getElementById('edit_jenis_noakun').value = jenis_akun;
            }


        });
    });
</script>