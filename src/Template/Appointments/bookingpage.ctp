<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Company Members</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Company Members</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">

                    <div class="view-icons">
                        <a href="clients.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="clients-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Client ID</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Client Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Company</option>
                        <option>Global Technologies</option>
                        <option>Delta Infotech</option>
                    </select>
                    <label class="focus-label">Company</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- Search Filter -->

        <div class="row staff-grid-row">
            <?php foreach ($companymembers as $companymember) : ?>
                <?php if ($companymember->designation->name != 'Customer') : ?>
                    <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
                        <div class="profile-widget">
                            <div class="profile-img">

                                <a href="client-profile.html" class="avatar">
                                    <?php if ($companymember->user->profileFilepath != null && $companymember->user->profileFilename != null) : ?>
                                        <img alt="" src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>">
                                    <?php else : ?>
                                        <img alt="" src="/assets/img/profiles/avatar-19.jpg">
                                    <?php endif; ?>
                                </a>
                            </div>

                            <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-profile.html"><?= $companymember->usercompany->name ?></a></h4>
                            <h5 class="user-name m-t-10 mb-0 text-ellipsis"><a href="client-profile.html"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></a></h5>

                                <div class="small text-muted"><?=$companymember->designation->name?></div>


                            <a href="chat.html" data-toggle="modal" data-target="#book_appointment_<?= $companymember->user->id ?>" class="btn btn-white btn-sm m-t-10">Book Appointment</a>
                            <a href="/user/view/<?= $companymember->user->id ?>" class="btn btn-white btn-sm m-t-10">View Profile</a>
                        </div>
                    </div>


                    <!-- appointment  Modal -->
                    <div id="book_appointment_<?= $companymember->user->id ?>" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Booking</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="/appointments/newappointment?companymemberId=<?= $companymember->user->id ?>&&companyId=<?= $companymember->company_id ?>">
                                        <div class="form-group ">
                                            <label>Select date</label>
                                            <div class="input-group date" sdata-target-input="nearest">
                                                <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker1_<?=$companymember->user->id?>" data-target="#datetimepicker1_<?=$companymember->user->id?>" name="appointmentdate" />
                                                <div class="input-group-append" data-target="#datetimepicker1_<?=$companymember->user->id?>" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Appointment Title</label>
                                            <input class="form-control" type="text" placeholder="Title" name="title">
                                        </div>
                                        <div class="form-group ">
                                            <label for="date">Subject</label>
                                            <textarea class="form-control" placeholder="Write Subject" name="subject"></textarea>
                                        </div>
                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /appointment Modal -->
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- /Page Content -->





</div>

<!-- /Page Wrapper -->

