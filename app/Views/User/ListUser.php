<?= $this->extend('layout') ?>

<?= $this->section('css') ?>
<style>
    .breadcrumb-title div {
        display: inline;
    }

    .custom-height {
        padding-top: 6px !important;
        height: 38px !important;
    }

    .admin-role {
        color: red !important;
    }

    .moderator-role {
        color: blue !important;
    }

    .no-hover-color {
        color: inherit !important;
    }

    .card-header {
        padding: 25px 25px 5px 25px !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Danh sách thành viên trong hệ thống</h4>
                            <span>Thông tin về các thành viên sẽ hiển thị tại đây</span>
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
                                <a href="<?= base_url('user-management') ?>" class="text-decoration-none">Danh sách thành viên</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row justify-content-center d-flex">
                <div class="col-lg-12">
                    <div class="card border">
                        <div class="card-header">
                            <h5 class="card-header-text">Danh sách thành viên trong hệ thống</h5>
                            <span>Chọn vào một người dùng để xem danh sách dự án họ đang tham gia.</span>
                        </div>
                        <?php if (!empty($users)) : ?>
                            <div class="card-block accordion-block">
                                <?php foreach ($users as $user) : ?>
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
                                                                <h6 class="m-b-5"><b><a class="text-decoration-none"><?= $user['username'] ?></a></b> <span class="f-12 text-muted m-l-5 <?= $user['type'] ?>-role"><?= USER_TYPE[$user['type']] ?></span></h6>
                                                                <p class="text-muted m-b-0"><?= $user['email'] ?></p>
                                                            </div>
                                                            <div class="col-3">
                                                                <p class="m-b-0"><b>Dự án đang tham gia:</b> <?= $user['totalProject'] ?? 0 ?></p>
                                                                <p class="m-b-0"><b>Công việc đang thực hiện:</b> <?= $user['totalTask'] ?? 0 ?></p>
                                                            </div>
                                                            <div class="col-1">
                                                                <?php if (ADMIN != $user['type']) : ?>
                                                                    <?php if (MODERATOR == $user['type']) : ?>
                                                                        <div class="dropdown-secondary dropdown d-inline-block f-right">
                                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="revoke-role-<?= $user['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                <a class="dropdown-item waves-light waves-effect" onclick="revokeModRole(<?= $user['id'] ?>)"><i class="icofont icofont-arrow-down"></i> Huỷ quyền Quản trị viên</a>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif ?>
                                                                    <?php if (USER == $user['type']) :  ?>
                                                                        <div class="dropdown-secondary dropdown d-inline-block f-right">
                                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="grant-role-<?= $user['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                                <a class="dropdown-item waves-light waves-effect" onclick="grantModRole(<?= $user['id'] ?>)"><i class="icofont icofont-arrow-up"></i> Cấp quyền Quản trị viên</a>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif ?>
                                                                <?php endif ?>
                                                            </div>
                                                            <div class="justify-content-center d-flex" id="show-project-<?= $user['id'] ?>" onclick="changeIcon(<?= $user['id'] ?>)" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $user['id'] ?>" aria-expanded="true" aria-controls="collapse-<?= $user['id'] ?>">
                                                                <i class="icofont icofont-curved-down"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </h3>
                                            </div>
                                            <div id="collapse-<?= $user['id'] ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="accordion-content accordion-desc">
                                                    <div class="card border" style="border-top: none !important;border-top-left-radius: unset;border-top-right-radius: unset;">
                                                        <div class="card-header">
                                                            <h5 class="card-header-text">Dự án thành viên đang tham gia</h5>
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
                                                                <?php else : ?>
                                                                    <p>Ngươi dùng này chưa tham gia dự án nào</p>
                                                                <?php endif ?>
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
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js')  ?>

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

    var grantModRoleAlreadyClick = false
    var grantRoleContaiter

    function grantModRole(id) {

        if (grantModRoleAlreadyClick) return
        grantModRoleAlreadyClick = true

        if (!confirm('Bạn có chắc là muốn cấp quyền Quản Trị Viên cho người dùng này?')) {
            grantModRoleAlreadyClick = false
            return
        }

        grantRoleContaiter = document.getElementById(`grant-role-${id}`)
        grantRoleContaiter.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('user_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
        }
        fetch('<?= base_url('user/grant-mod-role') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    errUserID = result.errors.user_id
                    if (errUserID) {
                        $.growl.error({
                            message: errUserID,
                            location: 'tr',
                            size: 'large'
                        });

                        grantModRoleAlreadyClick = false
                        grantRoleContaiter.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                        return
                    }
                }

                $.growl.notice({
                    message: "Thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 300)

            }).catch((err) => {
                $.growl.error({
                    message: err,
                    location: 'tr',
                    size: 'large'
                });
                grantRoleContaiter.innerHTML = '<i class="icofont icofont-navigation-menu"></i>'
                grantModRoleAlreadyClick = false
            })
    }

    revokeModRoleAlreadyClick = false
    var revokeRoleContainer

    function revokeModRole(id) {

        if (revokeModRoleAlreadyClick) return
        revokeModRoleAlreadyClick = true

        if (!confirm('Bạn có chắc là muốn thu hồi quyền của người dùng này?')) {
            revokeModRoleAlreadyClick = false
            return
        }

        revokeRoleContainer = document.getElementById(`revoke-role-${id}`)
        revokeRoleContainer.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

        const data = new FormData()
        data.append('user_id', id)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow',
        }
        fetch('<?= base_url('user/revoke-mod-role') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    errUserID = result.errors.user_id
                    if (errUserID) {
                        $.growl.error({
                            message: errUserID,
                            location: 'tr',
                            size: 'large'
                        });

                        revokeRoleContainer = false
                        return
                    }
                }

                $.growl.notice({
                    message: "Thành công"
                });

                setTimeout(() => {
                    window.location.reload()
                }, 300)

            }).catch((err) => {
                $.growl.error({
                    message: err,
                    location: 'tr',
                    size: 'large'
                });
                revokeRoleContainer = false
            })
    }
</script>

<?= $this->endSection() ?>