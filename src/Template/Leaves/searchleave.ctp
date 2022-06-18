	<!-- Page Wrapper -->
	<div class="page-wrapper">

	    <!-- Page Content -->
	    <div class="content container-fluid">

	        <!-- Page Header -->
	        <div class="page-header">
	            <div class="row">
	                <div class="col-sm-12">
	                    <h3 class="page-title">Leave Search</h3>
	                    <ul class="breadcrumb">
	                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
	                        <li class="breadcrumb-item active">Search</li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	        <!-- /Page Header -->

	        <!-- Content Starts -->
	        <div class="row">
	            <div class="col-12">

	                <!-- Search Filter -->
	                <form action="/leaves/searchleave">
	                    <div class="row filter-row">
	                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
	                            <div class="form-group form-focus">
	                                <input type="text" id="myInput" class="form-control floating" name="employeename" onkeyup="myFunction(this)">
	                                <label class="focus-label">Employee Name</label>
	                            </div>
	                        </div>
	                        <?php $total = count($leavesData); ?>
	                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
	                            <div class="form-group form-focus select-focus">
	                                <select id="searchleavetype" class="select floating" name="leavetype" onchange="serachLeavetype(<?= $total ?>)">
	                                    <option disabled> -- Select -- </option>
	                                    <option>Casual Leave</option>
	                                    <option>Medical Leave</option>
	                                    <option>Loss of Pay</option>
	                                </select>
	                                <label class="focus-label">Leave Type</label>
	                            </div>
	                        </div>
	                        <br />
	                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
	                            <div class="form-group form-focus select-focus">
	                                <select id="serachLeavestatus" class="select floating" name="leavestatus" onchange="serachLeavestatus(<?= $total ?>)">
	                                    <option> -- Select -- </option>
	                                    <option> Pending </option>
	                                    <option> Approved </option>
	                                    <option> Rejected </option>
	                                </select>
	                                <label class="focus-label">Leave Status</label>
	                            </div>
	                        </div>
	                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
	                            <div class="form-group form-focus">
	                                <div class="cal-icon">
	                                    <input id="searchfromdate" class="form-control floating datetimepicker" type="text" name="fromdate">
	                                </div>
	                                <label class="focus-label">From</label>
	                            </div>
	                        </div>
	                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
	                            <div class="form-group form-focus">
	                                <div class="cal-icon">
	                                    <input id="todatesearch" class="form-control floating datetimepicker" type="text" name="todate">
	                                </div>
	                                <label class="focus-label">To</label>
	                            </div>
	                        </div>
	                        <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
	                            <input type="hidden" name="companyId" value="<?= $companyId ?>">
	                            <button type="submit" class="btn btn-success btn-block"> Search </button>
	                        </div>
	                    </div>
	                </form>
	                <!-- /Search Filter -->

	                <div class="search-result">
	                    <h3>Search Result Found For: <u>Keyword</u></h3>
	                    <p>215 Results found</p>
	                </div>

	                <div class="row">
	                    <div class="col-md-12">
	                        <div class="table-responsive">
	                            <table id="myTable" class="table table-striped custom-table mb-0 datatable">
	                                <thead>
	                                    <tr>
	                                        <th>Employee</th>
	                                        <th>Leave Type</th>
	                                        <th>From</th>
	                                        <th>To</th>
	                                        <th>No of Days</th>
	                                        <th>Reason</th>
	                                        <th class="text-center">Status</th>
	                                        <th class="text-right">Actions</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <?php

                                        use App\Model\Entity\Leave;

                                        foreach ($leavesData as $key => $leave) : ?>
	                                        <tr id="myrow_<?= $key ?>">
	                                            <td>
	                                                <h2 class="table-avatar">
	                                                    <a href="/user/view/<?= $leave->user->id ?>" class="avatar">
	                                                        <?php if ($leave->user->profileFilepath != null && $leave->user->profileFilename != null) : ?>
	                                                            <img alt="" src="<?= $leave->user->profileFilepath ?>/<?= $leave->user->profileFilename ?>">
	                                                        <?php else : ?>
	                                                            <img alt="" src="/assets/img/profiles/avatar-02.jpg">
	                                                        <?php endif; ?>
	                                                    </a>
	                                                    <a href="/user/view/<?= $leave->user->id ?>"> <?= $leave->user->firstname ?> <?= $leave->user->lastname ?>
	                                                        <?php foreach ($companymembers as $companymember) : ?>
	                                                            <?php if ($leave->user_id == $companymember->user_id) : ?>
	                                                                <p><span><?= $companymember->designation->name ?></span></p>
	                                                            <?php endif; ?>
	                                                        <?php endforeach; ?>
	                                                    </a>
	                                                </h2>
	                                            </td>
	                                            <?php if ($leave->leavetype == 'M') : ?>
	                                                <td>Medical Leave</td>
	                                            <?php elseif ($leave->leavetype == 'C') : ?>
	                                                <td>Casual Leave</td>
	                                            <?php else : ?>
	                                                <td>Loss Of Pay Leave</td>
	                                            <?php endif; ?>
	                                            <td id="fromdaterow_<?= $key ?>"><?= $leave->fromdate->i18nFormat('dd/MM/yyyy'); ?></td>
	                                            <td id="todaterow_<?= $key ?>"><?= $leave->todate->i18nFormat('dd/MM/yyyy'); ?></td>
	                                            <?php $difference = date_diff($leave->fromdate, $leave->todate) ?>
	                                            <td><?= $difference->format("%a days"); ?></td>
	                                            <td><?= $leave->leavereason ?></td>
	                                            <td class="text-center">
	                                                <select class="select2-icon" id="leavestatus_<?= $key ?>" name="leavestatus" onchange="updateLeavestatus(this, <?= $leave->id ?>); return false;">
	                                                    <?php if ($leave->status == 'N') : ?>
	                                                        <option value="N" selected data-icon="fa fa-dot-circle-o text-purple">New</option>
	                                                        <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
	                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">Approved</option>
	                                                        <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>

	                                                    <?php elseif ($leave->status == 'A') : ?>
	                                                        <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
	                                                        <option value="A" selected data-icon="fa fa-dot-circle-o text-success">approved</option>
	                                                        <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
	                                                        <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>
	                                                    <?php elseif ($leave->status == 'P') : ?>
	                                                        <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
	                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">approved</option>
	                                                        <option value="P" selected data-icon="fa fa-dot-circle-o text-info">Pending</option>
	                                                        <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>
	                                                    <?php else : ?>
	                                                        <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
	                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">approved</option>
	                                                        <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
	                                                        <option value="R" selected data-icon="fa fa-dot-circle-o text-danger">Rejected</option>
	                                                    <?php endif; ?>
	                                                </select>

	                                            </td>
	                                            <td class="text-right">
	                                                <div class="dropdown dropdown-action">
	                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
	                                                    <div class="dropdown-menu dropdown-menu-right">
	                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_leave_<?= $leave->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
	                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_approve_<?= $leave->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
	                                                    </div>
	                                                </div>
	                                            </td>
	                                        </tr>
	                                        <!-- Delete Leave Modal -->
	                                        <div class="modal custom-modal fade" id="delete_approve_<?= $leave->id ?>" role="dialog">
	                                            <div class="modal-dialog modal-dialog-centered">
	                                                <div class="modal-content">
	                                                    <div class="modal-body">
	                                                        <div class="form-header">
	                                                            <h3>Delete Leave</h3>
	                                                            <p>Are you sure want to Cancel this leave?</p>
	                                                        </div>
	                                                        <div class="modal-btn delete-action">
	                                                            <div class="row">
	                                                                <div class="col-6">
	                                                                    <a href="/leaves/delete/<?= $leave->id ?>" class="btn btn-primary continue-btn">Delete</a>
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
	                                        <!-- /Delete Leave Modal -->

	                                        <!-- Edit Leave Modal -->
	                                        <div id="edit_leave_<?= $leave->id ?>" class="modal custom-modal fade" role="dialog">
	                                            <div class="modal-dialog modal-dialog-centered" role="document">
	                                                <div class="modal-content">
	                                                    <div class="modal-header">
	                                                        <h5 class="modal-title">Edit Leave</h5>
	                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                                            <span aria-hidden="true">&times;</span>
	                                                        </button>
	                                                    </div>
	                                                    <div class="modal-body">
	                                                        <form method="post" action="/leaves/updateleave">
	                                                            <div class="form-group">
	                                                                <label>Leave Type <span class="text-danger">*</span></label>
	                                                                <select class="select" id="leavetype" name="leavetype" onchange="changeLeaveTypeupdate(this, <?= $leave->id ?>); return false;">
	                                                                    <?php if ($leave->leavetype == 'M') : ?>
	                                                                        <option value="M" selected>Medical Leave</option>
	                                                                        <option value="C">Casual Leave </option>
	                                                                        <option value="L">Loss of Pay </option>
	                                                                    <?php elseif ($leave->leavetype == 'C') : ?>
	                                                                        <option value="M">Medical Leave</option>
	                                                                        <option value="C" selected>Casual Leave </option>
	                                                                        <option value="L">Loss of Pay </option>
	                                                                    <?php else : ?>
	                                                                        <option value="M">Medical Leave</option>
	                                                                        <option value="C">Casual Leave </option>
	                                                                        <option value="L" selected>Loss of Pay </option>
	                                                                    <?php endif; ?>
	                                                                </select>
	                                                            </div>
	                                                            <?php if ($leave->leavetype == 'M') : ?>
	                                                                <div id="medicalnumber" style="margin-left:10%;">
	                                                                    <label for="medicalno"><?= __('Enter Medical Number') ?></label>
	                                                                    <input type="number" id="medicalnumber" name="medicalno" value="<?= $leave->medical_number ?>">

	                                                                </div>
	                                                            <?php endif; ?>
	                                                            <div class="form-group">
	                                                                <label>From <span class="text-danger">*</span></label>
	                                                                <div class="cal-icon">
	                                                                    <input class="form-control datetimepicker" name="fromdate" value="<?= $leave->fromdate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?>" type="text">
	                                                                </div>
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>To <span class="text-danger">*</span></label>
	                                                                <div class="cal-icon">
	                                                                    <input class="form-control datetimepicker" name="todate" value="<?= $leave->todate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?>" type="text">
	                                                                </div>
	                                                            </div>
	                                                            <?php
                                                                $diff = abs(strtotime($leave->todate) - strtotime($leave->fromdate));
                                                                $years = floor($diff / (365 * 60 * 60 * 24));
                                                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                                                $totaldays = $days;
                                                                //$difference = date_diff($emp->fromdate, $emp->todate)
                                                                ?>
	                                                            <div class="form-group">
	                                                                <label>Number of days <span class="text-danger">*</span></label>
	                                                                <input class="form-control" readonly type="text" value="<?= $totaldays ?>">
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>Remaining Leaves <span class="text-danger">*</span></label>
	                                                                <input class="form-control" readonly value="12" type="text">
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>Leave Reason <span class="text-danger">*</span></label>
	                                                                <textarea rows="4" name="leavereason" class="form-control"><?= $leave->leavereason ?></textarea>
	                                                            </div>
	                                                            <div class="submit-section">
	                                                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
	                                                                <input type="hidden" name="lid" value="<?= $leave->id ?>">
	                                                                <input type="hidden" name="kid" value="<?= $leave->id ?>">
	                                                            </div>
	                                                        </form>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <!-- /Edit Leave Modal -->
	                                    <?php endforeach; ?>


	                                </tbody>
	                            </table>
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

	<script>
	    function formatText(icon) {
	        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
	    };
	    $('.select2-icon').select2({
	        width: "100%",
	        templateSelection: formatText,
	        templateResult: formatText
	    });
	</script>
