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
                    <h3 class="page-title">Holidays 2019</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Holidays</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_holiday"><i class="fa fa-plus"></i> Add Holiday</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title </th>
                                <th>Holiday Date</th>
                                <th>Day</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>



                            <?php foreach ($allholidays as $holiday) : ?>

                                <?php if (strtotime($holiday->holiday_date->i18nFormat('dd-MM-yyyy')) >= strtotime("now")) : ?>
                                    <tr class="holiday-upcoming">
                                        <td><?= $holiday->id ?></td>
                                        <td><?= $holiday->holiday_name ?></td>
                                        <td><?= $holiday->holiday_date->i18nFormat('dd-MM-yyyy','Europe/Rome') ?></td>
                                        <td><?= date('l', strtotime($holiday->holiday_date->i18nFormat('dd-MM-yyyy'))); ?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_holiday_<?= $holiday->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday_<?= $holiday->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Edit Holiday Modal -->
                                        <div class="modal custom-modal fade" id="edit_holiday_<?= $holiday->id ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Holiday</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="/holidays/updateholiday" method="post">
                                                            <div class="form-group">
                                                                <label>Holiday Name <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="holiday_name" value="<?= $holiday->holiday_name ?>" type="text">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Holiday Date <span class="text-danger">*</span></label>
                                                                <div class="cal-icon"><input name="holiday_date" class="form-control datetimepicker" value="<?= $holiday->holiday_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" type="text"></div>
                                                            </div>
                                                            <div class="submit-section">
                                                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                                <input type="hidden" name="id" value="<?= $holiday->id ?>">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Holiday Modal -->

                                        <!-- Delete Holiday Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday_<?= $holiday->id ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Holiday</h3>
                                                            <p>Are you sure want to delete?</p>
                                                        </div>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <a href="/holidays/delete/<?=$holiday->id?>" class="btn btn-primary continue-btn">Delete</a>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete Holiday Modal -->

                                    </tr>
                                <?php else : ?>
                                    <tr class="holiday-completed">
                                        <td><?= $holiday->id ?></td>
                                        <td><?= $holiday->holiday_name ?></td>
                                        <td><?= $holiday->holiday_date->i18nFormat('dd-MM-yyyy','Europe/Rome') ?></td>
                                        <td><?= date('l', strtotime($holiday->holiday_date->i18nFormat('dd-MM-yyyy'))); ?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_holiday_<?= $holiday->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_holiday_<?= $holiday->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Edit Holiday Modal -->
                                        <div class="modal custom-modal fade" id="edit_holiday_<?= $holiday->id ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Holiday</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="/holidays/updateholiday" method="post">
                                                            <div class="form-group">
                                                                <label>Holiday Name <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="holiday_name" value="<?= $holiday->holiday_name ?>" type="text">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Holiday Date <span class="text-danger">*</span></label>
                                                                <div class="cal-icon"><input name="holiday_date" class="form-control datetimepicker" value="<?= $holiday->holiday_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" type="text"></div>
                                                            </div>
                                                            <div class="submit-section">
                                                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                                <input type="hidden" name="id" value="<?= $holiday->id ?>">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Holiday Modal -->

                                        <!-- Delete Holiday Modal -->
                                        <div class="modal custom-modal fade" id="delete_holiday_<?= $holiday->id ?>" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Delete Holiday</h3>
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
                                        <!-- /Delete Holiday Modal -->



                                    <?php endif; ?>
                                <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Holiday Modal -->
    <div class="modal custom-modal fade" id="add_holiday" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/holidays/addholiday" method="post">
                        <div class="form-group">
                            <label>Holiday Name <span class="text-danger">*</span></label>
                            <input name="name" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label>Holiday Date <span class="text-danger">*</span></label>
                            <div class="cal-icon"><input name="holidaydate" class="form-control datetimepicker" type="text"></div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Holiday Modal -->



</div>
<!-- /Page Wrapper -->
