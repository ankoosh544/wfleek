<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Available Employees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Available Employees</li>
                    </ul>
                </div>
                <!--   <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                </div> -->
            </div>
        </div>
        <!-- /Page Header -->


        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUsers as $singleUser) : ?>

                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html" class="avatar"><img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>"></a>
                                        <h2><?= $singleUser->firstname ?>
                                </td>
                                <td><?= $singleUser->lastname ?></td>

                                <td class="text-center">

                                    <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-dot-circle-o text-purple"></i> Active
                                        </a>
                                    </div>
                                </td>
                                <td> <?= $singleUser->email ?></td>
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
