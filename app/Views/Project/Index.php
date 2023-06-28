<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
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

    .hidden {
        display: none;
    }

    .item {
        padding: 0.3em 1.2em;
    }

    .item:hover {
        background-color: rgba(44, 141, 247, 0.2);
        cursor: pointer;
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
                                                            <h5 class="card-header-text sub-title d-flex" onmouseenter="editSectionName(<?= $section['id'] ?>)" onmouseleave="rollBackEdit(<?= $section['id'] ?>)">
                                                                <?= $section['title'] ?>&nbsp;<i class="icofont icofont-pencil-alt-5 hidden" id="edit-section-<?= $section['id'] ?>" onclick="showEditSection(<?= $section['id'] ?>)"></i>
                                                                <div class="input-group hidden" id="input-group-section-<?= $section['id'] ?>" onfocusout="inputGroupSectionOut(<?= $section['id'] ?>)">
                                                                    <input type="text" class="form-control" id="section-name-num-<?= $section['id'] ?>" value="<?= $section['title'] ?>">
                                                                    <button type="button" id="save-edit-section-<?= $section['id'] ?>" class="btn btn-primary" onclick="saveNewName(<?= $section['id'] ?>)">Lưu</button>
                                                                    <button type="button" id="delete-section-<?= $section['id'] ?>" class="btn btn-danger" onclick="deleteSection(<?= $section['id'] ?>)">Xoá</button>
                                                                </div>
                                                            </h5>
                                                        </div>
                                                        <div class="card-block p-b-0">
                                                            <div class="row">
                                                                <div class="col-md-12" id="draggableMultiple">
                                                                    <?php if (!empty($section['tasks'])) : ?>
                                                                        <?php foreach ($section['tasks'] as $task) : ?>
                                                                            <div class="sortable-moves border" oncontextmenu="showContextMenu(event, <?= $task['id'] ?>)">
                                                                                <p id="task-num-<?= $task['id'] ?>" onclick="window.location.href = '<?= base_url('project/') . $project['id'] . '/task/' . $task['id'] ?>'"><?= $task['title'] ?></p>

                                                                                <div class="dropdown-secondary dropdown d-inline-block" id="context-menu-<?= $task['id'] ?>">
                                                                                    <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                                    <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                        <a class="dropdown-item waves-light waves-effect" href="<?= base_url('project/') . $project['id'] . '/task/' . $task['id'] ?>"><i class="icofont icofont-eye-alt"></i>Xem</a>
                                                                                        <a class="dropdown-item waves-light waves-effect" id="btn-delete-task-<?= $task['id'] ?>" onclick="deleteTask(<?= $task['id'] ?>)"><i class="icofont icofont-ui-delete"></i>Xoá</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach ?>
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

<div class="modal modal-xl fade mt-5" id="createNewTask" tabindex="-1" data-bs-backdrop="static" aria-labelledby="" aria-hidden="true">
    <!-- modal-xl -->
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <form class="needs-validation" id="create-project">
                    <div class="mb-3">
                        <label for="task_name" class="col-form-label">Tên công việc<span class="text-danger">*</span></label>
                        <input type="text" name="task_name" class="form-control rounded" id="project_name" placeholder="Nhập tên dự án" minlength="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Trạng thái công việc</label>
                        <select name="choose_section" class="form-control">
                            <?php if (!empty($sections)) : ?>
                                <?php foreach ($sections as $section) : ?>
                                    <option value="<?= $section['id'] ?>"><?= $section['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Tiền tố <i class="fa fa-question-circle-o" title="Tiền tố là các chữ cái đầu của tên dự án được viết hoa và ghép lại. Giúp cho việc nhận biết các công việc nào của dự án nào một cách nhanh chóng. Bạn có thể tự định nghĩa chúng!"></i><span class="text-danger">*</span></label>
                        <input type="text" name="project_key" class="form-control rounded" id="project_key" placeholder="Tiền tố" minlength="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Mô tả cho dự án</label>
                        <textarea name="project_descriptions" class="form-control rounded" id="project_descriptions" maxlength="512" rows="5"></textarea>
                    </div>

                    <div class="float-end">
                        <button type="submit" id="loading-on-click" onclick="createTask(event)" class="btn btn-primary rounded">
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

<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\Sortable\js\Sortable.js"></script>
<!-- Select 2 js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\select2\js\select2.full.min.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\advance-elements\select2-custom.js"></script>

<script>
    // window.addEventListener('beforeunload', function(){})

    draggablePanelList = document.getElementById('draggablePanelList');
    Sortable.create(draggablePanelList, {
        group: 'draggablePanelList',
        animation: 150,
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
        // Element dragging ended
        onEnd: function( /**Event*/ evt) {
            evt.to; // target list
            evt.from; // previous list
            evt.oldIndex; // element's old index within old parent
            evt.newIndex; // element's new index within new parent
            // console.log(evt.item, evt.oldIndex, evt.newIndex)
        },
    });

    let sectionName = document.getElementById('section-name')
    let submitButton = document.getElementById('submit-button')
    let createSectionAlreadyActive = false

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

        if (createSectionAlreadyActive)
        {
            return
        }
        createSectionAlreadyActive = true

        projectId = document.getElementById('project-id')
        const data = new FormData()
        data.append('section_name', sectionName.value)
        data.append('project_id', projectId.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('project/section/create') ?>', requestOptions)
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

    let sectionNameTemp = ''
    let attempt = 1

    function editSectionName(id) {
        if ('flex' == document.getElementById(`input-group-section-${id}`).style.display) {
            return
        }
        editButton = document.getElementById(`edit-section-${id}`)
        editButton.style.display = 'block'
    }

    function showEditSection(id) {
        div = document.getElementById(`input-group-section-${id}`)
        div.style.display = 'flex'

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
            div = document.getElementById(`input-group-section-${id}`)
            div.style.display = 'none'
        }
        attempt++
    }

    function rollBackEdit(id) {
        editButton = document.getElementById(`edit-section-${id}`)
        editButton.style.display = 'none'
    }

    function saveNewName(id) {
        inputSectionName = document.getElementById(`section-name-num-${id}`)
        btnSave = document.getElementById(`save-edit-section-${id}`)
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'


        const data = new FormData()
        data.append('section_id', id)
        data.append('section_name', inputSectionName.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };

        fetch('<?= base_url('project/section/update') ?>', requestOptions)
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
                        alreadyClick = false
                        btnSave.innerHTML = 'Lưu'
                    }, 1000)
                }
            })
    }

    function deleteSection(id) {
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

        fetch('<?= base_url('project/section/delete') ?>', requestOptions)
            .then(response => response.json())
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
                        message: 'Section đang chứa công việc, không thể xoá!',
                        location: 'tr',
                        size: 'large'
                    });
                    alreadyClick = false
                    btnDelete.innerHTML = 'Xoá'
                }, 1000)
            })
    }

    function deleteTask(id) {
        btnDeleteTask = document.getElementById(`btn-delete-task-${id}`)
        btnDeleteTask.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        isConfirm = confirm('Bạn có chắc là muốn xoá công việc này?')

        if (!isConfirm) {
            return
        }

        setTimeout(function() {
            $.growl.notice({
                message: "Xoá thành công"
            });
            btnDeleteTask.innerHTML = '<i class="icofont icofont-ui-delete"></i>Xoá'
        }, 3000)

    }
</script>

<?= $this->endSection() ?>