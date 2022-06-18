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
                    <h3 class="page-title">Employees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Work Status</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_request"><i class="fa fa-plus"></i> Add Request</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Leave Statistics -->

        <!-- /Leave Statistics -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" id="myInput" class="form-control floating" onkeyup="myFunction(this)">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select id="searchleavetype" class="select floating" onchange="serachLeavetype(<?= $total ?>)">
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
                    <select id="serachLeavestatus" class="select floating" onchange="serachLeavestatus(<?= $total ?>)">
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
                        <input id="searchfromdate" class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input id="todatesearch" class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Request Type</th>
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
                            ?>

                                <?php foreach ($allusers as $user) : ?>


                                        <tr id="myrow_<?= $key ?>">
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="profile.html" class="avatar"><img alt="" src="/assets/img/profiles/avatar-09.jpg"></a>

                                                    <a> <?= $user->firstname ?> <?= $user->lastname ?>
                                                        <?php foreach ($projectMember as $member) : ?>



                                                                <?php if ($member->type == 'X') : ?>
                                                                    <p><span>Developer</span></p>

                                                                <?php elseif ($member->type == 'Y') : ?>
                                                                    <p> <span>Administrator</span></p>

                                                                <?php elseif ($member->type == 'Z') : ?>
                                                                    <p><span>Project Manager</span></p>
                                                                <?php elseif ($member->type == 'H') : ?>
                                                                    <p><span>HR</span></p>
                                                                <?php else : ?>
                                                                    <p> <span>Coordinator</span></p>
                                                                <?php endif; ?>

                                                        <?php endforeach; ?>
                                                    </a>

                                                </h2>
                                            </td>

                                                <td>Medical Leave</td>

                                                <td>Casual Leave</td>

                                                <td>Loss Of Pay Leave</td>

                                            <td id="fromdaterow_<?= $key ?>"></td>
                                            <td id="todaterow_<?= $key ?>"><</td>

                                            <td></td>
                                            <td></td>
                                            <td class="text-center">
                                                <select class="select2-icon" id="leavestatus_<?= $key ?>" name="leavestatus" onchange="updateLeavestatus(this, <?= $leave->id ?>); return false;">

                                                        <option value="N" selected data-icon="fa fa-dot-circle-o text-purple">New</option>
                                                        <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">Approved</option>
                                                        <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>


                                                        <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
                                                        <option value="A" selected data-icon="fa fa-dot-circle-o text-success">approved</option>
                                                        <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
                                                        <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>

                                                        <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">approved</option>
                                                        <option value="P" selected data-icon="fa fa-dot-circle-o text-info">Pending</option>
                                                        <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>

                                                        <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">approved</option>
                                                        <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
                                                        <option value="R" selected data-icon="fa fa-dot-circle-o text-danger">Rejected</option>



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




                                <?php endforeach; ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Leave Modal -->
    <div id="add_request" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/employeerequests/addrequest" method="post">
                        <div class="form-group">
                            <label>Request Type <span class="text-danger">*</span></label>
                            <select id="requesttype" name="requesttype" onchange="changeRequestType(event)">
                                <option>Select Request Type</option>
                                <option value="W">Work related</option>
                               <option value="O">Others</option>
                            </select>
                        </div>
                        <div id="workrelated" style="display: none;">
                            <div class="form-group">
                                <label>Request Header workrelated <span class="text-danger">*</span></label>
                                <div>
                                    <input name="requestheader" id="add_fromdate" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Work type <span class="text-danger">*</span></label>
                                <select id="worktype" name="workype" >
                                    <option>Select Request Type</option>
                                    <option value="H">Work from Home</option>
                                    <option value="P">Work from Place</option>
                                    <option value="O">Others</option>
                                </select>


                            </div>
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="fromdate" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="todate"  type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <div class="form-control">
                                    <input name="name" id="add_fromdate" class="form-control" type="text">
                                </div>
                            </div>

                        </div>
                        <div id="otherwork" style="display: none;">



                            <div class="form-group">
                                <label>Request Name <span class="text-danger">*</span></label>
                                <div>
                                    <input name="name" class="form-control" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Work type <span class="text-danger">*</span></label>
                                <select id="worktype" name="workype" >
                                    <option>Select Request Type</option>
                                    <option value="H">Work from Home</option>
                                    <option value="P">Work from Place</option>
                                    <option value="O">Others</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="fromdate" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="todate"  type="text">
                                </div>
                            </div>



                            <div class="form-group">
                                <label>Request description <span class="text-danger">*</span></label>
                                <textarea name="leavereason" rows="4" class="form-control"></textarea>
                            </div>

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

    <!-- <!-- Edit Leave Modal -->
    <div id="edit_leave" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Leave</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Leave Type <span class="text-danger">*</span></label>
                            <select class="select">
                                <option>Select Leave Type</option>
                                <option>Casual Leave 12 Days</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>From <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="01-01-2019" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>To <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="01-01-2019" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Number of days <span class="text-danger">*</span></label>
                            <input class="form-control" readonly type="text" value="2">
                        </div>
                        <div class="form-group">
                            <label>Remaining Leaves <span class="text-danger">*</span></label>
                            <input class="form-control" readonly value="12" type="text">
                        </div>
                        <div class="form-group">
                            <label>Leave Reason <span class="text-danger">*</span></label>
                            <textarea rows="4" class="form-control">Going to hospital</textarea>
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
</div> -->



<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    function changeRequestType(event) {
        //window.location.reload();


        var type = $('#requesttype').val();
        console.log(type);
        if (requesttype === "W") {
            $("#workrelated").show()

            $("#otherwork").hide()
        } else {


            $("#otherwork").show()
        }


        // ajax call
    }




    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            console.log(td);
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
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });
</script>
