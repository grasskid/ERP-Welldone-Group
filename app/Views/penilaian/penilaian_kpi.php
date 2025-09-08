<!-- Header Card -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Penilaian KPI</h4>
    </div>
</div>

<!-- Form -->
<form method="post" action="insert_penilaian">
    <div class="card shadow-none position-relative overflow-hidden">
        <div class="card-body">
            <!-- Pegawai & Tanggal -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Pegawai</label>
                    <select class="form-select" name="pegawai_idpegawai" id="pegawaiSelect" required>
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
                    <input type="hidden" name="kpi_utama[]" value="<?= esc($tpl->template_kpi) ?>">
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
                            <input type="number" name="score[]" class="form-control" required>
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
                <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
            </div>
        </div>
    </div>
</form>

<!-- JS: Auto Submit on Pegawai Change -->
<!-- <script>
document.getElementById('pegawaiSelect').addEventListener('change', function() {
    const selectedId = this.value;
    if (selectedId) {
        const url = new URL(window.location.href);
        url.searchParams.set('pegawai_idpegawai', selectedId);
        window.location.href = url.toString();
    }
});
</script> -->

<script>
document.getElementById('pegawaiSelect').addEventListener('change', function() {
    const selectedId = this.value;
    const tanggal = document.getElementById('tanggalInput').value;
    if (selectedId) {
        const url = new URL(window.location.href);
        url.searchParams.set('pegawai_idpegawai', selectedId);
        if (tanggal) {
            url.searchParams.set('tanggal_penilaian_kpi', tanggal);
        }
        window.location.href = url.toString();
    }
});

document.getElementById('tanggalInput').addEventListener('change', function() {
    const tanggal = this.value;
    const pegawai = document.getElementById('pegawaiSelect').value;
    if (pegawai) {
        const url = new URL(window.location.href);
        url.searchParams.set('tanggal_penilaian_kpi', tanggal);
        url.searchParams.set('pegawai_idpegawai', pegawai);
        window.location.href = url.toString();
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const rows = document.querySelectorAll("#templateKpiContainer .card");
    const totalScoreEl = document.getElementById("totalScore");
    const rankEl = document.getElementById("rank");

    function calculateAll() {
        let total = 0;

        rows.forEach(row => {
            const bobotInput = row.querySelector('input[name="bobot[]"]');
            const targetInput = row.querySelector('input[name="target[]"]');
            const realisasiInput = row.querySelector('input[name="realisasi[]"]');
            const scoreInput = row.querySelector('input[name="score[]"]');

            let bobot = parseFloat(bobotInput.value) || 0;
            let target = parseFloat(targetInput.value) || 0;
            let realisasi = parseFloat(realisasiInput.value) || 0;

            let score = 0;
            if (target > 0) {
                score = (realisasi / target) * bobot;
            }

            scoreInput.value = score.toFixed(2);
            total += score;
        });

        // Update total score
        totalScoreEl.textContent = total.toFixed(2);

        // Determine rank
        let rank = "-";
        if (total >= 90) {
            rank = "Platinum";
        } else if (total >= 80) {
            rank = "Gold";
        } else if (total >= 70) {
            rank = "Silver";
        } else {
            rank = "Bronze";
        }

        rankEl.textContent = rank;
    }

    // Initial calculation
    calculateAll();

    // Recalculate when inputs change
    rows.forEach(row => {
        row.querySelectorAll('input').forEach(input => {
            input.addEventListener("input", calculateAll);
        });
    });
});
</script>