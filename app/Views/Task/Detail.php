<?= $this->extend('layout') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Task detail</h4>
                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Task</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Task-Detail</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <!-- Task-detail-right start -->
                        <div class="col-xl-4 col-lg-12 push-xl-8 task-detail-right">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-clock-time m-r-10"></i>Task Timer</h5>
                                </div>
                                <div class="card-block">
                                    <div class="counter">
                                        <div class="yourCountdownContainer">
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <h2>12</h2>
                                                    <p>Days</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <h2>24</h2>
                                                    <p>Hours</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <h2>38</h2>
                                                    <p>Minutes</p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <h2>56</h2>
                                                    <p>Seconds</p>
                                                </div>
                                            </div>
                                            <!-- end of row -->
                                        </div>
                                        <!-- end of yourCountdown -->
                                    </div>
                                    <!-- end of counter -->
                                </div>
                                <div class="card-footer">
                                    <div class="f-left">
                                        <i class="icofont icofont-rewind"></i> <i class="icofont icofont-pause"></i> <i class="icofont icofont-play-alt-1"></i>
                                    </div>
                                    <div class="f-right">
                                        <div class="dropdown-secondary dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Open</button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <a class="dropdown-item waves-light waves-effect active" href="#!">Open</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">On hold</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Resolved</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Closed</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Dublicate</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Invalid</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Wontfix</a>
                                            </div>
                                            <!-- end of dropdown menu -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-ui-note m-r-10"></i> Task Details</h5>
                                </div>
                                <div class="card-block task-details">
                                    <table class="table table-border table-xs">
                                        <tbody>
                                            <tr>
                                                <td><i class="icofont icofont-contrast"></i> Project:</td>
                                                <td class="text-right"><span class="f-right"><a href="#"> Singular app</a></span></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-meeting-add"></i> Updated:</td>
                                                <td class="text-right">12 May, 2015</td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-id-card"></i> Created:</td>
                                                <td class="text-right">25 Feb, 2015</td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-spinner-alt-5"></i> Priority:</td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <a href="#">
                                                            <i class="icofont icofont-upload m-r-5"></i> Highest
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-spinner-alt-3"></i> Revisions:</td>
                                                <td class="text-right">29</td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-ui-love-add"></i> Added by:</td>
                                                <td class="text-right"><a href="#">Winnie</a></td>
                                            </tr>
                                            <tr>
                                                <td><i class="icofont icofont-washing-machine"></i> Status:</td>
                                                <td class="text-right">Published</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <div>
                                        <span>
                                            <a href="#!" class="text-muted m-r-10 f-16"><i class="icofont icofont-random"></i> </a>
                                        </span>
                                        <span class="m-r-10">
                                            <a href="#!" class="text-muted f-16"><i class="icofont icofont-options"></i></a>
                                        </span>
                                        <div class="dropdown-secondary dropdown d-inline-block">
                                            <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-checked m-r-10"></i>Check in</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-attachment m-r-10"></i>Attach screenshot</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-rotation m-r-10"></i>Reassign</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-edit-alt m-r-10"></i>Edit task</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-close m-r-10"></i>Remove</a>
                                            </div>
                                            <!-- end of dropdown menu -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-wheel m-r-10"></i> Task Settings</h5>
                                </div>
                                <div class="card-block task-setting">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Publish after save</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Allow comments</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Allow users to edit the task</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Use task timer</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Auto saving</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Auto saving</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="f-left">Allow attachments</label>
                                                <input type="checkbox" class="js-small f-right" checked="">
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-default waves-effect p-l-40 p-r-40  m-r-30">Reset
                                                </button>
                                                <button type="button" class="btn btn-primary waves-effect waves-light p-l-40 p-r-40">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-certificate-alt-2 m-r-10"></i> Revisions</h5>
                                </div>
                                <div class="card-block revision-block">
                                    <div class="form-group">
                                        <div class="row">
                                            <ul class="media-list revision-blc">
                                                <li class="media d-flex m-b-15">
                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle"><a href="#" class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icon-ghost f-18 v-middle"></i></a></div>
                                                    <div class="d-inline-block">
                                                        Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                                        <div class="media-annotation">4 minutes ago</div>
                                                    </div>
                                                </li>
                                                <li class="media d-flex m-b-15">
                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle"><a href="#" class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icon-vector f-18 v-middle"></i></a></div>
                                                    <div class="d-inline-block">
                                                        Add full font overrides for popovers and tooltips
                                                        <div class="media-annotation">36 minutes ago</div>
                                                    </div>
                                                </li>
                                                <li class="media d-flex m-b-15">
                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle"><a href="#" class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icon-share-alt f-18 v-middle"></i></a></div>
                                                    <div class="d-inline-block">
                                                        created a new Design branch
                                                        <div class="media-annotation">36 minutes ago</div>
                                                    </div>
                                                </li>
                                                <li class="media d-flex m-b-15">
                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle"><a href="#" class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icon-equalizer f-18 v-middle"></i></a></div>
                                                    <div class="d-inline-block">
                                                        merged Master and Dev branches
                                                        <div class="media-annotation">48 minutes ago</div>
                                                    </div>
                                                </li>
                                                <li class="media d-flex">
                                                    <div class="p-l-15 p-r-20 d-inline-block v-middle"><a href="#" class="btn btn-outline-primary btn-lg txt-muted btn-icon"><i class="icon-graph f-18 v-middle"></i></a></div>
                                                    <div class="d-inline-block">
                                                        Have Carousel ignore keyboard events
                                                        <div class="media-annotation">Dec 12, 05:46</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-attachment"></i> Attached Files</h5>
                                </div>
                                <div class="card-block task-attachment">
                                    <ul class="media-list">
                                        <li class="media d-flex m-b-10">
                                            <div class="m-r-20 v-middle">
                                                <i class="icofont icofont-file-word f-28 text-muted"></i>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="m-b-5 d-block">Overdrew_scowled.doc</a>
                                                <div class="text-muted">
                                                    <span>Size: 1.2Mb</span>
                                                    <span>
                                                        Added by <a href="">Winnie</a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="f-right v-middle text-muted">
                                                <i class="icofont icofont-download-alt f-18"></i>
                                            </div>
                                        </li>
                                        <li class="media d-flex m-b-10">
                                            <div class="m-r-20 v-middle">
                                                <i class="icofont icofont-file-powerpoint f-28 text-muted"></i>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="m-b-5 d-block">And_less_maternally.pdf</a>
                                                <div class="text-muted">
                                                    <span>Size: 0.11Mb</span>
                                                    <span>
                                                        Added by <a href="">Eugene</a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="f-right v-middle text-muted">
                                                <i class="icofont icofont-download-alt f-18"></i>
                                            </div>
                                        </li>
                                        <li class="media d-flex m-b-10">
                                            <div class="m-r-20 v-middle">
                                                <i class="icofont icofont-file-pdf f-28 text-muted"></i>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="m-b-5 d-block">The_less_overslept.pdf</a>
                                                <div class="text-muted">
                                                    <span>Size:5.9Mb</span>
                                                    <span>
                                                        Added by <a href="">Natalie</a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="f-right v-middle text-muted">
                                                <i class="icofont icofont-download-alt f-18"></i>
                                            </div>
                                        </li>
                                        <li class="media d-flex m-b-10">
                                            <div class="m-r-20 v-middle">
                                                <i class="icofont icofont-file-exe f-28 text-muted"></i>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="m-b-5 d-block">Well_equitably.mov</a>
                                                <div class="text-muted">
                                                    <span>Size:20.9Mb</span>
                                                    <span>
                                                        Added by <a href="">Jenny</a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="f-right v-middle text-muted">
                                                <i class="icofont icofont-download-alt f-18"></i>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-users-alt-4"></i> Assigned Users</h5>
                                </div>
                                <div class="card-block user-box assign-user">
                                    <div class="media">
                                        <div class="media-left media-middle photo-table">
                                            <a href="#">
                                                <img class="img-radius" src="libraries\assets\images\avatar-3.jpg" alt="chat-user">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h6>Sortino media</h6>
                                            <p>Software Engineer</p>
                                        </div>
                                        <div>
                                            <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left media-middle photo-table">
                                            <a href="#">
                                                <img class="img-radius" src="libraries\assets\images\avatar-2.jpg" alt="chat-user">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h6>Larry heading </h6>
                                            <p>Web Designer</p>
                                        </div>
                                        <div>
                                            <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left media-middle photo-table">
                                            <a href="#">
                                                <img class="img-radius" src="libraries\assets\images\avatar-1.jpg" alt="chat-user">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h6>Mark</h6>
                                            <p>Chief Financial Officer (CFO)</p>
                                        </div>
                                        <div>
                                            <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                                        </div>
                                    </div>
                                    <div class="media p-0 d-flex">
                                        <div class="media-left media-middle photo-table">
                                            <a href="#">
                                                <img class="img-radius" src="libraries\assets\images\avatar-4.jpg" alt="chat-user">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h6>John Doe</h6>
                                            <p>Senior Marketing Designer</p>
                                        </div>
                                        <div>
                                            <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Task-detail-right start -->
                        <!-- Task-detail-left start -->
                        <div class="col-xl-8 col-lg-12 pull-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="icofont icofont-tasks-alt m-r-5"></i> Ticket List Doesn't Support Commas</h5>
                                    <button class="btn btn-sm btn-primary f-right"><i class="icofont icofont-ui-alarm"></i>Check in</button>
                                </div>
                                <div class="card-block">
                                    <div class="">
                                        <div class="m-b-20">
                                            <h6 class="sub-title m-b-15">Overview</h6>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                            </p>
                                        </div>
                                        <div class="m-b-20">
                                            <h6 class="sub-title m-b-15">What we need</h6>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                            </p>
                                        </div>
                                        <div class="m-b-20 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="text-primary f-14 m-b-10">
                                                        1. The standard Lorem Ipsum passage
                                                    </div>
                                                    <div class="f-12">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.
                                                    </div>
                                                    <div class="text-primary f-14 m-b-10 m-t-15">
                                                        2. The standard Lorem Ipsum passage
                                                    </div>
                                                    <div class="f-12">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.
                                                    </div>
                                                    <div class="text-primary f-14 m-b-10 m-t-15">
                                                        3. The standard Lorem Ipsum passage
                                                    </div>
                                                    <div class="f-12">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6">
                                                    <div class="text-primary f-14 m-b-10">
                                                        1. The standard Lorem Ipsum passage
                                                    </div>
                                                    <div class="f-12">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.
                                                    </div>
                                                    <div class="text-primary f-14 m-b-10 m-t-15">
                                                        2.The standard Lorem Ipsum passage
                                                    </div>
                                                    <div class="f-12">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.
                                                    </div>
                                                    <div class="text-primary f-14 m-b-10 m-t-15">
                                                        3. The standard Lorem Ipsum passage
                                                    </div>
                                                    <div class="f-12">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-b-20">
                                            <h6 class="sub-title m-b-15">Requirements</h6>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                            </p>
                                            <div class="table-responsive m-t-20">
                                                <table class="table m-b-0 f-14 b-solid requid-table">
                                                    <thead>
                                                        <tr class="text-uppercase">
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">Task</th>
                                                            <th class="text-center">Due Date</th>
                                                            <th class="text-center">Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center text-muted">
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Design mockup</td>
                                                            <td> <i class="icofont icofont-ui-calendar"></i>&nbsp; 22 December, 16</td>
                                                            <td>The standard Lorem Ipsum passage</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Software Engineer</td>
                                                            <td> <i class="icofont icofont-ui-calendar"></i>&nbsp; 01 December, 16</td>
                                                            <td>The standard Lorem Ipsum passage</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Photoshop And Illustrator</td>
                                                            <td> <i class="icofont icofont-ui-calendar"></i>&nbsp; 15 December, 16</td>
                                                            <td>The standard Lorem Ipsum passage</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Allocated Resource</td>
                                                            <td> <i class="icofont icofont-ui-calendar"></i>&nbsp; 28 December, 16</td>
                                                            <td>The standard Lorem Ipsum passage</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>Financial Controlle</td>
                                                            <td> <i class="icofont icofont-ui-calendar"></i>&nbsp; 20 December, 16</td>
                                                            <td>The standard Lorem Ipsum passage</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="m-t-20 m-b-20">
                                            <h6 class="sub-title m-b-15">Uploaded files</h6>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card thumb-block">
                                                    <div class="thumb-img">
                                                        <img src="libraries\assets\images\task\task-u1.jpg" class="img-fluid width-100" alt="task-u1.jpg">
                                                        <div class="caption-hover">
                                                            <span>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-ui-zoom-in"></i> </a>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-download-alt"></i> </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <a href="#!"> task/task-u1.jpg </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card thumb-block">
                                                    <div class="thumb-img">
                                                        <img src="libraries\assets\images\task\task-u2.jpg" class="img-fluid width-100" alt="task-u2.jpg">
                                                        <div class="caption-hover">
                                                            <span>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-ui-zoom-in"></i> </a>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-download-alt"></i> </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <a href="#!"> task/task-u2.jpg </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card thumb-block">
                                                    <div class="thumb-img">
                                                        <img src="libraries\assets\images\task\task-u3.jpg" class="img-fluid width-100" alt="task-u3.jpg">
                                                        <div class="caption-hover">
                                                            <span>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-ui-zoom-in"></i> </a>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-download-alt"></i> </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <a href="#!"> task/task-u3.jpg </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-3">
                                                <div class="card thumb-block">
                                                    <div class="thumb-img">
                                                        <img src="libraries\assets\images\task\task-u4.jpg" class="img-fluid width-100" alt="task-u4.jpg">
                                                        <div class="caption-hover">
                                                            <span>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-ui-zoom-in"></i> </a>
                                                                <a href="#" class="btn btn-primary btn-sm"><i class="icofont icofont-download-alt"></i> </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-center">
                                                        <a href="#!"> task/task-u4.jpg </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="f-left">
                                        <span class=" txt-primary"> <i class="icofont icofont-chart-line-alt"></i>
                                            Status:</span>
                                        <div class="dropdown-secondary dropdown d-inline-block">
                                            <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Open</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown4" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <a class="dropdown-item waves-light waves-effect active" href="#!">Open</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">On hold</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Resolved</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Closed</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Dublicate</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Invalid</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!">Wontfix</a>
                                            </div>
                                            <!-- end of dropdown menu -->
                                        </div>
                                    </div>
                                    <div class="f-right d-flex">
                                        <span>
                                            <a href="#!" class="text-muted m-r-10 f-16"><i class="icofont icofont-edit"></i> </a>
                                        </span>
                                        <span class="m-r-10">
                                            <a href="#!" class="text-muted f-16"><i class="icofont icofont-ui-delete"></i></a>
                                        </span>
                                        <div class="dropdown-secondary dropdown d-inline-block">
                                            <button class="btn btn-sm btn-primary dropdown-toggle waves-light bg-white b-none txt-muted" type="button" id="dropdown5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown5" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-alarm m-r-10"></i>Check in</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-attachment m-r-10"></i>Attach screenshot</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-spinner-alt-5 m-r-10"></i>Reassign</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-edit m-r-10"></i>Edit task</a>
                                                <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-close-line m-r-10"></i>Remove</a>
                                            </div>
                                            <!-- end of dropdown menu -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card comment-block">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="icofont icofont-comment m-r-5"></i> Comments</h5>
                                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                        <i class="icofont icofont-plus"></i>
                                    </button>
                                </div>
                                <div class="card-block">
                                    <ul class="media-list">
                                        <li class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-1.jpg" alt="Generic placeholder image">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading txt-primary">Lorem Ipsum <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                <div class="m-t-10 m-b-25">
                                                    <span class="f-14">115 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                    <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                </div>
                                                <hr>
                                                <!-- Nested media object -->
                                                <div class="media mt-2">
                                                    <a class="media-left" href="#">
                                                        <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                                    </a>
                                                    <div class="media-body">
                                                        <h6 class="media-heading txt-primary">Lorem Ipsum <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                        <div class="m-t-10 m-b-25">
                                                            <span class="f-14">75 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                        <!-- Nested media object -->
                                                        <div class="media mt-2">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading txt-primary">Lorem Ipsum <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                                <div class="m-t-10 m-b-25">
                                                                    <span class="f-14">156 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                                    <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Nested media object -->
                                                <div class="media mt-2">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-1.jpg" alt="Generic placeholder image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading txt-primary">Lorem ipsum<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                        <div class="m-t-10 m-b-25">
                                                            <span class="f-14">36 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <div class="media mt-2">
                                                    <a class="media-left" href="#">
                                                        <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                                    </a>
                                                    <div class="media-body">
                                                        <h6 class="media-heading txt-primary">Lorem ipsum<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                        <div class="m-t-10 m-b-25">
                                                            <span class="f-14">75 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                        <!-- Nested media object -->
                                                        <div class="media mt-2">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                                                </a>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading txt-primary">Lorem ipsum<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                                <div class="m-t-10 m-b-25">
                                                                    <span class="f-14">156 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                                    <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="media mt-2">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object img-radius comment-img" src="libraries\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="media-heading txt-primary">Lorem ipsum<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                        <div class="m-t-10 m-b-25">
                                                            <span class="f-14">41 <i class="icofont icofont-curved-up m-l-5 m-r-5 text-success"></i><i class="icofont icofont-curved-down text-danger m-r-10"></i></span>
                                                            <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="m-r-10 f-12">Edit</a> </span>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="md-float-material d-flex">
                                        <div class="col-md-12 btn-add-task">
                                            <div class="input-group input-group-button">
                                                <input type="text" class="form-control" placeholder="Add Task">
                                                <span class="input-group-addon btn btn-primary" id="basic-addon1">
                                                    <i class="icofont icofont-plus f-w-600"></i> Add task
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Task-detail-left end -->
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js')  ?>
<script type="text/javascript" src="<?= base_url() ?>\templates\libraries\assets\js\script.js"></script>
<?= $this->endSection() ?>