<?php
$grouped_penjualan = [];
foreach ($retur_penjualan as $row) {
    $grouped_penjualan[$row->no_retur_pelanggan][] = $row;
}
?>

<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Retur Penjualan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat Retur</a>
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
                        <th>No. Retur Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($grouped_penjualan)): ?>
                        <?php foreach ($grouped_penjualan as $no_retur_pelanggan => $items): ?>
                            <?php $first = $items[0]; ?>
                            <tr>
                                <td><?= esc($no_retur_pelanggan) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($first->tanggal))) ?></td>
                                <td><?= esc($first->nama_barang) ?>, ...</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail<?= esc($no_retur_pelanggan) ?>"
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
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($grouped_penjualan as $no_retur_pelanggan => $items): ?>
    <!-- Modal for each No. Retur Pelanggan -->
    <div class="modal fade" id="modalDetail<?= esc($no_retur_pelanggan) ?>" tabindex="-1"
        aria-labelledby="modalLabel<?= esc($no_retur_pelanggan) ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan - No. Retur Pelanggan <?= esc($no_retur_pelanggan) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered detail-table" id="detailTable<?= esc($no_retur_pelanggan) ?>">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Jual</th>
                                    <th>Diskon</th>
                                    <th>SubTotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?= esc($item->nama_barang) ?></td>
                                        <td><?= esc($item->jumlah) ?></td>
                                        <td><?= esc(number_format($item->harga_penjualan, 0, ',', '.')) ?></td>
                                        <td><?= esc(number_format($item->diskon_penjualan, 0, ',', '.')) ?></td>
                                        <td><?= esc(number_format($item->sub_total, 0, ',', '.')) ?></td>
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
        $('#zero_config').DataTable();
        $('#detailTable').DataTable({

        });

    });
</script>