<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
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

        .nav-active {
            border-bottom: 4px solid #0099ff;
            color: #0099ff;
        }

        .hover:hover {
            background-color: #f0f5f5;
        }

        .page-link,
        label {
            font-size: 0.75rem;
        }

        .active-enable-color>a>span {
            color: #FE8A7D
        }

        .active-enable-color>a>span>i::before {
            color: #FE8A7D
        }

        .pcoded-submenu {
            margin-left: 47px;
            margin-top: 5px;
            margin-bottom: 5px;
            text-decoration: none;
        }

        .pcoded-submenu>li>a {
            text-decoration: none;
        }

        .pcoded-submenu li:hover>a {
            color: #404e67 !important
        }

        .hidden {
            display: none;
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
                    <?php if (url_is('project/*')) : ?>
                        <?= $this->include("navbar") ?>
                    <?php endif ?>
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Create new project Modal -->
    <div class="modal fade mt-5" id="createNewProject" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- modal-xl -->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo dự án mới</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="create-project">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tên dự án <span class="text-danger">*</span></label>
                            <input type="text" name="project_name" class="form-control rounded" id="project_name" placeholder="Nhập tên dự án" minlength="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Tiền tố <i class="fa fa-question-circle-o" title="Tiền tố là các chữ cái đầu của tên dự án được viết hoa và ghép lại. Giúp cho việc nhận biết các công việc nào của dự án nào một cách nhanh chóng. Bạn có thể tự định nghĩa chúng!"></i><span class="text-danger">*</span></label>
                            <input type="text" name="project_key" class="form-control rounded" id="project_key" placeholder="Tiền tố" minlength="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Mô tả cho dự án</label>
                            <textarea name="project_descriptions" class="form-control rounded" id="project_descriptions" maxlength="512" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="project_start_date" class="col-form-label">Chọn ngày bắt đầu</label>
                                    <input type="date" id="project_start_date" class="form-control rounded">
                                </div>
                                <div class="col-6">
                                    <label for="project_due_date" class="col-form-label">Chọn ngày kết thúc</label>
                                    <input type="date" id="project_due_date" class="form-control rounded">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="project_status" class="col-form-label">Trạng thái dự án</label>
                            <select id="project_status" class="form-control rounded" disabled>
                                <option value="initialize">Khởi tạo</option>
                            </select>
                        </div>

                        <div class="float-end">
                            <button type="submit" id="loading-on-click" onclick="createProject(event)" class="btn btn-primary rounded">
                                Tạo
                            </button>
                            <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Huỷ</button>
                        </div>
                    </form>
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

    <?= $this->renderSection('js') ?>

    <script>
        // ===========================>
        var createNewProjectModal = document.getElementById('createNewProject')
        var projectName = document.getElementById('project_name')
        var projectKey = document.getElementById('project_key')
        var projectDescriptions = document.getElementById('project_descriptions')
        var projectDueDate = document.getElementById('project_due_date')
        var projectStartDate = document.getElementById('project_start_date')
        var projectStatus = document.getElementById('project_status')

        let flag = false

        createNewProjectModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            // const recipient = button.getAttribute('data-bs-whatever')
        })

        projectName.addEventListener('input', () => {
            if (!flag) {
                text = projectName.value.split(' ').map(str => str.charAt(0).toUpperCase()).join('');
                projectKey.value = removeDiacritics(text)
            }
        })

        projectKey.addEventListener('input', () => {
            flag = true
            if (projectKey.value == '') {
                flag = false
            }
        })
        // <===========================

        var createProjectAlreadyClick = false

        function createProject(event) {
            if (createProjectAlreadyClick) {
                return
            }
            createProjectAlreadyClick = true

            if (projectName.value == '' ||
                projectKey.value == '' ||
                projectName.value.length < 5 ||
                projectDescriptions.value.length > 512) {

                createProjectAlreadyClick = false
                return
            }

            createButton = document.getElementById('loading-on-click')
            createButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'

            const data = new FormData();
            data.append('project_name', projectName.value);
            data.append('project_prefix', projectKey.value)
            data.append('project_descriptions', projectDescriptions.value)
            data.append('project_due_date', projectDueDate.value);
            data.append('project_start_date', projectStartDate.value)
            data.append('project_status', projectStatus.value)

            var requestOptions = {
                method: 'POST',
                body: data,
                redirect: 'follow'
            };
            fetch('<?= base_url('project/create') ?>', requestOptions)
                .then(response => {
                    return response.json();
                })
                .then(result => {
                    if (result.errors) {
                        setTimeout(() => {
                            errName = result.errors.project_name
                            if (errName) {
                                errName = errName.replace('project_name', 'Tên dự án')
                                $.growl.error({
                                    message: errName,
                                    location: 'tr',
                                    size: 'large'
                                });
                            }

                            errPrefix = result.errors.project_prefix
                            if (errPrefix) {
                                errPrefix = errPrefix.replace('project_prefix', 'Tiền tố')
                                $.growl.error({
                                    message: errPrefix,
                                    location: 'tr',
                                    size: 'large'
                                });
                            }

                            errDescription = result.errors.project_descriptions
                            if (errDescription) {
                                errDescription = errDescription.replace('project_descriptions', 'Mô tả dự án')
                                $.growl.error({
                                    message: errDescription,
                                    location: 'tr',
                                    size: 'large'
                                });
                            }

                            errStatus = result.errors.project_status
                            if (errDescription) {
                                errDescription = errDescription.replace('project_status', 'Trạng thái dự án')
                                $.growl.error({
                                    message: errDescription,
                                    location: 'tr',
                                    size: 'large'
                                });
                            }

                            errStartDate = result.errors.project_start_date
                            if (errDescription) {
                                errDescription = errDescription.replace('project_start_date', 'Ngày bắt đầu')
                                $.growl.error({
                                    message: errDescription,
                                    location: 'tr',
                                    size: 'large'
                                });
                            }

                            errEndDate = result.errors.project_end_date
                            if (errDescription) {
                                errDescription = errDescription.replace('project_end_date', 'Ngày kết thúc')
                                $.growl.error({
                                    message: errDescription,
                                    location: 'tr',
                                    size: 'large'
                                });
                            }

                            createProjectAlreadyClick = false
                            createButton.innerHTML = 'Tạo'
                        }, 500)
                        return
                    }

                    errDateTime = result.errors_datetime
                    if (errDateTime) {
                        $.growl.error({
                            message: errDateTime,
                            location: 'tr',
                            size: 'large'
                        });

                        createProjectAlreadyClick = false
                        createButton.innerHTML = 'Tạo'

                        return
                    }

                    $.growl.notice({
                        message: "Tạo mới dự án thành công"
                    });

                    setTimeout(() => {
                        createProjectAlreadyClick = false
                        createButton.innerHTML = 'Tạo'
                        window.location.href = `<?= base_url('project') ?>/${result.project_id}`
                    }, 500)

                    return
                }).catch((error) => {
                    $.growl.error({
                        message: error
                    });
                    createProjectAlreadyClick = false
                    createButton.innerHTML = 'Tạo'
                })
        }

        // ===========================>
        function removeDiacritics(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        document.getElementById("create-project").addEventListener("submit", function(event) {
            event.preventDefault()
        });

        // <===========================

        function removeAlert() {
            document.querySelectorAll(".alert").forEach(e => e.remove());
        }
    </script>
</body>

</html>