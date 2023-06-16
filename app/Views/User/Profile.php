<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<style>
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
                            <h4>Thông tin cá nhân</h4>
                            <span>Thông tin về cá nhân</span>
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
                                <h5 class="card-header-text">Thông tin cơ bản</h5>
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
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-primary">
                                            <label class="p-1" for="username">Tài khoản</label>
                                            <input type="text" value="<?= $user['username'] ?>" class="form-control rounded" placeholder="Tài khoản" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-primary">
                                            <label class="p-1" for="email">Email</label>
                                            <input type="email" value="<?= $user['email'] ?>" class="form-control rounded" placeholder="Email" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-primary">
                                            <label class="p-1" for="lastname">Họ</label>
                                            <input type="text" name="firstname" value="<?= $user['firstname'] ?? set_value('firstname') ?>" class="form-control rounded" placeholder="Nhập họ...">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-primary">
                                            <label class="p-1" for="lastname">Tên</label>
                                            <input type="text" name="lastname" value="<?= $user['lastname'] ?? set_value('lastname') ?>" class="form-control rounded" placeholder="Nhập tên...">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-primary">
                                            <label class="p-1" for="lastname">Mật khẩu cũ</label>
                                            <input type="password" name="old_password" class="form-control rounded" placeholder="Nhập mật khẩu cũ" minlength="4">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-primary">
                                            <label class="p-1" for="lastname">Mật khẩu mới</label>
                                            <input type="password" name="new_password" class="form-control rounded" placeholder="Nhập khẩu mới nếu bạn muốn thay đổi" minlength="4">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        Hình đại diện...
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <div class="col-12">
                                        <a href="<?= base_url('user') ?>" id="edit-cancel" class=" rounded btn btn-default waves-effect float-end">Cancel</a>
                                        <button class="btn btn-primary rounded waves-effect waves-light m-r-20 float-end">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

    function removeAlert() {
        document.querySelectorAll(".alert").forEach(e => e.remove());
    }
</script>

<?= $this->endSection() ?>