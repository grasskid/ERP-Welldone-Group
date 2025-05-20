<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Stok Awal</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Stok Awal</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#input-stokawal-modal"
            style="display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                style="margin-right: 8px;"></iconify-icon>
            Pilih Barang
        </button>
    </div>

    <br>
    <div class="mb-3 px-4">
        <label class="me-2">Filter Kategori:</label>
        <select id="kategoriFilter" class="form-select d-inline" style="width: auto;" onchange="filterKategori()">
            <option value="">Semua Kategori</option>
            <?php
            $kategoriList = [];
            foreach ($stok as $row) {
                if (!in_array($row->nama_kategori, $kategoriList)) {
                    $kategoriList[] = $row->nama_kategori;
                    echo '<option value="' . esc($row->nama_kategori) . '">' . esc($row->nama_kategori) . '</option>';
                }
            }
            ?>
        </select>

        <label class="me-2 ms-4">Filter PPN:</label>
        <select id="ppnFilter" class="form-select d-inline" style="width: auto;" onchange="filterKategori()">
            <option value="">Semua</option>
            <option value="PPN">PPN</option>
            <option value="Non PPN">Non PPN</option>
        </select>

        <button onclick="resetKategoriFilter()" class="btn btn-sm btn-secondary ms-2">Reset</button>
    </div>


    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Jumlah</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama kategori</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Harga Beli</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status PPN</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Satuan Terkecil</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ID Unit</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ID Suplier</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">ID Pelanggan</h6>
                    </th>
                </tr>
            </thead>
            <tbody id="produkTableBody">
                <?php if (!empty($stok)): ?>
                    <?php foreach ($stok as $row): ?>
                        <tr>
                            <td><?= esc(date('d-m-Y', strtotime($row->tanggal))) ?></td>

                            <td><?= esc($row->jumlah) ?></td>
                            <td><?= esc($row->nama_barang) ?></td>
                            <td><?= esc($row->nama_kategori) ?></td>
                            <td>Rp <?= number_format($row->harga_beli, 0, ',', '.') ?></td>
                            <td><?= $row->status_ppn == 1 ? 'PPN' : 'Non PPN' ?></td>
                            <td><?= esc($row->satuan_terkecil) ?></td>
                            <td><?= esc($row->NAMA_UNIT) ?></td>
                            <td>
                                <?php if (!empty($row->nama_suplier)): ?>
                                    <?= esc($row->nama_suplier) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row->nama_pelanggan)): ?>
                                    <?= esc($row->nama_pelanggan) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="input-stokawal-modal" tabindex="-1" aria-labelledby="inputStokAwalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 95%;" role="document">
        <div class="modal-content">
            <form action="<?= base_url('insert/stokawal') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="inputStokAwalModalLabel">Input Data Stok Awal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="global_unit" class="col-sm-2 col-form-label">Unit</label>
                        <div class="col-sm-10">
                            <select name="global_unit" id="global_unit" class="form-select" required>
                                <option value="">-- Pilih Unit --</option>
                                <?php foreach ($unit as $u): ?>
                                    <option value="<?= $u->idunit ?>"><?= $u->NAMA_UNIT ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="table_barang">
                            <thead>
                                <tr>
                                    <th>Pilih</th>

                                    <th style="text-align: center;">Nama Barang</th>
                                    <th>Jumlah</th>
                                    <!-- <th>Harga Beli</th> -->
                                    <th>Satuan Terkecil</th>
                                    <th>Sumber</th>
                                    <th>Suplier</th>
                                    <th>Pelanggan</th>
                                    <th hidden>Unit</th>
                                    <th hidden>Kode Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($barang as $index => $b): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected_products[]" value="<?= $b->kode_barang ?>"
                                                id="product_<?= $index ?>" onchange="toggleProductFields(<?= $index ?>)">
                                        </td>

                                        <td style="min-width: 140px; text-align: center;">
                                            <p style="font-weight: bold;"><?= esc($b->kode_barang) ?></p>
                                            <p style="font-style: italic;"><?= esc($b->nama_barang) ?></p>
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah[<?= $b->kode_barang ?>]" class="form-control"
                                                id="jumlah_<?= $index ?>" disabled style="min-width: 120px;">
                                        </td>

                                        <!-- <td>
                                            <input  type="number" name="harga_beli[<?= $b->kode_barang ?>]"
                                                class="form-control currency" id="harga_beli_<?= $index ?>" disabled
                                                style="min-width: 120px;">
                                        </td> -->
                                        <td>
                                            <select name="satuan_terkecil[<?= $b->kode_barang ?>]" class="form-select"
                                                id="satuan_terkecil_<?= $index ?>" disabled style="min-width: 190px;">
                                                <option value="">-- Pilih Satuan --</option>
                                                <option value="pcs">pcs</option>
                                                <option value="pack">pack</option>
                                            </select>
                                        </td>

                                        <td>
                                            <?php $isImeiEmpty = empty($b->imei);
                                            $tipeRelasiDisabled = $isImeiEmpty ? 'disabled' : ''; ?>
                                            <select name="tipe_relasi[<?= $b->kode_barang ?>]" class="form-select"
                                                id="tipe_relasi_<?= $index ?>" onchange="toggleRelasiFields(<?= $index ?>)"
                                                <?= $tipeRelasiDisabled ?> style="min-width: 190px;">
                                                <option value="">-- Pilih Tipe --</option>
                                                <option value="suplier" <?= $isImeiEmpty ? 'selected' : '' ?>>Suplier
                                                </option>
                                                <option value="pelanggan" <?= $isImeiEmpty ? 'disabled' : '' ?>>Pelanggan
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="id_suplier_text[<?= $b->kode_barang ?>]" class="form-select"
                                                id="id_suplier_text_<?= $index ?>" disabled style="min-width: 190px;">
                                                <option value="">-- Pilih Suplier --</option>
                                                <?php foreach ($suplier as $s): ?>
                                                    <option value="<?= $s->id_suplier ?>"><?= $s->nama_suplier ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="id_pelanggan_text[<?= $b->kode_barang ?>]" class="form-select"
                                                id="id_pelanggan_text_<?= $index ?>" disabled style="min-width: 190px;">
                                                <option value="">-- Pilih Pelanggan --</option>
                                                <?php foreach ($pelanggan as $p): ?>
                                                    <option value="<?= $p->id_pelanggan ?>"><?= $p->nama ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="id_unit_text[<?= $b->kode_barang ?>]"
                                                id="id_unit_text_<?= $index ?>" hidden>
                                                <?php foreach ($unit as $u): ?>
                                                    <option value="<?= $u->idunit ?>"><?= $u->NAMA_UNIT ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </td>
                                        <td hidden><?= esc($b->kode_barang) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let table;

    $(document).ready(function() {
        table = $('#zero_config').DataTable();


        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const kategoriFilter = $('#kategoriFilter').val().toLowerCase();
            const ppnFilter = $('#ppnFilter').val().toLowerCase();

            const kategori = data[3].toLowerCase();
            const ppn = data[5].toLowerCase();

            const matchKategori = !kategoriFilter || kategori === kategoriFilter;
            const matchPPN = !ppnFilter || ppn === ppnFilter;

            return matchKategori && matchPPN;
        });


        if ($('#ppnFilter option').length > 1) {
            $('#ppnFilter')[0].selectedIndex = 1;
        }
        if ($('#kategoriFilter option').length > 1) {
            $('#kategoriFilter')[0].selectedIndex = 1;
        }


        table.draw();
    });

    function filterKategori() {
        table.draw();
    }

    function resetKategoriFilter() {
        $('#kategoriFilter').val('');
        $('#ppnFilter').val('');
        table.draw();
    }
</script>




<script>
    const suplierList = <?= json_encode($suplier) ?>;
    const pelangganList = <?= json_encode($pelanggan) ?>;
    const allBarang = <?= json_encode($barang) ?>;
    const stok = <?= json_encode($stok) ?>;

    // Toggle enable/disable fields when checkbox is clicked
    function toggleProductFields(index) {
        const isChecked = document.getElementById('product_' + index).checked;
        document.getElementById('jumlah_' + index).disabled = !isChecked;
        document.getElementById('harga_beli_' + index).disabled = !isChecked;
        document.getElementById('satuan_terkecil_' + index).disabled = !isChecked;
        document.getElementById('tipe_relasi_' + index).disabled = !isChecked;
        document.getElementById('id_suplier_text_' + index).disabled = !isChecked;
        document.getElementById('id_pelanggan_text_' + index).disabled = !isChecked;
    }

    // Toggle supplier/pelanggan fields based on selected relation type
    function toggleRelasiFields(index) {
        const tipeRelasi = document.getElementById('tipe_relasi_' + index).value;
        const suplierSelect = document.getElementById('id_suplier_text_' + index);
        const pelangganSelect = document.getElementById('id_pelanggan_text_' + index);

        if (tipeRelasi === 'suplier') {
            suplierSelect.disabled = false;
            pelangganSelect.disabled = true;
            pelangganSelect.value = '';
        } else if (tipeRelasi === 'pelanggan') {
            pelangganSelect.disabled = false;
            suplierSelect.disabled = true;
            suplierSelect.value = '';
        } else {
            suplierSelect.disabled = true;
            pelangganSelect.disabled = true;
            suplierSelect.value = '';
            pelangganSelect.value = '';
        }
    }

    // Global unit change handler to assign selected unit to all barang
    document.getElementById('global_unit').addEventListener('change', function() {
        const unitId = this.value;
        <?php foreach ($barang as $index => $b): ?>
            document.getElementById('id_unit_text_<?= $index ?>').value = unitId;
        <?php endforeach; ?>
    });

    // Global unit change handler to filter barang
    document.getElementById('global_unit').addEventListener('change', function() {
        const selectedUnitId = this.value;
        filterBarangByUnit(selectedUnitId);
    });

    function filterBarangByUnit(unitId) {
        const filteredBarang = allBarang.filter(barang => {
            const inStok = stok.some(s => s.unit_idunit == unitId && s.barang_idbarang == barang.idbarang);
            return !inStok;
        });
        updateBarangTable(filteredBarang);
    }

    // Dynamically render filtered barang rows
    function updateBarangTable(filteredBarang) {
        const tableBody = document.querySelector('#table_barang tbody');
        tableBody.innerHTML = '';

        filteredBarang.forEach((barang, index) => {
            const suplierOptions = suplierList.map(s =>
                `<option value="${s.id_suplier}">${s.nama_suplier}</option>`
            ).join('');
            const pelangganOptions = pelangganList.map(p =>
                `<option value="${p.id_pelanggan}">${p.nama}</option>`
            ).join('');

            tableBody.innerHTML += `
                <tr>
                    <td>
                        <input type="checkbox" name="selected_products[]" value="${barang.kode_barang}" id="product_${index}" onchange="toggleProductFields(${index})">
                    </td>
                    <td style="min-width: 140px; text-align: center;">
                        <p style="font-weight: bold;">${barang.kode_barang}</p>
                        <p style="font-style: italic;">${barang.nama_barang}</p>
                    </td>
                    <td><input type="number" name="jumlah[${barang.kode_barang}]" class="form-control" id="jumlah_${index}" disabled style="min-width: 120px;"></td>
                    <td><input type="number" name="harga_beli[${barang.kode_barang}]" class="form-control" id="harga_beli_${index}" disabled style="min-width: 120px;"></td>
                    <td>
                        <select name="satuan_terkecil[${barang.kode_barang}]" class="form-select" id="satuan_terkecil_${index}" disabled style="min-width: 190px;">
                            <option value="">-- Pilih Satuan --</option>
                            <option value="pcs">pcs</option>
                            <option value="pack">pack</option>
                        </select>
                    </td>
                    <td>
                        <select name="tipe_relasi[${barang.kode_barang}]" class="form-select" id="tipe_relasi_${index}" onchange="toggleRelasiFields(${index})" disabled>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="suplier">Suplier</option>
                            <option value="pelanggan">Pelanggan</option>
                        </select>
                    </td>
                    <td>
                        <select name="id_suplier_text[${barang.kode_barang}]" class="form-select" id="id_suplier_text_${index}" disabled style="min-width: 190px;">
                            <option value="">-- Pilih Suplier --</option>
                            ${suplierOptions}
                        </select>
                    </td>
                    <td>
                        <select name="id_pelanggan_text[${barang.kode_barang}]" class="form-select" id="id_pelanggan_text_${index}" disabled style="min-width: 190px;">
                            <option value="">-- Pilih Pelanggan --</option>
                            ${pelangganOptions}
                        </select>
                    </td>
                </tr>
            `;
        });
    }

    // Optional: Initialize DataTable
    $(document).ready(function() {
        $('#table_barang').DataTable();
    });
</script>