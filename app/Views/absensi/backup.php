<?php date_default_timezone_set('Asia/Jakarta'); ?>
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Service</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Transaksi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Service</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body">
        <div class="modal fade" id="loading-lokasi-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-4">
                    <center>
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                    </center>
                    <h5>Mendapatkan lokasi...</h5>
                </div>
            </div>
        </div>

        <h5 style="display: flex; padding-left: 20px; padding-top: 20px; padding-bottom: 20px;">Absensi Pegawai Tanggal
            : <?= date('d-m-Y') ?></h2>

            <div class="table-responsive mb-4 px-4">
                <table class="table border text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>Nama Pegawai</th>
                            <td>Tanggal</td>
                            <th>Jenis Absensi</th>
                            <th style="display: flex; justify-content: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= session('NAMA') ?></td>
                            <td><?= date('d-m-Y') ?></td>
                            <td>Absen Masuk</td>
                            <td style="display: flex; justify-content: center; gap: 10px;">
                                <?php if (!$sudahAbsenMasuk): ?>


                                    <button type="button" id="btn-absen-masuk" class="btn btn-primary">Submit</button>


                                <?php else: ?>

                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modal-detail-absen">Detail</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modal-peta-lokasi">Detail Lokasi</button>

                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</div>


<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body">


        <h5 style="display: flex; padding-left: 20px; padding-top: 20px; padding-bottom: 20px;">Absensi Pegawai Tanggal
            : <?= date('d-m-Y') ?></h2>

            <div class="table-responsive mb-4 px-4">
                <table class="table border text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>Nama Pegawai</th>
                            <th>Tanggal</th>
                            <th>Jenis Absensi</th>
                            <th style="display: flex; justify-content: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><?= session('NAMA') ?></td>
                            <td><?= date('d-m-Y') ?></td>
                            <td>Absen Pulang</td>
                            <td style="display: flex; justify-content: center;">
                                <?php if (!$sudahAbsenPulang): ?>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-konfirmasi-absen-pulang">
                                        Submit
                                    </button>

                                <?php else: ?>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modal-detail-absen-pulang">Detail</button>

                                <?php endif; ?>

                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

    </div>
</div>

<!-- modal absen masuk -->
<div class="modal fade" id="modal-konfirmasi-absen-masuk" tabindex="-1" aria-labelledby="konfirmasiAbsenMasukLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="konfirmasiAbsenMasukLabel">Konfirmasi Absen Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p style="font-style: italic;">Pilih shift terlebih dahulu</p>

                <form action="kirim/lokasi_masuk" enctype="multipart/form-data" method="post">

                    <div class="mb-3">
                        <label for="jadwal-select" class="form-label">Pilih Jadwal Masuk</label>
                        <select id="jadwal-select" class="form-select">
                            <option value="" disabled selected>-- Pilih Jadwal --</option>
                            <?php foreach ($jadwalmasuk as $jadwal): ?>
                                <option value="<?= $jadwal->idjadwal_masuk ?>" data-jammasuk="<?= $jadwal->jam_masuk ?>"
                                    data-jampulang="<?= $jadwal->jam_pulang ?>"
                                    data-jamtoleransi="<?= $jadwal->toleransi ?>">
                                    <?= $jadwal->nama_jadwal ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Ambil Foto Kehadiran</label>
                        <input type="file" name="foto_kehadiran" id="foto" class="form-control" accept="image/*"
                            capture="environment" required>
                    </div>


                    <input hidden id="latitude" name="latitude">
                    <input hidden id="longitude" name="longitude">

                    <div class="mb-2">
                        <label hidden>ID Jadwal Masuk</label>
                        <input hidden type="text" name="idjadwal_masuk" id="idjadwal_masuk" class="form-control"
                            readonly>
                    </div>

                    <div class="mb-2">
                        <label>Jam Masuk</label>
                        <input type="text" id="jam_masuk" name="jam_masuk" class="form-control" readonly>
                    </div>

                    <div class="mb-2">
                        <label>Jam Pulang</label>
                        <input type="text" id="jam_pulang" name="jam_pulang" class="form-control" readonly>
                    </div>

                    <div class="mb-2">
                        <label>Jam toleransi</label>
                        <input type="text" id="jam_toleransi" name="jam_toleransi" class="form-control" readonly>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="konfirmasi-absen-masuk">Ya, Absen Sekarang</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- absen pulang -->
<div class="modal fade" id="modal-konfirmasi-absen-pulang" tabindex="-1" aria-labelledby="konfirmasiAbsenPulangLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="konfirmasiAbsenPulangLabel">Konfirmasi Absen Pulang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <?php if (empty($idpresensiHariIni) || $idpresensiHariIni == 0): ?>
                    <p class="text-danger" style="font-style: italic;">Anda belum melakukan absen masuk.</p>
                <?php else: ?>
                    <p style="font-style: italic;">Apakah Anda yakin ingin melakukan absen pulang sekarang?</p>
                    <form action="kirim/lokasi_pulang" enctype="multipart/form-data" method="post">
                        <input type="text" hidden name="idpresensi" value="<?= esc($idpresensiHariIni) ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger-subtle text-danger"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="konfirmasi-absen-pulang">Ya, Absen
                                Pulang</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<!-- Modal Detail Absen -->
<div class="modal fade" id="modal-detail-absen" tabindex="-1" aria-labelledby="modalDetailAbsenLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailAbsenLabel">Detail Absen Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($presensiHariIni)): ?>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Nama:</strong> <?= session('NAMA') ?></li>
                        <li class="list-group-item"><strong>Tanggal:</strong>
                            <?= date('d-m-Y', strtotime($presensiHariIni->waktu_masuk)) ?></li>
                        <li class="list-group-item"><strong>Jam Masuk:</strong>
                            <?= date('H:i:s', strtotime($presensiHariIni->waktu_masuk)) ?></li>
                        <li class="list-group-item"><strong>IP:</strong> <?= esc($presensiHariIni->ip) ?></li>
                        <li class="list-group-item"><strong>Lokasi:</strong> <?= esc($presensiHariIni->lat) ?>,
                            <?= esc($presensiHariIni->long) ?></li>
                        <li class="list-group-item"><strong>Foto:</strong><br>
                            <?php if ($presensiHariIni->foto): ?>
                                <img src="<?= base_url('foto_presensi/' . $presensiHariIni->foto) ?>" alt="Foto Absen"
                                    style="max-width: 200px; max-height: 150px;">
                            <?php else: ?>
                                <em>Tidak ada foto</em>
                            <?php endif; ?>
                        </li>
                    </ul>
                <?php else: ?>
                    <p class="text-danger">Data presensi tidak ditemukan.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Absen Pulang -->
<div class="modal fade" id="modal-detail-absen-pulang" tabindex="-1" aria-labelledby="modalDetailAbsenPulangLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailAbsenPulangLabel">Detail Absen Pulang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($presensiHariIni) && !empty($presensiHariIni->waktu_pulang)): ?>
                    <?php
                    $jamMasuk = new DateTime($presensiHariIni->waktu_masuk);
                    $jamPulang = new DateTime($presensiHariIni->waktu_pulang);
                    $durasi = $jamMasuk->diff($jamPulang);
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Nama:</strong> <?= session('NAMA') ?></li>
                        <li class="list-group-item"><strong>Tanggal:</strong>
                            <?= date('d-m-Y', strtotime($presensiHariIni->waktu_masuk)) ?></li>
                        <li class="list-group-item"><strong>Jam Masuk:</strong>
                            <?= date('H:i:s', strtotime($presensiHariIni->waktu_masuk)) ?></li>
                        <li class="list-group-item"><strong>Jam Pulang:</strong>
                            <?= date('H:i:s', strtotime($presensiHariIni->waktu_pulang)) ?></li>
                        <li class="list-group-item"><strong>Durasi Kerja:</strong> <?= $durasi->format('%h jam %i menit') ?>
                        </li>
                    </ul>
                <?php else: ?>
                    <p class="text-danger">Data absen pulang tidak ditemukan.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Fullscreen Lokasi Pegawai -->
<div class="modal fade" id="modal-peta-lokasi" tabindex="-1" aria-labelledby="modalPetaLokasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLokasiLabel">Detail Lokasi Pegawai :
                    <?php if (isset($jarakKm)): ?>
                        <?= number_format($jarakKm, 2) ?> km
                    <?php endif; ?> </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-0">
                <div id="map" style="height: 100vh; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>




<script>
    let loadingModal;
    let konfirmasiModal;

    document.addEventListener('DOMContentLoaded', function() {
        const loadingModalEl = document.getElementById('loading-lokasi-modal');
        loadingModal = bootstrap.Modal.getOrCreateInstance(loadingModalEl);

        const konfirmasiModalEl = document.getElementById('modal-konfirmasi-absen-masuk');
        konfirmasiModal = bootstrap.Modal.getOrCreateInstance(konfirmasiModalEl);

        const btnAbsenMasuk = document.getElementById('btn-absen-masuk');

        btnAbsenMasuk.addEventListener('click', function() {
            // Tampilkan loading dulu
            loadingModal.show();

            // Ambil lokasi
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Isi input lat/long di modal konfirmasi
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;

                        // Setelah loading, tampilkan modal konfirmasi
                        setTimeout(() => {
                            loadingModal.hide();
                            konfirmasiModal.show();
                        }, 800);
                    },
                    function(error) {
                        setTimeout(() => {
                            loadingModal.hide();
                            alert('Gagal mendapatkan lokasi: ' + error.message);
                        }, 500);
                    }
                );
            } else {
                loadingModal.hide();
                alert('Geolocation tidak didukung oleh browser ini');
            }
        });

        // Submit form absen masuk saat user klik tombol konfirmasi
        document.getElementById('konfirmasi-absen-masuk').addEventListener('click', function() {
            const form = document.getElementById('form-masuk');

            // Optional: Validasi pilih jadwal
            const idjadwal = document.getElementById('idjadwal_masuk').value;
            if (!idjadwal) {
                alert('Silakan pilih jadwal masuk terlebih dahulu');
                return;
            }

            // Submit form
            form.submit();
        });
    });
</script>


<script>
    document.getElementById('konfirmasi-absen-masuk').addEventListener('click', function() {
        document.getElementById('form-masuk').submit();
    });
</script>

<script>
    document.getElementById('konfirmasi-absen-pulang').addEventListener('click', function() {
        document.getElementById('form-pulang').submit();
    });
</script>

<script>
    document.getElementById('jadwal-select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        const id = selectedOption.value;
        const jamMasuk = selectedOption.getAttribute('data-jammasuk');
        const jamPulang = selectedOption.getAttribute('data-jampulang');
        const jamToleransi = selectedOption.getAttribute('data-jamtoleransi');

        document.getElementById('idjadwal_masuk').value = id;
        document.getElementById('jam_masuk').value = jamMasuk;
        document.getElementById('jam_pulang').value = jamPulang;
        document.getElementById('jam_toleransi').value = jamToleransi;
    });

    document.getElementById('konfirmasi-absen-masuk').addEventListener('click', function() {
        // Bisa validasi jika belum pilih jadwal
        const jadwalId = document.getElementById('idjadwal_masuk').value;
        if (!jadwalId) {
            alert('Silakan pilih jadwal terlebih dahulu.');
            return;
        }

        // Submit form
        document.getElementById('form-masuk').submit();
    });
</script>


<script>
    const latitudeKantor = <?= json_encode($dataunit->LATITUDE ?? null) ?>;
    const longitudeKantor = <?= json_encode($dataunit->LONGTITUDE ?? null) ?>;
    const latitudePegawai = <?= json_encode($presensiHariIni->lat ?? null) ?>;
    const longitudePegawai = <?= json_encode($presensiHariIni->long ?? null) ?>;


    let map;

    function hitungJarak(lat1, lon1, lat2, lon2) {
        const R = 6371; // km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    document.getElementById('modal-peta-lokasi').addEventListener('shown.bs.modal', function() {
        if (!map) {
            map = L.map('map').setView([latitudeKantor, longitudeKantor], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Marker Kantor
            L.marker([latitudeKantor, longitudeKantor])
                .addTo(map)
                .bindPopup('Lokasi Kantor')
                .openPopup();

            // Marker Pegawai
            L.marker([latitudePegawai, longitudePegawai])
                .addTo(map)
                .bindPopup('Lokasi Pegawai');

            // Garis Polyline
            const latlngs = [
                [latitudeKantor, longitudeKantor],
                [latitudePegawai, longitudePegawai]
            ];

            const polyline = L.polyline(latlngs, {
                color: 'blue'
            }).addTo(map);

            // Hitung Jarak
            const jarak = hitungJarak(latitudeKantor, longitudeKantor, latitudePegawai, longitudePegawai);
            const midLat = (latitudeKantor + latitudePegawai) / 2;
            const midLng = (longitudeKantor + longitudePegawai) / 2;

            // Tooltip Jarak (di tengah polyline)
            L.tooltip({
                    permanent: true,
                    direction: 'top',
                    className: 'leaflet-distance-label'
                })
                .setContent(`${jarak.toFixed(2)} km`)
                .setLatLng([midLat, midLng])
                .addTo(map);

            // Judul Modal Update
            const titleElement = document.getElementById('modalDetailLokasiLabel');
            if (titleElement) {
                titleElement.textContent = `Detail Lokasi Pegawai - Jarak ${jarak.toFixed(2)} km`;
            }
        } else {
            map.invalidateSize();
        }
    });
</script>

<style>
    .leaflet-distance-label {
        background-color: white;
        border: 1px solid #999;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 13px;
        font-weight: bold;
        color: #333;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
    }
</style>






//controller