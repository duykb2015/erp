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
                                            <h5 class="card-header-text sub-title d-flex">Thống kê dự án</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Công việc</h5>
                                                    <span>Thống kế số lượng công việc theo từng trạng thái trong dự án.</span>

                                                </div>
                                                <div class="card-block">
                                                    <div id="chart_Donut" style="width: 100%; height: 300px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="auth-box card">
                                <div class="card-header">
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <h5 class="card-header-text sub-title d-flex">Thống kê tiến độ thành viên</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Thành viên</h5>
                                                    <span>Tổng số lượng công việc đã hoàn thành của từng thành viên.</span>
                                                </div>
                                                <div class="card-block">
                                                    <?php foreach ($teamStatistic as $user) : ?>
                                                        <div class="row m-3">
                                                            <div class="col-2">
                                                                <p class="m-b-0"><span style="font-weight: bold; color: black; padding-left: 10px;" style="width:15%"><?= $user['name'] ?></span></p>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-success" role="progressbar" style="width: <?= $user['percentComplete'] ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <span style="font-weight: bold; color: black; "><b><?= $user['taskDone'] ?>/<?= $user['totalTask'] ?></b></span>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
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

<?= $this->section('js')  ?>
<!-- google chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    const jsonData = JSON.parse('<?= $chartData ?>')
    var result = Object.keys(jsonData).map((key) => {
        if ('Trạng thái' == key)
            return [key, jsonData[key]]
        return [key, parseInt(jsonData[key])]
    });

    //Donut chart
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChartDonut);

    var colors = ['lightgray']

    for (let i = 1; i < result.length - 2; i++) {
        colors.push('#007bff')
    }

    colors.push('#0ac282')
    console.log(colors)

    function drawChartDonut() {
        var dataDonut = google.visualization.arrayToDataTable(result);

        var optionsDonut = {
            width: 1488,
            pieHole: 0.4,
            colors: colors
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_Donut'));
        chart.draw(dataDonut, optionsDonut);
    }
</script>

<?= $this->endSection() ?>