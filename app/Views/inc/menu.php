<?php
// if (session()->get('logged_in') == false) {
//     header("Location:" . base_url('login'));
// }

use App\Models\Core;

$MCore = new Core();
$menu_utama = $MCore->get_menu_show();
$role = $MCore->get_role();
$menu_aktif = false;
?>
<nav class="top-nav">
    <ul>
        <?php foreach ($menu_utama as $mymenu) :
            $menu_aktif = false; ?>
            <?php if (in_array($mymenu['id'], $role)) : ?>
                <?php if (sizeof($mymenu['menu']) <= 0) :
                    if (base_url() . $mymenu['url'] == service('uri')) $menu_aktif = true;
                ?>
                    <li>
                        <a href="<?= base_url() . $mymenu['url'] ?>" class="top-menu <?= $m = ($menu_aktif) ? "top-menu--active" : ""; ?>">
                            <div class="top-menu__icon"><?= $mymenu['icon'] ?></div>
                            <div class="top-menu__title"><?= $mymenu['nama'] ?></div>
                        </a>
                    </li>
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
                    <li>
                        <a href="javascript:;" class="top-menu <?= $m = ($menu_aktif) ? "top-menu--active" : ""; ?>">
                            <div class="top-menu__icon"><?= $icon = ($mymenu['icon'] != null) ? $mymenu['icon'] : '<i class="fa fa-arrow-right"></i>'; ?></div>
                            <div class="top-menu__title"> <?= $mymenu['nama'] ?> <i data-lucide="chevron-down" class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            <?php foreach ($mymenu['menu'] as $menu) : ?>
                                <?php if (in_array($menu['id'], $role)) : ?>
                                    <?php if (sizeof($menu['sub']) <= 0) : ?>
                                        <li>
                                            <a href="<?= base_url() . $menu['url'] ?>" class="top-menu">
                                                <div class="top-menu__icon"><?= $icon = ($menu['icon'] != null) ? $menu['icon'] : '<i class="fa fa-arrow-right"></i>'; ?></div>
                                                <div class="top-menu__title"> <?= $menu['nama'] ?> </div>
                                            </a>
                                        </li>
                                    <?php else : ?>
                                        <li>
                                            <a href="javascript:;" class="top-menu">
                                                <div class="top-menu__icon"><?= $icon = ($menu['icon'] != null) ? $menu['icon'] : '<i class="fa fa-arrow-right"></i>'; ?></div>
                                                <div class="top-menu__title"> <?= $menu['nama'] ?> <i data-lucide="chevron-down" class="top-menu__sub-icon"></i> </div>
                                            </a>
                                            <ul class="">
                                                <?php foreach ($menu['sub'] as $sub_menu) : ?>
                                                    <?php if (in_array($sub_menu['id'], $role)) : ?>
                                                        <li>
                                                            <a href="<?= base_url() . $sub_menu['url'] ?>" class="top-menu">
                                                                <div class="top-menu__icon"><?= $icon = ($sub_menu['icon'] != null) ? $sub_menu['icon'] : '<i class="fa fa-caret-right"></i>'; ?></div>
                                                                <div class="top-menu__title"><?= $sub_menu['nama'] ?></div>
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