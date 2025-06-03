<div id="pelanggan-section" class="mt-3 mb-3" style="display: flex; justify-content: right;">
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#pelangganModal"
        style="display: inline-flex; align-items: center; margin-bottom: 4px;">
        <iconify-icon icon="mdi:account" width="20" height="20" style="margin-right: 8px;"></iconify-icon>
        Input Data Pelanggan
    </button>
</div>

<form action="<?php echo base_url('insert/pelanggan_service') ?>" enctype="multipart/form-data" method="post">
    <div class="row g-3">

        <input hidden type="text" name="idservice" value="<?php echo @$idservice ?>">

        <div class="col-md-6">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" value="<?php echo @$old_service_pelanggan->nama ?>" class="form-control"
                name="nama_pelanggan" id="nama_pelanggan">
        </div>
        <!-- <div class="col-md-6">
            <label class="form-label">Kode Faktur</label>
            <input type="text" class="form-control" value="">
        </div> -->

        <div class="col-md-6">
            <label class="form-label">No Hp</label>
            <input type="text" class="form-control" value="<?php echo @$old_service_pelanggan->no_hp ?>" name="no_hp"
                id="no_hp">
        </div>
        <div class="col-md-6">
            <label class="form-label">Imei</label>
            <input type="text" value="<?php echo @$old_service_pelanggan->imei ?>" class="form-control" name="imei">
        </div>
        <div class="col-md-6">
            <label class="form-label">Tipe Passcode</label>
            <select class="form-control" name="tipe_passcode">
                <option value="">-- Pilih Tipe --</option>
                <option value="pola"
                    <?php echo (@$old_service_pelanggan->type_passcode == 'pola') ? 'selected' : ''; ?>>Pola</option>
                <option value="text"
                    <?php echo (@$old_service_pelanggan->type_passcode == 'text') ? 'selected' : ''; ?>>Text</option>
            </select>
        </div>


        <div class="col-md-6">
            <label class="form-label">Passcode</label>
            <input value="<?php echo @$old_service_pelanggan->passcode ?>" type="text" class="form-control"
                name="passcode">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email (icloud)</label>
            <input type="email" value="<?php echo @$old_service_pelanggan->email_icloud ?>" placeholder="@icloud.com"
                class="form-control" name="email_icloud">
        </div>
        <div class="col-md-6">
            <label class="form-label">Password (icloud)</label>
            <input type="password" value="<?php echo @$old_service_pelanggan->password_icloud ?>" placeholder="********"
                class="form-control" name="password_icloud">
        </div>

        <!-- <div class="col-md-6">
            <label class="form-label">Gudang</label>
            <select class="form-select" name="gudang">
                <option selected>---Pilih Gudang---</option>
                
            </select>
        </div> -->
        <div class="col-md-6">
            <label class="form-label">Alamat</label>
            <textarea style="height: 100px;" type="text" class="form-control" name="alamat"
                id="alamat"><?php echo @$old_service_pelanggan->alamat ?></textarea>

        </div>

        <div class="col-md-6">
            <label class="form-label">Keluhan</label>
            <textarea style="height: 100px;" class="form-control"
                name="keluhan"><?php echo @$old_service_pelanggan->keluhan ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Keterangan</label>
            <textarea style="height: 100px;" type="text" class="form-control"
                name="keterangan"><?php echo @$old_service_pelanggan->keterangan ?></textarea>

        </div>






    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <!-- <button type="button" class="btn btn-outline-secondary">Sebelumnya</button> -->
        <div>
            <button type="submit" class="btn btn-info text-white me-2">Simpan</button>
            <button type="button" class="btn btn-success" id="btn-next-to-kerusakan">Selanjutnya</button>
        </div>
    </div>

    <div class="modal fade" id="pelangganModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cari Data Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <select id="pelanggan-select" name="selectedidpelanggan" class="select2 form-control"
                        style="width: 100%;">
                        <option disabled selected>Select</option>
                        <?php foreach ($pelanggan as $p): ?>
                        <option value="<?= htmlspecialchars($p->id_pelanggan) ?>"
                            data-nama="<?= htmlspecialchars($p->nama) ?>" data-nohp="<?= htmlspecialchars($p->no_hp) ?>"
                            data-alamat="<?= htmlspecialchars($p->alamat) ?>">
                            <?= htmlspecialchars($p->nama) ?> : <?= htmlspecialchars($p->no_hp) ?>
                        </option>

                        <?php endforeach; ?>
                    </select>

                    <!-- Tombol di bawah dropdown -->
                    <div style="display: flex; justify-content: right; gap: 10px; margin-top: 20px;">
                        <button id="btnPilihPelanggan" type="button" class="btn btn-primary">Pilih</button>
                        <button id="btnTambahPelanggan" type="button" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




</form>

<div class="modal fade" id="modalTambahPelanggan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTambahPelanggan">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" id="nik" name="nik" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" id="no_hp" name="no_hp" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pelangganModal = new bootstrap.Modal(document.getElementById('pelangganModal'));
    const modalTambah = new bootstrap.Modal(document.getElementById('modalTambahPelanggan'));

    // Inisialisasi Select2 dengan dropdownParent agar dropdown muncul di atas modal
    $('.select2').select2({
        dropdownParent: $('#pelangganModal')
    });

    // Langsung tampilkan tombol pelanggan saat halaman dimuat
    const existingBtn = document.getElementById('pelanggan-button');
    if (!existingBtn) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.id = 'pelanggan-button';
        btn.className = 'btn btn-warning mt-2';
        btn.style = 'display: inline-flex; align-items: center; margin-bottom: 4px;';
        btn.innerHTML = `
                <iconify-icon icon="mdi:account" width="20" height="20" style="margin-right: 8px;"></iconify-icon>
                Input Data Pelanggan
            `;

        btn.onclick = () => pelangganModal.show();

        const container = document.querySelector('.table-responsive.mt-3.mb-4');
        if (container) {
            container.appendChild(btn);
        }
    }

    // Tombol "Tambah" di bawah dropdown
    document.getElementById('btnTambahPelanggan').addEventListener('click', function() {
        modalTambah.show();
    });

    // Saat tombol "Pilih" ditekan
    document.getElementById('btnPilihPelanggan').addEventListener('click', function() {
        const select = document.getElementById('pelanggan-select');
        const selectedOption = select.options[select.selectedIndex];

        if (!selectedOption || selectedOption.disabled) {
            alert('Silakan pilih pelanggan terlebih dahulu.');
            return;
        }

        const nama = selectedOption.getAttribute('data-nama');
        const no_hp = selectedOption.getAttribute('data-nohp');
        const alamat = selectedOption.getAttribute('data-alamat');

        // Set nilai ke form input
        document.getElementById('nama_pelanggan').value = nama;
        document.getElementById('no_hp').value = no_hp;
        document.getElementById('alamat').value = alamat;


        pelangganModal.hide();
    });


    $('#formTambahPelanggan').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: '<?php echo base_url('simpan/pelanggan') ?>',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    modalTambah.hide();
                    $('#formTambahPelanggan')[0].reset();

                    const newOption = new Option(
                        response.data.nama + ' : ' + response.data.no_hp,
                        response.data.id_pelanggan,
                        true,
                        true
                    );
                    $('#pelanggan-select').append(newOption).trigger('change');
                    alert('Pelanggan berhasil ditambahkan');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    });
});
</script>

<script>
document.getElementById('btn-next-to-kerusakan').addEventListener('click', function() {
    var idservice = document.querySelector('input[name="idservice"]').value;

    if (!idservice) {
        alert('Harap isi dan simpan pelanggan terlebih dahulu.');
    } else {
        var tabTrigger = new bootstrap.Tab(document.querySelector('#kerusakan-tab'));
        tabTrigger.show();
    }
});
</script>