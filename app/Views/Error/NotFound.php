<!DOCTYPE html>

<html lang="en-us" class="no-js">

<head>
    <meta charset="utf-8">
    <title>Không tìm thấy</title>
    <meta name="description" content="Flat able 404 Error page design">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Codedthemes">
    <!-- Favicon -->
    <link rel="shortcut icon" href="img\favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>\templates\libraries\extra-pages\404\1\css\style.css">
</head>

<body>

    <div class="image"></div>

    <!-- Your logo on the top left -->
    <a href="#" class="logo-link" title="back home">

        <img src="<?= base_url() ?>\templates\libraries\extra-pages\404\1\img\logo.png" class="logo" alt="Company's logo">

    </a>

    <div class="content">

        <div class="content-box">

            <div class="big-content">

                <!-- Main squares for the content logo in the background -->
                <div class="list-square">
                    <span class="square"></span>
                    <span class="square"></span>
                    <span class="square"></span>
                </div>

                <!-- Main lines for the content logo in the background -->
                <div class="list-line">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </div>

                <!-- The animated searching tool -->
                <i class="fa fa-search" aria-hidden="true"></i>

                <!-- div clearing the float -->
                <div class="clear"></div>

            </div>

            <!-- Your text -->
            <h1>404 NOT FOUND.</h1>

            <p>Trang bạn tìm kiếm không tồn tại.<br>
                Có thể trang bạn yêu cầu đã được di chuyển tới một nơi khác.</p>

        </div>

    </div>

    <footer class="light">

        <ul>
            <li><a href="/">Trang chủ</a></li>
            <li><a href="<?= base_url($backLink ?? '') ?>">Quay lại trang trước đó</a></li>
        </ul>

    </footer>
    <script src="<?= base_url() ?>\templates\libraries\extra-pages\404\1\js\jquery.min.js"></script>
    <script src="<?= base_url() ?>\templates\libraries\extra-pages\404\1\js\bootstrap.min.js"></script>

</body>

</html>