<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
< <!-- Page Wrapper -->
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
                        <h6>Annual Leave</h6>
                        <h4>12</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Medical Leave</h6>
                        <?php $medicalleaves = 0; ?>
                        <?php foreach ($empleave as $emp) : ?>
                            <?php if ($emp->leavetype == 'M' && $emp->status == 'A') : ?>
                                <?php $medicalleaves = $medicalleaves + 1; ?>
                                <h4><?= $medicalleaves ?></h4>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Other Leave</h6>
                        <?php $otherleaves = 0; ?>
                        <?php foreach ($empleave as $emp) : ?>
                            <?php if ($emp->leavetype != 'M' && $emp->status == 'A') : ?>
                                <?php $otherleaves = $otherleaves + 1; ?>
                                <h4><?= $otherleaves ?></h4>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Remaining Leave</h6>
                        <?php $remaingleaves = 12 - ($medicalleaves + $otherleaves) ?>
                        <h4><?= $remaingleaves ?></h4>
                    </div>
                </div>
            </div>
            <!-- /Leave Statistics -->

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
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
                                <?php foreach ($empleave as $emp) : ?>
                                    <tr>
                                        <?php if ($emp->leavetype == 'M') : ?>
                                            <td>Medical Leave</td>
                                        <?php elseif ($emp->leavetype == 'C') : ?>
                                            <td>Casual Leave</td>
                                        <?php else : ?>
                                            <td>Loss Of Pay Leave</td>
                                        <?php endif; ?>

                                        <td><?= $emp->fromdate->i18nFormat('dd/MM/yyyy'); ?></td>
                                        <td><?= $emp->todate->i18nFormat('dd/MM/yyyy'); ?></td>

                                        <?php
                                        $diff = abs(strtotime($emp->todate) - strtotime($emp->fromdate));
                                        $years = floor($diff / (365 * 60 * 60 * 24));
                                        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                        $totaldays = $days;

                                        ?>
                                        <?php if ($totaldays == 1) : ?>
                                            <td><?= $totaldays ?> day</td>
                                        <?php else : ?>
                                            <td><?= $totaldays ?> days</td>
                                        <?php endif; ?>
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
                                                <?php if ($emp->status == 'A') : ?>
                                                    <a href="profile.html" class="avatar avatar-xs"><img src="assets/img/profiles/avatar-09.jpg" alt=""></a>
                                                    <a href="#">Alessandra Lopa</a>
                                                <?php else : ?>
                                                    <a href="#">----</a>
                                                <?php endif; ?>
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
                                    <!----Edit Leave Modal--->

                                    <?= $this->element('edit_leavemodal',['emp' => $emp]) ?>

                                    <!-----/Edit Leave Modal--->



                                    <!-- Delete Leave Modal -->
                                    <div class="modal custom-modal fade" id="delete_approve_<?= $emp->id ?>" role="dialog">
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
                                                                <a href="/leaves/delete/<?= $emp->id ?>" class="btn btn-primary continue-btn">Delete</a>
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

        <!----Create Leave Modal------------>

        <?= $this->element('create_leavemodal') ?>

        <!----/Create Leave Moda------------>







    </div>
    <!-- /Page Wrapper -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script type="text/javascript">


        function changeLeaveTypeadd(event) {
            //window.location.reload();
            var leavetype = $('#addleavetype').val();
            //console.log(leavetype);
            if (leavetype === "M") {
                $("#addmedicalno").show()
            } else {
                $("#addmedicalno").hide()
            }


            // ajax call


        }

        function changeLeaveTypeupdate(event) {
            //window.location.reload();
            var leavetype = event.value;
            //console.log(leavetype);
            if (leavetype === "M") {
                $("#medicalno").show()
            } else {
                $("#medicalno").hide()
            }


            // ajax call


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
