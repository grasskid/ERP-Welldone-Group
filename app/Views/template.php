<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="dark" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('template/') ?><?= env('app.logo', 'assets/images/logo.png') ?>" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Core Css -->
    <link rel="stylesheet" href="<?php echo base_url('template/') ?>assets/css/styles.css" />
    <link rel="stylesheet" href="<?php echo base_url('template/assets/libs/select2/dist/css/select2.min.css') ?>">



    <title><?= env('app.name', 'App ERP') ?></title>

    <!-- jvectormap  -->
    <link rel="stylesheet" href="<?php echo base_url('template/') ?>assets/libs/jvectormap/jquery-jvectormap.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS -->

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />



</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="<?php echo base_url('template/') ?>assets/images/logos/loader.svg" alt="loader"
            class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <?php echo view('inc/left_vertical'); ?>
        <!--  Sidebar End -->
        <div class="page-wrapper">

            <?php echo view('inc/left_horizontal'); ?>

            <div class="body-wrapper">
                <div class="container-fluid">
                    <!--  Header Start -->
                    <header class="topbar sticky-top">
                        <div class="with-vertical">
                            <!-- ---------------------------------- -->
                            <!-- Start Vertical Layout Header -->
                            <!-- ---------------------------------- -->
                            <nav class="navbar navbar-expand-lg p-0">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                            href="javascript:void(0)">
                                            <div class="nav-icon-hover-bg rounded-circle ">
                                                <iconify-icon icon="solar:list-bold-duotone" class="fs-7 text-dark">
                                                </iconify-icon>
                                            </div>
                                        </a>
                                    </li>
                                </ul>



                                <div class="d-block d-lg-none">
                                    <img src="<?php echo base_url('template/') ?>assets/images/logos/logo-light.svg"
                                        class="dark-logo" alt="Logo-Dark" />
                                    <img src="<?php echo base_url('template/') ?>assets/images/logos/logo-dark.svg"
                                        class="light-logo" alt="Logo-light" />
                                </div>


                                <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)"
                                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="p-2">
                                        <i class="ti ti-dots fs-7"></i>
                                    </span>
                                </a>
                                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0)"
                                            class="nav-link d-flex d-lg-none align-items-center justify-content-center"
                                            type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                            aria-controls="offcanvasWithBothOptions">
                                            <div class="nav-icon-hover-bg rounded-circle ">
                                                <i class="ti ti-align-justified fs-7"></i>
                                            </div>
                                        </a>
                                        <ul
                                            class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                            <li class="nav-item dropdown d-block d-lg-none">
                                                <a class="nav-link position-relative" href="javascript:void(0)"
                                                    id="drop3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <iconify-icon icon="solar:magnifer-linear" class="fs-7 text-dark">
                                                    </iconify-icon>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop3">
                                                    <!--  Search Bar -->

                                                    <div class="modal-header border-bottom p-3">
                                                        <input type="search" class="form-control fs-3"
                                                            placeholder="Try to searching ..." />
                                                        <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
                                                            <i class="ti ti-x fs-5 ms-3"></i>
                                                        </span>
                                                    </div>
                                                    <div class="message-body p-3" data-simplebar="">
                                                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                                                        <ul class="list mb-0 py-2">
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- start language Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown d-none d-lg-block">
                                                <a class="nav-link position-relative" href="javascript:void(0)"
                                                    id="drop3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <form class="nav-link position-relative">
                                                        <input type="text"
                                                            class="form-control rounded-3 py-2 ps-5 text-dark"
                                                            placeholder="Try to searching ...">
                                                        <iconify-icon icon="solar:magnifer-linear"
                                                            class="text-dark position-absolute top-50 start-0 translate-middle-y text-dark ms-3">
                                                        </iconify-icon>
                                                    </form>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop3">
                                                    <!--  Search Bar -->

                                                    <div class="modal-header border-bottom p-3">
                                                        <input type="search" class="form-control fs-3"
                                                            placeholder="Try to searching ..." />
                                                        <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
                                                            <i class="ti ti-x fs-5 ms-3"></i>
                                                        </span>
                                                    </div>
                                                    <div class="message-body p-3" data-simplebar="">
                                                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                                                        <ul class="list mb-0 py-2">
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end language Dropdown -->
                                            <!-- ------------------------------- -->

                                            <li class="nav-item">
                                                <a class="nav-link nav-icon-hover moon dark-layout"
                                                    href="javascript:void(0)">
                                                    <iconify-icon icon="solar:moon-line-duotone" class="moon fs-7">
                                                    </iconify-icon>
                                                </a>
                                                <a class="nav-link nav-icon-hover sun light-layout"
                                                    href="javascript:void(0)">
                                                    <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-7">
                                                    </iconify-icon>
                                                </a>
                                            </li>

                                            <!-- ------------------------------- -->
                                            <!-- start Messages cart Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link position-relative nav-icon-hover"
                                                    href="javascript:void(0)" id="drop3" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <div class="nav-icon-hover-bg rounded-circle ">
                                                        <iconify-icon icon="solar:chat-dots-line-duotone"
                                                            class="fs-7 text-dark"></iconify-icon>
                                                    </div>
                                                    <div class="pulse">
                                                        <span class="heartbit border-warning"></span>
                                                        <span class="point text-bg-warning"></span>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop3">
                                                    <!--  Messages -->
                                                    <div class="d-flex align-items-center py-3 px-7">
                                                        <h3 class="mb-0 fs-5">Stok Minimum</h3>
                                                        <span class="badge bg-info ms-3"><?= count($stokMinimum) ?> new</span>
                                                    </div>

                                                    <div class="message-body" data-simplebar>
                                                        <?php if (!empty($stokMinimum)) : ?>
                                                            <?php foreach ($stokMinimum as $item) : ?>
                                                                <a href="javascript:void(0)" class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                    <span class="flex-shrink-0">
                                                                        <img src="<?= base_url('template/assets/images/profile/user-2.jpg') ?>"
                                                                            alt="user" width="45" class="rounded-circle" />
                                                                    </span>
                                                                    <div class="w-100 d-inline-block v-middle ps-3">
                                                                        <div class="d-flex align-items-center justify-content-between">
                                                                            <h5 class="mb-0 fs-3 fw-normal">
                                                                                <?= esc($item->nama_barang) ?>
                                                                            </h5>
                                                                        </div>
                                                                        <span class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">
                                                                            Unit: <?= esc($item->nama_unit) ?>
                                                                        </span>
                                                                        <span class="fs-2 text-nowrap d-block fw-normal mt-1 text-danger">
                                                                            Sisa <?= esc($item->stok_akhir) ?> (Min: <?= esc($item->stok_minimum) ?>)
                                                                        </span>
                                                                    </div>
                                                                </a>
                                                            <?php endforeach; ?>
                                                        <?php else : ?>
                                                            <div class="px-7 py-6 text-muted">Tidak ada notifikasi stok minimum</div>
                                                        <?php endif; ?>
                                                    </div>



                                                    <div class="py-6 px-7 mb-1">
                                                        <a href="<?php echo base_url('stok_minimum') ?>">
                                                            <button class="btn btn-primary w-100">
                                                                See All Messages
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end Messages cart Dropdown -->
                                            <!-- ------------------------------- -->

                                            <!-- ------------------------------- -->
                                            <!-- start notification Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link position-relative nav-icon-hover"
                                                    href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <div class="nav-icon-hover-bg rounded-circle ">
                                                        <iconify-icon icon="solar:bell-bing-line-duotone"
                                                            class="fs-7 text-dark"></iconify-icon>
                                                    </div>
                                                    <div class="pulse">
                                                        <span class="heartbit border-success"></span>
                                                        <span class="point text-bg-success"></span>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop2">
                                                    <div class="d-flex align-items-center px-7 py-3">
                                                        <h3 class="mb-0 fs-5">Notifications</h3>
                                                        <span class="badge bg-warning ms-3">5 new</span>
                                                    </div>

                                                    <div class="message-body" data-simplebar>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-2.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 fs-3 fw-normal">
                                                                    Roman Joined the Team!
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Congratulate
                                                                    him</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-3.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 mt-1 fs-3 fw-normal">
                                                                    New message received
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Salma
                                                                    sent you new
                                                                    message</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-4.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 mt-1 fs-3 fw-normal">
                                                                    New Payment received
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Check
                                                                    your
                                                                    earnings</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-5.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 fs-3 fw-normal">
                                                                    New message received
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Salma
                                                                    sent you new
                                                                    message</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-6.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 fs-3 fw-normal">
                                                                    Roman Joined the Team!
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Congratulate
                                                                    him</span>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="py-6 px-7 mb-1">
                                                        <button class="btn btn-primary w-100">
                                                            See All Notifications
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end notification Dropdown -->
                                            <!-- ------------------------------- -->

                                            <!-- ------------------------------- -->
                                            <!-- start profile Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link position-relative ms-6" href="javascript:void(0)"
                                                    id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <div class="d-flex align-items-center flex-shrink-0">
                                                        <div class="user-profile me-sm-3 me-2">
                                                            <img src="<?php echo base_url('template/') ?>assets/images/profile/user-1.jpg"
                                                                width="45" class="rounded-circle" alt="">
                                                        </div>
                                                        <span class="d-sm-none d-block">
                                                            <iconify-icon icon="solar:alt-arrow-down-line-duotone">
                                                            </iconify-icon>
                                                        </span>

                                                        <div class="d-none d-sm-block">
                                                            <h6 class="fw-bold fs-4 mb-1 profile-name">
                                                                <?php echo session('NAMA') ?>
                                                            </h6>
                                                            <p class="fs-3 lh-base mb-0 profile-subtext">
                                                                Admin
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop1">
                                                    <div class="profile-dropdown position-relative" data-simplebar>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between pt-3 px-7">
                                                            <h3 class="mb-0 fs-5">User Profile</h3>
                                                            <button type="button" class="border-0 bg-transparent"
                                                                aria-label="Close">
                                                                <iconify-icon icon="solar:close-circle-line-duotone"
                                                                    class="fs-7 text-muted"></iconify-icon>
                                                            </button>
                                                        </div>

                                                        <div class="d-flex align-items-center mx-7 py-9 border-bottom">
                                                            <img src="<?php echo base_url('template/') ?>assets/images/profile/user-1.jpg"
                                                                alt="user" width="90" class="rounded-circle" />
                                                            <div class="ms-4">
                                                                <h4 class="mb-0 fs-5 fw-normal">Mike Nielsen</h4>
                                                                <span class="text-muted">super admin</span>
                                                                <p
                                                                    class="text-muted mb-0 mt-1 d-flex align-items-center">
                                                                    <iconify-icon icon="solar:mailbox-line-duotone"
                                                                        class="fs-4 me-1"></iconify-icon>
                                                                    info@spike.com
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="message-body">
                                                            <a href="<?php echo base_url('template/') ?>dark/page-user-profile.html"
                                                                class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                <span
                                                                    class="btn px-3 py-2 bg-info-subtle rounded-1 text-info shadow-none">
                                                                    <iconify-icon icon="solar:wallet-2-line-duotone"
                                                                        class="fs-7"></iconify-icon>
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">
                                                                        My Profile
                                                                    </h5>
                                                                    <span
                                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">Account
                                                                        Settings</span>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo base_url('template/') ?>dark/app-email.html"
                                                                class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                <span
                                                                    class="btn px-3 py-2 bg-success-subtle rounded-1 text-success shadow-none">
                                                                    <iconify-icon
                                                                        icon="solar:shield-minimalistic-line-duotone"
                                                                        class="fs-7"></iconify-icon>
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">My Inbox</h5>
                                                                    <span
                                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">Messages
                                                                        & Emails</span>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo base_url('template/') ?>dark/app-notes.html"
                                                                class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                <span
                                                                    class="btn px-3 py-2 bg-danger-subtle rounded-1 text-danger shadow-none">
                                                                    <iconify-icon icon="solar:card-2-line-duotone"
                                                                        class="fs-7"></iconify-icon>
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">My Task</h5>
                                                                    <span
                                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">To-do
                                                                        and Daily
                                                                        Tasks</span>
                                                                </div>
                                                            </a>
                                                        </div>

                                                        <div class="py-6 px-7 mb-1">
                                                            <a href="<?php echo base_url('template/') ?>dark/authentication-login.html"
                                                                class="btn btn-primary w-100">Log Out</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end profile Dropdown -->
                                            <!-- ------------------------------- -->
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!-- ---------------------------------- -->
                            <!-- End Vertical Layout Header -->
                            <!-- ---------------------------------- -->

                            <!-- ------------------------------- -->
                            <!-- apps Dropdown in Small screen -->
                            <!-- ------------------------------- -->
                            <!--  Mobilenavbar -->
                            <div class="offcanvas offcanvas-start dropdown-menu-nav-offcanvas" data-bs-scroll="true"
                                tabindex="-1" id="mobilenavbar" aria-labelledby="offcanvasWithBothOptionsLabel">
                                <nav class="sidebar-nav scroll-sidebar">
                                    <div class="offcanvas-header justify-content-between">
                                        <img src="<?php echo base_url('template/') ?>assets/images/logos/favicon.png"
                                            alt="" class="img-fluid" />
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body h-n80" data-simplebar>
                                        <ul id="sidebarnav">
                                            <li class="sidebar-item">
                                                <a class="sidebar-link gap-2 has-arrow" href="javascript:void(0)"
                                                    aria-expanded="false">
                                                    <iconify-icon icon="solar:list-bold-duotone" class="fs-7 text-dark">
                                                    </iconify-icon>
                                                    <span class="hide-menu">Apps</span>
                                                </a>
                                                <ul aria-expanded="false" class="collapse first-level my-3">
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-chat.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Chat Application</h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">New
                                                                    messages arrived</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-invoice.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Invoice App</h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">Get
                                                                    latest invoice</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-mobile.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Contact Application
                                                                </h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">2
                                                                    Unsaved Contacts</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-message-box.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Email App</h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">Get new
                                                                    emails</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-cart.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">User Profile</h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">learn
                                                                    more information</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-date.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Calendar App</h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">Get
                                                                    dates</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-lifebuoy.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Contact List Table
                                                                </h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">Add new
                                                                    contact</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-item py-2">
                                                        <a href="#" class="d-flex align-items-center">
                                                            <div
                                                                class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/svgs/icon-dd-application.svg"
                                                                    alt="" class="img-fluid" width="24" height="24" />
                                                            </div>
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-1 bg-hover-primary">Notes Application</h6>
                                                                <span class="fs-2 d-block fw-normal text-muted">To-do
                                                                    and Daily tasks</span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <ul class="px-8 mt-6 mb-4">
                                                        <li class="sidebar-item mb-3">
                                                            <h5 class="fs-5 fw-semibold">Quick Links</h5>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">Pricing Page</a>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">Authentication
                                                                Design</a>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">Register Now</a>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">404 Error Page</a>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">Notes App</a>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">User
                                                                Application</a>
                                                        </li>
                                                        <li class="sidebar-item py-2">
                                                            <a class="fw-semibold text-dark" href="#">Account
                                                                Settings</a>
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link gap-2" href="#" aria-expanded="false">
                                                    <iconify-icon icon="solar:chat-round-unread-line-duotone"
                                                        class="fs-6 text-dark"></iconify-icon>
                                                    <span class="hide-menu">Chat</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link gap-2" href="#" aria-expanded="false">
                                                    <iconify-icon icon="solar:calendar-add-line-duotone"
                                                        class="fs-6 text-dark"></iconify-icon>
                                                    <span class="hide-menu">Calendar</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link gap-2" href="#" aria-expanded="false">
                                                    <iconify-icon icon="solar:mailbox-line-duotone"
                                                        class="fs-6 text-dark"></iconify-icon>
                                                    <span class="hide-menu">Email</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="app-header with-horizontal">
                            <nav class="navbar navbar-expand-xl container-fluid p-0">
                                <ul class="navbar-nav">
                                    <li class="nav-item d-none d-xl-block">
                                        <a href="index.html" class="text-nowrap nav-link">
                                            <img src="<?php echo base_url('template/') ?>assets/images/logos/logo-light.svg"
                                                class="dark-logo" width="180" alt="" />
                                            <img src="<?php echo base_url('template/') ?>assets/images/logos/logo-dark.svg"
                                                class="light-logo" width="180" alt="" />
                                        </a>
                                    </li>
                                </ul>
                                <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)"
                                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="p-2">
                                        <i class="ti ti-dots fs-7"></i>
                                    </span>
                                </a>
                                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="javascript:void(0)"
                                            class="nav-link d-flex d-lg-none align-items-center justify-content-center"
                                            type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                            aria-controls="offcanvasWithBothOptions">
                                            <div class="nav-icon-hover-bg rounded-circle ">
                                                <i class="ti ti-align-justified fs-7"></i>
                                            </div>
                                        </a>
                                        <ul
                                            class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                                            <li class="nav-item dropdown d-block d-lg-none">
                                                <a class="nav-link position-relative" href="javascript:void(0)"
                                                    id="drop3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <iconify-icon icon="solar:magnifer-linear" class="fs-7 text-dark">
                                                    </iconify-icon>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop3">
                                                    <!--  Search Bar -->

                                                    <div class="modal-header border-bottom p-3">
                                                        <input type="search" class="form-control fs-3"
                                                            placeholder="Try to searching ..." />
                                                        <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
                                                            <i class="ti ti-x fs-5 ms-3"></i>
                                                        </span>
                                                    </div>
                                                    <div class="message-body p-3" data-simplebar="">
                                                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                                                        <ul class="list mb-0 py-2">
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- start language Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown d-none d-lg-block">
                                                <a class="nav-link position-relative" href="javascript:void(0)"
                                                    id="drop3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <form class="nav-link position-relative">
                                                        <input type="text"
                                                            class="form-control rounded-3 py-2 ps-5 text-dark"
                                                            placeholder="Try to searching ...">
                                                        <iconify-icon icon="solar:magnifer-linear"
                                                            class="text-dark position-absolute top-50 start-0 translate-middle-y text-dark ms-3">
                                                        </iconify-icon>
                                                    </form>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop3">
                                                    <!--  Search Bar -->

                                                    <div class="modal-header border-bottom p-3">
                                                        <input type="search" class="form-control fs-3"
                                                            placeholder="Try to searching ..." />
                                                        <span data-bs-dismiss="modal" class="lh-1 cursor-pointer">
                                                            <i class="ti ti-x fs-5 ms-3"></i>
                                                        </span>
                                                    </div>
                                                    <div class="message-body p-3" data-simplebar="">
                                                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                                                        <ul class="list mb-0 py-2">
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Modern</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard1</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Dashboard</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/dashboards/dashboard2</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Contacts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/contacts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Posts</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/posts</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Detail</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                                                </a>
                                                            </li>
                                                            <li class="p-1 mb-1 bg-hover-light-black">
                                                                <a href="#">
                                                                    <span
                                                                        class="fs-3 text-dark fw-normal d-block">Shop</span>
                                                                    <span
                                                                        class="fs-3 text-muted d-block">/apps/ecommerce/shop</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end language Dropdown -->
                                            <!-- ------------------------------- -->

                                            <li class="nav-item">
                                                <a class="nav-link nav-icon-hover moon dark-layout"
                                                    href="javascript:void(0)">
                                                    <iconify-icon icon="solar:moon-line-duotone" class="moon fs-7">
                                                    </iconify-icon>
                                                </a>
                                                <a class="nav-link nav-icon-hover sun light-layout"
                                                    href="javascript:void(0)">
                                                    <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-7">
                                                    </iconify-icon>
                                                </a>
                                            </li>

                                            <!-- ------------------------------- -->
                                            <!-- start Messages cart Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link position-relative nav-icon-hover"
                                                    href="javascript:void(0)" id="drop3" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <div class="nav-icon-hover-bg rounded-circle ">
                                                        <iconify-icon icon="solar:chat-dots-line-duotone"
                                                            class="fs-7 text-dark"></iconify-icon>
                                                    </div>
                                                    <div class="pulse">
                                                        <span class="heartbit border-warning"></span>
                                                        <span class="point text-bg-warning"></span>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop3">
                                                    <!--  Messages -->
                                                    <div class="d-flex align-items-center py-3 px-7">
                                                        <h3 class="mb-0 fs-5">Messages</h3>
                                                        <span class="badge bg-info ms-3">5 new</span>
                                                    </div>

                                                    <div class="message-body" data-simplebar>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-7 d-flex align-items-center py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-2.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-100 d-inline-block v-middle ps-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <h5 class="mb-0 fs-3 fw-normal">
                                                                        Roman Joined the Team!
                                                                    </h5>
                                                                    <span
                                                                        class="fs-2 text-nowrap d-block text-muted">9:08
                                                                        AM</span>
                                                                </div>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Congratulate
                                                                    him</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-7 d-flex align-items-center py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-3.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-100 d-inline-block v-middle ps-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <h5 class="mb-0 fs-3 fw-normal">
                                                                        New message received
                                                                    </h5>
                                                                    <span
                                                                        class="fs-2 text-nowrap d-block text-muted">9:08
                                                                        AM</span>
                                                                </div>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Salma
                                                                    sent you new
                                                                    message</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-7 d-flex align-items-center py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-4.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-100 d-inline-block v-middle ps-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <h5 class="mb-0 fs-3 fw-normal">
                                                                        New Payment received
                                                                    </h5>
                                                                    <span
                                                                        class="fs-2 text-nowrap d-block text-muted">9:08
                                                                        AM</span>
                                                                </div>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Check
                                                                    your
                                                                    earnings</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-7 d-flex align-items-center py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-5.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-100 d-inline-block v-middle ps-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <h5 class="mb-0 fs-3 fw-normal">
                                                                        New message received
                                                                    </h5>
                                                                    <span
                                                                        class="fs-2 text-nowrap d-block text-muted">9:08
                                                                        AM</span>
                                                                </div>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Salma
                                                                    sent you new
                                                                    message</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-7 d-flex align-items-center py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-6.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-100 d-inline-block v-middle ps-3">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <h5 class="mb-0 fs-3 fw-normal">
                                                                        Roman Joined the Team!
                                                                    </h5>
                                                                    <span
                                                                        class="fs-2 text-nowrap d-block text-muted">9:08
                                                                        AM</span>
                                                                </div>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Congratulate
                                                                    him</span>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="py-6 px-7 mb-1">
                                                        <button class="btn btn-primary w-100">
                                                            See All Messages
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end Messages cart Dropdown -->
                                            <!-- ------------------------------- -->

                                            <!-- ------------------------------- -->
                                            <!-- start notification Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link position-relative nav-icon-hover"
                                                    href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <div class="nav-icon-hover-bg rounded-circle ">
                                                        <iconify-icon icon="solar:bell-bing-line-duotone"
                                                            class="fs-7 text-dark"></iconify-icon>
                                                    </div>
                                                    <div class="pulse">
                                                        <span class="heartbit border-success"></span>
                                                        <span class="point text-bg-success"></span>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop2">
                                                    <div class="d-flex align-items-center px-7 py-3">
                                                        <h3 class="mb-0 fs-5">Notifications</h3>
                                                        <span class="badge bg-warning ms-3">5 new</span>
                                                    </div>

                                                    <div class="message-body" data-simplebar>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-2.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 fs-3 fw-normal">
                                                                    Roman Joined the Team!
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Congratulate
                                                                    him</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-3.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 mt-1 fs-3 fw-normal">
                                                                    New message received
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Salma
                                                                    sent you new
                                                                    message</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-4.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 mt-1 fs-3 fw-normal">
                                                                    New Payment received
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Check
                                                                    your
                                                                    earnings</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-5.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 fs-3 fw-normal">
                                                                    New message received
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Salma
                                                                    sent you new
                                                                    message</span>
                                                            </div>
                                                        </a>

                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item px-2 d-flex align-items-center px-7 py-6">
                                                            <span class="flex-shrink-0">
                                                                <img src="<?php echo base_url('template/') ?>assets/images/profile/user-6.jpg"
                                                                    alt="user" width="45" class="rounded-circle" />
                                                            </span>
                                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                                <h5 class="mb-0 fs-3 fw-normal">
                                                                    Roman Joined the Team!
                                                                </h5>
                                                                <span
                                                                    class="fs-2 text-nowrap d-block fw-normal mt-1 text-muted">Congratulate
                                                                    him</span>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="py-6 px-7 mb-1">
                                                        <button class="btn btn-primary w-100">
                                                            See All Notifications
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end notification Dropdown -->
                                            <!-- ------------------------------- -->

                                            <!-- ------------------------------- -->
                                            <!-- start profile Dropdown -->
                                            <!-- ------------------------------- -->
                                            <li class="nav-item dropdown">
                                                <a class="nav-link position-relative ms-6" href="javascript:void(0)"
                                                    id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <div class="d-flex align-items-center flex-shrink-0">
                                                        <div class="user-profile me-sm-3 me-2">
                                                            <img src="<?php echo base_url('template/') ?>assets/images/profile/user-1.jpg"
                                                                width="45" class="rounded-circle" alt="">
                                                        </div>
                                                        <span class="d-sm-none d-block">
                                                            <iconify-icon icon="solar:alt-arrow-down-line-duotone">
                                                            </iconify-icon>
                                                        </span>

                                                        <div class="d-none d-sm-block">
                                                            <h6 class="fw-bold fs-4 mb-1 profile-name">
                                                                Mike Nielsen
                                                            </h6>
                                                            <p class="fs-3 lh-base mb-0 profile-subtext">
                                                                Admin
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                                    aria-labelledby="drop1">
                                                    <div class="profile-dropdown position-relative" data-simplebar>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between pt-3 px-7">
                                                            <h3 class="mb-0 fs-5">User Profile</h3>
                                                            <button type="button" class="border-0 bg-transparent"
                                                                aria-label="Close">
                                                                <iconify-icon icon="solar:close-circle-line-duotone"
                                                                    class="fs-7 text-muted"></iconify-icon>
                                                            </button>
                                                        </div>

                                                        <div class="d-flex align-items-center mx-7 py-9 border-bottom">
                                                            <img src="<?php echo base_url('template/') ?>assets/images/profile/user-1.jpg"
                                                                alt="user" width="90" class="rounded-circle" />
                                                            <div class="ms-4">
                                                                <h4 class="mb-0 fs-5 fw-normal">Mike Nielsen</h4>
                                                                <span class="text-muted">super admin</span>
                                                                <p
                                                                    class="text-muted mb-0 mt-1 d-flex align-items-center">
                                                                    <iconify-icon icon="solar:mailbox-line-duotone"
                                                                        class="fs-4 me-1"></iconify-icon>
                                                                    info@spike.com
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="message-body">
                                                            <a href="<?php echo base_url('template/') ?>dark/page-user-profile.html"
                                                                class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                <span
                                                                    class="btn px-3 py-2 bg-info-subtle rounded-1 text-info shadow-none">
                                                                    <iconify-icon icon="solar:wallet-2-line-duotone"
                                                                        class="fs-7"></iconify-icon>
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">
                                                                        My Profile
                                                                    </h5>
                                                                    <span
                                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">Account
                                                                        Settings</span>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo base_url('template/') ?>dark/app-email.html"
                                                                class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                <span
                                                                    class="btn px-3 py-2 bg-success-subtle rounded-1 text-success shadow-none">
                                                                    <iconify-icon
                                                                        icon="solar:shield-minimalistic-line-duotone"
                                                                        class="fs-7"></iconify-icon>
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">My Inbox</h5>
                                                                    <span
                                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">Messages
                                                                        & Emails</span>
                                                                </div>
                                                            </a>

                                                            <a href="<?php echo base_url('template/') ?>dark/app-notes.html"
                                                                class="dropdown-item px-7 d-flex align-items-center py-6">
                                                                <span
                                                                    class="btn px-3 py-2 bg-danger-subtle rounded-1 text-danger shadow-none">
                                                                    <iconify-icon icon="solar:card-2-line-duotone"
                                                                        class="fs-7"></iconify-icon>
                                                                </span>
                                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                                    <h5 class="mb-0 mt-1 fs-4 fw-normal">My Task</h5>
                                                                    <span
                                                                        class="fs-3 text-nowrap d-block fw-normal mt-1 text-muted">To-do
                                                                        and Daily
                                                                        Tasks</span>
                                                                </div>
                                                            </a>
                                                        </div>

                                                        <div class="py-6 px-7 mb-1">
                                                            <a href="<?php echo base_url('template/') ?>dark/authentication-login.html"
                                                                class="btn btn-primary w-100">Log Out</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- ------------------------------- -->
                                            <!-- end profile Dropdown -->
                                            <!-- ------------------------------- -->
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </header>
                    <!--  Header End -->
                    <?php include($body . '.php'); ?>

                </div>
            </div>
            <script>
                function handleColorTheme(e) {
                    $("html").attr("data-color-theme", e);
                    $(e).prop("checked", !0);
                }
            </script>
            <button
                class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                <i class="icon ti ti-settings fs-7"></i>
            </button>

            <div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                    <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
                        Settings
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body h-n80" data-simplebar>
                    <h6 class="fw-semibold fs-4 mb-2">Theme</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check light-layout" name="theme-layout" id="light-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="light-layout"><i
                                class="icon ti ti-brightness-up fs-7 me-2"></i>Light</label>

                        <input type="radio" class="btn-check dark-layout" name="theme-layout" id="dark-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="dark-layout"><i
                                class="icon ti ti-moon fs-7 me-2"></i>Dark</label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Direction</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="direction-l" id="ltr-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="ltr-layout"><i
                                class="icon ti ti-text-direction-ltr fs-7 me-2"></i>LTR</label>

                        <input type="radio" class="btn-check" name="direction-l" id="rtl-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="rtl-layout"><i
                                class="icon ti ti-text-direction-rtl fs-7 me-2"></i>RTL</label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Theme Colors</h6>

                    <div class="d-flex flex-row flex-wrap gap-3 customizer-box color-pallete" role="group">
                        <input type="radio" class="btn-check" name="color-theme-layout" id="Blue_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Blue_Theme')" for="Blue_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="BLUE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-1">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="Aqua_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Aqua_Theme')" for="Aqua_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="AQUA_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-2">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="Purple_Theme"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Purple_Theme')" for="Purple_Theme" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="PURPLE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-3">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="green-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Green_Theme')" for="green-theme-layout" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="GREEN_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-4">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="cyan-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Cyan_Theme')" for="cyan-theme-layout" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="CYAN_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-5">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>

                        <input type="radio" class="btn-check" name="color-theme-layout" id="orange-theme-layout"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary d-flex align-items-center justify-content-center"
                            onclick="handleColorTheme('Orange_Theme')" for="orange-theme-layout"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ORANGE_THEME">
                            <div
                                class="color-box rounded-circle d-flex align-items-center justify-content-center skin-6">
                                <i class="ti ti-check text-white d-flex icon fs-5"></i>
                            </div>
                        </label>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Layout Type</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <div>
                            <input type="radio" class="btn-check" name="page-layout" id="vertical-layout"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="vertical-layout"><i
                                    class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Vertical</label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check" name="page-layout" id="horizontal-layout"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="horizontal-layout"><i
                                    class="icon ti ti-layout-navbar fs-7 me-2"></i>Horizontal</label>
                        </div>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Container Option</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="layout" id="boxed-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="boxed-layout"><i
                                class="icon ti ti-layout-distribute-vertical fs-7 me-2"></i>Boxed</label>

                        <input type="radio" class="btn-check" name="layout" id="full-layout" autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="full-layout"><i
                                class="icon ti ti-layout-distribute-horizontal fs-7 me-2"></i>Full</label>
                    </div>

                    <h6 class="fw-semibold fs-4 mb-2 mt-5">Sidebar Type</h6>
                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <a href="javascript:void(0)" class="fullsidebar">
                            <input type="radio" class="btn-check" name="sidebar-type" id="full-sidebar"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="full-sidebar"><i
                                    class="icon ti ti-layout-sidebar-right fs-7 me-2"></i>Full</label>
                        </a>
                        <div>
                            <input type="radio" class="btn-check " name="sidebar-type" id="mini-sidebar"
                                autocomplete="off" />
                            <label class="btn p-9 btn-outline-primary" for="mini-sidebar"><i
                                    class="icon ti ti-layout-sidebar fs-7 me-2"></i>Collapse</label>
                        </div>
                    </div>

                    <h6 class="mt-5 fw-semibold fs-4 mb-2">Card With</h6>

                    <div class="d-flex flex-row gap-3 customizer-box" role="group">
                        <input type="radio" class="btn-check" name="card-layout" id="card-with-border"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="card-with-border"><i
                                class="icon ti ti-border-outer fs-7 me-2"></i>Border</label>

                        <input type="radio" class="btn-check" name="card-layout" id="card-without-border"
                            autocomplete="off" />
                        <label class="btn p-9 btn-outline-primary" for="card-without-border"><i
                                class="icon ti ti-border-none fs-7 me-2"></i>Shadow</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="dark-transparent sidebartoggler"></div>
    </div>








    <script src="<?php echo base_url('template/') ?>assets/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <!-- <script src="<?php echo base_url('template/') ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="<?php echo base_url('template/') ?>assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/app.dark.init.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/theme.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/app.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/sidebarmenu.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/feather.min.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/libs/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/extra-libs/jvectormap/jquery-jvectormap-us-aea-en.js">
    </script>
    <script src="<?php echo base_url('template/') ?>assets/js/dashboards/dashboard.js"></script>


    <!-- js alert -->
    <?php if (session()->getFlashdata('sukses')) : ?>
        <script>
            $(document).ready(function() {
                toastr.success(
                    "<?= session()->getFlashdata('sukses'); ?>",
                    "Berhasil!", {
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        progressBar: true,
                        timeOut: 2000
                    }
                );
            });
        </script>
    <?php endif; ?>
    <!-- js alert Ends -->
    <?php if (session()->getFlashdata('gagal')) : ?>
        <script>
            $(document).ready(function() {
                toastr.warning(
                    <?= json_encode(session()->getFlashdata('gagal')) ?>,
                    "Gagal!", {
                        showMethod: "slideDown",
                        hideMethod: "slideUp",
                        progressBar: true,
                        timeOut: 2000
                    }
                );
            });
        </script>
    <?php endif ?>




</body>


<script src="<?php echo base_url('template/assets/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('template/assets/js/datatable/datatable-basic.init.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('template/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') ?>" />
<script src="<?php echo base_url('template/assets/js/plugins/toastr-init.js') ?>"></script>
<script src="<?php echo base_url('template/assets/libs/select2/dist/js/select2.full.min.js') ?>"></script>
<script src="<?php echo base_url('template/assets/libs/select2/dist/js/select2.min.js') ?>"></script>
<script src="<?php echo base_url('template/assets/js/forms/select2.init.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

</html>