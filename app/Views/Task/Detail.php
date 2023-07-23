<?= $this->extend('layout') ?>

<?= $this->section('css') ?>
<!-- Time line css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\pages\timeline\style.css">
<!-- Switch component css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\bower_components\switchery\css\switchery.min.css">
<!-- swiper css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\bower_components\swiper\css\swiper.min.css">

<link type="text/css" rel="stylesheet" href="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\css\jquery.filer.css">

<style>
    .icon-jfi-trash {
        text-decoration: none;
    }

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

    .editorContainer {
        width: 50.5vw;
    }

    .editorContainer-2 {
        width: 48vw;
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
                                    <div class="d-flex">
                                        <a href="<?= base_url("project/{$project['prefix']}") ?>" class="text-decoration-none"><?= $project['name'] ?></a>
                                        &nbsp;/&nbsp;
                                        <?php if (!empty($parentTask)) : ?>
                                            <a href="<?= base_url("project/{$project['prefix']}/task/{$parentTask}") ?>" class="text-decoration-none"><?= $parentTask ?></a>
                                            &nbsp;/&nbsp;
                                            <a href="<?= base_url("project/{$project['prefix']}/task/{$task['task_key']}") ?>" class="text-decoration-none"><?= $task['task_key'] ?></a>
                                        <?php else : ?>
                                            <a href="<?= base_url("project/{$project['prefix']}/{$task['task_key']}") ?>" class="text-decoration-none"><?= $task['task_key'] ?></a>
                                        <?php endif ?>
                                    </div>
                                    <div class="f-left">
                                        <h4><i class="icofont icofont-tasks-alt m-r-5"></i> <?= $task['title'] ?? 'Dự án chưa có tiêu đề' ?></h4>
                                    </div>
                                    <?php if ($currentUser == $task['assigneeID'] || $currentUser == $project['owner'] || $userRole == LEADER) : ?>
                                        <div class="f-right d-flex">
                                            <div class="dropdown-secondary dropdown d-inline-block">
                                                <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown35" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdown35" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                    <a class="dropdown-item waves-light waves-effect" data-bs-toggle="modal" data-bs-target="#updateTaskInformation"><i class="icofont icofont-edit-alt m-r-10"></i>Chỉnh sửa</a>
                                                    <a class="dropdown-item waves-light waves-effect" id="btn-delete-task-<?= $task['id'] ?>" onclick="deleteTask(<?= $task['id'] ?>, <?= $project['id'] ?>)"><i class="icofont icofont-close m-r-10"></i>Xoá</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="card-block">
                                    <div>
                                        <div class="m-b-30">
                                            <h6 class="sub-title m-b-15">Mô tả dự án</h6>
                                            <p>
                                                <?= $task['descriptions'] ?? 'Dự án chưa có mô tả' ?>
                                            </p>
                                        </div>
                                        <?php if (!empty($attachments)) : ?>
                                            <div class="m-t-20 m-b-30">
                                                <h6 class="sub-title m-b-15">Tệp đính kèm</h6>
                                                <div class="col-sm-12">
                                                    <div class="swiper-container">
                                                        <div class="swiper-wrapper">
                                                            <?php foreach ($attachments as $attachment) : ?>
                                                                <div class="swiper-slide">
                                                                    <div class="card thumb-block">
                                                                        <div class="thumb-img">
                                                                            <img src="<?= base_url() ?>\file.jpg" class="img-fluid width-100" alt="<?= $attachment['name'] ?>">
                                                                            <div class="caption-hover">
                                                                                <span>
                                                                                    <a href="<?= base_url("attachments/{$attachment['name']}") ?>" class="btn btn-primary btn-sm"><i class="icofont icofont-download-alt"></i></a>
                                                                                    <?php if (OWNER == $currentUser || LEADER == $currentUser || $task['created_by'] == session()->get('user_id')) : ?>
                                                                                        <a onclick="removeFile(<?= $attachment['id'] ?> , '<?= $attachment['name'] ?>')" id="btn-delete-attachment-<?= $attachment['id'] ?>" class="btn btn-danger btn-sm"><i class="icofont icofont-trash"></i></a>
                                                                                    <?php endif ?>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-footer text-center text-truncate">
                                                                            <a target="_blank" class="text-decoration-none" title="<?= $attachment['name'] ?>" href="<?= base_url("attachments/{$attachment['name']}") ?>"><?= $attachment['name'] ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                        <?php if (0 == $task['parent_id']) : ?>
                                            <div class="m-t-20 m-b-30">
                                                <h6 class="sub-title m-b-15">Công việc phụ</h6>
                                                <div class="dropdown-secondary dropdown d-inline-block">
                                                    <button class="btn btn-sm btn-primary waves-light" type="button" data-bs-toggle="modal" data-bs-target="#createSubTask"><i class="icofont icofont-plus"></i> Thêm công việc phụ</button>
                                                </div>
                                                <?php if (!empty($subtasks)) : ?>
                                                    <div class="card my-3">
                                                        <div class="card-header border " style="border-bottom-right-radius: unset; border-bottom-left-radius: unset;">
                                                            <div class="col-md-12">
                                                                <h5 class="card-header-text">Tiến độ hoàn thành</h5>
                                                                <div class="d-flex">
                                                                    <div class="progress" style="width:95%">
                                                                        <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?= $percenSubtaskProgress ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                    <span style="font-weight: bold; color: black; padding-left: 10px; top:-5px; position: relative;" style="width:5%"><?= $percenSubtaskProgress ?>%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-block border rounded-bottom" style="border-top: none !important;border-top-left-radius: unset;border-top-right-radius: unset;">
                                                            <div class="row">
                                                                <?php foreach ($subtasks as $sub) : ?>
                                                                    <div class="col border bg-light rounded mt-3 mx-2">
                                                                        <p class="m-b-0 m-t-10"><b><a class="text-decoration-none" href='<?= base_url("project/{$project['prefix']}/task/{$sub['task_key']}") ?>'>[<?= $sub['task_key'] ?>] <?= $sub['title'] ?></a></b></p>
                                                                        <p class="m-b-10">
                                                                            <b>Trạng thái:</b>
                                                                            <span class="badge-custom-<?= $sub['base_status'] ?>"><?= $sub['status'] ?></span>
                                                                        </p>
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card border comment-block">
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
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#work-log" role="tab">
                                                <i class="icofont icofont-clock-time m-r-10"></i>Nhật ký làm việc
                                            </a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                    <div class="tab-content card-block">
                                        <div class="tab-pane active" id="comment" role="tabpanel">
                                            <div class="md-float-material d-flex">
                                                <div class="col-md-12 btn-add-task">
                                                    <form action="#" class="d-flex">
                                                        <input type="text" id="comment-decorator" onclick="showCommentEditor()" class="form-control" placeholder="Thêm bình luận ...">
                                                        <div id="form-comment" class="hidden">
                                                            <div class="row">
                                                                <div class="col-12 m-b-20 editorContainer">
                                                                    <textarea name="task_comment" class="form-control" id="task-comment"></textarea>
                                                                </div>
                                                                <div class="col-12 ">
                                                                    <button type="button" class="btn btn-secondary f-right rounded" onclick="clearComment()">Huỷ</button>
                                                                    <button class="btn btn-primary f-right rounded mx-2" type="button" id="btn-save-comment" onclick="createComments(<?= $task['id'] ?>)">Bình luận</button>
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
                                                                    <img class="media-object img-radius comment-img" src="<?= base_url('/imgs/') . $comment['photo'] ?>" alt="Generic placeholder image">
                                                                </a>
                                                            </div>
                                                            <div class="media-body w-100">
                                                                <h6 class="media-heading txt-primary"><?= $comment['name'] ?><span class="f-12 text-muted m-l-5"><?= $comment['created_at'] ?></span></h6>
                                                                <div id="comment-text-<?= $comment['id'] ?>"><?= $comment['text'] ?></div>

                                                                <div id="form-edit-comment-<?= $comment['id'] ?>" class="hidden">
                                                                    <div class="row">
                                                                        <div class="col-12 m-b-20 editorContainer-2">
                                                                            <textarea id="edit-comment-editor-<?= $comment['id'] ?>" class="hidden" cols="30" rows="10"><?= $comment['text'] ?></textarea>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <button type="button" class="btn btn-secondary f-right rounded" onclick="clearEditComment(<?= $comment['id'] ?>)">Huỷ</button>
                                                                            <button class="btn btn-primary f-right rounded mx-2" id="btn-edit-comment-<?= $comment['id'] ?>" onclick="saveEditComment(<?= $comment['id'] ?>)">Lưu</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($currentUser == $comment['user_id']) : ?>
                                                                    <div class="m-t-10 m-b-25 edit-and-delete">
                                                                        <span><a class="m-r-10 f-12 text-decoration-none" onclick="showEditCommentEditor(<?= $comment['id'] ?>)">Sửa</a></span><span><a class="m-r-10 f-12 text-decoration-none" id="btn-delete-comment" onclick="deleteComment(<?= $comment['id'] ?>)">Xoá</a> </span>
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
                                            <div class="mb-3">
                                                <?= !empty($pager) ? $pager->links('default', 'default') : '' ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="activity" role="tabpanel">
                                            <div class="form-group">
                                                <div class="row">
                                                    <h6 class="sub-title m-t-30 m-b-15">Danh sách hoạt động</h6>
                                                    <ul class="media-list revision-blc">
                                                        <?php if (!empty($activities)) : ?>
                                                            <?php foreach ($activities as $activity) : ?>
                                                                <li class="media d-flex m-t-5 m-b-15">
                                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle"><a class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icofont icofont-settings-alt"></i></a></div>
                                                                    <div class="d-inline-block">
                                                                        <?= $activity['log'] ?>
                                                                        <div class="media-annotation"><?= $activity['created_at'] ?></div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach ?>
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
                                        <div class="tab-pane" id="work-log" role="tabpanel">
                                            <div class="form-group">
                                                <div class="row">
                                                    <h6 class="sub-title m-t-30 m-b-15">Danh sách nhật ký</h6>
                                                    <ul class="media-list revision-blc">
                                                        <?php if (!empty($timeTrackings)) : ?>
                                                            <?php foreach ($timeTrackings as $time) : ?>
                                                                <li class="media d-flex m-t-5 m-b-15">
                                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle">
                                                                        <a class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icofont icofont-clock-time m-r-10"></i></a>
                                                                    </div>
                                                                    <div class="d-inline-block">
                                                                        <b><?= $time['created_by'] ?></b> đã ghi lại <code> <?= $time['time'] ?> </code> thời gian làm việc.
                                                                        <div class="media-annotation"><?= $time['created_at'] ?></div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach ?>
                                                        <?php else : ?>
                                                            <li>
                                                                <div class="d-inline-block">
                                                                    Chưa có nhật ký làm việc nào.
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
                                    <h5 class="card-header-text"><i class="icofont icofont-ui-note m-r-10"></i> Chi tiết công việc</h5>
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
                                                <td class="text-right"><?= $task['assignee'] ?? 'Trống' ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-user"></i> Người nhận báo cáo: </td>
                                                <td class="text-right"><?= $task['reporter'] ?? 'Trống' ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-washing-machine"></i> Trạng thái:</td>
                                                <td class="text-right">
                                                    <span class="badge-custom-<?= $task['base_status'] ?>"><?= $task['status'] ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-washing-machine"></i> Tổng thời gian làm việc:</td>
                                                <td class="text-right">
                                                    <?= $totalWorkTime ?? 'Chưa có' ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <?php if ((session()->get('user_id') == $task['created_by']) || (session()->get('user_id') == $task['assigneeID']) || OWNER == $userRole) : ?>
                                        <div class="dropdown-secondary dropdown d-inline-block" id="context-menu-<?= $task['id'] ?>">
                                            Trạng thái:
                                            <button class="btn btn-sm btn-primary  waves-light" type="button" id="dropdown-<?= $task['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <?php foreach ($taskStatus as $subStatus) : ?>
                                                    <a style="z-index: 9999;" class="dropdown-item waves-light waves-effect <?= $task['task_status_id'] == $subStatus['id'] ? 'active' : '' ?>" <?= $task['task_status_id'] == $subStatus['id'] ? '' : 'onclick="changeTaskStatus(' . $task['id'] . ',' . $subStatus['id'] . ')"' ?>>
                                                        <i class="icofont icofont-listine-dots"></i>
                                                        <?= $subStatus['title'] ?>
                                                    </a>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php if ($currentUser == $task['assigneeID']) : ?>
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
                            <!-- <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-wheel m-r-10"></i> Cài đặt</h5>
                                </div>
                                <div class="card-block task-setting">
                                    <div class="form-group">
                                        <?php if ($currentUser == $task['assignee'] || $currentUser == $project['owner'] || $currentUser == $task['created_by']) : ?>
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

<!-- Create new update task modal -->
<div class="modal modal-xl fade mt-5" id="updateTaskInformation" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form class="needs-validation" id="create-project">
                    <div class="mb-3">
                        <label for="task_name" class="col-form-label">Tên công việc<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control rounded" id="task_name" value="<?= $task['title'] ?>" placeholder="Nhập tên công việc ..." minlength="5" maxlength="512" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Trạng thái công việc<span class="text-danger"> *</span></label>
                        <select id="task_status" class="form-control">
                            <?php if (!empty($taskStatus)) : ?>
                                <?php foreach ($taskStatus as $status) : ?>
                                    <option value="<?= $status['id'] ?>" <?= $task['task_status_id'] == $status['id'] ? 'selected' : '' ?>><?= $status['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Người được giao</label>
                        <select id="assignee" class="form-control">
                            <option value="">Trống</option>
                            <option value="<?= session()->get('user_id') ?>" <?= !empty($task['assigneeID']) && $task['assigneeID'] == session()->get('user_id') ? 'selected' : '' ?>>Cho tôi</option>
                            <?php if (!empty($assignees)) : ?>
                                <?php foreach ($assignees as $assignee) : ?>
                                    <option value="<?= $assignee['user_id'] ?>" <?= !empty($task['assigneeID']) &&  $task['assigneeID'] == $assignee['user_id'] ? 'selected' : '' ?>><?= $assignee['name'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reporter" class="col-form-label">Người nhận báo cáo</label>
                        <select id="reporter" class="form-control">
                            <option value="">Trống</option>
                            <?php if (!empty($reporters)) : ?>
                                <?php foreach ($reporters as $reporter) : ?>
                                    <option value="<?= $reporter['user_id'] ?>" <?= !empty($task['reporterID']) && $reporter['user_id'] == $task['reporterID'] ? 'selected' : '' ?>><?= $reporter['name'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="task_descriptions" class="col-form-label">Chọn mức độ ưu tiên</label>
                        <select id="task_priority" class="form-control">
                            <?php foreach (TASK_PRIORITY as $key => $priority) : ?>
                                <option value="<?= $key ?>" <?= $task['priority'] == $key ? 'selected' : '' ?>><?= $priority ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="task_start_date" class="col-form-label">Chọn ngày bắt đầu</label>
                                <input type="date" id="task_start_date" value="<?= $task['start_at'] ?>" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="task_due_date" class="col-form-label">Chọn ngày kết thúc</label>
                                <input type="date" id="task_due_date" value="<?= $task['due_at'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="task_descriptions" class="col-form-label">Mô tả cho dự án</label>
                        <textarea id="task_descriptions" class="form-control rounded" maxlength="512" rows="5"><?= $task['descriptions'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="user_avatar" class="col-form-label">Tệp đính kèm</label>
                        <input type="file" id="attachment" name="attachment[]" accept="*" multiple="multiple">
                    </div>

                    <div class="float-end mb-5">
                        <button type="submit" id="btn-create-task" onclick="updateTask(<?= $project['id'] ?>)" class="btn btn-primary rounded">
                            Lưu
                        </button>
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Create new sub task modal -->
<div class="modal modal-xl fade mt-5" id="createSubTask" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form class="needs-validation" id="create-project">
                    <div class="mb-3">
                        <label for="sub_task_name" class="col-form-label">Tên công việc<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control rounded" id="sub_task_name" value="" placeholder="Nhập tên công việc ..." minlength="5" maxlength="512" required>
                    </div>
                    <div class="mb-3">
                        <label for="sub_task_status" class="col-form-label">Trạng thái công việc<span class="text-danger"> *</span></label>
                        <select id="sub_task_status" class="form-control">
                            <?php if (!empty($taskStatus)) : ?>
                                <?php foreach ($taskStatus as $status) : ?>
                                    <?php if ($status['base_status'] != 1) continue ?>
                                    <option value="<?= $status['id'] ?>"><?= $status['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_assignee" class="col-form-label">Người được giao</label>
                        <select id="sub_assignee" class="form-control">
                            <option value="">Trống</option>
                            <option value="<?= session()->get('user_id') ?>">Cho tôi</option>
                            <?php if (!empty($assignees)) : ?>
                                <?php foreach ($assignees as $assignee) : ?>
                                    <option value="<?= $assignee['user_id'] ?>"><?= $assignee['name'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_reporter" class="col-form-label">Người nhận báo cáo</label>
                        <select id="sub_reporter" class="form-control">
                            <option value="">Trống</option>
                            <?php if (!empty($reporters)) : ?>
                                <?php foreach ($reporters as $reporter) : ?>
                                    <option value="<?= $reporter['user_id'] ?>"><?= $reporter['name'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sub_task_priority" class="col-form-label">Chọn mức độ ưu tiên</label>
                        <select id="sub_task_priority" class="form-control">
                            <?php foreach (TASK_PRIORITY as $key => $priority) : ?>
                                <option value="<?= $key ?>" <?= $key == NORMAL ? 'selected' : '' ?>><?= $priority ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="sub_task_start_date" class="col-form-label">Chọn ngày bắt đầu</label>
                                <input type="date" id="sub_task_start_date" value="" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="sub_task_due_date" class="col-form-label">Chọn ngày kết thúc</label>
                                <input type="date" id="sub_task_due_date" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="task_descriptions" class="col-form-label">Mô tả cho dự án</label>
                        <textarea id="sub_task_descriptions" class="form-control rounded" maxlength="512" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="user_avatar" class="col-form-label">Tệp đính kèm</label>
                        <input type="file" id="sub_attachment" name="sub_attactment[]" accept="*" multiple="multiple">
                    </div>

                    <div class="float-end mb-5">
                        <button type="button" id="btn-create-sub-task" onclick="createSubTask(<?= $project['id'] ?>)" class="btn btn-primary rounded">
                            Tạo
                        </button>
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
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

<!-- jquery file upload js -->
<script src="<?= base_url() ?>\templates\libraries\assets\pages\jquery.filer\js\jquery.filer.js"></script>

<!-- CK4 -->
<script>
    var task_descriptions = CKEDITOR.replace('task_descriptions', {
        // width: '100%',
        height: 300,
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
    var sub_task_descriptions = CKEDITOR.replace('sub_task_descriptions', {
        // width: '100%',
        height: 300,
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
</script>

<script>
    $('#sub_attachment').filer({
        limit: 10,
        maxSize: 5,
        extensions: null,
        changeInput: true,
        showThumbs: true,
        addMore: true,
        captions: {
            button: "Chọn tệp",
            feedback: "Chọn tệp để tải lên",
            feedback2: "Tệp đã được chọn",
            removeConfirmation: "Bạn có chắc là muốn xoá tệp này?",
            errors: {
                filesLimit: "Tối đa chỉ được tải lên {{fi-limit}} tệp.",
                filesSize: "{{fi-name}} quá lớn, dung lượng tối đa mà tệp có thể tải lên là {{fi-fileMaxSize}} MB.",
                filesSizeAll: "Tệp bạn tải lên quá lớn, dung lượng tối đa mà tệp có thể tải lên là {{fi-maxSize}} MB.",
                folderUpload: "Bạn không được phép tải thư mục lên."
            }
        }
    });

    $('#attachment').filer({
        limit: 10,
        maxSize: 5,
        extensions: null,
        changeInput: true,
        showThumbs: true,
        addMore: true,
        files: [
            <?php empty($attachments) and $attachments = []; ?>
            <?php foreach ($attachments as $attachment) : ?> {
                    id: <?= $attachment['id'] ?>,
                    name: "<?= $attachment['name'] ?>",
                    size: <?= filesize((ATTACHMENT_PATH . $attachment['name'])) ?>,
                    type: "<?= $attachment['type'] ?>",
                    file: "<?= base_url("attachments/{$attachment['name']}") ?>",
                    url: "<?= base_url("attachments/{$attachment['name']}") ?>"
                },
            <?php endforeach ?>
        ],
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
            var filerKit = inputEl.prop("jFiler"),
                file_name = filerKit.files_list[id].file.name;
            file_id = filerKit.files_list[id].file.id;

            $.post('/task/attachment/remove', {
                file: file_name,
                attachment_id: file_id,
            });
        },
        captions: {
            button: "Chọn tệp",
            feedback: "Chọn tệp để tải lên",
            feedback2: "Tệp đã được chọn",
            removeConfirmation: "Bạn có chắc là muốn xoá tệp này?",
            errors: {
                filesLimit: "Tối đa chỉ được tải lên {{fi-limit}} tệp.",
                filesSize: "{{fi-name}} quá lớn, dung lượng tối đa mà tệp có thể tải lên là {{fi-fileMaxSize}} MB.",
                filesSizeAll: "Tệp bạn tải lên quá lớn, dung lượng tối đa mà tệp có thể tải lên là {{fi-maxSize}} MB.",
                folderUpload: "Bạn không được phép tải thư mục lên."
            }
        }
    });

    var btnDA

    function removeFile(id, name) {
        if (!confirm('Bạn có chắc là muốn xoá tệp này?')) return

        btnDA = document.getElementById(`btn-delete-attachment-${id}`)
        btnDA.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        $.post('/task/attachment/remove', {
            file: name,
            attachment_id: id,
        }).then(() => {
            $.growl.notice({
                message: "Đã xoá!"
            });
            setTimeout(() => {
                window.location.reload()
            }, 300)
        }).catch(() => {
            $.growl.error({
                message: "Có lỗi xảy ra, vui lòng thử lại sau!"
            });
            btnDA.innerHTML = '<i class="icofont icofont-trash"></i>'
        });
    }

    var commentDecorator = document.getElementById('comment-decorator')
    var formEditor = document.getElementById('form-comment')
    var commentEditor = null

    function clearComment() {
        document.getElementById('task-comment').value = ''
        commentEditor.setData('')
        formEditor.style.display = 'none'
        commentDecorator.hidden = false
    }

    function showCommentEditor() {
        commentDecorator.hidden = true
        formEditor.style.display = 'flex'

        if (commentEditor != null) {
            return
        }
        commentEditor = CKEDITOR.replace('task-comment', {
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

    var isCreateCommentAlreadyClick = false
    var btnSaveComment

    function createComments(taskID) {
        if (isCreateCommentAlreadyClick) return
        isCreateCommentAlreadyClick = true

        btnSaveComment = document.getElementById('btn-save-comment')
        btnSaveComment.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('task_id', taskID)
        data.append('comment', commentEditor.getData())
        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
        };
        fetch('<?= base_url('comment/create') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    if (result.errors.task_id) {
                        error = result.errors.task_id.replace('task_id', 'Mã công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isCreateCommentAlreadyClick = false
                            btnSaveComment.innerHTML = 'Bình luận'
                        }, 500)

                        return
                    }
                    if (result.errors.comment) {
                        error = result.errors.comment.replace('comment', 'Bình luận')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isCreateCommentAlreadyClick = false
                            btnSaveComment.innerHTML = 'Bình luận'
                        }, 500)

                        return
                    }
                }

                $.growl.notice({
                    message: 'Đã gửi bình luận'
                });

                setTimeout(() => {
                    window.location.reload()
                }, 300)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau'
                });
                isCreateCommentAlreadyClick = false
                btnSaveComment.innerHTML = 'Bình luận'
            })
    }

    var editAndDelete = document.getElementsByClassName('edit-and-delete')

    function clearEditComment(commentID) {
        var commentEditText = document.getElementById(`comment-text-${commentID}`)
        var editSection = document.getElementById(`form-edit-comment-${commentID}`)
        commentEditText.hidden = false
        editSection.style.display = 'none'

        for (let i = 0; i < editAndDelete.length; i++) {
            editAndDelete[i].hidden = false
        }
    }

    var commentEditEditor = null

    function showEditCommentEditor(commentID) {

        for (let i = 0; i < editAndDelete.length; i++) {
            editAndDelete[i].hidden = true
        }

        var editSection = document.getElementById(`form-edit-comment-${commentID}`)
        var commentEditText = document.getElementById(`comment-text-${commentID}`)
        var textAreaEditComment = document.getElementById(`edit-comment-editor-${commentID}`)

        commentEditText.hidden = true
        editSection.style.display = 'flex'

        if (commentEditEditor != null) {
            return
        }

        commentEditEditor = CKEDITOR.replace(`edit-comment-editor-${commentID}`, {
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

        commentEditEditor.setData(textAreaEditComment.value)
    }

    var isSaveEditCommentAlreadyClick = false
    var btnSaveEditComment

    function saveEditComment(commentID) {
        if (isSaveEditCommentAlreadyClick) return
        isSaveEditCommentAlreadyClick = true
        btnSaveEditComment = document.getElementById(`btn-edit-comment-${commentID}`)
        btnSaveEditComment.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('comment_id', commentID)
        data.append('text', commentEditEditor.getData())
        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };
        fetch('<?= base_url('comment/update') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    if (result.errors.comment) {
                        error = result.errors.comment.replace('comment', 'Bình luận')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isSaveEditCommentAlreadyClick = false
                            btnSaveEditComment.innerHTML = 'Lưu'
                        }, 1000)

                        return
                    }
                }

                $.growl.notice({
                    message: 'Đã lưu bình luận',
                });

                setTimeout(() => {
                    window.location.reload()
                }, 1000)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau'
                });
                isSaveEditCommentAlreadyClick = false
                btnSaveEditComment.innerHTML = 'Lưu'
            })
    }

    var isDeleteCommentAlreadyClick = false
    var btnDeleteComment = document.getElementById('btn-delete-comment')

    function deleteComment(commentID) {
        if (isDeleteCommentAlreadyClick) return
        isDeleteCommentAlreadyClick = true

        if (!confirm('Bạn có chắc là muốn xoá bình luận này?')) {
            isDeleteCommentAlreadyClick = false
            return
        }

        btnDeleteComment.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('comment_id', commentID)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };
        fetch('<?= base_url('comment/delete') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {

                    if (result.errors.comment_id) {
                        error = result.errors.comment.replace('comment_id', 'Mã bình luận')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isDeleteCommentAlreadyClick = false
                            btnDeleteComment.innerHTML = 'Xoá'
                        }, 1000)

                        return
                    }
                }

                $.growl.notice({
                    message: 'Đã xoá bình luận',
                });

                setTimeout(() => {
                    window.location.reload()
                }, 1000)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau'
                });
                isDeleteCommentAlreadyClick = false
                btnDeleteComment.innerHTML = 'Xoá'
            })
    }

    var isUpdateTaskAlreadyClick = false

    function updateTask(projectID) {
        if (isUpdateTaskAlreadyClick) return
        isUpdateTaskAlreadyClick = true

        taskName = document.getElementById('task_name')
        if (taskName.value == '') {
            isUpdateTaskAlreadyClick = false
            return
        }

        btnUpdateTask = document.getElementById('btn-create-task')
        btnUpdateTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('task_id', <?= $task['id'] ?>)
        data.append('name', taskName.value)
        data.append('task_status', document.getElementById('task_status').value)
        data.append('assignee', document.getElementById('assignee').value)
        data.append('reporter', document.getElementById('reporter').value)
        data.append('priority', document.getElementById('task_priority').value)
        data.append('start_date', document.getElementById('task_start_date').value)
        data.append('due_date', document.getElementById('task_due_date').value)
        data.append('descriptions', task_descriptions.getData())
        data.append('project_id', projectID)

        const files = document.getElementById('attachment').files
        if (0 < files.length) {
            for (let i = 0; i < files.length; i++) {
                data.append(i, document.getElementById('attachment').files[i])
            }
        }

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task/update') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {

                    if (result.errors.section) {
                        error = result.errors.section.replace('section', 'Trạng thái công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isUpdateTaskAlreadyClick = false
                            btnUpdateTask.innerHTML = 'Lưu'
                        }, 500)

                        return
                    }

                    if (result.errors.assignee) {
                        error = result.errors.assignee.replace('assignee', 'Người được giao')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isUpdateTaskAlreadyClick = false
                            btnUpdateTask.innerHTML = 'Lưu'
                        }, 500)

                        return
                    }

                    if (result.errors.name) {
                        error = result.errors.task_name.replace('name', 'Tên công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isUpdateTaskAlreadyClick = false
                            btnUpdateTask.innerHTML = 'Lưu'
                        }, 500)

                        return
                    }
                }

                if (result.errors_datetime) {
                    $.growl.error({
                        message: result.errors_datetime,
                        location: 'tr',
                        size: 'large'
                    });
                    setTimeout(() => {
                        isUpdateTaskAlreadyClick = false
                        btnUpdateTask.innerHTML = 'Lưu'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Lưu thông tin thành công công việc"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isUpdateTaskAlreadyClick = false
                btnUpdateTask.innerHTML = 'Lưu'
            })
    }

    var isDeleteTaskAlreadyClick = false
    var btnDeleteTask

    function deleteTask(taskID, projectID) {
        if (isDeleteTaskAlreadyClick) return
        isDeleteTaskAlreadyClick = true

        if (!confirm('Bạn có chắc là muốn xoá công việc này?')) {
            isDeleteTaskAlreadyClick = false
            return
        }

        btnDeleteTask = document.getElementById(`btn-delete-task-${taskID}`)
        btnDeleteTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('task_id', taskID)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task/delete') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {

                    if (result.errors.task_id) {
                        error = result.errors.section.replace('task_id', 'Mã công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isDeleteTaskAlreadyClick = false
                            btnDeleteTask.innerHTML = '<i class="icofont icofont-close m-r-10"></i>Xoá'
                        }, 1000)
                        return
                    }
                }

                $.growl.notice({
                    message: "Xoá công việc thành công"
                });

                setTimeout(() => {
                    isDeleteTaskAlreadyClick = false
                    btnDeleteTask.innerHTML = '<i class="icofont icofont-close m-r-10"></i>Xoá'
                    window.location.href = `<?= base_url('project') ?>/${projectID}`
                }, 1000)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isDeleteTaskAlreadyClick = false
                btnDeleteTask.innerHTML = '<i class="icofont icofont-close m-r-10"></i>Xoá'
            })
    }

    // var files
    var btnCreateSubTask = null
    var isCreateSubTaskAlreadyClick = false
    var projectId = document.getElementById('project-id')

    function createSubTask(projectID) {

        if (isCreateSubTaskAlreadyClick) return
        isCreateSubTaskAlreadyClick = true

        taskName = document.getElementById('task_name')
        if (taskName.value == '') {
            isCreateSubTaskAlreadyClick = false
            return
        }

        btnCreateSubTask = document.getElementById('btn-create-sub-task')
        btnCreateSubTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('parent_id', <?= $task['id'] ?>)
        data.append('name', taskName.value)
        data.append('task_status', document.getElementById('sub_task_status').value)
        data.append('assignee', document.getElementById('sub_assignee').value)
        data.append('reporter', document.getElementById('sub_reporter').value)
        data.append('priority', document.getElementById('sub_task_priority').value)
        data.append('start_date', document.getElementById('sub_task_start_date').value)
        data.append('due_date', document.getElementById('sub_task_due_date').value)
        data.append('descriptions', sub_task_descriptions.getData())
        data.append('project_id', projectID)

        const fileManagers = document.getElementById('sub_attachment').files
        if (0 < fileManagers.length) {
            for (let i = 0; i < fileManagers.length; i++) {
                data.append(i, document.getElementById('sub_attachment').files[i])
            }
        }

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            synchron: true,
        };

        fetch('<?= base_url('task/create') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {

                    if (result.errors.section) {
                        error = result.errors.section.replace('task_status', 'Trạng thái công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isCreateSubTaskAlreadyClick = false
                            btnCreateSubTask.innerHTML = 'Tạo'
                        }, 500)

                        return
                    }

                    if (result.errors.assignee) {
                        error = result.errors.assignee.replace('assignee', 'Người được giao')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isCreateSubTaskAlreadyClick = false
                            btnCreateSubTask.innerHTML = 'Tạo'
                        }, 500)

                        return
                    }

                    if (result.errors.name) {
                        error = result.errors.task_name.replace('name', 'Tên công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isCreateSubTaskAlreadyClick = false
                            btnCreateSubTask.innerHTML = 'Tạo'
                        }, 500)

                        return
                    }
                }

                if (result.errors_datetime) {
                    $.growl.error({
                        message: result.errors_datetime,
                        location: 'tr',
                        size: 'large'
                    });
                    setTimeout(() => {
                        isCreateSubTaskAlreadyClick = false
                        btnCreateSubTask.innerHTML = 'Tạo'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Tạo mới công việc thành công"
                });

                setTimeout(() => {
                    isCreateSubTaskAlreadyClick = false
                    btnCreateSubTask.innerHTML = 'Tạo'

                    window.location.reload()
                }, 500)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isCreateSubTaskAlreadyClick = false
                btnCreateSubTask.innerHTML = 'Tạo'
            })
    }

    var isChangeTaskStatusAlreadyClick = false
    var dropDownChangeStatus

    function changeTaskStatus(taskID, statusID) {
        if (isChangeTaskStatusAlreadyClick) return
        isChangeTaskStatusAlreadyClick = true

        const data = new FormData()
        data.append('task_id', taskID)
        data.append('status_id', statusID)

        dropDownChangeStatus = document.getElementById(`dropdown-${taskID}`)
        dropDownChangeStatus.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task/change-status') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    errTaskID = result.errors.task_id
                    if (errTaskID) {
                        errTaskID = errTaskID.replace('task_id', 'Công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isChangeTaskStatusAlreadyClick = false
                            dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        }, 500)

                        return
                    }

                    errStatusID = result.errors.status_id
                    if (errStatusID) {
                        errStatusID = errStatusID.replace('status_id', 'Trạng thái')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isChangeTaskStatusAlreadyClick = false
                            dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        }, 500)

                        return
                    }
                }

                $.growl.notice({
                    message: "Cập nhật trạng thái thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)

                return
            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!'
                });
                isChangeTaskStatusAlreadyClick = false
                dropDownChangeStatus.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }
    // Multiple swithces
    // var elem = Array.prototype.slice.call(document.querySelectorAll('.js-small'));

    // elem.forEach(function(html) {
    //     var switchery = new Switchery(html, {
    //         color: '#1abc9c',
    //         jackColor: '#fff',
    //         size: 'small'
    //     });
    // });

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
            isBtnStopCounterClick = false
            return
        }

        clearInterval(counterInterval)

        // >> ===================================
        btnStopCounter.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'
        btnStartCounter.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('time', counter)
        data.append('task', <?= $task['id'] ?>)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task/save-tracking-time') ?>', requestOptions)
            .then(() => {
                $.growl.notice({
                    message: "Đã ghi lại thời gian làm việc"
                })

                counter = 0

                countBox.innerHTML = '00:00:00'
                isBtnStopCounterClick = false
                btnStopCounter.innerHTML = 'Dừng'
                isBtnStartCounterClick = false
                btnStartCounter.innerHTML = 'Bắt đầu'

                setTimeout(() => {
                    window.location.reload()
                }, 500)
            })
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
</script>

<?= $this->endSection() ?>