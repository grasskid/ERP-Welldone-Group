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
                    <label for="nama_suplier" class="form-label">Nama Suplier</label>
                    <select class="form-select" id="suplier" name="suplier" onchange="tampilkanIdSuplier()">
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
                            <td colspan="2"><strong>Total Diskon</strong></td>
                            <td colspan="7">
                                <input type="text" id="total-diskon" name="total-diskon" class="form-control" readonly>
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

                <button class="btn btn-success" type="submit">Simpan</button>
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
                            <input type="number" name="produk[${id}][jumlah]" class="form-control jumlah-input" data-id="${id}" value="1" min="1">
                        </td>
                        <td>
                            <input type="number" name="produk[${id}][diskon]" class="form-control diskon-input" data-id="${id}" value="0" min="0" max="100">
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

                                row.querySelector('.jumlah-input').addEventListener('input',
                                    updateTotals);
                                row.querySelector('.diskon-input').addEventListener('input',
                                    updateTotals);
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
                        const hargaInput = row.querySelector('input[name$="[harga]"]');
                        const jumlahInput = row.querySelector('.jumlah-input');
                        const diskonInput = row.querySelector('.diskon-input');
                        const ppnCheckbox = row.querySelector('.ppn-checkbox');

                        if (hargaInput && jumlahInput && diskonInput) {
                            const harga = parseInt(hargaInput.value) || 0;
                            const jumlah = parseInt(jumlahInput.value) || 0;
                            const diskon = parseFloat(diskonInput.value) || 0; // bentuk nominal langsung
                            const isPpn = ppnCheckbox?.checked;

                            let subtotal = harga * jumlah;
                            let setelahDiskon = subtotal - diskon;
                            let ppnAmount = isPpn ? setelahDiskon * 0.11 : 0;

                            totalDiskon += diskon;
                            totalPPN += ppnAmount;
                            total += setelahDiskon + ppnAmount;
                        }
                    });

                    document.getElementById('total-diskon').value = 'Rp ' + totalDiskon.toLocaleString('id-ID');
                    document.getElementById('total-ppn').value = 'Rp ' + totalPPN.toLocaleString('id-ID');
                    document.getElementById('total-harga').value = 'Rp ' + total.toLocaleString('id-ID');

                    updateHutang();
                }


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