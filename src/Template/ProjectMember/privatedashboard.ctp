<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<!-- Loader -->

<div id="loader-wrapper">
    <div id="loader">
        <div class="loader-ellips">
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
        </div>
    </div>
</div>
<!-- /Loader -->


<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="welcome-box">
                    <div class="welcome-img">
                        <img alt="" src="<?= $authUser->profileFilepath ?>/<?= $authUser->profileFilename ?>">
                    </div>
                    <div class="welcome-det">
                        <h3>Welcome, <?= $authUser->firstname ?> <?= $authUser->lastname ?></h3>
                        <p> <?= $currDateTime = date("d/m/Y H:i:s") ?></p>

                        <!--   <ul class="personal-info">
                            <li>
                            <div class="title">FirstName</div>
                             <div class="text"><?= $authUser->firstname ?></div>
                            </li>
                            <li>
                            <div class="title">LastName</div>
                             <div class="text"><?= $authUser->lastname ?></div>
                            </li>
                            <li>
                            <div class="title">LastName</div>
                             <div class="text"><?= $authUser->lastname ?></div>
                            </li>
                        </ul> -->


                    </div>



                </div>

                <?php if (!empty($admin) && $authUser->id == $admin->user_id) : ?>
                    <a class="btn btn-info" href="/usercompanies/generateqrcode?companyId=<?= $authUser->choosen_companyId ?>&type=Entrance">Entrance</a>

                    <a class="btn btn-info" href="/usercompanies/generateqrcode?companyId=<?= $authUser->choosen_companyId ?>&type=Exit">Exit</a>
                <?php endif; ?>



            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                <section class="dash-section">
                    <?php if ($onleavetoday != null) : ?>
                        <h1 class="dash-sec-title">Today</h1>
                        <div class="dash-sec-content">
                            <div class="dash-info-list">
                                <?php foreach ($onleavetoday as $leavetoday) : ?>
                                    <?php if ($leavetoday->user_id != $authUser->id) : ?>
                                        <a href="#" class="dash-card text-danger">
                                            <div class="dash-card-container">
                                                <div class="dash-card-icon">
                                                    <i class="fa fa-hourglass-o"></i>
                                                </div>
                                                <div class="dash-card-content">
                                                    <p><?= $leavetoday->user->firstname ?> <?= $leavetoday->user->lastname ?> is in
                                                        <?php if ($leavetoday->leavetype == 'M') : ?> Medical Leave
                                                        <?php elseif ($leavetoday->leavetype == 'C') : ?> Casual Leave
                                                        <?php else : ?> Loss of Pay Leave
                                                        <?php endif; ?>
                                                </div>
                                                <div class="dash-card-avatars">
                                                    <div class="e-avatar"><img src="<?= $leavetoday->user->profileFilepath ?>/<?= $leavetoday->user->profileFilename ?>" alt=""></div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($leavetoday->user_id == $authUser->id) : ?>
                                        <a href="#" class="dash-card text-danger">
                                            <div class="dash-card-container">
                                                <div class="dash-card-icon">
                                                    <i class="fa fa-hourglass-o"></i>
                                                </div>
                                                <div class="dash-card-content">
                                                    <p><?= $leavetoday->user->firstname ?> <?= $leavetoday->user->lastname ?> is in
                                                        <?php if ($leavetoday->leavetype == 'M') : ?> Medical Leave
                                                        <?php elseif ($leavetoday->leavetype == 'C') : ?> Casual Leave
                                                        <?php else : ?> Loss of Pay Leave
                                                        <?php endif; ?>
                                                </div>
                                                <div class="dash-card-avatars">
                                                    <div class="e-avatar"><img src="<?= $leavetoday->user->profileFilepath ?>/<?= $leavetoday->user->profileFilename ?>" alt=""></div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php else : ?>
                                        <a href="#" class="dash-card text-success">
                                            <div class="dash-card-container">
                                                <div class="dash-card-icon">
                                                    <i class="fa fa-hourglass-o"></i>
                                                </div>
                                                <div class="dash-card-content">
                                                    <p><?= $authUser->firstname ?> <?= $authUser->lastname ?> is Working Today
                                                </div>
                                                <div class="dash-card-avatars">
                                                    <div class="e-avatar"><img src="<?= $authUser->profileFilepath ?>/<?= $authUser->profileFilename ?>" alt=""></div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </div>
                            <!----------------------------Categorized Employees data------------------------------

                         <div class="dash-info-list">
                            <a href="#" class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-suitcase"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>You are awayuuuuuuuuuuuuuuu today</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar"><img src="/assets/img/profiles/avatar-02.jpg" alt=""></div>
                                    </div>
                                </div>
                            </a>
                        </div>------>


                        </div>
                    <?php endif; ?>
                    <?php if ($myrequest != null) : ?>
                        <div class="dash-info-list">

                            <a href="#" class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <div class="dash-card-content">

                                        <?php if ($myrequest->worktype == 'H') : ?>
                                            <p>You are working from Home on <?= $myrequest->fromdate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?> to <?= $myrequest->todate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?></p>
                                        <?php elseif ($myrequest->worktype == 'M') : ?>
                                            <p>You are working from Milan on <?= $myrequest->fromdate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?> to <?= $myrequest->todate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?></p>
                                        <?php elseif ($myrequest->worktype == 'V') : ?>
                                            <p>You are working from Vareze on <?= $myrequest->fromdate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?> to <?= $myrequest->todate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?></p>
                                        <?php else : ?>
                                            <p>You are working from Unknown Place </p>
                                        <?php endif; ?>


                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar"><img src="<?= $authUser->profileFilepath ?>/<?= $authUser->profileFilename ?>" alt=""></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                </section>
                <section class="dash-section">
                    <?php if ($nextweekleaves != null) : ?>
                        <h1 class="dash-sec-title">Next seven days</h1>
                        <div class="dash-sec-content">
                            <?php foreach ($nextweekleaves as $nextweekleave) : ?>
                                <div class="dash-info-list">
                                    <div class="dash-card text-info">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-suitcase"></i>
                                            </div>


                                            <div class="dash-card-content">

                                                <p> <?= $nextweekleave->user->firstname ?> <?= $nextweekleave->user->lastname ?> will be in
                                                    <?php if ($nextweekleave->leavetype == 'M') : ?> Medical Leave
                                                    <?php elseif ($nextweekleave->leavetype == 'C') : ?> Casual Leave
                                                    <?php else : ?> Loss of Pay Leave
                                                    <?php endif; ?>
                                                    on <?= $nextweekleave->fromdate ?> to <?= $nextweekleave->todate ?>

                                                </p>
                                            </div>
                                            <div class="dash-card-avatars">
                                                <div class="e-avatar"><img src="<?= $nextweekleave->user->profileFilepath ?>/<?= $nextweekleave->user->profileFilename ?>" alt=""></div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!--  <div class="dash-info-list">
                            <div class="dash-card">
                                <div class="dash-card-container">
                                    <div class="dash-card-icon">
                                        <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="dash-card-content">
                                        <p>Your first day is going to be on Thursday</p>
                                    </div>
                                    <div class="dash-card-avatars">
                                        <div class="e-avatar"><img src="/assets/img/profiles/avatar-02.jpg" alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                            <?php foreach ($holidays as $holiday) : ?>
                                <div class="dash-info-list">
                                    <a href="" class="dash-card">
                                        <div class="dash-card-container">
                                            <div class="dash-card-icon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <div class="dash-card-content">
                                                <p>It's <?= $holiday->holiday_name ?> on <?= $holiday->holiday_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="dash-sidebar">
                    <section>
                        <h5 class="dash-title">Projects</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <?php $totalprojecttasks = count($projecttasks) ?>
                                        <h4><?= $totalprojecttasks ?></h4>
                                        <p>Total Tasks</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <?php $totalpendigtasks = count($pendingtasks) ?>
                                        <h4><?= $totalpendigtasks ?></h4>
                                        <p>Pending Tasks</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <div class="dash-stats-list">
                                        <?php $totalprojects = count($projectObjects) ?>
                                        <h4><?= $totalprojects ?></h4>
                                        <p>Total Projects</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php if ($approvedleaves != null) : ?>
                        <section>
                            <h5 class="dash-title">Your Leave</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="time-list">

                                        <div class="dash-stats-list">
                                            <?php $totalapproved = count($approvedleaves) ?>
                                            <h4><?= $totalapproved ?></h4>
                                            <p>Leave Taken</p>
                                        </div>

                                        <div class="dash-stats-list">
                                            <?php $remaining = 12 - $totalapproved ?>
                                            <h4><?= $remaining ?></h4>
                                            <p>Remaining</p>
                                        </div>
                                    </div>
                                    <div class="request-btn">

                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add_leave"> Apply Leave</a>
                                    </div>

                                    <!-- Add Leave Modal -->
                                    <div id="add_leave" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Leave</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/leaves/addleave" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label>Leave Type <span class="text-danger">*</span></label>
                                                            <select id="leavetype" name="leavetype" onchange="changeLeaveType(this); return false;">
                                                                <option>Select Leave Type</option>
                                                                <option value="C">Casual Leave 12 Days</option>
                                                                <option value="M">Medical Leave</option>
                                                                <option value="L">Loss of Pay</option>
                                                            </select>
                                                            <div id="medicalno" style="display: none;margin-left:10%;;">
                                                                <label for="medicalno"><?= __('Enter Medical Number') ?></label>
                                                                <input type="number" id="medicalno" name="medicalno">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>From <span class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input name="fromdate" id="add_fromdate" class="datetimepicker form-control" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>To <span class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input name="todate" id="add_todate" class="datetimepicker form-control" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Number of days <span class="text-danger">*</span></label>
                                                            <input id="ndays" class="form-control" type="number">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Remaining Leaves <span class="text-danger">*</span></label>
                                                            <input class="form-control" readonly value="12" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Leave Reason <span class="text-danger">*</span></label>
                                                            <textarea name="leavereason" rows="4" class="form-control"></textarea>
                                                        </div>
                                                        <div class="submit-section">
                                                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                                            <input type="hidden" name="type" value="employee">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Add Leave Modal -->


                                </div>
                            </div>
                        </section>
                    <?php endif; ?>


                    <section>
                        <h5 class="dash-title">Your time off allowance</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="time-list">
                                    <div class="dash-stats-list">
                                        <h4>5.0 Hours</h4>
                                        <p>Approved</p>
                                    </div>
                                    <div class="dash-stats-list">
                                        <h4>15 Hours</h4>
                                        <p>Remaining</p>
                                    </div>
                                </div>
                                <div class="request-btn">
                                    <a class="btn btn-primary" href="#">Apply Time Off</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php if (!empty($holidays)) : ?>
                        <section>
                            <h5 class="dash-title">Upcoming Holiday</h5>
                            <div class="card">
                                <div class="card-body text-center">
                                    <?php foreach ($holidays as $holiday) : ?>
                                        <h4 class="holiday-title mb-0"><?= date('l', strtotime($holiday->holiday_date->i18nFormat('dd-MM-yyyy', 'Europe/Rome'))); ?>,<?= $holiday->holiday_date->i18nFormat('dd-MM-yyyy') ?>- <?= $holiday->holiday_name ?></h4>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $(function() {

        $(document).ready(function() {
            $("#add_fromdate").datetimepicker({
                dateFormat: "dd/mm/yy"
            }).val();

            $("#add_todate").datetimepicker().on('dp.change', function() {
                console.log("sucess")
                myfunc();


            });

        });
        var ndays = 0;

        function myfunc() {
            var start = $("#add_fromdate").datetimepicker("viewDate");
            var end = $("#add_todate").datetimepicker("viewDate");
            days = (end - start) / (1000 * 60 * 60 * 24) + 1;
            ndays = Math.round(days);
            //console.log(ndays);
            $("#ndays").val(ndays);
        }
    });

    function changeLeaveType(event) {
        //window.location.reload();
        var leavetype = event.value;
        console.log(leavetype);
        if (leavetype === "M") {
            $("#medicalno").show()
        } else {
            $("#medicalno").hide()
        }

    }

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });
</script>
