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
                    <!-- Authentication card start -->
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
                                <?php if (!empty($users)) : ?>
                                    <?php foreach ($users as $user) : ?>
                                        <li class="media d-flex">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object img-radius comment-img" src="<?= base_url() . '/imgs/' . $user['photo'] ?>" alt="Generic placeholder image">
                                                </a>
                                            </div>
                                            <div class="media-body w-100">
                                                <h6 class="media-heading txt-primary"><?= $user['firstname'] . ' ' . $user['lastname'] ?> <span class="f-12 text-muted m-l-5 <?= $user['type'] ?>-role"><?= USER_TYPE[$user['type']] ?></span></h6>
                                                <p><?= $user['email'] ?></p>
                                                <hr>
                                            </div>
                                            <?php if (ADMIN != $user['type']) : ?>
                                                <?php if (MODERATOR == $user['type']) : ?>
                                                    <div class="media-right">
                                                        <div class="dropdown-secondary dropdown d-inline-block">
                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="revoke-role-<?= $user['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                <a class="dropdown-item waves-light waves-effect" id="btn-delete-member" onclick="revokeModRole(<?= $user['id'] ?>)"><i class="icofont icofont-arrow-down"></i> Huỷ quyền Quản trị viên</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                <?php if (USER == $user['type']) :  ?>
                                                    <div class="media-right">
                                                        <div class="dropdown-secondary dropdown d-inline-block">
                                                            <button class="btn btn-sm btn-primary waves-light" type="button" id="grant-role-<?= $user['id'] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                                <a class="dropdown-item waves-light waves-effect" id="btn-delete-member" onclick="grantModRole(<?= $user['id'] ?>)"><i class="icofont icofont-arrow-up"></i> Cấp quyền Quản trị viên</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </li>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </ul>
                            <?= !empty($pager) ? $pager->links('default', 'default') : '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js')  ?>

<script>
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