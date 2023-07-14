<?php

$menu = [
    [
        'url' => base_url('project') . '/' . $project['id'],
        'active' => 'project/' . $project['id'],
        'name' => 'Tổng quan dự án',
        'icon' => '<i class="feather icon-home"></i>',
        'sub_menu' => [
            'url' => 'project/' . $project['id'] . '/task/' . (!empty($task['id']) ? $task['id'] : ''),
            'name' => 'Chi tiết công việc',
        ],
        'role' => [MEMBER, LEADER, OWNER]
    ],
    [
        'url' => base_url('project') . '/' . $project['id'] . '/statistic',
        'active' => 'project/*/statistic',
        'name' => 'Thống kê số liệu',
        'icon' => '<i class="feather icon-user"></i>',
        'role' => [MEMBER, LEADER, OWNER]
    ],
    [
        'url' => base_url('project') . '/' . $project['id'] . '/user',
        'active' => 'project/*/user',
        'name' => 'Quản lý thành viên',
        'icon' => '<i class="feather icon-user"></i>',
        'role' => [MEMBER, LEADER, OWNER]
    ],
    [
        'url' => base_url('project') . '/' . $project['id'] . '/setting',
        'name' => 'Cài đặt dự án',
        'active' => 'project/*/setting',
        'icon' => '<i class="fa fa-gear"></i>',
        'role' => [OWNER]
    ],
];
?>

<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Bảng điều khiển</div>
        <ul class="pcoded-item pcoded-left-item">
            <?php foreach ($menu as $row) : ?>
                <?php $classActive = url_is($row['active']) ? ' pcoded-trigger active active-enable-color' : '' ?>
                <?php if (in_array($userRole, $row['role'])) : ?>
                    <li class="<?= $classActive ?> ">
                        <a href="<?= $row['url'] ?>">
                            <span class="pcoded-micon"><?= $row['icon'] ?></span>
                            <span class="pcoded-mtext"><?= $row['name'] ?></span>
                        </a>
                        <?php if (!empty($row['sub_menu']) && url_is($row['sub_menu']['url'] . '*')) : ?>
                            <ul class="pcoded-submenu">
                                <li class="active">
                                    <a href="<?= $row['sub_menu']['url'] ?>">
                                        <span class="pcoded-mtext"><?= $row['sub_menu']['name'] ?></span>
                                    </a>
                                </li>
                            </ul>
                        <?php endif ?>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
    </div>
</nav>