<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>

<!-- Page Header -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Pembelian</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Transaksi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pembelian</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Form & Main Content -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>

    <div class="card-body px-4 pt-4 pb-2">
        <form action="<?= base_url('insert_pembelian') ?>" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <!-- <div class="col-md-6">
                    <label for="no_nota" class="form-label">No Nota Supplier</label>
                    <input type="text" class="form-control" id="no_nota" name="no_nota" placeholder="xxxxxxxxx"
                        required>
                </div> -->

                <div class="col-md-6">
                    <label for="nama_sumber" class="form-label">Sumber</label>
                    <select id="tipe_pihak" class="form-select">
                        <option value="">Pilih Tipe</option>
                        <option value="suplier">Suplier</option>
                        <option value="pelanggan">Pelanggan</option>
                    </select>


                </div>

                <div class="col-md-6">
                    <label for="nama_suplier" class="form-label">Nama Suplier</label>
                    <select disabled class="form-select" id="suplier" name="suplier" required
                        onchange="tampilkanIdSuplier()">
                        <option value="" disabled selected>Pilih Unit</option>
                        <?php foreach ($suplier as $b): ?>
                        <option value="<?= $b->id_suplier; ?>"><?= $b->nama_suplier; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input name="id_suplier_text" type="hidden" id="id_suplier_text"
                        class="text-muted d-block mt-2"></input>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Upload Gambar Nota : Max 10Mb</label>
                    <div class="border border-2 border-dashed rounded p-3 text-center position-relative">
                        <i class="bi bi-cloud-arrow-up fs-1 text-secondary"></i>
                        <p class="mb-0 text-muted">Drag and drop a file here or click</p>
                        <input type="file" name="nota_file" id="notaFileInput"
                            class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0" accept="image/*"
                            required>
                    </div>

                    <!-- Preview Image -->
                    <div class="mt-2 text-center">
                        <img id="previewNota" src="#" alt="Preview Gambar Nota"
                            style="max-width: 100%; max-height: 250px; display: none;" />
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                        value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                    <input type="date" class="form-control" id="jatuh_tempo" name="jatuh_tempo"
                        value="<?= date('Y-m-d') ?>" required>
                </div>
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

            <!-- Modal Pilih Produk -->
            <div class="modal fade" id="pilih-produk-modal" tabindex="-1" aria-labelledby="produkModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
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
                                                <h6 class="fs-4 fw-semibold mb-0">Harga</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0">Kategori</h6>
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
                                                    data-harga_beli="<?= $p->harga_beli ?>"
                                                    data-kategori="<?= $p->nama_kategori ?>"
                                                    data-input="<?= $p->input ?>">
                                            </td>
                                            <td><?= $p->kode_barang ?></td>
                                            <td><?= $p->nama_barang ?></td>
                                            <td><?= 'Rp ' . number_format($p->harga, 0, ',', '.') ?></td>
                                            <td><?= $p->nama_kategori ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
                            <th>Harga Beli</th>
                            <th>Jumlah</th>
                            <th>Diskon (Rp)</th>
                            <th>
                                <input type="checkbox" id="select-all-ppn"> PPN 11%
                            </th>
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
                                <input type="number" id="total-diskon" name="total-diskon" class="form-control">

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

                <!-- Bayar and Hutang Form -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bayar" class="form-label">Bayar</label>
                        <input type="text" class="form-control" id="bayar" name="bayar" value="Rp 0">
                    </div>
                    <div class="col-md-6">
                        <label for="hutang" class="form-label">Hutang</label>
                        <input type="text" class="form-control" id="hutang" name="hutang" readonly>
                    </div>
                </div>

                <button style="height: fit-content;" class="btn btn-success mt-3" type="submit">Simpan</button>

                <!-- Pelanggan Button -->
                <div id="pelanggan-section" class="mt-3" style="display: none;">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#pelangganModal"
                        style="display: inline-flex; align-items: center; margin-bottom: 4px;">
                        <iconify-icon icon="mdi:account" width="20" height="20" style="margin-right: 8px;">
                        </iconify-icon>
                        Input Data Pelanggan
                    </button>
                </div>

                <div class="modal fade" id="pelanggan-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="pelanggan-form">
                                <div class="modal-header">
                                    <h5 class="modal-title">Input Data Pelanggan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Input cari -->
                                    <div class="mb-3">
                                        <label for="search-nohp" class="form-label">Nomor HP</label>
                                        <input type="text" name="nomor" class="form-control" id="search-nohp">
                                    </div>
                                    <button type="button" id="cari-pelanggan-btn" class="btn btn-info">Cari</button>

                                    <!-- Hidden input to store id_pelanggan -->
                                    <input type="hidden" id="id_pelanggan" name="id_pelanggan">

                                    <!-- Extra form fields -->
                                    <div id="pelanggan-form-extra" style="display:none; margin-top: 1rem;">
                                        <div class="mb-2">
                                            <label for="nama">Nama</label>
                                            <input type="text" name="nama" id="nama" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label for="alamat">Alamat</label>
                                            <textarea id="alamat" name="alamat" class="form-control"></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label for="nik">NIK</label>
                                            <input type="text" name="nik" id="nik" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Simpan Pelanggan</button>
                                    </div>
                                </div>
                            </form>
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
                        const harga_beli = cb.getAttribute('data-harga_beli');
                        const kategori = cb.getAttribute('data-kategori');
                        const input = cb.getAttribute('data-input');

                        if (!document.getElementById('produk-row-' + id)) {
                            const row = document.createElement('tr');
                            row.id = 'produk-row-' + id;
                            row.innerHTML = `
                        <td>
                            ${kode}
                            <input type="hidden" name="produk[${id}][id]" value="${id}">
                            <input type="hidden" name="produk[${id}][kode]" value="${kode}">
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
                            Rp ${parseInt(harga).toLocaleString('id-ID')}
                            <input type="hidden" name="produk[${id}][harga]" value="${harga}">
                        </td>
                        <td>
                            <input class="form-control harga-beli-input" data-id="${id}" value="Rp ${parseInt(harga_beli).toLocaleString('id-ID')}">
                            <input type="hidden" name="produk[${id}][harga_beli]" id="harga-beli-hidden-${id}" value="${parseInt(harga_beli)}">
                        </td>
                        <td>
                            <input type="number" name="produk[${id}][jumlah]" class="form-control jumlah-input" data-id="${id}" value="1" min="1">
                        </td>
                        <td>
                            <input type="number" name="produk[${id}][diskon]" class="form-control diskon-input" data-id="${id}" value="0" min="0">
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

                            // Event Listeners
                            row.querySelector('.jumlah-input').addEventListener('input',
                                updateTotals);
                            row.querySelector('.diskon-input').addEventListener('input',
                                updateTotals);
                            row.querySelector('.ppn-checkbox').addEventListener('change',
                                updateTotals);

                            const hargaBeliInput = row.querySelector('.harga-beli-input');
                            hargaBeliInput.addEventListener('input', function() {
                                const id = this.getAttribute('data-id');
                                const numeric = this.value.replace(/[^\d]/g, '');
                                this.value = formatToRupiah(numeric);
                                document.getElementById(`harga-beli-hidden-${id}`)
                                    .value = numeric;
                                updateTotals();
                            });
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

                bayarInput.addEventListener('input', function() {
                    const numeric = this.value.replace(/[^\d]/g, '');
                    this.value = formatToRupiah(numeric);
                    updateHutang();
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
                    const hargaBeliHiddenInput = row.querySelector('input[id^="harga-beli-hidden-"]');
                    const jumlahInput = row.querySelector('.jumlah-input');
                    const diskonInput = row.querySelector('.diskon-input');
                    const ppnCheckbox = row.querySelector('.ppn-checkbox');

                    if (hargaBeliHiddenInput && jumlahInput && diskonInput) {
                        const hargaBeli = parseInt(hargaBeliHiddenInput.value) || 0;
                        const jumlah = parseInt(jumlahInput.value) || 0;
                        const diskon = parseFloat(diskonInput.value) || 0;
                        const isPpn = ppnCheckbox?.checked;

                        let subtotal = hargaBeli * jumlah;
                        let setelahDiskon = subtotal - diskon;
                        let ppnAmount = isPpn ? setelahDiskon * 0.11 : 0;

                        totalDiskon += diskon;
                        totalPPN += ppnAmount;
                        total += setelahDiskon + ppnAmount;
                    }
                });

                const totalDiskonInput = document.getElementById('total-diskon');
                totalDiskonInput.min = totalDiskon;

                let manualDiskon = parseFloat(totalDiskonInput.value);
                if (isNaN(manualDiskon) || manualDiskon < totalDiskon) {
                    manualDiskon = totalDiskon;
                    totalDiskonInput.value = totalDiskon;
                }

                const totalHargaFinal = total - (manualDiskon - totalDiskon);
                document.getElementById('total-ppn').value = 'Rp ' + totalPPN.toLocaleString('id-ID');
                document.getElementById('total-harga').value = 'Rp ' + totalHargaFinal.toLocaleString('id-ID');

                updateHutang();
            }

            document.getElementById('total-diskon').addEventListener('input', () => {
                updateTotals(true);
            });

            function updateHutang() {
                const totalStr = document.getElementById('total-harga').value.replace(/[^\d]/g, '') || "0";
                const bayarStr = document.getElementById('bayar').value || "Rp 0";
                const bayar = unformatRupiah(bayarStr);
                const total = parseInt(totalStr);
                const hutang = Math.max(total - bayar, 0);

                document.getElementById('hutang').value = 'Rp ' + hutang.toLocaleString('id-ID');
            }
            </script>



            <script>
            $(document).ready(function() {
                var table = $('#produk-modal-table').DataTable();


            });
            </script>
            <script>
            function tampilkanIdSuplier() {
                const select = document.getElementById('suplier');
                const idSuplierInput = document.getElementById('id_suplier_text');
                const selectedValue = select.value;
                idSuplierInput.value = selectedValue;
            }
            </script>

            <script>
            document.getElementById('notaFileInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('previewNota');

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };

                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
            </script>


            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const pelangganModal = new bootstrap.Modal(document.getElementById('pelanggan-modal'));
                const pelangganFormExtra = document.getElementById('pelanggan-form-extra');
                const pelangganForm = document.getElementById('pelanggan-form');
                const cariBtn = document.getElementById('cari-pelanggan-btn');
                const noHpInput = document.getElementById('search-nohp');
                const tipe_pihak = document.getElementById('tipe_pihak');
                const tipe_sumber = tipe_pihak.value;

                // Auto-show "Input Data Pelanggan" button if category = handphone
                function checkForHandphone() {
                    const rows = document.querySelectorAll('#selected-produk-table tr');
                    let show = false;

                    rows.forEach(row => {
                        const kategoriInput = row.querySelector('input[name$="[kategori]"]');
                        if (kategoriInput && kategoriInput.value.toLowerCase() === 'handphone' &&
                            tipe_pihak.value === 'pelanggan') {
                            show = true;
                        }
                    });

                    document.getElementById('pelanggan-button')?.remove();

                    if (show) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.id = 'pelanggan-button';
                        btn.className = 'btn btn-warning mt-2';
                        btn.style = 'display: inline-flex; align-items: center; margin-bottom: 4px;';
                        btn.innerHTML = `
                <iconify-icon icon="mdi:account" width="20" height="20" style="margin-right: 8px;"></iconify-icon>
                Input Data Pelanggan
            `;
                        btn.onclick = () => pelangganModal.show();
                        document.querySelector('.table-responsive.mt-3.mb-4').appendChild(btn);
                    }
                }

                // Check after confirming products
                document.getElementById('confirm-produk-btn').addEventListener('click', () => {
                    setTimeout(checkForHandphone, 500); // delay to wait for DOM changes
                });

                tipe_pihak.addEventListener('change', () => {
                    checkForHandphone();

                    const suplierSelect = document.getElementById('suplier');

                    if (tipe_pihak.value === 'pelanggan') {
                        suplierSelect.disabled = true;
                        suplierSelect.value = ''; // reset nilai jika sebelumnya memilih suplier
                        document.getElementById('id_suplier_text').value =
                            ''; // reset juga input hidden
                    } else if (tipe_pihak.value === 'suplier') {
                        suplierSelect.disabled = false;
                    }
                });


                // 🔍 Search pelanggan by phone number
                cariBtn.addEventListener('click', function() {
                    const no_hp = noHpInput.value.trim();
                    if (!no_hp) return alert('Isi nomor HP terlebih dahulu.');

                    fetch(`<?= base_url('penjualan/search_by_hp') ?>?no_hp=${encodeURIComponent(no_hp)}`, {
                            method: 'GET'
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.found) {
                                document.getElementById('id_pelanggan').value = data.pelanggan
                                    .id_pelanggan;
                                pelangganModal.hide();
                                alert('Pelanggan ditemukan dan dipilih.');
                            } else {
                                pelangganFormExtra.style.display = 'block';
                                alert('Nomor tidak ditemukan, silakan lengkapi data pelanggan.');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan saat mencari pelanggan.');
                        });
                });

                // 💾 Submit pelanggan form
                pelangganForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const payload = {
                        no_hp: document.getElementById('search-nohp').value.trim(),
                        nama: document.getElementById('nama').value.trim(),
                        alamat: document.getElementById('alamat').value.trim(),
                        nik: document.getElementById('nik').value.trim()
                    };

                    fetch(`<?= base_url('pelanggan/insert') ?>`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('id_pelanggan').value = data.id_pelanggan ||
                                    '';
                                pelangganModal.hide();
                                alert('Pelanggan berhasil disimpan.');
                            } else {
                                alert('Gagal menyimpan pelanggan.');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Terjadi kesalahan saat menyimpan pelanggan.');
                        });
                });
            });
            </script>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllPPN = document.getElementById('select-all-ppn');

                selectAllPPN.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.ppn-checkbox');
                    checkboxes.forEach(cb => cb.checked = selectAllPPN.checked);
                    updateTotals();
                });
            });
            </script>