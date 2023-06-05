<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">

        <div class="navbar-logo">
            <a href="<?= base_url() ?>">
                <img class="img-fluid" src="<?= base_url() ?>\templates\libraries\assets\images\logo.png" alt="Theme-Logo">
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li class="">
                    <a href="" class="btn ">Tạo mới dự án</a>
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
                            <li>
                                <a href="<?= base_url('user-infomation') ?>">
                                    <i class="feather icon-user"></i> Thông tin
                                </a>
                            </li>
                            <a href="<?= base_url('auth/logout') ?>">
                                <li>
                                    <i class="feather icon-log-out"></i> Đăng xuất
                                </li>
                            </a>
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