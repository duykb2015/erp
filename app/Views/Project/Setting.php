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
                                                    <label class="p-1" for="username">Tên dự án <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?= $project['name'] ?>" name="name" class="form-control rounded" placeholder="Tên dự án" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <label class="p-1" for="prefix">Tiền tố <span class="text-danger">*</span></label>
                                                    <input type="text" value="<?= $project['key'] ?>" class="form-control rounded" placeholder="Email" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <label class="p-1" for="lastname">Chủ sở hữu</label>
                                                    <input type="text" name="owner" value="" class="form-control rounded" placeholder="Nhập họ...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-4">
                                                <div class="form-group form-primary">
                                                    <label class="p-1" for="lastname">Mô tả</label>
                                                    <textarea type="text" name="descriptions" value="" class="form-control rounded"><?= $project['key'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Create new project Modal -->
                                        <div class="modal fade mt-5" id="changeProfileAvatar" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
                                            <!-- modal-xl -->
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thay đổi ảnh đại diện</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="file" name="user_avatar" id="image-upload" accept="image/*">
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
                                            <a href="<?= base_url('user') ?>" id="edit-cancel" class=" rounded btn btn-default waves-effect float-end">Cancel</a>
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
    function saveAvatar() {

        if (!window.localStorage.getItem('img-name')) {
            return
        }

        if (alreadyClick) {
            return
        }
        alreadyClick = true

        saveButton = document.getElementById('save-image')
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        setTimeout(() => {
            window.localStorage.removeItem('img-name')
            window.location.reload()
        }, 500)
    }

    function cancelSave() {
        cancelSaveButton = document.getElementById('cancel-save-image')
        cancelSaveButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        confirm = confirm('Bạn có chắc là muốn huỷ sự thay đổi này?')
        if (!confirm) {
            return
        }

        // img = window.localStorage.getItem('img-name')

        // const data = new FormData()
        // data.append('img', $img)

        var requestOptions = {
            method: 'POST',
        }

        fetch('<?= base_url('user/image/cancel') ?>', requestOptions)
        cancelSaveButton.innerHTML = 'Huỷ'
        // window.localStorage.removeItem('img-name')
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
</script>

<?= $this->endSection() ?>