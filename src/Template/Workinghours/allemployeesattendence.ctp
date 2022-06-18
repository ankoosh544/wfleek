<?php

use Cake\I18n\Time;
?>


<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Attendance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="/workinghours/filterattendence/<?= $companyId ?>">
            <div class="row filter-row">
                <div class="col">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="name">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="month">
                            <option value="">-</option>
                            <option value="01">Jan</option>
                            <option value="02">Feb</option>
                            <option value="03">Mar</option>
                            <option value="04">Apr</option>
                            <option value="05">May</option>
                            <option value="06">Jun</option>
                            <option value="07">Jul</option>
                            <option value="08">Aug</option>
                            <option value="09">Sep</option>
                            <option value="10">Oct</option>
                            <option value="11">Nov</option>
                            <option value="12">Dec</option>
                        </select>
                        <label class="focus-label">Select Month</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="year">
                            <option value="">-</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>


                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="fromdate">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="todate">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>

                <div class="col">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                </div>
            </div>
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table table-nowrap mb-0">


                        <?php
                        $first_day_this_month = date('Y-m-01');
                        $last_day_this_month  =  date("Y-m-t");
                        $start_time = strtotime($first_day_this_month);
                        $end_time = strtotime("+1 month", $start_time);
                        for ($i = $start_time; $i < $end_time; $i += 86400) {
                            $list[] = date('Y-m-d', $i);
                            $listdates[] = date('d-m-Y,D', $i);
                        }
                        ?>



                        <thead>
                            <tr>
                                <th>Employee</th>
                                <?php foreach ($listdates as $date) : ?>
                                    <th><?= $date ?></th>
                                <?php endforeach; ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <?php if (!empty($user->workinghours)) : ?>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a class="avatar avatar-xs" href="/user/view/<?= $user->id ?>">
                                                    <?php if ($user->profileFilepath != null && $user->profileFilename != null) : ?>
                                                        <img alt="" src="<?= $user->profileFilepath ?>/<?= $user->profileFilename ?>"></a>
                                            <?php else : ?>
                                                <img alt="" src="/assets/img/profiles/avatar-09.jpg"></a>
                                            <?php endif; ?>
                                            <a href="/user/view/<?= $user->id ?>"><?= $user->firstname ?> <?= $user->lastname ?></a>
                                            </h2>
                                        </td>

                                        <?php
                                        $workeddays = array();
                                        foreach ($user->workinghours as $attendence) {
                                            if (!in_array($attendence->start_time->i18nFormat('yyyy-MM-dd'), $workeddays)) {
                                                array_push($workeddays, $attendence->start_time->i18nFormat('yyyy-MM-dd'));
                                            }
                                        }
                                        ?>

                                        <?php foreach ($list as $date) : ?>

                                            <?php
                                            $todayactivity = array();
                                            foreach ($user->workinghours as $attendence) {
                                                if ($attendence->start_time->i18nFormat('yyyy-MM-dd') == $date) {
                                                    array_push($todayactivity, $attendence);
                                                }
                                            }
                                            ?>

                                            <?php if (in_array($date, $workeddays)) : ?>
                                                <td><a href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info_<?= $user->id ?>_<?=$date?>"><i class="fa fa-check text-success"></i></a></td>

                                                <!-- Attendance Modal -->
                                                <div class="modal custom-modal fade" id="attendance_info_<?= $user->id ?>_<?=$date?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Attendance Info</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="card punch-status">
                                                                            <div class="card-body">
                                                                                <?php
                                                                                $todayhours  = 0;
                                                                                foreach ($todayactivity as $today) {
                                                                                    if ($today->end_time != null) {
                                                                                        $diff = strtotime($today->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($today->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                                                                        $todayhours = $todayhours + round($diff / (60 * 60), 2);
                                                                                    } else {
                                                                                        $diff = strtotime(Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($today->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                                                                        $todayhours = round($diff / (60 * 60), 2);
                                                                                    }
                                                                                }
                                                                                ?>


                                                                                <h5 class="card-title">Timesheet <small class="text-muted"><?= $todayactivity[0]->start_time->i18nFormat('dd-MM-yyyy') ?></small></h5>
                                                                                <div class="punch-det">
                                                                                    <h6>Punch In at</h6>
                                                                                    <p><?= date('l', strtotime($todayactivity[0]->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'))); ?>,<?= $todayactivity[0]->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome') ?></p>
                                                                                </div>

                                                                                <div class="punch-info">
                                                                                    <div class="punch-hours">
                                                                                        <span><?= $todayhours ?> hrs</span>
                                                                                    </div>
                                                                                </div>
                                                                                <?php if ($todayactivity[count($todayactivity) - 1]->end_time != null) : ?>
                                                                                    <div class="punch-det">
                                                                                        <h6>Punch Out at</h6>
                                                                                        <p><?= date('l', strtotime($todayactivity[count($todayactivity) - 1]->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'))); ?>,<?= $todayactivity[count($todayactivity) - 1]->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome') ?></p>
                                                                                    </div>
                                                                                <?php endif; ?>


                                                                                <div class="statistics">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>Break</p>
                                                                                                <h6>1.21 hrs</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-6 text-center">
                                                                                            <div class="stats-box">
                                                                                                <p>Overtime</p>
                                                                                                <h6>3 hrs</h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card recent-activity">
                                                                            <div class="card-body">
                                                                                <h5 class="card-title">Activity</h5>
                                                                                <ul class="res-activity-list">
                                                                                    <?php foreach ($todayactivity as $today) : ?>


                                                                                        <li>
                                                                                            <p class="mb-0">Punch In at</p>
                                                                                            <p class="res-activity-time">
                                                                                                <i class="fa fa-clock-o"></i>
                                                                                                <?= $today->start_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?>.
                                                                                            </p>
                                                                                        </li>
                                                                                        <?php if ($today->end_time != null) : ?>
                                                                                            <li>
                                                                                                <p class="mb-0">Punch Out at</p>
                                                                                                <p class="res-activity-time">
                                                                                                    <i class="fa fa-clock-o"></i>
                                                                                                    <?= $today->end_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?>.
                                                                                                </p>
                                                                                            </li>
                                                                                        <?php endif; ?>

                                                                                    <?php endforeach; ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Attendance Modal -->


                                            <?php else : ?>
                                                <td>
                                                    <div class="half-day">
                                                        <span class="first-off"><i class="fa fa-close text-danger"></i></span>
                                                    </div>
                                                </td>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                        <td><a href="/workinghours/downloadpdf?companyId=<?= $companyId ?>&empid=<?= $user->id ?>&fromdate=<?= $startdatetime->format('d-m-Y') ?>&todate=<?= $enddatetime->format('d-m-Y') ?>" class="btn btn-sm btn-primary">PDF</a></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- Page Wrapper -->
