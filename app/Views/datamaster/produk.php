<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Barang</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Barang</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">

    </div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2">
            <a href="<?= base_url('produk/export/produk') ?>" class="btn btn-danger"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>Export
            </a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#samedata-modal"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:import-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Import
            </button>
            <a href="<?php echo base_url('format_excell/format_product.xlsx') ?>"><button type="button"
                    class="btn btn-success" style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:download-broken" width="24" height="24" style="margin-right: 8px;">
                    </iconify-icon>
                    Download Format Excell
                </button></a>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-produk-modal">
            Input
        </button>
    </div>




    <div class="mb-4" style="width: 30%; padding-left: 20px;">
        <label for="filterKategori" class="form-label">Filter Kategori</label>
        <select id="filterKategori" class="form-select">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori as $kat) : ?>
                <option value="<?= esc($kat->nama_kategori) ?>"><?= esc($kat->nama_kategori) ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kode Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Harga</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kategori</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Input By</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>
                </tr>
            </thead>
            <tbody id="produkTableBody">
                <?php if (!empty($produk)): ?>
                    <?php foreach ($produk as $row): ?>
                        <tr>
                            <td><?= esc($row->kode_barang) ?></td>
                            <td><?= esc($row->nama_barang) ?></td>
                            <td><?= 'Rp ' . number_format($row->harga, 0, ',', '.') ?></td>
                            <td><?= esc($row->nama_kategori) ?></td>


                            <td><?= esc($row->input) ?></td>
                            <td><button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-produk-modal" data-id_barang="<?= esc($row->idbarang) ?>"
                                    data-kode_barang="<?= esc($row->kode_barang) ?>"
                                    data-nama_barang="<?= esc($row->nama_barang) ?>" data-harga="<?= esc($row->harga) ?>"
                                    data-input_by="<?= esc($row->input) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                </button>
                                <button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal"
                                    data-bs-target="#delete-produk-modal" data-id_barang="<?= esc($row->idbarang) ?>">
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
                <form action="<?php echo base_url('produk/import/produk') ?>" enctype="multipart/form-data" method="post">
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

<!-- //modal EditProduk -->
<div class="modal fade" id="edit-produk-modal" tabindex="-1" aria-labelledby="inputProdukModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputProdukModalLabel">
                    Edit Data Barang
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produk/update_produk') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" hidden name="id_barang" id="id_barang">
                        <label hidden for="kode_barang" class="form-label">Kode Barang</label>
                        <input hidden type="text" class="form-control" id="kode_barang" name="kode_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="id_kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k->nama_kategori; ?>"><?= $k->nama_kategori; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <!-- Removed the value field -->
                            <input type="text" class="form-control currency" id="edit-harga" name="harga" required>
                        </div>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="input_by" class="form-label">Input By</label>
                        <input type="text" class="form-control"  id="input_by" name="input_by" readonly>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->


<!-- //modal Input Produk -->
<div class="modal fade" id="input-produk-modal" tabindex="-1" aria-labelledby="inputProdukModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputProdukModalLabel">
                    Input Data Barang
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produk/insert_produk') ?>" method="post">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="id_kategori" name="kategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k->nama_kategori; ?>"><?= $k->nama_kategori; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <!-- Removed the value field -->
                            <input type="text" class="form-control currency" id="edit-harga" name="harga" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="input_by" class="form-label">Input By</label>
                        <input type="text" class="form-control" value="<?php echo @$akun->NAMA_AKUN ?>" id="input_by" name="input_by" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->


<!-- Modal Alert Sukses -->
<!-- Modal Alert Sukses -->



<!-- //modal Delete Produk -->
<div class="modal fade" id="delete-produk-modal" tabindex="-1" aria-labelledby="inputProdukModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputProdukModalLabel">
                    Delete Data Produk
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo base_url('produk/delete_produk') ?>" method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <input type="text" id="id_barang_delete" hidden name="id_barang">
                        <p style="font-style: italic;">Apa anda yakin ingin menghapus data ini?</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function handleColorTheme(e) {
        $("html").attr("data-color-theme", e);
        $(e).prop("checked", true);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#zero_config').addEventListener('click', function(e) {
            if (e.target.closest('.edit-button')) {
                const button = e.target.closest('.edit-button');

                const id_barang = button.getAttribute('data-id_barang');
                const kode_barang = button.getAttribute('data-kode_barang');
                const nama_barang = button.getAttribute('data-nama_barang');
                const harga = button.getAttribute('data-harga');
                const lokasi = button.getAttribute('data-lokasi');
                const input_by = button.getAttribute('data-input_by');

                document.getElementById('id_barang').value = id_barang;
                document.getElementById('kode_barang').value = kode_barang;
                document.getElementById('nama_barang').value = nama_barang;
                document.getElementById('edit-harga').value = harga;
                document.getElementById('lokasi').value = lokasi;
                document.getElementById('input_by').value = input_by;
            }

            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                const id_barang = button.getAttribute('data-id_barang');
                document.getElementById('id_barang_delete').value = id_barang;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#zero_config').DataTable();

        // Saat dropdown berubah
        $('#filterKategori').on('change', function() {
            var selected = $(this).val();
            if (selected) {
                table.column(3).search('^' + selected + '$', true, false).draw();
            } else {
                table.column(3).search('').draw();
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