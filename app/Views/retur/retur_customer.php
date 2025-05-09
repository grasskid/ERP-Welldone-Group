<?php
$grouped_penjualan = [];
foreach ($detail_penjualan as $row) {
    $grouped_penjualan[$row->kode_invoice][] = $row;
}
?>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Retur Penjualan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Retur</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2 mb-1"></div>

    <div class="row px-4 mb-3">
        <div class="table-responsive mb-4 px-4">
            <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grouped_penjualan)): ?>
                        <?php foreach ($grouped_penjualan as $kode_invoice => $items): ?>
                            <?php $first = $items[0]; ?>
                            <tr>
                                <td><?= esc($kode_invoice) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($first->tanggal))) ?></td>
                                <td><?= esc($first->nama_barang) ?>, ...</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= esc($kode_invoice) ?>"
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
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($grouped_penjualan as $kode_invoice => $items): ?>
    <!-- Modal for each invoice -->
    <div class="modal fade" id="modalDetail<?= esc($kode_invoice) ?>" tabindex="-1"
        aria-labelledby="modalLabel<?= esc($kode_invoice) ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan - Invoice <?= esc($kode_invoice) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('insert_retur_customer') ?>" method="post">
                        <input type="hidden" name="kode_invoice" value="<?= esc($kode_invoice) ?>">
                        <div class="table-responsive">
                            <table class="table table-bordered detail-table" id="detailTable<?= esc($kode_invoice) ?>">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Jual</th>
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
                                                <input type="hidden" name="items[<?= $index ?>][iddetail_penjualan]" value="<?= esc($item->iddetail_penjualan) ?>">
                                            </td>
                                            <td><?= esc($item->nama_barang) ?></td>
                                            <td><?= esc($item->jumlah) ?></td>
                                            <td><?= esc(number_format($item->harga_penjualan, 0, ',', '.')) ?></td>
                                            <td><?= esc(number_format($item->diskon_penjualan, 0, ',', '.')) ?></td>
                                            <td><?= esc(number_format($item->sub_total, 0, ',', '.')) ?></td>
                                            <td>
                                                <input type="number" class="form-control" name="items[<?= $index ?>][jumlah_retur]" min="1" max="<?= esc($item->jumlah) ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="items[<?= $index ?>][satuan]" value="<?= esc($item->satuan_jual) ?>" readonly>

                                                <input type="hidden" name="items[<?= $index ?>][jumlah]" value="<?= esc($item->jumlah) ?>">
                                                <input type="hidden" name="items[<?= $index ?>][barang_idbarang]" value="<?= esc($item->barang_idbarang) ?>">
                                                <input type="hidden" name="items[<?= $index ?>][unit_idunit]" value="<?= esc($item->unit_idunit) ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-success">Simpan Retur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('#zero_config').DataTable();
        $('.detail-table').DataTable();
    });
</script>