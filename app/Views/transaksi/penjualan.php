<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>

<!-- Page Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Penjualan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Transaksi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Form & Main Content -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2">
        <form action="<?= base_url('insert_penjualan') ?>" method="post" id="form_penjualan" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="tanggal_masuk" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                        value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="sales_by" class="form-label">Pilih Akun</label>
                    <select class="form-control" id="sales_by" name="sales_by" required>
                        <option value="">-- Pilih Frontliner --</option>
                        <?php foreach ($frontliner as $akun): ?>
                            <option value="<?= esc($akun->ID_AKUN) ?>"><?= esc($akun->NAMA_AKUN) ?></option>
                        <?php endforeach; ?>
                    </select>
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

                <!-- Button Trigger Modal -->
                <div class="mt-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#pilih-produk-modal" style="display: inline-flex; align-items: center;">
                        <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                            style="margin-right: 8px;"></iconify-icon>
                        Pilih Produk
                    </button>


                </div>


                <!-- produk bundle modal -->

                <div class="modal fade" id="pilih-produk-modal" tabindex="-1" aria-labelledby="produkModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pilih Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Nav Tabs -->
                                <ul class="nav nav-tabs mb-3" id="produkTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="produk-tab" data-bs-toggle="tab" data-bs-target="#produk-content" type="button" role="tab" aria-controls="produk-content" aria-selected="true">Produk</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="bundle-tab" data-bs-toggle="tab" data-bs-target="#bundle-content" type="button" role="tab" aria-controls="bundle-content" aria-selected="false">Bundle</button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="produkTabContent">
                                    <!-- Produk -->
                                    <div class="tab-pane fade show active" id="produk-content" role="tabpanel" aria-labelledby="produk-tab">
                                        <div class="table-responsive mb-4 px-4">
                                            <table class="table border text-nowrap mb-0 align-middle" id="produk-modal-table">
                                                <thead class="text-dark fs-4">
                                                    <tr>
                                                        <th><input type="checkbox" id="select-all-produk"></th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Kode Barang</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Nama Barang</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Kondisi Barang</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Harga</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Kategori</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Stok</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Imei</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Internal</h6>
                                                        </th>
                                                        <th>
                                                            <h6 class="fs-4 fw-semibold mb-0">Warna</h6>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($produk as $p): ?>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="produk-checkbox"
                                                                    data-id="<?= $p->idbarang ?>" data-kode="<?= $p->kode_barang ?>"
                                                                    data-nama="<?= $p->nama_barang ?>" data-harga="<?= $p->harga ?>"
                                                                    data-kategori="<?= $p->nama_kategori ?>"
                                                                    data-input="<?= $p->input ?>"
                                                                    data-kondisi_barang="<?= $p->status_barang ?>"
                                                                    <?= (is_null($p->stok_akhir) || $p->stok_akhir <= 0) ? 'disabled' : '' ?>>
                                                            </td>
                                                            <td><?= $p->kode_barang ?></td>
                                                            <td><?= $p->nama_barang ?></td>
                                                            <td><?= $p->status_barang == 1 ? 'Baru' : 'Second' ?></td>
                                                            <td><?= 'Rp ' . number_format($p->harga, 0, ',', '.') ?></td>
                                                            <td><?= $p->nama_kategori ?></td>
                                                            <td>
                                                                <?= is_null($p->stok_akhir) ? '<span class="text-red-500">belum mengatur stok awal</span>' : $p->stok_akhir ?>
                                                            </td>
                                                            <td><?= $p->imei ? $p->imei : 'Tidak Ada' ?></td>
                                                            <td><?= $p->internal ? $p->internal : 'Tidak Ada' ?></td>
                                                            <td><?= $p->warna ? $p->warna : 'Tidak Ada' ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Bundle -->
                                    <div class="tab-pane fade" id="bundle-content" role="tabpanel" aria-labelledby="bundle-tab">
                                        <div class="table-responsive mb-4 px-4">
                                            <table class="table border text-nowrap mb-0 align-middle" id="bundle-modal-table">
                                                <thead class="text-dark fs-4">
                                                    <tr>
                                                        <th><input type="checkbox" id="select-all-bundle"></th>
                                                        <th>Nama Bundle</th>
                                                        <th>Status Ketesediaan</th>
                                                        <th>Harga</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($bundle as $p): ?>
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" class="produk-checkbox"
                                                                    data-id="bundle<?= $p->idbundle ?>" data-kode="Bundle"
                                                                    data-nama="<?= $p->nama_bundle ?>" data-harga="<?= $p->harga_jual ?>"
                                                                    data-kategori="Bundle"
                                                                    data-input="Bundle"
                                                                    <?= ($p->status_stok != 'Tersedia') ? 'disabled' : '' ?>>
                                                            </td>
                                                            <td><?= $p->nama_bundle ?></td>
                                                            <td>
                                                                <?php if ($p->status_stok == 'Tersedia'): ?>
                                                                    <button style="background-color: chartreuse; border-radius: 5px; color: black;">
                                                                        <?= $p->status_stok ?>
                                                                    </button>
                                                                <?php else: ?>
                                                                    <button style="background-color: red; border-radius: 5px; color: white;">
                                                                        <?= $p->status_stok ?>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td><?= 'Rp ' . number_format($p->harga_jual, 0, ',', '.') ?></td>
                                                            <td>
                                                                <button class="btn btn-warning btn-check-bundle"
                                                                    data-id="<?= $p->idbundle ?>"
                                                                    data-nama="<?= $p->nama_bundle ?>"
                                                                    data-detail='<?= json_encode($p->detail) ?>'>
                                                                    Check Bundle
                                                                </button>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" id="confirm-produk-btn" class="btn btn-primary">Pilih</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Selected Produk Table -->
                <div class="table-responsive mt-3 mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Diskon (Rp)</th>
                                <th>PPN 11%</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="selected-produk-table">
                            <!-- Rows will be dynamically added -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><strong>Total Diskon (Rp.)</strong></td>
                                <td colspan="7">
                                    <input type="text" id="total-diskon" readonly value="Rp 0" name="total-diskon"
                                        class="form-control">
                                    <small id="total-diskon-alert" class="text-danger d-none">
                                        Total diskon tidak boleh lebih kecil dari jumlah diskon per barang.
                                    </small>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>Total PPN</strong></td>
                                <td colspan="7">
                                    <input type="text" id="total-ppn" name="total-ppn" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Total Keseluruhan</strong></td>
                                <td colspan="7">
                                    <input type="text" id="total-harga" name="total-harga" class="form-control" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row mb-3 tunai-section">
                        <div class="col-md-6">
                            <label for="bayar" class="form-label">Bayar Tunai</label>
                            <input type="text" class="form-control" id="bayar" name="bayar" value="Rp 0">
                        </div>

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



                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kembalian" class="form-label">Kembalian</label>
                            <input type="text" class="form-control" id="kembalian" name="kembalian" value="Rp 0">
                        </div>

                        <div class="col-md-6" id="pelanggan-container" style="display: none;">
                            <label for="pelanggan" class="form-label">Pelanggan</label>
                            <input type="text" class="form-control" id="pelanggan" name="pelanggan" readonly>
                        </div>

                        <div class="col-md-6">
                            <label hidden for="hutang" class="form-label">Hutang</label>
                            <input hidden type="text" class="form-control" id="hutang" name="hutang" readonly>
                        </div>

                    </div>

                    <!-- Pelanggan Button -->
                    <div class="table-responsive mt-3 mb-4">
                        <!-- tabel produk -->
                    </div>



                    <div class="modal fade" id="pelangganModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cari Data Pelanggan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <select id="pelanggan-select" name="selectedidpelanggan" class="select2 form-control"
                                        style="width: 100%;">
                                        <option disabled selected>Select</option>
                                        <?php foreach ($pelanggan as $p): ?>
                                            <option value="<?= htmlspecialchars($p->id_pelanggan) ?>">
                                                <?= htmlspecialchars($p->nama) ?> : <?= htmlspecialchars($p->no_hp) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <!-- Tombol di bawah dropdown -->
                                    <div style="display: flex; justify-content: right; gap: 10px; margin-top: 20px;">
                                        <button id="btnPilihPelanggan" type="button" class="btn btn-primary">Pilih</button>
                                        <button id="btnTambahPelanggan" type="button"
                                            class="btn btn-success">Tambah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>







                    <!-- Pindahkan tombol ke sini agar tidak acak -->
                    <div id="pelanggan-section" class="mt-3">
                        <button class="btn btn-success" type="submit">Simpan</button>
                        <button type="button" id="pelanggan-button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#pelangganModal"
                            style="display: inline-flex; align-items: center; margin-bottom: 4px;">
                            <iconify-icon icon="mdi:account" width="20" height="20" style="margin-right: 8px;">
                            </iconify-icon>
                            Input Data Pelanggan
                        </button>
                    </div>

                </div>



                <!-- Modal Detail Bundle -->
                <div class="modal fade" id="detailBundleModal" tabindex="-1" aria-labelledby="detailBundleLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" style="background-color: antiquewhite;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailBundleLabel">Detail Bundle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Stok Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bundle-detail-body">

                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    function formatToRupiah(angka) {
                        const cleaned = angka.replace(/[^\d]/g, '');
                        const number = parseInt(cleaned) || 0;
                        return 'Rp ' + number.toLocaleString('id-ID');
                    }

                    function unformatRupiah(rupiah) {
                        return parseInt(rupiah.replace(/[^\d]/g, '')) || 0;
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        const selectedTable = document.getElementById('selected-produk-table');
                        const confirmBtn = document.getElementById('confirm-produk-btn');
                        const selectAll = document.getElementById('select-all-produk');
                        const modalEl = document.getElementById('pilih-produk-modal');
                        const modalInstance = new bootstrap.Modal(modalEl);
                        const bayarInput = document.getElementById('bayar');
                        const totalDiskonInput = document.getElementById('total-diskon');
                        const bayarBank = document.getElementById('bayar_bank');

                        selectAll.addEventListener('change', function() {
                            document.querySelectorAll('.produk-checkbox').forEach(cb => cb.checked = this
                                .checked);
                        });

                        confirmBtn.addEventListener('click', function() {
                            document.querySelectorAll('.produk-checkbox:checked').forEach(cb => {
                                const id = cb.getAttribute('data-id');
                                const kode = cb.getAttribute('data-kode');
                                const nama = cb.getAttribute('data-nama');
                                const harga = cb.getAttribute('data-harga');
                                const kategori = cb.getAttribute('data-kategori');
                                const kondisi_barang = cb.getAttribute('data-kondisi_barang');

                                if (!document.getElementById('produk-row-' + id)) {
                                    const row = document.createElement('tr');
                                    row.id = 'produk-row-' + id;
                                    row.innerHTML = `
                    <td>
                        ${kode}
                        <input type="hidden" name="produk[${id}][id]" value="${id}">
                        <input type="hidden" name="produk[${id}][kode]" value="${kode}">
                        <input type="hidden" name="produk[${id}][kondisi_barang]" value="${kondisi_barang}">
                    </td>
                    <td>
                        ${nama}
                        <input type="hidden" name="produk[${id}][nama]" value="${nama}">
                    </td>
                    <td>
                        ${kategori}
                        <input type="hidden" name="produk[${id}][kategori]" value="${kategori}">
                    </td>
                    <td>
                        <input type="text" name="produk[${id}][harga]" class="form-control harga-input" data-id="${id}" value="${formatToRupiah(harga)}">
                    </td>
                    <td>
                        <input type="number" name="produk[${id}][jumlah]" class="form-control jumlah-input" data-id="${id}" value="1" min="1">
                    </td>
                    <td>
                        <input type="text" name="produk[${id}][diskon]" class="form-control diskon-input" data-id="${id}" value="0" min="0">
                    </td>
                    <td class="text-center">
                        <input type="checkbox" name="produk[${id}][ppn]" class="form-check-input ppn-checkbox" data-id="${id}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusProduk('${id}')">
                            <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="20" height="20"></iconify-icon>
                        </button>
                    </td>
                `;
                                    selectedTable.appendChild(row);

                                    // Add event listeners
                                    row.querySelector('.harga-input').addEventListener('input',
                                        function() {
                                            this.value = formatToRupiah(this.value);
                                            updateTotals();
                                        });
                                    row.querySelector('.jumlah-input').addEventListener('input',
                                        updateTotals);
                                    row.querySelector('.diskon-input').addEventListener('input',
                                        function() {
                                            this.value = formatToRupiah(this.value);
                                            updateTotals();
                                        });
                                    row.querySelector('.ppn-checkbox').addEventListener('change',
                                        updateTotals);
                                }
                            });

                            modalInstance.hide();
                            setTimeout(() => {
                                document.body.classList.remove('modal-open');
                                document.body.style.removeProperty('padding-right');
                                document.body.style.removeProperty('overflow');
                                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                            }, 500);

                            document.querySelectorAll('.produk-checkbox').forEach(cb => cb.checked = false);
                            selectAll.checked = false;

                            updateTotals();
                        });

                        totalDiskonInput.addEventListener('input', function() {
                            const numeric = this.value.replace(/[^\d]/g, '');
                            this.value = formatToRupiah(numeric);
                            updateTotals();
                        });

                        bayarInput.addEventListener('input', function() {
                            const numeric = this.value.replace(/[^\d]/g, '');
                            this.value = formatToRupiah(numeric);
                            updateHutang();
                        });

                        bayarBank.addEventListener('input', function() {
                            const numeric = this.value.replace(/[^\d]/g, '');
                            this.value = formatToRupiah(numeric);
                            updateHutang();
                        });

                        updateTotals();


                        const form_penjualan = document.getElementById('form_penjualan');

                        form_penjualan.addEventListener('submit', function(e) {
                            const total = unformatRupiah(document.getElementById('total-harga').value || 'Rp 0');
                            const bayar = unformatRupiah(document.getElementById('bayar').value || 'Rp 0');
                            const bayar_bankin = unformatRupiah(document.getElementById('bayar_bank').value || 'Rp 0');

                            if ((bayar + bayar_bankin) < total) {
                                alert('Pembayaran kurang! Silakan periksa kembali.');
                                e.preventDefault();
                            }
                        });

                    });

                    function hapusProduk(id) {
                        const row = document.getElementById('produk-row-' + id);
                        if (row) row.remove();
                        updateTotals();
                    }

                    function updateTotals() {
                        let total = 0;
                        let totalDiskon = 0;
                        let totalPPN = 0;

                        document.querySelectorAll('#selected-produk-table tr').forEach(row => {
                            const hargaInput = row.querySelector('.harga-input');
                            const jumlahInput = row.querySelector('.jumlah-input');
                            const diskonInput = row.querySelector('.diskon-input');
                            const ppnCheckbox = row.querySelector('.ppn-checkbox');

                            if (hargaInput && jumlahInput && diskonInput) {
                                const harga = unformatRupiah(hargaInput.value) || 0;
                                const jumlah = parseInt(jumlahInput.value) || 0;
                                const diskon = unformatRupiah(diskonInput.value) || 0;
                                const isPpn = ppnCheckbox?.checked;

                                let subtotal = harga * jumlah;
                                let setelahDiskon = subtotal - diskon;
                                let ppnAmount = isPpn ? setelahDiskon * 0.11 : 0;

                                totalDiskon += diskon;
                                totalPPN += ppnAmount;
                                total += setelahDiskon + ppnAmount;
                            }
                        });

                        const totalDiskonInput = document.getElementById('total-diskon');
                        totalDiskonInput.min = totalDiskon;

                        let manualDiskon = unformatRupiah(totalDiskonInput.value) || 0;

                        if (isNaN(manualDiskon) || manualDiskon < totalDiskon) {
                            manualDiskon = totalDiskon;
                            totalDiskonInput.value = 'Rp ' + totalDiskon.toLocaleString('id-ID');
                        }

                        const totalHargaFinal = total - (manualDiskon - totalDiskon);
                        document.getElementById('total-ppn').value = 'Rp ' + totalPPN.toLocaleString('id-ID');
                        document.getElementById('total-harga').value = 'Rp ' + totalHargaFinal.toLocaleString('id-ID');

                        updateHutang();
                    }

                    function updateHutang() {
                        const totalInput = document.getElementById('total-harga');
                        const bayarEl = document.getElementById('bayar');
                        const hutangInput = document.getElementById('hutang');
                        const kembalianInput = document.getElementById('kembalian');
                        const bayarbankEl = document.getElementById('bayar_bank');

                        if (!totalInput || !bayarEl || !hutangInput || !kembalianInput || !bayarbankEl) return;

                        const total = unformatRupiah(totalInput.value || 'Rp 0');
                        const bayar = unformatRupiah(bayarEl.value || 'Rp 0');
                        const bankbayar = unformatRupiah(bayarbankEl.value || 'Rp 0');

                        const selisih = (bayar + bankbayar) - total;

                        const hutang = Math.max(total - (bayar + bankbayar), 0);
                        const kembalian = selisih > 0 ? selisih : 0;

                        hutangInput.value = 'Rp ' + hutang.toLocaleString('id-ID');
                        kembalianInput.value = 'Rp ' + kembalian.toLocaleString('id-ID');
                    }
                </script>
        </form>

        <div class="modal fade" id="modalTambahPelanggan" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formTambahPelanggan">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Pelanggan Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" id="no_hp" name="no_hp" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pelangganModal = new bootstrap.Modal(document.getElementById('pelangganModal'));

                $('.select2').select2({
                    dropdownParent: $('#pelangganModal')
                });

                const confirmBtn = document.getElementById('confirm-produk-btn');

                const modalTambah = new bootstrap.Modal(document.getElementById('modalTambahPelanggan'));

                // Tombol "Tambah" di bawah dropdown
                document.getElementById('btnTambahPelanggan').addEventListener('click', function() {
                    modalTambah.show();
                });

                // Tombol "Pilih" untuk menutup modal
                document.getElementById('btnPilihPelanggan').addEventListener('click', function() {
                    const select = document.getElementById('pelanggan-select');
                    const selectedOption = select.options[select.selectedIndex];

                    if (!selectedOption || selectedOption.disabled) {
                        alert('Silakan pilih pelanggan terlebih dahulu.');
                        return;
                    }

                    document.getElementById('pelanggan-container').style.display = 'block';
                    document.getElementById('pelanggan').value = selectedOption.text;

                    document.querySelector('#pelangganModal .btn-close').click();
                });

                // Submit form tambah pelanggan via AJAX
                $('#formTambahPelanggan').on('submit', function(e) {
                    e.preventDefault();

                    const formData = $(this).serialize();

                    $.ajax({
                        url: '<?php echo base_url('simpan/pelanggan') ?>',
                        method: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                modalTambah.hide();
                                $('#formTambahPelanggan')[0].reset();

                                const newOption = new Option(
                                    response.data.nama + ' : ' + response.data.no_hp,
                                    response.data.id_pelanggan,
                                    true,
                                    true
                                );
                                $('#pelanggan-select').append(newOption).trigger('change');
                                alert('Pelanggan berhasil ditambahkan');
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menyimpan data.');
                        }
                    });
                });
            });
        </script>



        <script>
            $(document).ready(function() {
                var table = $('#produk-modal-table').DataTable();
            });

            $(document).ready(function() {
                var table = $('#bundle-modal-table').DataTable();
            });
        </script>


        <script>
            $(document).ready(function() {
                // sembunyikan semua section dulu
                $('.tunai-section, .transfer-section').hide();

                $('#metode_bayar').on('change', function() {
                    var metode = $(this).val();

                    if (metode === 'tunai') {
                        $('.tunai-section').show();
                        $('.transfer-section').hide();
                    } else if (metode === 'transfer') {
                        $('.tunai-section').hide();
                        $('.transfer-section').show();
                    } else if (metode === 'tunai_transfer') {
                        $('.tunai-section').show();
                        $('.transfer-section').show();
                    } else {
                        $('.tunai-section, .transfer-section').hide();
                    }
                });


                $('#bank_idbank').select2({
                    dropdownParent: $('body')
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".btn-check-bundle").forEach(btn => {
                    btn.addEventListener("click", function() {
                        let namaBundle = this.getAttribute("data-nama");
                        let detail = JSON.parse(this.getAttribute("data-detail"));

                        // Ubah judul modal
                        document.getElementById("detailBundleLabel").innerText = "Detail Bundle: " + namaBundle;

                        // Isi tabel detail
                        let tbody = document.getElementById("bundle-detail-body");
                        tbody.innerHTML = ""; // reset
                        detail.forEach(item => {
                            let row = `<tr>
                    <td>${item.nama_barang}</td>
                    <td>${item.jumlah}</td>
                    <td>${item.stok_akhir ?? '-'}</td>
                </tr>`;
                            tbody.innerHTML += row;
                        });

                        // Tampilkan modal
                        let modal = new bootstrap.Modal(document.getElementById("detailBundleModal"));
                        modal.show();
                    });
                });
            });
        </script>