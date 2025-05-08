<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Handphone</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Handphone</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Card -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
    </div>

    <div class="px-4 py-3 border-bottom d-flex justify-content-between">
        <div class="d-flex gap-2">
            <a href="<?= base_url('export/phone') ?>" class="btn btn-danger"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Export
            </a>
            <a href="<?php echo base_url('format_excell/format_phone.xlsx') ?>"><button type="button"
                    class="btn btn-success" style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:download-broken" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>
                    Download Format Excell
                </button></a>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-produk-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>
            Input
        </button>
    </div>
    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Kode Barang</th>
                    <th>IMEI</th>
                    <th>Nama Barang </th>
                    <th>Harga</th>
                    <th>Jenis HP</th>

                    <th>Internal</th>
                    <th>Warna</th>
                    <th>Status</th>
                    <th>Input</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($phone)): ?>
                    <?php foreach ($phone as $row): ?>
                        <tr>
                            <td><?= esc($row->kode_barang) ?></td>
                            <td><?= esc($row->imei) ?></td>
                            <td><?= esc($row->nama_barang) ?></td>
                            <td><?= 'Rp ' . number_format($row->harga, 0, ',', '.') ?></td>
                            <td><?= esc($row->jenis_hp) ?></td>

                            <td><?= esc($row->internal) ?> Gb</td>
                            <td><?= esc($row->warna) ?></td>
                            <td>
                                <?php
                                if ($row->status == 0) {
                                    echo 'Menunggu';
                                } elseif ($row->status == 1) {
                                    echo 'Disetujui';
                                } else {
                                    echo 'Unknown Status';
                                }
                                ?>
                            </td>
                            <td><?= esc($row->input) ?></td>

                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-produk-modal"
                                    data-nama_barang="<?= esc($row->nama_barang) ?>"
                                    data-id="<?= esc($row->idbarang) ?>"
                                    data-imei="<?= esc($row->imei) ?>" data-jenis_hp="<?= esc($row->jenis_hp) ?>"
                                    data-harga="<?= esc($row->harga) ?>"
                                    data-internal="<?= esc($row->internal) ?>" data-warna="<?= esc($row->warna) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button>
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-phone-modal" data-id="<?= esc($row->idbarang) ?>">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="24" height="24">
                                    </iconify-icon>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Input Produk -->
<div class="modal fade" id="input-produk-modal" tabindex="-1" aria-labelledby="inputProdukModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('insert_phone') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="inputProdukModalLabel">Input Data Handphone</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="harga" name="harga" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>IMEI</label>
                        <input type="text" class="form-control" name="imei" required>
                    </div>

                    <div class="mb-3">
                        <label>Jenis HP</label>
                        <input type="text" class="form-control" name="jenis_hp" required>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="hpp" class="form-label">HPP</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="hpp" name="hpp" required>
                        </div>
                    </div> -->
                    <div class="mb-3">
                        <label>Internal</label>
                        <input type="text" class="form-control" name="internal" required>
                    </div>
                    <div class="mb-3">
                        <label>Warna</label>
                        <input type="text" class="form-control" name="warna" required>
                    </div>


                    <!-- Radio Buttons -->
                    <!-- <div class="col-sm-4">
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="customRadio1" name="customRadio" class="form-check-input"
                                onclick="showForm('pelanggan')" />
                            <label class="form-check-label" for="customRadio1">Pelanggan</label>
                        </div>
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="customRadio2" name="customRadio" class="form-check-input"
                                onclick="showForm('suplier')" />
                            <label class="form-check-label" for="customRadio2">Suplier</label>
                        </div>
                    </div> -->

                    <!-- Hidden forms for Pelanggan and Suplier -->
                    <!-- <div id="pelangganForm" class="mt-3" style="display: none;">
                        <input type="text" class="form-control" name="idcustomer" placeholder="Masukkan nama Pelanggan">
                    </div>
                    <div id="suplierForm" class="mt-3" style="display: none;">
                        <input type="text" class="form-control" name="idsuplier" placeholder="Masukkan nama Suplier">
                    </div> -->

                    <!-- Hidden fields to indicate which selection (Pelanggan/Suplier) was made -->
                    <!-- <input type="hidden" id="selectedType" name="selectedType"> -->
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

<!-- Modal Edit Produk -->
<div class="modal fade" id="edit-produk-modal" tabindex="-1" aria-labelledby="editProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('update_phone') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="editProdukModalLabel">Edit Data Handphone</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input name="id" hidden id="edit-id">
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="edit-nama_barang" required>
                    </div>
                    <div class="mb-3">
                        <label>IMEI</label>
                        <input type="text" class="form-control" name="imei" id="edit-imei" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis HP</label>
                        <input type="text" class="form-control" name="jenis_hp" id="edit-jenis_hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="edit-harga" name="harga" required>
                        </div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="hpp" class="form-label">HPP</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="edit-hpp" name="hpp" required>
                        </div>
                    </div> -->
                    <div class="mb-3">
                        <label>Internal</label>
                        <input type="text" class="form-control" name="internal" id="edit-internal" required>
                    </div>
                    <div class="mb-3">
                        <label>Warna</label>
                        <input type="text" class="form-control" name="warna" id="edit-warna" required>
                    </div>

                    <!-- Radio Buttons -->
                    <!-- <div class="col-sm-4">
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="editRadioPelanggan" name="customRadio" class="form-check-input"
                                onclick="showEditForm('pelanggan')" />
                            <label class="form-check-label" for="editRadioPelanggan">Pelanggan</label>
                        </div>
                        <div class="custom-control py-2 custom-radio">
                            <input type="radio" id="editRadioSuplier" name="customRadio" class="form-check-input"
                                onclick="showEditForm('suplier')" />
                            <label class="form-check-label" for="editRadioSuplier">Suplier</label>
                        </div>
                    </div> -->

                    <!-- Conditional Input Fields -->
                    <!-- <div id="editPelangganForm" class="mt-3" style="display: none;">
                        <input type="text" class="form-control" id="edit-pelanggan" name="pelanggan"
                            placeholder="Masukkan nama Pelanggan">
                    </div>
                    <div id="editSuplierForm" class="mt-3" style="display: none;">
                        <input type="text" class="form-control" id="edit-suplier" name="suplier"
                            placeholder="Masukkan nama Suplier">
                    </div> -->
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
                <form action="<?php echo base_url('import/phone') ?>" enctype="multipart/form-data" method="post">
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


<!-- delete modal -->
<div class="modal fade" id="delete-phone-modal" tabindex="-1" aria-labelledby="deleteKategoriModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="deleteKategoriModalLabel">Delete Data Kategori</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('delete_phone') ?>" method="post">
                <div class="modal-body">
                    <input id="delete-id" hidden name="id">
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

<!-- JavaScript for Edit Modal Behavior -->
<script>
    function showEditForm(selected) {
        document.getElementById('editPelangganForm').style.display = 'none';
        document.getElementById('editSuplierForm').style.display = 'none';

        if (selected === 'pelanggan') {
            document.getElementById('editPelangganForm').style.display = 'block';
        } else if (selected === 'suplier') {
            document.getElementById('editSuplierForm').style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#zero_config').addEventListener('click', function(e) {
            if (e.target.closest('.edit-button')) {
                const button = e.target.closest('.edit-button');

                // Populate base fields
                document.getElementById('edit-id').value = button.getAttribute('data-id');
                document.getElementById('edit-nama_barang').value = button.getAttribute('data-nama_barang');
                document.getElementById('edit-imei').value = button.getAttribute('data-imei');
                document.getElementById('edit-jenis_hp').value = button.getAttribute('data-jenis_hp');
                document.getElementById('edit-harga').value = button.getAttribute('data-harga');
                // document.getElementById('edit-hpp').value = button.getAttribute('data-hpp');
                document.getElementById('edit-internal').value = button.getAttribute('data-internal');
                document.getElementById('edit-warna').value = button.getAttribute('data-warna');
                document.getElementById('edit-unit').value = button.getAttribute('data-unit');

                // Check Pelanggan vs Suplier
                const pelanggan = button.getAttribute('data-pelanggan');
                const suplier = button.getAttribute('data-suplier');

                if (pelanggan && pelanggan !== '') {
                    document.getElementById('editRadioPelanggan').checked = true;
                    showEditForm('pelanggan');
                    document.getElementById('edit-pelanggan').value = pelanggan;
                    document.getElementById('edit-suplier').value = '';
                } else {
                    document.getElementById('editRadioSuplier').checked = true;
                    showEditForm('suplier');
                    document.getElementById('edit-suplier').value = suplier;
                    document.getElementById('edit-pelanggan').value = '';
                }
            }

            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                document.getElementById('delete-id').value = button.getAttribute('data-id');
                document.getElementById('delete_id_phone').value = id_phone;
            }
        });
    });
</script>

<!-- JavaScript to toggle the forms and handle hidden inputs -->
<script>
    function showForm(selected) {
        // Hide both forms initially
        document.getElementById('pelangganForm').style.display = 'none';
        document.getElementById('suplierForm').style.display = 'none';
        document.getElementById('selectedType').value = ''; // Reset hidden field

        // Show the selected form and set the hidden field value
        if (selected === 'pelanggan') {
            document.getElementById('pelangganForm').style.display = 'block';
            document.getElementById('selectedType').value = 'pelanggan';
        } else if (selected === 'suplier') {
            document.getElementById('suplierForm').style.display = 'block';
            document.getElementById('selectedType').value = 'suplier';
        }
    }
</script>

<script>
    document.querySelectorAll('.currency').forEach(function(el) {
        new Cleave(el, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    });
</script>