<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">

            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Search</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                    <a href="/workinghours/attendance?emp_id=<?=$user_id?>&company_id=<?=$companyId?>" class="btn btn-success btn-block"> Go Back </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="row">
            <div class="col-12">


                <div class="search-lists">

                    <div class="tab-content">
                        <div class="tab-pane show active" id="results_projects">



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table datatable">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date </th>
                                                    <th>Punch In</th>
                                                    <th>Punch Out</th>
                                                    <th>Production</th>
                                                    <th>Break</th>
                                                    <th>Overtime</th>
                                                    <th class="text-right">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php foreach ($matched_data as $key => $attendance) : ?>
                                                    <tr id="myrow_<?= $key ?>">
                                                        <td>1</td>
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


                                                    <?php
                                                    if ($attendance->end_time != null) {
                                                        $diff = strtotime($attendance->end_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome')) - strtotime($attendance->start_time->i18nFormat('dd-MM-yyyy HH:mm:ss', 'Europe/Rome'));
                                                        $hours = round($diff / (60 * 60), 2);
                                                    } else {
                                                        $hours = 0;
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
                    </div>
                </div>

            </div>
        </div>
        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
