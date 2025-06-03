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
                                <td><?= 'Rp ' . number_format($s->harga, 0, ',', '.') ?></td>
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
            <option selected disabled>---Pilih Garansi---</option>
            <option value="0">Tidak Ada</option>
            <option value="7">1 Minggu</option>
            <option value="30">1 Bulan</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Total Diskon</label>
        <input type="text" class="form-control" name="diskon" id="diskon_sparepart" value="Rp 0" readonly>
    </div>

    <div class="mb-4">
        <label class="form-label">Harga Akhir</label>
        <input type="text" class="form-control" id="harga_akhir_sparepart" name="harga_akhir" value="Rp 0" readonly>
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

    // Format number as Rp currency string
    function formatRupiah(angka) {
        if (!angka) angka = 0;
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Parse Rp formatted string to number
    function parseRupiah(rpString) {
        if (!rpString) return 0;
        // Remove anything except digits
        return parseInt(rpString.replace(/[^0-9]/g, '')) || 0;
    }

    // Add selected sparepart rows to the table
    document.getElementById('add-selected-sparepart').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.sparepart-check:checked');
        const tbody = document.getElementById('sparepart-table-body');
        const currentIndex = tbody.children.length;

        checkboxes.forEach((cb, index) => {
            const id = cb.dataset.id;
            const nama = cb.dataset.nama;
            const hargaRaw = parseFloat(cb.dataset.harga);

            if (document.querySelector(`#row-${id}`)) return;

            const rowIndex = currentIndex + index;

            const row = document.createElement('tr');
            row.id = `row-${id}`;
            row.innerHTML = `
                <td>
                    ${nama}
                    <input type="hidden" name="produk[${rowIndex}][id]" value="${id}">
                </td>
                <td><input type="text" class="form-control harga" name="produk[${rowIndex}][harga]" value="${formatRupiah(hargaRaw)}"></td>
                <td><input type="number" class="form-control qty" name="produk[${rowIndex}][jumlah]" value="1" min="1"></td>
                <td><input type="text" class="form-control diskon-item" name="produk[${rowIndex}][diskon]" value="Rp 0"></td>
                <td><input type="text" class="form-control total" name="produk[${rowIndex}][total]" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
            `;

            tbody.appendChild(row);
        });

        updateTotals();
    });

    // Listen for input in harga and diskon fields to format as Rupiah
    document.addEventListener('input', function(e) {
        const el = e.target;

        // For harga and diskon-item inputs, format to Rupiah as user types
        if (el.classList.contains('harga') || el.classList.contains('diskon-item')) {
            let cursorPos = el.selectionStart;
            let originalLength = el.value.length;

            // Remove all non-digit chars, then format
            let numericValue = parseRupiah(el.value);
            el.value = formatRupiah(numericValue);

            // Adjust cursor position (rough fix)
            let newLength = el.value.length;
            cursorPos = cursorPos + (newLength - originalLength);
            el.setSelectionRange(cursorPos, cursorPos);

            updateTotals();
        }

        // For qty, just update totals
        if (el.classList.contains('qty')) {
            updateTotals();
        }
    });

    // Remove row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            updateTotals();
        }
    });

    // Update all totals, summing with parsed numbers
    function updateTotals() {
        let totalHarga = 0;
        let totalDiskon = 0;

        document.querySelectorAll('#sparepart-table-body tr').forEach(row => {
            const hargaStr = row.querySelector('.harga').value;
            const qty = parseInt(row.querySelector('.qty').value) || 0;
            const diskonStr = row.querySelector('.diskon-item').value;

            const harga = parseRupiah(hargaStr);
            const diskonItem = parseRupiah(diskonStr);

            const subtotal = harga * qty;
            const total = subtotal - diskonItem;

            row.querySelector('.total').value = formatRupiah(total);

            totalHarga += subtotal;
            totalDiskon += diskonItem;
        });

        const hargaAkhir = totalHarga - totalDiskon;

        document.querySelector('[name="total_harga"]').value = formatRupiah(totalHarga);
        document.querySelector('[name="diskon"]').value = formatRupiah(totalDiskon);
        document.querySelector('[name="harga_akhir"]').value = formatRupiah(hargaAkhir);

        document.getElementById('harga_akhir_sparepart').value = formatRupiah(hargaAkhir);
        document.getElementById('diskon_sparepart').value = formatRupiah(totalDiskon);

        updateTotalHarga();
    }

    // Sync to other fields if needed
    function updateTotalHarga() {
        const harga = document.getElementById('harga_akhir_sparepart').value;
        const diskon_akhir = document.getElementById('diskon_sparepart').value;

        if (document.getElementById('total_harga_pembayaran'))
            document.getElementById('total_harga_pembayaran').value = harga;
        if (document.getElementById('diskon_pembayaran'))
            document.getElementById('diskon_pembayaran').value = diskon_akhir;
    }
    </script>
</form>