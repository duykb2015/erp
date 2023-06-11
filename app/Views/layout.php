<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">

    <!-- Boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Favicon icon -->
    <link rel="icon" href="<?= base_url() ?>\templates\libraries\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
  
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\icon\feather\css\feather.css">

    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\pages\notification\notification.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\icon\themify-icons\themify-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\icon\font-awesome\css\font-awesome.min.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\icon\icofont\css\icofont.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\assets\css\style.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\css\app.css">
    <link href="<?= base_url() ?>\templates\css\jquery.growl.css" rel="stylesheet" type="text/css" />

    <!-- ckeditor js -->
    <script src="<?= base_url() ?>/ckeditor/ckeditor.js"></script>

    <?= $this->renderSection('css') ?>

    <style>
        body {
            font-size: 16px;
        }

        select.form-control:not([size]):not([multiple]) {
            height: auto !important;
        }
    </style>
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div style="position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -50px;
        margin-left: -50px;
        width: 100px;
        height: 100px;" class='contain'>
            <div class="preloader3 loader-block">
                <div class="circ1 loader-primary loader-md"></div>
                <div class="circ2 loader-primary loader-md"></div>
                <div class="circ3 loader-primary loader-md"></div>
                <div class="circ4 loader-primary loader-md"></div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <?= $this->include("header") ?>
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\jquery\js\jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\popper.js\js\popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\bootstrap\js\bootstrap.min.js"></script>

    <!-- notification js -->
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\bootstrap-growl.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\pages\notification\notification.js"></script>

        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>

    <!-- custom js -->
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\vartical-layout.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\script.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\pcoded.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>\templates\js\app.js"></script>
    <!-- ajax -->

    <script src="<?= base_url() ?>\templates\js\jquery.growl.js" type="text/javascript"></script>
    
    <script>
        $('#remove-alert').on('click', function() {
            $('.alert').remove();
        })

        $(function() {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                container: 'body',
                boundary: 'body',
                fallbackPlacement: ['bottom', 'bottom', 'bottom', 'bottom']
            })
        })
    </script>
</body>

</html>