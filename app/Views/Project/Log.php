<?= $this->extend('layout') ?>

<?= $this->section('css') ?>
<!-- Select 2 css -->
<link rel="stylesheet" href="<?= base_url() ?>templates\libraries\bower_components\select2\css\select2.min.css">
<!-- Multi Select css -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>templates\libraries\bower_components\bootstrap-multiselect\css\bootstrap-multiselect.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>templates\libraries\bower_components\multiselect\css\multi-select.css">
<style>
    .breadcrumb-title div {
        display: inline;
    }

    .custom-height {
        padding-top: 6px !important;
        height: 38px !important;
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
                                        <a href="<?= base_url('project/') . $project['id'] ?>/statistic" class="text-decoration-none">Thống kê</a>
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
                                            <h5 class="card-header-text sub-title d-flex">Các hoạt động trong dự án</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <ul class="media-list revision-blc">
                                        <?php if (!empty($projectLog)) : ?>
                                            <?php foreach ($projectLog as $log) : ?>
                                                <hr>
                                                <li class="media d-flex m-t-5 m-b-15">
                                                    <div class="p-l-15 p-r-15 d-inline-block v-middle">
                                                        <a class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icofont icofont-clock-time" style="margin-right: 0px !important;"></i></a>
                                                    </div>
                                                    <div class="d-inline-block">
                                                        <?= $log['log'] ?>
                                                        <div class="media-annotation"><?= $log['created_at'] ?></div>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <li>
                                                <div class="d-inline-block">
                                                    Chưa có nhật ký hoạt động nào.
                                                </div>
                                            </li>
                                        <?php endif ?>
                                    </ul>
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

<?= $this->section('js')  ?>
<!-- google chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
</script>

<?= $this->endSection() ?>