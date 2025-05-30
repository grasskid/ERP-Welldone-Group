<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Data Pegawai</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <!-- Filter Tanggal -->
        <div class="mb-3 px-4">
            <label class="me-2">Filter by Unit:</label>
            <select id="unitFilter" class="form-select d-inline" style="width: auto; display: inline-block;" name="unit" onchange="filterData()">
                <option value="">Semua Unit</option>
                <?php
                foreach ($unit as $items) {
                    echo '<option value="' . esc($items->idunit) . '">' . esc($items->NAMA_UNIT) . '</option>';
                }
                ?>
            </select>

            <button onclick="resetFilter()" type="button" class="btn btn-sm btn-secondary ms-3">Reset</button>
        </div>
        <div class="d-flex gap-2">
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-pegawai-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>Input
        </button>
    </div>


    <div class="row px-4 mb-3">
        <div class="table-responsive mb-4 px-4">
            <div id="loadingSpinner" style="display: none;" class="text-center my-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No. ID</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No KTP</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Email</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama Pegawai</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jabatan</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Unit</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                        </th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Input Pegawai -->
<div class="modal fade" id="input-pegawai-modal" tabindex="-1" aria-labelledby="inputPeagawaiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputPegawaiModalLabel">Input Data Pegawai</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pegawai/insert') ?>" method="post">
                <div class="modal-body row">
                    <div class="mb-3 col-md-6">
                        <label for="noid" class="form-label">No ID Pegawai</label> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="noid" name="noid" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="no_ktp" class="form-label">No KTP</label> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email</label> <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Nama Pegawai</label> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="unit" class="form-label">Unit<span class="text-danger">*</span></label>
                        <select class="select-unit form-control" name="unit" id="unit">
                            <option value="">-- Pilih Unit --</option>
                            <?php foreach ($unit as $val) : ?>
                                <option value="<?= $val->idunit; ?>"><?= $val->NAMA_UNIT; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="jabatan" class="form-label">Jabatan<span class="text-danger">*</span> </label>
                        <select class="select-jabatan form-control" name="jabatan" id="jabatan">
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $val) : ?>
                                <option value="<?= $val->ID_JABATAN; ?>"><?= $val->NAMA_JABATAN; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="hp" class="form-label">No.HP</label></label>
                        <input type="number" class="form-control" id="hp" name="hp">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="hp" class="form-label">Jenis Kelamin</label></label>
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="laki-input" name="jenis_kelamin" value="Laki-Laki" class="form-check-input" />
                            <label class="form-check-label" for="laki-input">Laki - Laki</label>
                        </div>
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="perempuan-input" name="jenis_kelamin" value="Perempuan" class="form-check-input" />
                            <label class="form-check-label" for="perempuan-input">Perempuan</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label></label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="roles-select" class="form-label">Roles Tambahan (optional)</label>
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

<!-- Modal Edit Pegawai -->
<div class="modal fade" id="edit-pegawai-modal" tabindex="-1" aria-labelledby="inputPeagawaiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputPegawaiModalLabel">Update Data Pegawai</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pegawai/update') ?>" method="post">
                <input type="hidden" name="ID_AKUN" id="ID_AKUN">
                <div class="modal-body row">
                    <div class="mb-3 col-md-6">
                        <label for="noid" class="form-label">No ID Pegawai</label> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="noid" name="noid" required readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="no_ktp" class="form-label">No KTP</label> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email</label> <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nama" class="form-label">Nama Pegawai</label> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="unit" class="form-label">Unit<span class="text-danger">*</span></label>
                        <select class="select-unit form-control" name="unit" id="unit-update">
                            <option value="">-- Pilih Unit --</option>
                            <?php foreach ($unit as $val) : ?>
                                <option value="<?= $val->idunit; ?>"><?= $val->NAMA_UNIT; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="jabatan" class="form-label">Jabatan<span class="text-danger">*</span> </label>
                        <select class="select-jabatan form-control" name="jabatan" id="jabatan-update">
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $val) : ?>
                                <option value="<?= $val->ID_JABATAN; ?>"><?= $val->NAMA_JABATAN; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="hp" class="form-label">No.HP</label></label>
                        <input type="number" class="form-control" id="hp" name="hp">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="hp" class="form-label">Jenis Kelamin</label></label>
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="laki-update" name="jenis_kelamin" value="Laki-Laki" class="form-check-input" />
                            <label class="form-check-label" for="laki-update">Laki - Laki</label>
                        </div>
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="perempuan-update" name="jenis_kelamin" value="Perempuan" class="form-check-input" />
                            <label class="form-check-label" for="perempuan-update">Perempuan</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label></label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="roles-select" class="form-label">Roles Tambahan (optional)</label>
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


<script>
    $(document).ready(function() {
        loadData();

        $('#roles-select').select2({
            dropdownParent: $('#input-pegawai-modal'),
            width: '100%',
            dropdownAutoWidth: true,
        });
        $('#roles-update').select2({
            dropdownParent: $('#edit-pegawai-modal'),
            width: '100%',
            dropdownAutoWidth: true,
        });
    });

    $(document).on('click', '.edit-button', function() {
        const id = $(this).data('id');
        const noid = $(this).data('noid');
        const ktp = $(this).data('ktp');
        const email = $(this).data('email');
        const nama = $(this).data('nama');
        const unit = $(this).data('unit');
        const jabatan = $(this).data('jabatan');
        const hp = $(this).data('hp');
        const alamat = $(this).data('alamat');
        const jenis_kelamin = $(this).data('jenis_kelamin');
        const roles = $(this).data('roles');
        $('#edit-pegawai-modal #id').val(id);
        $('#edit-pegawai-modal #noid').val(noid);
        $('#edit-pegawai-modal #no_ktp').val(ktp);
        $('#edit-pegawai-modal #nama').val(nama);
        $('#edit-pegawai-modal #email').val(email);
        $('#edit-pegawai-modal #jabatan').val(jabatan);
        $('#edit-pegawai-modal #hp').val(hp);
        $('#edit-pegawai-modal #alamat').val(alamat);
        $('#edit-pegawai-modal #unit-update').val(unit);
        $('#edit-pegawai-modal #jabatan-update').val(jabatan);
        alert(unit);
        // With this:
        if (jenis_kelamin === 'Laki-Laki') {
            $('#edit-pegawai-modal #laki-update').prop('checked', true);
            $('#edit-pegawai-modal #perempuan-update').prop('checked', false);
        } else if (jenis_kelamin === 'Perempuan') {
            $('#edit-pegawai-modal #laki-update').prop('checked', false);
            $('#edit-pegawai-modal #perempuan-update').prop('checked', true);
        }

        $('#roles-update').val(null).trigger('change');
        if (roles && roles.length > 0) {
            $('#roles-update').val(roles).trigger('change');
        }

    });

    function loadData() {
        var unitId = $('#unitFilter').val();
        // Show loading spinner
        $('#loadingSpinner').show();
        $.ajax({
            url: '<?= base_url('pegawai/search') ?>',
            type: 'POST',
            data: {
                unit_id: unitId
            },
            dataType: 'json',
            success: function(response) {
                var html = '';
                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        html += '<tr>';
                        html += '<td>' + item.NOID + '</td>';
                        html += '<td>' + item.KTP + '</td>';
                        html += '<td>' + item.EMAIL + '</td>';
                        html += '<td>' + item.NAMA_AKUN + '</td>';
                        html += '<td>' + item.NAMA_JABATAN + '</td>';
                        html += '<td>' + item.NAMA_UNIT + '</td>';
                        html += '<td>';
                        html += '<button type="button" class="btn btn-warning edit-button me-2" data-bs-toggle="modal" data-bs-target="#edit-pegawai-modal" ';
                        html += 'data-id="' + item.ID_AKUN + '" ';
                        html += 'data-noid="' + item.NOID + '" ';
                        html += 'data-email="' + item.EMAIL + '" ';
                        html += 'data-ktp="' + item.KTP + '" ';
                        html += 'data-nama="' + item.NAMA_AKUN + '" ';
                        html += 'data-hp="' + item.HP + '" ';
                        html += 'data-alamat="' + item.ALAMAT + '" ';
                        html += 'data-jenis_kelamin="' + item.JENIS_KELAMIN + '" ';
                        html += 'data-roles="' + item.ROLES + '" ';
                        html += 'data-jabatan="' + item.ID_JABATAN + '" ';
                        html += 'data-unit="' + item.ID_UNIT + '">';
                        html += '<iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>';
                        html += '</button>';
                        html += '<button onclick="deletePegawai(' + item.ID_AKUN + ')" class="btn btn-sm btn-danger">';
                        html += '<iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24"></iconify-icon>';
                        html += '</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                }
                $('#zero_config tbody').html(html);
            },
            error: function(xhr, status, error) {
                $('#zero_config tbody').html('<tr><td colspan="7" class="text-center text-danger">Terjadi kesalahan saat memuat data</td></tr>');
            },
            complete: function() {
                // Hide loading spinner
                $('#loadingSpinner').hide();
            }
        });
    }

    function filterData() {
        loadData();
    }

    function resetFilter() {
        $('#unitFilter').val('');
        loadData();
    }

    function deletePegawai(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                url: '<?= base_url('pegawai/delete') ?>',
                type: 'POST',
                data: {
                    ID_AKUN: id
                },
                success: function(response) {
                    toastr.success(
                        "Data berhasil dihapus",
                        "Berhasil!", {
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: true,
                            timeOut: 2000
                        }
                    )
                    loadData();
                },
                error: function(xhr, status, error) {
                    toastr.warning(
                        "Gagal menghapus data",
                        "Gagal!", {
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                            progressBar: true,
                            timeOut: 2000
                        }
                    );
                }
            });
        }
    }
</script>