<style>
    .form-focus.select-focus .focus-label {
        opacity: 1;
        font-weight: 300;
        top: -20px;
        font-size: 12px;
        z-index: 1;
    }
</style>



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
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Leave Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>
                        <form action="/leaves/presentworkingemp" method="post">
                            <button class="btn btn-info" type="submit"> Presents(Available)</button>
                        </form>
                    </h6>
                    <?php $available = $totalemps - $totalleave; ?>
                    <h4><?= $available ?> / <?= $totalemps ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">

                    <h6>
                        <form action="/leaves/onleaveemployees" method="post">
                            <button class="btn btn-info" type="submit">Leaves</button>
                        </form>
                    </h6>
                    <h4><?= $totalleave ?> <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Unplanned Leaves</h6>
                    <h4>0 <span>Today</span></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-info">
                    <h6>Pending Requests</h6>
                    <h4><?= $totalpendings ?></h4>
                </div>
            </div>
        </div>
        <!-- /Leave Statistics -->

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
                            <option value=""> -- Select -- </option>
                            <option value="C">Casual Leave</option>
                            <option value="M">Medical Leave</option>
                            <option value="L">Loss of Pay</option>
                        </select>
                        <label class="focus-label">Leave Type</label>
                    </div>
                </div>
                <br />
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select id="serachLeavestatus" class="select floating" name="leavestatus" onchange="serachLeavestatus(<?= $total ?>)">
                            <option value=""> -- Select -- </option>
                            <option value="N"> New </option>
                            <option value="P"> Pending </option>
                            <option value="A"> Approved </option>
                            <option value="R"> Rejected </option>
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
                            <select class="select" id="leavetype" name="leavetype" onchange="changeLeaveType(this); return false;">
                                <option>Select Leave Type</option>
                                <option value="C">Casual Leave</option>
                                <option value="M">Medical Leave</option>
                                <option value="L">Loss of Pay</option>
                            </select>
                            </br>
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
                            <input type="hidden" name="companyId" value="<?=$companyId?>">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->


    <!-- Approve Leave Modal -->
    <div class="modal custom-modal fade" id="approve_leave" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Leave Approve</h3>
                        <p>Are you sure want to approve for this leave?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Approve</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Decline</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Approve Leave Modal -->

    <!-- Delete Leave Modal -->
    <div class="modal custom-modal fade" id="delete_approve" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave</h3>
                        <p>Are you sure want to delete this leave?</p>
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
    <!-- /Delete Leave Modal -->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    function updateLeavestatus(event, $id) {
        var $leavestatus = event.value;
        $.ajax({
            url: '/leaves/updateLeavestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'lid': $id,
                'leavestatus': $leavestatus,
            },
            success: function(data) {
                window.location.reload();
            },
            error: function() {}
        })

    }

    $(function() {
        $(document).ready(function() {

            //search fromdate
            $("#searchfromdate").datetimepicker().on('dp.change', function() {
                var fromdate = $('#searchfromdate').val();
                for (i = 0; i < <?= count($leavesData) ?>; i++) {
                    var myrow = document.getElementById('myrow_' + i);
                    var txt = myrow.getElementsByTagName('td')[2].innerText;
                    if (txt) {
                        if (new Date(txt).getTime() == new Date(fromdate).getTime()) {
                            myrow.style.display = "";
                        } else {
                            myrow.style.display = "none";
                        }
                    }
                }
            })

            //Search Todate
            $("#todatesearch").datetimepicker().on('dp.change', function() {
                var todate = $('#todatesearch').val();
                for (i = 0; i < <?= count($leavesData) ?>; i++) {
                    var myrow = document.getElementById('myrow_' + i);
                    var txt = myrow.getElementsByTagName('td')[3].innerText;
                    if (txt) {
                        if (new Date(txt).getTime() == new Date(todate).getTime()) {
                            myrow.style.display = "";
                        } else {
                            myrow.style.display = "none";
                        }
                    }
                }
            })
            $("#add_fromdate").datetimepicker({
                dateFormat: "dd/mm/yy"
            }).val();

            $("#add_todate").datetimepicker().on('dp.change', function() {
                myfunc();
            });

        });
        var ndays = 0;

        function myfunc() {
            var start = $("#add_fromdate").datetimepicker("viewDate");
            var end = $("#add_todate").datetimepicker("viewDate");
            days = (end - start) / (1000 * 60 * 60 * 24) + 1;
            ndays = Math.round(days);
            $("#ndays").val(ndays);
        }
    });

    function changeLeaveType(event) {
        var leavetype = event.value;
        if (leavetype === "M") {
            $("#medicalno").show()
        } else {
            $("#medicalno").hide()
        }
    }

    function changeLeaveTypeupdate(event) {
        var leavetype = event.value;
        console.log(leavetype);
        if (leavetype === "M") {
            $("#medicalnumber").show()
        } else {
            $("#medicalnumber").hide()
        }
    }

    function serachLeavetype(total) {
        var input, filter, tr, td, i, txtValue;
        input = $('#searchleavetype').val();
        filter = input.toUpperCase();
        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('myrow_' + i);
            var txt = myrow.getElementsByTagName('td')[1].innerText;
            if (txt) {
                if (txt.toUpperCase().includes(filter)) {
                    myrow.style.display = "";
                } else {
                    myrow.style.display = "none";
                }
            }
        }
    }

    function serachLeavestatus(total) {
        var input, filter, table, tr, td, i, txtValue;
        input = $('#serachLeavestatus').val();
        filter = input.toUpperCase();
        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('myrow_' + i);
            var select = $('#leavestatus_' + i).val();
            if (select == 'A') {
                select = 'Approved';
            }
            if (select == 'P') {
                select = 'Pending';
            }
            if (select === 'R') {
                select = 'Rejected';
            }
            if (select === 'N') {
                select = 'New';
            }
            if (select) {
                if (select.toUpperCase().includes(filter)) {
                    myrow.style.display = "";
                } else {
                    myrow.style.display = "none";
                }
            }
        }
    }

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };
    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });
</script>
