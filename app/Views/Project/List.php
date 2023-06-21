<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<style>
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Danh sách dự án</h4>
                            <span>Danh sách các dự án mà bạn đang tham gia sẽ được hiện ở đây.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <!-- Page body start -->
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 pull-xl-12 filter-bar">
                    <!-- Nav Filter tab start -->
                    <nav class="navbar navbar-light m-b-30 p-10 ">
                        <form class="form-material w-100" action="" id="filter" method="GET">
                            <div class="row">
                                <div class="col-3 pb-2">
                                    <label class="p-1" for="dim"><i class="icofont icofont-filter"></i> Thời gian</label>
                                    <select class="form-control rounded" name="dim" onchange="submitForm()">
                                        <optgroup label="Lọc theo">
                                            <option <?= empty($dim) ? 'selected' : '' ?> value="">Toàn bộ</option>
                                        </optgroup>
                                        <optgroup label="Lọc theo">
                                            <option <?= !empty($dim) && 'today' == $dim      ? 'selected' : ''  ?> value="today">Ngày hôm nay</option>
                                            <option <?= !empty($dim) && 'yesterday' == $dim  ? 'selected' : ''  ?> value="yesterday">Ngày hôm qua</option>
                                            <option <?= !empty($dim) && 'this_week' == $dim  ? 'selected' : ''  ?> value="this_week">Tuần này</option>
                                            <option <?= !empty($dim) && 'this_month' == $dim ? 'selected' : ''  ?> value="this_month">Tháng này</option>
                                            <option <?= !empty($dim) && 'this_year' == $dim  ? 'selected' : ''  ?> value="this_year">Năm nay</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="p-1" for="sort"><i class="icofont icofont-sort-alt"></i> Sắp xếp</label>
                                    <select class="form-control rounded" name="sort" onchange="submitForm()">
                                        <optgroup label="Sắp xếp theo">
                                            <option <?= empty($sort) ? 'selected' : '' ?> value="">Mặc định</option>
                                        </optgroup>
                                        <optgroup label="Sắp xếp theo">
                                            <option <?= !empty($sort) && 'latest' == $sort ? 'selected' : ''  ?> value="latest">Mới nhất</option>
                                            <option <?= !empty($sort) && 'oldest' == $sort ? 'selected' : ''  ?> value="oldest">Cũ nhất</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-3 pb-2">
                                    <label class="p-1" for="name"><i class="icofont icofont-pencil-alt-5"></i> Tên dự án</label>
                                    <input type="text" class="form-control rounded" value="<?= $name ?? '' ?>" name="name" onkeyup="afterInput()" placeholder="Nhập tên dự án...">
                                </div>
                                <div class="col-2">
                                    <label class="p-1" for="sort"><i class="icofont icofont-social-stack-exchange"></i> Hiển thị</label>
                                    <select class="form-control rounded" name="limit" onchange="submitForm()">
                                        <option <?= !empty($limit) && 10  == $limit ? 'selected' : ''  ?> value="10">10</option>
                                        <option <?= !empty($limit) && 25  == $limit ? 'selected' : ''  ?> value="25">25</option>
                                        <option <?= !empty($limit) && 50  == $limit ? 'selected' : ''  ?> value="50">50</option>
                                        <option <?= !empty($limit) && 100 == $limit ? 'selected' : ''  ?> value="100">100</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label class="p-1">&nbsp;</label>
                                    <a href="<?= base_url('project') ?>" class="text-decoration-none text-center form-control rounded">Xoá bộ lọc</a>
                                </div>
                            </div>
                        </form>
                    </nav>
                    <!-- Nav Filter tab end -->
                    <!-- Task board design block start-->
                    <div class="card border">
                        <?php if (!empty($projects)) : ?>
                            <div class="card-block">
                                <?php foreach ($projects as $project) : ?>
                                    <div class="card shadow-sm border bg-light text-dark">
                                        <div class="row m-3">
                                            <div class="col-auto p-r-0">
                                                <div class="u-img">
                                                    <img src="<?= base_url() . '/imgs/' . $project['photo'] ?>" alt="user image" width="70" height="70" class="img-radius cover-img">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h6 class="m-b-5"><a href="<?= base_url('project') . '/' . $project['id'] ?>" class="text-decoration-none">[<?= $project['key'] ?>] <?= $project['name'] ?></a></h6>
                                                <p class="text-muted m-b-0"><?= !empty($project['descriptions']) ? $project['descriptions'] : 'Dự án này chưa có mô tả.' ?></p>
                                                <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: <?= $project['updated_at'] ?>.</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>

                                <?= !empty($pager) ? $pager->links('default', 'default') : '' ?>
                            </div>
                        <?php else : ?>
                            <div class="card-header">
                                <?php if (empty($dim)) : ?>
                                    <div class="text-center"><span>Hiện tại không có dự án nào. </span><a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#createNewProject" data-bs-whatever="@mdo">Tạo mới!</a></div>
                                <?php else :  ?>
                                    <div class="text-center"><span>Không có dự án nào trong khoảng thời gian này</div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <!-- Task board design block end -->
                </div>
                <!-- Left column end -->
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
<!-- Main-body end -->
<script>
    function submitForm() {
        var form = document.getElementById('filter');
        form.submit();
    }

    function afterInput() {
        delay(function() {
            var form = document.getElementById('filter');
            form.submit();
        }, 1500);
    }

    var delay = (function() {
        var timer = 0;
        return function(callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();
</script>
<?= $this->endSection() ?>