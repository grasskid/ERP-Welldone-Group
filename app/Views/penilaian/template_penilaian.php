<!-- Breadcrumb -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Template Penilaian</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Template</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Penilaian</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Card -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="px-4 py-3 border-bottom d-flex justify-content-between">
        <div class="d-flex gap-2">

        </div>
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-penilaian-modal"
            style="display: inline-flex; align-items: center; height: 50px;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>
            Input
        </button> -->

    </div>

    <br>
    <div class="mb-3 ">
        <br>



    </div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Aspek</th>
                    <th>Keterangan</th>
                    <th>Jabatan</th>
                    <th>Aspek KPI</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($penilaian)): ?>
                <?php foreach ($penilaian as $row): ?>
                <tr>
                    <td><?= esc($row->aspek_penilaian) ?></td>
                    <td><?= esc($row->keterangan_penilaian) ?></td>
                    <td><?= esc($row->jabatan) ?></td>
                    <td><?= esc($row->aspek_kpi) ?></td>
                    <!-- <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-penilaian-modal"
                                    data-idtemplate_penilaian="<?= esc($row->idtemplate_penilaian) ?>"
                                    data-aspek_penilaian="<?= esc($row->aspek_penilaian) ?>"
                                    data-keterangan_penilaian="<?= esc($row->keterangan_penilaian) ?>"
                                    data-jabatan="<?= esc($row->jabatan) ?>"
                                    data-idtemplate_kpi="<?= esc($row->idtemplate_kpi) ?>"
                                    data-aspek_kpi="<?= esc($row->aspek_kpi) ?>"
                                    data-jabatan_idjabatan="<?= esc($row->jabatan_idjabatan) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button>


                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-penilaian-modal" data-idtemplate_penilaian="<?= esc($row->idtemplate_penilaian) ?>">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24"></iconify-icon>
                                </button>
                            </td> -->
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<!-- Modal Input penilaian -->
<div class="modal fade" id="input-penilaian-modal" tabindex="-1" aria-labelledby="inputPenilaianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('insert_template_penilaian') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="inputPenilaianModalLabel">Input Data Penilaian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="aspek" class="form-label">Aspek Penilaian</label>
                        <input type="text" class="form-control" name="aspek" id="aspek" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan_idjabatan" class="form-label">Jabatan</label>
                        <select class="form-select" name="jabatan_idjabatan" id="input-jabatan_idjabatan" required>
                            <option value="" disabled>-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $row): ?>
                            <option value="<?= esc($row->ID_JABATAN) ?>">
                                <?= esc($row->NAMA_JABATAN) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                    </div>


                    <select class="form-select" name="aspek_kpi" id="aspek_kpi" required>
                        <option value="" disabled selected>-- Pilih Aspek KPI --</option>
                        <?php foreach ($template as $row): ?>
                        <option value="<?= esc($row->idtemplate_kpi) ?>"
                            data-jabatan-id="<?= esc($row->jabatan_idjabatan) ?>">
                            <?= esc($row->template_kpi) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>


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



<!-- Modal Edit penilaian -->
<div class="modal fade" id="edit-penilaian-modal" tabindex="-1" aria-labelledby="editPenilaianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('update_template_penilaian') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPenilaianModalLabel">Edit Data Penilaian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input hidden name="idtemplate_penilaian" id="edit-idtemplate_penilaian">

                    <div class="mb-3">
                        <label for="edit-aspek" class="form-label">Aspek Penilaian</label>
                        <input type="text" class="form-control" name="aspek" id="edit-aspek" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="edit-keterangan" rows="3"></textarea>
                    </div>


                    <div class="mb-3">
                        <select class=" form-control" name="jabatan_idjabatan" id="edit-jabatan_idjabatan" required>
                            <option value="" disabled>-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $row): ?>
                            <option value="<?= esc($row->ID_JABATAN) ?>">
                                <?= esc($row->NAMA_JABATAN) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <select class="form-select" name="aspek_kpi" id="edit-aspek_kpi" required>
                            <option value="" disabled selected>-- Pilih Aspek KPI --</option>
                            <?php foreach ($template as $row): ?>
                            <option value="<?= esc($row->idtemplate_kpi) ?>"
                                data-jabatan-id="<?= esc($row->jabatan_idjabatan) ?>">
                                <?= esc($row->template_kpi) ?>
                            </option>
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



<!-- Modal Delete penilaian -->
<div class="modal fade" id="delete-penilaian-modal" tabindex="-1" aria-labelledby="deletepenilaianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('delete_template_penilaian') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="deletepenilaianModalLabel">Delete Data penilaian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input hidden id="delete-idtemplate_penilaian" name="idtemplate_penilaian">
                    <p style="font-style: italic;">Apa Anda yakin ingin menghapus data ini?</p>
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

<!-- Modal Import -->
<div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="exampleModalLabel1">Import File Excell</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('import/penilaian') ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="control-label">File:</label>
                        <input type="file" class="form-control" name="file" id="recipient-name1" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Edit/Delete Modal -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editJabatanSelect = document.getElementById('edit-jabatan_idjabatan');
    const editAspekKpiSelect = document.getElementById('edit-aspek_kpi');


    const originalAspekKpiOptions = Array.from(editAspekKpiSelect.querySelectorAll('option'))
        .filter(opt => opt.value);

    window.filterEditAspekKpi = function(jabatanId, selectedKpiId = null) {

        editAspekKpiSelect.innerHTML = '<option value="" disabled>-- Pilih Aspek KPI --</option>';


        originalAspekKpiOptions.forEach(opt => {
            if (opt.dataset.jabatanId === jabatanId) {
                editAspekKpiSelect.appendChild(opt.cloneNode(true));
            }
        });


        if (selectedKpiId) {
            editAspekKpiSelect.value = selectedKpiId;
        }


        if ($(editAspekKpiSelect).hasClass('select2')) {
            $(editAspekKpiSelect).trigger('change');
        }
    }


    editJabatanSelect.addEventListener('change', function() {
        filterEditAspekKpi(this.value);
    });


    document.querySelector('#zero_config').addEventListener('click', function(e) {
        if (e.target.closest('.edit-button')) {
            const button = e.target.closest('.edit-button');

            const idPenilaian = button.getAttribute('data-idtemplate_penilaian');
            const aspek = button.getAttribute('data-aspek_penilaian');
            const keterangan = button.getAttribute('data-keterangan_penilaian');
            const jabatanId = button.getAttribute('data-jabatan_idjabatan');
            const aspekKpiId = button.getAttribute('data-idtemplate_kpi');

            document.getElementById('edit-idtemplate_penilaian').value = idPenilaian;
            document.getElementById('edit-aspek').value = aspek;
            document.getElementById('edit-keterangan').value = keterangan;


            editJabatanSelect.value = jabatanId;
            $('#edit-jabatan_idjabatan').val(jabatanId).trigger('change');


            filterEditAspekKpi(jabatanId, aspekKpiId);
        }

        if (e.target.closest('.delete-button')) {
            const button = e.target.closest('.delete-button');
            document.getElementById('delete-idtemplate_penilaian').value = button.getAttribute(
                'data-idtemplate_penilaian');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jabatanSelect = document.getElementById('input-jabatan_idjabatan');
    const aspekKpiSelect = document.getElementById('aspek_kpi');
    const allAspekKpiOptions = Array.from(aspekKpiSelect.options).filter(opt => opt.value); // skip default

    function filterAspekKpi(jabatanId) {

        aspekKpiSelect.innerHTML = '<option value="" disabled selected>-- Pilih Aspek KPI --</option>';


        allAspekKpiOptions.forEach(opt => {
            if (opt.dataset.jabatanId === jabatanId) {
                aspekKpiSelect.appendChild(opt);
            }
        });

        t2
        if ($(aspekKpiSelect).hasClass("select2")) {
            $(aspekKpiSelect).val(null).trigger('change');
        }
    }

    jabatanSelect.addEventListener('change', function() {
        const selectedJabatanId = this.value;
        filterAspekKpi(selectedJabatanId);
    });
});
</script>