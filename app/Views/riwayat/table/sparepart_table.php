<form action="" id="form-sparepart">
    <div class="mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sparepartModal">
            Tambah Sparepart
        </button>
    </div>
    <br>

    <div class="modal fade" id="sparepartModal" tabindex="-1" aria-labelledby="sparepartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Sparepart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="sparepartDataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama Sparepart</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sparepart as $s) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="sparepart-check" data-id="<?= esc($s->idbarang) ?>"
                                            data-nama="<?= esc($s->nama_barang) ?>" data-harga="<?= esc($s->harga) ?>">
                                    </td>
                                    <td><?= esc($s->nama_barang) ?></td>
                                    <td><?= esc(number_format($s->harga, 0, ',', '.')) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="add-selected-sparepart" class="btn btn-success"
                        data-bs-dismiss="modal">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Sparepart</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody id="sparepart-table-body">

        </tbody>
    </table>

    <div class="mb-3">
        <label class="form-label">Total Harga</label>
        <input type="text" class="form-control" name="total_harga" readonly>
    </div>

    <input type="text" hidden name="idservice" value="<?php echo @$idservice ?>" id="">

    <div class="mb-3">
        <label class="form-label">Garansi</label>
        <select class="form-select" name="garansi">
            <option disabled <?php echo @$lama_garansi === null ? 'selected' : '' ?>>---Pilih Garansi_hari---</option>
            <option value="0" <?php echo @$lama_garansi == 0 ? 'selected' : '' ?>>Tidak Ada</option>
            <option value="7" <?php echo @$lama_garansi == 7 ? 'selected' : '' ?>>1 Minggu</option>
            <option value="30" <?php echo @$lama_garansi == 30 ? 'selected' : '' ?>>1 Bulan</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Total Diskon</label>
        <input type="text" class="form-control" name="diskon" value="0" readonly>
    </div>


    <div class="mb-4">
        <label class="form-label">Harga Akhir</label>
        <input type="text" class="form-control" name="harga_akhir" readonly>
    </div>

    <div style="display: flex; justify-content: space-between;">
        <div>
            <button type="button" class="btn btn-light" id="btn-previous-to-kerusakan">Sebelumnya</button>
            <button type="button" class="btn btn-success" id="btn-next-to-pembayaran">Selanjutnya</button>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#sparepartDataTable').DataTable();
        });

        const oldSpareparts = <?= json_encode($oldsparepart) ?>;

        document.addEventListener('DOMContentLoaded', () => {
            const tbody = document.getElementById('sparepart-table-body');

            oldSpareparts.forEach((sp, index) => {
                const id = sp.barang_idbarang;
                const nama = sp.nama_barang; // pastikan field ini tersedia dari join
                const harga = parseFloat(sp.harga_penjualan);
                const jumlah = parseInt(sp.jumlah);
                const diskon = parseFloat(sp.diskon_penjualan);
                const total = harga * jumlah - diskon;

                // tandai checkbox sebagai tercentang
                const checkbox = document.querySelector(`.sparepart-check[data-id="${id}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }

                // buat baris di tabel
                const row = document.createElement('tr');
                row.id = `row-${id}`;
                row.innerHTML = `
                <td>
                    ${nama}
                    <input type="hidden" name="produk[${index}][id]" value="${id}">
                </td>
                <td><input type="number" class="form-control harga" name="produk[${index}][harga]" value="${harga}"></td>
                <td><input type="number" class="form-control qty" name="produk[${index}][jumlah]" value="${jumlah}" min="1"></td>
                <td><input type="number" class="form-control diskon-item" name="produk[${index}][diskon]" value="${diskon}" min="0"></td>
                <td><input type="text" class="form-control total" name="produk[${index}][total]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
            `;
                tbody.appendChild(row);
            });

            updateTotals();
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty') || e.target.classList.contains('harga')) {
                updateTotals();
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
                updateTotals();
            }
        });

        document.addEventListener('input', function(e) {
            if (
                e.target.classList.contains('qty') ||
                e.target.classList.contains('harga') ||
                e.target.classList.contains('diskon-item')
            ) {
                updateTotals();
            }
        });


        function updateTotals() {
            let totalHarga = 0;
            let totalDiskon = 0;

            document.querySelectorAll('#sparepart-table-body tr').forEach(row => {
                const harga = parseFloat(row.querySelector('.harga').value) || 0;
                const qty = parseInt(row.querySelector('.qty').value) || 0;
                const diskonItem = parseFloat(row.querySelector('.diskon-item').value) || 0;

                const subtotal = harga * qty;
                const total = subtotal - diskonItem;

                row.querySelector('.total').value = total.toLocaleString('id-ID');

                totalHarga += subtotal;
                totalDiskon += diskonItem;
            });

            document.querySelector('[name="total_harga"]').value = totalHarga.toLocaleString('id-ID');
            document.querySelector('[name="diskon"]').value = totalDiskon.toLocaleString('id-ID');
            document.querySelector('[name="harga_akhir"]').value = (totalHarga - totalDiskon).toLocaleString('id-ID');
        }


        document.querySelector('[name="diskon"]').addEventListener('input', updateTotals);
    </script>
</form>

<script>
    document.getElementById('btn-next-to-pembayaran').addEventListener('click', function() {
        var tabTrigger = new bootstrap.Tab(document.querySelector('#pembayaran-tab'));
        tabTrigger.show();
    });

    document.getElementById('btn-previous-to-kerusakan').addEventListener('click', function() {
        var tabTrigger = new bootstrap.Tab(document.querySelector('#kerusakan-tab'));
        tabTrigger.show();
    });
</script>