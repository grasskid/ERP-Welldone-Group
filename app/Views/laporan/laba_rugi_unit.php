<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Laba Rugi Comparation Berdasarkan Unit</h3>
                </div>
                <div class="card-body">
                    <form method="get" action="<?= site_url('LaporanKeuangan/laba_rugi_unit') ?>" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" id="tanggalAwal" class="form-control"
                                        value="<?= $tanggal_awal ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" id="tanggalAkhir" class="form-control"
                                        value="<?= $tanggal_akhir ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Unit/Cabang</label>
                                    <select name="id_unit[]" id="idUnit" class="form-control" multiple size="4">
                                        <option value="">Semua Cabang</option>
                                        <?php foreach ($unit as $u): ?>
                                            <option value="<?= $u->idunit ?>"
                                                <?= $id_unit == $u->idunit ? 'selected' : '' ?>>
                                                <?= $u->NAMA_UNIT ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">Tekan Ctrl/Cmd untuk memilih multiple unit</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php if ($tanggal_awal || $tanggal_akhir || $id_unit): ?>
                                <button type="button" class="btn btn-success" onclick="printLaporanPerbandingan()">
                                    <iconify-icon icon="solar:print" width="20" height="20"></iconify-icon>
                                    Cetak Laporan Laba Rugi Comparation Berdasarkan Unit
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printLaporanPerbandingan() {
        var select = document.getElementById('idUnit');
        var selectedUnits = Array.from(select.selectedOptions).map(option => option.value);
        var tanggalAwal = document.getElementById('tanggalAwal').value;
        console.log(selectedUnits);
        var tanggalAkhir = document.getElementById('tanggalAkhir').value;
        if (selectedUnits.length < 2) {
            alert('Pilih minimal 2 unit untuk perbandingan');
            return;
        }

        var idunit = selectedUnits.join(',');
        var url = '<?= base_url('LaporanKeuangan/laba_rugi_perbandingan/cetak') ?>?tanggal_awal=' + tanggalAwal + '&tanggal_akhir=' + tanggalAkhir + '&id_unit=' + idunit;
        window.open(url, '_blank');
    }
</script>