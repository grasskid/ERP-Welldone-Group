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

    <br>


    <div class="mb-3 px-4">
        <label class="me-2">Filter Kategori:</label>
        <select id="kategoriFilter" class="form-select d-inline" style="width: auto; display: inline-block;" onchange="filterKategori()">
            <option value="">Semua Kategori</option>
            <?php
            $kategoriList = [];
            foreach ($produk as $row) {
                if (!in_array($row->nama_kategori, $kategoriList)) {
                    $kategoriList[] = $row->nama_kategori;
                    echo '<option value="' . esc($row->nama_kategori) . '">' . esc($row->nama_kategori) . '</option>';
                }
            }
            ?>
        </select>

        <label class="me-2 ms-4">Filter PPN:</label>
        <select id="ppnFilter" class="form-select d-inline" style="width: auto; display: inline-block;" onchange="filterKategori()">
            <option value="">Semua</option>
            <option value="PPN">PPN</option>
            <option value="Non PPN">Non PPN</option>
        </select>


        <button onclick="resetKategoriFilter()" class="btn btn-sm btn-secondary ms-2">Reset</button>
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
                        <h6 class="fs-4 fw-semibold mb-0">Harga Beli</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kategori</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status PPN</h6>
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
                            <td><?= 'Rp ' . number_format($row->harga_beli, 0, ',', '.') ?></td>
                            <td><?= esc($row->nama_kategori) ?></td>
                            <td><?= $row->status_ppn == 1 ? 'PPN' : 'Non PPN' ?></td>



                            <td><?= esc($row->input) ?></td>
                            <td><button type="button" class="btn btn-warning edit-button" data-bs-toggle="modal"
                                    data-bs-target="#edit-produk-modal" data-id_barang="<?= esc($row->idbarang) ?>"
                                    data-kode_barang="<?= esc($row->kode_barang) ?>"
                                    data-nama_barang="<?= esc($row->nama_barang) ?>" data-harga="<?= esc($row->harga) ?>"
                                    data-harga_beli="<?= esc($row->harga_beli) ?>"
                                    data-kategori="<?= esc($row->nama_kategori) ?>"
                                    data-ppn="<?= esc($row->status_ppn) ?>"
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
                <form action="<?php echo base_url('produk/import/produk') ?>" enctype="multipart/form-data"
                    method="post">
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
                <h4 class="modal-title" id="inputProdukModalLabel">Edit Data Barang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produk/update_produk') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_barang" id="id_barang">
                    <input type="hidden" class="form-control" id="kode_barang" name="kode_barang">

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
                        <label for="edit-harga" class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="edit-harga" name="harga" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-harga-beli" class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control currency" id="edit-harga-beli" name="harga_beli"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-ppn-status" class="form-label">Status PPN</label>
                        <select class="form-control" id="edit-ppn-status" name="status_ppn" required>
                            <option value="">-- Pilih Status PPN --</option>
                            <option value="1">PPN</option>
                            <option value="0">Non PPN</option>
                        </select>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="input_by" class="form-label">Input By</label>
                        <input type="text" class="form-control" id="input_by" name="input_by" readonly>
                    </div> -->
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

<!-- //modal Input Produk -->
<div class="modal fade" id="input-produk-modal" tabindex="-1" aria-labelledby="inputProdukModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="inputProdukModalLabel">Input Data Barang</h4>
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
                        <label for="ppn_status" class="form-label">Status PPN</label>
                        <select class="form-control" id="ppn_status" name="status_ppn" required>
                            <option value="">-- Pilih Status PPN --</option>
                            <option value="1">PPN</option>
                            <option value="0">Non PPN</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="input_by" class="form-label">Input By</label>
                        <input type="text" class="form-control" value="<?= @$akun->NAMA_AKUN ?>" id="input_by"
                            name="input_by" required>
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
    let table;

    window.onload = function() {
        table = $('#zero_config').DataTable();


        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const kategoriFilter = $('#kategoriFilter').val().toLowerCase();
            const ppnFilter = $('#ppnFilter').val().toLowerCase();

            const kategori = data[4].toLowerCase();
            const ppn = data[5].toLowerCase();

            const matchKategori = !kategoriFilter || kategori === kategoriFilter;
            const matchPPN = !ppnFilter || ppn === ppnFilter;

            return matchKategori && matchPPN;
        });


        const kategoriSelect = document.getElementById('kategoriFilter');
        const ppnSelect = document.getElementById('ppnFilter');

        if (kategoriSelect && kategoriSelect.options.length > 1) {
            kategoriSelect.selectedIndex = 1;
        }
        if (ppnSelect && ppnSelect.options.length > 1) {
            ppnSelect.selectedIndex = 1;
        }


        table.draw();
    };

    function filterKategori() {
        table.draw();
    }

    function resetKategoriFilter() {
        $('#kategoriFilter').val('');
        $('#ppnFilter').val('');
        table.draw();
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
                const harga_beli = button.getAttribute('data-harga_beli');
                const kategori = button.getAttribute('data-kategori');
                // const lokasi = button.getAttribute('data-lokasi');
                const ppn = button.getAttribute('data-ppn');

                const input_by = button.getAttribute('data-input_by');

                document.getElementById('id_barang').value = id_barang;
                document.getElementById('kode_barang').value = kode_barang;
                document.getElementById('nama_barang').value = nama_barang;
                document.getElementById('edit-harga').value = parseInt(harga.replace(/[^\d]/g, ''));
                document.getElementById('edit-harga-beli').value = parseInt(harga_beli.replace(/[^\d]/g,
                    ''));
                document.getElementById('id_kategori').value = kategori;
                // document.getElementById('lokasi').value = lokasi;
                document.getElementById('edit-ppn-status').value = ppn;
                document.getElementById('input_by').value = input_by;
            }

            if (e.target.closest('.delete-button')) {
                const button = e.target.closest('.delete-button');
                const id_barang = button.getAttribute('data-id_barang');
                document.getElementById('id_barang_delete').value = id_barang;
            }
        });

        // Currency formatting using Cleave.js
        document.querySelectorAll('.currency').forEach(function(el) {
            new Cleave(el, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        });
    });
</script>