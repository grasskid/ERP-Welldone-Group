<!-- Breadcrumb -->
<div class="card shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body d-flex align-items-center justify-content-between p-4">
        <h4 class="fw-semibold mb-0">Promosi Pelanggan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="<?= base_url('/') ?>">Promosi</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Pelanggan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Card -->
<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom"></div>



    <div class="table-responsive mb-4 px-4">
        <table class="table border text-nowrap mb-0 align-middle" id="zero_config">
            <thead class="text-dark fs-4">
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>NIK</th>
                    <th>Nomer HP</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pelanggan)): ?>
                    <?php foreach ($pelanggan as $row): ?>
                        <tr>
                            <td><?= esc($row->nama) ?></td>
                            <td><?= esc($row->alamat) ?></td>
                            <td><?= esc($row->nik) ?></td>
                            <td><?= esc($row->no_hp) ?></td>
                            <td>
                                <button type="button" class="btn btn-wa"
                                    data-nohp="<?= esc($row->no_hp) ?>"
                                    style="width: 100px; height: 40px; background-color: greenyellow;">
                                    <iconify-icon icon="solar:phone-bold" width="24" height="24"></iconify-icon>
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-wa');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                let nomor = this.dataset.nohp.trim();

                // Normalisasi nomor HP
                if (nomor.startsWith('0')) {
                    nomor = '62' + nomor.substring(1);
                } else if (nomor.startsWith('+62')) {
                    nomor = nomor.substring(1); // hapus +
                }

                const waUrl = 'https://wa.me/' + nomor + '?text=' + encodeURIComponent("Halo, saya ingin bertanya");

                // Buka WhatsApp
                window.open(waUrl, '_blank');
            });
        });
    });
</script>