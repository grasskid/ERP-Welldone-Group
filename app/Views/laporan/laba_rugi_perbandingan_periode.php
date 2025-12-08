<!-- Page Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Laporan Laba Rugi - Perbandingan Periode</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('LaporanKeuangan/laba_rugi') ?>">Laporan Laba Rugi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Perbandingan Periode</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter Form -->
<div class="card w-100 position-relative overflow-hidden mb-4">
    <div class="card-body">
        <form method="get" action="<?= base_url('LaporanKeuangan/laba_rugi_perbandingan_periode') ?>" id="filterForm">
            <h5 class="mb-3">Periode 1</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Awal Periode 1:</label>
                    <input type="date" name="tanggal_awal_1" id="tanggalAwal1" class="form-control"
                        value="<?= $tanggal_awal_1 ?? '' ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Akhir Periode 1:</label>
                    <input type="date" name="tanggal_akhir_1" id="tanggalAkhir1" class="form-control"
                        value="<?= $tanggal_akhir_1 ?? '' ?>" required>
                </div>
            </div>

            <h5 class="mb-3">Periode 2</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Awal Periode 2:</label>
                    <input type="date" name="tanggal_awal_2" id="tanggalAwal2" class="form-control"
                        value="<?= $tanggal_awal_2 ?? '' ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Akhir Periode 2:</label>
                    <input type="date" name="tanggal_akhir_2" id="tanggalAkhir2" class="form-control"
                        value="<?= $tanggal_akhir_2 ?? '' ?>" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="form-label">Unit/Cabang:</label>
                    <select name="id_unit[]" id="idUnit" class="form-control select2">
                        <?php foreach ($unit as $u): ?>
                            <option value="<?= $u->idunit ?>" 
                                <?= (is_array($id_unit) && in_array($u->idunit, $id_unit)) ? 'selected' : '' ?>>
                                <?= esc($u->NAMA_UNIT) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php if ($tanggal_awal_1 && $tanggal_akhir_1 && $tanggal_awal_2 && $tanggal_akhir_2): ?>
                        <button type="button" class="btn btn-success" onclick="cetakLaporan()">
                            <iconify-icon icon="solar:print" width="20" height="20"></iconify-icon>
                            Cetak Laporan
                        </button>
                    <?php endif; ?>
                    <a href="<?= base_url('LaporanKeuangan/laba_rugi') ?>" class="btn btn-outline-secondary">
                        <iconify-icon icon="solar:arrow-left-bold" width="20" height="20"></iconify-icon>
                        Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function resetFilter() {
    // Set default values (previous month for period 1, current month for period 2)
    const today = new Date();
    const prevMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
    const prevMonthLastDay = new Date(today.getFullYear(), today.getMonth(), 0);
    const currentMonthFirstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const currentMonthLastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    document.getElementById('tanggalAwal1').value = formatDate(prevMonth);
    document.getElementById('tanggalAkhir1').value = formatDate(prevMonthLastDay);
    document.getElementById('tanggalAwal2').value = formatDate(currentMonthFirstDay);
    document.getElementById('tanggalAkhir2').value = formatDate(currentMonthLastDay);
    
    // Clear unit selection
    const unitSelect = document.getElementById('idUnit');
    for (let i = 0; i < unitSelect.options.length; i++) {
        unitSelect.options[i].selected = false;
    }
}

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function cetakLaporan() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    
    // Get selected units
    const idUnit = document.getElementById('idUnit');
    const selectedUnits = Array.from(idUnit.selectedOptions).map(option => option.value);
    
    // Build URL
    const url = new URL('<?= base_url('LaporanKeuangan/laba_rugi_perbandingan_periode/cetak') ?>', window.location.origin);
    
    // Add form data
    url.searchParams.set('tanggal_awal_1', formData.get('tanggal_awal_1'));
    url.searchParams.set('tanggal_akhir_1', formData.get('tanggal_akhir_1'));
    url.searchParams.set('tanggal_awal_2', formData.get('tanggal_awal_2'));
    url.searchParams.set('tanggal_akhir_2', formData.get('tanggal_akhir_2'));
    
    if (selectedUnits.length > 0) {
        url.searchParams.set('id_unit', selectedUnits.join(','));
    }
    
    window.open(url.toString(), '_blank');
}
</script>
