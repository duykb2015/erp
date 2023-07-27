<?= $this->extend('layout') ?>

<?= $this->section('css') ?>
<!-- Select 2 css -->
<link rel="stylesheet" href="<?= base_url() ?>templates\libraries\bower_components\select2\css\select2.min.css">
<!-- Multi Select css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>templates\libraries\bower_components\bootstrap-multiselect\css\bootstrap-multiselect.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>templates\libraries\bower_components\multiselect\css\multi-select.css">
<style>
    .breadcrumb-title div {
        display: inline;
    }

    .custom-height {
        padding-top: 6px !important;
        height: 38px !important;
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

                            <?php if (MEMBER != $userRole) : ?>
                                <div class="auth-box card">
                                    <div class="card-header">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <h5 class="card-header-text sub-title d-flex">Thêm thành viên mới vào dự án</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <!-- Notification -->
                                        <div class="row m-b-10">
                                            <div class="col-12">
                                                <?php $success = session()->getFlashdata('success') ?>
                                                <?php if (!empty($success)) :  ?>
                                                    <div class="alert alert-success mb-1 rounded">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <?= $success ?>
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
                                        <!-- End notification -->
                                        <div class="card border">
                                            <div class="card-block">
                                                <form action="" method="post">
                                                    <div class="row ">
                                                        <div class="col-12">
                                                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                            <input type="hidden" name="project_prefix" value="<?= $project['prefix'] ?>">
                                                            <label for="add_new_member" class="p-b-10">Nhập email người dùng</label>
                                                            <select name="user_id" class="add-member col-sm-12 rounded"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row m-b-10">
                                                        <div class="col-12">
                                                            <label class="p-b-10 d-block">&nbsp;</label>
                                                            <button class="btn btn-primary rounded custom-height f-right">Thêm</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <?php if (OWNER == $userRole && ADMIN == session()->get('type')) : ?>
                                            <div class="row">
                                                <div class="col-11 mb-2">
                                                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                    <label for="add_new_member" class="p-b-10">Hoặc tạo mới người dùng và thêm vào dự án!</label>
                                                    <br>
                                                    <button class="btn btn-primary rounded custom-height" data-bs-toggle="modal" data-bs-target="#createUserAndAddToProject">Tạo</button>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endif ?>

                            <div class="auth-box card">
                                <div class="card-header">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <h5 class="card-header-text sub-title d-flex">Danh sách thành viên</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <ul class="media-list mt-3">
                                        <?php $currentUser = session()->get('user_id') ?>

                                        <?php if (!empty($members)) : ?>
                                            <div class="card-block accordion-block">
                                                <?php foreach ($members as $user) : ?>
                                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="accordion-panel">
                                                            <div class="accordion-heading" role="tab" id="headingOne">
                                                                <h3 class="card-title accordion-title">
                                                                    <!-- class="accordion-msg" -->
                                                                    <div class="card shadow-sm border bg-light text-dark m-t-20 m-l-20 m-r-20 m-b-0" style="border-bottom-right-radius: unset;border-bottom-left-radius: unset;">
                                                                        <div class="row my-3 mx-1">
                                                                            <div class="col-auto p-r-0">
                                                                                <div class="u-img">
                                                                                    <img src="<?= base_url("imgs/{$user['photo']}") ?>" alt="user image" width="70" height="70" class="img-radius cover-img">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col">
                                                                                <h6 class="m-b-5"><b><a class="text-decoration-none"><?= $user['username'] ?></a></b> <span class="f-12d m-l-5"><?= PROJECT_ROLE[$user['role']] ?></span></h6>
                                                                                <p class="m-b-0"><?= $user['email'] ?></p>
                                                                            </div>
                                                                            <div class="col-1">
                                                                                <?php if (session()->get('user_id') == $project['owner'] && OWNER != $user['role']) : ?>
                                                                                    <div class="dropdown-secondary dropdown d-inline-block" id="context-menu">
                                                                                        <button class="btn btn-sm btn-primary waves-light" type="button" id="owner-power-<?= $user['project_user_id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                                        <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                            <?php if (MEMBER == $user['role']) : ?>
                                                                                                <a class="dropdown-item waves-light waves-effect" onclick="changeRoleToLeader(<?= $user['project_user_id'] ?>, <?= $project['id'] ?>)"><i class="icofont icofont-arrow-up "></i> Thăng trưởng nhóm</a>
                                                                                            <?php endif ?>
                                                                                            <?php if (LEADER == $user['role']) : ?>
                                                                                                <a class="dropdown-item waves-light waves-effect" onclick="changeRoleToMember(<?= $user['project_user_id'] ?>)"><i class="icofont icofont-arrow-down"></i> Về thành viên</a>
                                                                                            <?php endif ?>
                                                                                            <a class="dropdown-item waves-light waves-effect" id="btn-delete-member" onclick="removeUser(<?= $user['project_user_id'] ?>, 0)"><i class="icofont icofont-ui-delete p-r-5"></i>Xoá khỏi dự án</a>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php else : ?>
                                                                                    <?php if (session()->get('user_id') == $user['user_id'] && session()->get('user_id') != $project['owner']) : ?>
                                                                                        <div class="dropdown-secondary dropdown d-inline-block" id="context-menu">
                                                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="owner-power-<?= $user['project_user_id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                                <a class="dropdown-item waves-light waves-effect" id="btn-delete-member" onclick="removeUser(<?= $user['project_user_id'] ?>, 1)"><i class="icofont icofont-ui-delete p-r-5"></i>Rời khỏi dự án</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endif ?>
                                                                                <?php endif ?>
                                                                            </div>
                                                                            <?php if (session()->get('user_id') != $user['user_id']) : ?>
                                                                                <div class="justify-content-center d-flex" onclick="changeIcon(<?= $user['user_id'] ?>)" id="show-project-<?= $user['user_id'] ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $user['user_id'] ?>" aria-expanded="true" aria-controls="collapse-<?= $user['user_id'] ?>">
                                                                                    <i class="icofont icofont-curved-down"></i>
                                                                                </div>
                                                                            <?php else : ?>
                                                                                <div class="justify-content-center d-flex">
                                                                                    &nbsp;
                                                                                </div>
                                                                            <?php endif ?>
                                                                        </div>
                                                                    </div>
                                                                </h3>
                                                            </div>
                                                            <?php if (session()->get('user_id') != $user['user_id']) : ?>
                                                                <div id="collapse-<?= $user['user_id'] ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                                    <div class="accordion-content accordion-desc">
                                                                        <div class="card border" style="border-top: none !important;border-top-left-radius: unset;border-top-right-radius: unset;">
                                                                            <div class="card-header">
                                                                                <h5 class="card-header-text">Dự án thành viên đang tham gia chung</h5>

                                                                            </div>
                                                                            <div class="card-block">
                                                                                <ul class="media-list mt-3">
                                                                                    <?php if (!empty($user['projects'])) : ?>
                                                                                        <?php foreach ($user['projects'] as $project) : ?>
                                                                                            <hr>
                                                                                            <li class="media d-flex">
                                                                                                <div class="media-left">
                                                                                                    <a href="#">
                                                                                                        <img class="media-object img-radius comment-img" src="<?= base_url("imgs/{$project['photo']}") ?>" alt="Generic placeholder image">
                                                                                                    </a>
                                                                                                </div>
                                                                                                <div class="media-body w-100">
                                                                                                    <a href="<?= base_url("project/{$project['prefix']}") ?>" class="text-decoration-none">
                                                                                                        <h6 class="media-heading txt-primary">[<?= $project['prefix'] ?>] <?= $project['name'] ?></h6>
                                                                                                    </a>
                                                                                                    <p class="text-truncate"><?= $project['descriptions'] ?></p>
                                                                                                </div>
                                                                                            </li>
                                                                                        <?php endforeach ?>
                                                                                    <?php endif ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach ?>
                                                <div class="m-20">
                                                    <?= !empty($pager) ? $pager->links('default', 'default') : '' ?>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mt-5" id="createUserAndAddToProject" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <!-- modal-xl -->
    <div class="modal-dialog modal-dialog-scrollable modal-l">
        <div class="modal-content">
            <div class="modal-body">
                <form class="md-float-material form-material needs-validation" onsubmit="createUserAndAddToProject(event)" method="POST" novalidate>
                    <input type="hidden" id="project_id1" value="<?= $project['id'] ?>">
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center">Tạo người dùng và thêm vào dự án</h3>
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <label class="p-1" for="username">Tài khoản <span class="text-danger">*</span></label>
                                <input type="text" id="username1" value="<?= set_value('username') ?>" class="form-control rounded" placeholder="Tài khoản" minlength="3" required>
                            </div>
                            <div class="form-group form-primary">
                                <label class="p-1" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email1" value="<?= set_value('email') ?>" class="form-control rounded" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập một địa chỉ email hợp lệ.
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <label class="p-1" for="password">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" id="password1" class="form-control rounded" placeholder="Mật khẩu" minlength="4" required>
                                <div class="invalid-feedback">
                                    Mật khẩu tối thiểu 4 kí tự.
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <label class="p-1" for="re_password">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" id="re_password1" class="form-control rounded" placeholder="Nhập lại mật khẩu" minlength="4" required>
                            </div>
                            <div class="form-group form-primary">
                                <label class="p-1" for="firstname">Họ</label>
                                <input type="text" id="firstname1" value="<?= set_value('firstname') ?>" class="form-control rounded" placeholder="Họ">
                            </div>
                            <div class="form-group form-primary">
                                <label class="p-1" for="lastname">Tên</label>
                                <input type="text" id="lastname1" value="<?= set_value('lastname') ?>" class="form-control rounded" placeholder="Tên">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" id="btn-create-12" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center rounded mt-3">Tạo</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js')  ?>

<!-- Select 2 js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\select2\js\select2.full.min.js"></script>
<!-- Multiselect js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\multiselect\js\jquery.multi-select.js"></script>
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\js\jquery.quicksearch.js"></script>
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url() ?>templates\libraries\assets\pages\advance-elements\select2-custom.js"></script>
<script>
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

    var createUserAndAddToProjectAlreadyClick = false
    var btnCreateUser

    function createUserAndAddToProject(event) {
        event.preventDefault()

        if (createUserAndAddToProjectAlreadyClick) return
        createUserAndAddToProjectAlreadyClick = true

        btnCreateUser = document.getElementById('btn-create-12')
        btnCreateUser.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        let username = document.getElementById('username1')
        let email = document.getElementById('email1')
        let password = document.getElementById('password1')
        let re_password = document.getElementById('re_password1')
        let firstname = document.getElementById('firstname1')
        let lastname = document.getElementById('lastname1')
        let projectID = document.getElementById('project_id1')

        if (username.value == '' ||
            email.value == '' ||
            password == '' ||
            re_password == '') {
            btnCreateUser.innerHTML = 'Tạo'
            createUserAndAddToProjectAlreadyClick = false
            return
        }

        const data = new FormData()
        data.append('username', username.value)
        data.append('email', email.value)
        data.append('password', password.value)
        data.append('re_password', re_password.value)
        data.append('firstname', firstname.value)
        data.append('lastname', lastname.value)
        data.append('project_id', projectID.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
        }
        fetch('<?= base_url('user/create-and-add-to-project') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    if (result.errors.username) {
                        errUsername = result.errors.username.replace('username', 'Tài khoản')
                        $.growl.error({
                            message: errUsername,
                            location: 'tr',
                            size: 'large'
                        });

                        btnCreateUser.innerHTML = 'Tạo'
                        createUserAndAddToProjectAlreadyClick = false
                        return
                    }

                    if (result.errors.email) {
                        errEmail = result.errors.email.replace('email', 'Email')
                        $.growl.error({
                            message: errEmail,
                            location: 'tr',
                            size: 'large'
                        });

                        btnCreateUser.innerHTML = 'Tạo'
                        createUserAndAddToProjectAlreadyClick = false
                        return
                    }

                    if (result.errors.password) {
                        errPassword = result.errors.password.replace('password', 'Mật khẩu')
                        $.growl.error({
                            message: errPassword,
                            location: 'tr',
                            size: 'large'
                        });

                        btnCreateUser.innerHTML = 'Tạo'
                        createUserAndAddToProjectAlreadyClick = false
                        return
                    }

                    if (result.errors.re_password) {
                        errRepassword = result.errors.re_password.replace('re_password', 'Nhập lại mật khẩu')
                        $.growl.error({
                            message: errRepassword,
                            location: 'tr',
                            size: 'large'
                        });

                        btnCreateUser.innerHTML = 'Tạo'
                        createUserAndAddToProjectAlreadyClick = false
                        return
                    }

                    if (result.errors.project_id) {
                        errProjectID = result.errors.project_id.replace('project_id', 'Dự án')
                        $.growl.error({
                            message: errProjectID,
                            location: 'tr',
                            size: 'large'
                        });

                        btnCreateUser.innerHTML = 'Tạo'
                        createUserAndAddToProjectAlreadyClick = false
                        return
                    }

                    btnCreateUser.innerHTML = 'Tạo'
                    createUserAndAddToProjectAlreadyClick = false
                    return
                }

                $.growl.notice({
                    message: "Thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 300)

            }).catch((e) => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                    location: 'tr',
                    size: 'large'
                });
                btnCreateUser.innerHTML = 'Tạo'
                createUserAndAddToProjectAlreadyClick = false
            })

    }
</script>
<script>
    $(".add-member").select2({
        ajax: {
            method: 'POST',
            url: "<?= base_url('project/find/user') ?>",
            dataType: 'json',
            delay: 200,
            data: function(params) {
                const request = {
                    email: params.term,
                    project: <?= $project['id'] ?>
                }

                return request;
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        },
    });

    var changeRoleToLeaderAlreadyClick = false

    var ownerPower

    function changeRoleToLeader(projectUserId, projectID) {
        if (changeRoleToLeaderAlreadyClick) return
        changeRoleToLeaderAlreadyClick = true

        ownerPower = document.getElementById(`owner-power-${projectUserId}`)
        ownerPower.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('project_user_id', projectUserId)
        data.append('project_id', projectID)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
        }
        fetch('<?= base_url('project/change-role-leader') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    errProjectUserID = result.errors.project_user_id
                    if (errProjectUserID) {
                        $.growl.error({
                            message: errProjectUserID,
                            location: 'tr',
                            size: 'large'
                        });

                        changeRoleToLeaderAlreadyClick = false
                        ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        return
                    }

                    errProjectID = result.errors.project_id
                    if (errProjectID) {
                        $.growl.error({
                            message: errProjectID,
                            location: 'tr',
                            size: 'large'
                        });

                        changeRoleToLeaderAlreadyClick = false
                        ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        return
                    }
                }

                $.growl.notice({
                    message: "Thành công"
                });

                changeRoleToLeaderAlreadyClick = false
                ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                setTimeout(() => {
                    window.location.reload()
                }, 300)

            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                    location: 'tr',
                    size: 'large'
                });
                changeRoleToLeaderAlreadyClick = false
                ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }

    var changeRoleToLeaderAlreadyClick = false

    function changeRoleToMember(projectUserId) {
        if (changeRoleToLeaderAlreadyClick) return
        changeRoleToLeaderAlreadyClick = true

        ownerPower = document.getElementById(`owner-power-${projectUserId}`)
        ownerPower.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('project_user_id', projectUserId)
        data.append('project_id', <?= $project['id'] ?>)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
        }
        fetch('<?= base_url('project/change-role-member') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    errProjectID = result.errors.project_user_id
                    if (errProjectUserID) {
                        $.growl.error({
                            message: errProjectUserID,
                            location: 'tr',
                            size: 'large'
                        });

                        changeRoleToLeaderAlreadyClick = false
                        ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        return
                    }
                }

                $.growl.notice({
                    message: "Thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 300)

            }).catch(() => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                    location: 'tr',
                    size: 'large'
                });
                changeRoleToLeaderAlreadyClick = false
                ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }

    var deleteUserAlreadyClick = false

    function removeUser(id, type) {

        if (deleteUserAlreadyClick) return
        deleteUserAlreadyClick = true

        if (type == 0) {
            if (!confirm('Bạn có chắc là muốn xoá người dùng này khỏi dự án?')) {
                deleteUserAlreadyClick = false
                return
            }
        } else {
            if (!confirm('Bạn có chắc là muốn rời khỏi dự án này?')) {
                deleteUserAlreadyClick = false
                return
            }
        }

        ownerPower = document.getElementById(`owner-power-${id}`)
        ownerPower.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('project_user_id', id)
        data.append('type', type)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
        }
        fetch('<?= base_url('project/remove-user') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {

                    errProjectUserID = result.errors.project_user_id
                    if (errProjectUserID) {
                        $.growl.error({
                            message: errProjectUserID,
                            location: 'tr',
                            size: 'large'
                        });

                        deleteUserAlreadyClick = false
                        ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        return
                    }

                    error = result.errors
                    if (error) {
                        $.growl.error({
                            message: error,
                            location: 'tr',
                            size: 'large'
                        });

                        deleteUserAlreadyClick = false
                        ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        return
                    }
                }

                deleteUserAlreadyClick = false
                ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'

                if (type == 1) {
                    window.location.href = '<?= base_url('project') ?>'
                    return
                }

                $.growl.notice({
                    message: "Đã xoá thành viên khỏi dự án!"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 300)

            }).catch((e) => {
                $.growl.error({
                    message: 'Có lỗi xảy ra, vui lòng thử lại sau!',
                    location: 'tr',
                    size: 'large'
                });
                deleteUserAlreadyClick = false
                ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
            })
    }

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
</script>
<?= $this->endSection() ?>