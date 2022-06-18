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
                    <h3 class="page-title"> Attendance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-4">
                <div class="card punch-status">
                    <div class="card-body">
                        <h5 class="card-title">Timesheet <small class="text-muted"><?= Time::now()->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></small></h5>
                        <?php if (!empty($todayactivity)) : ?>

                            <?php if ($todayactivity[count($todayactivity) - 1]->end_time == null) : ?>
                                <div class="punch-det">
                                    <h6>Punch In at</h6>
                                    <p><?= date('l', strtotime($todayactivity[0]->start_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'))); ?>, <?= $todayactivity[0]->start_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></p>
                                </div>
                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span><?= number_format($todayhrs,2, ',', ' ') ?> hrs</span>
                                    </div>
                                </div>
                                <div class="punch-btn-section">
                                    <a href="" data-toggle="modal" data-target="#punch-out-description" class="btn btn-primary punch-btn">Punch Out</a>
                                </div>
                            <?php endif; ?>

                            <!-- Punch Out Description Modal -->
                            <div id="punch-out-description" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Description</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/companiesuser/employeepunchout">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="description">Write Description</label>
                                                            <textarea class="form-control summernote" name="description">
                                                            <?php if ($description != null) : ?>
                                                            <?= $description ?>
                                                        <?php endif; ?>
                                                        </textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="submit-section">
                                                    <button type="submit" class="btn btn-primary submit-btn">Punch-Out</button>
                                                    <input type="hidden" name="emp_id" value="<?= $user_id ?>">
                                                    <input type="hidden" name="company_id" value="<?= $companyId ?>">
                                                    <input type="hidden" name="attendencedashboard" value="<?= $user_id ?>">

                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Punch Out Description Modal -->




                            <div class="punch-det">
                                <h6>Punch In at</h6>
                                <p><?= date('l', strtotime($todayactivity[0]->start_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'))); ?>, <?= $todayactivity[0]->start_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></p>
                            </div>
                            <?php if ($todayactivity[count($todayactivity) - 1]->end_time != null) : ?>
                                <div class="punch-det">
                                    <h6>Punch Out at</h6>
                                    <p><?= date('l', strtotime($todayactivity[count($todayactivity) - 1]->end_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'))); ?>, <?= $todayactivity[count($todayactivity) - 1]->end_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (empty($checkpunchoutemp)) : ?>
                                <div class="punch-det">
                                    <a href="/companies-user/employeepunchin?emp_id=<?= $user_id ?>&company_id=<?= $companyId ?>&attendencedashboard=<?= $user_id ?>" class="btn btn-primary punch-btn">Punch In</a>
                                </div>
                            <?php endif; ?>

                            <div class="statistics">
                                <div class="row">
                                    <!--  <div class="col-md-6 col-6 text-center">
	                                    <div class="stats-box">
	                                        <p>Break</p>
	                                        <h6>1.21 hrs</h6>
	                                    </div>
	                                </div> -->

                                    <div class="col-md-12 col-12 text-center">
                                        <div class="stats-box">
                                            <p>Total Hours</p>


                                            <h6> <?= number_format($todayhrs,2, ',', ' ')?> hrs</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="punch-det">

                                <a href="/companies-user/employeepunchin?emp_id=<?= $user_id ?>&company_id=<?= $companyId ?>&attendencedashboard=<?= $user_id ?>" class="btn btn-primary punch-btn">Punch In</a>
                            </div>
                        <?php endif; ?>



                    </div>
                </div>
            </div>
            <?php if (!empty($todayactivity)) : ?>
                <div class="col-md-4">
                    <div class="card att-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Statistics</h5>
                            <div class="stats-list">
                                <div class="stats-info">

                                    <p>Today <strong><?= number_format($todayhrs,2, ',', ' ') ?>  <small>/ 8 hrs</small></strong></p>
                                    <?php $progress =  round(($todayhrs / 8) * 100); ?>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $progress ?>%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>


                                <div class="stats-info">
                                    <p>This Week <strong><?=number_format($weeklyhrs,2, ',', ' ') ?> <small>/ 40 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= round(($weeklyhrs / 40) * 100) ?>%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="stats-info">
                                    <p>This Month <strong><?=  number_format($monthlyhrs,2, ',', ' ')  ?> <small>/ 160 hrs</small></strong></p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width:<?= round(($monthlyhrs / 160) * 100) ?>%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <!--  <div class="stats-info">
	                                <p>Remaining <strong>90 <small>/ 160 hrs</small></strong></p>
	                                <div class="progress">
	                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
	                                </div>
	                            </div>
	                            <div class="stats-info">
	                                <p>Overtime <strong>4</strong></p>
	                                <div class="progress">
	                                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
	                                </div>
	                            </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card recent-activity">
                        <div class="card-body">
                            <h5 class="card-title">Today Activity</h5>
                            <ul class="res-activity-list">

                                <?php foreach ($todayactivity as $today) : ?>

                                    <?php if (strtotime($today->start_time->i18nFormat('dd-MM-yyyy', 'Europe/Rome')) == strtotime(Time::now()->i18nFormat('dd-MM-yyyy', 'Europe/Rome'))) : ?>
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
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>




        <!-- Search Filter -->

        <form method="post" action="/workinghours/searchattendance">
            <div class="row filter-row">
                <div class="col-sm-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input type="text" class="form-control floating datetimepicker" id="searchbydate" name="date">
                        </div>
                        <label class="focus-label">Date</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="month">
                            <option value="null">Select Month</option>
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
                <div class="col-sm-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="year">
                            <option value="null">Select Year</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                        <label class="focus-label">Select Year</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="companyId" value="<?= $companyId ?>">
                </div>
            </div>

        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>#Employee Id</th>
                                <th>Date </th>
                                <th>Punch In</th>
                                <th>Punch Out</th>
                                <th>Description</th>
                                <th>Production</th>
                                <th>Break</th>
                                <th>Overtime</th>
                                <th class="text-right">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendances as $key => $attendance) : ?>
                                <tr id="myrow_<?= $key ?>">
                                    <td><?=$attendance->user_id?></td>
                                    <td>
                                        <?php if ($attendance->start_time != null) : ?>
                                            <?= $attendance->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <?php if ($attendance->start_time != null) : ?>
                                            <?= $attendance->start_time->i18nFormat('HH:mm:ss', 'Europe/Rome'); ?></td>
                                <?php endif; ?>
                                <td>
                                    <?php if ($attendance->end_time != null) : ?>
                                        <?= $attendance->end_time->i18nFormat('HH:mm:ss', 'Europe/Rome'); ?>
                                    <?php endif; ?>
                                </td>
                                <td><?=$attendance->description?></td>


                                <?php
                                if ($attendance->end_time != null) {
                                    $diff = strtotime($attendance->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                    $hours = round($diff / (60 * 60), 2);
                                } else {
                                    $diff = strtotime(Time::now()->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                    $hours = round($diff / (60 * 60), 2);
                                }
                                ?>
                                <td><?= $hours ?> hrs</td>
                                <td>--</td>
                                <td>--</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_timesheet_<?= $attendance->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_timesheet_<?= $attendance->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                                </tr>




                                <!-- Edit Time Sheet Modal -->
                                <div class="modal custom-modal fade" id="edit_timesheet_<?= $attendance->id ?>" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Timesheet</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card punch-status">
                                                            <div class="card-body">


                                                                <!--  <h5 class="card-title" style="text-align: center;"> Edit Timesheet <small class="text-muted"></small></h5> -->
                                                                <form method="post" action="/workinghours/updatetimesheet">
                                                                    <div class="form-group">
                                                                        <label>Punch In Time</label>
                                                                        <input class="form-control" type="text" name="punchintime" value="<?= $attendance->start_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?>">

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Punch Out Time</label>
                                                                        <?php if ($attendance->end_time != null) : ?>
                                                                            <input class="form-control" type="text" name="punchouttime" value="<?= $attendance->end_time->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?>">
                                                                        <?php else : ?>
                                                                            <input class="form-control" type="text" name="punchouttime">
                                                                        <?php endif; ?>
                                                                    </div>

                                                                    <div class="punch-btn-section">
                                                                        <button type="submit" class="btn btn-primary punch-btn">Update</button>
                                                                        <input type="hidden" name="timesheetId" value="<?= $attendance->id ?>">
                                                                        <input type="hidden" name="userId" value="<?= $attendance->user_id ?>">
                                                                        <input type="hidden" name="companyId" value="<?= $attendance->company_id ?>">
                                                                    </div>

                                                                </form>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Edit Time Sheet Modal -->




                                <!-- Delete Time Sheet Modal -->
                                <div class="modal custom-modal fade" id="delete_timesheet_<?= $attendance->id ?>" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                    <h3>Delete Time Sheet</h3>
                                                    <p>Are you sure want to delete?</p>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="/workinghours/delete/<?= $attendance->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Delete Time Sheet Modal  -->
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

<script>
    $(function() {

        $(document).ready(function() {

            //search fromdate
            $("#searchbydate").datetimepicker().on('dp.change', function() {

                var fromdate = $('#searchbydate').val();
                for (i = 0; i < <?= count($attendances) ?>; i++) {
                    var myrow = document.getElementById('myrow_' + i);
                    var txt = myrow.getElementsByTagName('td')[1].innerText;
                    if (txt) {
                        if (new Date(txt).getTime() == new Date(fromdate).getTime()) {
                            myrow.style.display = "";
                        } else {
                            myrow.style.display = "none";
                        }
                    }
                }

                //  console.log(fromdate)

            })






        });

    });
</script>
