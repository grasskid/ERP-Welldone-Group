<!-- Card Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Tugas</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat Tugas</li>
            </ol>
        </nav>
    </div>
</div>

<?php
$groups = [];
foreach ($tugas as $row) {
    $groups[$row->akun_ID_AKUN][] = $row;
}
?>

<!-- Filter and Grouped Table -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body px-4 pt-4 pb-2">

        <form method="get" class="mb-4">
            <div class="row">
                <div class="col">
                    <label>Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="<?= esc($tanggal_awal) ?>">
                </div>
                <div class="col">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="<?= esc($tanggal_akhir) ?>">
                </div>
                <div class="col">
                    <label>Unit</label>
                    <select name="id_unit" class="form-control">
                        <option value="">-- Semua Unit --</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit->idunit ?>" <?= $id_unit == $unit->idunit ? 'selected' : '' ?>>
                                <?= esc($unit->NAMA_UNIT) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary form-control">Filter</button>
                </div>
            </div>
        </form>


        <div class="table-responsive">
            <table class="table border text-nowrap align-middle" id="zero_config">
                <thead>
                    <tr>
                        <th>Nama Akun</th>
                        <th>Jumlah Tugas</th>
                        <th>Detail</th>
                        <th style="display:none;">Tanggal Acuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groups as $akunId => $items):
                        $modalId = 'modal_' . md5($akunId);
                        $jumlahTugas = count($items);
                        $namaAkun = $items[0]->NAMA_AKUN ?? 'Akun Tidak Dikenal';
                        $firstDate = date('Y-m-d', strtotime($items[0]->created_at));
                    ?>
                        <tr>
                            <td><?= esc($namaAkun) ?></td>
                            <td><?= $jumlahTugas ?> Tugas</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#<?= $modalId ?>">Detail</button>
                                <button type="button" class="btn btn-sm btn-info"
                                    onclick="window.location.href='<?= base_url('alltugas') ?>'">Lihat Tugas</button>
                            </td>
                            <td style="display:none;"><?= $firstDate ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modals -->
<?php foreach ($groups as $akunId => $items):
    $modalId = 'modal_' . md5($akunId);
    $namaAkun = $items[0]->NAMA_AKUN ?? 'Akun Tidak Dikenal';
?>
    <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Tugas - <?= esc($namaAkun) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered detail-table mb-0">
                        <thead>
                            <tr>
                                <th>Nama Tugas</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $r): ?>
                                <tr>
                                    <td><?= esc($r->nama_tugas) ?></td>
                                    <td><?= esc($r->deskripsi) ?></td>
                                    <td><?= ['1' => 'To Do', '2' => 'Progress', '3' => 'Pending', '4' => 'Done'][$r->status] ?? 'Tidak Diketahui' ?>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($r->created_at)) ?></td>
                                    <td>
                                        <?php if (!empty($r->foto_tugas)):
                                            $imgId = 'img_' . md5($r->idtugas);
                                        ?>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#<?= $imgId ?>">Lihat Foto</button>
                                        <?php else: ?>
                                            <span class="text-muted">Tidak Ada</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- modal preview -->

<?php foreach ($groups as $items): ?>
    <?php foreach ($items as $r): ?>
        <?php if (!empty($r->foto_tugas)):
            $imgId = 'img_' . md5($r->idtugas);
            $imgSrc = base_url('foto_tugas/' . $r->foto_tugas);
        ?>


            <div class="modal fade" id="<?= $imgId ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content  border-0">
                        <div class="modal-body text-center p-0" style="overflow: hidden;">
                            <br>
                            <img src="<?= $imgSrc ?>" alt="Foto Tugas" class="img-fluid rounded shadow zoomable-image"
                                style="transition: transform 0.3s ease; cursor: grab; max-height: 500px;">
                        </div>
                        <div class="modal-footer justify-content-center gap-2 flex-wrap bg-white rounded-bottom">
                            <div class="btn-group me-3" role="group">
                                <button class="btn btn-secondary btn-pan" data-x="0" data-y="-20">↑</button>
                                <div class="d-flex">
                                    <button class="btn btn-secondary btn-pan" data-x="-20" data-y="0">←</button>
                                    <button class="btn btn-secondary btn-pan" data-x="20" data-y="0">→</button>
                                </div>
                                <button class="btn btn-secondary btn-pan" data-x="0" data-y="20">↓</button>
                            </div>
                            <div class="btn-group" role="group">
                                <button class="btn btn-secondary btn-zoom-out">-</button>
                                <button class="btn btn-secondary btn-zoom-in">+</button>
                            </div>
                            <button class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>



<script>
    $(document).ready(function() {
        if (!$.fn.dataTable.isDataTable('#zero_config')) {
            var table = $('#zero_config').DataTable({
                columnDefs: [{
                    targets: [3],
                    visible: false
                }]
            });

            $('#tanggal_awal, #tanggal_akhir').on('change', function() {
                var startDate = $('#tanggal_awal').val();
                var endDate = $('#tanggal_akhir').val();

                $.fn.dataTable.ext.search = [];
                $.fn.dataTable.ext.search.push(function(settings, data) {
                    var tanggal = data[3];
                    if (!startDate && !endDate) return true;
                    if (startDate && tanggal < startDate) return false;
                    if (endDate && tanggal > endDate) return false;
                    return true;
                });

                table.draw();
            });
        }

        $('.detail-table').each(function() {
            if (!$.fn.dataTable.isDataTable(this)) {
                $(this).DataTable();
            }
        });
    });
</script>


<script>
    let previousModalId = null;

    // Saat tombol untuk membuka modal gambar diklik, simpan modal sebelumnya
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const targetModal = this.getAttribute('data-bs-target');
            const parentModal = this.closest('.modal');
            if (parentModal) {
                previousModalId = parentModal.getAttribute('id');
                const parentInstance = bootstrap.Modal.getInstance(parentModal);
                if (parentInstance) {
                    parentInstance.hide();
                }
            }
        });
    });

    document.querySelectorAll('.modal').forEach(modal => {
        const img = modal.querySelector('.zoomable-image');
        if (!img) return;

        let scale = 1;
        let posX = 0;
        let posY = 0;
        let isDragging = false;
        let startX = 0,
            startY = 0;

        // Zoom pakai scroll
        img.addEventListener('wheel', function(e) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? -0.1 : 0.1;
            scale = Math.min(Math.max(0.5, scale + delta), 5);
            updateTransform();
        });

        // Drag pakai mouse
        img.addEventListener('mousedown', function(e) {
            isDragging = true;
            startX = e.clientX - posX;
            startY = e.clientY - posY;
            img.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            posX = e.clientX - startX;
            posY = e.clientY - startY;
            updateTransform();
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
            img.style.cursor = 'grab';
        });

        // Reset dan kembalikan modal sebelumnya saat modal ditutup
        modal.addEventListener('hidden.bs.modal', function() {
            scale = 1;
            posX = 0;
            posY = 0;
            updateTransform();

            // Hapus backdrop manual jika tertinggal
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';

            // Buka modal sebelumnya jika ada
            if (previousModalId) {
                const prevModal = document.getElementById(previousModalId);
                if (prevModal) {
                    const prevInstance = new bootstrap.Modal(prevModal);
                    prevInstance.show();
                }
                previousModalId = null; // reset
            }
        });

        // Tombol Zoom
        modal.querySelector('.btn-zoom-in')?.addEventListener('click', () => {
            scale = Math.min(scale + 0.1, 5);
            updateTransform();
        });

        modal.querySelector('.btn-zoom-out')?.addEventListener('click', () => {
            scale = Math.max(scale - 0.1, 0.5);
            updateTransform();
        });

        // Tombol Pan
        modal.querySelectorAll('.btn-pan').forEach(btn => {
            btn.addEventListener('click', () => {
                const dx = parseInt(btn.getAttribute('data-x'));
                const dy = parseInt(btn.getAttribute('data-y'));
                posX += dx;
                posY += dy;
                updateTransform();
            });
        });

        function updateTransform() {
            img.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
        }

        img.style.cursor = 'grab';
    });
</script>