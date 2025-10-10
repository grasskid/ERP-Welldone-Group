<div hidden class="mb-3" style="margin-left: 20px;">
    <label hidden for="filterUnit"> Unit:</label>
    <select hidden style="margin-right: 10px;" id="filterUnit" class="form-control d-inline-block w-auto">
        <option value="">Semua Unit</option>
        <?php foreach ($unit as $u): ?>
            <option value="<?= $u->idunit ?>" <?= $u->idunit == session('ID_UNIT') ? 'selected' : '' ?>>
                <?= esc($u->NAMA_UNIT) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button hidden id="resetFilter" class="btn btn-secondary">Reset</button>


</div>

<div class="mb-3" style="margin-left: 20px; display: flex; justify-content: right; gap: 20px;">

    <select disabled style="margin-right: 10px;" id="filterUnitxyz" class="form-control d-inline-block w-auto">
        <option value="">Semua Unit</option>
        <?php foreach ($unit as $u): ?>
            <option value="<?= $u->idunit ?>" <?= $u->idunit == session('ID_UNIT') ? 'selected' : '' ?>>
                <?= esc($u->NAMA_UNIT) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


<form action="<?= base_url('insert/stokopname') ?>" method="post">
    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th><input type="checkbox" id="select_all"></th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Nama Unit</th>
                    <th>Stok Dasar</th>
                    <th>Tanggal Stok Dasar</th>
                    <th>Jumlah Komputer</th>
                    <th>Jumlah Real</th>
                    <th>Jumlah Selisih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stok as $index => $row): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="row-check" name="data[<?= $index ?>][checked]" value="1">
                        </td>
                        <td>
                            <?= esc($row->kode_barang) ?>
                            <input type="hidden" name="data[<?= $index ?>][barang_idbarang]" value="<?= $row->idbarang ?>">
                            <input type="hidden" name="data[<?= $index ?>][unit_idunit]" value="<?= $row->id_unit ?>">
                        </td>
                        <td><?= esc($row->nama_barang) ?></td>
                        <td><?= esc($row->nama_unit) ?></td>
                        <td><?= esc($row->stok_dasar) ?></td>
                        <td><?= esc(date('d-m-Y', strtotime($row->tanggal_stok_dasar))) ?></td>
                        <td><input class="form-control jumlah-komp" name="data[<?= $index ?>][jumlah_komp]" value="<?= $row->stok_akhir ?>"></td>
                        <td><input type="number" class="form-control jumlah-real" name="data[<?= $index ?>][jumlah_real]"></td>
                        <td><input readonly class="form-control jumlah_selisih" name="data[<?= $index ?>][jumlah_selisih]"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>

<script>
    // Select All checkbox logic
    document.getElementById('select_all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-check');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Recalculate selisih only if checkbox is checked
    document.querySelectorAll('.jumlah-real').forEach(function(realInput) {
        realInput.addEventListener('input', function() {
            const tr = realInput.closest('tr');
            const checkbox = tr.querySelector('.row-check');
            const komp = parseFloat(tr.querySelector('input[name$="[jumlah_komp]"]').value) || 0;
            const real = parseFloat(realInput.value) || 0;

            if (checkbox.checked) {
                tr.querySelector('input[name$="[jumlah_selisih]"]').value = real - komp;
            } else {
                alert("Silakan centang kotak ceklis terlebih dahulu sebelum mengisi jumlah real.");
                realInput.value = '';
                realInput.focus();
            }
        });
    });

    // DataTable + Filter Unit
    $(document).ready(function() {
        var table = $('#zero_config').DataTable();

        // Fungsi filter berdasarkan teks nama_unit (kolom ke-3)
        function applyFilter() {
            var selectedId = $('#filterUnit').val();

            if (selectedId) {
                // Ambil nama unit dari option terpilih
                var selectedText = $('#filterUnit option:selected').text();
                table.column(3).search('^' + selectedText + '$', true, false).draw();
            } else {
                table.column(3).search('', true, false).draw();
            }
        }

        // Jalankan filter otomatis saat halaman load
        applyFilter();

        // Jalankan filter ketika dropdown berubah
        $('#filterUnit').on('change', function() {
            applyFilter();
        });

        // Tombol Reset Filter
        $('#resetFilter').on('click', function() {
            $('#filterUnit').val('');
            table.column(3).search('', true, false).draw();
        });
    });
</script>