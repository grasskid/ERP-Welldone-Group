<!-- Breadcrumb -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Pelanggan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Pelanggan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Card -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="px-4 py-3 border-bottom d-flex justify-content-between">
        <div class="d-flex gap-2">
            <a href="<?= base_url('export/pelanggan') ?>" class="btn btn-danger"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon> Export
            </a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#samedata-modal"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:import-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Import
            </button>
            <a href="<?php echo base_url('format_excell/format_pelanggan.xlsx') ?>"><button type="button"
                    class="btn btn-success" style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:download-broken" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>
                    Download Format Excell
                </button></a>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-pelanggan-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>NIK</th>
                    <th>Nomer HP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pelanggan)): ?>
                    <?php foreach ($pelanggan as $row): ?>
                        <tr>
                            <td><?= esc($row->nama) ?></td>
                            <td><?= esc($row->alamat) ?></td>
                            <td><?= esc($row->nik) ?></td>
                            <td><?= esc($row->no_hp) ?></td>
                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-pelanggan-modal" data-id_pelanggan="<?= esc($row->id_pelanggan) ?>"
                                    data-nama="<?= esc($row->nama) ?>" data-alamat="<?= esc($row->alamat) ?>"
                                    data-nik="<?= esc($row->nik) ?>" data-no_hp="<?= esc($row->no_hp) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button>
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-pelanggan-modal" data-id_pelanggan="<?= esc($row->id_pelanggan) ?>">
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

<!-- Modal Input Pelanggan -->
<div class="modal fade" id="input-pelanggan-modal" tabindex="-1" aria-labelledby="inputPelangganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('insert_pelanggan') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="inputPelangganModalLabel">Input Data Pelanggan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label>NIK</label><input type="text" class="form-control" name="nik" required>
                    </div>
                    <div class="mb-3"><label>Nama</label><input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3"><label>Alamat</label><input type="text" class="form-control" name="alamat"
                            required></div>

                    <div class="mb-3"><label>Nomor HP</label><input type="text" class="form-control" name="no_hp"
                            required></div>
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


<!-- //modal -->
<div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="exampleModalLabel1">
                    Import File Excell
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('import/pelanggan') ?>" enctype="multipart/form-data" method="post">
                    <div class="mb-3">
                        <label for="recipient-name" class="control-label">file:</label>
                        <input type="File" class="form-control" name="file" id="recipient-name1" />
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger " data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-success">
                    Submit
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->


<!-- Modal Alert Sukses -->


<!-- /.modal -->

<!-- Modal Edit Pelanggan -->
<div class="modal fade" id="edit-pelanggan-modal" tabindex="-1" aria-labelledby="editPelangganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('update_pelanggan') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPelangganModalLabel">Edit Data Pelanggan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pelanggan" id="edit-id_pelanggan">
                    <div class="mb-3"><label>Nama</label><input type="text" class="form-control" name="nama"
                            id="edit-nama" required></div>
                    <div class="mb-3"><label>Alamat</label><input type="text" class="form-control" name="alamat"
                            id="edit-alamat" required></div>
                    <div class="mb-3"><label>NIK</label><input type="text" class="form-control" name="nik" id="edit-nik"
                            required></div>
                    <div class="mb-3"><label>Nomor HP</label><input type="text" class="form-control" name="no_hp"
                            id="edit-no_hp" required></div>
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

<!-- Modal Delete Pelanggan -->
<div class="modal fade" id="delete-pelanggan-modal" tabindex="-1" aria-labelledby="deletePelangganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('delete_pelanggan') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="deletePelangganModalLabel">Delete Data Pelanggan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="delete-id_pelanggan" hidden name="id_pelanggan">
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

<!-- JavaScript to Handle Edit/Delete -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#zero_config').addEventListener('click', function(e) {
            if (e.target.closest('.edit-button')) {
                const button = e.target.closest('.edit-button');
                document.getElementById('edit-id_pelanggan').value = button.getAttribute(
                    'data-id_pelanggan');
                document.getElementById('edit-nama').value = button.getAttribute('data-nama');
                document.getElementById('edit-alamat').value = button.getAttribute('data-alamat');
                document.getElementById('edit-nik').value = button.getAttribute('data-nik');
                document.getElementById('edit-no_hp').value = button.getAttribute('data-no_hp');
            }
            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                document.getElementById('delete-id_pelanggan').value = button.getAttribute(
                    'data-id_pelanggan');
            }
        });
    });
</script>