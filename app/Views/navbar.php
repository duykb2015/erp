<?php
$menu = [
    [
        'url' => base_url('project') . '/' . $project['id'],
        'active' => 'project/' . $project['id'],
        'name' => 'Tổng quan dự án',
        'icon' => '<i class="feather icon-home"></i>',
    ],
    [
        'url' => base_url('project') . '/' . $project['id'] . '/user',
        'active' => 'project/*/user',
        'name' => 'Quản lý thành viên',
        'icon' => '<i class="feather icon-user"></i>',
    ],
    [
        'url' => base_url('project') . '/' . $project['id'] . '/setting',
        'name' => 'Cài đặt dự án',
        'active' => 'project/*/setting',
        'icon' => '<i class="fa fa-gear"></i>',
    ],
];
?>

<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Bảng điều khiển</div>
        <ul class="pcoded-item pcoded-left-item">
            <?php foreach ($menu as $row) : ?>
                <?php $classActive = url_is($row['active']) ? ' pcoded-trigger' : '' ?>
                <li class="<?= !empty($row['url']) ? '' : 'pcoded-hasmenu' ?> <?= $classActive ?>">
                    <a href="<?= !empty($row['url']) ? $row['url'] : 'javascript:void(0)' ?>">
                        <span class="pcoded-micon"><?= $row['icon'] ?></span>
                        <span class="pcoded-mtext"><?= $row['name'] ?></span>
                    </a>
                    <?php if (!empty($row['sub_menu'])) : ?>
                        <ul class="pcoded-submenu">
                            <?php foreach ($row['sub_menu'] as $sub) : ?>
                                <?php if (!empty($sub['sub_menu'])) : ?>
                                    <?php $subClassActive = url_is($sub['active'] . '*') ? ' pcoded-trigger' : '' ?>
                                    <li class="pcoded-hasmenu <?= $subClassActive ?>">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-mtext"><?= $sub['name'] ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <?php foreach ($sub['sub_menu'] as $val) : ?>
                                                <li class="<?= url_is(str_replace(base_url(), '', $val['url'])) ? 'active' : '' ?>">
                                                    <a href="<?= $val['url'] ?>">
                                                        <span class="pcoded-mtext"><?= $val['name'] ?></span>
                                                    </a>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                    </li>
                                <?php else : ?>
                                    <li class="<?= url_is(str_replace(base_url(), '', $sub['url'])) ? 'active' : '' ?>">
                                        <a href="<?= $sub['url'] ?>">
                                            <span class="pcoded-mtext"><?= $sub['name'] ?></span>
                                        </a>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</nav>