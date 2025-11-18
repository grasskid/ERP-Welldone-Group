<div class="card mb-4">
    <div class="card-body">
        <form method="get" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <!-- <select class="form-select" name="unit_idunit" onchange="this.form.submit()">
                        <option value="">-- Semua Unit --</option>
                        <?php foreach ($units as $unit): ?>
                        <option value="<?= $unit->idunit ?>" <?= ($unit_id == $unit->idunit ? 'selected' : '') ?>>
                            <?= $unit->NAMA_UNIT ?>
                        </option>
                        <?php endforeach; ?>

                    </select> -->
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body position-relative">
                        <div>
                            <h5 class="mb-1 fw-bold">Welcome <?= session()->get('NAMA') ?></h5>
                            <h6 class="mb-1 fw-bold"><?= session()->get('NAMA_JABATAN') ?></h6>
                            <p class="fs-3 mb-3 pb-1">Lokasi: <?= session()->get('NAMA_UNIT') ?></p>
                            <a href="<?= base_url('absensi') ?>" class="btn btn-primary rounded-pill" type="button">
                                Presensi
                            </a>
                            <a href="<?= base_url('tugas') ?>" class="btn btn-success rounded-pill" type="button">
                                Tugas
                            </a>
                            <a href="#" class="btn btn-danger rounded-pill" type="button" data-bs-toggle="modal"
                                data-bs-target="#reset-pegawai-modal">
                                Reset Password
                            </a>
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
            <!-- (UNMODIFIED — your commented area remains untouched) -->

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php if (session('ID_JABATAN') == 1 || session('ID_JABATAN') == 37 || session('ID_JABATAN') == 36): ?>
<script>
const ctx = document.getElementById('pendapatanChart').getContext('2d');
const pendapatanChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [
            <?php if (session('ID_JABATAN') == 1 || session('ID_JABATAN') == 37): ?> {
                label: 'Pendapatan POS',
                data: <?= json_encode($pendapatan_chart) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            },
            <?php endif; ?>
            <?php if (session('ID_JABATAN') == 1 || session('ID_JABATAN') == 36): ?> {
                label: 'Pendapatan Service',
                data: <?= json_encode($pendapatan_service_chart) ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.6)'
            }
            <?php endif; ?>
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
<?php endif; ?>

<?php if (session('ID_JABATAN') == 1 || session('ID_JABATAN') == 37): ?>
<script>
const barangLabels = <?= json_encode($barang_labels) ?>;
const barangData = <?= json_encode($barang_data) ?>;

new Chart(document.getElementById('barangTerlarisChart'), {
    type: 'bar',
    data: {
        labels: barangLabels,
        datasets: [{
            label: 'Total Penjualan',
            data: barangData,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Penjualan'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Barang'
                }
            }
        }
    }
});
</script>
<?php endif; ?>

<?php if (session('ID_JABATAN') == 1 || session('ID_JABATAN') == 37 || session('ID_JABATAN') == 36): ?>
<script>
const hutangLabels = <?= json_encode($hutang_labels) ?>;
const hutangBayar = <?= json_encode($hutang_bayar) ?>;
const hutangSisa = <?= json_encode($hutang_sisa) ?>;

new Chart(document.getElementById('hutangChart'), {
    type: 'line',
    data: {
        labels: hutangLabels,
        datasets: [{
                label: 'Total Bayar',
                data: hutangBayar,
                borderColor: 'green',
                backgroundColor: 'rgba(0,128,0,0.2)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Sisa Hutang',
                data: hutangSisa,
                borderColor: 'red',
                backgroundColor: 'rgba(255,0,0,0.2)',
                tension: 0.3,
                fill: true
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
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
<?php endif; ?>

<div class="modal fade" id="reset-pegawai-modal" tabindex="-1" aria-labelledby="resetpegawaiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('pegawai/reset') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="resetpegawaiModalLabel">Reset Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input hidden id="reset-id_pegawai" name="ID_AKUN">
                    <p style="font-style: italic;">Apa anda yakin ingin Reset password?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>