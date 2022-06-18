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
                    <h3 class="page-title">Employee's Requests</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Requests</li>
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
                    <label class="focus-label">Work Type</label>
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
                    <label class="focus-label">Work Status</label>
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
                                <th>Work Type</th>

                                <th>Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allrequest as $request) : ?>
                                <tr>

                                    <?php foreach ($allusers as $singleuser) : ?>
                                        <?php if ($request->user_id == $singleuser->id) : ?>
                                            <td>
                                                <a href="profile.html" class="avatar"><img alt="" src="<?= $singleuser->profileFilepath ?>/<?= $singleuser->profileFilename ?>"></a>
                                                <?= $singleuser->firstname ?><?= $singleuser->lastname ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <td>
                                        <?php if ($request->request_type == 'W') : ?> Work related
                                        <?php else : ?> Personal related
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($request->worktype == 'H') : ?> Work From Home
                                        <?php elseif ($request->worktype == 'M') : ?> Work From Milan
                                        <?php elseif ($request->worktype == 'H') : ?> Work From Vareze
                                        <?php else : ?> Others
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $request->description ?></td>
                                    <td><?= $request->fromdate ?></td>
                                    <td><?= $request->todate ?></td>
                                    <td>
                                        <select class="select2-icon">
                                            <?php if ($request->status == 'N') : ?>
                                                <option selected data-icon="fa fa-dot-circle-o text-purple"> New</option>
                                            <?php elseif ($request->status == 'P') : ?>
                                                <option selected data-icon="fa fa-dot-circle-o text-info"> Pending</option>
                                            <?php elseif ($request->status == 'A') : ?>
                                                <option selected data-icon="fa fa-dot-circle-o text-success"> Approved</option>
                                            <?php else : ?>
                                                <option selected data-icon="fa fa-dot-circle-o text-danger"> Rejected</option>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_request_<?= $request->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_approve_<?= $request->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>



                                    <!-- Edit Request Modal -->
                                    <div id="edit_request_<?= $request->id ?>" class="modal custom-modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Request</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/employeerequests/updaterequest">
                                                        <div class="form-group">
                                                            <label>Request Type <span class="text-danger">*</span></label>
                                                            <select class="select" id="leavetype" name="request_type">
                                                                <?php if ($request->request_type == 'W') : ?>
                                                                    <option value="W" selected>Work Related</option>
                                                                    <option value="T">Time Related </option>
                                                                    <option value="O">Other </option>
                                                                <?php elseif ($leave->leavetype == 'T') : ?>
                                                                    <option value="W">Work Related</option>
                                                                    <option value="T" selected>Time Related </option>
                                                                    <option value="O">Other </option>
                                                                <?php else : ?>
                                                                    <option value="W">Work Related</option>
                                                                    <option value="T">Time Related </option>
                                                                    <option value="O" selected>Other </option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Request Title <span class="text-danger">*</span></label>
                                                            <input name="title" class="form-control" value="<?= $request->title ?>" type="text">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Work Type <span class="text-danger">*</span></label>
                                                            <select class="select2-icon" id="worktype" name="work_type">
                                                                <?php if ($request->request_type == 'H') : ?>
                                                                    <option value="H" selected>Work from Home</option>
                                                                    <option value="M">Work from Milan </option>
                                                                    <option value="V">Work from Vareze </option>
                                                                    <option value="O">Other </option>
                                                                <?php elseif ($request->request_type == 'M') : ?>
                                                                    <option value="H">Work from Home</option>
                                                                    <option value="M" selected>Work from Milan </option>
                                                                    <option value="V">Work from Vareze </option>
                                                                    <option value="O">Other </option>
                                                                <?php elseif ($request->request_type == 'V') : ?>
                                                                    <option value="H">Work from Home</option>
                                                                    <option value="M">Work from Milan </option>
                                                                    <option value="V" selected>Work from Vareze </option>
                                                                    <option value="O">Other </option>
                                                                <?php else : ?>
                                                                    <option value="H">Work from Home</option>
                                                                    <option value="M">Work from Milan </option>
                                                                    <option value="V">Work from Vareze </option>
                                                                    <option value="O" selected>Other </option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>From <span class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input class="form-control datetimepicker" name="fromdate" value="<?= $request->fromdate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?>" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>To <span class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input class="form-control datetimepicker" name="todate" value="<?= $request->todate->i18nFormat('dd/MM/yyyy, Europe/Rome'); ?>" type="text">
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $diff = abs(strtotime($request->todate) - strtotime($request->fromdate));
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
                                                            <label>Description <span class="text-danger">*</span></label>
                                                            <textarea rows="4" name="description" class="form-control"><?= $request->description ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status <span class="text-danger">*</span></label>
                                                            <select class="select" id="leavetype" name="status">
                                                                <?php if ($request->status == 'N') : ?>
                                                                    <option value="N" selected data-icon="fa fa-dot-circle-o text-purple">New</option>
                                                                    <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
                                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Approved</option>
                                                                    <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>

                                                                <?php elseif ($request->status == 'A') : ?>
                                                                    <option value="N" data-icon="fa fa-dot-circle-o text-purple"> New</option>
                                                                    <option value="A" selected data-icon="fa fa-dot-circle-o text-success">approved</option>
                                                                    <option value="P" data-icon="fa fa-dot-circle-o text-info">Pending</option>
                                                                    <option value="R" data-icon="fa fa-dot-circle-o text-danger">Rejected</option>
                                                                <?php elseif ($request->status == 'P') : ?>
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
                                                        </div>
                                                        <div class="submit-section">
                                                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                            <input type="hidden" name="rid" value="<?= $request->id ?>">

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Edit Leave Modal -->

                                </tr>
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
                            <select class="select" id="requesttype" name="requesttype" onchange="changeRequestType()">
                                <option>Select Request Type</option>
                                <option value="W">Work related</option>
                                <option value="O">Others</option>
                            </select>
                        </div>

                        <div class="form-group" id="workrequest" style="display: none;">
                            <label>Work type <span class="text-danger">*</span></label>
                            <select class="select" id="worktype" name="worktype">
                                <option>Select Request Type</option>
                                <option value="Work from Home">Work from Home</option>
                                <option value="Work from Milan">Work from Milan</option>
                                <option value="Work from Vareze">Work from Vareze</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <div>
                                <input name="name" class="form-control" type="text">
                            </div>
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
                                <input class="form-control datetimepicker" name="todate" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Request description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" class="form-control"></textarea>
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
        if (requesttype != 'W') {
            $("#workrequest").show()

            //$("#otherwork").hide()
        } else {
            $("#workrequest").hide()
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
