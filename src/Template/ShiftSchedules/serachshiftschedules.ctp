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
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Daily Scheduling</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="employees.html">Employees</a></li>
                        <li class="breadcrumb-item active">Shift Scheduling</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="/employee-shifts/shifts/<?= $companyId ?>" class="btn add-btn m-r-5">Shifts</a>
                    <a href="#" class="btn add-btn m-r-5" data-toggle="modal" data-target="#add_schedule"> Assign Shifts</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->



        <!-- Search Filter -->
        <form action="/shift-schedules/serachshiftschedules">
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="employeename" value="<?= $employeename ?>">
                        <label class="focus-label">Employee</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="departmentId">
                            <?php foreach ($departments as $department) : ?>
                                <option>--Select Department--</option>
                                <?php if (!empty($department->id) && $department->id == $departmentId) : ?>
                                    <option selected value="<?= $department->id ?>"><?= $department->name ?></option>
                                <?php else : ?>
                                    <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </select>
                        <label class="focus-label">Department</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="fromdate" value="">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="todate">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                    <input type="hidden" name="companyId" value="<?= $companyId ?>">
                </div>
            </div>
        </form>
        <!-- Search Filter -->

        <?php
        $first_day_this_month = date('Y-m-d');
        $last_day_this_month  =  date("Y-m-t");
        $start_time = strtotime($first_day_this_month);
        $end_time = strtotime("+7 days", $start_time);
        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $list[] = date('Y-m-d', $i);

            $listdates[] = date('d-m-Y,D', $i);
        }

        ?>


        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Scheduled Shift</th>
                                <?php foreach ($listdates as $date) : ?>
                                    <th><?= $date ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($companyshiftschedules)) : ?>
                                <?php foreach ($companyshiftschedules as $companymember) : ?>

                                    <?php if (!empty($companymember->shiftschedules)) : ?>
                                        <?php $shiftscheduledays = array();
                                        foreach ($companymember->shiftschedules as $shiftschedule) {
                                            if (!in_array($shiftschedule->scheduledshift_startdate->i18nFormat('yyyy-MM-dd'), $shiftscheduledays)) {
                                                array_push($shiftscheduledays, $shiftschedule->scheduledshift_startdate->i18nFormat('yyyy-MM-dd'));
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar"><img alt="" src="/assets/img/profiles/avatar-02.jpg"></a>
                                                    <a href="profile.html"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?> <span><?= $companymember->designation->name ?></span></a>
                                                </h2>
                                            </td>
                                            <?php foreach ($list as $listdate) : ?>

                                                <?php


                                                $todayschedule = null;
                                                foreach ($companymember->shiftschedules as $shiftschedule) {
                                                    if ($shiftschedule->scheduledshift_startdate->i18nFormat('yyyy-MM-dd') == $listdate) {
                                                        $todayschedule = $shiftschedule;
                                                    }
                                                }
                                                ?>
                                                <?php if (!empty($todayschedule)) : ?>

                                                    <td>
                                                        <div class="user-add-shedule-list">
                                                            <?php

                                                            if ($todayschedule->employee_shift->start_time != null && $todayschedule->employee_shift->end_time != null) {
                                                                $diff = strtotime($todayschedule->employee_shift->end_time->i18nFormat('HH:mm:ss')) - strtotime($todayschedule->employee_shift->start_time->i18nFormat('HH:mm:ss'));
                                                            }
                                                            ?>
                                                            <?php if ($todayschedule->employee_shift->start_time != null && $todayschedule->employee_shift->end_time != null) : ?>
                                                                <h2>
                                                                    <a href="#" data-toggle="modal" data-target="#edit_schedule_<?= $todayschedule->id ?>_<?= $listdate ?>" style="border:2px dashed #1eb53a">
                                                                        <span class="username-info m-b-10">
                                                                            <?= $todayschedule->employee_shift->start_time->i18nFormat('HH:mm:ss') ?> - <?= $todayschedule->employee_shift->end_time->i18nFormat('HH:mm:ss') ?> ( <?= $diff ?>)</span>
                                                                        <span class="userrole-info"><?= $companymember->designation->name ?> - SMARTHR</span>
                                                                    </a>
                                                                </h2>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>

                                                    <!-- Edit Schedule Modal -->
                                                    <?= $this->element('edit_schedule', [
                                                        'todayschedule' => $todayschedule,
                                                        'date' => $listdate,
                                                        'companyId' => $companyId
                                                    ]) ?>

                                                    <!-- /Edit Schedule Modal -->
                                                <?php else :  ?>
                                                    <td>
                                                        <div class="user-add-shedule-list">
                                                            <a href="#" data-toggle="modal" data-target="#add_schedule_fordate_<?= $companymember->user->id ?>_<?= $listdate ?>">
                                                                <span><i class="fa fa-plus"></i></span>
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <!-- Add Schedule Modal -->
                                                    <?= $this->element('add_schedule_fordate', [
                                                        'companymember' =>  $companymember,
                                                        'listdate' => $listdate
                                                    ]) ?>
                                                    <!-- /Add Schedule Modal -->
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        </tr>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<?php $date = ""; ?>
<!-- Add Schedule Modal -->
<?= $this->element('add_schedule', [
    'date' => $date
]) ?>
<!-- /Add Schedule Modal -->
