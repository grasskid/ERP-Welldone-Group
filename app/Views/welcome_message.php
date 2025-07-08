<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <select class="form-select" name="unit_idunit" onchange="this.form.submit()">
                        <option value="">-- Semua Unit --</option>
                        <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit->idunit ?>" <?= ($unit_id == $unit->idunit ? 'selected' : '') ?>>
                            <?= $unit->idunit == session()->get('ID_UNIT') ? session()->get('NAMA_UNIT') : 'Unit #' . $unit->idunit ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body position-relative">
                        <div>
                            <h5 class="mb-1 fw-bold">Welcome <?= session()->get('NAMA') ?></h5>
                            <p class="fs-3 mb-3 pb-1">Lokasi: <?= session()->get('NAMA_UNIT') ?></p>
                            <button class="btn btn-primary rounded-pill" type="button">Visit Now</button>
                        </div>
                        <div class="school-img d-none d-sm-block">
                            <img src="<?= base_url('template/') ?>assets/images/backgrounds/school.png"
                                class="img-fluid" alt="" />
                        </div>
                        <div class="d-sm-none d-block text-center">
                            <img src="<?= base_url('template/') ?>assets/images/backgrounds/school.png"
                                class="img-fluid" alt="" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metric Cards -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-4 d-flex align-items-stretch">
                        <div class="card warning-card overflow-hidden text-bg-primary w-100">
                            <div class="card-body p-4">
                                <div class="mb-7">
                                    <i class="ti ti-users fs-8 fw-lighter"></i>
                                </div>
                                <h5 class="text-white fw-bold fs-14 text-nowrap">
                                    <span class="fs-2 fw-light"><?= $pelanggan ?></span>
                                </h5>
                                <p class="opacity-50 mb-0">Pelanggan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 d-flex align-items-stretch">
                        <div class="card warning-card overflow-hidden text-bg-primary w-100">
                            <div class="card-body p-4">
                                <div class="mb-7">
                                    <i class="ti ti-user-plus fs-8 fw-lighter"></i>
                                </div>
                                <h5 class="text-white fw-bold fs-14 text-nowrap">
                                    <span class="fs-2 fw-light"><?= $pelanggan_baru ?></span>
                                </h5>
                                <p class="opacity-50 mb-0">Pelanggan Baru (1 Bulan)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 d-flex align-items-stretch">
                        <div class="card warning-card overflow-hidden text-bg-primary w-100">
                            <div class="card-body p-4">
                                <div class="mb-7">
                                    <i class="ti ti-users fs-8 fw-lighter"></i>
                                </div>
                                <h5 class="text-white fw-bold fs-14 text-nowrap">
                                    <span class="fs-2 fw-light"><?= $pelanggan_service ?></span>
                                </h5>
                                <p class="opacity-50 mb-0">Pelanggan Service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Area -->
            <div class="col-lg-12 mt-4">
                <div class="card shadow-none position-relative overflow-hidden">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Grafik Pendapatan 6 Bulan Terakhir</h5>
                        <canvas id="pendapatanChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('pendapatanChart').getContext('2d');
const pendapatanChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
                label: 'Pendapatan POS',
                data: <?= json_encode($pendapatan_chart) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            },
            {
                label: 'Pendapatan Service',
                data: <?= json_encode($pendapatan_service_chart) ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.6)'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.raw.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                },
                beginAtZero: true
            }
        }
    }
});
</script>