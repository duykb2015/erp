<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<style>
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- <div class="pcoded-content"> -->
<!-- <div class="pcoded-inner-content"> -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Không gian làm việc</h4>
                            <span>Tổng hợp mọi thứ bạn làm việc ở đây.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body ">
            <div class="col-sm-12">
                <!-- Panel card start -->
                <div class="card border">
                    <div class="card-header">
                        <h5 class="card-header-text">Các dự án gần đây</h5>
                        <?php if (!empty($projects)) : ?>
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item"><a href="<?= base_url('project') ?>">Xem toàn bộ các dự án</a></li>
                                </ul>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="card-block panels-wells">
                        <div class="row">
                            <?php if (!empty($projects)) : ?>
                                <?php foreach ($projects as $project) : ?>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                        <div class="card shadow border bg-light text-dark">
                                            <div class="row m-3">
                                                <div class="col-2 p-r-0">
                                                    <div class="u-img">
                                                        <img src="<?= base_url() . '/imgs/' . $project['photo'] ?>" width="50" height="50" alt="user image" class="img-radius cover-img">
                                                    </div>
                                                </div>
                                                <div class="col-10 d-inline-block text-truncate">
                                                    <h6 class="m-b-5"><a href="<?= base_url('project') . '/' . $project['id'] ?>" class="text-decoration-none">[<?= $project['key'] ?>] <?= $project['name'] ?></a></h6>
                                                    <p class="text-muted m-b-0"><?= !empty($project['descriptions']) ? $project['descriptions'] : 'Dự án này chưa có mô tả.' ?></p>
                                                    <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: <?= $project['updated_at'] ?>.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <div class="col-12 d-inline-block text-truncate">
                                    <h6 class="m-b-5 justify-content-center">Hiện không có dự án nào.</h6>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <!-- Panel card end -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card user-activity-card border">
                        <?php if (!empty($projectss)) : ?>
                            <div class="card-header">
                                <h5 class="card-header-text">Công việc đang thực hiện</h5>
                                <div class="sub-title">Đang thực hiện</div>
                            </div>
                            <div class="card-block">
                                <?php foreach ($projects as $project) : ?>
                                    <div class="card z-depth-bottom-2">
                                        <div class="row m-3">
                                            <div class="col-auto p-r-0">
                                                <div class="u-img">
                                                    <img src="<?= base_url() . '/imgs/' . $project['photo'] ?>" alt="user image" class="img-radius cover-img">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h6 class="m-b-5"><a href="<?= base_url('project') . '/' . $project['id'] ?>" class="text-decoration-none">[<?= $project['key'] ?>] <?= $project['name'] ?></a></h6>
                                                <p class="text-muted m-b-0"><?= $project['descriptions'] ?></p>
                                                <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: <?= $project['updated_at'] ?>.</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else : ?>
                            <div class="card-header rounded text-center">
                                <h5 class="card-header-text ">Hiện tại bạn không có công việc nào!</h5>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<?= $this->endSection() ?>