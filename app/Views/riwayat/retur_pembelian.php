<?php
$grouped_pembelian = [];
foreach ($returpembelian as $row) {
    $grouped_pembelian[$row->no_retur_suplier][] = $row;
}
?>


<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Retur Pembelian</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Retur Pembelian</li>
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
                            <h6 class="fs-4 fw-semibold mb-0">No. Retur Suplier</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grouped_pembelian)): ?>
                        <?php foreach ($grouped_pembelian as $no_retur_suplier => $items): ?>
                            <?php $row = $items[0]; ?>
                            <tr>
                                <td><?= esc($row->no_retur_suplier) ?></td>

                                <td><?= esc(date('d-m-Y', strtotime($row->tanggal))) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= esc($no_retur_suplier) ?>"
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


    <?php foreach ($grouped_pembelian as $no_retur_suplier => $items): ?>
        <!-- Modal for each invoice -->
        <div class="modal fade" id="modalDetail<?= esc($no_retur_suplier) ?>" tabindex="-1"
            aria-labelledby="modalLabel<?= esc($no_retur_suplier) ?>" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail pembelian - No. Batch <?= esc($no_retur_suplier) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered detail-table" id="detailTable<?= esc($no_retur_suplier) ?>">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= esc($item->nama_barang) ?></td>
                                            <td><?= esc($item->jumlah) ?></td>
                                            <td><?= esc($item->satuan) ?></td>
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