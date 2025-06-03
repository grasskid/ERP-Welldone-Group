<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Service</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Transaksi</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Service</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body">
        <!-- Nav tabs -->
        <ul class="nav nav-pills nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center active" id="pelanggan-tab" data-bs-toggle="tab" href="#pelanggan"
                    role="tab" aria-controls="pelanggan" aria-selected="true">
                    <i class="bi bi-pencil-square fs-5"></i>
                    <span class="ms-2 mt-1">Pelanggan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center" id="kerusakan-tab" data-bs-toggle="tab" href="#kerusakan"
                    role="tab" aria-controls="kerusakan" aria-selected="false">
                    <i class="bi bi-clipboard-check fs-5"></i>
                    <span class="ms-2 mt-1">Kerusakan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center" id="sparepart-tab" data-bs-toggle="tab" href="#sparepart"
                    role="tab" aria-controls="sparepart" aria-selected="false">
                    <i class="bi bi-clipboard-check fs-5"></i>
                    <span class="ms-2 mt-1">Sparepart</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex flex-column align-items-center" id="pembayaran-tab" data-bs-toggle="tab" href="#pembayaran"
                    role="tab" aria-controls="pembayaran" aria-selected="false">
                    <i class="bi bi-clipboard-check fs-5"></i>
                    <span class="ms-2 mt-1">Pembayaran</span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content mt-3">
            <div class=" tab-pane fade show active" id="pelanggan" role="tabpanel" aria-labelledby="pelanggan-tab">
                <?= view('transaksi/table/pelanggan_table') ?>
            </div>


            <div class="tab-pane fade" id="kerusakan" role="tabpanel" aria-labelledby="kerusakan-tab">
                <?= view('transaksi/table/kerusakan_table') ?>
            </div>
            <div class="tab-pane fade" id="sparepart" role="tabpanel" aria-labelledby="sparepart-tab">
                <?= view('transaksi/table/sparepart_table') ?>
            </div>
            <div class="tab-pane fade" id="pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">
                <?= view('transaksi/table/pembayaran_table') ?>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('submitSemuaForm').addEventListener('click', async function(event) {
        event.preventDefault(); // <<<<<< Cegah submit bawaan browser

        let formKerusakan = new FormData(document.getElementById('form-kerusakan'));
        let formSparepart = new FormData(document.getElementById('form-sparepart'));
        let formPembayaran = new FormData(document.getElementById('form-pembayaran'));

        let finalFormData = new FormData();

        function mergeFormData(source, target) {
            for (let [key, value] of source.entries()) {
                target.append(key, value);
            }
        }

        mergeFormData(formKerusakan, finalFormData);
        mergeFormData(formSparepart, finalFormData);
        mergeFormData(formPembayaran, finalFormData);

        try {
            await fetch("<?= base_url('insert_kelengkapan/service') ?>", {
                method: "POST",
                body: finalFormData
            });
        } catch (error) {
            console.error("Terjadi kesalahan:", error);
        } finally {
            window.location.href = "<?= base_url('riwayat_service') ?>";
        }
    });
</script>