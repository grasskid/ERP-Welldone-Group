<div class="mb-3" style="margin-left: 20px;">
    <label for="filterUnit2"> Unit:</label>
    <select style="margin-right: 10px;" id="filterUnit2" class="form-control d-inline-block w-auto">
        <option value="">Semua Unit</option>
        <?php foreach ($unit as $u): ?>
        <option value="<?= $u->idunit ?>" <?= $u->idunit == session('ID_UNIT') ? 'selected' : '' ?>>
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
// Gabungkan kedua script menjadi satu untuk menghindari konflik
document.addEventListener('DOMContentLoaded', function() {
    // ===== BAGIAN 1: Fungsi untuk checkbox dan perhitungan =====
    const selectAllCheckbox = document.getElementById('select_all2');
    const rows = document.querySelectorAll('#zero_config2 tbody tr');

    // Fungsi untuk mengupdate status input berdasarkan checkbox
    function updateInputStatus(checkbox, row) {
        const kompInput = row.querySelector('.jumlah-komp');
        const realInput = row.querySelector('.jumlah-real');

        if (checkbox.checked) {
            kompInput.disabled = false;
            realInput.disabled = false;
        } else {
            kompInput.disabled = true;
            realInput.disabled = true;
        }
    }

    // Fungsi untuk menghitung selisih
    function calculateSelisih(row) {
        const kompInput = row.querySelector('.jumlah-komp');
        const realInput = row.querySelector('.jumlah-real');
        const selisihInput = row.querySelector('.jumlah-selisih');

        const komp = parseFloat(kompInput.value) || 0;
        const real = parseFloat(realInput.value) || 0;

        selisihInput.value = real - komp;
    }

    // Inisialisasi setiap baris
    rows.forEach(function(row) {
        const checkbox = row.querySelector('.row-check');
        const kompInput = row.querySelector('.jumlah-komp');
        const realInput = row.querySelector('.jumlah-real');
        const selisihInput = row.querySelector('.jumlah-selisih');

        // Disable inputs awal
        kompInput.disabled = true;
        realInput.disabled = true;

        // Hitung selisih awal jika ada nilai
        const komp = parseFloat(kompInput.value) || 0;
        const real = parseFloat(realInput.value) || 0;
        if (real !== 0 || komp !== 0) {
            selisihInput.value = real - komp;
        }

        // Event untuk checkbox
        checkbox.addEventListener('change', function() {
            updateInputStatus(checkbox, row);
        });

        // Event untuk input jumlah real
        realInput.addEventListener('input', function() {
            if (checkbox.checked) {
                calculateSelisih(row);
            } else {
                alert(
                    "Silakan centang kotak ceklis terlebih dahulu sebelum mengisi jumlah real."
                    );
                realInput.value = '';
                realInput.focus();
            }
        });

        // Event untuk input jumlah komputer
        kompInput.addEventListener('input', function() {
            if (checkbox.checked) {
                calculateSelisih(row);
            }
        });
    });

    // Event untuk select all
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('#zero_config2 .row-check');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
                // Trigger change event pada setiap checkbox
                const event = new Event('change');
                cb.dispatchEvent(event);
            });
        });
    }

    // ===== BAGIAN 2: Inisialisasi DataTable dengan Filter =====
    // Cek apakah jQuery sudah siap
    if (typeof jQuery !== 'undefined') {
        $(function() {
            // Hapus DataTable yang sudah ada jika ada
            if ($.fn.dataTable.isDataTable('#zero_config2')) {
                $('#zero_config2').DataTable().destroy();
                console.log('DataTable lama di-destroy');
            }

            // Inisialisasi DataTable baru dengan opsi yang benar
            var table = $('#zero_config2').DataTable({
                "destroy": true, // Izinkan destroy
                "retrieve": true, // Ambil instance jika sudah ada
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 10,
                "language": {
                    "emptyTable": "Tidak ada data tersedia",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "search": "Cari:",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 4, 5,
                            6
                        ] // Nonaktifkan sorting untuk kolom checkbox dan input
                    },
                    {
                        "searchable": true,
                        "targets": [1, 2, 3] // Kolom yang bisa dicari
                    }
                ],
                "drawCallback": function(settings) {
                    // Setelah tabel di-draw, update status checkbox
                    const checkboxes = document.querySelectorAll(
                        '#zero_config2 .row-check');
                    checkboxes.forEach(cb => {
                        const row = cb.closest('tr');
                        const kompInput = row.querySelector('.jumlah-komp');
                        const realInput = row.querySelector('.jumlah-real');

                        if (cb.checked) {
                            kompInput.disabled = false;
                            realInput.disabled = false;
                        } else {
                            kompInput.disabled = true;
                            realInput.disabled = true;
                        }
                    });
                }
            });

            console.log('DataTable diinisialisasi dengan', table.rows().count(), 'baris');

            // ===== BAGIAN 3: Fungsi Filter =====
            var currentFilter = null;

            function applyFilter() {
                var selectedId = $('#filterUnit2').val();

                // Hapus filter sebelumnya jika ada
                if (currentFilter !== null) {
                    var index = $.fn.dataTable.ext.search.indexOf(currentFilter);
                    if (index !== -1) {
                        $.fn.dataTable.ext.search.splice(index, 1);
                    }
                    currentFilter = null;
                }

                if (selectedId) {
                    // Dapatkan teks dari option yang dipilih
                    var selectedText = $('#filterUnit2 option:selected').text();

                    // Buat filter baru
                    currentFilter = function(settings, data, dataIndex) {
                        // data[3] adalah kolom Nama Unit (index ke-3)
                        var unitName = data[3];
                        return unitName === selectedText;
                    };

                    // Terapkan filter
                    $.fn.dataTable.ext.search.push(currentFilter);
                }

                // Redraw tabel
                table.draw();
            }

            // Terapkan filter awal jika ada nilai yang dipilih
            var initialValue = $('#filterUnit2').val();
            if (initialValue) {
                applyFilter();
            }

            // Event untuk dropdown filter
            $('#filterUnit2').on('change', function() {
                applyFilter();
            });

            // Event untuk tombol reset
            $('#resetFilter2').on('click', function(e) {
                e.preventDefault();
                $('#filterUnit2').val('');
                applyFilter();
            });

            // Debug: tampilkan semua unit yang ada di tabel
            console.log('Unit yang tersedia di tabel:');
            var uniqueUnits = table.column(3).data().unique().sort().toArray();
            uniqueUnits.forEach(function(unit, index) {
                console.log((index + 1) + '. ' + unit);
            });
        });
    } else {
        console.error('jQuery tidak ditemukan!');
    }
});
</script>