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
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#samedata-modal"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:import-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Import
            </button>
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

    <br>
    <div class="mb-3 px-4">
        <label class="me-2">Filter Handphone:</label>
        <select id="namaBarangFilter" class="form-select d-inline" style="width: auto; display: inline-block;"
            onchange="filterBarang()">
            <option value="">Semua Barang</option>
            <?php
            $namaBarangList = [];
            foreach ($phone as $row) {
                if (!in_array($row->nama_barang, $namaBarangList)) {
                    $namaBarangList[] = $row->nama_barang;
                    echo '<option value="' . esc($row->nama_barang) . '">' . esc($row->nama_barang) . '</option>';
                }
            }
            ?>
        </select>

        <label class="me-2 ms-4">Filter Warna:</label>
        <select id="warnaFilter" class="form-select d-inline" style="width: auto; display: inline-block;"
            onchange="filterBarang()">
            <option value="">Semua Warna</option>
            <?php
            $warnaList = [];
            foreach ($phone as $row) {
                if (!in_array($row->warna, $warnaList)) {
                    $warnaList[] = $row->warna;
                    echo '<option value="' . esc($row->warna) . '">' . esc($row->warna) . '</option>';
                }
            }
            ?>
        </select>

        <label class="me-2 ms-4">Filter Kondisi:</label>
        <select id="kondisiFilter" class="form-select d-inline" style="width: auto; display: inline-block;"
            onchange="filterBarang()">
            <option value="">Semua Kondisi</option>
            <option value="baru">Baru</option>
            <option value="bekas">Bekas</option>
        </select>


        <button onclick="resetBarangFilter()" class="btn btn-sm btn-secondary ms-2">Reset</button>
    </div>


    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>

                    <th>Kode Barang</th>
                    <th>IMEI</th>
                    <th>Nama Barang </th>
                    <th>Harga</th>
                    <th>Harga Beli</th>
                    <th>Jenis HP</th>
                    <th>Internal</th>
                    <th>Warna</th>
                    <th>kondisi</th>
                    <th>PPN</th>
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
                            <td><?= 'Rp ' . number_format($row->harga_beli, 0, ',', '.') ?></td>
                            <td><?= esc($row->jenis_hp) ?></td>

                            <td><?= esc($row->internal) ?> Gb</td>
                            <td><?= esc($row->warna) ?></td>
                            <?php if (esc($row->status_barang == 0)) : ?>
                                <td>Baru</td>
                            <?php else : ?>
                                <td>Bekas</td>
                            <?php endif ?>
                            <td><?= $row->status_ppn == 1 ? 'PPN' : 'Non PPN' ?></td>
                            <td><?= esc($row->input) ?></td>

                            <td>
                                <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-produk-modal" data-nama_barang="<?= esc($row->nama_barang) ?>"
                                    data-id="<?= esc($row->idbarang) ?>" data-imei="<?= esc($row->imei) ?>"
                                    data-jenis_hp="<?= ucfirst(strtolower($row->jenis_hp)) ?>"
                                    data-harga="<?= esc($row->harga) ?>" data-harga_beli="<?= esc($row->harga_beli) ?>"
                                    data-internal="<?= esc($row->internal) ?>" data-warna="<?= esc($row->warna) ?>"
                                    data-status_ppn="<?= esc($row->status_ppn) ?>"
                                    data-status_barang="<?= esc($row->status_barang) ?>">
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
                        <td colspan="12" class="text-center">Tidak ada data</td>
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
                        <label>Nama Handphone</label>
                        <br>
                        <div style="display: flex; gap: 10px;">
                            <select id="namahandphone-select" name="nama_barang" class="select2 form-control"
                                style="width: 100%;">
                                <option disabled selected>Select</option>
                                <?php foreach ($nama_handphone as $p): ?>
                                    <option value="<?= htmlspecialchars($p->nama) ?>">
                                        <?= htmlspecialchars($p->nama)  ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div style="display: flex; align-items: center;">
                                <button type="button" style="width: 30px; height: 35px;" data-bs-toggle="modal"
                                    data-bs-target="#nama-phone-modal">+</button>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="harga" name="harga" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="harga_beli" name="harga_beli" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>IMEI</label>
                        <input type="text" class="form-control" name="imei" required>
                    </div>

                    <div class="mb-3">
                        <label>Jenis HP</label>
                        <select class="form-control" name="jenis_hp" id="input-jenis_hp" required>
                            <option disabled selected>Pilih Jenis HP</option>
                            <option value="Android">Android</option>
                            <option value="Iphone">Iphone</option>
                        </select>
                    </div>




                    <div class="mb-3">
                        <label>Internal</label>
                        <input type="number" class="form-control" name="internal" required>
                    </div>
                    <div class="mb-3">
                        <label>Warna</label>
                        <input type="text" class="form-control" name="warna" required>
                    </div>

                    <div class="mb-3">
                        <label>Kondisi</label>
                        <select class="form-control" name="kondisi" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="0">Baru</option>
                            <option value="1">Bekas</option>
                        </select>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label">Status PPn :</label>
                        <div class="col-sm-9">
                            <div class="form-check d-flex align-items-center gap-2 mb-8">
                                <input class="form-check-input" type="radio" name="status_ppn" id="RadioPpn" value="1">
                                <label class="form-check-label" for="RadioPpn"> PPn
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="status_ppn" id="RadioNonPpn"
                                    value="0" checked>
                                <label class="form-check-label" for="RadioNonPpn"> Non PPn</label>
                            </div>
                        </div>
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
                        <div class="mb-3">
                            <label>Nama Barang</label>
                            <br>
                            <div style="display: flex; gap: 10px;">
                                <select id="edit-nama_barang" name="nama_barang" class="form-control select2"
                                    style="width: 100%;" required>
                                    <option disabled selected>Select</option>
                                    <?php foreach ($nama_handphone as $p): ?>
                                        <option value="<?= htmlspecialchars($p->nama) ?>">
                                            <?= htmlspecialchars($p->nama)  ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" style="width: 30px; height: 35px;" id="btn-tambah-nama-edit"
                                    style="height: 38px;">+</button>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label>IMEI</label>
                        <input type="text" class="form-control" name="imei" id="edit-imei" required>
                    </div>
                    <div class="mb-3">
                        <label>Jenis HP</label>
                        <select class="form-control" name="jenis_hp" id="edit-jenis_hp" required>
                            <option disabled selected>Pilih Jenis HP</option>
                            <option value="Android">Android</option>
                            <option value="Iphone">Iphone</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="edit-harga" name="harga" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="edit-harga_beli" name="harga_beli"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Internal</label>
                        <input type="number" class="form-control" name="internal" id="edit-internal" required>
                    </div>
                    <div class="mb-3">
                        <label>Warna</label>
                        <input type="text" class="form-control" name="warna" id="edit-warna" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-kondisi">Kondisi</label>
                        <select class="form-control" name="kondisi" id="edit-kondisi" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="0">Baru</option>
                            <option value="1">Bekas</option>
                        </select>
                    </div>


                    <!-- Radio Buttons -->
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Status PPn :</label>
                        <div class="col-sm-9">
                            <div class="form-check d-flex align-items-center gap-2 mb-8">
                                <input class="form-check-input" type="radio" name="status_ppn" id="editRadioPpn"
                                    value="1">
                                <label class="form-check-label" for="editRadioPpn"> PPn
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-2">
                                <input class="form-check-input" type="radio" name="status_ppn" id="editRadioNonPpn"
                                    value="0">
                                <label class="form-check-label" for="editRadioNonPpn"> Non PPn</label>
                            </div>
                        </div>
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
                <h4 class="modal-title" id="deleteKategoriModalLabel">Delete Data Handphone</h4>
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

<!-- Modal Tambah Nama Handphone -->
<div class="modal fade" id="nama-phone-modal" tabindex="-1" aria-labelledby="namaphoneModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-tambah-handphone">
                <div class="modal-header">
                    <h5 class="modal-title" id="namaphoneModalLabel">Tambah Nama Handphone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="input-nama-handphone">Nama Handphone</label>
                        <input type="text" name="nama_handphone" id="input-nama-handphone" class="form-control"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="$('#input-produk-modal').modal('show')">Kembali</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                // Populate status_ppn
                var status_ppn = button.getAttribute('data-status_ppn');
                if (button.getAttribute('data-status_ppn') === '0') {
                    document.getElementById('editRadioNonPpn').checked = true;
                } else {
                    document.getElementById('editRadioPpn').checked = true;
                }
                // Populate base fields
                document.getElementById('edit-id').value = button.getAttribute('data-id');
                $('#edit-nama_barang').val(button.getAttribute('data-nama_barang')).trigger('change');

                document.getElementById('edit-imei').value = button.getAttribute('data-imei');
                $('#edit-jenis_hp').val(button.getAttribute('data-jenis_hp')).trigger('change');
                document.getElementById('edit-harga').value = button.getAttribute('data-harga');
                document.getElementById('edit-harga_beli').value = button.getAttribute('data-harga_beli');
                // document.getElementById('edit-hpp').value = button.getAttribute('data-hpp');
                document.getElementById('edit-internal').value = button.getAttribute('data-internal');
                document.getElementById('edit-warna').value = button.getAttribute('data-warna');
                document.getElementById('edit-kondisi').value = button.getAttribute('data-status_barang');
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



<script>
    document.querySelectorAll('.currency').forEach(function(el) {
        new Cleave(el, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    });
</script>

<script>
    let table;

    window.onload = function() {
        table = $('#zero_config').DataTable();

        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const namaBarangFilter = $('#namaBarangFilter').val().toLowerCase();
            const warnaFilter = $('#warnaFilter').val().toLowerCase();
            const kondisiFilter = $('#kondisiFilter').val().toLowerCase();


            const namaBarang = data[3].toLowerCase();
            const warna = data[8].toLowerCase();
            const kondisi = data[9].toLowerCase();

            const matchNamaBarang = !namaBarangFilter || namaBarang.trim() === namaBarangFilter;
            const matchWarna = !warnaFilter || warna.trim() === warnaFilter;
            const matchKondisi = !kondisiFilter || kondisi.trim() === kondisiFilter;

            return matchNamaBarang && matchWarna && matchKondisi;
        });


        table.draw();
    };

    function filterBarang() {
        table.draw();
    }

    function resetBarangFilter() {
        $('#namaBarangFilter').val('');
        $('#warnaFilter').val('');
        table.draw();
    }
</script>

<script>
    $(document).ready(function() {
        // Inisialisasi select2
        $('#namahandphone-select').select2({
            dropdownParent: $('#input-produk-modal'),
            placeholder: 'Pilih Nama Handphone',
            width: '100%'
        });

        // Submit form tambah handphone dengan AJAX
        $('#form-tambah-handphone').on('submit', function(e) {
            e.preventDefault();

            const nama_handphone = $('#input-nama-handphone').val();

            $.ajax({
                url: '<?= base_url('insert-phone-ajax') ?>',
                method: 'POST',
                data: {
                    nama_handphone: nama_handphone
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        // Simpan nama baru
                        const namaBaru = res.nama;

                        // Buat option baru, tapi jangan langsung selected
                        const newOption = new Option(namaBaru, namaBaru, false, false);

                        // Tambah ke dropdown edit (langsung muncul karena tidak pakai destroy)
                        $('#edit-nama_barang').append(new Option(namaBaru, namaBaru, true,
                            true)).trigger('change');

                        // Simpan info return source
                        const returnSource = $('#nama-phone-modal').attr('data-return');

                        $('#form-tambah-handphone')[0].reset();
                        $('#nama-phone-modal').modal('hide');

                        // Setelah modal tertutup, buka kembali modal asal
                        $('#nama-phone-modal').on('hidden.bs.modal', function() {
                            if (returnSource === 'edit') {
                                $('#edit-produk-modal').modal('show');
                            } else {
                                $('#input-produk-modal').modal('show');

                                // Tunggu modal terbuka agar select2 siap, lalu tambahkan & pilih
                                setTimeout(() => {
                                    const $selectInput = $(
                                        '#namahandphone-select');

                                    // Destroy dan init ulang select2
                                    $selectInput.select2('destroy').empty();

                                    // Tambahkan ulang semua opsi dari server (jika kamu mau safe)
                                    <?php foreach ($nama_handphone as $p): ?>
                                        $selectInput.append(new Option(
                                            "<?= htmlspecialchars($p->nama) ?>",
                                            "<?= htmlspecialchars($p->nama) ?>"
                                        ));
                                    <?php endforeach; ?>

                                    // Tambahkan nama baru
                                    $selectInput.append(newOption);

                                    // Reinit select2
                                    $selectInput.select2({
                                        dropdownParent: $(
                                            '#input-produk-modal'),
                                        placeholder: 'Pilih Nama Handphone',
                                        width: '100%'
                                    });

                                    // Pilih nilai baru
                                    $selectInput.val(namaBaru).trigger(
                                        'change');
                                }, 300);
                            }

                            // Cleanup
                            $(this).removeAttr('data-return');
                            $(this).off('hidden.bs.modal');
                        });

                    } else {
                        alert(res.message || 'Gagal menambahkan.');
                    }
                },

                error: function() {
                    alert('Terjadi kesalahan.');
                }
            });
        });

    });
</script>

<script>
    $('#btn-tambah-nama-edit').on('click', function() {
        $('#edit-produk-modal').modal('hide');
        $('#nama-phone-modal').modal('show');

        // Tandai bahwa kita datang dari modal edit
        $('#nama-phone-modal').attr('data-return', 'edit');
    });
</script>


<style>
    .select2-container {
        z-index: 9999;
        position: relative;
    }

    .select2-container--open {
        z-index: 9999;
    }
</style>