<!-- Header Card -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Key Performance</h4>
    </div>
</div>

<!-- Form -->
<form method="post">
    <div class="card shadow-none position-relative overflow-hidden">
        <div class="card-body">
            <!-- Pegawai & Tanggal -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Pegawai</label>
                    <select class="form-select select2" name="pegawai_idpegawai" id="pegawaiSelect" required>
                        <option value="">-- Pilih Pegawai --</option>
                        <?php foreach ($akun as $a): ?>
                        <option value="<?= $a->ID_AKUN ?>" data-jabatan="<?= $a->ID_JABATAN ?? '' ?>"
                            <?= (isset($pegawai_idpegawai) && $pegawai_idpegawai == $a->ID_AKUN) ? 'selected' : '' ?>>
                            <?= $a->NAMA_AKUN ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tanggal Penilaian</label>
                    <input type="date" class="form-control" name="tanggal_penilaian_kpi" id="tanggalInput"
                        value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <!-- KPI Templates -->
            <div id="templateKpiContainer">
                <?php if (!empty($templatekpi)): ?>
                <?php foreach ($templatekpi as $index => $tpl): ?>
                <div class="card mb-3 p-3 border">
                    <input type="hidden" name="idpenilaian_kpi[]" value="<?= esc($tpl->idpenilaian_kpi ?? '') ?>">

                    <input type="hidden" name="kpi_utama[]" value="<?= esc($tpl->template_kpi) ?>">
                    <input type="hidden" name="level[]" value="<?= esc($levelList[$index] ?? $tpl->level) ?>">
                    <input type="hidden" name="template_kpi_idtemplate_kpi[]"
                        value="<?= esc($templateIdList[$index] ?? $tpl->idtemplate_kpi) ?>">
                    <input type="hidden" name="unit_idunit[]" value="<?= esc($unit_idunit) ?>">
                    <div class="mb-2">
                        <label class="form-label fw-semibold"><?= esc($tpl->template_kpi) ?></label>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-2">
                            <label class="form-label">Bobot</label>
                            <input type="number" name="bobot[]" class="form-control" value="<?= esc($tpl->bobot) ?>"
                                readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Target</label>
                            <input type="text" name="target[]" class="form-control" value="<?= esc($tpl->target) ?>"
                                readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Realisasi</label>
                            <input type="text" name="realisasi[]" class="form-control"
                                value="<?= esc($skorMap[$tpl->template_kpi]['realisasi'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Score</label>
                            <input type="number" name="score[]" step="0.01" class="form-control score-input" required>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="alert alert-info text-center">Pilih pegawai terlebih dahulu untuk menampilkan KPI.</div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <h5>Total Score: <span id="totalScore">0</span></h5>
                <h5>Rank: <span id="rank">-</span></h5>
            </div>

            <!-- Submit -->
            <div class="text-end mt-4">
                <?php if (isset($isUpdate) && $isUpdate): ?>
                <button type="submit" formaction="<?= base_url('update_penilaian_Key') ?>"
                    class="btn btn-warning">Update
                    Penilaian</button>
                <?php else: ?>
                <button type="submit" formaction="<?= base_url('insert_penilaian_Key') ?>"
                    class="btn btn-primary">Simpan
                    Penilaian</button>
                <?php endif; ?>
            </div>

        </div>
    </div>
</form>

<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- JS -->
<script>
$(document).ready(function() {
    // Initialize Select2
    $('#pegawaiSelect').select2({
        placeholder: "-- Pilih Pegawai --",
        allowClear: true,
        width: '100%'
    });

    // Convert comma to dot for decimal input
    $(document).on('input', '.score-input', function() {
        this.value = this.value.replace(',', '.');
    });

    // When Pegawai changes
    $('#pegawaiSelect').on('change', function() {
        const selectedId = $(this).val();
        const tanggal = $('#tanggalInput').val();

        if (selectedId) {
            const url = new URL(window.location.href);
            url.searchParams.set('pegawai_idpegawai', selectedId);
            if (tanggal) {
                url.searchParams.set('tanggal_penilaian_kpi', tanggal);
            }
            window.location.href = url.toString();
        }
    });

    // When Tanggal changes
    $('#tanggalInput').on('change', function() {
        const tanggal = $(this).val();
        const pegawai = $('#pegawaiSelect').val();

        if (pegawai) {
            const url = new URL(window.location.href);
            url.searchParams.set('tanggal_penilaian_kpi', tanggal);
            url.searchParams.set('pegawai_idpegawai', pegawai);
            window.location.href = url.toString();
        }
    });

    // Auto calculate scores
    function calculateAll() {
        let total = 0;
        const rows = $("#templateKpiContainer .card");

        rows.each(function() {
            const bobot = parseFloat($(this).find('input[name="bobot[]"]').val()) || 0;
            const target = parseFloat($(this).find('input[name="target[]"]').val()) || 0;
            const realisasi = parseFloat($(this).find('input[name="realisasi[]"]').val()) || 0;

            let score = 0;
            if (target > 0) {
                score = (realisasi / target) * bobot;
            }

            $(this).find('input[name="score[]"]').val(score.toFixed(2));
            total += score;
        });

        $('#totalScore').text(total.toFixed(2));

        let rank = "-";
        if (total >= 90) rank = "Platinum";
        else if (total >= 80) rank = "Gold";
        else if (total >= 70) rank = "Silver";
        else rank = "Bronze";

        $('#rank').text(rank);
    }

    // Run on load
    calculateAll();

    // Recalculate when inputs change
    $(document).on('input', 'input[name="realisasi[]"], input[name="target[]"], input[name="bobot[]"]',
        calculateAll);
});
</script>