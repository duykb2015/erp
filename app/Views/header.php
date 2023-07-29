<nav class="navbar header-navbar pcoded-header" header-theme="theme5">
    <div class="navbar-wrapper">
        <div class="navbar-logo" logo-theme="theme5">
            <a href="<?= base_url() ?>">
                <img class="img-fluid" src="<?= base_url() ?>\templates\libraries\assets\images\logo.png" alt="Theme-Logo">
            </a>
            <?php if (url_is('project/*')) : ?>
                <a class="mobile-menu text-decoration-none" id="mobile-collapse">
                    <i class="feather icon-menu"></i>
                </a>
            <?php endif ?>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle <?= url_is('/') ? 'nav-active' : '' ?>"> <!-- data-toggle="dropdown" -->
                            <div class="hover px-2" onclick="redirect_url('/')">
                                <span>Trang chủ</span>
                                <!-- <i class="feather icon-chevron-down"></i> -->
                            </div>
                        </div>
                        <!-- <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li class="nav-item dropdown" onclick="redirect_url('/')">
                                <div class="media">
                                    <a class="text-decoration-none d-flex">
                                        Đi đến không gian làm việc
                                    </a>
                                </div>
                            </li>
                        </ul> -->
                    </div>
                </li>
                <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle <?= url_is('/project*') ? 'nav-active' : '' ?>" data-toggle="dropdown">
                            <div class="hover px-2">
                                <span>Dự án</span>
                                <i class="feather icon-chevron-down"></i>
                            </div>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li class="nav-item dropdown" onclick="redirect_url('/project')">
                                <div class="media">
                                    <a class="text-decoration-none d-flex">
                                        Danh sách dự án
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown" style="display: <?= url_is('/project*') ? 'none' : 'block' ?>;" data-bs-toggle="modal" data-bs-target="#createNewProject" data-bs-whatever="@mdo">
                                <div class="media">
                                    <a class="text-decoration-none d-flex">
                                        Tạo dự án mới
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php if (ADMIN == session()->get('type')) : ?>
                    <li class="header-notification">
                        <div class="dropdown-primary dropdown">
                            <div class="dropdown-toggle <?= url_is('/user-management*') ? 'nav-active' : '' ?>" > <!-- data-toggle="dropdown" -->
                                <div class="hover px-2" onclick="redirect_url('/user-management')">
                                    <span>Thành viên</span>
                                    <!-- <i class="feather icon-chevron-down"></i> -->
                                </div>
                            </div>
                            <!-- <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <li class="nav-item dropdown" onclick="redirect_url('/user-management')">
                                    <div class="media">
                                        <a class="text-decoration-none d-flex">
                                            Danh sách thành viên
                                        </a>
                                    </div>
                                </li>
                            </ul> -->
                        </div>
                    </li>
                <?php endif ?>
                <?php if (url_is('/') || url_is('/project')) : ?>
                    <li class="header-notification">
                        <div class="hover px-2">
                            <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#createNewProject">Tạo mới dự án</button>
                        </div>
                    </li>
                <?php endif ?>

                <?php if (url_is('project/' . (isset($project['prefix']) ? $project['prefix'] : 0))) : ?>
                    <li class="header-notification">
                        <div class="hover px-2">
                            <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#createNewTask">Tạo mới công việc</button>
                        </div>
                    </li>
                <?php endif ?>
            </ul>

            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= !empty(session()->get('avatar')) ? base_url() . 'imgs/' . session()->get('avatar') : base_url() . '\templates\libraries\assets\images\avatar-4.jpg' ?>" class="img-radius" alt="User-Profile-Image">
                            <span><?= session()->get('name') ?></span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li onclick="redirect_url('/user')">
                                <a class="text-decoration-none">
                                    <i class="feather icon-user"></i> Thông tin cá nhân
                                </a>
                            </li>
                            <li onclick="redirect_url('/auth/logout')">
                                <a class="text-decoration-none">
                                    <i class="feather icon-log-out"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="header-notification">
                    <div class="dropdown-primary dropdown someyourContainer">
                        <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="feather icon-bell"></i>
                            <?php if (!empty($totalNotification)) : ?>
                                <span class="badge bg-c-pink"><?= $totalNotification ?></span>
                            <?php endif ?>
                        </div>
                        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <h6>Thông báo</h6>
                                <?php if (!empty($notifications)) : ?>
                                    <span class="f-right">
                                        <a onclick="markAllAsRead([<?= collect($notifications)->implode('id', ',') ?>])">Đánh dấu tất cả là đã đọc</a>
                                    </span>
                                <?php endif ?>
                            </li>
                            <?php if (!empty($notifications)) : ?>
                                <?php foreach ($notifications as $notify) : ?>
                                    <li>
                                        <div class="media d-flex">
                                            <div class="media-left">
                                                <img class="d-flex align-self-center img-radius" src="<?= base_url("imgs/{$notify['photo']}") ?>" alt="Generic placeholder image">
                                            </div>
                                            <div class="media-body">
                                                <h5 class="notification-user"><?= $notify['title'] ?></h5>
                                                <p class="notification-msg"><?= $notify['message'] ?></p>
                                                <span class="notification-time"><?= $notify['created_at'] ?></span>
                                            </div>
                                            <div class="media-right">
                                                <label class="label label-primary">Mới</label>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            <?php else : ?>
                                <li>
                                    <div class="media d-flex">
                                        <div class="media-body">
                                            <p class="notification-msg">Hiện không có thông báo nào.</p>
                                        </div>
                                    </div>
                                </li>
                            <?php endif ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>