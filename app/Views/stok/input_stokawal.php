<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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



    <form action="<?= base_url('insert/stokawal') ?>" enctype="multipart/form-data" method="post">


        <div style="display: flex; margin-top: 20px; margin-left: 20px; gap: 20px; ">
            <label for="global_unit" class=" col-form-label">Unit:</label>
            <div>
                <select name="global_unit" id="global_unit" class="form-select" required <?= session('ID_UNIT') == 1 ? '' : 'readonly' ?>>

                    <?php if (session('ID_UNIT') == 1): ?>
                        <!-- Admin / Superuser: tampilkan semua unit -->
                        <?php foreach ($unit as $u): ?>
                            <?php if ($u && isset($u->idunit)): ?>
                                <option value="<?= $u->idunit ?>">
                                    <?= $u->NAMA_UNIT ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <!-- User biasa: hanya tampilkan unit sesuai session -->
                        <?php foreach ($unit as $u): ?>
                            <?php if ($u && isset($u->idunit) && $u->idunit == session('ID_UNIT')): ?>
                                <option value="<?= $u->idunit ?>" selected>
                                    <?= $u->NAMA_UNIT ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </select>

            </div>

        </div>

        <div class="table-responsive mb-4 px-4">
            <table class="table table-bordered align-middle" id="table_barang">
                <thead>
                    <tr>
                        <th>Pilih</th>

                        <th style="text-align: center;">Nama Barang</th>
                        <th style="text-align: center;">Imei</th>
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
                                <p style="font-style: italic;"><?= esc($b->imei ?? "tidak ada imei") ?></p>
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
                                    <option value="pelanggan" <?= $isImeiEmpty ? 'hidden' : '' ?>>Pelanggan
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
                                        <?php if ($u && isset($u->idunit)): ?>
                                            <option value="<?= $u->idunit ?>"><?= $u->NAMA_UNIT ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>

                            </td>
                            <td hidden><?= esc($b->kode_barang) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="button" class="btn bg-danger-subtle text-danger"
            data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>

    </form>

</div>




<script>
    /* =====================================================
   1. INIT DATATABLE SEKALI SAJA
===================================================== */
    let tablecc = $('#table_barang').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10
    });

    const suplierList = <?= json_encode($suplier) ?>;
    const pelangganList = <?= json_encode($pelanggan) ?>;
    const allBarang = <?= json_encode($barang) ?>;
    const stok = <?= json_encode($stok) ?>;

    /* =====================================================
       2. PREPARE STOK SET (ANTI LOOP BERAT)
    ===================================================== */
    const stokSet = new Set(
        stok.map(s => `${s.unit_idunit}_${s.barang_idbarang}`)
    );

    /* =====================================================
       3. GLOBAL UNIT CHANGE
    ===================================================== */
    document.getElementById('global_unit').addEventListener('change', function() {
        filterBarangByUnit(this.value);
    });

    /* =====================================================
       4. FILTER BARANG (CEPAT)
    ===================================================== */
    function filterBarangByUnit(unitId) {
        const filteredBarang = allBarang.filter(barang =>
            !stokSet.has(`${unitId}_${barang.idbarang}`)
        );

        renderBarangTable(filteredBarang);
    }

    /* =====================================================
       5. RENDER TABLE (PAKAI DATATABLES API)
    ===================================================== */
    function renderBarangTable(barangList) {

        tablecc.clear();

        const suplierOptions = suplierList.map(s =>
            `<option value="${s.id_suplier}">${s.nama_suplier}</option>`
        ).join('');

        const pelangganOptions = pelangganList.map(p =>
            `<option value="${p.id_pelanggan}">${p.nama}</option>`
        ).join('');

        barangList.forEach(barang => {

            const kode = barang.kode_barang;
            const imei = barang.imei ? barang.imei : 'tidak ada imei';
            const isImeiEmpty = !barang.imei;

            tablecc.row.add([

                /* Pilih */
                `<input type="checkbox"
            name="selected_products[]"
            value="${kode}"
            id="product_${kode}">`,

                /* Nama Barang */
                `<b>${kode}</b><br><i>${barang.nama_barang}</i>`,

                /* IMEI */
                `<i>${imei}</i>`,

                /* Jumlah */
                `<input type="number"
            name="jumlah[${kode}]"
            id="jumlah_${kode}"
            class="form-control"
            disabled>`,

                /* Satuan */
                `<select name="satuan_terkecil[${kode}]"
            id="satuan_terkecil_${kode}"
            class="form-select"
            disabled>
            <option value="">-- Pilih Satuan --</option>
            <option value="pcs">pcs</option>
            <option value="pack">pack</option>
        </select>`,

                /* SUMBER */
                `<select name="tipe_relasi[${kode}]"
            id="tipe_relasi_${kode}"
            class="form-select tipe_relasi"
            data-kode="${kode}"
            ${isImeiEmpty ? 'disabled' : ''}>
            <option value="">-- Pilih Tipe --</option>
            <option value="suplier" ${isImeiEmpty ? 'selected' : ''}>
                Suplier
            </option>
            <option value="pelanggan" ${isImeiEmpty ? 'hidden' : ''}>
                Pelanggan
            </option>
        </select>`,

                /* Suplier */
                `<select name="id_suplier_text[${kode}]"
            id="id_suplier_text_${kode}"
            class="form-select"
            disabled>
            <option value="">-- Pilih Suplier --</option>
            ${suplierOptions}
        </select>`,

                /* Pelanggan */
                `<select name="id_pelanggan_text[${kode}]"
            id="id_pelanggan_text_${kode}"
            class="form-select"
            disabled>
            <option value="">-- Pilih Pelanggan --</option>
            ${pelangganOptions}
        </select>`,

                /* UNIT (HIDDEN) */
                `<input type="hidden"
            name="id_unit_text[${kode}]"
            id="id_unit_text_${kode}">`,

                /* Kode barang hidden */
                `<span hidden>${kode}</span>`
            ]);
        });

        tablecc.draw(false);
    }


    /* =====================================================
       6. EVENT DELEGATION (ANTI EVENT NUMPUK )
    ===================================================== */
    document.addEventListener('change', function(e) {

        // Checkbox produk
        if (e.target.id.startsWith('product_')) {
            const kode = e.target.id.replace('product_', '');
            toggleProductFields(kode, e.target.checked);
        }

        // Tipe relasi
        if (e.target.classList.contains('tipe_relasi')) {
            toggleRelasiFields(
                e.target.dataset.kode,
                e.target.value
            );
        }
    });

    /* =====================================================
       7. TOGGLE FIELD PRODUK
    ===================================================== */
    function toggleProductFields(kode, status) {
        [
            `jumlah_${kode}`,
            `satuan_terkecil_${kode}`,
            `tipe_relasi_${kode}`,
            `id_suplier_text_${kode}`,
            `id_pelanggan_text_${kode}`
        ].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.disabled = !status;
        });
    }

    /* =====================================================
       8. TOGGLE RELASI
    ===================================================== */
    function toggleRelasiFields(kode, tipe) {

        const suplier = document.getElementById(`id_suplier_text_${kode}`);
        const pelanggan = document.getElementById(`id_pelanggan_text_${kode}`);

        if (!suplier || !pelanggan) return;

        if (tipe === 'suplier') {
            suplier.disabled = false;
            pelanggan.disabled = true;
            pelanggan.value = '';
        } else if (tipe === 'pelanggan') {
            pelanggan.disabled = false;
            suplier.disabled = true;
            suplier.value = '';
        } else {
            suplier.disabled = true;
            pelanggan.disabled = true;
            suplier.value = '';
            pelanggan.value = '';
        }
    }
</script>