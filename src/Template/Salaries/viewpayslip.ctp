<?php

use Cake\I18n\Number;

?>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Payslip</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payslip</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="btn-group btn-group-sm">
                        <a href="/salaries/downloadcsv/<?=$employeepayslip->id?>"  class="btn btn-white"> Download CSV</a>
                        <a href="/salaries/downloadpdf/<?=$employeepayslip->id?>"  class="btn btn-white"> Download PDF</a>
                        <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="payslip-title">Payslip for the month of <?= $employeepayslip->month ?> <?= $employeepayslip->year ?></h4>
                        <div class="row">
                            <div class="col-sm-6 m-b-20">
                                <img src="/assets/img/logo2.png" class="inv-logo" alt="">
                                <ul class="list-unstyled mb-0">
                                    <li><strong><?= $employeepayslip->usercompany->name ?></strong></li>
                                    <li><?= $employeepayslip->usercompany->address ?>,</li>
                                    <li><?= $employeepayslip->usercompany->country ?> <?= $employeepayslip->usercompany->state ?>, <?= $employeepayslip->usercompany->postal_code ?></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 m-b-20">
                                <div class="invoice-details">
                                    <h3 class="text-uppercase">Payslip #<?= $employeepayslip->id ?></h3>
                                    <ul class="list-unstyled">
                                        <li>Salary Month: <span><?= $employeepayslip->month ?> ,<?= $employeepayslip->year ?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 m-b-20">
                                <ul class="list-unstyled">
                                    <li>
                                        <h5 class="mb-0"><strong><?= $employeepayslip->user->firstname ?> <?= $employeepayslip->user->lastname ?></strong></h5>
                                    </li>

                                    <?php if ($employee->member_role == 'Y') : ?>
                                        <li><span>Administrator</span></li>
                                    <?php elseif ($employee->member_role == 'X') : ?>
                                        <li><span>Developer</span></li>
                                    <?php elseif ($employee->member_role == 'Z') : ?>
                                        <li><span>Project Manager</span></li>
                                    <?php elseif ($employee->member_role == 'H') : ?>
                                        <li><span>HR</span></li>
                                    <?php elseif ($employee->member_role == 'C') : ?>
                                        <li><span>Customer</span></li>
                                    <?php endif; ?>


                                    <li>Employee ID: <?=$employeepayslip->user->id?></li>
                                    <li>Joining Date: <?=$employeepayslip->user->registrationDate?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Earnings</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Basic Salary</strong> <span class="float-right"><?=  Number::currency(($employeepayslip->net_salary), 'EUR', ['locale' => 'it_IT']); ?></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>House Rent Allowance (H.R.A.)</strong> <span class="float-right"><?=$employeepayslip->hra?></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>T D S</strong> <span class="float-right"><?=$employeepayslip->tds?></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>PF</strong> <span class="float-right"><?=$employeepayslip->pf?></span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tax</strong> <span class="float-right"><strong><?=$employeepayslip->tax?></strong></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h4 class="m-b-10"><strong>Deductions</strong></h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Tax Deducted at Source (T.D.S.)</strong> <span class="float-right">$0</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Provident Fund</strong> <span class="float-right">$0</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>ESI</strong> <span class="float-right">$0</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Loan</strong> <span class="float-right">$300</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Deductions</strong> <span class="float-right"><strong>$59698</strong></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <p><strong>Net Salary: $59698</strong> (Fifty nine thousand six hundred and ninety eight only.)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
