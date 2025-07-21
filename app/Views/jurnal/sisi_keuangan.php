<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Sisi Keuangan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Keuangan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sisi Keuangan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="mb-0">Ringkasan Sisi Keuangan per Parent Akun</h5>
    </div>

    <a href="<?= base_url('cetak/posisi_keuangan?' . http_build_query([
                    'startDate' => $tanggal_awal,
                    'endDate' => $tanggal_akhir,
                    'filterUnit' => $id_unit
                ])) ?>" target="_blank" class="btn btn-danger ml-2" style="width: 100px; margin-left: 20px;">Cetak</a>

    <form method="get" class="mb-4" style="margin-left: 20px; margin-top: 20px;">
        <div style="display: flex; gap:40px">
            <div style="display: grid;">
                <label>Tanggal Awal:</label>
                <input type="date" name="startDate" class="form-control" value="<?= esc($tanggal_awal) ?>">
            </div>

            <div style="display: grid;">
                <label class="ml-2">Tanggal Akhir:</label>
                <input type="date" name="endDate" class="form-control" value="<?= esc($tanggal_akhir) ?>">
            </div>
            <div style="display: grid;">
                <label class="ml-2">Unit:</label>
                <select name="filterUnit" class="form-control">
                    <option value="">Semua Unit</option>
                    <?php foreach ($data_unit as $u): ?>
                        <option value="<?= $u->idunit ?>" <?= ($id_unit == $u->idunit) ? 'selected' : '' ?>>
                            <?= $u->NAMA_UNIT ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 150px; height:60px; margin-top: 20px;">Tampilkan</button>
        </div>
    </form>






    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-5 fw-semibold mb-0">Kode Parent</h6>
                    </th>
                    <th>
                        <h6 class="fs-5 fw-semibold mb-0">Nama Akun Parent</h6>
                    </th>
                    <th class="text-end">
                        <h6 class="fs-5 fw-semibold mb-0">Debit Kredit</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_parent)): ?>
                    <?php foreach ($data_parent as $row):
                        $saldo = $row['total_debet'] - $row['total_kredit'];
                        $saldoDisplay = number_format(abs($saldo), 0, ',', '.');
                        $saldoClass = $saldo < 0 ? 'text-danger' : '';
                    ?>
                        <tr>
                            <td><?= esc($row['parent_no_akun']) ?></td>
                            <td><?= esc($row['parent_nama_akun']) ?></td>
                            <td class="text-end fw-semibold <?= $saldoClass ?>"><?= $saldoDisplay ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data keuangan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <?php if (!empty($data_grand_parent)):
                $grandSaldo = $data_grand_parent->total_debet - $data_grand_parent->total_kredit;
                $grandSaldoDisplay = number_format(abs($grandSaldo), 0, ',', '.');
                $grandSaldoClass = $grandSaldo < 0 ? 'text-danger' : '';
            ?>
                <tfoot>
                    <tr class="fw-bold text-dark">
                        <td colspan="2" class="text-end">Total Grandparent (<?= esc($data_grand_parent->nama_akun) ?>)</td>
                        <td class="text-end fw-semibold <?= $grandSaldoClass ?>"><?= $grandSaldoDisplay ?></td>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>