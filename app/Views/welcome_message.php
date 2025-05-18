<section class="welcome">
    <div class="row">
        <div class="col-lg-12 col-xl-6 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body position-relative">
                    <div>
                        <h5 class="mb-1 fw-bold">Welcome <?= session()->get('NAMA') ?></h5>
                        <p class="fs-3 mb-3 pb-1">Lokasi : <?= session()->get('NAMA_UNIT') ?></p>
                        <button class="btn btn-primary rounded-pill" type="button">
                            Visit Now
                        </button>
                    </div>
                    <div class="school-img d-none d-sm-block">
                        <img src="<?= base_url('template/') ?>assets/images/backgrounds/school.png" class="img-fluid" alt="" />
                    </div>

                    <div class="d-sm-none d-block text-center">
                        <img src="<?= base_url('template/') ?>assets/images/backgrounds/school.png" class="img-fluid" alt="" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xl-6">
            <div class="row">
                <div class="col-sm-4 d-flex align-items-strech">
                    <div class="card warning-card overflow-hidden text-bg-primary w-100">
                        <div class="card-body p-4">
                            <div class="mb-7">
                                <i class="ti ti-brand-producthunt fs-8 fw-lighter"></i>
                            </div>
                            <h5 class="text-white fw-bold fs-14 text-nowrap">
                                2358 <span class="fs-2 fw-light">+23%</span>
                            </h5>
                            <p class="opacity-50 mb-0 ">Sales</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 d-flex align-items-strech">
                    <div class="card danger-card overflow-hidden text-bg-primary w-100">
                        <div class="card-body p-4">
                            <div class="mb-7">
                                <i class="ti ti-report-money fs-8 fw-lighter"></i>
                            </div>
                            <h5 class="text-white fw-bold fs-14">
                                356 <span class="fs-2 fw-light">+8%</span>
                            </h5>
                            <p class="opacity-50 mb-0">Refunds</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 d-flex align-items-strech">
                    <div class="card info-card overflow-hidden text-bg-primary w-100">
                        <div class="card-body p-4">
                            <div class="mb-7">
                                <i class="ti ti-currency-dollar fs-8 fw-lighter"></i>
                            </div>
                            <h5 class="text-white fw-bold fs-14 text-nowrap">
                                $235.8K <span class="fs-2 fw-light">-3%</span>
                            </h5>
                            <p class="opacity-50 mb-0">Earnings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>