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
                        <input type="text" class="form-control floating" name="name" value="<?= $name ?>">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="month">
                            <?php if (!empty($month)) : ?>
                                <option selected><?= date("F", strtotime(date('Y-' . $month . '-01'))); ?></option>
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
                            <?php else : ?>
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
                            <?php endif; ?>
                        </select>
                        <label class="focus-label">Select Month</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="year">
                            <?php if (!empty($year)) : ?>
                                <option selected value="<?= $year ?>"><?= $year ?></option>
                                <option value="">-</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>

                            <?php else : ?>
                                <option value="">-</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                            <?php endif; ?>



                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <?php if (!empty($fromdate)) : ?>
                                <input class="form-control floating datetimepicker" type="text" name="fromdate" value="<?= $fromdate ?>">
                            <?php else : ?>
                                <input class="form-control floating datetimepicker" type="text" name="fromdate">
                            <?php endif; ?>
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group form-focus focused">
                        <div class="cal-icon">
                            <?php if (!empty($todate)) : ?>
                                <input class="form-control floating datetimepicker" type="text" name="todate" value="<?= $todate ?>">
                            <?php else : ?>
                                <input class="form-control floating datetimepicker" type="text" name="todate">
                            <?php endif; ?>
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

        <div class="search-result">
            <h3>Search Result Found For: <u>

                    <?php if (!empty($name) && empty($month) && empty($year)) : ?> <?= $name ?>

                    <?php elseif (!empty($name) && !empty($month)) : ?> <?= $name ?>, <?= date("F", strtotime(date('Y-' . $month . '-01')));?>
                    <?php elseif (!empty($month) && !empty($year) && !empty($name)) : ?> <?= $name ?>,<?= date("F", strtotime(date('Y-' . $month . '-01'))); ?>,<?= $year ?>
                    <?php elseif (!empty($month) && !empty($year)) : ?> <?=  date("F", strtotime(date('Y-' . $month . '-01'))); ?>,<?= $year ?>
                    <?php elseif (!empty($month)) : ?> <?= $month ?>
                        <?php elseif (!empty($fromdate) && !empty($todate)) : ?><?= $fromdate ?> - <?= $todate ?>
                    <?php endif; ?>
                </u></h3>

            <?php if (!empty($matched_data)) : ?>

                <?php $totalsearch = 0;
                foreach ($users as $user) {
                    if (!empty($user->workinghours)) {
                        $totalsearch = $totalsearch + 1;
                    }
                }
                ?>

            <?php else : ?>
                <?php $totalsearch = "NO MAATCH FOUND" ?>

            <?php endif; ?>
            <p><?= $totalsearch ?> Results found</p>
        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table table-nowrap mb-0">
                        <?php

                        if (!empty($year) && !empty($month)) {
                            $first_day_this_month =   date('' . $year . '-' . $month . '-01');
                            $last_day_this_month  =  date('' . $year . '-' . $month . '-t');
                        } elseif (!empty($month)) {
                            $first_day_this_month =   date('Y-' . $month . '-01');
                            $last_day_this_month  =  date('Y-' . $month . '-t');
                        } elseif (!empty($fromdate) && !empty($todate)) {
                            $first_day_this_month =   $fromdate;
                            $last_day_this_month  =  $todate;
                        } else {
                            $first_day_this_month =   date('Y-m-01');
                            $last_day_this_month  =  date('Y-m-t');
                        }


                        $start_time = strtotime($first_day_this_month);
                        if (!empty($fromdate) && !empty($todate)) {
                            $end_time = strtotime($todate);
                        } else {
                            $end_time = strtotime("+1 month", $start_time);
                        }


                        $listdates = array();
                        $list = array();
                        for ($i = $start_time; $i <= $end_time; $i += 86400) {
                           // $list[] = date('Y-m-d', $i);
                            array_push($list,date('Y-m-d', $i));
                            array_push($listdates, date('d-m-Y,D', $i));
                            //$listdates[] = date('d-m-Y,D', $i);
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
                            <?php if ($users != null) : ?>
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

                                                    <?php foreach ($user->workinghours as $attendence) : ?>

                                                        <?php if ($attendence->start_time->i18nFormat('yyyy-MM-dd') == $date) : ?>

                                                            <td><a href="javascript:void(0);" data-toggle="modal" data-target="#attendance_info_<?= $attendence->id ?>"><i class="fa fa-check text-success"></i></a></td>

                                                            <!-- Attendance Modal -->
                                                            <div class="modal custom-modal fade" id="attendance_info_<?= $attendence->id ?>" role="dialog">
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
                                                                                            ?>
                                                                                            <?php foreach ($todayactivity as $today) : ?>
                                                                                                <?php
                                                                                                if ($today->end_time != null) {
                                                                                                    $diff = strtotime($today->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($today->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                                                                                    $todayhours = $todayhours + round($diff / (60 * 60), 2);
                                                                                                } else {
                                                                                                    $diff = strtotime(Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($today->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                                                                                    $todayhours = round($diff / (60 * 60), 2);
                                                                                                }
                                                                                                ?>
                                                                                                <h5 class="card-title">Timesheet <small class="text-muted"><?= $attendence->start_time->i18nFormat('dd-MM-yyyy') ?></small></h5>

                                                                                                <div class="punch-det">
                                                                                                    <h6>Punch In at</h6>
                                                                                                    <p><?= date('l', strtotime($attendence->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'))); ?>,<?= $attendence->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome') ?></p>
                                                                                                </div>

                                                                                                <div class="punch-info">
                                                                                                    <div class="punch-hours">
                                                                                                        <span><?= $todayhours ?> hrs</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php if ($attendence->end_time != null) : ?>
                                                                                                    <div class="punch-det">
                                                                                                        <h6>Punch Out at</h6>
                                                                                                        <p><?= date('l', strtotime($attendence->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'))); ?>,<?= $attendence->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome') ?></p>
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
                                                                                            <?php endforeach; ?>
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

                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <td>
                                                        <div class="half-day">

                                                            <span class="first-off"><i class="fa fa-close text-danger"></i></span>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>

                                            <?php endforeach; ?>
                                            <td><a href="/workinghours/downloadpdf?empid=<?= $user->id ?>&fromdate=<?= $first_day_this_month ?>&todate=<?= $last_day_this_month ?>" class="btn btn-sm btn-primary">PDF</a></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            <?php endif; ?>


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->



</div>
<!-- Page Wrapper -->
