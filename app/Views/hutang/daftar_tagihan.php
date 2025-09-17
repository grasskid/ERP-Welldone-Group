<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Riwayat Pembayaran Hutang</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Riwayat</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pembayaran Hutang</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <form action="<?= base_url('export_daftar_hutang') ?>" method="post" enctype="multipart/form-data">
        <div class="px-4 py-3 border-bottom">
            <button type="submit" class="btn btn-danger"
                style="margin-left: 20px; display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:export-broken" width="24" height="24" style="margin-right: 8px;">
                </iconify-icon>
                Export
            </button>



        </div>


        <div class="row my-3 mx-1">
            <div class="mb-3 px-4">
                <label class="ms-3 me-2">Tanggal Awal:</label>
                <input name="tanggal_awal" type="date" id="startDate" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">

                <label class="ms-3 me-2">Tanggal Akhir:</label>
                <input name="tanggal_akhir" type="date" id="endDate" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">

                <label class="ms-3 me-2">Nama Unit:</label>
                <select name="nama_unit" id="unitSelect" class="form-control d-inline"
                    style="width: auto; display: inline-block;" onchange="filterData()">
                    <option value="">Semua Unit</option>
                    <?php
                    $unitList = [];
                    foreach ($hutang as $row) {
                        if (!in_array($row->NAMA_UNIT, $unitList)) {
                            $unitList[] = $row->NAMA_UNIT;
                            echo '<option value="' . esc($row->NAMA_UNIT) . '">' . esc($row->NAMA_UNIT) . '</option>';
                        }
                    }
                    ?>
                </select>

                <button type="button" onclick="resetFilter()" class="btn btn-sm btn-secondary ms-3">Reset</button>
                <input type="hidden" id="hiddenNamaUnit" name="hiddenNamaUnit">
            </div>
        </div>
    </form>





    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Tanggal Pembelian</th>
                    <th>Unit</th>
                    <th>Nota Pembelian</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Sisa Hutang</th>
                    <th>action</th>


                </tr>
            </thead>
            <tbody>
                <?php if (!empty($hutang)): ?>
                    <?php foreach ($hutang as $row): ?>
                        <tr>
                            <td><?= esc(date('d-m-Y', strtotime($row->tanggal_masuk))) ?></td>
                            <td><?= esc($row->NAMA_UNIT) ?></td>
                            <td><?= esc($row->no_nota_supplier) ?></td>
                            <td><?= esc(date('d-m-Y', strtotime($row->jatuh_tempo))) ?></td>
                            <td><?= esc('Rp ' . number_format($row->sisa, 0, ',', '.')) ?></td>

                            <td>
                                <button type="button" class="btn btn-warning edit-button" style="display: flex; gap: 5px; justify-content: center; padding-top: 16px;" data-bs-toggle="modal"
                                    data-bs-target="#bayar-tagihan-modal"
                                    data-idpembelian="<?= esc($row->idpembelian) ?>"
                                    data-no_nota_supplier="<?= esc($row->no_nota_supplier) ?>"
                                    data-tanggal_masuk="<?= esc($row->tanggal_masuk) ?>"
                                    data-sisa="<?= esc($row->sisa) ?>">
                                    <iconify-icon icon="solar:clapperboard-edit-broken" width="24" height="24"></iconify-icon>
                                    <p>Bayar Tagihan</p>
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Bayar Tagihan -->
<div class="modal fade" id="bayar-tagihan-modal" tabindex="-1" aria-labelledby="bayarTagihanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="bayarTagihanModalLabel">Bayar Tagihan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= base_url('update_cicilan_hutang') ?>" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <!-- ID Pembelian -->
                    <input type="hidden" id="edit_idpembelian" name="idpembelian">
                    <div style="display: flex; gap: 20px;">
                        <div class="mb-3">
                            <label for="edit_no_nota_supplier" class="form-label">No Nota Supplier</label>
                            <input style="width: 400px;" type="text" class="form-control" id="edit_no_nota_supplier" name="no_nota_supplier" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="edit_tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" style="width: 400px;" class="form-control" id="edit_tanggal_masuk" name="tanggal_masuk" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="metode_bayar" class="form-label">Metode Pembayaran</label>
                            <select id="metode_bayar" name="metode_bayar" class="form-control">
                                <option disabled selected>Pilih Metode</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                                <option value="tunai_transfer">Tunai + Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bayar_tunai" class="form-label">Bayar Tunai</label>
                        <input type="text" class="form-control" id="bayar_tunai" name="bayar_tunai" value="Rp 0">
                    </div>

                    <div class="row mb-3 transfer-section">
                        <div class="col-md-6">
                            <label for="bayar_bank" class="form-label">Bayar Bank</label>
                            <input type="text" class="form-control" id="bayar_bank" name="bayar_bank" value="Rp 0">
                        </div>

                        <div class="col-md-6">
                            <label for="bank_idbank" class="form-label">Pilih Bank</label>
                            <select id="bank_idbank" name="bank_idbank" class="select2 form-control" style="width: 100%;">
                                <option disabled selected>Pilih Bank</option>
                                <?php foreach ($bank as $p): ?>
                                    <option value="<?= htmlspecialchars($p->idbank) ?>">
                                        <?= htmlspecialchars($p->nama_bank) ?> : <?= htmlspecialchars($p->norek) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <div class="col-md-6">
                            <label for="edit_sisa" class="form-label">Sisa Hutang</label>
                            <input type="text" class="form-control" id="edit_sisa" name="sisa" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="kembalian" class="form-label">Kembalian</label>
                            <input type="text" class="form-control" id="kembalian" name="kembalian" readonly>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah ? 'Rp ' + rupiah : '';
    }

    function unformatRupiah(rupiah) {
        return parseInt(rupiah.replace(/[^0-9]/g, '')) || 0;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const bayarTunai = document.getElementById('bayar_tunai');
        const bayarBank = document.getElementById('bayar_bank');
        const sisa = document.getElementById('edit_sisa');
        const kembalian = document.getElementById('kembalian');

        let totalHutang = 0; // akan diisi dari data-sisa tombol edit

        $('#bank_idbank').select2({
            dropdownParent: $('#bayar-tagihan-modal')
        });

        // fungsi hitung sisa hutang & kembalian
        function hitung() {
            let tunai = unformatRupiah(bayarTunai.value);
            let bank = unformatRupiah(bayarBank.value);

            let totalBayar = tunai + bank;

            let sisaHutang = totalHutang - totalBayar;
            let kembali = totalBayar - totalHutang;

            if (sisaHutang < 0) sisaHutang = 0;
            if (kembali < 0) kembali = 0;

            sisa.value = formatRupiah(sisaHutang.toString());
            kembalian.value = formatRupiah(kembali.toString());
        }

        // event input untuk format & hitung
        [bayarTunai, bayarBank].forEach(el => {
            el.addEventListener('input', function() {
                let angka = unformatRupiah(el.value);
                el.value = angka > 0 ? formatRupiah(angka.toString()) : '';
                hitung();
            });

            el.addEventListener('blur', function() {
                if (el.value === '') el.value = 'Rp 0';
                hitung();
            });

            el.addEventListener('focus', function() {
                if (unformatRupiah(el.value) === 0) el.value = '';
            });
        });

        // saat tombol edit ditekan
        document.querySelector('#zero_config').addEventListener('click', function(e) {
            if (e.target.closest('.edit-button')) {
                const button = e.target.closest('.edit-button');
                const idpembelian = button.getAttribute('data-idpembelian');
                const no_nota_supplier = button.getAttribute('data-no_nota_supplier');
                const tanggal_masuk = button.getAttribute('data-tanggal_masuk');
                const sisaAwal = button.getAttribute('data-sisa'); // ambil sisa dari tombol

                document.getElementById('edit_idpembelian').value = idpembelian;
                document.getElementById('edit_no_nota_supplier').value = no_nota_supplier;
                document.getElementById('edit_tanggal_masuk').value = tanggal_masuk;

                // set total hutang = sisa awal dari database
                totalHutang = unformatRupiah(sisaAwal);

                // isi form awal
                bayarTunai.value = 'Rp 0';
                bayarBank.value = 'Rp 0';
                sisa.value = formatRupiah(totalHutang.toString());
                kembalian.value = 'Rp 0';
            }
        });
    });
</script>








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

        const unitSelect = document.getElementById('unitSelect');
        if (unitSelect.options.length > 1) {
            unitSelect.selectedIndex = 1;
        }

        filterData();
    };

    function filterData() {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        const selectedUnit = document.getElementById('unitSelect').value.toLowerCase();

        const rows = document.querySelectorAll('#zero_config tbody tr');
        rows.forEach(row => {
            const dateCell = row.children[0];
            const unitCell = row.children[1];
            if (!dateCell || !unitCell) return;

            // Ambil dan parsing tanggal
            const dateText = dateCell.textContent.trim();
            const parts = dateText.split('-');
            const rowDate = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`); // ubah ke Y-m-d

            const startDate = start ? new Date(start) : null;
            const endDate = end ? new Date(end) : null;

            // Ambil dan cocokan nama unit
            const unitName = unitCell.textContent.trim().toLowerCase();
            const unitMatch = selectedUnit === "" || unitName === selectedUnit;

            let dateMatch = true;
            if (startDate && rowDate < startDate) dateMatch = false;
            if (endDate && rowDate > endDate) dateMatch = false;

            // Tampilkan baris jika dua-duanya match
            row.style.display = (unitMatch && dateMatch) ? '' : 'none';
        });
    }

    function resetFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('unitSelect').value = '';
        filterData();
    }
</script>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        const metodeBayar = document.getElementById("metode_bayar");
        const bayarTunaiDiv = document.getElementById("bayar_tunai").closest(".mb-3");
        const transferSection = document.querySelector(".transfer-section");

        function toggleMetode() {
            const val = metodeBayar.value;

            if (val === "tunai") {
                bayarTunaiDiv.style.display = "block";
                transferSection.style.display = "none";
            } else if (val === "transfer") {
                bayarTunaiDiv.style.display = "none";
                transferSection.style.display = "flex";
            } else if (val === "tunai_transfer") {
                bayarTunaiDiv.style.display = "block";
                transferSection.style.display = "flex";
            } else {
                bayarTunaiDiv.style.display = "none";
                transferSection.style.display = "none";
            }
        }


        toggleMetode();


        metodeBayar.addEventListener("change", toggleMetode);
    });
</script>