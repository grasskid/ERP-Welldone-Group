<form action="" id="form-pembayaran">
    <div class="mt-3">

        <div class="mb-3">
            <label class="form-label fw-semibold">Service Staff</label>
            <input type="text" name="service_by_pembayaran" class="form-control form-control-lg" value="">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">No Service</label>
            <input type="text" name="no_service_pembayaran" value="<?php echo @$old_service_pelanggan->no_service ?>" class="form-control form-control-lg" value="" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Diskon</label>
            <input type="text" name="diskon_pembayaran" class="form-control form-control-lg" value="<?php echo @$old_service_pelanggan->total_diskon ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Total Harga</label>
            <input type="text" name="total_harga_pembayaran" value="<?php echo @$old_service_pelanggan->total_service ?>" class="form-control form-control-lg">
        </div>

        <!-- <div class="mb-3">
        <label class="form-label fw-semibold">Jenis Pembayaran</label>
        <select class="form-select form-select-lg" name="jenis_pembayaran">
            <option selected disabled>---Pilih Jenis Pembayaran---</option>
            <option value="Tunai">Tunai</option>
            <option value="Transfer">Transfer</option>
            <option value="QRIS">QRIS</option>
        </select> 
    </div> -->

        <div class="mb-5">
            <label class="form-label fw-semibold">Status</label>
            <select class="form-select form-select-lg" name="status_service_pembayaran">
                <option disabled <?php echo @$old_service_pelanggan->status_service == null ? 'selected' : '' ?>>---Pilih Status---</option>
                <option value="1" <?php echo @$old_service_pelanggan->status_service == 1 ? 'selected' : '' ?>>Menunggu</option>
                <option value="2" <?php echo @$old_service_pelanggan->status_service == 2 ? 'selected' : '' ?>>Proses</option>
                <option value="3" <?php echo @$old_service_pelanggan->status_service == 3 ? 'selected' : '' ?>>Pengambilan</option>
                <option value="4" <?php echo @$old_service_pelanggan->status_service == 4 ? 'selected' : '' ?>>Selesai</option>
                <option value="5" <?php echo @$old_service_pelanggan->status_service == 9 ? 'selected' : '' ?>>Dibatalkan</option>
            </select>
        </div>

</form>

<div class="d-flex justify-content-end">
    <button type="button" class="btn btn-light btn-lg me-2">Sebelumnya</button>
    <button type="button" id="submitSemuaForm" class="btn btn-success btn-lg">Selesai</button>
</div>

</div>