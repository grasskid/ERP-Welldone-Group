<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Template Jurnal Asset</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Template</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Jurnal Asset</li>
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
            </iconify-icon>Input Template Jurnal Asset
        </button>
    </div>

    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Kode Template</th>
                    <th>Nomor Akun</th>
                    <th>Nama Akun</th>

                    <th>Debet / Kredit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($template_jurnal_asset)): ?>
                    <?php foreach ($template_jurnal_asset as $row): ?>
                        <tr>
                            <td><?= esc($row->kode_template) ?></td>
                            <td><?= esc($row->no_akun) ?></td>
                            <td><?= esc($row->nama_akun) ?></td>
                            <td><?= esc($row->debet_kredit) ?></td>
                            <td>
                                <!-- <button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-kas-modal" data-id="<?= esc($row->idtemplate_jurnal) ?>"
                                    data-kode_template="<?= esc($row->kode_template) ?>"
                                    data-no_akun="<?= esc($row->no_akun) ?>"
                                    data-nama_akun="<?= $row->nama_akun ?>"
                                    data-debet_kredit="<?= esc($row->debet_kredit) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button> -->
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-kas-modal" data-id="<?= esc($row->idtemplate_jurnal) ?>">
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
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <form action="<?= base_url('insert_template_jurnal_asset') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Input Template Jurnal Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div style="margin-left: 20px;">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCariBuku">
                            Cari Buku
                        </button>
                    </div>

                    <div class="table-responsive px-3 mt-3">
                        <table class="table table-bordered" id="akun-terpilih-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: fit-content;">No Akun</th>
                                    <th style="width: fit-content;">Jenis Akun</th>
                                    <th style="width: fit-content;">Nama Akun</th>
                                    <th style="width: fit-content;">kategori</th>
                                    <th style="width: fit-content;">Jenis Jurnal</th>
                                    <th style="width: fit-content;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="akun-terpilih-container">
                                <!-- Baris akan ditambahkan di sini -->
                            </tbody>
                        </table>
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


<!-- Modal Cari Buku -->
<div class="modal fade" id="modalCariBuku" tabindex="-1" aria-labelledby="modalCariBukuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Modal ukuran besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="table_kasmasuk">
                    <thead>
                        <tr>
                            <th>No Akun</th>
                            <th>Nama Akun</th>
                            <th>Jenis Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($no_akun as $row): ?>
                            <tr>
                                <td><?= esc($row->no_akun) ?></td>
                                <td><?= esc($row->nama_akun) ?></td>
                                <td><?= esc($row->jenis_akun) ?></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm pilih-akun"
                                        data-no="<?= esc($row->no_akun) ?>"
                                        data-jenis="<?= esc($row->jenis_akun) ?>"
                                        data-nama="<?= esc($row->nama_akun) ?>"
                                        data-bs-dismiss="modal">
                                        Pilih
                                    </button>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<!-- Modal Edit -->
<div class="modal fade" id="edit-kas-modal" tabindex="-1" aria-labelledby="editKasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('update_template_jurnal') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Template Jurnal Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idtemplate_jurnal" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_kode_template" class="form-label">Kode Template</label>
                        <input type="text" class="form-control" readonly name="kode_template" id="edit_kode_template" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_no_akun" class="form-label">No Akun</label>
                        <input type="text" class="form-control" readonly name="no_akun" id="edit_no_akun" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nama_akun" class="form-label">Nama Akun</label>
                        <input type="text" class="form-control" readonly name="nama_akun" id="edit_nama_akun" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_debet_kredit" class="form-label">Jenis Jurnal</label>
                        <select class="form-control" name="debet_kredit" id="edit_debet_kredit" required>
                            <option value="">-- Pilih --</option>
                            <option value="debet">Debet</option>
                            <option value="kredit">Kredit</option>
                        </select>
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
            <form action="<?= base_url('delete_template_jurnal') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Template Jurnal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="delete_id" name="idtemplate_jurnal">
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
                document.getElementById('edit_kode_template').value = btn.dataset.kode_template;
                document.getElementById('edit_no_akun').value = btn.dataset.no_akun;
                document.getElementById('edit_nama_akun').value = btn.dataset.nama_akun;
                document.getElementById('edit_debet_kredit').value = btn.dataset.debet_kredit;
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#zero_config').addEventListener('click', function(e) {
            if (e.target.closest('.delete-button')) {
                const btn = e.target.closest('.delete-button');
                document.getElementById('delete_id').value = btn.dataset.id;
            }
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        let akunIndex = 0;

        // Inisialisasi DataTable
        let table = $('#table_kasmasuk').DataTable();

        // Event delegation: tombol pilih-akun tetap berfungsi walaupun pagination
        $('#table_kasmasuk').on('click', '.pilih-akun', function() {
            const noAkun = $(this).attr('data-no');
            const jenisAkun = $(this).attr('data-jenis');
            const namaakun = $(this).attr('data-nama');


            const container = document.getElementById('akun-terpilih-container');

            const row = document.createElement('tr');
            row.className = 'akun-row';
            row.innerHTML = `
            <td>
                <input type="text" class="form-control" name="akun[${akunIndex}][no_akun]" value="${noAkun}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="akun[${akunIndex}][jenis_akun]" value="${jenisAkun}" readonly>
            </td>

            <td>
                <input type="text" class="form-control" name="akun[${akunIndex}][nama_akun]" value="${namaakun}" readonly>
            </td>

            <td>
            <select style="width: 100px;" class="form-control select2-kategori_asset" name="akun[${akunIndex}][kategori_idkategori]" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori_asset as $kat): ?>
                                    <option value="<?= esc($kat->idkategori_asset) ?>"><?= esc($kat->kategori_asset) ?></option>
                                <?php endforeach; ?>
                            </select>
            </td>
            <td>
                <select class="form-control jenis-jurnal" name="akun[${akunIndex}][jenis_jurnal]">
                    <option value="">-- Pilih Jenis jurnal --</option>
                    <option value="debet">Debit</option>
                    <option value="kredit">Kredit</option>
                </select>
            </td>
            
           
            
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-akun">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

            container.appendChild(row);
            akunIndex++;


            // Select2
            $(row).find('.select2-kategori_asset').select2({
                dropdownParent: $('#input-kas-modal'),
                width: '100%'
            });


            // Tutup modal Cari Buku
            const modalBuku = bootstrap.Modal.getInstance(document.getElementById('modalCariBuku'));
            modalBuku.hide();

            // Buka kembali modal utama
            const inputKasModal = new bootstrap.Modal(document.getElementById('input-kas-modal'));
            inputKasModal.show();
        });

        // Event delegation untuk tombol hapus
        document.getElementById('akun-terpilih-container').addEventListener('click', function(e) {
            if (e.target.closest('.remove-akun')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#edit_penerima').select2({
            dropdownParent: $('#edit-kas-modal')
        });
    });
</script>