<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('template/') ?><?= env('app.logo', 'assets/images/logo.png') ?>" />

    <!-- Core Css -->
    <link rel="stylesheet" href="<?php echo base_url('template/') ?>assets/css/styles.css" />

    <title><?= env('app.name', 'App ERP') ?></title>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="<?php echo base_url('template/') ?>assets/images/logos/loader.svg" alt="loader"
            class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper" class="p-0 bg-white">
        <div
            class="auth-login position-relative overflow-hidden d-flex align-items-center justify-content-center px-7 px-xxl-0 rounded-3 vh-100">
            <div class="auth-login-shape position-relative w-100">
                <div class="auth-login-wrapper card mb-0 container position-relative z-1 h-100" data-simplebar>

                    <div class="card-body">
                        <a href="#" class="">
                            <!-- <img src="<?php echo base_url('template/') ?>assets/images/logo_urban.png"
                                class="dark-logo" alt="Logo-light" /> -->
                        </a>
                        <div class="row align-items-center justify-content-around pt-6 pb-5">
                            <div class="col-lg-6 col-xl-5 d-none d-lg-block">
                                <div class="text-center text-lg-start">
                                    <img src="<?php echo base_url('template/') ?>assets/images/login_art.png" alt=""
                                        class="w-100" /> <!-- w-50 = 50% width -->
                                </div>

                            </div>
                            <div class="col-lg-6 col-xl-5">
                                <h2 class="mb-6 fs-8 fw-bolder">Welcome to <?= env('app.name', 'App ERP') ?></h2>
                                <p class="text-dark fs-4 mb-7">Your Admin Dashboard</p>

                                <form action="<?= base_url('/proses_login') ?>" method="post">
                                    <?php if (session()->getFlashdata('pesan_error')) { ?>
                                        <div class="text-danger mt-2">
                                            <?= session()->getFlashdata('pesan_error') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (session()->getFlashdata('pesan_username')) { ?>
                                        <div class="text-danger mt-2">
                                            <?= session()->getFlashdata('pesan_username') ?>
                                        </div>
                                    <?php } ?>
                                    <div class="mb-7">
                                        <label for="InputUsername" class="form-label text-dark fw-bold">Username</label>
                                        <input type="text" name="username" class="form-control py-6" id="InputUsername"
                                            aria-describedby="emailHelp" />
                                    </div>
                                    <?php if (session()->getFlashdata('pesan_password')) { ?>
                                        <div class="text-danger mt-2">
                                            <?= session()->getFlashdata('pesan_password') ?>
                                        </div>
                                    <?php } ?>
                                    <div class="mb-9">
                                        <label for="exampleInputPassword1"
                                            class="form-label text-dark fw-bold">Password</label>
                                        <input type="password" name="password" class="form-control py-6"
                                            id="exampleInputPassword1" />
                                    </div>
                                    <!-- <div
                                        class="d-flex align-items-center justify-content-between mb-7 pb-1">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input primary"
                                                type="checkbox"
                                                value=""
                                                id="flexCheckChecked"
                                                checked />
                                            <label
                                                class="form-check-label text-dark fs-3"
                                                for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div>
                                        <a
                                            class="text-primary fw-medium fs-3 fw-bold"
                                            href="../dark/authentication-forgot-password.html">Forgot Password ?</a>
                                    </div> -->
                                    <button type="submit" class="btn btn-primary w-100 mb-7 rounded-pill">Sign In</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Import Js Files -->
    <script src="<?php echo base_url('template/') ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/app.dark.init.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/theme.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/app.min.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/sidebarmenu.js"></script>
    <script src="<?php echo base_url('template/') ?>assets/js/theme/feather.min.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>