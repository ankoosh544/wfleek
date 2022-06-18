<?php

use Cake\I18n\Time;

?>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Timesheet</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Timesheet</li>
                    </ul>
                </div>
              <!--   <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_todaywork"><i class="fa fa-plus"></i> Add Today Work</a>
                </div> -->
            </div>
        </div>
        <!-- /Page Header -->

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
                                    <td><?= $attendance->user_id ?></td>
                                    <td>
                                        <?php if ($attendance->start_time != null) : ?>
                                            <?= date('l', strtotime($attendance->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome'))); ?>, <?=$attendance->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome')?>
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
                                <td><?= $attendance->description ?></td>


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

    <!-- Add Today Work Modal -->
    <div id="add_todaywork" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Today Work details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Project <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>Office Management</option>
                                    <option>Project Management</option>
                                    <option>Video Calling App</option>
                                    <option>Hospital Administration</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>Deadline <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control" type="text" value="5 May 2019" readonly>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Total Hours <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="100" readonly>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Remaining Hours <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="60" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Hours <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control"></textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Today Work Modal -->

    <!-- Edit Today Work Modal -->
    <div id="edit_todaywork" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Work Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Project <span class="text-danger">*</span></label>
                                <select class="select">
                                    <option>Office Management</option>
                                    <option>Project Management</option>
                                    <option>Video Calling App</option>
                                    <option>Hospital Administration</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>Deadline <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control" type="text" value="5 May 2019" readonly>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Total Hours <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="100" readonly>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Remaining Hours <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="60" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" value="03/03/2019" type="text">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Hours <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" value="9">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel elit neque.</textarea>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Today Work Modal -->

    <!-- Delete Today Work Modal -->
    <div class="modal custom-modal fade" id="delete_workdetail" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Work Details</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
    <!-- Delete Today Work Modal -->

</div>
<!-- /Page Wrapper -->
