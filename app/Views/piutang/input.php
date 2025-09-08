<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Piutang</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Input</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Piutang</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <form action="<?php echo base_url('input_piutang') ?>" enctype="multipart/form-data" method="post">

            <div style="display: flex; justify-content: space-between; ">

                <div class="mb-3">
                    <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                    <input style="width: 400px;" type="date" class="form-control" name="tanggal_peminjaman" id="tanggal_peminjaman">
                </div>



                <div class="mb-3" style="width: 400px;">
                    <label hidden for="jenis_penerima" class="form-label">Penerima</label>
                    <select hidden style="width: 400px;" name="jenis_penerima" id="jenis_penerima" class="form-select" required>
                        <option value="">-- Pilih Penerima --</option>
                        <option value="pelanggan">Pelanggan</option>
                        <option value="pegawai" selected>Pegawai</option> <!-- default pegawai -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jatuh_tempo" id="jatuh_tempo" class="form-label">Jatuh Tempo</label>
                    <input style="width: 400px;" type="date" class="form-control" name="jatuh_tempo" id="jatuh_tempo">
                </div>
            </div>




            <div style="display: flex; justify-content: space-between; ">



                <div class="mb-3" style="width: 400px;">
                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-select" required>
                        <option value="">-- Pilih Jenis Pembayaran --</option>
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="tunai_transfer">Tunai + Transfer</option>
                    </select>
                </div>

            </div>

            <p style="font-size: medium; font-weight: bold;">Detail Peminjaman</p>

            <div style="display: flex; justify-content: space-between; " id="pelanggan_section">

                <div class="mb-3" id="pemilihan_pelanggan" style="width: 400px;">
                    <label class="form-label" for="pelanggan_idpelanggan">Pelanggan</label>
                    <br>
                    <select class="form-control select2" name="pelanggan_idpelanggan" id="pelanggan_idpelanggan" required>
                        <option value="0">Pilih Pelanggan</option>
                        <?php foreach ($pelanggan as $b): ?>
                            <option data-alamat="<?= $b->alamat ?>" value="<?= esc($b->id_pelanggan) ?>">
                                <?= esc($b->nama) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="mb-3" id="pemilihan_pelanggan" style="width: 400px;">
                    <label class="form-label" for="alamat_pelanggan">Alamat Pelanggan</label>
                    <textarea readonly type="text" id="alamat_pelanggan" style="width: 400px;"></textarea>

                </div>


            </div>


            <div id="pegawai_section" class="row g-3"> <!-- g-3 kasih jarak antar kolom -->
                <!-- Kolom kiri -->
                <div class="col-md-6">
                    <label class="form-label" for="pegawai_idpegawai">Pegawai</label>
                    <select class="form-control select2" name="pegawai_idpegawai" id="pegawai_idpegawai" required>
                        <option value="0">Pilih Pegawai</option>
                        <?php foreach ($pegawai as $b): ?>
                            <option data-alamat="<?= $b->ALAMAT ?>" value="<?= esc($b->ID_AKUN) ?>">
                                <?= esc($b->NAMA_AKUN) ?> : <?= esc($b->KTP) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Kolom kanan -->
                <div class="col-md-6">
                    <label class="form-label" for="alamat_pegawai">Alamat Pegawai</label>
                    <textarea readonly class="form-control" id="alamat_pegawai" rows="3"></textarea>
                </div>


                <div class="col-md-6" id="bank_section">
                    <label class="form-label" for="bank_idbank">Bank</label>
                    <select class="form-control select2" name="bank_idbank" id="bank_idbank" required>
                        <option value="0">Pilih Bank</option>
                        <?php foreach ($bank as $b): ?>
                            <option data-atas_nama="<?= $b->atas_nama ?>" value="<?= esc($b->idbank) ?>">
                                <?= esc($b->nama_bank) ?> : <?= esc($b->norek) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Nominal Bank -->
                <div class="col-md-6" id="bank_section">
                    <label class="form-label" id="bank_section" for="jumlah_bank">Nominal Bank</label>
                    <input type="text" class="form-control nominal" name="jumlah_bank" value="Rp. 0" id="jumlah_bank">
                </div>

                <div class="col-md-6" id="nominal_tunai_section">
                    <label class="form-label" for="jumlah_tunai">Nominal Tunai</label>
                    <input type="text" class="form-control nominal" name="jumlah_tunai" value="Rp. 0" id="jumlah_tunai">
                </div>




                <div hidden class="col-md-6">
                    <label class="form-label" for="tambahan_nominal">Nominal Tambahan</label>
                    <input type="text" class="form-control nominal" value="Rp. 0" id="tambahan_nominal">
                </div>


                <div class="col-md-6">
                    <label class="form-label" for="nilai_total">Nominal Total</label>
                    <input readonly type="text" name="nilai_total" class="form-control" value="Rp. 0" id="nilai_total">
                </div>

            </div>
            <div style="display: flex; justify-content: right; ">
                <button style="margin-top: 20px;" type="submit" class="btn btn-success">Simpan</button>
            </div>

    </div>

    </form>


    <script>
        $(document).ready(function() {
            $('#pelanggan_idpelanggan').select2({
                dropdownParent: $('body')
            });


        });

        $(document).ready(function() {
            $('#pegawai_idpegawai').select2({
                dropdownParent: $('body')
            });


        });
    </script>



    <script>
        $(document).ready(function() {
            // awalnya sembunyikan dulu
            $("#pelanggan_section").hide();
            $("#pegawai_section").hide();

            // event ketika jenis_penerima berubah
            $("#jenis_penerima").on("change", function() {
                var pilihan = $(this).val();

                if (pilihan === "pelanggan") {
                    $("#pelanggan_section").show();
                    $("#pegawai_section").hide();
                } else if (pilihan === "pegawai") {
                    $("#pegawai_section").show();
                    $("#pelanggan_section").hide();
                } else {
                    $("#pelanggan_section").hide();
                    $("#pegawai_section").hide();
                }
            });

            // trigger change saat pertama kali halaman dimuat
            $("#jenis_penerima").trigger("change");
        });
    </script>


    <script>
        $(document).ready(function() {
            // untuk pelanggan
            $("#pelanggan_idpelanggan").on("change", function() {
                let alamat = $(this).find(":selected").data("alamat");
                if (alamat && alamat.trim() !== "") {
                    $("#alamat_pelanggan").val(alamat);
                } else {
                    $("#alamat_pelanggan").val("Tidak Tersedia, Silahkan Update Terlebih Dahulu");
                }
            });

            // untuk pegawai
            $("#pegawai_idpegawai").on("change", function() {
                let alamat = $(this).find(":selected").data("alamat");
                if (alamat && alamat.trim() !== "") {
                    $("#alamat_pegawai").val(alamat);
                } else {
                    $("#alamat_pegawai").val("Tidak Tersedia, Silahkan Update Terlebih Dahulu");
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            function togglePembayaran() {
                var jenis = $("#jenis_pembayaran").val();

                if (jenis === "tunai") {
                    $("#nominal_tunai_section").show();
                    $("#nominal_bank_section, #bank_section").hide();
                } else if (jenis === "transfer") {
                    $("#nominal_bank_section, #bank_section").show();
                    $("#nominal_tunai_section").hide();
                } else if (jenis === "tunai_transfer") {
                    $("#nominal_tunai_section, #nominal_bank_section, #bank_section").show();
                } else {
                    $("#nominal_tunai_section, #nominal_bank_section, #bank_section").hide();
                }
            }

            // jalankan pertama kali
            togglePembayaran();

            // jalankan setiap dropdown berubah
            $("#jenis_pembayaran").on("change", function() {
                togglePembayaran();
            });
        });
    </script>





    <script>
        $(document).ready(function() {
            // fungsi format ke rupiah
            function formatRupiah(angka) {
                let number_string = angka.replace(/[^,\d]/g, "").toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return rupiah ? "Rp. " + rupiah : "Rp. 0";
            }

            // fungsi hitung total
            function hitungTotal() {
                let bank = parseInt($("#jumlah_bank").val().replace(/[^,\d]/g, "")) || 0;
                let tunai = parseInt($("#jumlah_tunai").val().replace(/[^,\d]/g, "")) || 0;
                let tambahan = parseInt($("#tambahan_nominal").val().replace(/[^,\d]/g, "")) || 0;

                let total = bank + tunai + tambahan;
                $("#nilai_total").val(formatRupiah(total.toString()));
            }

            // event ketika user input
            $(".nominal").on("keyup", function() {
                $(this).val(formatRupiah($(this).val())); // format langsung ke rupiah
                hitungTotal(); // update total
            });

            // jalankan pertama kali
            hitungTotal();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date();
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, "0"); // bulan 01-12
            let dd = String(today.getDate()).padStart(2, "0"); // tanggal 01-31

            let formattedDate = yyyy + "-" + mm + "-" + dd;
            document.getElementById("tanggal_peminjaman").value = formattedDate;
        });
    </script>