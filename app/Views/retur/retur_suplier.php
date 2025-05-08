<?php
$grouped_pembelian = [];
foreach ($detail_pembelian as $row) {
    $grouped_pembelian[$row->no_batch][] = $row;
}
?>


<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Retur Pembelian</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Retur</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pembelian</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">
        <div class="d-flex gap-2"></div>
    </div>

    <div class="row px-4 mb-3">

        <!-- <form method="get" action="<?= base_url('riwayat_pembelian') ?>">
            <div class="row px-4 mb-3">
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="<?= esc($_GET['tanggal_awal'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="<?= esc($_GET['tanggal_akhir'] ?? '') ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form> -->


        <div class="table-responsive mb-4 px-4">
            <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No. Batch</h6>
                        </th>

                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Jumlah</h6>
                        </th>


                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Total Harga</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grouped_pembelian)): ?>
                    <?php foreach ($grouped_pembelian as $no_batch => $items): ?>
                    <?php $row = $items[0]; ?>
                    <tr>
                        <td><?= esc($row->no_batch) ?></td>

                        <td><?= esc(date('d-m-Y', strtotime($row->tanggal))) ?></td>
                        <td><?= esc($row->jumlah) ?></td>

                        <td><?= esc(number_format($row->total_harga, 0, ',', '.')) ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalDetail<?= esc($no_batch) ?>"
                                style="display: inline-flex; align-items: center;">
                                <iconify-icon icon="solar:folder-favourite-bookmark-broken" width="24" height="24">
                                </iconify-icon>
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php foreach ($grouped_pembelian as $no_batch => $items): ?>
    <!-- Modal for each invoice -->
    <div class="modal fade" id="modalDetail<?= esc($no_batch) ?>" tabindex="-1"
        aria-labelledby="modalLabel<?= esc($no_batch) ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail pembelian - No. Batch <?= esc($no_batch) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered detail-table" id="detailTable<?= esc($no_batch) ?>">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Diskon</th>
                                    <th>SubTotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= esc($item->nama_barang) ?></td>
                                    <td><?= esc($item->jumlah) ?></td>
                                    <td><?= esc(number_format($item->hrg_beli, 0, ',', '.')) ?></td>
                                    <td><?= esc(number_format($item->diskon, 0, ',', '.')) ?></td>
                                    <td><?= esc(number_format($item->total_harga, 0, ',', '.')) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btnReturPembelian"
                                            data-nama="<?= esc($item->nama_barang) ?>"
                                            data-batch="<?= esc($no_batch) ?>"
                                            data-satuan="<?= esc($item->satuan_beli) ?>"
                                            data-iddetail_pembelian="<?= esc($item->iddetail_pembelian) ?>"
                                            data-jumlahval="<?= esc($item->jumlah) ?>"
                                            data-barang_idbarang="<?= esc($item->barang_idbarang) ?>"
                                            data-bs-dismiss="modal">
                                            Retur
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Global Retur Modal -->
    <div class="modal fade" id="modalReturPembelian" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Retur Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="formReturPembelian" enctype="multipart/form-data" method="post"
                        action="<?php echo base_url('insert_retur_suplier') ?>">

                        <div class="mb-3">
                            <label hidden for="iddetail_pembelian" class="form-label">iddetail_pembelian</label>
                            <input type="number" class="form-control" id="iddetail_pembelian" name="iddetail_pembelian"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label hidden for="barang_idbarang" class="form-label">barang_idbarang</label>
                            <input hidden type="text" class="form-control" id="barang_idbarang" name="barang_idbarang"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="no_batch_retur" class="form-label">No. Batch</label>
                            <input type="text" class="form-control" id="no_batch_retur" name="no_batch" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="namaBarang_retur" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang_retur" name="nama_barang" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="satuan_retur" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan_retur" name="satuan" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_retur" class="form-label">Jumlah Retur</label>
                            <input type="number" class="form-control" id="jumlah_retur" name="jumlah">
                        </div>
                        <div class="mb-3">
                            <label hidden for="jumlahval" class="form-label">Jumlah Retur</label>
                            <input hidden type="number" class="form-control" id="jumlahval" name="jumlahval">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Retur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>







    <script>
    $(document).ready(function() {
        var table = $('#zero_config').DataTable();

        $(document).ready(function() {
            $('.detail-table').each(function() {
                $(this).DataTable();
            });
        });



        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var filterValue = $('#filterDate').val();
            if (!filterValue) return true;

            var selectedDate = new Date(filterValue);

            var tableDateStr = data[1];

            var parts = tableDateStr.split('-');
            if (parts.length !== 3) return false;

            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var year = parseInt(parts[2], 10);
            var tableDate = new Date(year, month, day);

            return tableDate.toDateString() === selectedDate.toDateString();
        });

        $('#filterDate').on('change', function() {
            table.draw();
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        let returPembelianData = null;

        $('.btnReturPembelian').on('click', function() {
            returPembelianData = {
                nama: $(this).data('nama'),
                satuan: $(this).data('satuan'),
                batch: $(this).data('batch'),
                iddetail_pembelian: $(this).data('iddetail_pembelian'),
                barang_idbarang: $(this).data('barang_idbarang'),
                jumlahval: $(this).data('jumlahval')
            };
        });

        $('.modal').on('hidden.bs.modal', function() {
            if (returPembelianData) {
                $('#namaBarang_retur').val(returPembelianData.nama);
                $('#satuan_retur').val(returPembelianData.satuan);
                $('#no_batch_retur').val(returPembelianData.batch);
                $('#iddetail_pembelian').val(returPembelianData.iddetail_pembelian);
                $('#barang_idbarang').val(returPembelianData.barang_idbarang);
                $('#jumlahval').val(returPembelianData.jumlahval);
                $('#modalReturPembelian').modal('show');
                returPembelianData = null;
            }
        });

        $('#modalReturPembelian').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
        });
    });
    </script>