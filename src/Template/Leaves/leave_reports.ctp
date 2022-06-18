<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Leave Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Report</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="/leaves/generatepdf?companyId=<?=$companyId?>" class="btn btn-primary">PDF</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row mb-4">
            <div class="col-sm-6 col-md-2">
                <div class="form-group form-focus">
                    <input class="form-control floating" type="text">
                    <label class="focus-label">Employee</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Department</option>
                        <option>Designing</option>
                        <option>Development</option>
                        <option>Finance</option>
                        <option>Hr & Finance</option>
                    </select>
                    <label class="focus-label">Department</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>From Date</th>
                                <th>To Date</th
                                <th>Department</th>
                                <th>Leave Type</th>
                                <th>No.of Days</th>
                                <th>Remaining Leave</th>
                                <th>Total Leaves</th>
                                <th>Total Leave Taken</th>
                                <th>Leave Carry Forward</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($leaves as $leave) : ?>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="/user/view/<?= $leave->user_id ?>" class="avatar"><img alt="" src="/assets/img/profiles/avatar-02.jpg"></a>

                                            <a href="/user/view/<?= $leave->user_id ?>"><?= $leave->user->firstname ?> <?= $leave->user->lastname ?> <span>#<?= $leave->user_id ?></span></a>

                                        </h2>
                                    </td>
                                    <td><?=$leave->fromdate->i18nFormat('dd/MM/yyyy ', 'Europe/Rome')?></td>
                                    <td><?=$leave->todate->i18nFormat('dd/MM/yyyy ', 'Europe/Rome')?></td>
                                    <?php foreach ($companymembers as $companymember) : ?>
                                        <?php if ($companymember->user_id == $leave->user_id) : ?>
                                                <td><?=$companymember->designation->name?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td class="text-center">

                                        <?php if ($leave->leavetype == 'M') : ?>
                                            <button class="btn btn-outline-danger btn-sm"> Medical Leave </button>
                                        <?php elseif ($leave->leavetype == 'C') : ?>
                                            <button class="btn btn-outline-info btn-sm"> Casual Leave</button>
                                        <?php elseif ($leave->leavetype == 'L') : ?>
                                            <button class="btn btn-outline-warning btn-sm"> Loss of Pay Leave</button>
                                        <?php endif; ?>
                                    </td>

                                    <?php
                                    $diff = abs(strtotime($leave->todate) - strtotime($leave->fromdate));
                                    $years = floor($diff / (365 * 60 * 60 * 24));
                                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                    $totalannualleaves = 12;
                                    $remaing = $totalannualleaves - $days;

                                    ?>

                                    <td class="text-center"><span class="btn btn-danger btn-sm"><?= $days ?></span></td>
                                    <td class="text-center"><span class="btn btn-warning btn-sm"><b><?= $remaing ?></b></span></td>
                                    <td class="text-center"><span class="btn btn-success btn-sm"><b><?= $totalannualleaves ?></b></span></td>
                                    <td class="text-center"><?= $days ?></td>
                                    <td class="text-center">00</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
