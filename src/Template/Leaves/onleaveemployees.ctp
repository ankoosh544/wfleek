<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leaves</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
              <!--   <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                </div> -->
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Leave Statistics -->
        <!-- <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Annual Leave</h6>
                    <h4>12</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Medical Leave</h6>
                    <h4>3</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Other Leave</h6>
                    <h4>4</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Remaining Leave</h6>
                    <h4>5</h4>
                </div>
            </div>
        </div> -->
        <!-- /Leave Statistics -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>No of Days</th>
                                <th>Reason</th>
                                <th class="text-center">Status</th>
                                <th>Approved by</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaves as $emp) : ?>
                                <tr>
                                    <?php foreach($user as $singleUser):?>
                                        <?php if($singleUser->id == $emp->user_id):?>
                                        <td><?=$singleUser->firstname?> <?=$singleUser->lastname?></td>
                                        <?php endif ;?>
                                        <?php endforeach ;?>
                                    <?php if ($emp->leavetype == 'M') : ?>
                                        <td>Medical Leave</td>
                                    <?php elseif ($emp->leavetype == 'C') : ?>
                                        <td>Casual Leave</td>
                                    <?php else : ?>
                                        <td>Loss Of Pay Leave</td>
                                    <?php endif; ?>

                                    <td><?= $emp->fromdate->i18nFormat('dd/MM/yyyy'); ?></td>
                                    <td><?= $emp->todate->i18nFormat('dd/MM/yyyy'); ?></td>
                                    <?php $difference = date_diff($emp->fromdate, $emp->todate) ?>
                                    <td><?= $difference->format("%a days");  ?></td>
                                    <td><?= $emp->leavereason ?></td>
                                    <td class="text-center">
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="javascript:void(0);">
                                                <?php if ($emp->status == 'N') : ?>
                                                    <i class="fa fa-dot-circle-o text-purple"></i> New
                                                <?php elseif ($emp->status == 'A') : ?>
                                                    <i class="fa fa-dot-circle-o text-purple"></i> Approved
                                                <?php elseif ($emp->status == 'P') : ?>
                                                    <i class="fa fa-dot-circle-o text-purple"></i> Pending
                                                <?php else : ?>
                                                    <i class="fa fa-dot-circle-o text-purple"></i> Rejected
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <?php foreach($user as $singleUser) : ?>
                                                <?php if($singleUser->id == $admin->memberId) : ?>
                                            <a href="profile.html" class="avatar avatar-xs"><img src="<?=$singleUser->profileFilepath?>/<?=$singleUser->profileFilename?>" alt=""></a>
                                            <a href="#"><?=$singleUser->firstname?> <?=$singleUser->lastname?></a>
                                            <?php endif ;?>
                                            <?php endforeach ;?>
                                        </h2>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_leave_<?= $emp->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_approve_<?= $emp->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Leave Modal -->
                                <div id="edit_leave_<?= $emp->id ?>" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Leave <?= $emp->id ?> </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label>Leave Type <span class="text-danger">*</span></label>
                                                        <select id="leavetype" name="leavetype" onchange="changeLeaveType(this, <?= $emp->id ?>); return false;">


                                                            <?php if ($emp->leavetype == 'M') : ?>
                                                                <option value="M" selected> Medical Leave</option>
                                                                <option value="C"> Casual Leave</option>
                                                                <option value="P">Loss of Pay</option>


                                                            <?php elseif ($emp->leavetype == 'C') : ?>
                                                                <option value="M"> Medical Leave</option>
                                                                <option value="C" selected> Casual Leave</option>
                                                                <option value="P">Loss of Pay</option>


                                                            <?php else : ?>
                                                                <option value="M"> Medical Leave</option>
                                                                <option value="C"> Casual Leave</option>
                                                                <option value="P" selected>Loss of Pay</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>

                                                    <?php if ($emp->leavetype == 'M') : ?>
                                                        <div id="medicalno" style="margin-left:10%;">
                                                            <label for="medicalno"><?= __('Enter Medical Number') ?></label>
                                                            <input type="number" id="medicalno" name="medicalno" value="<?= $emp->medical_number ?>">

                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="form-group">
                                                        <label>From <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" value="<?= $emp->fromdate->i18nFormat('dd-MM-yyyy'); ?>" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>To <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker" value="<?= $emp->todate->i18nFormat('dd-MM-yyyy'); ?>" type="text">
                                                        </div>
                                                    </div>
                                                    <?php $difference = date_diff($emp->fromdate, $emp->todate) ?>
                                                    <div class="form-group">
                                                        <label>Number of days <span class="text-danger">*</span></label>
                                                        <input class="form-control" readonly type="text" value="<?= $difference->format("%a"); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Remaining Leaves <span class="text-danger">*</span></label>
                                                        <input class="form-control" readonly value="12" type="text">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Leave Reason <span class="text-danger">*</span></label>
                                                        <textarea rows="4" class="form-control"><?= $emp->leavereason ?></textarea>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Edit Leave Modal -->

                                <!-- Delete Leave Modal -->
                                <div class="modal custom-modal fade" id="delete_approve_<?=$emp->id?>" role="dialog">
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
                                                            <a href="/leaves/delete/<?=$emp->id?>" class="btn btn-primary continue-btn">Delete</a>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->





</div>
<!-- /Page Wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script type="text/javascript">
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
            console.log(ndays);
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


        // ajax call


    }
</script>
