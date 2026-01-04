<div class="mb-3" style="margin-left: 20px;">
    <label for="filterUnit2"> Unit:</label>
    <select style="margin-right: 10px;" id="filterUnit2" class="form-control d-inline-block w-auto">
        <option value="">Semua Unit</option>
        <?php foreach ($unit as $u): ?>
        <option value="<?= esc($u->NAMA_UNIT) ?>">
            <?= esc($u->NAMA_UNIT) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <button id="resetFilter2" class="btn btn-secondary">Reset</button>
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
// ==================== SOLUSI SINGKAT DAN PASTI BERHASIL ====================
$(document).ready(function() {
    // 1. INISIALISASI DATATABLE
    var table;

    if ($.fn.dataTable.isDataTable('#zero_config2')) {
        table = $('#zero_config2').DataTable();
        console.log('Menggunakan DataTable yang sudah ada');
    } else {
        table = $('#zero_config2').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 4, 5, 6]
            }],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 25
        });
        console.log('DataTable diinisialisasi baru');
    }

    // Debug: tampilkan data yang ada di kolom unit
    console.log('=== DEBUG: DATA UNIT DI TABEL ===');
    table.rows().every(function(rowIdx, tableLoop, rowLoop) {
        if (rowIdx < 3) { // Hanya 3 baris pertama
            var data = this.data();
            console.log('Baris ' + rowIdx + ': Unit = "' + data[3] + '"');
        }
    });

    // 2. FUNGSI FILTER YANG PASTI BEKERJA
    function applyFilter2() {
        var selectedUnit = $('#filterUnit2').val();
        console.log('Filter dipilih:', selectedUnit);

        // Reset semua filter terlebih dahulu
        $.fn.dataTable.ext.search = [];

        if (selectedUnit && selectedUnit.trim() !== '') {
            // Tambahkan filter baru
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var unitName = data[3]; // Kolom ke-4 (Nama Unit)
                var isMatch = unitName === selectedUnit;

                // Debug per baris
                if (dataIndex < 3) {
                    console.log('Baris ' + dataIndex + ': ' + unitName + ' == ' + selectedUnit + ' ? ' +
                        isMatch);
                }

                return isMatch;
            });
        }

        // Redraw tabel
        table.draw();

        // Tampilkan jumlah baris setelah filter
        console.log('Baris yang ditampilkan:', table.rows({
            filter: 'applied'
        }).count());
    }

    // 3. EVENT HANDLERS
    $('#filterUnit2').on('change', function() {
        applyFilter2();
    });

    $('#resetFilter2').on('click', function(e) {
        e.preventDefault();
        $('#filterUnit2').val('');
        applyFilter2();
    });

    // 4. TERAPKAN FILTER AWAL JIKA ADA
    var initialFilter = $('#filterUnit2').val();
    if (initialFilter) {
        applyFilter2();
    }

    // ==================== FUNGSI CHECKBOX DAN PERHITUNGAN ====================
    // Select all checkbox
    $('#select_all2').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('.row-check').prop('checked', isChecked);

        // Update status input
        $('.row-check').each(function() {
            var $row = $(this).closest('tr');
            var $kompInput = $row.find('.jumlah-komp');
            var $realInput = $row.find('.jumlah-real');

            if (isChecked) {
                $kompInput.prop('disabled', false);
                $realInput.prop('disabled', false);
            } else {
                $kompInput.prop('disabled', true);
                $realInput.prop('disabled', true);
            }
        });
    });

    // Individual checkbox
    $(document).on('change', '.row-check', function() {
        var $row = $(this).closest('tr');
        var $kompInput = $row.find('.jumlah-komp');
        var $realInput = $row.find('.jumlah-real');

        if ($(this).is(':checked')) {
            $kompInput.prop('disabled', false);
            $realInput.prop('disabled', false);
        } else {
            $kompInput.prop('disabled', true);
            $realInput.prop('disabled', true);
        }
    });

    // Hitung selisih
    $(document).on('input', '.jumlah-real, .jumlah-komp', function() {
        var $row = $(this).closest('tr');
        var $checkbox = $row.find('.row-check');

        if (!$checkbox.is(':checked') && $(this).hasClass('jumlah-real')) {
            alert("Silakan centang baris terlebih dahulu sebelum mengisi jumlah real.");
            $(this).val('');
            return;
        }

        var komp = parseFloat($row.find('.jumlah-komp').val()) || 0;
        var real = parseFloat($row.find('.jumlah-real').val()) || 0;
        var selisih = real - komp;

        $row.find('.jumlah-selisih').val(selisih);
    });
});
</script>