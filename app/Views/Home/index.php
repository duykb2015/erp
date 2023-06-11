<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<style>
</style>
<?= $this->endSection() ?>

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
                            <?php if (!empty($projects)) : ?>
                                <?php foreach ($projects as $project) : ?>
                                    <div class="card z-depth-bottom-2">
                                        <div class="row m-3">
                                            <div class="col-auto p-r-0">
                                                <div class="u-img">
                                                    <img src="<?= base_url() . '/imgs/' . $project['photo'] ?>" alt="user image" class="img-radius cover-img">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h6 class="m-b-5"><a href="<?= base_url('project') . '/' . $project['id'] ?>" class="text-decoration-none">[<?= $project['key'] ?>] <?= $project['name'] ?></a></h6>
                                                <p class="text-muted m-b-0"><?= $project['descriptions'] ?></p>
                                                <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Cập nhật: <?= $project['updated_at'] ?>.</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <div class="text-center">Hiện tại bạn không tham gia dự án nào. Tạo mới dự án bằng nút phía trên!</div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

                    <div class="float-end">
                        <button type="submit" onclick="createProject(event)" class="btn btn-primary rounded">Tạo</button>
                        <button type="button" class="btn btn-secondary rounded" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ===========================>
    const createNewProjectModal = document.getElementById('createNewProject')
    const projectName = document.getElementById('project_name')
    const projectKey = document.getElementById('project_key')
    const projectDescriptions = document.getElementById('project_descriptions')

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

    // ===========================>
    function removeDiacritics(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    document.getElementById("create-project").addEventListener("submit", function(event) {
        event.preventDefault()
    });

    function createProject(event) {
        if (projectName.value == '' ||
            projectKey.value == '' ||
            projectName.value.length < 5 ||
            projectDescriptions.value.length > 512) {
            return
        }

        const data = new FormData();
        data.append('project_name', projectName.value);
        data.append('project_key', projectKey.value)
        data.append('project_descriptions', projectDescriptions.value)

        var requestOptions = {
            method: 'POST',
            body: data,
            redirect: 'follow'
        };
        fetch('<?= base_url('project/create') ?>', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.errors) {
                    if (result.errors.project_name) {
                        result.errors.project_name = result.errors.project_name.replace('project_name', 'Tên dự án')
                        $.growl.error({
                            message: result.errors.project_name,
                            location: 'tr',
                            size: 'large'
                        });
                    }
                    if (result.errors.project_key) {
                        result.errors.project_key = result.errors.project_key.replace('project_key', 'Tiền tố')
                        $.growl.error({
                            message: result.errors.project_key,
                            location: 'tr',
                            size: 'large'
                        });
                    }
                    if (result.errors.project_descriptions) {
                        result.errors.project_descriptions = result.errors.project_descriptions.replace('project_descriptions', 'Mô tả dự án')
                        $.growl.error({
                            message: result.errors.project_descriptions,
                            location: 'tr',
                            size: 'large'
                        });
                    }
                    return
                }

                if (result.project_id) {
                    $.growl.notice({
                        message: "Tạo mới dự án thành công"
                    });

                    setTimeout(() => {
                        window.location.href = `<?= base_url('project') ?>/${result.project_id}`
                    }, 2000)

                    return
                }
            }).catch(() => {
                $.growl.error({
                    message: "Có lỗi xảy ra, vui lòng thử lại sau"
                });
            })
    }
    // <===========================
</script>
<!-- </div> -->
<?= $this->endSection() ?>