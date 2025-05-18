<form action="<?= base_url('insert/stokopnamefix') ?>" method="post">
    <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
        <thead class="text-dark fs-4">
            <tr>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">Kode Barang</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">Nama Unit</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">Tanggal Stok Dasar</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">Jumlah Komputer</h6>
                </th>
                <th>
                    <h6 class="fs-4 fw-semibold mb-0">Jumlah Real</h6>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stokopname as $row): ?>
            <tr>
                <td><?= esc($row->kode_barang) ?></td>
                <td><?= esc($row->nama_barang) ?></td>
                <td><?= esc($row->NAMA_UNIT) ?></td>
                <td><?= esc($row->tanggal) ?></td>

                <!-- Input fields -->
                <td>
                    <input type="number" name="jumlah_komp[]" class="form-control" value="<?= esc($row->jumlah_komp) ?>"
                        required>
                </td>
                <td>
                    <input type="number" name="jumlah_real[]" class="form-control" value="<?= esc($row->jumlah_real) ?>"
                        required>
                </td>

                <!-- Hidden fields for identification -->
                <input type="hidden" name="barang_idbarang[]" value="<?= esc($row->barang_idbarang) ?>">
                <input type="hidden" name="unit_idunit[]" value="<?= esc($row->unit_idunit) ?>">
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary mt-3">Simpan Fix</button>
</form>