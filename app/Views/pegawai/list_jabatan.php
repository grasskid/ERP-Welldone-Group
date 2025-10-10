<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Data Jabatan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Pegawai</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2">
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-jabatan-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="row px-4 mb-3">

        <div class="table-responsive mb-4 px-4">
            <table class="table border mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">#</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jabatan</h6>
                        </th>
                        <th width="60%">
                            <h6 class="fs-4 fw-semibold mb-0">Roles</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($jabatan as $j) : ?>
                        <tr>
                            <td>
                                <h6 class="fw-semibold mb-0"><?= $i++; ?></h6>
                            </td>
                            <td>
                                <h6 class="fw-semibold mb-0"><?= $j['NAMA_JABATAN']; ?></h6>
                            </td>
                            <td>
                                <?php
                                foreach ($j['roles'] as $r) : ?>
                                    <span class="mb-1 badge rounded-pill bg-primary-subtle text-primary"><?= $r; ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-jabatan-modal"
                                    data-id="<?= esc($j['ID_JABATAN']) ?>"
                                    data-nama_jabatan="<?= esc($j['NAMA_JABATAN']) ?>"
                                    data-roles="<?= esc($j['ROLES_JABATAN']) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button>
                                <!-- <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-kategori-modal" data-id="<?= esc($j['ID_JABATAN']) ?>">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24">
                                    </iconify-icon>
                                </button> -->
                                <!-- <button onclick="deleteJabatan(<?= $j['ID_JABATAN']; ?>)" class="btn btn-sm btn-danger">Delete</button> -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Edit Kategori -->
<div class="modal fade" id="edit-jabatan-modal" tabindex="-1" aria-labelledby="editKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editKategoriModalLabel">Edit Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pegawai/update_jabatan') ?>" method="post">
                <input hidden type="text" name="idjabatan" id="idjabatan">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Roles Akses Menu</label>
                        <select class="select2 form-control" multiple="multiple" name="roles[]" id="roles-update">
                            <?php foreach ($roles as $r) : ?>
                                <option value="<?= $r->idmenu; ?>"><?= $r->nama_menu; ?></option>
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




<!-- /.modal -->

<!-- Modal Input Jabatan -->
<div class="modal fade" id="input-jabatan-modal" tabindex="-1" aria-labelledby="inputJabatanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputJabatanModalLabel">Input Data Jabatan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pegawai/insert_jabatan') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Roles Akses Menu</label>
                        <select class="select2 form-control" multiple="multiple" name="roles[]" id="roles-select">
                            <?php foreach ($roles as $r) : ?>
                                <option value="<?= $r->idmenu; ?>"><?= $r->nama_menu; ?></option>
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

<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('#roles-select').select2({
            dropdownParent: $('#input-jabatan-modal'),
            width: '100%',
            dropdownAutoWidth: true,
        });

        $('#roles-update').select2({
            dropdownParent: $('#edit-jabatan-modal'),
            width: '100%',
            dropdownAutoWidth: true,
        });

        // Gunakan event delegation untuk DataTables
        $('#zero_config').on('click', '.edit-button', function() {
            const id = $(this).data('id');
            const namaJabatan = $(this).data('nama_jabatan');
            const roles = $(this).data('roles');

            console.log(roles);

            // Isi modal edit
            $('#edit-jabatan-modal #idjabatan').val(id);
            $('#edit-jabatan-modal #nama_jabatan').val(namaJabatan);

            // Reset select2 dan set value baru
            $('#roles-update').val(null).trigger('change');
            if (roles && roles.length > 0) {
                $('#roles-update').val(roles).trigger('change');
            }
        });
    });
</script>