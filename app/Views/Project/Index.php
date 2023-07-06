<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\css\jquery.filer.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\css\themes\jquery.filer-dragdropbox-theme.css">

<style>
    .breadcrumb-title div {
        display: inline;
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

    .badge-custom-0 {
        border-radius: 4px;
        padding: 2px 6px;
        margin-right: 4px;
        color: <?= BASE_SECTION[0]['color'] ?> !important;
        background-color: <?= BASE_SECTION[0]['background'] ?> !important;
    }

    .badge-custom-1 {
        border-radius: 4px;
        padding: 2px 6px;
        margin-right: 4px;
        color: <?= BASE_SECTION[1]['color'] ?> !important;
        background-color: <?= BASE_SECTION[1]['background'] ?> !important;
    }

    .badge-custom-2 {
        border-radius: 4px;
        padding: 2px 6px;
        margin-right: 4px;
        color: <?= BASE_SECTION[2]['color'] ?> !important;
        background-color: <?= BASE_SECTION[2]['background'] ?> !important;
    }

    .badge-custom-3 {
        border-radius: 4px;
        padding: 2px 6px;
        margin-right: 4px;
        color: <?= BASE_SECTION[3]['color'] ?> !important;
        background-color: <?= BASE_SECTION[3]['background'] ?> !important;
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
                                        <a href="<?= base_url('project/') . $project['id'] ?>" class="text-decoration-none">Chi tiết dự án</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border d-flex">
                                <div class="card-block scroll-x">
                                    <div class="row flex-nowrap" id="draggablePanelList">
                                        <?php if (!empty($sections)) : ?>
                                            <?php foreach ($sections as $section) : ?>
                                                <div class="col-3">
                                                    <div class="card border">
                                                        <div class="card-header">
                                                            <h5 class="card-header-text sub-title d-flex text-wrap overflow-auto" onmouseenter="showSectionEditButton(<?= $section['id'] ?>)" onmouseleave="hideSectionEditButton(<?= $section['id'] ?>)">
                                                                <span class="d-flex badge-custom-<?= $section['base_section'] ?>" id="section-title-<?= $section['id'] ?>">
                                                                    <?= $section['title'] ?>
                                                                </span>
                                                                <i class="icofont icofont-pencil-alt-5 hidden" id="edit-section-<?= $section['id'] ?>" onclick="showEditSection(<?= $section['id'] ?>)"></i>
                                                            </h5>
                                                            <div class="input-group hidden" id="input-group-section-<?= $section['id'] ?>" onfocusout="inputGroupSectionOut(<?= $section['id'] ?>)">
                                                                <input type="text" class="form-control" id="section-name-num-<?= $section['id'] ?>" value="<?= $section['title'] ?>">
                                                                <button type="button" id="save-edit-section-<?= $section['id'] ?>" class="btn btn-primary" onclick="saveNewSection(<?= $section['id'] ?>)">Lưu</button>
                                                                <button type="button" id="delete-section-<?= $section['id'] ?>" class="btn btn-danger" onclick="deleteSection(<?= $section['id'] ?>)">Xoá</button>
                                                            </div>
                                                        </div>
                                                        <div class="card-block p-b-0">
                                                            <div class="row">
                                                                <div class="col-md-12 section-container" id="draggableMultiple">
                                                                    <?php if (!empty($section['tasks'])) : ?>
                                                                        <?php foreach ($section['tasks'] as $task) : ?>
                                                                            <div class="sortable-moves border box">
                                                                                <p class="task-name hover-pointer overflow-auto" id="task-num-<?= $task['id'] ?>" onclick="redirect_url('<?= base_url('project/') . $project['id'] . '/task/' . $task['id'] ?>')"><?= $task['title'] ?></p>

                                                                                <div class="dropdown-secondary dropdown d-inline-block" id="context-menu-<?= $task['id'] ?>">
                                                                                    <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown-<?= $task['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                                    <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                        <a class="dropdown-item waves-light waves-effect" data-bs-toggle="modal" data-bs-target="#changeTaskStatus"><i class="icofont icofont-listine-dots"></i>Chuyển trạng thái</a>
                                                                                        <a class="dropdown-item waves-light waves-effect" id="btn-delete-task-<?= $task['id'] ?>" onclick="deleteTask(<?= $task['id'] ?>)"><i class="icofont icofont-ui-delete"></i>Xoá</a>
                                                                                    </div>
                                                                                </div>
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
                                        <div class="col-3">
                                            <div class="card border">
                                                <div class="card-block">
                                                    <form action="" method="post" onsubmit="createSection(event)" id="save-section">
                                                        <div class="input-group">
                                                            <input type="hidden" id="project-id" value="<?= $project['id'] ?>">
                                                            <input type="text" name="section_name" id="section-name" class="form-control hidden">
                                                            <button type="button" id="submit-button" class="btn btn-primary input-group-addon" onclick="doCreateSection()"><i class="icofont icofont-plus"></i></button>
                                                        </div>
                                                    </form>
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
        </div>
    </div>
</div>

<!-- Create new project Modal -->
<div class="modal fade mt-5" id="changeTaskStatus" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- modal-xl -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chuyển trạng thái công việc</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Trạng thái công việc<span class="text-danger"> *</span></label>
                    <select id="change-section" class="form-control">
                        <?php if (!empty($sections)) : ?>
                            <?php foreach ($sections as $section) : ?>
                                <option value="<?= $section['id'] ?>"><?= $section['title'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="float-end mb-1">
                    <button type="submit" id="btn-update-task-status" onclick="changeTaskStatus(<?= isset($task['id']) ? $task['id'] : '' ?>)" class="btn btn-primary rounded">
                        Chuyển
                    </button>
                    <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Huỷ</button>
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
                <form class="needs-validation" id="create-project">
                    <div class="mb-3">
                        <label for="task_name" class="col-form-label">Tên công việc<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control rounded" id="task_name" placeholder="Nhập tên công việc ..." minlength="5" maxlength="512" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Trạng thái công việc<span class="text-danger"> *</span></label>
                        <select id="choose_section" class="form-control" disabled>
                            <?php if (!empty($sections)) : ?>
                                <option value="<?= $sections[0]['id'] ?>"><?= $sections[0]['title'] ?></option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Người được giao</label>
                        <select id="assignee" class="form-control">
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
                        <label for="task_descriptions" class="col-form-label">Chọn mức độ ưu tiên</label>
                        <select id="task_priority" class="form-control">
                            <?php foreach (TASK_PRIORITY as $key => $priority) : ?>
                                <option value="<?= $key ?>"><?= $priority ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="task_start_date" class="col-form-label">Chọn ngày bắt đầu</label>
                                <input type="date" id="task_start_date" class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="task_due_date" class="col-form-label">Chọn ngày kết thúc</label>
                                <input type="date" id="task_due_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="task_descriptions" class="col-form-label">Mô tả cho dự án</label>
                        <textarea id="task_descriptions" class="form-control rounded" id="task_descriptions" maxlength="512" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="user_avatar" class="col-form-label">Thêm tệp đính kèm</label>
                        <br>
                        <label for="user_avatar" class="col-form-label">Tính năng đang được bảo trì</label>
                        <!-- <input type="file" id="attachment" accept="*"> -->
                    </div>

                    <div class="float-end mb-5">
                        <button type="submit" id="btn-create-task" onclick="createNewTask(<?= $project['id'] ?>)" class="btn btn-primary rounded">
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
<script src="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\js\jquery.filer.js"></script>
<script src="<?= base_url() ?>templates\libraries\assets\pages\filer\custom-filer.js" type="text/javascript"></script>
<script src="<?= base_url() ?>templates\libraries\assets\pages\filer\jquery.fileuploads.init.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\Sortable\js\Sortable.js"></script>
<!-- Select 2 js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\select2\js\select2.full.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\advance-elements\select2-custom.js"></script>

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
            items: ['Table']
        }],
        removeDialogTabs: 'image:advanced;link:advanced',
    })
</script>

<!-- Dragable -->
<script>
    draggablePanelList = document.getElementById('draggablePanelList');
    Sortable.create(draggablePanelList, {
        group: 'draggablePanelList',
        animation: 150,
        cursor: 'move',
        // Element dragging ended
        onEnd: function( /**Event*/ evt) {
            evt.to; // target list
            evt.from; // previous list
            evt.oldIndex; // element's old index within old parent
            evt.newIndex; // element's new index within new parent
            // console.log(evt.item, evt.oldIndex, evt.newIndex)
        },
    });

    draggableMultiple = document.getElementById('draggableMultiple');
    Sortable.create(draggableMultiple, {
        group: 'draggableMultiple',
        animation: 150,
        cursor: 'move',
        // Element dragging ended
        onEnd: function( /**Event*/ evt) {
            evt.to; // target list
            evt.from; // previous list
            evt.oldIndex; // element's old index within old parent
            evt.newIndex; // element's new index within new parent
            // console.log(evt.item, evt.oldIndex, evt.newIndex)
        },
    });
</script>

<script>
    var isChangeTaskStatusAlreadyClick = false
    var btnChangeTaskStatus

    function changeTaskStatus(taskID) {
        if (isChangeTaskStatusAlreadyClick) return
        isChangeTaskStatusAlreadyClick = true

        btnChangeTaskStatus = document.getElementById('btn-update-task-status')
        btnChangeTaskStatus.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('task_id', taskID)
        data.append('section_id', document.getElementById('change-section').value)

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
                    if (result.errors.task_id) {
                        error = result.errors.section.replace('section', 'Trạng thái công việc')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isChangeTaskStatusAlreadyClick = false
                            btnChangeTaskStatus.innerHTML = 'Chuyển'
                        }, 1000)

                        return
                    }

                    if (result.errors.section_id) {
                        error = result.errors.assignee.replace('assignee', 'Người được giao')
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });
                        setTimeout(() => {
                            isChangeTaskStatusAlreadyClick = false
                            btnChangeTaskStatus.innerHTML = 'Chuyển'
                        }, 1000)

                        return
                    }
                }

                $.growl.notice({
                    message: "Cập nhật trạng thái thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 1000)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isChangeTaskStatusAlreadyClick = false
                btnChangeTaskStatus.innerHTML = 'Chuyển'
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
        if (taskName.value == '') {
            isCreateNewTaskAlreadyClick = false
            return
        }

        btnCreateTask = document.getElementById('btn-create-task')
        btnCreateTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('name', taskName.value)
        data.append('section', document.getElementById('choose_section').value)
        data.append('assignee', document.getElementById('assignee').value)
        data.append('priority', document.getElementById('task_priority').value)
        data.append('start_date', document.getElementById('task_start_date').value)
        data.append('due_date', document.getElementById('task_due_date').value)
        data.append('descriptions', task_descriptions.getData())
        data.append('project_id', projectID)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task/create') ?>', requestOptions)
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
                            isCreateNewTaskAlreadyClick = false
                            btnCreateTask.innerHTML = 'Tạo'
                        }, 1000)

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
                        }, 1000)

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
                        }, 1000)

                        return
                    }
                }

                if (result.errors_datetime) {
                    console.log(result.errors_datetime)
                    $.growl.error({
                        message: result.errors_datetime,
                        location: 'tr',
                        size: 'large'
                    });
                    setTimeout(() => {
                        isCreateNewTaskAlreadyClick = false
                        btnCreateTask.innerHTML = 'Tạo'
                    }, 1000)

                    return
                }

                $.growl.notice({
                    message: "Tạo mới công việc thành công"
                });

                setTimeout(() => {
                    isCreateNewTaskAlreadyClick = false
                    btnCreateTask.innerHTML = 'Tạo'
                    window.location.href = `<?= base_url('project') ?>/${projectID}/task/${result.task_id}`
                }, 1000)

                return
            }).catch(error => {
                $.growl.error({
                    message: error
                });
                isCreateNewTaskAlreadyClick = false
                btnCreateTask.innerHTML = 'Tạo'
            })
    }

    var menuContext
    var isDeleteTaskAlreadyClick = false

    function deleteTask(id) {
        menuContext = document.getElementById(`dropdown-${id}`)
        if (isDeleteTaskAlreadyClick) return
        isDeleteTaskAlreadyClick = true

        // btnDeleteTask = document.getElementById(`btn-delete-task-${id}`)
        // btnDeleteTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'
        menuContext.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        isConfirm = confirm('Bạn có chắc là muốn xoá công việc này?')

        if (!isConfirm) {
            return
        }

        const data = new FormData()
        data.append('task_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('task/delete') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                setTimeout(function() {
                    $.growl.notice({
                        message: "Xoá thành công"
                    });
                    window.location.reload()
                }, 1500)
            }).catch(error => {
                $.growl.error({
                    message: error,
                    location: 'tr',
                    size: 'large'
                });
                // btnDeleteTask.innerHTML = '<i class="icofont icofont-ui-delete"></i>Xoá'
                menuContext.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            });

    }
</script>

<script>
    var sectionName = document.getElementById('section-name')
    var submitButton = document.getElementById('submit-button')
    var createSectionAlreadyActive = false

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

    function createSection(event) {
        event.preventDefault()

        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        if (createSectionAlreadyActive) {
            return
        }
        createSectionAlreadyActive = true

        const data = new FormData()
        data.append('section_name', sectionName.value)
        data.append('project_id', projectId.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('section/create') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (0 == result.length) {
                    $.growl.notice({
                        message: "Tạo mới thành công"
                    });

                    setTimeout(() => {
                        window.location.reload()
                    }, 1500)
                    return
                }

                if (result.errors) {
                    setTimeout(() => {
                        if (result.errors.project_id) {
                            result.errors.project_id = result.errors.project_id.replace('project_id', 'Mã dự án')
                            $.growl.error({
                                message: result.errors.project_name,
                                location: 'tr',
                                size: 'large'
                            });
                        }
                        if (result.errors.section_name) {
                            result.errors.section_name = result.errors.section_name.replace('section_name', 'Tên Section')
                            $.growl.error({
                                message: result.errors.section_name,
                                location: 'tr',
                                size: 'large'
                            });
                        }
                        createSectionAlreadyActive = false
                        submitButton.innerHTML = '<i class="icofont icofont-plus"></i>'
                    }, 1000)
                }
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

    var saveNewNameAlreadyActive = false

    function saveNewSection(id) {
        if (saveNewNameAlreadyActive) {
            return
        }
        saveNewNameAlreadyActive = true
        inputSectionName = document.getElementById(`section-name-num-${id}`)
        btnSaveSection = document.getElementById(`save-edit-section-${id}`)
        btnSaveSection.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('section_id', id)
        data.append('section_name', inputSectionName.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('section/update') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (0 == result.length) {
                    $.growl.notice({
                        message: "Cập nhật thành công"
                    });

                    setTimeout(() => {
                        window.location.reload()
                    }, 1500)
                    return
                }

                if (result.errors) {
                    setTimeout(() => {
                        if (result.errors.section_id) {
                            result.errors.section_id = result.errors.section_id.replace('section_id', 'Mã Section')
                            $.growl.error({
                                message: result.errors.project_name,
                                location: 'tr',
                                size: 'large'
                            });
                        }
                        if (result.errors.section_name) {
                            result.errors.section_name = result.errors.section_name.replace('section_name', 'Tên Section')
                            $.growl.error({
                                message: result.errors.section_name,
                                location: 'tr',
                                size: 'large'
                            });
                        }
                        saveNewNameAlreadyActive = false
                        btnSaveSection.innerHTML = 'Lưu'
                    }, 1000)
                }
            })
    }

    var deleteSectionAlreadyActive = false

    function deleteSection(id) {
        if (deleteSectionAlreadyActive) {
            return
        }
        deleteSectionAlreadyActive = true

        attempt = 1
        isConfirm = confirm('Bạn có chắc muốn xoá đi section này?')
        if (!isConfirm) {
            return
        }
        btnDelete = document.getElementById(`delete-section-${id}`)
        btnDelete.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('section_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('section/delete') ?>', requestOptions)
            .then(response => {
                return response.json()
            })
            .then(result => {
                if (0 == result.length) {
                    $.growl.notice({
                        message: "Xoá thành công"
                    });

                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                    return
                }

                setTimeout(() => {
                    $.growl.error({
                        message: result.errors,
                        location: 'tr',
                        size: 'large'
                    });
                    deleteSectionAlreadyActive = false
                    btnDelete.innerHTML = 'Xoá'
                }, 500)

            }).catch((error) => {
                $.growl.error({
                    message: error,
                    location: 'tr',
                    size: 'large'
                });
                deleteSectionAlreadyActive = false
                btnDelete.innerHTML = 'Xoá'
            })
    }
</script>

<?= $this->endSection() ?>