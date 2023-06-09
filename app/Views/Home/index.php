<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- <div class="pcoded-content"> -->
<!-- <div class="pcoded-inner-content"> -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-12">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Danh sách dự án</h4>
                            <span>Các dự án mà bạn tham gia sẽ được hiển thị ở đây.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card user-activity-card">
                        <div class="card-block">
                            <div class="card z-depth-bottom-2">
                                <div class="row m-3">
                                    <div class="col-auto p-r-0">
                                        <div class="u-img">
                                            <img src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" alt="user image" class="img-radius cover-img">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="m-b-5">Công việc hằng ngày</h6>
                                        <p class="text-muted m-b-0">Tổng hợp công việc sẽ diễn ra hằng ngày.</p>
                                        <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: 4 tiếng trước.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card z-depth-bottom-2">
                                <div class="row m-3">
                                    <div class="col-auto p-r-0">
                                        <div class="u-img">
                                            <img src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" alt="user image" class="img-radius cover-img">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="m-b-5">Công việc hằng ngày</h6>
                                        <p class="text-muted m-b-0">Tổng hợp công việc sẽ diễn ra hằng ngày.</p>
                                        <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: 4 tiếng trước.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card z-depth-bottom-2">
                                <div class="row m-3">
                                    <div class="col-auto p-r-0">
                                        <div class="u-img">
                                            <img src="<?= base_url() ?>\templates\libraries\assets\images\avatar-4.jpg" alt="user image" class="img-radius cover-img">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="m-b-5">Công việc hằng ngày</h6>
                                        <p class="text-muted m-b-0">Tổng hợp công việc sẽ diễn ra hằng ngày.</p>
                                        <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: 4 tiếng trước.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="text-center">
                                <a href="#!" class="b-b-primary text-primary text-decoration-none">Thêm dự án</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createNewProject" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- modal-xl -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo dự án mới</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('project/create') ?>" method="POST">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tên dự án <span class="text-danger">*</span></label>
                        <input type="text" name="project_name" class="form-control" id="project_name" placeholder="Nhập tên dự án" required>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Tiếp đầu ngữ <span class="text-danger">*</span></label>
                        <input type="text" name="project_prefix" class="form-control" id="project_prefix" placeholder="Nhập tiếp đầu ngữ" required>
                    </div>

                    <div class="float-end">
                        <button type="submit" class="btn btn-primary rounded">Tạo</button>
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const createNewProjectModal = document.getElementById('createNewProject')
    const projectName = document.getElementById('project_name')
    const projectPrefix = document.getElementById('project_prefix')
    let flag = false

    createNewProjectModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        // const modalTitle = exampleModal.querySelector('.modal-title')
        // const modalBodyInput = exampleModal.querySelector('.modal-body input')

        // modalTitle.textContent = `New message to ${recipient}`
        // modalBodyInput.value = recipient
    })

    projectName.addEventListener('input', () => {
        if (!flag) {
            text = projectName.value.split(' ').map(str => str.charAt(0).toUpperCase()).join('');
            projectPrefix.value = removeDiacritics(text)
        }
    })

    projectPrefix.addEventListener('input', () => {
        flag = true
        if (projectPrefix.value == '') {
            flag = false
        }
    })



    function removeDiacritics(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }
</script>
<!-- </div> -->
<?= $this->endSection() ?>