<?= $this->extend('layout') ?>
<?= $this->section('css') ?>
<style>
    .breadcrumb-title div {
        display: inline;
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
                                        <a href="<?= base_url('project/') . $project['id'] ?>" class="text-decoration-none">Chi tiết dự án</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card d-flex">
                                <!-- <div class="card-header">

                        </div> -->
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="card border">
                                                <div class="card-header">
                                                    <h5 class="card-header-text sub-title d-flex">Khởi tạo</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card border">
                                                <div class="card-header">
                                                    <h5 class="card-header-text sub-title d-flex">Đang làm</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card border">
                                                <div class="card-header">
                                                    <h5 class="card-header-text sub-title d-flex">Hoàn thành</h5>

                                                </div>
                                                <div class="card-block p-b-0">
                                                    <div class="row">
                                                        <div class="col-md-12" id="draggableMultiple">
                                                            <div class="sortable-moves border">
                                                                <img class="img-fluid p-absolute" src="libraries\assets\images\avatar-1.jpg" alt="">
                                                                <h6>Multiple list 1</h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            </div>
                                                            <div class="sortable-moves border">
                                                                <img class="img-fluid p-absolute" src="libraries\assets\images\avatar-2.jpg" alt="">
                                                                <h6>Multiple list 1</h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            </div>
                                                            <div class="sortable-moves">
                                                                <img class="img-fluid p-absolute" src="libraries\assets\images\avatar-3.jpg" alt="">
                                                                <h6>Multiple list 2</h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            </div>
                                                            <div class="sortable-moves">
                                                                <img class="img-fluid p-absolute" src="libraries\assets\images\avatar-4.jpg" alt="">
                                                                <h6>Multiple list 3</h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            </div>
                                                            <div class="sortable-moves">
                                                                <img class="img-fluid p-absolute" src="libraries\assets\images\avatar-5.jpg" alt="">
                                                                <h6>Multiple list 4</h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            </div>
                                                            <div class="sortable-moves">
                                                                <img class="img-fluid p-absolute" src="libraries\assets\images\avatar-6.jpg" alt="">
                                                                <h6>Multiple list 5</h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<?= $this->section('js') ?>

<script type="text/javascript" src="<?= base_url() ?>templates\libraries\bower_components\Sortable\js\Sortable.js"></script>

<script>
    draggableMultiple = document.getElementById('draggableMultiple');
    Sortable.create(draggableMultiple, {
        group: 'draggableMultiple',
        animation: 150,
        // Element dragging ended
        onEnd: function( /**Event*/ evt) {
            evt.to; // target list
            evt.from; // previous list
            evt.oldIndex; // element's old index within old parent
            evt.newIndex; // element's new index within new parent
            console.log(evt.item, evt.oldIndex, evt.newIndex)
        },
    });
</script>

<?= $this->endSection() ?>