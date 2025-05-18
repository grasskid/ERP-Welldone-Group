You said:
<form action="<?= base_url('insert/stokopname') ?>" method="post">
    <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
        <thead class="text-dark fs-4">
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Nama Unit</th>
                <th>Stok Dasar</th>
                <th>Tanggal Stok Dasar</th>
                <th>Jumlah Komputer</th>
                <th>Jumlah Real</th>
                <!-- <th>Jumlah Selisih</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stok as $index => $row): ?>
                <tr>
                    <td>
                        <?= esc($row->kode_barang) ?>
                        <input type="hidden" name="data[<?= $index ?>][barang_idbarang]" value="<?= $row->idbarang ?>">
                        <input type="hidden" name="data[<?= $index ?>][unit_idunit]" value="<?= $row->id_unit ?>">
                    </td>
                    <td><?= esc($row->nama_barang) ?></td>
                    <td><?= esc($row->nama_unit) ?></td>
                    <td><?= esc($row->stok_dasar) ?></td>
                    <td><?= esc($row->tanggal_stok_dasar) ?></td>
                    <td>
                        <?= esc($row->stok_akhir) ?>
                        <input type="hidden" name="data[<?= $index ?>][jumlah_komp]" value="<?= $row->stok_akhir ?>">
                    </td>
                    <td>
                        <input type="number" class="form-control" name="data[<?= $index ?>][jumlah_real]">
                    </td>
                    <!-- <td>
                        <input type="number" class="form-control" name="data[<?= $index ?>][jumlah_selisih]">
                    </td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>

<script>
    document.querySelectorAll('input[name$="[jumlah_real]"]').forEach(function(realInput) {
        realInput.addEventListener('input', function() {
            const tr = realInput.closest('tr');
            const komp = parseFloat(tr.querySelector('input[name$="[jumlah_komp]"]').value) || 0;
            const real = parseFloat(realInput.value) || 0;
            tr.querySelector('input[name$="[jumlah_selisih]"]').value = real - komp;
        });
    });
</script>