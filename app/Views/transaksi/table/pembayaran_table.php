<form action="<?php echo base_url('insert/service/savePembayaran') ?>" enctype="multipart/form-data" method="post">
    <div class="mt-3">

        <div class="mb-3">
            <label class="form-label fw-semibold">Service Staff</label>
            <select name="service_by_pembayaran" class="form-control form-control-lg">
                <option value="" disabled <?= empty($old_service_pelanggan->service_by) ? 'selected' : '' ?>>-- Pilih Service Staff --</option>
                <?php foreach ($teknisi as $a): ?>
                    <option value="<?= $a->ID_AKUN ?>" <?= @$old_service_pelanggan->service_by == $a->ID_AKUN ? 'selected' : '' ?>>
                        <?= $a->NAMA_AKUN ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>
        <input type="text" hidden name="idservice_p" value="<?php echo @$idservice ?>" id="">

        <div class="mb-3">
            <label class="form-label fw-semibold">No Service</label>
            <input type="text" name="no_service_pembayaran" value="<?php echo @$old_service_pelanggan->no_service ?>"
                class="form-control form-control-lg" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Diskon</label>
            <input type="text" name="diskon_pembayaran" id="diskon_pembayaran" readonly
                class="form-control form-control-lg" value="Rp 0">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">DP</label>
            <input type="text" name="dp_bayar" id="dp_bayar" readonly
                class="form-control form-control-lg" value="<?php echo @$old_service_pelanggan->dp_bayar ?>">
        </div>


        <div class="mb-3">
            <label class="form-label fw-semibold">Total Harga</label>
            <input type="text" name="total_harga_pembayaran" id="total_harga_pembayaran"
                class="form-control form-control-lg" readonly value="Rp 0">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Total Harga Akhir</label>
            <input type="text" name="total_harga_pembayaran_akhir" id="total_harga_pembayaran_akhir"
                class="form-control form-control-lg" readonly value="Rp 0">
        </div>




        <div class="mb-3">
            <label class="form-label fw-semibold">Bayar</label>
            <input type="text" name="bayar_pembayaran" id="bayar" class="form-control form-control-lg"
                oninput="handleBayarInput()" placeholder="Rp 0">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Kembalian</label>
            <input type="text" name="kembalian" id="kembalian" class="form-control form-control-lg" readonly
                value="Rp 0">
        </div>

        <!-- <div class="mb-5">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select form-select-lg" name="status_service_pembayaran">
                <option selected disabled>---Pilih Status---</option>
                <option value="1">Menunggu</option>
                <option value="2">Proses</option>
                <option value="3">Pengambilan</option>
                <option value="4">Selesai dan Sudah Dibayar</option>
                <option value="5">Dibatalkan</option>
            </select>
        </div> -->
    </div>


    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-light btn-lg me-2" id="btn-previous-to-sparepart">Sebelumnya</button>
        <button type="submit" id="submitSemuaForm" class="btn btn-success btn-lg">Submit</button>
    </div>
</form>
<script>
    function parseRupiahToNumber(rp) {
        if (!rp) return 0;
        // Remove "Rp", dots, spaces, commas, etc, leaving only digits
        let clean = rp.replace(/[^0-9]/g, '');
        return parseInt(clean) || 0;
    }

    function formatRupiah(angka) {
        if (!angka) return 'Rp 0';
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    document.getElementById('dp_bayar').addEventListener('input', function() {
        let number = parseRupiahToNumber(this.value);
        this.value = formatRupiah(number);
        hitungKembalian();
    });



    // Called on "bayar" input change
    function handleBayarInput() {
        const bayarInput = document.getElementById('bayar');
        let cursorPos = bayarInput.selectionStart;

        // Parse current value to number
        let numberValue = parseRupiahToNumber(bayarInput.value);

        // Format and set back with Rp prefix
        bayarInput.value = formatRupiah(numberValue);

        // Reset cursor position to the end (better UX for this type of formatting)
        bayarInput.setSelectionRange(bayarInput.value.length, bayarInput.value.length);

        hitungKembalian();
    }

    function hitungKembalian() {
        const totalHargaStr = document.getElementById('total_harga_pembayaran_akhir').value;
        const totalHarga = parseRupiahToNumber(totalHargaStr);

        const bayarStr = document.getElementById('bayar').value;
        const bayar = parseRupiahToNumber(bayarStr);

        let kembalian = bayar - totalHarga;
        if (kembalian < 0) kembalian = 0;

        document.getElementById('kembalian').value = formatRupiah(kembalian);
    }



    // To set diskon and total harga programmatically with Rupiah format:
    function setDiskon(value) {
        document.getElementById('diskon_pembayaran').value = formatRupiah(value);
    }

    function setTotalHarga(value) {
        document.getElementById('total_harga_pembayaran').value = formatRupiah(value);
    }

    // Example initial set (optional)
    // setDiskon(50000);
    // setTotalHarga(200000);
</script>

<script>
    document.getElementById('btn-previous-to-sparepart').addEventListener('click', function() {
        var tabTrigger = new bootstrap.Tab(document.querySelector('#sparepart-tab'));
        tabTrigger.show();
    });
</script>