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
                                        data-bs-target="#modalDetail<?= esc($no_batch) ?>">
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
        <div class="modal fade" id="modalDetail<?= esc($no_batch) ?>" tabindex="-1"
            aria-labelledby="modalLabel<?= esc($no_batch) ?>" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="<?= base_url('insert_retur_suplier') ?>" method="post">
                        <input type="hidden" name="no_batch" value="<?= esc($no_batch) ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail pembelian - No. Batch <?= esc($no_batch) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered detail-table" id="detailTable<?= esc($no_batch) ?>">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga Beli</th>
                                            <th>Diskon</th>
                                            <th>SubTotal</th>
                                            <th>Jumlah Retur</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $index => $item): ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="items[<?= $index ?>][selected]" value="1">
                                                    <input type="hidden" name="items[<?= $index ?>][iddetail_pembelian]"
                                                        value="<?= esc($item->iddetail_pembelian) ?>">
                                                </td>
                                                <td><?= esc($item->nama_barang) ?></td>
                                                <td><?= esc($item->jumlah) ?></td>
                                                <td><?= esc(number_format($item->hrg_beli, 0, ',', '.')) ?></td>
                                                <td><?= esc(number_format($item->diskon, 0, ',', '.')) ?></td>
                                                <td><?= esc(number_format($item->total_harga, 0, ',', '.')) ?></td>
                                                <td>
                                                    <input type="number" name="items[<?= $index ?>][jumlah_retur]"
                                                        class="form-control" min="1" max="<?= esc($item->jumlah) ?>">
                                                </td>
                                                <td>
                                                    <input readonly type="text" name="items[<?= $index ?>][satuan]" value="<?= esc($item->satuan_beli) ?>" class="form-control">
                                                    <input hidden type="text" name="items[<?= $index ?>][jumlah]" value="<?= esc($item->jumlah) ?>" class="form-control">
                                                    <input hidden type="text" name="items[<?= $index ?>][barang_idbarang]" value="<?= esc($item->barang_idbarang) ?>" class="form-control">
                                                    <input hidden type="text" name="items[<?= $index ?>][iddetail_pembelian]" value="<?= esc($item->iddetail_pembelian) ?>" class="form-control">
                                                    <input hidden type="text" name="items[<?= $index ?>][unit_idunit]" value="<?= esc($item->unit_idunit) ?>" class="form-control">

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan Retur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        $(document).ready(function() {
            $('#zero_config').DataTable();
            $('.detail-table').each(function() {
                $(this).DataTable();
            });
        });
    </script>
</div>