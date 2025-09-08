<head>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        const BASE_URL = "<?= base_url() ?>";
        const CSRF_TOKEN = "<?= csrf_hash() ?>";
    </script>
    <script src="<?= base_url('template/assets/js/apps/kanban.js') ?>"></script>
</head>


<body>
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Kanban</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Kanban</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card w-100 position-relative overflow-hidden">
        <div class="px-4 py-3 border-bottom">

        </div>
        <div
            class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between flex-wrap gap-6">
            <!-- <button id="add-list" class="btn btn-primary">Add List</button> -->
        </div>




        <!-- TO DO -->
        <div class="row scrumboard" id="cancel-row">
            <div class="col-lg-12 layout-spacing pb-3">
                <div data-simplebar>
                    <div class="task-list-section d-flex">
                        <div data-item="item-todo" class="task-list-container ms-3" data-action="sorting">
                            <div class="connect-sorting connect-sorting-todo">
                                <div class="task-container-header">
                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Todo">Todo</h6>
                                    <div class="hstack gap-2">
                                        <div class="add-kanban-title">
                                            <a class="addTask d-flex align-items-center justify-content-center gap-1 lh-sm"
                                                data-bs-toggle="modal" data-bs-target="#add-task-modal"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Add Task">
                                                <i class="ti ti-plus text-dark"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-1"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="ti ti-dots-vertical text-dark"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink-1">
                                                <!-- <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a> -->
                                                <!-- <a class="dropdown-item list-delete"
                                                    href="javascript:void(0);">Delete</a> -->
                                                <a class="dropdown-item clear_semua" href="javascript:void(0);"
                                                    data-status="1" data-akun="<?= session('ID_AKUN') ?>">Clear All</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="connect-sorting-content" data-sortable="true">
                                    <?php foreach ($tugas as $t): ?>
                                        <?php if ($t->status == 1): ?>
                                            <div data-draggable="true" class="card img-task">
                                                <div class="card-body">
                                                    <div class="task-header">
                                                        <div>
                                                            <h4 data-item-title="<?= esc($t->nama_tugas) ?>">
                                                                <?= esc($t->nama_tugas) ?>
                                                                <small class="text-muted">
                                                                    <br>
                                                                    <?= esc($t->NAMA_AKUN) ?></small>
                                                            </h4>
                                                        </div>
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="dropdownMenuLink-<?= $t->idtugas ?>"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="true">
                                                                <i class="ti ti-dots-vertical text-dark"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink-<?= $t->idtugas ?>">
                                                                <a class="dropdown-item edit_item_task cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);" data-idtugas="<?= $t->idtugas ?>"
                                                                    data-nama_tugas="<?= esc($t->nama_tugas) ?>"
                                                                    data-deskripsi="<?= esc($t->deskripsi) ?>"
                                                                    data-file="<?= esc($t->foto_tugas) ?>"
                                                                    data-status="<?= $t->status ?>">
                                                                    <i class="ti ti-pencil fs-5"></i>Edit
                                                                </a>

                                                                <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);"
                                                                    data-idtugas="<?= $t->idtugas ?>">
                                                                    <i class="ti ti-trash fs-5"></i>Delete
                                                                </a>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($t->deskripsi)): ?>
                                                        <div class="task-content">
                                                            <p class="mb-0" data-item-text="<?= esc($t->deskripsi) ?>">
                                                                <?= esc($t->deskripsi) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($t->foto_tugas): ?>
                                                        <div class="task-content p-0 mt-2">
                                                            <center>
                                                                <img src="<?= base_url('foto_tugas/' . $t->foto_tugas) ?>"
                                                                    class="img-fluid img-thumbnail-preview"
                                                                    alt="task image"
                                                                    style="max-width: 200px; display: flex; justify-content: center; cursor: pointer;"
                                                                    data-bs-toggle="modal" data-bs-target="#modalFoto">
                                                            </center>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="task-body">
                                                        <div class="task-bottom">
                                                            <div class="tb-section-1">
                                                                <span class="hstack gap-2 fs-2">
                                                                    <i class="ti ti-calendar fs-5"></i> <?= date('d M Y') ?>
                                                                </span>
                                                            </div>
                                                            <div class="tb-section-2">
                                                                <span
                                                                    class="badge rounded-pill text-bg-success fs-1">Todo</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        if (date('Y-m-d H:i:s') > $t->end_date): ?>
                                                            <span class="hstack gap-2 fs-2" style="padding-left: 20px; color: red; padding-bottom: 20px;">
                                                                keterangan : Melewati Deadline (<?= esc($t->end_date) ?>)
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- IN Progress -->
                        <div data-item="item-inprogress" class="task-list-container" data-action="sorting">
                            <div class="connect-sorting connect-sorting-inprogress">
                                <div class="task-container-header">
                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="In Progress">In
                                        Progress</h6>
                                    <div class="hstack gap-2">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button"
                                                id="dropdownMenuLink-inprogress" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="true">
                                                <i class="ti ti-dots-vertical text-dark"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink-inprogress">
                                                <!-- <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                <a class="dropdown-item list-delete"
                                                    href="javascript:void(0);">Delete</a> -->
                                                <a class="dropdown-item clear_semua" href="javascript:void(0);"
                                                    data-status="2" data-akun="<?= session('ID_AKUN') ?>">Clear All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="connect-sorting-content" data-sortable="true">
                                    <?php foreach ($tugas as $t): ?>
                                        <?php if ($t->status == 2): ?>
                                            <div data-draggable="true" class="card">
                                                <div class="card-body">
                                                    <div class="task-header">
                                                        <div>
                                                            <h4 data-item-title="<?= esc($t->nama_tugas) ?>">
                                                                <?= esc($t->nama_tugas) ?>
                                                                <small class="text-muted">
                                                                    <br>
                                                                    <?= esc($t->NAMA_AKUN) ?></small>
                                                            </h4>
                                                        </div>
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="dropdownMenuLink-<?= $t->idtugas ?>"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="true">
                                                                <i class="ti ti-dots-vertical text-dark"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink-<?= $t->idtugas ?>">
                                                                <a class="dropdown-item edit_item_task cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);" data-idtugas="<?= $t->idtugas ?>"
                                                                    data-nama_tugas="<?= esc($t->nama_tugas) ?>"
                                                                    data-deskripsi="<?= esc($t->deskripsi) ?>"
                                                                    data-file="<?= esc($t->foto_tugas) ?>"
                                                                    data-status="<?= $t->status ?>">
                                                                    <i class="ti ti-pencil fs-5"></i>Edit
                                                                </a>

                                                                <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);"
                                                                    data-idtugas="<?= $t->idtugas ?>">
                                                                    <i class="ti ti-trash fs-5"></i>Delete
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($t->deskripsi)): ?>
                                                        <div class="task-content">
                                                            <p class="mb-0" data-item-text="<?= esc($t->deskripsi) ?>">
                                                                <?= esc($t->deskripsi) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($t->foto_tugas): ?>
                                                        <div class="task-content p-0 mt-2">
                                                            <center>
                                                                <img src="<?= base_url('foto_tugas/' . $t->foto_tugas) ?>"
                                                                    class="img-fluid img-thumbnail-preview"
                                                                    alt="task image"
                                                                    style="max-width: 200px; display: flex; justify-content: center; cursor: pointer;"
                                                                    data-bs-toggle="modal" data-bs-target="#modalFoto">
                                                            </center>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="task-body">
                                                        <div class="task-bottom">
                                                            <div class="tb-section-1">
                                                                <span class="hstack gap-2 fs-2">
                                                                    <i class="ti ti-calendar fs-5"></i> <?= date('d M Y') ?>
                                                                </span>
                                                            </div>
                                                            <div class="tb-section-2">
                                                                <span class="badge rounded-pill text-bg-primary fs-1">In
                                                                    Progress</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        if (date('Y-m-d H:i:s') > $t->end_date): ?>
                                                            <span class="hstack gap-2 fs-2" style="padding-left: 20px; color: red; padding-bottom: 20px;">
                                                                keterangan : Melewati Deadline (<?= esc($t->end_date) ?>)
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>


                        <!-- PENDING -->
                        <div data-item="item-pending" class="task-list-container" data-action="sorting">
                            <div class="connect-sorting connect-sorting-pending">
                                <div class="task-container-header">
                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Pending">Pending</h6>
                                    <div class="hstack gap-2">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button"
                                                id="dropdownMenuLink-pending" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="true">
                                                <i class="ti ti-dots-vertical text-dark"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink-pending">
                                                <!-- <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                <a class="dropdown-item list-delete"
                                                    href="javascript:void(0);">Delete</a> -->
                                                <a class="dropdown-item clear_semua" href="javascript:void(0);"
                                                    data-status="3" data-akun="<?= session('ID_AKUN') ?>">Clear All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="connect-sorting-content" data-sortable="true">
                                    <?php foreach ($tugas as $t): ?>
                                        <?php if ($t->status == 3): ?>
                                            <div data-draggable="true" class="card img-task">
                                                <div class="card-body">
                                                    <div class="task-header">
                                                        <div>
                                                            <h4 data-item-title="<?= esc($t->nama_tugas) ?>">
                                                                <?= esc($t->nama_tugas) ?>
                                                                <small class="text-muted">
                                                                    <br>
                                                                    <?= esc($t->NAMA_AKUN) ?></small>
                                                            </h4>
                                                        </div>
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="dropdownMenuLink-<?= $t->idtugas ?>"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="true">
                                                                <i class="ti ti-dots-vertical text-dark"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink-<?= $t->idtugas ?>">
                                                                <a class="dropdown-item edit_item_task cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);" data-idtugas="<?= $t->idtugas ?>"
                                                                    data-nama_tugas="<?= esc($t->nama_tugas) ?>"
                                                                    data-deskripsi="<?= esc($t->deskripsi) ?>"
                                                                    data-file="<?= esc($t->foto_tugas) ?>"
                                                                    data-status="<?= $t->status ?>">
                                                                    <i class="ti ti-pencil fs-5"></i>Edit
                                                                </a>

                                                                <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);"
                                                                    data-idtugas="<?= $t->idtugas ?>">
                                                                    <i class="ti ti-trash fs-5"></i>Delete
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($t->deskripsi)): ?>
                                                        <div class="task-content">
                                                            <p class="mb-0" data-item-text="<?= esc($t->deskripsi) ?>">
                                                                <?= esc($t->deskripsi) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($t->foto_tugas): ?>
                                                        <div class="task-content p-0 mt-2">
                                                            <center>
                                                                <img src="<?= base_url('foto_tugas/' . $t->foto_tugas) ?>"
                                                                    class="img-fluid img-thumbnail-preview"
                                                                    alt="task image"
                                                                    style="max-width: 200px; display: flex; justify-content: center; cursor: pointer;"
                                                                    data-bs-toggle="modal" data-bs-target="#modalFoto">
                                                            </center>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="task-body">
                                                        <div class="task-bottom">
                                                            <div class="tb-section-1">
                                                                <span class="hstack gap-2 fs-2">
                                                                    <i class="ti ti-calendar fs-5"></i> <?= date('d M Y') ?>
                                                                </span>
                                                            </div>
                                                            <div class="tb-section-2">
                                                                <span
                                                                    class="badge rounded-pill text-bg-warning fs-1">Pending</span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        if (date('Y-m-d H:i:s') > $t->end_date): ?>
                                                            <span class="hstack gap-2 fs-2" style="padding-left: 20px; color: red; padding-bottom: 20px;">
                                                                keterangan : Melewati Deadline (<?= esc($t->end_date) ?>)
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- DONE -->
                        <div data-item="item-done" class="task-list-container" style="margin-right: 1rem;"
                            data-action="sorting">
                            <div class="connect-sorting connect-sorting-done">
                                <div class="task-container-header">
                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Done">Done</h6>
                                    <div class="hstack gap-2">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-done"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="ti ti-dots-vertical text-dark"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuLink-done">
                                                <!-- <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                <a class="dropdown-item list-delete"
                                                    href="javascript:void(0);">Delete</a> -->
                                                <a class="dropdown-item clear_semua" href="javascript:void(0);"
                                                    data-status="4" data-akun="<?= session('ID_AKUN') ?>">Clear All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="connect-sorting-content" data-sortable="true">
                                    <?php foreach ($tugas as $t): ?>
                                        <?php if ($t->status == 4): ?>
                                            <div data-draggable="true" class="card img-task">
                                                <div class="card-body">
                                                    <div class="task-header">
                                                        <div>
                                                            <h4 data-item-title="<?= esc($t->nama_tugas) ?>">
                                                                <?= esc($t->nama_tugas) ?>
                                                                <small class="text-muted">
                                                                    <br>
                                                                    <?= esc($t->NAMA_AKUN) ?></small>
                                                            </h4>
                                                        </div>
                                                        <div class="dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                                id="dropdownMenuLink-<?= $t->idtugas ?>"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="true">
                                                                <i class="ti ti-dots-vertical text-dark"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="dropdownMenuLink-<?= $t->idtugas ?>">
                                                                <a class="dropdown-item edit_item_task cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);" data-idtugas="<?= $t->idtugas ?>"
                                                                    data-nama_tugas="<?= esc($t->nama_tugas) ?>"
                                                                    data-deskripsi="<?= esc($t->deskripsi) ?>"
                                                                    data-file="<?= esc($t->foto_tugas) ?>"
                                                                    data-status="<?= $t->status ?>">
                                                                    <i class="ti ti-pencil fs-5"></i>Edit
                                                                </a>

                                                                <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1"
                                                                    href="javascript:void(0);"
                                                                    data-idtugas="<?= $t->idtugas ?>">
                                                                    <i class="ti ti-trash fs-5"></i>Delete
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($t->deskripsi)): ?>
                                                        <div class="task-content">
                                                            <p class="mb-0" data-item-text="<?= esc($t->deskripsi) ?>">
                                                                <?= esc($t->deskripsi) ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($t->foto_tugas): ?>
                                                        <div class="task-content p-0 mt-2">
                                                            <center>
                                                                <img src="<?= base_url('foto_tugas/' . $t->foto_tugas) ?>"
                                                                    class="img-fluid img-thumbnail-preview"
                                                                    alt="task image"
                                                                    style="max-width: 200px; display: flex; justify-content: center; cursor: pointer;"
                                                                    data-bs-toggle="modal" data-bs-target="#modalFoto">
                                                            </center>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="task-body">
                                                        <div class="task-bottom">
                                                            <div class="tb-section-1">
                                                                <span class="hstack gap-2 fs-2">
                                                                    <i class="ti ti-calendar fs-5"></i> <?= date('d M Y') ?>
                                                                </span>
                                                            </div>
                                                            <div class="tb-section-2">
                                                                <span class="badge rounded-pill text-bg-info fs-1">Done</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Task -->
    <div class="modal fade" id="add-task-modal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('add_tugas') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addTaskModalLabel">Tambah Tugas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama_tugas" class="form-label">Nama Tugas</label>
                            <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_tugas" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" id="deskripsi_tugas" name="deskripsi_tugas" rows="3"
                                required></textarea>
                        </div>


                        <div class="mb-3">
                            <label for="foto_tugas" class="form-label">Upload File (Foto Tugas)</label>


                            <div class="mb-2">
                                <img id="preview-foto_tugas" src="<?= base_url('path/default.jpg') ?>"
                                    class="img-thumbnail" style="max-height: 200px;">
                            </div>

                            <input type="file" class="form-control" id="foto_tugas" name="foto_tugas" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">Pending</option>
                                <option value="4">Done</option>
                            </select>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div> -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Edit Tugas -->
    <div class="modal fade" id="edit-task-modal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('update_tugas') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editTaskModalLabel">Edit Tugas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="edit-idtugas" name="idtugas">


                        <div class="mb-3">
                            <label for="edit-nama_tugas" class="form-label">Nama Tugas</label>
                            <input type="text" class="form-control" id="edit-nama_tugas" name="nama_tugas" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit-deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit-deskripsi" name="deskripsi_tugas" rows="3"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-file" class="form-label">Upload File Baru (Opsional)</label>

                            <div class="mb-2">
                                <img id="preview-edit-file" src="" alt="Preview Foto Lama" class="img-thumbnail"
                                    style="max-height: 200px;">
                            </div>

                            <input type="file" class="form-control" id="edit-file" name="foto_tugas" accept="image/*">
                            <small id="file-help" class="form-text text-muted">File sebelumnya: <span
                                    id="file-lama"></span></small>
                        </div>


                        <!-- Status -->
                        <div class="mb-3">
                            <label for="edit-status" class="form-label">Status</label>
                            <select class="form-select" id="edit-status" name="status" required>
                                <option value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">Pending</option>
                                <option value="4">Done</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Delete Tugas -->
    <div class="modal fade" id="delete-task-modal" tabindex="-1" aria-labelledby="deleteTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('delete_tugas') ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title" id="deleteTaskModalLabel">Hapus Tugas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="idtugas" id="delete-idtugas">
                        <p style="font-style: italic;">Apakah Anda yakin ingin menghapus tugas ini?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Clear All -->
    <div class="modal fade" id="clear-all-modal" tabindex="-1" aria-labelledby="clearAllModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('clear_all_tugas') ?>" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title" id="clearAllModalLabel">Hapus Semua Tugas</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="status" id="clear-status">
                        <input type="hidden" name="akun_ID_AKUN" id="clear-akun">

                        <p style="font-style: italic;">Apakah Anda yakin ingin menghapus <strong>semua tugas</strong>
                            berdasarkan status ini?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Semua</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal untuk Menampilkan Gambar -->
    <div class="modal fade" id="modalFoto" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div id="zoom-container" style="overflow: hidden;">
                        <img id="modalGambar" src="" alt="Foto Zoom"
                            style="max-width: 100%; transition: transform 0.3s ease;">
                    </div>
                </div>
                <div class="modal-footer justify-content-center gap-2 flex-wrap">

                    <!-- Tombol Geser -->
                    <div class="btn-group me-3" role="group">
                        <button class="btn btn-secondary" onclick="panImage(0, -20)">↑</button>
                        <div class="d-flex">
                            <button class="btn btn-secondary" onclick="panImage(-20, 0)">←</button>
                            <button class="btn btn-secondary" onclick="panImage(20, 0)">→</button>
                        </div>
                        <button class="btn btn-secondary" onclick="panImage(0, 20)">↓</button>
                    </div>

                    <!-- Tombol Zoom -->
                    <div class="btn-group" role="group">
                        <button class="btn btn-secondary" onclick="zoomOut()">-</button>
                        <button class="btn btn-secondary" onclick="zoomIn()">+</button>
                    </div>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        // edit

        document.querySelectorAll('.edit_item_task').forEach(button => {
            button.addEventListener('click', () => {
                const fileName = button.getAttribute('data-file');
                const baseUrl = '<?= base_url('foto_tugas/') ?>';

                document.getElementById('file-lama').textContent = fileName ? fileName : 'Tidak ada file';


                const previewImg = document.getElementById('preview-edit-file');
                if (fileName) {
                    previewImg.src = baseUrl + fileName;
                    previewImg.style.display = 'block';
                } else {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
                }


                document.getElementById('edit-idtugas').value = button.getAttribute('data-idtugas');
                document.getElementById('edit-nama_tugas').value = button.getAttribute('data-nama_tugas');
                document.getElementById('edit-deskripsi').value = button.getAttribute('data-deskripsi');
                document.getElementById('edit-status').value = button.getAttribute('data-status');


                const modaledit = new bootstrap.Modal(document.getElementById('edit-task-modal'));
                modaledit.show();
            });
        });


        document.getElementById('edit-file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImg = document.getElementById('preview-edit-file');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // delete
        document.querySelectorAll('.kanban-item-delete').forEach(button => {
            button.addEventListener('click', () => {
                const idtugas = button.getAttribute('data-idtugas');
                document.getElementById('delete-idtugas').value = idtugas;

                const modaldelete = new bootstrap.Modal(document.getElementById('delete-task-modal'));
                modaldelete.show();
            });
        });

        // clear all
        document.querySelectorAll('.clear_semua').forEach(button => {
            button.addEventListener('click', () => {


                const status = button.getAttribute('data-status');
                const akunID = button.getAttribute('data-akun');

                document.getElementById('clear-status').value = status;
                document.getElementById('clear-akun').value = akunID;


                const modalclearall = new bootstrap.Modal(document.getElementById('clear-all-modal'));
                modalclearall.show();
            });
        });
    </script>

    <!-- preview image -->
    <script>
        document.getElementById('foto_tugas').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview-foto_tugas').src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });
    </script>


    <script>
        const thumbnails = document.querySelectorAll('.img-thumbnail-preview');
        const modalGambar = document.getElementById('modalGambar');
        const modalFoto = document.getElementById('modalFoto');

        let scale = 1;
        let posX = 0;
        let posY = 0;
        let isDragging = false;
        let startX, startY;
        let modalInstance = null;



        thumbnails.forEach(img => {
            img.addEventListener('click', function() {
                const src = this.getAttribute('src');
                modalGambar.setAttribute('src', src);

                scale = 1;
                posX = 0;
                posY = 0;
                updateTransform();

                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(modalFoto);
                }
                modalInstance.show();
            });
        });

        // Fungsi update transform CSS
        function updateTransform() {
            modalGambar.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
        }


        modalGambar.addEventListener('wheel', function(e) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? -0.1 : 0.1;
            scale = Math.min(Math.max(0.5, scale + delta), 5);
            updateTransform();
        });

        // Drag dengan mouse
        modalGambar.addEventListener('mousedown', function(e) {
            isDragging = true;
            startX = e.clientX - posX;
            startY = e.clientY - posY;
            modalGambar.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            posX = e.clientX - startX;
            posY = e.clientY - startY;
            updateTransform();
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
            modalGambar.style.cursor = 'grab';
        });

        // Reset saat modal ditutup
        modalFoto.addEventListener('hidden.bs.modal', function() {
            scale = 1;
            posX = 0;
            posY = 0;
            updateTransform();

            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = '';
        });

        // Fungsi tombol zoom
        function zoomIn() {
            scale = Math.min(scale + 0.1, 5);
            updateTransform();
        }

        function zoomOut() {
            scale = Math.max(scale - 0.1, 0.5);
            updateTransform();
        }

        // Fungsi tombol geser
        function panImage(x, y) {
            posX += x;
            posY += y;
            updateTransform();
        }



        function tutupModal() {
            const modalInstance = bootstrap.Modal.getInstance(modalFoto);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    </script>




</body>


<!-- kode lama #
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="add-task-title modal-title" id="addTaskModalTitleLabel1">Add Task</h5>
                        <h5 class="edit-task-title modal-title" id="addTaskModalTitleLabel2">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="compose-box">
                            <div class="compose-content" id="addTaskModalTitle">
                                <div class="addTaskAccordion" id="add_task_accordion">
                                    <div class="task-content task-text-progress">
                                        <div id="collapseTwo" class="collapse show" data-parent="#add_task_accordion">
                                            <div class="task-content-body">
                                                <form action="javascript:void(0);">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="task-title mb-4 d-flex">
                                                                <input id="kanban-title" type="text" placeholder="Task"
                                                                    class="form-control" name="task">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="task-badge d-flex">
                                                                <textarea id="kanban-text" placeholder="Task Text"
                                                                    class="form-control" name="taskText"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <div class="d-flex gap-6">
                            <button data-btn-action="addTask" class="btn add-tsk btn-primary">Add Task</button>
                            <button data-btn-action="editTask" class="btn edit-tsk btn-success">Save</button>
                            <button class="btn bg-danger-subtle text-danger d-flex align-items-center gap-1"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title add-list-title" id="addListModalTitleLabel1">Add List</h5>
                        <h5 class="modal-title edit-list-title" id="addListModalTitleLabel2">Edit List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="compose-box">
                            <div class="compose-content" id="addListModalTitle">
                                <form action="javascript:void(0);">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="list-title d-flex align-items-center">
                                                <input id="item-name" type="text" placeholder="List Name"
                                                    class="form-control" name="task">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <div class="d-flex gap-6">
                            <button class="btn bg-danger-subtle text-danger d-flex align-items-center gap-1"
                                data-bs-dismiss="modal">Cancel</button>
                            <button class="btn add-list btn-primary">Add List</button>
                            <button class="btn edit-list btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteConformation" tabindex="-1" role="dialog"
            aria-labelledby="deleteConformationLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" id="deleteConformationLabel">
                    <div class="modal-header">
                        <div
                            class="icon round-40 d-flex align-items-center justify-content-center bg-light-danger text-danger me-2 rounded-circle">
                            <i class="ti ti-trash fs-6"></i>
                        </div>
                        <h5 class="modal-title fw-semibold" id="exampleModalLabel">Delete the task?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">If you delete the task it will be gone forever. Are you sure you want to
                            proceed?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" data-remove="task">Delete</button>
                    </div>
                </div>
            </div>
        </div>

end kode lama # -->