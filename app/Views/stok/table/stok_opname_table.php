<div hidden class="mb-3" style="margin-left: 20px;">
    <label hidden for="filterUnit2"> Unit:</label>
    <select hidden style="margin-right: 10px;" id="filterUnit2" class="form-control d-inline-block w-auto">
        <option value="">Semua Unit</option>
        <?php foreach ($unit as $u): ?>
        <option value="<?= $u->idunit ?>" <?= $u->idunit == session('ID_UNIT') ? 'selected' : '' ?>>
            <?= esc($u->NAMA_UNIT) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <button hidden id="resetFilter2" class="btn btn-secondary">Reset</button>
</div>

<div class="mb-3" style="margin-left: 20px; display: flex; justify-content: right; gap: 20px;">

    <select disabled style="margin-right: 10px;" id="filterUnitxyzcc" class="form-control d-inline-block w-auto">
        <option value="">Semua Unit</option>
        <?php foreach ($unit as $u): ?>
        <option value="<?= $u->idunit ?>" <?= $u->idunit == session('ID_UNIT') ? 'selected' : '' ?>>
            <?= esc($u->NAMA_UNIT) ?>
        </option>
        <?php endforeach; ?>
    </select>
</div>



<form action="<?= base_url('insert/stokopnamefix') ?>" method="post">
    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config2">
            <thead class="text-dark fs-4">
                <tr>
                    <th><input type="checkbox" id="select_all2"></th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Nama Unit</th>
                    <th>Jumlah Komputer</th>
                    <th>Jumlah Real</th>
                    <th>Jumlah Selisih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stokopname as $index => $row): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="row-check" name="data[<?= $index ?>][checked]" value="1">
                    </td>
                    <td><?= esc($row->kode_barang) ?></td>
                    <td><?= esc($row->nama_barang) ?></td>
                    <td><?= esc($row->NAMA_UNIT) ?></td>
                    <td>
                        <input type="number" name="data[<?= $index ?>][jumlah_komp]" class="form-control jumlah-komp"
                            value="<?= esc($row->jumlah_komp) ?>">
                    </td>
                    <td>
                        <input type="number" name="data[<?= $index ?>][jumlah_real]" class="form-control jumlah-real"
                            value="<?= esc($row->jumlah_real) ?>">
                    </td>
                    <td>
                        <input readonly class="form-control jumlah_selisih jumlah-selisih"
                            name="data[<?= $index ?>][jumlah_selisih]">
                    </td>

                    <input type="hidden" name="data[<?= $index ?>][barang_idbarang]"
                        value="<?= esc($row->barang_idbarang) ?>">
                    <input type="hidden" name="data[<?= $index ?>][unit_idunit]" value="<?= esc($row->unit_idunit) ?>">
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan Fix</button>
</form>


<script>
window.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#zero_config2 tbody tr');

    rows.forEach(function(tr) {
        const checkbox = tr.querySelector('.row-check');
        const kompInput = tr.querySelector('.jumlah-komp');
        const realInput = tr.querySelector('.jumlah-real');
        const selisihInput = tr.querySelector('.jumlah-selisih');

        // Disable inputs awal
        kompInput.disabled = true;
        realInput.disabled = true;

        // Hitung selisih jika sudah ada nilai
        const komp = parseFloat(kompInput.value) || 0;
        const real = parseFloat(realInput.value) || 0;
        if (real || komp) {
            selisihInput.value = real - komp;
        }

        // Event checkbox untuk enable input
        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                kompInput.disabled = false;
                realInput.disabled = false;
            } else {
                kompInput.disabled = true;
                realInput.disabled = true;
            }
        });

        // Event input untuk menghitung selisih
        realInput.addEventListener('input', function() {
            if (checkbox.checked) {
                const komp = parseFloat(kompInput.value) || 0;
                const real = parseFloat(realInput.value) || 0;
                selisihInput.value = real - komp;
            } else {
                alert(
                    "Silakan centang kotak ceklis terlebih dahulu sebelum mengisi jumlah real."
                    );
                realInput.value = '';
                realInput.blur();
            }
        });

        kompInput.addEventListener('input', function() {
            if (checkbox.checked) {
                const komp = parseFloat(kompInput.value) || 0;
                const real = parseFloat(realInput.value) || 0;
                selisihInput.value = real - komp;
            }
        });
    });

    // Select All untuk tabel kedua
    document.getElementById('select_all2').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('#zero_config2 .row-check');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
            cb.dispatchEvent(new Event('change'));
        });
    });
});
</script>

<script>
$(document).ready(function() {
    var table = $('#zero_config2').DataTable();

    // Fungsi untuk filter berdasarkan teks nama unit (kolom ke-3)
    function applyFilter2() {
        var selectedId = $('#filterUnit2').val();

        if (selectedId) {
            var selectedText = $('#filterUnit2 option:selected').text();
            table.column(3).search('^' + selectedText + '$', true, false).draw();
        } else {
            table.column(3).search('', true, false).draw();
        }
    }

    // Jalankan filter otomatis saat halaman pertama kali dimuat
    applyFilter2();

    // Jalankan filter ketika dropdown berubah
    $('#filterUnit2').on('change', function() {
        applyFilter2();
    });

    // Tombol Reset Filter
    $('#resetFilter2').on('click', function() {
        $('#filterUnit2').val('');
        table.column(3).search('', true, false).draw();
    });
});
</script>