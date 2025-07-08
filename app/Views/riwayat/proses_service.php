<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Proses Service</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Proses</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Service</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
    </div>

    <form action="<?php echo base_url('riwayat_service/export') ?>" method="post" enctype="multipart/form-data">
        <button type="submit" class="btn btn-danger"
            style="margin-left: 20px; display: inline-flex; align-items: center;">
            <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;"></iconify-icon>
            Export
        </button>
        <br><br>


        <!-- Filter Tanggal & Unit -->
        <div class="mb-3 px-4">

            <label class="ms-3 me-2">Tanggal Awal:</label>
            <input name="tanggal_awal" type="date" id="startDate" class="form-control d-inline"
                style="width: auto; display: inline-block;" onchange="filterData()">

            <label class="ms-3 me-2">Tanggal Akhir:</label>
            <input name="tanggal_akhir" type="date" id="endDate" class="form-control d-inline"
                style="width: auto; display: inline-block;" onchange="filterData()">

            <button type="button" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
        </div>
    </form>





    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" <?= empty($service) ? '' : 'id="zero_config"' ?>>

            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">No Service</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Tanggal Service Masuk</h6>
                    </th>



                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Pelanggan</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nomor Handphone</h6>
                    </th>

                    <th style="display: flex; justify-content: center;">
                        <h6 class="fs-4 fw-semibold mb-0">Alamat</h6>
                    </th>

                    <th>
                        <h6 style="display: flex; justify-content: center;" class="fs-4 fw-semibold mb-0">Lama</h6>
                    </th>

                    <th>
                        <h6 style="display: flex; justify-content: center;" class="fs-4 fw-semibold mb-0">Status Service</h6>
                    </th>



                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Detail Service</h6>
                    </th>

                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Ubah Status</h6>
                    </th>

                    <th style="display: flex; justify-content: center;">
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($service)): ?>
                    <?php foreach ($service as $row): ?>
                        <tr>
                            <td><?= esc($row->no_service) ?></td>
                            <td><?= esc(date('d-m-Y', strtotime($row->created_at))) ?></td>

                            <td><?= esc($row->nama_pelanggan) ?></td>
                            <td><?= esc($row->no_hp) ?></td>
                            <td><?= esc($row->alamat) ?></td>
                            <td><?= esc($row->lama_service) ?></td>
                            <td>
                                <?php if (!empty($row->tanggal_claim_garansi) && $row->tanggal_claim_garansi > '1971-01-01'): ?>
                                    Service Garansi
                                <?php else: ?>
                                    Service Baru
                                <?php endif; ?>
                            </td>
                            <!-- Tombol Status -->
                            <td>
                                <?php
                                $status = $row->status_proses;
                                $id = $row->idservice;

                                $statusMap = [
                                    1 => ['text' => 'Belum Dicek', 'class' => 'btn-light'],
                                    2 => ['text' => 'Sedang Dicek', 'class' => 'btn-primary'],
                                    3 => ['text' => 'Sedang Dikerjakan', 'class' => 'btn-success'],
                                    4 => ['text' => 'Sedang Testing', 'class' => 'btn-secondary'],
                                    5 => ['text' => 'Menunggu Konfirmasi', 'class' => 'btn-danger'],
                                    6 => ['text' => 'Menunggu Sparepart', 'class' => 'btn-warning'],
                                ];

                                $current = $statusMap[$status] ?? ['text' => 'Status Tidak Diketahui', 'class' => 'btn-outline-dark'];

                                echo '<button type="button" class="btn ' . $current['class'] . '" data-bs-toggle="modal" data-bs-target="#statusModal-' . $id . '">' . $current['text'] . '</button>';
                                ?>
                            </td>


                            <td>
                                <button class="btn btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#bisaDiambilModal-<?= esc($row->idservice) ?>"
                                    data-idservice="<?= esc($row->idservice) ?>">
                                    Bisa Diambil
                                </button>


                            </td>


                            <td>
                                <?php
                                // Kondisi 1: Jika status service adalah 4, tombol dinonaktifkan (prioritas tertinggi).
                                if ($row->status_service == 4):
                                ?>
                                    <button type="button" class="btn btn-warning edit-button" disabled>
                                        <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                    </button>

                                <?php
                                // Kondisi 2: Jika tanggal klaim garansi ada dan merupakan tanggal yang valid.
                                elseif (isset($row->tanggal_claim_garansi) && strtotime($row->tanggal_claim_garansi) > 0):
                                ?>
                                    <a href="<?php echo base_url('service_by_garansi/' . $row->idservice) ?>">
                                        <button type="button" class="btn btn-warning edit-button">
                                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                        </button>
                                    </a>

                                <?php
                                // Kondisi 3 (Default): Jika dua kondisi di atas tidak terpenuhi.
                                else:
                                ?>
                                    <a href="<?php echo base_url('detail/riwayat_service/' . $row->idservice) ?>">
                                        <button type="button" class="btn btn-warning edit-button">
                                            <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                        </button>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo base_url('cetak/invoice_service/' . $row->idservice) ?>">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        style="display: inline-flex; align-items: center;">
                                        <iconify-icon icon="solar:folder-favourite-bookmark-broken" width="24" height="24">
                                        </iconify-icon>
                                        Cetak Struk
                                    </button>
                                </a>
                                <button type="button" class="btn btn-wa"
                                    data-nohp="<?= esc($row->no_hp) ?>"
                                    data-nama="<?= esc($row->nama_pelanggan) ?>"
                                    style="width: 100px; height: 40px; background-color: greenyellow;">
                                    <iconify-icon icon="solar:phone-bold" width="24" height="24"></iconify-icon>
                                </button>
                            </td>
                        </tr>

                        <!-- //modal detail status -->

                        <div class="modal fade" id="statusModal-<?= $id ?>" tabindex="-1" aria-labelledby="statusModalLabel-<?= $id ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="statusModalLabel-<?= $id ?>">Ubah Status Proses</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="<?= base_url('update_status_proses') ?>" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="hidden" name="idservice" value="<?= $id ?>">

                                            <div class="container-fluid">
                                                <div class="row">
                                                    <?php foreach ($statusMap as $value => $info): ?>
                                                        <div class="col-6 mb-2">
                                                            <input class="form-check-input" type="radio" name="status_proses" id="status<?= $value ?>-<?= $id ?>" value="<?= $value ?>" <?= $value == $status ? 'checked' : '' ?>>
                                                            <label style="width: 150px;" class="form-check-label btn <?= $info['class'] ?>  btn-sm ms-2" for="status<?= $value ?>-<?= $id ?>">
                                                                <?= $info['text'] ?>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- modal bsa dimabil -->

                        <div class="modal fade" id="bisaDiambilModal-<?= esc($row->idservice) ?>" tabindex="-1" aria-labelledby="bisaDiambilModalLabel-<?= esc($row->idservice) ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="bisaDiambilModalLabel-<?= esc($row->idservice) ?>">Konfirmasi Pengambilan</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <form action="<?= base_url('service/bisa_diambil') ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="idservice" value="<?= esc($row->idservice) ?>">
                                            <p>Apakah Anda yakin service ini sudah bisa diambil oleh pelanggan?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Konfirmasi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>






<script>
    window.onload = function() {
        const endDateInput = document.getElementById('endDate');
        const startDateInput = document.getElementById('startDate');

        const today = new Date();
        const fifteenDaysAgo = new Date();
        fifteenDaysAgo.setDate(today.getDate() - 15);


        const toDateInputValue = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        startDateInput.value = toDateInputValue(fifteenDaysAgo);
        endDateInput.value = toDateInputValue(today);



        filterData();
    };

    function filterData() {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;


        const rows = document.querySelectorAll('#zero_config tbody tr');
        rows.forEach(row => {
            const dateCell = row.children[1];
            if (!dateCell) return;

            const dateText = dateCell.textContent.trim();
            const parts = dateText.split('-');
            const rowDate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`);

            const startDate = start ? new Date(start) : null;
            const endDate = end ? new Date(end) : null;

            let dateMatch = true;
            if (startDate && rowDate < startDate) dateMatch = false;
            if (endDate && rowDate > endDate) dateMatch = false;

            row.style.display = (dateMatch) ? '' : 'none';
        });
    }

    function resetFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';

        filterData();
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-wa');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                let nomor = this.dataset.nohp.trim();
                let nama = this.dataset.nama.trim();

                // Normalisasi nomor HP
                if (nomor.startsWith('0')) {
                    nomor = '62' + nomor.substring(1);
                } else if (nomor.startsWith('+62')) {
                    nomor = nomor.substring(1); // hapus +
                }

                const waUrl = 'https://wa.me/' + nomor + '?text=' + encodeURIComponent("Halo, Kami dari welldone group ingin melakukan konfirmasi untuk service handphone atas nama " + nama);

                // Buka WhatsApp
                window.open(waUrl, '_blank');
            });
        });
    });
</script>