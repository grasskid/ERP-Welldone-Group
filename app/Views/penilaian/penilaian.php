<!-- Breadcrumb -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0"> Penilaian</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>"></a>
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
            <form action="<?php echo base_url('export_penilaian') ?>" method="post" enctype="multipart/form-data">
                <button type="submit" class="btn btn-danger"
                    style="margin-left: 20px; display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>
                    Export
                </button>
                <br><br>
                <label class="ms-3 me-2">Tanggal Awal:</label>
                <input name="tanggal_awal" type="date" id="startDate" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">

                <label class="ms-3 me-2">Tanggal Akhir:</label>
                <input name="tanggal_akhir" type="date" id="endDate" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">

                <button type="button" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
            </form>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-penilaian-modal"
            style="display: inline-flex; align-items: center; height: 50px;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>
            Input
        </button>

    </div>

    <br>
    <div class="mb-3 ">
        <br>



    </div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Aspek</th>
                    <th>Keterangan</th>
                    <th>Skor</th>
                    <th>Tanggal Penilaian</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($penilaian)): ?>
                <?php foreach ($penilaian as $row): ?>
                <tr>
                    <td><?= esc($row->NAMA_AKUN) ?></td>
                    <td><?= esc($row->aspek) ?></td>
                    <td><?= esc($row->keterangan) ?></td>
                    <td><?= esc($row->skor) ?></td>
                    <td><?= esc(date('d-m-Y', strtotime($row->tanggal_penilaian))) ?></td>


                    <td>
                        <!-- <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-penilaian-modal" data-idpenilaian="<?= esc($row->idpenilaian) ?>"
                                    data-aspek="<?= esc($row->aspek) ?>" data-keterangan="<?= esc($row->keterangan) ?>"
                                    data-skor="<?= esc($row->skor) ?>"
                                    data-pegawai_idpegawai="<?= esc($row->pegawai_idpegawai) ?>"
                                    data-nama_pegawai="<?= esc($row->NAMA_AKUN) ?>"
                                    data-tanggal_penilaian="<?= esc($row->tanggal_penilaian) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button> -->


                        <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                            data-bs-target="#delete-penilaian-modal" data-idpenilaian="<?= esc($row->idpenilaian) ?>">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24">
                            </iconify-icon>
                        </button>
                    </td>
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
            <form action="<?= base_url('insert_penilaian') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="inputPenilaianModalLabel">Input Data Penilaian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Top: Pegawai & Tanggal -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pegawai_idpegawai" class="form-label">Pegawai</label>
                                <select class="form-select select2" name="pegawai_idpegawai"
                                    id="input-pegawai_idpegawai" required>
                                    <option value="" disabled selected>-- Pilih Pegawai --</option>
                                    <?php foreach ($akun as $row): ?>
                                    <option data-idjabatan="<?= esc($row->ID_JABATAN) ?>"
                                        value="<?= esc($row->ID_AKUN) ?>">
                                        <?= esc($row->NAMA_AKUN) ?> : <?= esc($row->NAMA_JABATAN) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                                <input type="date" class="form-control" name="tanggal_penilaian" id="tanggal_penilaian"
                                    required>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-md-6 slider-container"></div>

                        <div class="col-md-6 input-container"></div>
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



<!-- Modal Edit penilaian -->
<!-- <div class="modal fade" id="edit-penilaian-modal" tabindex="-1" aria-labelledby="editPenilaianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('update_penilaian') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPenilaianModalLabel">Edit Data Penilaian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="idpenilaian" id="edit-idpenilaian">

                    <div class="mb-3">
                        <label for="edit-aspek" class="form-label">Aspek Penilaian</label>
                        <input type="text" class="form-control" name="aspek" id="edit-aspek" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="edit-keterangan" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-skor" class="form-label">Skor</label>
                        <input type="number" class="form-control" name="skor" id="edit-skor" required>
                    </div>

                    <select class="select2 form-control" name="pegawai_idpegawai" id="edit-pegawai_idpegawai" required>
                        <option value="" disabled>-- Pilih Pegawai --</option>
                        <?php foreach ($akun as $row): ?>
                            <option value="<?= esc($row->ID_AKUN) ?>">
                                <?= esc($row->NAMA_AKUN) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                    <div class="mb-3">
                        <label for="edit-tanggal_penilaian" class="form-label">Tanggal Penilaian</label>
                        <input type="date" class="form-control" name="tanggal_penilaian" id="edit-tanggal_penilaian"
                            required>
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
</div> -->



<!-- Modal Delete penilaian -->
<div class="modal fade" id="delete-penilaian-modal" tabindex="-1" aria-labelledby="deletepenilaianModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('delete_penilaian') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="deletepenilaianModalLabel">Delete Data penilaian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input hidden id="delete-id_penilaian" name="id_penilaian">
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


    $('#input-penilaian-modal').on('shown.bs.modal', function() {

        $(this).find('.select2').select2({
            dropdownParent: $('#input-penilaian-modal'),
            width: '100%',
            placeholder: 'Pilih Pegawai',
            allowClear: true
        });
    });


    document.querySelector('#zero_config').addEventListener('click', function(e) {
        const editBtn = e.target.closest('.edit-button');
        if (editBtn) {

            $('.select2').select2({
                dropdownParent: $('#edit-penilaian-modal')
            });

            document.getElementById('edit-idpenilaian').value = editBtn.getAttribute(
                'data-idpenilaian');
            document.getElementById('edit-aspek').value = editBtn.getAttribute('data-aspek');
            document.getElementById('edit-keterangan').value = editBtn.getAttribute('data-keterangan');
            document.getElementById('edit-skor').value = editBtn.getAttribute('data-skor');
            document.getElementById('edit-tanggal_penilaian').value = editBtn.getAttribute(
                'data-tanggal_penilaian');


            const pegawaiId = editBtn.getAttribute('data-pegawai_idpegawai');


            setTimeout(function() {
                $('#edit-pegawai_idpegawai').val(pegawaiId).trigger('change');
            }, 200);
        }

        const deleteBtn = e.target.closest('.delete-button');
        if (deleteBtn) {
            document.getElementById('delete-id_penilaian').value = deleteBtn.getAttribute(
                'data-idpenilaian');
        }
    });
});
</script>


<script>
window.onload = function() {
    const endDateInput = document.getElementById('endDate');
    const startDateInput = document.getElementById('startDate');

    const today = new Date();
    const fifteenDaysAgo = new Date();
    fifteenDaysAgo.setDate(today.getDate() - 15);


    const toDateInputValue = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    startDateInput.value = toDateInputValue(fifteenDaysAgo);
    endDateInput.value = toDateInputValue(today);



    filterData();
};

function filterData() {
    const start = document.getElementById('startDate').value;
    const end = document.getElementById('endDate').value;


    const rows = document.querySelectorAll('#zero_config tbody tr');
    rows.forEach(row => {
        const dateCell = row.children[4];
        if (!dateCell) return;

        const dateText = dateCell.textContent.trim();
        const parts = dateText.split('-');
        const rowDate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`);

        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        let dateMatch = true;
        if (startDate && rowDate < startDate) dateMatch = false;
        if (endDate && rowDate > endDate) dateMatch = false;

        row.style.display = (dateMatch) ? '' : 'none';
    });
}

function resetFilter() {
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';

    filterData();
}
</script>

<script>
$(document).ready(function() {
    $('#input-pegawai_idpegawai').on('select2:select', function(e) {
        console.log('Dropdown select2 triggered');

        const idJabatan = $('#input-pegawai_idpegawai').find(':selected').data('idjabatan');
        console.log('ID Jabatan:', idJabatan);
        console.log('ID Jabatan:', idJabatan);

        // AJAX panggil template dari server
        $.ajax({
            url: `/penilaian/get_template_by_jabatan/${idJabatan}`,
            type: 'GET',
            success: function(res) {
                console.log('Template untuk jabatan:', res);
                renderFormPenilaian(res);
            },
            error: function(xhr, status, err) {
                console.error('Gagal mengambil data:', err);
            }
        });
    });

    function renderFormPenilaian(template) {
        const sliderContainer = $('.slider-container').empty(); // buat <div class="slider-container"> di HTML
        const inputContainer = $('.input-container').empty(); // buat <div class="input-container"> di HTML
        const jumlahMap = <?= json_encode($jumlahMap) ?>;
        const groupedSlider = {};
        const groupedInput = {};

        template.forEach(row => {
            if (row.status == 1) {
                if (!groupedSlider[row.aspek_kpi]) {
                    groupedSlider[row.aspek_kpi] = [];
                }
                groupedSlider[row.aspek_kpi].push(row);
            } else if (row.status == 2) {
                if (!groupedInput[row.aspek_kpi]) {
                    groupedInput[row.aspek_kpi] = [];
                }
                groupedInput[row.aspek_kpi].push(row);
            }
        });

        // Render slider
        for (const aspek in groupedSlider) {
            sliderContainer.append(`<div class="mt-3"><strong>${aspek}</strong></div>`);
            groupedSlider[aspek].forEach(row => {
                sliderContainer.append(`
                <input hidden name="template_ids1[]" value="${row.idtemplate_penilaian}">
                <input hidden name="aspek[]" value="${row.aspek_penilaian}">
                <input hidden name="keterangan[]" value="${row.keterangan_penilaian}">
                <input hidden name="idtempkpi1[]" value="${row.idtemplate_kpi}">
                <div class="mb-3 border rounded p-2">
                    <label class="form-label">${row.aspek_penilaian}</label>
                    <input type="range" class="form-range" name="skor1[]" min="1" max="5" step="1"
                        oninput="document.getElementById('range-value-${row.idtemplate_penilaian}').innerText = this.value">
                    <div class="small">Skor: <span id="range-value-${row.idtemplate_penilaian}">3</span></div>
                </div>
            `);
            });
        }

        // Render input
        for (const aspek in groupedInput) {
            inputContainer.append(`<div class="mt-3"><strong>${aspek}</strong></div>`);
            groupedInput[aspek].forEach(row => {
                inputContainer.append(`
            <input hidden name="template_ids2[]" value="${row.idtemplate_penilaian}">
            <input hidden name="aspek[]" value="${row.aspek_penilaian}">
            <input hidden name="keterangan[]" value="${row.keterangan_penilaian}">
            <input hidden name="idtempkpi2[]" value="${row.idtemplate_kpi}">
            <div class="mb-3 border rounded p-2">
                <label class="form-label">${row.aspek_penilaian}</label>
                <input type="number" class="form-control" name="skor2[]" 
                    min="0" step="0.01" 
                    value="${jumlahMap[row.idtemplate_penilaian] || ''}" 
                    required>
            </div>
        `);
            });
        }


    }

});
</script>