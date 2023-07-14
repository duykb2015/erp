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
                                                                Đã thêm thành viên.
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
                                        <form action="" method="post">
                                            <div class="row m-b-20">
                                                <div class="col-11 mb-2">
                                                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                    <label for="add_new_member" class="p-b-10">Nhập email người dùng</label>
                                                    <select name="user_id" class="add-member col-sm-12"></select>
                                                </div>
                                                <div class="col-1">
                                                    <label class="p-b-10 d-block">&nbsp;</label>
                                                    <button class="btn btn-primary rounded custom-height">Thêm</button>
                                                </div>
                                            </div>
                                        </form>

                                        <?php if (OWNER == $userRole && ADMIN == session()->get('type')) : ?>
                                            <div class="row">
                                                <div class="col-11 mb-2">
                                                    <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                                                    <label for="add_new_member" class="p-b-10">Hoặc tạo mới người dùng và thêm vào dự án!</label>
                                                    <br>
                                                    <button class="btn btn-primary rounded custom-height">Tạo</button>
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
                                            <?php foreach ($members as $member) : ?>
                                                <li class="media d-flex">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object img-radius comment-img" src="<?= base_url() . '/imgs/' . $member['photo'] ?>" alt="Generic placeholder image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body w-100">
                                                        <h6 class="media-heading txt-primary"><?= $member['username'] ?> <?= session()->get('user_id') == $member['user_id'] ? '(Bạn)' : '' ?><span class="f-12 text-muted m-l-5"><?= PROJECT_ROLE[$member['role']] ?></span></h6>
                                                        <p><?= $member['email'] ?></p>
                                                        <hr>
                                                    </div>
                                                    <div class="media-right">
                                                        <?php if (session()->get('user_id') == $project['owner'] && OWNER != $member['role']) : ?>
                                                            <div class="dropdown-secondary dropdown d-inline-block" id="context-menu">
                                                                <button class="btn btn-sm btn-primary waves-light" type="button" id="owner-power-<?= $member['project_user_id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                    <?php if (MEMBER == $member['role']) : ?>
                                                                        <a class="dropdown-item waves-light waves-effect" onclick="changeRoleToLeader(<?= $member['project_user_id'] ?>, <?= $project['id'] ?>)"><i class="icofont icofont-arrow-up "></i> Thăng trưởng nhóm</a>
                                                                    <?php endif ?>
                                                                    <?php if (LEADER == $member['role']) : ?>
                                                                        <a class="dropdown-item waves-light waves-effect" onclick="changeRoleToMember(<?= $member['project_user_id'] ?>)"><i class="icofont icofont-arrow-down"></i> Về thành viên</a>
                                                                    <?php endif ?>
                                                                    <a class="dropdown-item waves-light waves-effect" id="btn-delete-member" onclick="removeUser(<?= $member['project_user_id'] ?>, 0)"><i class="icofont icofont-ui-delete p-r-5"></i>Xoá khỏi dự án</a>
                                                                </div>
                                                            </div>
                                                        <?php else : ?>
                                                            <?php if (session()->get('user_id') == $member['user_id']) : ?>
                                                                <div class="dropdown-secondary dropdown d-inline-block" id="context-menu">
                                                                    <button class="btn btn-sm btn-primary waves-light" type="button" id="owner-power-<?= $member['project_user_id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                        <a class="dropdown-item waves-light waves-effect" id="btn-delete-member" onclick="removeUser(<?= $member['project_user_id'] ?>, 1)"><i class="icofont icofont-ui-delete p-r-5"></i>Rời khỏi dự án</a>
                                                                    </div>
                                                                </div>
                                                            <?php endif ?>
                                                        <?php endif ?>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
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
    $(".add-member").select2({
        ajax: {
            method: 'POST',
            url: "<?= base_url('project/find/user') ?>",
            dataType: 'json',
            delay: 1000,
            data: function(params) {
                const request = {
                    email: params.term
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

                $.growl.notice({
                    message: "Đã xoá thành viên khỏi dự án!"
                });

                deleteUserAlreadyClick = false
                ownerPower.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'

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
</script>
<?= $this->endSection() ?>