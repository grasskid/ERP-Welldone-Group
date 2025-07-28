<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Penilaian KPI</h4>
        <div class="d-flex">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-penilaian-modal"
                style="display: inline-flex; align-items: center; height: 50px;">
                <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                    style="margin-right: 8px;"></iconify-icon>
                Input
            </button>
        </div>
    </div>
</div>

<div class="card shadow-none position-relative overflow-hidden">
    <div class="card-body">
        <div class="table-responsive">
            <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Nama Pegawai</th>
                        <th>KPI Utama</th>
                        <th>Bobot</th>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th>Score</th>
                        <th>Tanggal Penilaian</th>
                        <th>Terakhir Diperbarui</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penilaiankpi)): ?>
                    <?php foreach ($penilaiankpi as $row): ?>
                    <tr>
                        <td><?= esc($row->NAMA_AKUN ?? '-') ?></td>
                        <td><?= esc($row->kpi_utama) ?></td>
                        <td><?= esc($row->bobot) ?></td>
                        <td><?= esc($row->target) ?></td>
                        <td><?= esc($row->realisasi) ?></td>
                        <td><?= esc($row->score) ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($row->tanggal_penilaian_kpi))) ?></td>
                        <td><?= $row->updated_on ? esc(date('d-m-Y', strtotime($row->updated_on))) : '-' ?></td>
                        <td>
                            <button class="btn btn-warning edit-button" data-bs-toggle="modal"
                                data-bs-target="#edit-penilaian-modal" data-id="<?= $row->idpenilaian_kpi ?>"
                                data-kpi_utama="<?= esc($row->kpi_utama) ?>" data-bobot="<?= esc($row->bobot) ?>"
                                data-target="<?= esc($row->target) ?>" data-realisasi="<?= esc($row->realisasi) ?>"
                                data-score="<?= esc($row->score) ?>" data-pegawai_id="<?= $row->pegawai_idpegawai ?>"
                                data-tanggal="<?= $row->tanggal_penilaian_kpi ?>">
                                <i class="ti ti-pencil"></i>
                            </button>

                            <button class="btn btn-danger delete-button" data-bs-toggle="modal"
                                data-bs-target="#delete-penilaian-modal" data-id="<?= $row->idpenilaian_kpi ?>">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="input-penilaian-modal" tabindex="-1" aria-labelledby="inputPenilaianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('insert_penilaian') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penilaian KPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">KPI Utama</label>
                    <input type="text" class="form-control" name="kpi_utama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bobot</label>
                    <input type="number" class="form-control" name="bobot" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Target</label>
                    <input type="text" class="form-control" name="target" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Realisasi</label>
                    <input type="text" class="form-control" name="realisasi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Score</label>
                    <input type="number" class="form-control" name="score" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pegawai</label>
                    <select class="form-select select2" name="pegawai_idpegawai" required>
                        <option value="">-- Pilih Pegawai --</option>
                        <?php foreach ($akun as $a): ?>
                        <option value="<?= $a->ID_AKUN ?>"><?= $a->NAMA_AKUN ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Penilaian</label>
                    <input type="date" class="form-control" name="tanggal_penilaian_kpi" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="edit-penilaian-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('update_penilaian') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Penilaian KPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="idpenilaian_kpi" id="edit-idpenilaian">
                <div class="mb-3">
                    <label class="form-label">KPI Utama</label>
                    <input type="text" class="form-control" name="kpi_utama" id="edit-kpi_utama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bobot</label>
                    <input type="number" class="form-control" name="bobot" id="edit-bobot" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Target</label>
                    <input type="text" class="form-control" name="target" id="edit-target" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Realisasi</label>
                    <input type="text" class="form-control" name="realisasi" id="edit-realisasi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Score</label>
                    <input type="number" class="form-control" name="score" id="edit-score" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pegawai</label>
                    <select class="form-select select2" name="pegawai_idpegawai" id="edit-pegawai_idpegawai" required>
                        <?php foreach ($akun as $a): ?>
                        <option value="<?= $a->ID_AKUN ?>"><?= $a->NAMA_AKUN ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Penilaian</label>
                    <input type="date" class="form-control" name="tanggal_penilaian_kpi" id="edit-tanggal_penilaian_kpi"
                        required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="delete-penilaian-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('delete_penilaian') ?>" method="post" class="modal-content">
            <div class="modal-body text-center">
                <input type="hidden" name="idpenilaian_kpi" id="delete-id_penilaian">
                <h5 class="mt-2">Yakin ingin menghapus penilaian ini?</h5>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
document.querySelector('#zero_config').addEventListener('click', function(e) {
    const editBtn = e.target.closest('.edit-button');
    if (editBtn) {
        document.querySelector('#edit-idpenilaian').value = editBtn.dataset.id;
        document.querySelector('#edit-kpi_utama').value = editBtn.dataset.kpi_utama;
        document.querySelector('#edit-bobot').value = editBtn.dataset.bobot;
        document.querySelector('#edit-target').value = editBtn.dataset.target;
        document.querySelector('#edit-realisasi').value = editBtn.dataset.realisasi;
        document.querySelector('#edit-score').value = editBtn.dataset.score;
        document.querySelector('#edit-tanggal_penilaian_kpi').value = editBtn.dataset.tanggal;
        setTimeout(() => {
            $('#edit-pegawai_idpegawai').val(editBtn.dataset.pegawai_id).trigger('change');
        }, 200);
    }

    const deleteBtn = e.target.closest('.delete-button');
    if (deleteBtn) {
        document.querySelector('#delete-id_penilaian').value = deleteBtn.dataset.id;
    }
});
</script>