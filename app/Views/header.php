<nav class="navbar header-navbar pcoded-header" header-theme="theme5">
    <div class="navbar-wrapper">
        <div class="navbar-logo" logo-theme="theme5">
            <a href="<?= base_url() ?>">
                <img class="img-fluid" src="<?= base_url() ?>\templates\libraries\assets\images\logo.png" alt="Theme-Logo">
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle <?= url_is('/') ? 'nav-active' : '' ?>" data-toggle="dropdown">
                            <div class="hover px-2">
                                <span>Không gian làm việc</span>
                                <i class="feather icon-chevron-down"></i>
                            </div>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li class="nav-item dropdown" onclick="redirect_url('/')">
                                <div class="media">
                                    <a class="text-decoration-none d-flex">
                                        Đi đến không gian làm việc
                                    </a>
                                </div>
                            </li>
                        </ul>
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
                            <li class="nav-item dropdown" data-bs-toggle="modal" data-bs-target="#createNewProject" data-bs-whatever="@mdo">
                                <div class="media">
                                    <a class="text-decoration-none d-flex">
                                        Tạo dự án mới
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <ul class="nav-right">
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
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
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="feather icon-bell"></i>
                            <span class="badge bg-c-pink">5</span>
                        </div>
                        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <h6>Notifications</h6>
                                <label class="label label-danger">New</label>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center img-radius" src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">John Doe</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center img-radius" src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">Joseph William</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="media">
                                    <img class="d-flex align-self-center img-radius" src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <h5 class="notification-user">Sara Soudein</h5>
                                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                        <span class="notification-time">30 minutes ago</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>