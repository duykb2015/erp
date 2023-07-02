<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\css\jquery.filer.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\css\themes\jquery.filer-dragdropbox-theme.css">
<style>
    .breadcrumb-title div {
        display: inline;
    }

    .jFiler-item-trash-action {
        text-decoration: none;
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
                                        <a href="<?= base_url('project/') . $project['id'] ?>/setting" class="text-decoration-none">Cài đặt dự án</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row justify-content-center d-flex">
                        <div class="col-lg-12">
                            <!-- Authentication card start -->
                            <form class="md-float-material form-material needs-validation" method="POST" action="" novalidate>
                                <div class="auth-box card">
                                    <div class="card-header">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <h5 class="card-header-text sub-title d-flex">Thông tin cơ bản</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row m-b-20">
                                            <div class="col-12">
                                                <?php $success = session()->getFlashdata('success') ?>
                                                <?php if (!empty($success)) :  ?>
                                                    <div class="alert alert-success mb-1 rounded">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                Cập nhật thông tin thành công.
                                                            </div>
                                                            <div class="col-1">
                                                                <i onclick="removeAlert()" class="feather icon-x-circle float-end"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                            <div class="col-12">
                                                <?php $errors = session()->getFlashdata('error_msg') ?>
                                                <?php if (!empty($errors)) :  ?>
                                                    <?php if (!is_array($errors)) : ?>
                                                        <div class="alert alert-danger mb-1 rounded">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <?= $errors ?>
                                                                </div>
                                                                <div class="col-1">
                                                                    <i onclick="removeAlert()" class="feather icon-x-circle float-end"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <?php foreach ($errors as $error) : ?>
                                                            <div class="alert alert-danger mb-1 rounded">
                                                                <div class="row">
                                                                    <div class="col-11">
                                                                        <?= $error ?>
                                                                    </div>
                                                                    <div class="col-1">
                                                                        <i onclick="removeAlert()" class="feather icon-x-circle float-end"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach ?>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <div class="card border">
                                                    <div class="social-profile">
                                                        <img class="img-fluid width-90 height-90 pb-3" src="<?= base_url('imgs/') . $project['photo'] ?>" alt="Avatar">
                                                        <div class="profile-hvr m-t-15" data-bs-toggle="modal" data-bs-target="#changeProjectAvatar">
                                                            <i class="icofont icofont-ui-edit p-r-10" type="button"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <input type="hidden" name="id" value="<?= $project['id'] ?>">
                                                    <label class="p-1" for="username">Tên dự án <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?= $project['name'] ?>" name="name" class="form-control rounded" placeholder="Tên dự án" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <label class="p-1" for="prefix">Tiền tố <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?= $project['key'] ?>" class="form-control rounded" placeholder="Email" disabled title="Tiền tố không thể sửa.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <label class="p-1" for="lastname">Chủ sở hữu</label>
                                                    <select name="owner" class="form-control rounded">
                                                        <?php foreach ($members as $member) : ?>
                                                            <option value="<?= $member['user_id'] ?>" <?= $member['user_id'] == $project['owner'] ? 'selected' : '' ?>><?= $member['username'] ?> <?= $member['user_id'] == $project['owner'] ? '(Chủ sở hữu)' : '' ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <label class="p-1" for="lastname">Mô tả</label>
                                                    <textarea type="text" name="descriptions" value="" class="form-control rounded"><?= $project['descriptions'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Create new project Modal -->
                                        <div class="modal fade mt-5" id="changeProjectAvatar" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
                                            <!-- modal-xl -->
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <input type="hidden" id="project-id" value="<?= $project['id'] ?>">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thay đổi ảnh dự án</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="file" name="project_avatar" id="project-image-upload" accept="image/*">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="save-image" onclick="saveAvatar()" class="btn btn-primary rounded waves-effect waves-light float-end">Lưu</button>
                                                        <button type="button" id="cancel-save-image" onclick="cancelSave()" class="btn btn-secondary rounded waves-effect waves-light float-end" data-bs-dismiss="modal">Huỷ</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-4 mb-3">
                                            <a href="<?= base_url('project/') . $project['id'] . '/setting' ?>" id="edit-cancel" class=" rounded btn btn-default waves-effect float-end">Cancel</a>
                                            <button class="btn btn-primary rounded waves-effect waves-light m-r-20 float-end">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js')  ?>

<!-- jquery file upload js -->
<script src="<?= base_url() ?>templates\libraries\assets\pages\jquery.filer\js\jquery.filer.js"></script>
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\filer\custom-filer.js"></script>
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\filer\jquery.fileuploads.init.js"></script>

<script>
    var alreadyClick = false

    function saveAvatar() {

        if (!window.localStorage.getItem('project-img-name')) {
            return
        }

        if (alreadyClick) {
            return
        }
        alreadyClick = true

        saveButton = document.getElementById('save-image')
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        setTimeout(() => {
            window.localStorage.removeItem('project-img-name')
            window.location.reload()
        }, 500)
    }

    function cancelSave() {
        cancelSaveButton = document.getElementById('cancel-save-image')
        cancelSaveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        isConfirm = confirm('Bạn có chắc là muốn huỷ sự thay đổi này?')
        if (!isConfirm) {
            return
        }

        var requestOptions = {
            method: 'POST',
        }

        fetch('<?= base_url('project/' . $project['id'] . '/image/cancel') ?>', requestOptions)
        cancelSaveButton.innerHTML = 'Huỷ'
    }

    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()

    function removeAlert() {
        document.querySelectorAll(".alert").forEach(e => e.remove());
    }

    $("#project-image-upload").filer({
        limit: 1,
        maxSize: 10,
        fileMaxSize: 10,
        extensions: ['jpg', 'png', 'jpeg'],
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Kéo và thả tệp vào đây</h3> <span style="display:inline-block; margin: 15px 0"> hoặc </span></div><a class="jFiler-input-choose-btn blue">Chọn tệp</a></div></div>',
        showThumbs: true,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
					<div class="jFiler-item-container">\
						<div class="jFiler-item-inner">\
							<div class="jFiler-item-thumb">\
								<div class="jFiler-item-status"></div>\
								<div class="jFiler-item-thumb-overlay">\
									<div class="jFiler-item-info">\
										<div style="display:table-cell;vertical-align: middle;">\
											<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
											<span class="jFiler-item-others">{{fi-size2}}</span>\
										</div>\
									</div>\
								</div>\
								{{fi-image}}\
							</div>\
							<div class="jFiler-item-assets jFiler-row">\
								<ul class="list-inline pull-left">\
									<li>{{fi-progressBar}}</li>\
								</ul>\
								<ul class="list-inline pull-right">\
									<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
								</ul>\
							</div>\
						</div>\
					</div>\
				</li>',
            itemAppend: '<li class="jFiler-item">\
						<div class="jFiler-item-container">\
							<div class="jFiler-item-inner">\
								<div class="jFiler-item-thumb">\
									<div class="jFiler-item-status"></div>\
									<div class="jFiler-item-thumb-overlay">\
										<div class="jFiler-item-info">\
											<div style="display:table-cell;vertical-align: middle;">\
												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
												<span class="jFiler-item-others">{{fi-size2}}</span>\
											</div>\
										</div>\
									</div>\
									{{fi-image}}\
								</div>\
								<div class="jFiler-item-assets jFiler-row">\
									<ul class="list-inline pull-left">\
										<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
									</ul>\
									<ul class="list-inline pull-right">\
										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
									</ul>\
								</div>\
							</div>\
						</div>\
					</li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            canvasImage: true,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null,
            dragContainer: null,
        },
        uploadFile: {
            url: '/project/<?= $project['id'] ?>/image/upload',
            data: null,
            type: 'POST',
            enctype: 'multipart/form-data',
            synchron: true,
            beforeSend: function() {
                alreadyClick = true

                saveButton = document.getElementById('save-image')
                saveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'
            },
            success: function(data, itemEl, listEl, boxEl, newInputEl, inputEl, id) {
                window.localStorage.setItem('project-img-name', data)
                var parent = itemEl.find(".jFiler-jProgressBar").parent(),
                    new_file_name = data //JSON.parse(),
                filerKit = inputEl.prop("jFiler");

                filerKit.files_list[id].name = new_file_name;

                itemEl.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                    $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Thành công</div>").hide().appendTo(parent).fadeIn("slow");
                });

                alreadyClick = false
                saveButton = document.getElementById('save-image')
                saveButton.innerHTML = 'Lưu'
            },
            error: function(el) {
                var parent = el.find(".jFiler-jProgressBar").parent();
                el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                    $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Thất bại</div>").hide().appendTo(parent).fadeIn("slow");
                });
                alreadyClick = false
                saveButton = document.getElementById('save-image')
                saveButton.innerHTML = 'Lưu'
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        },
        files: null,
        addMore: false,
        allowDuplicates: true,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
            var filerKit = inputEl.prop("jFiler"),
                file_name = filerKit.files_list[id].name;

            $.post('/project/<?= $project['id'] ?>/image/remove', {
                file: file_name
            });
        },
        onEmpty: null,
        options: null,
        dialogs: {
            alert: function(text) {
                return alert(text);
            },
            confirm: function(text, callback) {
                confirm(text) ? callback() : null;
            }
        },
        captions: {
            button: "Chọn ảnh",
            feedback: "Chọn ảnh để tải lên",
            feedback2: "Ảnh đã được chọn",
            drop: "Thả ảnh vào đây để tải lên",
            removeConfirmation: "Bạn có chắc là muốn xoá ảnh này?",
            errors: {
                filesLimit: "Tối đa chỉ được tải lên {{fi-limit}} ảnh.",
                filesType: "Chỉ hộ trợ tải lên hình ảnh.",
                filesSize: "{{fi-name}} quá lớn, dung lượng tối đa mà ảnh có thể tải lên là {{fi-fileMaxSize}} MB.",
                filesSizeAll: "Tệp bạn tải lên quá lớn, dung lượng tối đa mà ảnh có thể tải lên là {{fi-maxSize}} MB.",
                folderUpload: "Bạn không được phép tải thư mục lên."
            }
        }
    });
</script>

<?= $this->endSection() ?>