<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Datamaster Bundle</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Datamaster</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Bundle</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
    </div>

    <div class="card-body px-4 pt-4 pb-2 d-flex justify-content-between align-items-start mb-1">

        <div style="display: flex; justify-content: left; gap: 20px;">
            <a href="<?php echo base_url('bundle') ?>">
                <button type="button" class="btn btn-danger"
                    style="display: inline-flex; align-items: center;">
                    <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                        style="margin-right: 8px;"></iconify-icon>Kembali
                </button>
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#pilih-produk-modal"
                style="display: inline-flex; align-items: center;">
                <iconify-icon icon="solar:password-minimalistic-input-broken" width="24" height="24"
                    style="margin-right: 8px;"></iconify-icon>Pilih Produk
            </button>
        </div>

    </div>

    <form action="<?= base_url('update_bundle') ?>" method="post" id="form-edit-bundle">
        <div class="mb-3" style="width: 400px; padding-left: 20px;">
            <label for="nama_bundle" class="form-label">Nama Bundle</label>
            <input type="text" class="form-control" name="nama_bundle" id="nama_bundle"
                value="<?= esc($bundle->nama_bundle) ?>" required>
        </div>

        <input type="number" hidden name="idbundlenya" value="<?php echo @$idbundlenya ?>" readonly>

        <!-- <div class="mb-3">
            <label class="form-label">Daftar Barang</label>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pilih-produk-modal">
                Tambah Barang
            </button>
        </div> -->

        <div class="table-responsive">
            <table class="table table-bordered" id="tabel-terpilih">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Imei</th>
                        <th>Jenis Hp</th>
                        <th>Internal</th>
                        <th>Warna</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail_bundle as $row): ?>
                        <tr data-kode="<?= $row->kode_barang ?>">
                            <td>
                                <input type="hidden" name="barang[kode_barang][]" value="<?= esc($row->kode_barang) ?>">
                                <input type="hidden" name="barang[idbarang][]" value="<?= esc($row->barang_idbarang) ?>">
                                <?= esc($row->kode_barang) ?>
                            </td>
                            <td>
                                <input type="hidden" name="barang[nama_barang][]" value="<?= esc($row->nama_barang) ?>">
                                <?= esc($row->nama_barang) ?>
                            </td>
                            <td>
                                <input type="text" class="form-control harga-input"
                                    name="barang[harga][]"
                                    value="<?= number_format($row->harga, 0, ',', '.') ?>">
                            </td>
                            <td>
                                <input type="number" class="form-control jumlah-input"
                                    name="barang[jumlah][]" value="<?= $row->jumlah ?>" min="1">
                            </td>
                            <td>
                                <input type="hidden" name="barang[imei][]" value="<?= esc($row->imei) ?>">
                                <?= esc($row->imei) ?>
                            </td>

                            <td>
                                <input type="hidden" name="barang[jenis_hp][]" value="<?= esc($row->jenis_hp) ?>">
                                <?= esc($row->jenis_hp) ?>
                            </td>

                            <td>
                                <input type="hidden" name="barang[internal][]" value="<?= esc($row->internal) ?>">
                                <?= esc($row->internal) ?>
                            </td>

                            <td>
                                <input type="hidden" name="barang[warna][]" value="<?= esc($row->warna) ?>">
                                <?= esc($row->warna) ?>
                            </td>

                            <td class="subtotal"><?= "Rp " . number_format($row->harga * $row->jumlah, 0, ',', '.') ?></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm hapus-row">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end fw-bold">
                            Total: <span id="total-harga">Rp <?= number_format($bundle->harga_total, 0, ',', '.') ?></span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <input type="hidden" name="harga_total" id="harga_total" value="<?= $bundle->harga_total ?>">

        <div class="mt-3" style="padding: 20px;">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="<?= base_url('bundle') ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>


</div>








<div class="modal fade" id="pilih-produk-modal" tabindex="-1" aria-labelledby="pilihProduModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="pilihProduModalLabel">Pilih Produk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="table-responsive mb-4 px-4">
                    <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Pilih</h6>
                                </th>
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
                                    <h6 class="fs-4 fw-semibold mb-0">Imei</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Jenis Hp</h6>
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
                            <?php foreach ($barang as $row): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="pilih-barang"
                                            data-kode="<?= esc($row->kode_barang) ?>"
                                            data-nama="<?= esc($row->nama_barang) ?>"
                                            data-harga="<?= esc($row->harga) ?>"
                                            data-imei="<?= esc($row->imei) ?>"
                                            data-jenis="<?= esc($row->jenis_hp) ?>"
                                            data-internal="<?= esc($row->internal) ?>"
                                            data-warna="<?= esc($row->warna) ?>">
                                    </td>
                                    <td><?= esc($row->kode_barang) ?></td>
                                    <td><?= esc($row->nama_barang) ?></td>
                                    <td><?= esc('Rp ' . number_format($row->harga, 0, ',', '.')) ?></td>

                                    <td><?= esc($row->imei) ?></td>
                                    <td><?= esc($row->jenis_hp) ?></td>
                                    <td><?= esc($row->internal) ?></td>
                                    <td><?= esc($row->warna) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger"
                    data-bs-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        let number_string = angka.toString().replace(/[^,\d]/g, ""),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? "Rp " + rupiah : "";
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll("#tabel-terpilih tbody tr").forEach(function(row) {
            let hargaInput = row.querySelector(".harga-input").value.replace(/[^0-9]/g, "");
            let jumlahInput = row.querySelector(".jumlah-input").value;
            let harga = parseInt(hargaInput) || 0;
            let jumlah = parseInt(jumlahInput) || 0;
            let subtotal = harga * jumlah;

            row.querySelector(".subtotal").innerText = formatRupiah(subtotal);
            total += subtotal;
        });

        document.getElementById("total-harga").innerText = formatRupiah(total);
        document.getElementById("harga_total").value = total;
    }

    // event: ubah harga/jumlah
    document.addEventListener("input", function(e) {
        if (e.target.classList.contains("harga-input") || e.target.classList.contains("jumlah-input")) {
            if (e.target.classList.contains("harga-input")) {
                let val = e.target.value.replace(/[^0-9]/g, "");
                e.target.value = formatRupiah(val);
            }
            hitungTotal();
        }
    });

    // event: hapus row
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("hapus-row")) {
            e.target.closest("tr").remove();
            hitungTotal();
        }
    });

    // hitung ulang saat pertama load
    document.addEventListener("DOMContentLoaded", hitungTotal);
</script>

<script>
    // --- Fungsi Format Rupiah ---
    function formatRupiah(angka) {
        let number_string = angka.toString().replace(/[^,\d]/g, ""),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? "Rp " + rupiah : "";
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll("#tabel-terpilih tbody tr").forEach(function(row) {
            let hargaInput = row.querySelector(".harga-input").value.replace(/[^0-9]/g, "");
            let jumlahInput = row.querySelector(".jumlah-input").value;
            let harga = parseInt(hargaInput) || 0;
            let jumlah = parseInt(jumlahInput) || 0;
            let subtotal = harga * jumlah;

            // update subtotal di kolom
            row.querySelector(".subtotal").innerText = formatRupiah(subtotal);

            total += subtotal;
        });

        // tampilkan total di footer tabel
        document.getElementById("total-harga").innerText = formatRupiah(total);

        // simpan ke input hidden
        document.getElementById("harga_total").value = total;
    }


    // Event saat checkbox dipilih
    document.addEventListener("change", function(e) {
        if (e.target.classList.contains("pilih-barang")) {
            let kode = e.target.dataset.kode;

            if (e.target.checked) {
                // Tambah row ke tabel terpilih
                let tbody = document.querySelector("#tabel-terpilih tbody");
                let tr = document.createElement("tr");
                tr.setAttribute("data-kode", kode);
                tr.innerHTML = `
    <td>
        <input type="hidden" name="barang[kode_barang][]" value="${e.target.dataset.kode}">
        ${e.target.dataset.kode}
    </td>
    <td>
        <input type="hidden" name="barang[nama_barang][]" value="${e.target.dataset.nama}">
        ${e.target.dataset.nama}
    </td>
    <td>
        <input type="text" class="form-control harga-input" 
               name="barang[harga][]" 
               value="${formatRupiah(e.target.dataset.harga)}">
    </td>
    <td>
        <input type="number" class="form-control jumlah-input" 
               name="barang[jumlah][]" 
               value="1" min="1">
    </td>
    <td>
        <input type="hidden" name="barang[imei][]" value="${e.target.dataset.imei}">
        ${e.target.dataset.imei}
    </td>
    <td>
        <input type="hidden" name="barang[jenis_hp][]" value="${e.target.dataset.jenis}">
        ${e.target.dataset.jenis}
    </td>
    <td>
        <input type="hidden" name="barang[internal][]" value="${e.target.dataset.internal}">
        ${e.target.dataset.internal}
    </td>
    <td>
        <input type="hidden" name="barang[warna][]" value="${e.target.dataset.warna}">
        ${e.target.dataset.warna}
    </td>
    <td class="subtotal">${formatRupiah(e.target.dataset.harga)}</td>
    <td><button type="button" class="btn btn-sm btn-danger hapus-row">Hapus</button></td>
`;

                tbody.appendChild(tr);
                hitungTotal();
            } else {
                // Hapus row dari tabel terpilih
                let row = document.querySelector(`#tabel-terpilih tbody tr[data-kode="${kode}"]`);
                if (row) row.remove();
                hitungTotal();
            }
        }
    });

    // Event input harga (format rupiah realtime + hitung ulang)
    document.addEventListener("input", function(e) {
        if (e.target.classList.contains("harga-input")) {
            let val = e.target.value.replace(/[^0-9]/g, "");
            e.target.value = formatRupiah(val);
            hitungTotal();
        }
        if (e.target.classList.contains("jumlah-input")) {
            hitungTotal();
        }
    });

    // Event hapus row manual
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("hapus-row")) {
            let tr = e.target.closest("tr");
            let kode = tr.dataset.kode;
            tr.remove();

            // Uncheck checkbox di modal
            let checkbox = document.querySelector(`.pilih-barang[data-kode="${kode}"]`);
            if (checkbox) checkbox.checked = false;

            hitungTotal();
        }
    });
</script>