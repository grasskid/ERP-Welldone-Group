<form action="" id="form-pembayaran">
    <div class="mt-3">

        <div class="mb-3">
            <label class="form-label fw-semibold">Service Staff</label>
            <select name="service_by_pembayaran" class="form-control form-control-lg">
                <option value="">-- Pilih Service Staff --</option>
                <?php foreach ($teknisi as $a): ?>
                    <option value="<?= $a->ID_AKUN ?>"
                        <?= @$old_service_pelanggan->service_by == $a->ID_AKUN ? 'selected' : '' ?>>
                        <?= $a->NAMA_AKUN ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">No Service</label>
            <input type="text" name="no_service_pembayaran" value="<?php echo @$old_service_pelanggan->no_service ?>"
                class="form-control form-control-lg" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Diskon</label>
            <input type="text" name="diskon_pembayaran" id="diskon_pembayaran" class="form-control form-control-lg"
                onblur="formatRupiahInput(this)">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Total Harga</label>
            <input type="text" name="total_harga_pembayaran" id="total_harga_pembayaran"
                class="form-control form-control-lg" onblur="formatRupiahInput(this)">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Bayar</label>
            <input type="text" name="bayar_pembayaran" id="bayar" class="form-control form-control-lg"
                oninput="formatRupiahLive(this); hitungKembalian();">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Kembalian</label>
            <input type="text" name="kembalian" id="kembalian" class="form-control form-control-lg" readonly>
        </div>

        <div class="mb-5">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select form-select-lg" name="status_service_pembayaran">
                <option disabled <?php echo @$old_service_pelanggan->status_service == null ? 'selected' : '' ?>>
                    ---Pilih Status---</option>
                <option value="1" <?php echo @$old_service_pelanggan->status_service == 1 ? 'selected' : '' ?>>Menunggu
                </option>
                <option value="2" <?php echo @$old_service_pelanggan->status_service == 2 ? 'selected' : '' ?>>Proses
                </option>
                <option value="3" <?php echo @$old_service_pelanggan->status_service == 3 ? 'selected' : '' ?>>
                    Pengambilan</option>
                <option value="4" <?php echo @$old_service_pelanggan->status_service == 4 ? 'selected' : '' ?>>Selesai
                </option>
                <option value="5" <?php echo @$old_service_pelanggan->status_service == 9 ? 'selected' : '' ?>>
                    Dibatalkan</option>
            </select>
        </div>

    </div>
</form>

<div class="d-flex justify-content-end">
    <button type="button" class="btn btn-light btn-lg me-2">Sebelumnya</button>
    <button type="button" id="submitSemuaForm" class="btn btn-success btn-lg">Submit</button>
</div>

<script>
    function parseRupiahToNumber(rp) {
        if (!rp) return 0;
        let clean = rp.replace(/[^0-9]/g, '');
        return parseInt(clean) || 0;
    }

    function formatRupiahInput(input) {
        let value = input.value;
        if (!value) return;
        let number = parseRupiahToNumber(value);
        input.value = 'Rp ' + number.toLocaleString('id-ID');
    }

    // Format Bayar input live while typing
    function formatRupiahLive(input) {
        // Get cursor position
        let cursorPosition = input.selectionStart;
        let originalLength = input.value.length;

        // Extract only digits
        let value = input.value.replace(/[^0-9]/g, '');
        if (value === '') {
            input.value = '';
            return;
        }

        // Convert to number and format
        let number = parseInt(value);
        let formatted = 'Rp ' + number.toLocaleString('id-ID');

        input.value = formatted;

        // Adjust cursor position
        let newLength = formatted.length;
        cursorPosition = cursorPosition + (newLength - originalLength);
        input.setSelectionRange(cursorPosition, cursorPosition);
    }

    function hitungKembalian() {
        const totalHargaStr = document.getElementById('total_harga_pembayaran').value;
        const totalHarga = parseRupiahToNumber(totalHargaStr);

        const bayarStr = document.getElementById('bayar').value;
        const bayar = parseRupiahToNumber(bayarStr);

        let kembalian = bayar - totalHarga;
        if (kembalian < 0) kembalian = 0;

        document.getElementById('kembalian').value = 'Rp ' + kembalian.toLocaleString('id-ID');
    }

    // Optional: format initial values on page load
    window.addEventListener('DOMContentLoaded', () => {
        ['diskon_pembayaran', 'total_harga_pembayaran', 'kembalian'].forEach(id => {
            const el = document.getElementById(id);
            if (el && el.value) {
                formatRupiahInput(el);
            }
        });
    });
</script>