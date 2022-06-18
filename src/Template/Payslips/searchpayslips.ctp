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
                        <a href="/payslips/payslips?empid=<?= $user_id ?>&companyId=<?= $companyId ?>" class="btn btn-success btn-block"> Go Back </a>
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
                                                    <th>Employee Name</th>
                                                    <th>Paid Amount</th>
                                                    <th>Payment Month</th>
                                                    <th>Payment Year</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php foreach ($matched_data as $key => $payslip) : ?>

                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="profile.html" class="avatar"><img alt="" src="/assets/img/profiles/avatar-13.jpg"></a>
                                                                <a href="profile.html"><?= $payslip->user->firstname ?> <?= $payslip->user->lastname ?>
                                                                    <?php foreach ($allemployees as $employee) : ?>

                                                                        <?php if ($employee->user_id == $payslip->user->id) : ?>
                                                                            <?php if ($employee->member_role == 'Y') : ?>
                                                                                <span class="badge bg-inverse-danger">Admin</span>
                                                                            <?php elseif ($employee->member_role == 'H') : ?>
                                                                                <span class="badge bg-inverse-danger">HR</span>
                                                                            <?php elseif ($employee->member_role == 'Z') : ?>
                                                                                <span class="badge bg-inverse-danger">Project Manager</span>
                                                                            <?php elseif ($employee->member_role == 'X') : ?>
                                                                                <span class="badge bg-inverse-danger">Developer</span>
                                                                            <?php elseif ($employee->member_role == 'C') : ?>
                                                                                <span class="badge bg-inverse-danger">Customer</span>
                                                                            <?php else : ?>
                                                                                <span class="badge bg-inverse-danger">CO-Ordinator</span>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>

                                                                    <?php endforeach; ?>
                                                                </a>
                                                            </h2>
                                                        </td>
                                                        <td>$200</td>
                                                        <td><?= $payslip->month ?></td>
                                                        <td><?= $payslip->year ?></td>
                                                        <td class="text-center"> <a href="/payslips/downloadpayslip/<?= $payslip->id ?>" class="btn btn-sm btn-primary"> <?= $payslip->payslip_filename ?> Download</a></td>
                                                    </tr>



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
