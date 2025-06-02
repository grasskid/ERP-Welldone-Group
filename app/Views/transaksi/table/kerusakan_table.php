<?php
$kerusakan_terpilih = [];
foreach ($oldkerusakan as $item) {
    $kerusakan_terpilih[$item->fungsi_idfungsi] = $item->keterangan;
}
?>

<form id="form-kerusakan">
    <div class="row">
        <?php
        $chunks = array_chunk($fungsi, ceil(count($fungsi) / 3));
        foreach ($chunks as $group) : ?>
            <div class="col-md-4 mb-3">
                <?php foreach ($group as $row) :
                    $idfungsi = $row->idfungsi;
                    $sudah_dipilih = array_key_exists($idfungsi, $kerusakan_terpilih);
                    $keterangan = $kerusakan_terpilih[$idfungsi] ?? '';
                ?>
                    <div class="form-check mb-3 fs-5">
                        <input class="form-check-input me-2 checkbox-fungsi"
                            type="checkbox"
                            name="<?= $sudah_dipilih ? '' : 'fungsi[]' ?>"
                            value="<?= esc($idfungsi) ?>"
                            id="fungsi_<?= esc($idfungsi) ?>"
                            data-id="<?= esc($idfungsi) ?>"
                            <?= $sudah_dipilih ? 'checked disabled' : '' ?>>

                        <label class="form-check-label" for="fungsi_<?= esc($idfungsi) ?>">
                            <?= esc($row->nama_fungsi) ?>
                        </label>

                        <div class="mt-2"
                            id="keterangan_<?= esc($idfungsi) ?>"
                            style="<?= $sudah_dipilih ? '' : 'display: none;' ?>">
                            <textarea class="form-control"
                                name="<?= $sudah_dipilih ? '' : 'keterangan[' . esc($idfungsi) . ']' ?>"
                                rows="2"
                                placeholder="Tulis keterangan untuk <?= esc($row->nama_fungsi) ?>"
                                <?= $sudah_dipilih ? 'readonly' : '' ?>><?= esc($keterangan) ?></textarea>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="display: flex; justify-content: space-between;">
        <div>
            <button type="button" class="btn btn-light" id="btn-previous-to-pelanggan">Sebelumnya</button>
            <button type="button" class="btn btn-success" id="btn-next-to-sparepart">Selanjutnya</button>
        </div>

    </div>
</form>



<script>
    document.getElementById('btn-next-to-sparepart').addEventListener('click', function() {
        var tabTrigger = new bootstrap.Tab(document.querySelector('#sparepart-tab'));
        tabTrigger.show();
    });

    document.getElementById('btn-previous-to-pelanggan').addEventListener('click', function() {
        var tabTrigger = new bootstrap.Tab(document.querySelector('#pelanggan-tab'));
        tabTrigger.show();
    });
</script>

<script>
    // Saat dokumen siap
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.checkbox-fungsi');

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const id = this.dataset.id;
                const keteranganDiv = document.getElementById('keterangan_' + id);

                if (this.checked) {
                    keteranganDiv.style.display = 'block';
                } else {
                    keteranganDiv.style.display = 'none';
                }
            });
        });
    });
</script>

<script>
    document.querySelectorAll('.checkbox-fungsi').forEach(function(checkbox) {
        if (!checkbox.disabled) {
            checkbox.addEventListener('change', function() {
                var id = this.getAttribute('data-id');
                var textarea = document.getElementById('keterangan_' + id);
                textarea.style.display = this.checked ? 'block' : 'none';
            });
        }
    });
</script>