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
        <input type="text" class="form-control" name="diskon" value="0" readonly id="diskon_sparepart"
            onchange="updateTotalHarga()">
    </div>


    <div class="mb-4">
        <label class="form-label">Harga Akhir</label>
        <input type="text" class="form-control" name="harga_akhir" readonly id="harga_akhir_sparepart"
            onchange="updateTotalHarga()">
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

            oldSpareparts.forEach((sp) => {
                addSparepartRow(sp.barang_idbarang, sp.nama_barang, parseFloat(sp.harga_penjualan),
                    parseInt(sp.jumlah), parseFloat(sp.diskon_penjualan));

                // Centang checkbox lama
                const checkbox = document.querySelector(
                    `.sparepart-check[data-id="${sp.barang_idbarang}"]`);
                if (checkbox) checkbox.checked = true;
            });

            updateTotals();
        });

        // Tambah sparepart dari modal
        document.getElementById('add-selected-sparepart').addEventListener('click', () => {
            document.querySelectorAll('.sparepart-check:checked').forEach((checkbox) => {
                const id = checkbox.getAttribute('data-id');
                const nama = checkbox.getAttribute('data-nama');
                const harga = parseFloat(checkbox.getAttribute('data-harga'));

                // Cek apakah sparepart sudah ada di tabel
                if (!document.getElementById(`row-${id}`)) {
                    addSparepartRow(id, nama, harga, 1, 0);
                }
            });

            updateTotals();
        });

        // Tambahkan baris sparepart
        function addSparepartRow(id, nama, harga, jumlah = 1, diskon = 0) {
            const tbody = document.getElementById('sparepart-table-body');

            // Tentukan index terakhir yang belum terpakai
            const rows = tbody.querySelectorAll('tr');
            const nextIndex = rows.length;

            const row = document.createElement('tr');
            row.id = `row-${id}`;
            row.innerHTML = `
            <td>
                ${nama}
                <input type="hidden" name="produk[${nextIndex}][id]" value="${id}">
            </td>
            <td><input type="text" class="form-control harga" name="produk[${nextIndex}][harga]" value="Rp ${formatNumber(harga)}"></td>
            <td><input type="number" class="form-control qty" name="produk[${nextIndex}][jumlah]" value="${jumlah}" min="1"></td>
            <td><input type="text" class="form-control diskon-item" name="produk[${nextIndex}][diskon]" value="Rp ${formatNumber(diskon)}" min="0"></td>
            <td><input type="text" class="form-control total" name="produk[${nextIndex}][total]" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
        `;
            tbody.appendChild(row);
        }

        // Event: hapus baris
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                const tr = e.target.closest('tr');
                if (tr) tr.remove();
                updateTotals();
            }
        });

        // Event: hitung ulang saat input berubah
        document.addEventListener('input', function(e) {
            if (
                e.target.classList.contains('qty') ||
                e.target.classList.contains('harga') ||
                e.target.classList.contains('diskon-item')
            ) {
                if (e.target.classList.contains('harga') || e.target.classList.contains('diskon-item')) {
                    formatInputRupiah(e.target);
                }
                updateTotals();
            }
        });

        // Format number with thousand separators (e.g. 10000 -> 10.000)
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Format input field with Rupiah currency style on typing
        function formatInputRupiah(input) {
            let cursorPos = input.selectionStart;
            let originalLength = input.value.length;

            // Remove all non-digit characters
            let numbersOnly = input.value.replace(/[^0-9]/g, '');

            if (numbersOnly === '') {
                input.value = '';
                return;
            }

            let number = parseInt(numbersOnly, 10);

            if (isNaN(number)) {
                input.value = '';
                return;
            }

            // Format number to Rupiah string
            let formatted = 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            input.value = formatted;

            // Adjust cursor position after formatting
            let newLength = formatted.length;
            cursorPos = cursorPos + (newLength - originalLength);
            input.setSelectionRange(cursorPos, cursorPos);
        }

        // Parse formatted Rupiah string to number
        function parseRupiah(rupiahString) {
            if (!rupiahString) return 0;
            // Remove Rp and dots
            let numberString = rupiahString.replace(/[^0-9]/g, '');
            return parseInt(numberString, 10) || 0;
        }

        // Update total & diskon
        function updateTotals() {
            let totalHarga = 0;
            let totalDiskon = 0;

            document.querySelectorAll('#sparepart-table-body tr').forEach(row => {
                const harga = parseRupiah(row.querySelector('.harga')?.value) || 0;
                const qty = parseInt(row.querySelector('.qty')?.value) || 0;
                const diskon = parseRupiah(row.querySelector('.diskon-item')?.value) || 0;

                const subtotal = harga * qty;
                const total = subtotal - diskon;

                row.querySelector('.total').value = 'Rp ' + formatNumber(total);

                totalHarga += subtotal;
                totalDiskon += diskon;
            });

            document.querySelector('[name="total_harga"]').value = 'Rp ' + formatNumber(totalHarga);
            document.getElementById('diskon_sparepart').value = 'Rp ' + formatNumber(totalDiskon);
            document.getElementById('harga_akhir_sparepart').value = 'Rp ' + formatNumber(totalHarga - totalDiskon);

            updateTotalHarga();
        }

        // Optional: update total ke input pembayaran (jika ada tab selanjutnya)
        function updateTotalHarga() {
            const harga = document.getElementById('harga_akhir_sparepart').value;
            const diskon_akhir = document.getElementById('diskon_sparepart').value;

            // Assuming you have inputs with these IDs elsewhere in your form/page:
            if (document.getElementById('total_harga_pembayaran')) {
                document.getElementById('total_harga_pembayaran').value = harga;
            }
            if (document.getElementById('diskon_pembayaran')) {
                document.getElementById('diskon_pembayaran').value = diskon_akhir;
            }
        }

        // Jika ada perubahan manual di diskon akhir
        document.getElementById('diskon_sparepart').addEventListener('input', updateTotals);
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