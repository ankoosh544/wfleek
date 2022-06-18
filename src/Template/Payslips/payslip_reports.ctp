<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Payslip Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payslip Reports</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <!-- Search Filter -->
        <div class="row filter-row">

            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <select class="form-control floating select">
                            <option>
                                Jan
                            </option>
                            <option>
                                Feb
                            </option>
                            <option>
                                Mar
                            </option>
                        </select>
                    </div>
                    <label class="focus-label">Month</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <select class="form-control floating select">
                            <option>
                                2018
                            </option>
                            <option>
                                2019
                            </option>
                            <option>
                                2020
                            </option>
                        </select>
                    </div>
                    <label class="focus-label">Year</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
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
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Paid Amount</th>
                                <th>Payment Month</th>
                                <th>Payment Year</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companymembers as $index => $companymember) : ?>
                                <?php if ($companymember->member_role != 'C') : ?>

                                    <tr>
                                        <td><?= $index + 1 ?> </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <?php if ($companymember->payslip->user->profileFilepath != null && $companymember->payslip->user->profileFilename != null) : ?>
                                                        <img alt="" src="<?= $companymember->payslip->user->profileFilepath ?>/<?= $companymember->payslip->user->profileFilename ?>">
                                                    <?php else : ?>
                                                        <img alt="" src="/assets/img/profiles/avatar-13.jpg">
                                                    <?php endif; ?>
                                                </a>

                                                <a href="profile.html"><?= $companymember->payslip->user->firstname ?> <?= $companymember->payslip->user->lastname ?>
                                                    <?php if ($companymember->member_role == 'Y') : ?> <span>Web Developer</span>
                                                    <?php elseif ($companymember->member_role == 'A') : ?> <span>Functional Analyst</span>
                                                    <?php elseif ($companymember->member_role == 'Z') : ?> <span>Project Manager</span>
                                                    <?php elseif ($companymember->member_role == 'X') : ?> <span>Developer</span>
                                                    <?php endif; ?>
                                                </a>
                                            </h2>
                                        </td>
                                        <td>$200</td>
                                        <td>Apr</td>
                                        <td>2019</td>
                                        <td class="text-center"> <a href="#" class="btn btn-sm btn-primary">PDF</a></td>
                                    </tr>

                                <?php endif; ?>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
