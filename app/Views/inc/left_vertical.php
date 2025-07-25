<aside class="left-sidebar with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="brand-logo d-flex justify-content-center align-items-center py-3">
        <h2 style="text-align: center; margin-top: 2px;"><?= session()->get('NAMA_UNIT'); ?></h2>
        <a href="<?php echo base_url('template/') ?>dark/index.html" class="text-nowrap logo-img">
            <img src="<?php echo base_url('template/') ?>assets/images/logo_urban.png" class="dark-logo w-100 h-auto"
                alt="Logo-Dark" />
            <img src="<?php echo base_url('template/') ?>assets/images/logo_urban.png" class="light-logo w-100 h-auto"
                alt="Logo-light" />
        </a>
        <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
        </a>
    </div>

    <div class="scroll-sidebar" data-simplebar>
        <?php
        if (session()->get('logged_in') == false) {
            header("Location:" . base_url('login'));
        }

        use App\Models\Core;

        $MCore = new Core();
        $menu_utama = $MCore->get_menu_show();
        $role = $MCore->get_role();
        $menu_aktif = false;
        ?>
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">
                <?php foreach ($menu_utama as $mymenu) :
                    $menu_aktif = false; ?>
                    <?php if (in_array($mymenu['id'], $role)) : ?>
                        <?php if (sizeof($mymenu['menu']) <= 0) : ?>
                            <?php if (base_url() . $mymenu['url'] == service('uri')) $menu_aktif = true; ?>
                            <?php if ($mymenu['utama'] == 0) : ?>
                                <li class="nav-small-cap">
                                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                                    <span class="hide-menu"><?= $mymenu['nama'] ?></span>
                                </li>
                            <?php else: ?>
                                <li class="sidebar-item">
                                    <a class="sidebar-link sidebar-link primary-hover-bg" href="<?= base_url() . $mymenu['url'] ?>" aria-expanded="false">
                                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                                            <?= $mymenu['icon'] ?>
                                            <!-- <iconify-icon icon="solar:screencast-2-line-duotone" class="fs-6"></iconify-icon> -->
                                        </span>
                                        <span class="hide-menu ps-1"><?= $mymenu['nama'] ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php else :
                            $uri = service('uri');
                            foreach ($mymenu['menu'] as $menu) :
                                if (in_array($menu['id'], $role)) :
                                    if ($menu['role'] == $uri->getSegment(1)) $menu_aktif = true;
                                endif;
                                foreach ($menu['sub'] as $sub_menu) :
                                    if (in_array($sub_menu['id'], $role)) :
                                        if ($menu['role'] == $uri->getSegment(1)) $menu_aktif = true;
                                    endif;
                                endforeach;
                            endforeach;
                        ?>
                            <?php if ($mymenu['utama'] == 0) : ?>
                                <li class="nav-small-cap">
                                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                                    <span class="hide-menu"><?= $mymenu['nama'] ?></span>
                                </li>
                            <?php endif; ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link has-arrow success-hover-bg" href="#" aria-expanded="false">
                                    <span class="aside-icon p-2 bg-success-subtle rounded-1">
                                        <?= $icon = ($mymenu['icon'] != null) ? $mymenu['icon'] : '<iconify-icon icon="solar:smart-speaker-minimalistic-line-duotone" class="fs-6"></iconify-icon>'; ?>
                                    </span>
                                    <span class="hide-menu ps-1"><?= $mymenu['nama'] ?></span>
                                </a>
                                <ul aria-expanded="false" class="collapse first-level">
                                    <?php foreach ($mymenu['menu'] as $menu) : ?>
                                        <?php if (in_array($menu['id'], $role)) : ?>
                                            <?php if (sizeof($menu['sub']) <= 0) : ?>
                                                <li class="sidebar-item">
                                                    <a href="<?= base_url() . $menu['url'] ?>" class="sidebar-link">
                                                        <span
                                                            class="sidebar-icon"><?= $icon = ($menu['icon'] != null) ? $menu['icon'] : ''; ?></span>
                                                        <span class="hide-menu"> <?= $menu['nama'] ?></span>
                                                    </a>
                                                </li>
                                            <?php else : ?>
                                                <li class="sidebar-item">
                                                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                                                        <span
                                                            class="sidebar-icon"><?= $icon = ($menu['icon'] != null) ? $menu['icon'] : ''; ?></span>
                                                        <span class="hide-menu"> <?= $menu['nama'] ?> </span>
                                                    </a>
                                                    <ul aria-expanded="false" class="collapse two-level">
                                                        <?php foreach ($menu['sub'] as $sub_menu) : ?>
                                                            <?php if (in_array($sub_menu['id'], $role)) : ?>
                                                                <li class="sidebar-item">
                                                                    <a href="<?= base_url() . $sub_menu['url'] ?>" class="sidebar-link">
                                                                        <span
                                                                            class="sidebar-icon"><?= $icon = ($sub_menu['icon'] != null) ? $sub_menu['icon'] : ''; ?></span>
                                                                        <span class="hide-menu"><?= $sub_menu['nama'] ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

            </ul>
        </nav>

        <div class=" fixed-profile mx-3 mt-3">
            <div class="card bg-primary-subtle mb-0 shadow-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="<?php echo base_url('template/') ?>assets/images/profile/user-1.jpg" width="45"
                                height="45" class="img-fluid rounded-circle" alt="" />
                            <div>
                                <h5 class="mb-1"><?php echo session('NAMA') ?></h5>
                                <p class="mb-0"><?php echo session('NAMA_JABATAN') ?></p>
                            </div>
                        </div>
                        <a href="<?php echo base_url('Logout') ?>"
                            class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Logout">
                            <iconify-icon icon="solar:logout-line-duotone" class="fs-8"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
</aside>