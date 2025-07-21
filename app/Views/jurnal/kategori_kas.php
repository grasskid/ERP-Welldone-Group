<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Kategori Kas</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kategori Kas</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2"></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-kategori-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama Kategori</th>
                    <th>Kode Template Kas</th>
                    <th>Jenis Kas</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kategorikas)): ?>
                <?php foreach ($kategorikas as $row): ?>
                <tr>
                    <td><?= esc($row->kategori) ?></td>
                    <td><?= esc($row->kode_template_jurnal) ?></td>
                    <td><?= esc($row->jenis_kas) ?></td>
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-kategori-modal" data-id="<?= esc($row->idkategori_kas) ?>"
                            data-kategori="<?= esc($row->kategori) ?>"
                            data-kode="<?= esc($row->kode_template_jurnal) ?>" data-jenis="<?= esc($row->jenis_kas) ?>">
                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                        </button>
                        <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                            data-bs-target="#delete-kategori-modal" data-id="<?= esc($row->idkategori_kas) ?>">
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

<!-- Modal Input -->
<div class="modal fade" id="input-kategori-modal" tabindex="-1" aria-labelledby="inputKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputKategoriModalLabel">Input Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('insert_kategori') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode_template_kas" class="form-label">Kode Template Jurnal</label>
                        <input type="text" class="form-control" id="kode_template_jurnal" name="kode_template_jurnal"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kas" class="form-label">Jenis Kas</label>
                        <select class="form-control" id="jenis_kas" name="jenis_kas" required>
                            <option value="">-- Pilih Jenis Kas --</option>
                            <option value="kas_masuk">Kas Masuk</option>
                            <option value="kas_keluar">Kas Keluar</option>
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

<!-- Modal Edit -->
<div class="modal fade" id="edit-kategori-modal" tabindex="-1" aria-labelledby="editKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="editKategoriModalLabel">Edit Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('update_kategori') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="edit_id" name="idkategori_kas">
                    <div class="mb-3">
                        <label for="edit_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_kategori" name="kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kode" class="form-label">Kode Template Jurnal</label>
                        <input type="text" class="form-control" id="edit_kode" name="kode_template_jurnal" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenis" class="form-label">Jenis Kas</label>
                        <select class="form-control" id="edit_jenis" name="jenis_kas" required>
                            <option value="">-- Pilih Jenis Kas --</option>
                            <option value="kas_masuk">Kas Masuk</option>
                            <option value="kas_keluar">Kas Keluar</option>
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

<!-- Modal Delete -->
<div class="modal fade" id="delete-kategori-modal" tabindex="-1" aria-labelledby="deleteKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="deleteKategoriModalLabel">Delete Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('delete_kategori') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="idkategori_kas">
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
            const btn = e.target.closest('.edit-button');
            document.getElementById('edit_id').value = btn.dataset.id;
            document.getElementById('edit_kategori').value = btn.dataset.kategori;
            document.getElementById('edit_kode').value = btn.dataset.kode;
            document.getElementById('edit_jenis').value = btn.dataset.jenis;
        }

        if (e.target.closest('.delete-button')) {
            const btn = e.target.closest('.delete-button');
            document.getElementById('delete_id').value = btn.dataset.id;
        }
    });
});
</script>