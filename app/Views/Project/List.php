<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<style>
    .card-header {
        padding: 25px 25px 5px 25px !important;
    }
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
                                <div class="col-2 pb-2">
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
                                <div class="col-2">
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
                                <div class="col-2">
                                    <label class="p-1" for="status"><i class="icofont icofont-social-stack-exchange"></i> Trạng thái dự án</label>
                                    <select class="form-control rounded" name="status" onchange="submitForm()">
                                        <option <?= !empty($status) && 'all'  == $status ? 'selected' : ''  ?> value="all">Toàn bộ</option>
                                        <option <?= !empty($status) && ACTIVE  == $status ? 'selected' : ''  ?> value="<?= ACTIVE ?>"><?= PROJECT_STATUS[ACTIVE] ?></option>
                                        <option <?= !empty($status) && INITIALIZE  == $status ? 'selected' : ''  ?> value="<?= INITIALIZE ?>"><?= PROJECT_STATUS[INITIALIZE] ?></option>
                                        <option <?= !empty($status) && CLOSE  == $status ? 'selected' : ''  ?> value="<?= CLOSE ?>"><?= PROJECT_STATUS[CLOSE] ?></option>
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

                    <div class="col-lg-12">
                        <div class="card border">
                            <?php if (!empty($projects)) : ?>
                                <div class="card-block accordion-block">
                                    <?php foreach ($projects as $project) : ?>
                                        <div id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="accordion-panel" onclick="changeIcon(<?= $project['id'] ?>)">
                                                <div class="accordion-heading" role="tab" id="headingOne">
                                                    <h3 class="card-title accordion-title">
                                                        <!-- class="accordion-msg" -->
                                                        <div class="card shadow-sm border bg-light text-dark m-t-20 m-l-20 m-r-20 m-b-0" style="border-bottom-right-radius: unset;border-bottom-left-radius: unset;" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $project['id'] ?>" aria-expanded="true" aria-controls="collapse-<?= $project['id'] ?>">
                                                            <div class="row m-3">
                                                                <div class="col-auto p-r-0">
                                                                    <div class="u-img">
                                                                        <img src="<?= base_url() . '/imgs/' . $project['photo'] ?>" alt="user image" width="70" height="70" class="img-radius cover-img">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <?php if (CLOSE == $project['status']) : ?>
                                                                        <h6 class="m-b-5" style="text-decoration: line-through;"><b>[<?= $project['prefix'] ?>] <?= $project['name'] ?></b></h6>
                                                                    <?php else : ?>
                                                                        <h6 class="m-b-5" onclick="window.location.href = 'project/<?= $project['id'] ?>'"><b><a class="text-decoration-none">[<?= $project['prefix'] ?>] <?= $project['name'] ?></a></b></h6>
                                                                    <?php endif ?>
                                                                    <p class="text-muted m-b-0"><?= !empty($project['descriptions']) ? $project['descriptions'] : 'Dự án này chưa có mô tả.' ?></p>
                                                                    <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: <?= $project['updated_at'] ?>.</p>
                                                                </div>
                                                                <div class="col-3">
                                                                    <p class="m-b-0"><b>Thành viên:</b> <?= $project['totalUser'] ?></p>
                                                                    <p class="m-b-0"><b>Công việc:</b> <?= $project['totalTask'] ?></p>
                                                                    <p class="m-b-0"><b>Trạng thái:</b> <?= PROJECT_STATUS[$project['status']] ?></p>
                                                                </div>
                                                                <div class="col-1">
                                                                    <?php if (CLOSE == $project['status'] && session()->get('user_id') == $project['owner']) : ?>
                                                                        <div class="dropdown-secondary dropdown d-inline-block f-right">
                                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                <a class="dropdown-item waves-light waves-effect" onclick="restoreProject(<?= $project['id'] ?>)"><i class="icofont icofont-redo"></i> Mở dự án</a>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif ?>
                                                                    <?php if (CLOSE != $project['status'] && session()->get('user_id') == $project['owner']) : ?>
                                                                        <div class="dropdown-secondary dropdown d-inline-block f-right">
                                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                <?php if (INITIALIZE == $project['status']) : ?>
                                                                                    <a class="dropdown-item waves-light waves-effect" onclick="activateProject(<?= $project['id'] ?>)"><i class="icofont icofont-caret-right "></i> Kích hoạt dự án</a>
                                                                                <?php endif ?>
                                                                                <a class="dropdown-item waves-light waves-effect" onclick="closeProject(<?= $project['id'] ?>)"><i class="icofont icofont-close-line"></i> Đóng dự án</a>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif ?>
                                                                </div>
                                                                <div class="justify-content-center d-flex" style="height: 15px;" id="show-project-<?= $project['id'] ?>">
                                                                    <i class="icofont icofont-curved-down"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </h3>
                                                </div>
                                                <div id="collapse-<?= $project['id'] ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="accordion-content accordion-desc">
                                                        <div class="card border" style="border-top: none !important;border-top-left-radius: unset;border-top-right-radius: unset;">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">Thành viên trong dự án</h5>
                                                            </div>
                                                            <div class="card-block">
                                                                <ul class="media-list mt-3">
                                                                    <?php foreach ($project['users'] as $user) : ?>
                                                                        <hr>
                                                                        <li class="media d-flex">
                                                                            <div class="media-left">
                                                                                <a href="#">
                                                                                    <img class="media-object img-radius comment-img" src="<?= base_url("imgs/{$user['photo']}") ?>" alt="Generic placeholder image">
                                                                                </a>
                                                                            </div>
                                                                            <div class="media-body w-100">
                                                                                <a href="#" class="text-decoration-none">
                                                                                    <h6 class="media-heading txt-primary"><?= $user['username'] ?> <span class="f-12 text-muted m-l-5 <?= $user['role'] ?>-role"><?= PROJECT_ROLE[$user['role']] ?></span></h6>
                                                                                </a>
                                                                                <p class="text-truncate"><?= $user['email'] ?></p>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                    <div class="m-20">
                                        <?= !empty($pager) ? $pager->links('default', 'default') : '' ?>
                                    </div>
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
                    </div>
                </div>
            </div>
            <!-- Left column end -->
        </div>
    </div>
    <!-- Page body end -->
</div>
</div>
<!-- Main-body end -->
<script>
    var changeIconDirectionUp = true

    function changeIcon(id) {
        direction = document.getElementById(`show-project-${id}`)
        if (changeIconDirectionUp) {
            direction.innerHTML = '<i class="icofont icofont-curved-up"></i>'
            changeIconDirectionUp = false
            return
        }

        direction.innerHTML = '<i class="icofont icofont-curved-down"></i>'
        changeIconDirectionUp = true
        return
    }

    function submitForm() {
        var form = document.getElementById('filter')
        form.submit()
    }

    function afterInput() {
        delay(function() {
            var form = document.getElementById('filter')
            form.submit()
        }, 1500)
    }

    var delay = (function() {
        var timer = 0
        return function(callback, ms) {
            clearTimeout(timer)
            timer = setTimeout(callback, ms)
        }
    })()

    function restoreProject(id) {
        const data = new FormData()
        data.append('project_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch(`project/${id}/re-open`, requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    error = result.errors.project_id
                    if (error) {
                        error = error.replace('section', 'Dự án')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                    }

                    setTimeout(() => {
                        // isChangeTaskStatusAlreadyClick = false
                        // dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Đã mở dự án!"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!'
                });
                // isChangeTaskStatusAlreadyClick = false
                // dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }

    function activateProject(id) {
        const data = new FormData()
        data.append('project_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch(`project/${id}/activate`, requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    error = result.errors.project_id
                    if (error) {
                        error = error.replace('section', 'Dự án')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                    }

                    setTimeout(() => {
                        // isChangeTaskStatusAlreadyClick = false
                        // dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Đã kích hoạt dự án!"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!'
                });
                // isChangeTaskStatusAlreadyClick = false
                // dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }

    function closeProject(id) {
        const data = new FormData()
        data.append('project_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch(`project/${id}/close`, requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    error = result.errors.project_id
                    if (error) {
                        error = error.replace('section', 'Dự án')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                    }

                    setTimeout(() => {
                        // isChangeTaskStatusAlreadyClick = false
                        // dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Đã đóng dự án!"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!'
                });
                // isChangeTaskStatusAlreadyClick = false
                // dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }
</script>
<?= $this->endSection() ?>