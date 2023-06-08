<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng ký</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url() ?>\templates\libraries\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\bower_components\bootstrap\css\bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\pages\notification\notification.css">

    <!-- Animate.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\bower_components\animate.css\css\animate.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\css\style.css">

    <style>
        label {
            font-size: 0.75rem;
        }
    </style>
</head>

<body class="fix-menu">
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->

                    <form class="md-float-material form-material needs-validation" method="POST" action="<?= base_url('auth/register') ?>" novalidate>
                        <div class="text-center">
                            <img src="<?= base_url() ?>\templates\libraries\assets\images\logo.png" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Đăng ký</h3>
                                    </div>
                                    <div class="col-12">
                                        <?php $success = session()->getFlashdata('success') ?>
                                        <?php if (!empty($success)) :  ?>
                                            <div class="alert alert-success mb-1">
                                                Đăng ký thành công, giờ bạn có thể đăng nhập
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-12">
                                        <?php $errors = session()->getFlashdata('error_msg') ?>
                                        <?php if (!empty($errors)) :  ?>
                                            <?php if (!is_array($errors)) : ?>
                                                <div class="alert alert-danger mb-1">
                                                    <?= $errors ?>
                                                </div>
                                            <?php else : ?>
                                                <?php foreach ($errors as $error) : ?>
                                                    <div class="alert alert-danger mb-1">
                                                        <?= $error ?>
                                                    </div>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <label for="username">Tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="username" value="<?= set_value('username') ?>" class="form-control rounded" placeholder="Tài khoản" minlength="3" required>
                                </div>
                                <div class="form-group form-primary">
                                    <label for="username">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="<?= set_value('email') ?>" class="form-control rounded" placeholder="Email" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập một địa chỉ email hợp lệ.
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <label for="username">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control rounded" placeholder="Mật khẩu" minlength="4" required>
                                </div>
                                <div class="form-group form-primary">
                                    <label for="username">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="re_password" class="form-control rounded" placeholder="Nhập lại mật khẩu" minlength="4" required>
                                </div>
                                <div class="form-group form-primary">
                                    <label for="username">Họ</label>
                                    <input type="text" name="firstname" value="<?= set_value('firstname') ?>" class="form-control rounded" placeholder="Họ">
                                </div>
                                <div class="form-group form-primary">
                                    <label for="username">Tên</label>
                                    <input type="text" name="lastname" value="<?= set_value('lastname') ?>" class="form-control rounded" placeholder="Tên">

                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center rounded">Đăng ký</button>
                                    <div></div>
                                    <p class="text-center m-b-5"><span class="text-decoration-line-through">------------</span> hoặc <span class="text-decoration-line-through">------------</span></p>
                                    <a href="login" class="btn btn-outline-secondary btn-md btn-block waves-effect waves-light text-center rounded">Đăng nhập</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>

    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\jquery\js\jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\bootstrap\js\bootstrap.min.js"></script>

    <!-- notification js -->
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\bootstrap-growl.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\js\app.js"></script>

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
    </script>

</body>

</html>