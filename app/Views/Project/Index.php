<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\css\jquery.filer.css">

<style>
    .breadcrumb-title div {
        display: inline;
    }

    #draggableMultiple .sortable-moves {
        cursor: default !important;
    }

    .sortable-moves {
        padding: 15px !important;
    }

    .scroll-x>.row {
        overflow-x: auto;
    }

    .scroll-x>.row>* {
        display: inline-block;
        float: none;
    }

    .btn i {
        margin-right: 0px !important;
    }

    .item {
        padding: 0.3em 1.2em;
    }

    .item:hover {
        background-color: rgba(44, 141, 247, 0.2);
        cursor: pointer;
    }

    .section-name {
        width: 100%;
    }

    .task-name {
        width: 100%;
    }

    .jFiler-input-dragDrop {
        width: 100% !important;
    }

    .icofont-pencil-alt-5 {
        margin-top: 8px !important;
    }

    .hover-pointer:hover {
        cursor: pointer !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4><?= $project['name'] ?></h4>
                                    <span><?= $project['descriptions'] ?></span>
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
                                        <a href="<?= base_url('project/') . $project['prefix'] ?>" class="text-decoration-none">Chi tiết dự án</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <nav class="navbar navbar-light m-b-30 p-10 ">
                                <form class="form-material w-100" action="" id="filter" method="GET">
                                    <div class="row">
                                        <div class="col-2 pb-2">
                                            <label class="p-1" for="dim"><i class="icofont icofont-filter"></i> Người được giao việc</label>
                                            <select class="form-control rounded" name="user" onchange="submitForm()">
                                                <option value="all" <?= !empty($filterUser) && $filterUser == 'all' ? 'selected' : '' ?>>Toàn bộ</option>
                                                <option value="unassigned" <?= !empty($filterUser) && $filterUser == 'unassigned' ? 'selected' : '' ?>>Chưa được giao</option>
                                                <option value="<?= session()->get('user_id') ?>" <?= !empty($filterUser) && $filterUser == session()->get('user_id') ? 'selected' : '' ?>>Người dùng hiện tại</option>
                                                <?php if (!empty($assignees)) : ?>
                                                    <?php foreach ($assignees as $assignee) : ?>
                                                        <option value="<?= $assignee['user_id'] ?>" <?= !empty($filterUser) && $filterUser == $assignee['user_id'] ? 'selected' : '' ?>><?= $assignee['name'] ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </nav>
                            <div class="card border d-flex">
                                <div class="card-block scroll-x">
                                    <div class="row flex-nowrap" id="draggablePanelList">
                                        <?php if (!empty($taskStatus)) : ?>
                                            <?php foreach ($taskStatus as $status) : ?>
                                                <div class="col-3">
                                                    <div class="card border">
                                                        <div class="card-header">
                                                            <h5 class="card-header-text sub-title d-flex text-wrap overflow-auto" onmouseenter="showSectionEditButton(<?= $status['id'] ?>)" onmouseleave="hideSectionEditButton(<?= $status['id'] ?>)">
                                                                <span class="d-flex badge-custom-<?= $status['base_status'] ?>" id="section-title-<?= $status['id'] ?>">
                                                                    <?= $status['title'] ?>
                                                                </span>
                                                                <i class="icofont icofont-pencil-alt-5 hidden" id="edit-section-<?= $status['id'] ?>" onclick="showEditSection(<?= $status['id'] ?>)"></i>
                                                            </h5>
                                                            <div class="input-group hidden" id="input-group-section-<?= $status['id'] ?>" onfocusout="inputGroupSectionOut(<?= $status['id'] ?>)">
                                                                <input type="text" class="form-control" id="section-name-num-<?= $status['id'] ?>" value="<?= $status['title'] ?>">
                                                                <button type="button" id="save-edit-section-<?= $status['id'] ?>" class="btn btn-primary" onclick="editTaskStatusName(<?= $status['id'] ?>)">Lưu</button>
                                                                <button type="button" id="delete-section-<?= $status['id'] ?>" class="btn btn-danger" onclick="deleteTaskStatus(<?= $status['id'] ?>)">Xoá</button>
                                                            </div>
                                                        </div>
                                                        <div class="card-block p-b-0">
                                                            <div class="row">
                                                                <div class="col-md-12 section-container" id="draggableMultiple">
                                                                    <?php if (!empty($status['tasks'])) : ?>
                                                                        <?php foreach ($status['tasks'] as $task) : ?>
                                                                            <!-- <div class="col">
                                                                                <div class="card card-border-default">
                                                                                    <div class="card-header text-truncate">
                                                                                        <a href="<?= base_url("project/{$project['prefix']}/task/{$task['task_key']}") ?>" class="card-title text-decoration-none">[<?= $task['task_key'] ?>] <?= $task['title'] ?></a>
                                                                                    </div>
                                                                                    <div class="card-block">
                                                                                        <p class="task-due"><strong>Đến hạn: </strong><strong class="label label-primary"><?= $task['due_at'] ?? 'Trống' ?></strong></p>
                                                                                    </div>
                                                                                    <div class="card-footer">
                                                                                        <div class="task-list-table">
                                                                                            <a href="#!"><img class="img-fluid img-radius" src="libraries\assets\images\avatar-1.jpg" alt="1"></a>
                                                                                        </div>
                                                                                        <div class="task-board">
                                                                                            <div class="dropdown-secondary dropdown">
                                                                                                <button class="btn btn-primary btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Normal</button>
                                                                                                <div class="dropdown-menu" aria-labelledby="dropdown1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-danger"></span>Highest priority</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-warning"></span>High priority</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect active" href="#!"><span class="point-marker bg-success"></span>Normal priority</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-info"></span>Low priority</a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="dropdown-secondary dropdown">
                                                                                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Open</button>
                                                                                                <div class="dropdown-menu" aria-labelledby="dropdown2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                                    <a class="dropdown-item waves-light waves-effect active" href="#!">Open</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!">On hold</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!">Resolved</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!">Closed</a>
                                                                                                    <div class="dropdown-divider"></div>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!">Dublicate</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!">Invalid</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!">Wontfix</a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="dropdown-secondary dropdown">
                                                                                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-alarm"></i> Check in</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-attachment"></i> Attach screenshot</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-spinner-alt-5"></i> Reassign</a>
                                                                                                    <div class="dropdown-divider"></div>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-edit"></i> Edit task</a>
                                                                                                    <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-close-line"></i> Remove</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> -->

                                                                            <div class="sortable-moves border box d-block ">
                                                                                <p class="task-name hover-pointer text-truncate" id="task-num-<?= $task['id'] ?>" onclick="redirect_url('<?= base_url('project/') . $project['prefix'] . '/task/' . $task['task_key'] ?>')"><?= $task['title'] ?></p>
                                                                                <p><b>Người được giao: </b><?= $task['assignee_name'] ?? 'Trống' ?></p>
                                                                                <?php if ((session()->get('user_id') == $task['created_by']) || (session()->get('user_id') == $task['assignee']) || OWNER == $userRole) : ?>
                                                                                    <div class="dropdown-secondary dropdown d-inline-block" id="context-menu-<?= $task['id'] ?>">
                                                                                        <button class="btn btn-sm btn-primary  waves-light" type="button" id="dropdown-<?= $task['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                                        <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                            <?php foreach ($taskStatus as $subStatus) : ?>
                                                                                                <?php if (4 == $subStatus['base_status'] && (MEMBER == $userRole)) {
                                                                                                    continue;
                                                                                                } ?>
                                                                                                <a style="z-index: 9999;" class="dropdown-item waves-light waves-effect <?= $task['task_status_id'] == $subStatus['id'] ? 'active' : '' ?>" <?= $task['task_status_id'] == $subStatus['id'] ? '' : 'onclick="changeTaskStatus(' . $task['id'] . ',' . $subStatus['id'] . ')"' ?>>
                                                                                                    <i class="icofont icofont-listine-dots"></i>
                                                                                                    <?= $subStatus['title'] ?>
                                                                                                </a>
                                                                                            <?php endforeach ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php endif ?>

                                                                                <?php if (session()->get('user_id') == $task['created_by'] || OWNER == $userRole || LEADER == $userRole) : ?>
                                                                                    <button class="btn btn-sm btn-danger waves-light f-right" id="btn-delete-task-<?= $task['id'] ?>" type="button" onclick="deleteTask(<?= $task['id'] ?>)"><i class="icofont icofont-bin"></i></button>
                                                                                <?php endif ?>
                                                                            </div>
                                                                        <?php endforeach ?>
                                                                    <?php else : ?>
                                                                        <p class="overflow-auto">Hiện không có công việc nào.</p>
                                                                    <?php endif ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        <?php if (MEMBER != $userRole) : ?>
                                            <div class="col-3">
                                                <div class="card border">
                                                    <div class="card-block">
                                                        <form action="" method="post" onsubmit="createTaskStatus(event)" id="save-section">
                                                            <div class="input-group">
                                                                <input type="hidden" id="project-id" value="<?= $project['id'] ?>">
                                                                <input type="text" name="section_name" id="section-name" class="form-control hidden">
                                                                <button type="button" id="submit-button" class="btn btn-primary input-group-addon" onclick="doCreateSection()"><i class="icofont icofont-plus"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mt-5" id="createNewTask" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <!-- modal-xl -->
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <form class="needs-validation" id="create-project" method="POST" action="<?= base_url('task/do-create') ?>" enctype="multipart/form-data" onsubmit="createNewTask(<?= $project['id'] ?>); return false">
                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                    <div class="mb-3">
                        <label for="task_name" class="col-form-label">Tên công việc<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control rounded" name="name" id="task_name" placeholder="Nhập tên công việc ..." minlength="5" maxlength="512" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Trạng thái công việc<span class="text-danger"> *</span></label>
                        <select id="choose_section" name="task_status" class="form-control">
                            <?php if (!empty($taskStatus)) : ?>
                                <option value="<?= $taskStatus[0]['id'] ?>"><?= $taskStatus[0]['title'] ?></option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Người được giao</label>
                        <select id="assignee" name="assignee" class="form-control">
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
                        <label for="reporter" class="col-form-label">Người nhận báo cáo</label>
                        <select id="reporter" class="form-control">
                            <option value="">Trống</option>
                            <?php if (!empty($reporters)) : ?>
                                <?php foreach ($reporters as $reporter) : ?>
                                    <option value="<?= $reporter['user_id'] ?>"><?= $reporter['name'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="task_descriptions" class="col-form-label">Chọn mức độ ưu tiên</label>
                        <select id="task_priority" name="priority" class="form-control">
                            <?php foreach (TASK_PRIORITY as $key => $priority) : ?>
                                <option value="<?= $key ?>" <?= $key == NORMAL ? 'selected' : '' ?>><?= $priority ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="task_start_date" class="col-form-label">Chọn ngày bắt đầu</label>
                                <input type="date" name="start_date" id="task_start_date" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="task_due_date" class="col-form-label">Chọn ngày kết thúc</label>
                                <input type="date" name="due_date" id="task_due_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="task_descriptions" class="col-form-label">Mô tả cho dự án</label>
                        <textarea id="task_descriptions" name="descriptions" class="form-control rounded" id="task_descriptions" maxlength="512" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="user_avatar" class="col-form-label">Thêm tệp đính kèm</label>
                        <input type="file" id="attachment" name="attactment[]" accept="*" multiple="multiple">
                    </div>

                    <div class="float-end mb-5">
                        <button type="submit" id="btn-create-task" class="btn btn-primary rounded">
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
<?= $this->section('js') ?>
<!-- jquery file upload js -->
<script src="<?= base_url() ?>\templates\libraries\assets\pages\jquery.filer\js\jquery.filer.js"></script>

<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\Sortable\js\Sortable.js"></script>
<!-- Select 2 js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\select2\js\select2.full.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\advance-elements\select2-custom.js"></script>

<!-- task board js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\task-board\task-board.js"></script>
<!-- CK4 -->
<script>
    $('#attachment').filer({
        limit: 10,
        maxSize: 5,
        extensions: null,
        changeInput: true,
        showThumbs: true,
        addMore: true
    });

    function submitForm() {
        var form = document.getElementById('filter')
        form.submit()
    }
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
            items: ['Table']
        }],
        removeDialogTabs: 'image:advanced;link:advanced',
    })
</script>

<script>
    // draggablePanelList = document.getElementById('draggablePanelList');
    // Sortable.create(draggablePanelList, {
    //     group: 'draggablePanelList',
    //     animation: 150,
    //     cursor: 'move',
    //     // Element dragging ended
    //     onEnd: function( /**Event*/ evt) {
    //         evt.to; // target list
    //         evt.from; // previous list
    //         evt.oldIndex; // element's old index within old parent
    //         evt.newIndex; // element's new index within new parent
    //         // console.log(evt.item, evt.oldIndex, evt.newIndex)
    //     },
    // });

    // draggableMultiple = document.getElementById('draggableMultiple');
    // Sortable.create(draggableMultiple, {
    //     group: 'draggableMultiple',
    //     animation: 150,
    //     cursor: 'move',
    //     // Element dragging ended
    //     onEnd: function( /**Event*/ evt) {
    //         evt.to; // target list
    //         evt.from; // previous list
    //         evt.oldIndex; // element's old index within old parent
    //         evt.newIndex; // element's new index within new parent
    //         // console.log(evt.item, evt.oldIndex, evt.newIndex)
    //     },
    // });
</script>

<script>
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

    var isDeleteTaskAlreadyClick = false
    var btnDeleteTask

    function deleteTask(taskID) {
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
        data.append('project_id', <?= $project['id'] ?>)

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
                        error = result.errors.task_id.replace('task_id', 'Công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isDeleteTaskAlreadyClick = false
                            btnDeleteTask.innerHTML = '<i class="icofont icofont-bin"></i>'
                        }, 500)
                        return
                    }
                }

                $.growl.notice({
                    message: "Xoá công việc thành công"
                });

                setTimeout(() => {
                    isDeleteTaskAlreadyClick = false
                    btnDeleteTask.innerHTML = '<i class="icofont icofont-bin"></i>'
                    window.location.reload()
                }, 500)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isDeleteTaskAlreadyClick = false
                btnDeleteTask.innerHTML = '<i class="icofont icofont-bin"></i>'
            })
    }

    // var files
    var btnCreateTask = null
    var isCreateNewTaskAlreadyClick = false
    var projectId = document.getElementById('project-id')

    function createNewTask(projectID) {

        if (isCreateNewTaskAlreadyClick) return
        isCreateNewTaskAlreadyClick = true

        taskName = document.getElementById('task_name')
        if (taskName.value == '' || taskName.value.length < 5) {
            isCreateNewTaskAlreadyClick = false
            return
        }

        btnCreateTask = document.getElementById('btn-create-task')
        btnCreateTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('name', taskName.value)
        data.append('task_status', document.getElementById('choose_section').value)
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

                    if (result.errors.task_status) {
                        error = result.errors.task_status.replace('task_status', 'Trạng thái công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isCreateNewTaskAlreadyClick = false
                            btnCreateTask.innerHTML = 'Tạo'
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
                            isCreateNewTaskAlreadyClick = false
                            btnCreateTask.innerHTML = 'Tạo'
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
                            isCreateNewTaskAlreadyClick = false
                            btnCreateTask.innerHTML = 'Tạo'
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
                        isCreateNewTaskAlreadyClick = false
                        btnCreateTask.innerHTML = 'Tạo'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Tạo mới công việc thành công"
                });

                setTimeout(() => {
                    isCreateNewTaskAlreadyClick = false
                    btnCreateTask.innerHTML = 'Tạo'

                    window.location.reload()
                }, 500)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isCreateNewTaskAlreadyClick = false
                btnCreateTask.innerHTML = 'Tạo'
            })
    }
</script>

<script>
    var sectionName = document.getElementById('section-name')
    var submitButton = document.getElementById('submit-button')

    sectionName.addEventListener("focusout", () => {
        if (sectionName.value == '') {
            sectionName.required = false
            sectionName.style.display = 'none'

            submitButton.type = 'button'

            return
        }
    });

    function doCreateSection(event) {
        if (sectionName.style.display != 'block') {
            sectionName.required = true
            sectionName.style.display = 'block'

            submitButton.type = 'submit'
            return
        }
    }

    var createSectionAlreadyActive = false

    function createTaskStatus(event) {
        event.preventDefault()

        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        if (createSectionAlreadyActive) return
        createSectionAlreadyActive = true

        const data = new FormData()
        data.append('task_status_name', sectionName.value)
        data.append('project_id', projectId.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task-status/create') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    setTimeout(() => {

                        errProjectID = result.errors.project_id
                        if (errProjectID) {
                            errProjectID = errProjectID.replace('project_id', 'Dự án')
                            $.growl.error({
                                message: errProjectID,
                                location: 'tr',
                                size: 'large'
                            });
                        }

                        errStatusName = result.errors.task_status_name
                        if (errStatusName) {
                            errStatusName = errStatusName.replace('task_status_name', 'Tên trạng thái')
                            $.growl.error({
                                message: errStatusName,
                                location: 'tr',
                                size: 'large'
                            });
                        }
                        createSectionAlreadyActive = false
                        submitButton.innerHTML = '<i class="icofont icofont-plus"></i>'
                    }, 500)
                }

                $.growl.notice({
                    message: "Tạo mới thành công"
                });

                setTimeout(() => {
                    createSectionAlreadyActive = false
                    submitButton.innerHTML = '<i class="icofont icofont-plus"></i>'
                    window.location.reload()
                }, 500)
                return
            }).catch(() => {
                $.growl.error({
                    message: "Có lỗi xảy ra, vui lòng thử lại sau!",
                    location: 'tr',
                    size: 'large'
                });
                createSectionAlreadyActive = false
                submitButton.innerHTML = '<i class="icofont icofont-plus"></i>'
            })
    }

    var sectionNameTemp = ''
    var attempt = 1
    var inputGroutSection
    var editButton

    function showSectionEditButton(id) {
        // if (editButton) {
        //     return
        // }
        editButton = document.getElementById(`edit-section-${id}`)
        editButton.style.display = 'block'
    }

    function hideSectionEditButton(id) {
        editButton = document.getElementById(`edit-section-${id}`)
        editButton.style.display = 'none'
    }

    var sectionTitle

    function showEditSection(id) {
        sectionTitle = document.getElementById(`section-title-${id}`)
        sectionTitle.setAttribute('style', 'display:none !important');

        inputGroutSection = document.getElementById(`input-group-section-${id}`)
        inputGroutSection.style.display = 'flex'

        inputSectionName = document.getElementById(`section-name-num-${id}`)
        inputSectionName.focus()
        sectionNameTemp = inputSectionName.value
    }

    function inputGroupSectionOut(id) {
        if (0 != attempt) {
            attempt--
            return
        }
        inputSectionName = document.getElementById(`section-name-num-${id}`)
        if (sectionNameTemp == inputSectionName.value) {
            sectionTitle.style.display = 'block'
            div = document.getElementById(`input-group-section-${id}`)
            div.style.display = 'none'
        }
        attempt++
    }

    var editTaskStatusNameAlreadyActive = false
    var btnEditTaskStatusName

    function editTaskStatusName(id) {
        if (editTaskStatusNameAlreadyActive) {
            return
        }
        editTaskStatusNameAlreadyActive = true
        inputTaskStatusName = document.getElementById(`section-name-num-${id}`)
        btnEditTaskStatusName = document.getElementById(`save-edit-section-${id}`)
        btnEditTaskStatusName.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('task_status_id', id)
        data.append('task_status_name', inputTaskStatusName.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task-status/update') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {

                if (result.errors) {
                    setTimeout(() => {
                        errTaskStatusID = result.errors.task_status_id
                        if (errTaskStatusID) {
                            errTaskStatusID = errTaskStatusID.replace('task_status_id', 'Trạng thái công việc')
                            $.growl.error({
                                message: errTaskStatusID,
                                location: 'tr',
                                size: 'large'
                            });
                        }

                        errTaskStatusName = result.errors.task_status_name
                        if (errTaskStatusName) {
                            errTaskStatusName = errTaskStatusName.replace('section_name', 'Tên trạng thái công việc')
                            $.growl.error({
                                message: errTaskStatusName,
                                location: 'tr',
                                size: 'large'
                            });
                        }
                        editTaskStatusNameAlreadyActive = false
                        btnEditTaskStatusName.innerHTML = 'Lưu'
                    }, 500)

                    return
                }

                $.growl.notice({
                    message: "Cập nhật thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)
            }).catch(() => {
                $.growl.notice({
                    message: "Có lỗi xảy ra, vui lòng thử lại sau!",
                    location: 'tr',
                    size: 'large'
                });
                editTaskStatusNameAlreadyActive = false
                btnEditTaskStatusName.innerHTML = 'Lưu'
            })
    }

    var deleteTaskStatusAlreadyActive = false

    function deleteTaskStatus(id) {
        if (deleteTaskStatusAlreadyActive) {
            return
        }
        deleteTaskStatusAlreadyActive = true

        attempt = 1
        isConfirm = confirm('Bạn có chắc muốn xoá đi section này?')
        if (!isConfirm) {
            return
        }
        btnDelete = document.getElementById(`delete-section-${id}`)
        btnDelete.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('task_status_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task-status/delete') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (result.errors) {
                    setTimeout(() => {
                        $.growl.error({
                            message: result.errors,
                            location: 'tr',
                            size: 'large'
                        });
                        deleteTaskStatusAlreadyActive = false
                        btnDelete.innerHTML = 'Xoá'

                    }, 500)
                    return
                }

                $.growl.notice({
                    message: "Xoá thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 500)

            }).catch(() => {
                $.growl.error({
                    message: "Có lỗi xảy ra, vui lòng thử lại sau!",
                    location: 'tr',
                    size: 'large'
                });
                deleteTaskStatusAlreadyActive = false
                btnDelete.innerHTML = 'Xoá'
            })
    }
</script>

<?= $this->endSection() ?>