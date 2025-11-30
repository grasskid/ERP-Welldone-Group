<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Laba Rugi</h3>
                </div>
                <div class="card-body">
                    <form method="get" action="<?= site_url('LaporanKeuangan/laba_rugi_standar') ?>" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" class="form-control"
                                        value="<?= $tanggal_awal ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control"
                                        value="<?= $tanggal_akhir ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Unit/Cabang</label>
                                    <select name="id_unit" class="form-control">
                                        <option value="">Semua Cabang</option>
                                        <?php foreach ($unit as $u): ?>
                                            <option value="<?= $u->idunit ?>"
                                                <?= $id_unit == $u->idunit ? 'selected' : '' ?>>
                                                <?= $u->NAMA_UNIT ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis Laporan</label>
                                    <select name="jenis_laporan" class="form-control">
                                        <option value="transaksi" <?= $jenis_laporan == 'transaksi' ? 'selected' : '' ?>>Berdasarkan Transaksi</option>
                                        <option value="jurnal" <?= $jenis_laporan == 'jurnal' ? 'selected' : '' ?>>Berdasarkan Jurnal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($tanggal_awal || $tanggal_akhir || $id_unit): ?>
                                    <a href="<?= site_url('LaporanKeuangan/laba_rugi_standar/cetak') . '?' . http_build_query($_GET) ?>"
                                        target="_blank" class="btn btn-success">
                                        Cetak Laporan
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>