<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Kas Keluar</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Jurnal</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Kas Keluar</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2"></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-kas-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:wallet-money-line-duotone" width="24" height="24" style="margin-right: 8px;">
            </iconify-icon>Input Kas Keluar
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Penerima</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kas_keluar)): ?>
                <?php foreach ($kas_keluar as $row): ?>
                <tr>
                    <td><?= esc($row->tanggal) ?></td>
                    <td><?= esc($row->kategori) ?></td>
                    <td><?= esc($row->deskripsi) ?></td>
                    <td><?= number_format($row->jumlah, 0, ',', '.') ?></td>
                    <td><?= esc($row->penerima) ?></td>
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-kas-modal" data-id="<?= esc($row->idkas_keluar) ?>"
                            data-tanggal="<?= esc($row->tanggal) ?>"
                            data-kategori="<?= esc($row->kategori_idkategori) ?>"
                            data-deskripsi="<?= esc($row->deskripsi) ?>" data-jumlah="<?= esc($row->jumlah) ?>"
                            data-penerima="<?= esc($row->penerima) ?>">
                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                        </button>
                        <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                            data-bs-target="#delete-kas-modal" data-id="<?= esc($row->idkas_keluar) ?>">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24">
                            </iconify-icon>
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

<!-- Modal Input -->
<div class="modal fade" id="input-kas-modal" tabindex="-1" aria-labelledby="inputKasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('insert_kas_keluar') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Input Kas Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_idkategori" class="form-label">Kategori</label>
                        <select class="form-control" name="kategori_idkategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori_kas as $kat): ?>
                            <option value="<?= esc($kat->idkategori_kas) ?>"><?= esc($kat->kategori) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label for="penerima" class="form-label">Penerima</label>
                        <input type="text" class="form-control" name="penerima" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="edit-kas-modal" tabindex="-1" aria-labelledby="editKasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('update_kas_keluar') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kas Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idkas_keluar" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="edit_tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kategori" class="form-label">Kategori</label>
                        <select class="form-control" name="kategori_idkategori" id="edit_kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori_kas as $kat): ?>
                            <option value="<?= esc($kat->idkategori_kas) ?>"><?= esc($kat->kategori) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" id="edit_jumlah" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_penerima" class="form-label">Penerima</label>
                        <input type="text" class="form-control" name="penerima" id="edit_penerima" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="delete-kas-modal" tabindex="-1" aria-labelledby="deleteKasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('delete_kas_keluar') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Kas Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="idkas_keluar">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
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
            document.getElementById('edit_tanggal').value = btn.dataset.tanggal;
            document.getElementById('edit_kategori').value = btn.dataset.kategori;
            document.getElementById('edit_deskripsi').value = btn.dataset.deskripsi;
            document.getElementById('edit_jumlah').value = btn.dataset.jumlah;
            document.getElementById('edit_penerima').value = btn.dataset.penerima;
        }

        if (e.target.closest('.delete-button')) {
            const btn = e.target.closest('.delete-button');
            document.getElementById('delete_id').value = btn.dataset.id;
        }
    });
});
</script>