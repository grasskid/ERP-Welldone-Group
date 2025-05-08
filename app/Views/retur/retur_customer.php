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
                        <td colspan="8" class="text-center">Tidak ada data</td>
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
                <div class="table-responsive">
                    <table class="table table-bordered detail-table" id="detailTable<?= esc($kode_invoice) ?>">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
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
                                <td><?= esc(number_format($item->harga_penjualan, 0, ',', '.')) ?></td>
                                <td><?= esc(number_format($item->diskon_penjualan, 0, ',', '.')) ?></td>
                                <td><?= esc(number_format($item->sub_total, 0, ',', '.')) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning btnRetur"
                                        data-nama="<?= esc($item->nama_barang) ?>" data-kode="<?= esc($kode_invoice) ?>"
                                        data-satuan="<?= esc($item->satuan_jual) ?>"
                                        data-jumlahval="<?= esc($item->jumlah) ?>"
                                        data-iddetail_penjualan="<?= esc($item->iddetail_penjualan) ?>"
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

<div class="modal fade" id="modalReturForm" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Retur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="formRetur" method="post" action="<?php echo base_url('insert_retur_customer') ?>"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label hidden for="iddetail_penjualan" class="form-label">iddetail_penjualan</label>
                        <input hidden type="text" class="form-control" id="iddetail_penjualan"
                            name="iddetail_penjualan">
                    </div>
                    <div class="mb-3">
                        <label hidden for="barang_idbarang" class="form-label">barang_idbarang</label>
                        <input hidden type="text" class="form-control" id="barang_idbarang" name="barang_idbarang">
                    </div>
                    <div class="mb-3">
                        <label for="kode_invoice_retur" class="form-label">No Retur</label>
                        <input type="text" class="form-control" id="kode_invoice_retur" name="kode_invoice">
                    </div>
                    <div class="mb-3">
                        <label for="namaBarang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="namaBarang" name="nama_barang" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan">
                    </div>
                    <div class="mb-3">
                        <label hidden for="jumlahval" class="form-label">jumlahval</label>
                        <input type="number" hidden class="form-control" id="jumlahval" name="jumlahval" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Retur</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#zero_config').DataTable();
    $('.detail-table').DataTable();

    let returData = null;

    // Store data and wait for modal to close
    $('.btnRetur').on('click', function() {
        returData = {
            nama: $(this).data('nama'),
            satuan: $(this).data('satuan'),
            kode: $(this).data('kode'),
            jumlahval: $(this).data('jumlahval'),
            iddetail_penjualan: $(this).data('iddetail_penjualan'),
            barang_idbarang: $(this).data('barang_idbarang'),
        };
    });

    // When any modal is hidden, open the return modal
    $('.modal').on('hidden.bs.modal', function() {
        if (returData) {
            $('#namaBarang').val(returData.nama);
            $('#satuan').val(returData.satuan);
            $('#kode_invoice_retur').val(returData.kode);
            $('#jumlahval').val(returData.jumlahval);
            $('#iddetail_penjualan').val(returData.iddetail_penjualan);
            $('#barang_idbarang').val(returData.barang_idbarang);
            $('#modalReturForm').modal('show');
            returData = null;
        }
    });

    // Optional: Clean up any stray backdrops on modal close
    $('#modalReturForm').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });



});
</script>