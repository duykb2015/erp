<?= $this->extend('layout') ?>

<?= $this->section('css') ?>

<!-- Switch component css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\bower_components\switchery\css\switchery.min.css">
<!-- swiper css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\bower_components\swiper\css\swiper.min.css">
<style>
    .breadcrumb-title div {
        display: inline;
    }

    .scroll-y {
        overflow-y: auto;
        height: 80vh;
    }

    .scroll-y>.card>* {
        display: block;
        float: none;
    }

    #editorContainer {
        width: 50.5vw;
    }
</style>
<?= $this->endSection() ?>

<?php $currentUser = session()->get('user_id') ?>

<?= $this->section('content') ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Chi tiết công việc</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <div class="breadcrumb-title">
                                    <div>
                                        <a href="/" class="text-decoration-none"><i class="feather icon-home"></i></a>
                                    </div>
                                    /
                                    <div>
                                        <a href="<?= base_url('project') ?>" class="text-decoration-none">Dự án</a>
                                    </div>
                                    /
                                    <div>
                                        <a href="<?= base_url('project/') . $project['id'] ?>" class="text-decoration-none">Chi tiết dự án</a>
                                    </div>
                                    /
                                    <div>
                                        <a href="<?= base_url('//task/') . $task['id'] ?>" class="text-decoration-none">Chi tiết công việc</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-8 col-lg-12 pull-xl-4 scroll-y">
                            <div class="card border">
                                <div class="card-header mb-2">
                                    <div class="f-left">
                                        <h4><i class="icofont icofont-tasks-alt m-r-5"></i> <?= $task['title'] ?? 'Dự án chưa có tiêu đề' ?></h4>
                                    </div>
                                    <?php if ($currentUser == $task['assignee'] || $currentUser == $project['owner']) : //|| $currentUser == $task['created_by']
                                    ?>
                                        <div class="f-right d-flex">
                                            <div class="dropdown-secondary dropdown d-inline-block">
                                                <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown35" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdown35" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-edit-alt m-r-10"></i>Chỉnh sửa</a>
                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-close m-r-10"></i>Xoá</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="card-block">
                                    <div class="">
                                        <div class="m-b-50">
                                            <h6 class="sub-title m-b-15">Mô tả dự án</h6>
                                            <p>
                                                <?= $task['descriptions'] ?? 'Dự án chưa có mô tả' ?>
                                            </p>
                                        </div>
                                        <?php if (!empty($attachments)) : ?>
                                            <div class="m-t-20 m-b-20">
                                                <h6 class="sub-title m-b-15">Tệp đính kèm</h6>
                                            </div>
                                            <div class="col-sm-12">
                                                <!-- Swiper slider card start -->

                                                <div class="swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <div class="card thumb-block">
                                                                <div class="thumb-img">
                                                                    <img src="libraries\assets\images\task\task-u1.jpg" class="img-fluid width-100" alt="task-u1.jpg">
                                                                    <div class="caption-hover">
                                                                        <span>
                                                                            <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-ui-zoom-in"></i> </a>
                                                                            <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-download-alt"></i> </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-center">
                                                                    <a href="#!"> task/task-u1.jpg </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card border comment-block">
                                <!-- <div class="card-header">
                                    <h5 class="card-header-text d-flex">Các hoạt động</h5>
                                </div> -->
                                <div class="card-block">
                                    <ul class="nav nav-tabs md-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#comment" role="tab"><i class="icofont icofont-comment m-r-10"></i>Bình luận</a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#activity" role="tab"><i class="icofont icofont-certificate-alt-2 m-r-10"></i>Hoạt động</a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                    <div class="tab-content card-block">
                                        <div class="tab-pane active" id="comment" role="tabpanel">
                                            <div class="md-float-material d-flex">
                                                <div class="col-md-12 btn-add-task">
                                                    <form action="#" method="post" class="d-flex">
                                                        <input type="text" id="comment-decorator" onclick="showCommentEditor()" class="form-control" placeholder="Thêm bình luận ...">
                                                        <div id="form-comment" class="hidden">
                                                            <div class="row">
                                                                <div class="col-12 m-b-20" id="editorContainer">
                                                                    <textarea name="task_comment" class="form-control" id="task-comment"></textarea>
                                                                </div>
                                                                <div class="col-12 ">
                                                                    <button type="button" class="btn btn-secondary f-right rounded" onclick="clearComment()">Huỷ</button>
                                                                    <button class="btn btn-primary f-right rounded mx-2">Bình luận</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <h6 class="sub-title m-t-30 m-b-15">Danh sách bình luận</h6>
                                            <ul class="media-list mt-3">
                                                <?php if (!empty($comments)) : ?>
                                                    <?php foreach ($comments as $comment) : ?>
                                                        <li class="media d-flex">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object img-radius comment-img" src="https://colorlib.com/polygon/adminty/files/assets/images/avatar-4.jpg" alt="Generic placeholder image">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading txt-primary"><?= $comment['user_name'] ?><span class="f-12 text-muted m-l-5"><?= $comment['updated_at'] ?></span></h6>
                                                                <p><?= $comment['user'] ?></p>

                                                                <?php if ($currentUser == $comment['user_id']) : ?>
                                                                    <div class="m-t-10 m-b-25">
                                                                        <span><a href="#!" class="m-r-10 f-12">Edit</a></span><span><a href="#!" class="m-r-10 f-12">Delete</a> </span>
                                                                    </div>
                                                                <?php endif ?>

                                                                <hr>
                                                            </div>
                                                        </li>
                                                    <?php endforeach ?>
                                                <?php else : ?>
                                                    <li>
                                                        <p>Chưa có bình luận nào.</p>
                                                    </li>
                                                <?php endif ?>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" id="activity" role="tabpanel">
                                            <div class="form-group">
                                                <div class="row">
                                                    <h6 class="sub-title m-t-30 m-b-15">Danh sách hoạt động</h6>
                                                    <ul class="media-list revision-blc">
                                                        <?php if (!empty($activites)) : ?>
                                                            <li class="media d-flex m-b-15">
                                                                <div class="p-l-15 p-r-20 d-inline-block v-middle"><a href="#" class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icon-ghost f-18 v-middle"></i></a></div>
                                                                <div class="d-inline-block">
                                                                    Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                                                    <div class="media-annotation">4 minutes ago</div>
                                                                </div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <div class="d-inline-block">
                                                                    Chưa có hoạt động nào.
                                                                </div>
                                                            </li>
                                                        <?php endif ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Task-detail-right start -->
                        <div class="col-xl-4 col-lg-12 push-xl-8 task-detail-right scroll-y">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-ui-note m-r-10"></i> Task Details</h5>
                                </div>
                                <div class="card-block task-details">
                                    <table class="table table-border table-xs">
                                        <tbody>
                                            <tr>
                                                <td><i class="icofont icofont-contrast"></i> Dự án:</td>
                                                <td class="text-right"><span class="f-right"> <?= $project['name'] ?></span></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-spinner-alt-5"></i> Độ ưu tiên:</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <?= $task['priority'] ? TASK_PRIORITY[$task['priority']] : TASK_PRIORITY[NORMAL] ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-ui-calendar"></i> Ngày bắt đầu:</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <?= $task['start_at'] ?? 'Trống' ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-ui-calendar"></i> Ngày kết thúc:</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <?= $task['due_at'] ?? 'Trống' ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-user"></i> Người thực hiện: </td>
                                                <!-- <td class="text-right"><a href="#"></a></td> -->
                                                <td class="text-right"><?= $task['assignee'] ?? 'Trống' ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-washing-machine"></i> Trạng thái:</td>
                                                <td class="text-right">Đang thực hiện</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if ($currentUser != $task['assignee']) : ?>
                                <div class="card border">
                                    <div class="card-header">
                                        <h5 class="card-header-text"><i class="icofont icofont-clock-time m-r-10"></i>Bộ đếm thời gian</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-xs-3 justify-content-center d-flex">
                                                <h2>
                                                    <div id="count">00:00:00</div>
                                                </h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <div class="justify-content-center d-flex">
                                                    <button class="btn btn-primary rounded mx-1" id="start-counter" onclick="doCounter()">Bắt đầu</button>
                                                    <button class="btn btn-secondary rounded mx-1" id="stop-counter" onclick="stopCouter()">Dừng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-wheel m-r-10"></i> Cài đặt</h5>
                                </div>
                                <div class="card-block task-setting">
                                    <div class="form-group">
                                        <?php if ($currentUser == $task['assignee'] || $currentUser == $project['owner']) : //|| $currentUser == $task['created_by']
                                        ?>
                                            <form action="" method="post">
                                                <div class="row mb-2">
                                                    <div class="col-sm-12">
                                                        <label class="f-left">Cho phép bình luận</label>
                                                        <input type="checkbox" class="js-small f-right" checked>
                                                    </div>
                                                </div>
                                                <div class="row  mb-2">
                                                    <div class="col-sm-12">
                                                        <label class="f-left">Cho phép thành viên chỉnh sửa công việc</label>
                                                        <input type="checkbox" class="js-small f-right" checked>
                                                    </div>
                                                </div>
                                                <div class="row  mb-2">
                                                    <div class="col-sm-12">
                                                        <label class="f-left">Cho phép tải lên tệp đính kèm</label>
                                                        <input type="checkbox" class="js-small f-right" checked>
                                                    </div>
                                                </div>
                                                <div class="row text-center">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-primary waves-effect waves-light p-l-40 p-r-40">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php else : ?>
                                            <div class="row mb-2">
                                                <div class="col-sm-12">
                                                    <label class="f-left">Bạn không có quyền chỉnh sửa công việc này.</label>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-attachment"></i> Attached Files</h5>
                                </div>
                                <div class="card-block task-attachment">
                                    <ul class="media-list">
                                        <li class="media d-flex m-b-10">
                                            <div class="m-r-20 v-middle">
                                                <i class="icofont icofont-file-word f-28 text-muted"></i>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="m-b-5 d-block">Overdrew_scowled.doc</a>
                                                <div class="text-muted">
                                                    <span>Size: 1.2Mb</span>
                                                    <span>
                                                        Added by <a href="">Winnie</a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="f-right v-middle text-muted">
                                                <i class="icofont icofont-download-alt f-18"></i>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>

                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js')  ?>

<script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\script.js"></script>
<script type="text/javascript" src="<?= base_url() ?>\templates\js\moment\moment.js"></script>

<!-- Switch component js -->
<script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\switchery\js\switchery.min.js"></script>

<!-- swiper js -->
<script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\swiper\js\swiper.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\swiper-custom.js"></script>

<script>

    // window.addEventListener('beforeunload', function(){})

    var counter = 0
    var counterInterval
    var countBox = document.getElementById('count')

    var isBtnStartCounterClick = false
    var btnStartCounter = document.getElementById('start-counter')

    var isBtnStopCounterClick = false
    var btnStopCounter = document.getElementById('stop-counter')

    function doCounter() {
        if (isBtnStartCounterClick) {
            return
        }
        isBtnStartCounterClick = true
        btnStartCounter.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'
        setTimeout(() => {
            $.growl.notice({
                message: "Bắt đầu ca làm việc"
            });
            counterInterval = setInterval(countTime, 1000)
            btnStartCounter.innerHTML = 'Bắt đầu'
        }, 500)
    }

    function countTime() {
        counter++
        countBox.innerHTML = toHHMMSS(counter)
    }

    function stopCouter() {
        if (isBtnStopCounterClick) {
            return
        }
        isBtnStopCounterClick = true

        if (0 == counter) {
            return
        }

        clearInterval(counterInterval)

        // >> ===================================
        btnStopCounter.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'
        btnStartCounter.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        setTimeout(() => {
            //handle save counter

            $.growl.notice({
                message: "Đã ghi lại thời gian làm việc"
            })

            countBox.innerHTML = '00:00:00'
            isBtnStopCounterClick = false
            btnStopCounter.innerHTML = 'Dừng'
            isBtnStartCounterClick = false
            btnStartCounter.innerHTML = 'Bắt đầu'
        }, 1500)
        // =================================== <<

        // >> ===================================
        counter = 0
        // =================================== <<
    }

    function toHHMMSS(second) {
        var sec_num = parseInt(second, 10);
        var hours = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        return hours + ':' + minutes + ':' + seconds;
    }

    // Multiple swithces
    var elem = Array.prototype.slice.call(document.querySelectorAll('.js-small'));

    elem.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#1abc9c',
            jackColor: '#fff',
            size: 'small'
        });
    });

    var commentDecorator = document.getElementById('comment-decorator')
    var formEditor = document.getElementById('form-comment')
    var ckEditor = null

    function clearComment() {
        document.getElementById('task-comment').value = ''
        ckEditor.setData('')
        formEditor.style.display = 'none'
        commentDecorator.hidden = false
    }

    function showCommentEditor() {
        commentDecorator.hidden = true
        formEditor.style.display = 'flex'

        if (ckEditor != null) {
            return
        }
        ckEditor = CKEDITOR.replace('task-comment', {
            width: '100%',
            height: 150,
            toolbar: [{
                name: 'clipboard',
                items: ['Undo', 'Redo']
            }, {
                name: 'styles',
                items: ['Styles', 'Format']
            }, {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
            }, {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            }, {
                name: 'links',
                items: ['Link', 'Unlink']
            }, {
                name: 'insert',
                items: ['Table'] //'Image', 
            }],
            removeDialogTabs: 'image:advanced;link:advanced',
        })
    }
</script>

<?= $this->endSection() ?>