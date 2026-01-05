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
        <div style="display: flex; margin-top: 20px; margin-left: 20px; gap: 20px;">
            <label for="global_unit" class="col-form-label">Unit:</label>
            <div>
                <select name="global_unit" id="global_unit" class="form-select" required
                    <?= session('ID_UNIT') == 1 ? '' : 'readonly' ?>>
                    <?php if (session('ID_UNIT') == 1): ?>
                    <?php foreach ($unit as $u): ?>
                    <?php if ($u && isset($u->idunit)): ?>
                    <option value="<?= $u->idunit ?>"><?= $u->NAMA_UNIT ?></option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <?php foreach ($unit as $u): ?>
                    <?php if ($u && isset($u->idunit) && $u->idunit == session('ID_UNIT')): ?>
                    <option value="<?= $u->idunit ?>" selected><?= $u->NAMA_UNIT ?></option>
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
                        <th>Satuan Terkecil</th>
                        <th>Sumber</th>
                        <th>Suplier</th>
                        <th>Pelanggan</th>
                        <th hidden>Unit</th>
                        <th hidden>Kode Barang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($barang as $index => $b): 
                        $kode_barang = $b->kode_barang;
                        $isImeiEmpty = empty($b->imei);
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_products[]" value="<?= $kode_barang ?>"
                                id="product_<?= $kode_barang ?>" onchange="toggleCheckbox('<?= $kode_barang ?>')">
                        </td>
                        <td style="min-width: 140px; text-align: center;">
                            <p style="font-weight: bold;"><?= esc($kode_barang) ?></p>
                            <p style="font-style: italic;"><?= esc($b->nama_barang) ?></p>
                        </td>
                        <td>
                            <p style="font-style: italic;"><?= esc($b->imei ?? "tidak ada imei") ?></p>
                        </td>
                        <td>
                            <input type="number" name="jumlah[<?= $kode_barang ?>]" class="form-control"
                                id="jumlah_<?= $kode_barang ?>" disabled style="min-width: 120px;">
                        </td>
                        <td>
                            <select name="satuan_terkecil[<?= $kode_barang ?>]" class="form-select"
                                id="satuan_terkecil_<?= $kode_barang ?>" disabled style="min-width: 190px;">
                                <option value="">-- Pilih Satuan --</option>
                                <option value="pcs">pcs</option>
                                <option value="pack">pack</option>
                            </select>
                        </td>
                        <td>
                            <select name="tipe_relasi[<?= $kode_barang ?>]" class="form-select"
                                id="tipe_relasi_<?= $kode_barang ?>" onchange="toggleSumber('<?= $kode_barang ?>')"
                                <?= $isImeiEmpty ? 'disabled' : '' ?> style="min-width: 190px;">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="suplier" <?= $isImeiEmpty ? 'selected' : '' ?>>Suplier</option>
                                <option value="pelanggan" <?= $isImeiEmpty ? '' : '' ?>>Pelanggan</option>
                            </select>
                        </td>
                        <td>
                            <select name="id_suplier_text[<?= $kode_barang ?>]" class="form-select"
                                id="id_suplier_text_<?= $kode_barang ?>" disabled style="min-width: 190px;">
                                <option value="">-- Pilih Suplier --</option>
                                <?php foreach ($suplier as $s): ?>
                                <option value="<?= $s->id_suplier ?>"><?= $s->nama_suplier ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="id_pelanggan_text[<?= $kode_barang ?>]" class="form-select"
                                id="id_pelanggan_text_<?= $kode_barang ?>" disabled style="min-width: 190px;">
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach ($pelanggan as $p): ?>
                                <option value="<?= $p->id_pelanggan ?>"><?= $p->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="id_unit_text[<?= $kode_barang ?>]" id="id_unit_text_<?= $kode_barang ?>"
                                hidden>
                                <?php foreach ($unit as $u): ?>
                                <?php if ($u && isset($u->idunit)): ?>
                                <option value="<?= $u->idunit ?>"><?= $u->NAMA_UNIT ?></option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td hidden><?= esc($kode_barang) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button type="button" class="btn bg-danger-subtle text-danger" onclick="window.history.back()">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
// SIMPLE FUNCTIONS - NO COMPLEX LOGIC
function toggleCheckbox(kodeBarang) {
    const checkbox = document.getElementById('product_' + kodeBarang);
    const checked = checkbox.checked;

    // Toggle jumlah
    document.getElementById('jumlah_' + kodeBarang).disabled = !checked;
    if (!checked) document.getElementById('jumlah_' + kodeBarang).value = '';

    // Toggle satuan
    document.getElementById('satuan_terkecil_' + kodeBarang).disabled = !checked;
    if (!checked) document.getElementById('satuan_terkecil_' + kodeBarang).value = '';

    // Toggle sumber (if not disabled by PHP)
    const sumber = document.getElementById('tipe_relasi_' + kodeBarang);
    if (!sumber.hasAttribute('disabled')) {
        sumber.disabled = !checked;
    }
    if (!checked) sumber.value = '';

    // Always disable suplier and pelanggan when unchecked
    document.getElementById('id_suplier_text_' + kodeBarang).disabled = true;
    document.getElementById('id_pelanggan_text_' + kodeBarang).disabled = true;
    document.getElementById('id_suplier_text_' + kodeBarang).value = '';
    document.getElementById('id_pelanggan_text_' + kodeBarang).value = '';

    // If checked, update based on sumber value
    if (checked) {
        setTimeout(() => {
            toggleSumber(kodeBarang);
        }, 10);
    }
}

function toggleSumber(kodeBarang) {
    const sumber = document.getElementById('tipe_relasi_' + kodeBarang);
    const suplier = document.getElementById('id_suplier_text_' + kodeBarang);
    const pelanggan = document.getElementById('id_pelanggan_text_' + kodeBarang);
    const checkbox = document.getElementById('product_' + kodeBarang);

    // Reset both
    suplier.disabled = true;
    pelanggan.disabled = true;
    suplier.value = '';
    pelanggan.value = '';

    // Only enable one if checkbox is checked
    if (checkbox.checked) {
        if (sumber.value === 'suplier') {
            suplier.disabled = false;
        } else if (sumber.value === 'pelanggan') {
            pelanggan.disabled = false;
        }
    }
}

// Initialize DataTable
$(document).ready(function() {
    $('#table_barang').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10
    });

    // Initialize for items with no IMEI
    document.querySelectorAll('[id^="tipe_relasi_"]').forEach(sumber => {
        if (sumber.hasAttribute('disabled')) {
            const kodeBarang = sumber.id.replace('tipe_relasi_', '');
            const checkbox = document.getElementById('product_' + kodeBarang);
            if (checkbox && checkbox.checked) {
                document.getElementById('id_suplier_text_' + kodeBarang).disabled = false;
            }
        }
    });
});

// Global unit change handler
document.getElementById('global_unit').addEventListener('change', function() {
    const selectedUnitId = this.value;
    filterBarangByUnit(selectedUnitId);
});

// Filter function
const suplierList = <?= json_encode($suplier) ?>;
const pelangganList = <?= json_encode($pelanggan) ?>;
const allBarang = <?= json_encode($barang) ?>;
const stok = <?= json_encode($stok) ?>;

const stokSet = new Set(
    stok.map(s => `${s.unit_idunit}_${s.barang_idbarang}`)
);

function filterBarangByUnit(unitId) {
    const filteredBarang = allBarang.filter(barang =>
        !stokSet.has(`${unitId}_${barang.idbarang}`)
    );
    updateBarangTable(filteredBarang);
}

function updateBarangTable(filteredBarang) {
    const tableBody = document.querySelector('#table_barang tbody');
    tableBody.innerHTML = '';

    filteredBarang.forEach((barang) => {
        const kodeBarang = barang.kode_barang;
        const isImeiEmpty = !barang.imei;

        const suplierOptions = suplierList.map(s =>
            `<option value="${s.id_suplier}">${s.nama_suplier}</option>`
        ).join('');

        const pelangganOptions = pelangganList.map(p =>
            `<option value="${p.id_pelanggan}">${p.nama}</option>`
        ).join('');

        tableBody.innerHTML += `
            <tr>
                <td>
                    <input type="checkbox" name="selected_products[]" value="${kodeBarang}" 
                        id="product_${kodeBarang}" onchange="toggleCheckbox('${kodeBarang}')">
                </td>
                <td style="min-width: 140px; text-align: center;">
                    <p style="font-weight: bold;">${kodeBarang}</p>
                    <p style="font-style: italic;">${barang.nama_barang}</p>
                </td>
                <td>
                    <p style="font-style: italic;">${barang.imei || "tidak ada imei"}</p>
                </td>
                <td>
                    <input type="number" name="jumlah[${kodeBarang}]" class="form-control" 
                        id="jumlah_${kodeBarang}" disabled style="min-width: 120px;">
                </td>
                <td>
                    <select name="satuan_terkecil[${kodeBarang}]" class="form-select" 
                        id="satuan_terkecil_${kodeBarang}" disabled style="min-width: 190px;">
                        <option value="">-- Pilih Satuan --</option>
                        <option value="pcs">pcs</option>
                        <option value="pack">pack</option>
                    </select>
                </td>
                <td>
                    <select name="tipe_relasi[${kodeBarang}]" class="form-select" 
                        id="tipe_relasi_${kodeBarang}" onchange="toggleSumber('${kodeBarang}')"
                        ${isImeiEmpty ? 'disabled' : ''} style="min-width: 190px;">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="suplier" ${isImeiEmpty ? 'selected' : ''}>Suplier</option>
                        <option value="pelanggan">Pelanggan</option>
                    </select>
                </td>
                <td>
                    <select name="id_suplier_text[${kodeBarang}]" class="form-select" 
                        id="id_suplier_text_${kodeBarang}" disabled style="min-width: 190px;">
                        <option value="">-- Pilih Suplier --</option>
                        ${suplierOptions}
                    </select>
                </td>
                <td>
                    <select name="id_pelanggan_text[${kodeBarang}]" class="form-select" 
                        id="id_pelanggan_text_${kodeBarang}" disabled style="min-width: 190px;">
                        <option value="">-- Pilih Pelanggan --</option>
                        ${pelangganOptions}
                    </select>
                </td>
                <td hidden>
                    <select name="id_unit_text[${kodeBarang}]" id="id_unit_text_${kodeBarang}" hidden>
                        ${suplierList.map(u => `<option value="${u.id_suplier}">${u.nama_suplier}</option>`).join('')}
                    </select>
                </td>
                <td hidden>${kodeBarang}</td>
            </tr>
        `;
    });

    // Reinitialize DataTable
    $('#table_barang').DataTable().destroy();
    $('#table_barang').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10
    });
}
</script>