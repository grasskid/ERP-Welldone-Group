<!-- Breadcrumb -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Template KPI</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Template</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">KPI</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Card -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom d-flex justify-content-between">
        <div class="d-flex gap-2"></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-kpi-modal"
            style="display: inline-flex; align-items: center; height: 50px;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>
            Input
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Indikator KPI</th>
                    <th>Bobot</th>
                    <th>Formula</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($templatekpi)): ?>
                <?php foreach ($templatekpi as $row): ?>
                <tr>
                    <td><?= esc($row->template_kpi) ?></td>
                    <td><?= esc($row->bobot) ?>%</td>
                    <td><?= esc($row->formula) ?></td>
                    <td>
                        <?php
                                    foreach ($jabatan as $j) {
                                        if ($j->ID_JABATAN == $row->jabatan_idjabatan) {
                                            echo esc($j->NAMA_JABATAN);
                                            break;
                                        }
                                    }
                                ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                            data-bs-target="#edit-kpi-modal" data-id="<?= esc($row->idtemplate_kpi) ?>"
                            data-template_kpi="<?= esc($row->template_kpi) ?>" data-bobot="<?= esc($row->bobot) ?>"
                            data-formula="<?= esc($row->formula) ?>"
                            data-jabatan_id="<?= esc($row->jabatan_idjabatan) ?>">
                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                        </button>

                        <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                            data-bs-target="#delete-kpi-modal" data-id="<?= esc($row->idtemplate_kpi) ?>">
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

<!-- Input Modal -->
<div class="modal fade" id="input-kpi-modal" tabindex="-1" aria-labelledby="inputKPIModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('templatekpi/insert') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data KPI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Template KPI</label>
                        <input type="text" name="template_kpi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Bobot (%)</label>
                        <input type="number" name="bobot" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Formula</label>
                        <textarea name="formula" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="jabatan_idjabatan" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $j): ?>
                            <option value="<?= esc($j->ID_JABATAN) ?>"><?= esc($j->NAMA_JABATAN) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="level" placeholder="1">
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

<!-- Edit Modal -->
<div class="modal fade" id="edit-kpi-modal" tabindex="-1" aria-labelledby="editKPIModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('templatekpi/update') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data KPI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idtemplate_kpi" id="edit-id">
                    <div class="mb-3">
                        <label>Template KPI</label>
                        <input type="text" name="template_kpi" id="edit-template_kpi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Bobot (%)</label>
                        <input type="number" name="bobot" id="edit-bobot" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Formula</label>
                        <textarea name="formula" id="edit-formula" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan</label>
                        <select name="jabatan_idjabatan" id="edit-jabatan" class="form-select" required>
                            <option value="" disabled>-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $j): ?>
                            <option value="<?= esc($j->ID_JABATAN) ?>"><?= esc($j->NAMA_JABATAN) ?></option>
                            <?php endforeach; ?>
                        </select>
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

<!-- Delete Modal -->
<div class="modal fade" id="delete-kpi-modal" tabindex="-1" aria-labelledby="deleteKPIModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('templatekpi/delete') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data KPI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idtemplate_kpi" id="delete-id">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
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
    const editModal = document.getElementById('edit-kpi-modal');
    const deleteModal = document.getElementById('delete-kpi-modal');

    document.querySelector('#zero_config').addEventListener('click', function(e) {
        if (e.target.closest('.edit-button')) {
            const btn = e.target.closest('.edit-button');
            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-template_kpi').value = btn.dataset.template_kpi;
            document.getElementById('edit-bobot').value = btn.dataset.bobot;
            document.getElementById('edit-formula').value = btn.dataset.formula;
            document.getElementById('edit-jabatan').value = btn.dataset.jabatan_id;
        }

        if (e.target.closest('.delete-button')) {
            document.getElementById('delete-id').value = e.target.closest('.delete-button').dataset.id;
        }
    });
});
</script>