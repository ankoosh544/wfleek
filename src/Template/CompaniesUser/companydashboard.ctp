<?php

use Cake\I18n\Number;

?>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-1">
                    <div class="avatar-box">
                        <div class="avatar avatar-xs" style="width: 100px;height: 100px;">
                            <?php if ($authuser->usercompany->company_logoFilepath != null && $authuser->usercompany->company_logoFilename != null) : ?>
                                <img src="<?= $authuser->usercompany->company_logoFilepath ?>/<?= $authuser->usercompany->company_logoFilename ?>" alt="">
                            <?php else : ?>
                                <img src="/assets/img/profiles/avatar-16.jpg" alt="">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-11">
                    <h3 class="page-title">
                        <?= $authuser->usercompany->name ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                    </br>
                    <div>
                        <div>
                            <a style="margin-bottom: 10px;margin-left: 1%;" href="/companies-user/salary/<?= $authuser->usercompany->id ?>" class="btn add-btn"> Salary</a>
                        </div>
                        <div>
                            <a href="/companies-user/employees/<?= $authuser->usercompany->id ?>" class="btn add-btn"> Employees</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                        <div class="dash-widget-info">
                            <?php $totalprojects = count($projectObjects) ?>
                            <h3><?= $totalprojects ?></h3>
                            <span>Projects</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                        <div class="dash-widget-info">
                            <?php
                            $totalclients = 0;
                            if (!empty($clients)) {
                                foreach ($clients as $client) {
                                    if ($client->designation->name == 'Customer') {
                                        $totalclients = $totalclients + 1;
                                    }
                                }
                            }
                            ?>
                            <h3><?= $totalclients ?></h3>
                            <span>Clients</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                        <div class="dash-widget-info">
                            <?php if (!empty($projecttasks)) : ?>
                                <?php $totaltasks = count($projecttasks) ?>
                            <?php else : ?>
                                <?php $totaltasks = 0 ?>
                            <?php endif; ?>

                            <h3><?= $totaltasks ?></h3>
                            <span>Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                        <div class="dash-widget-info">
                            <?php if (!empty($totalemployees)) : ?>
                                <?php $totalEmps = count($totalemployees) ?>
                            <?php else : ?>
                                <?php $totalEmps = 0 ?>
                            <?php endif; ?>
                            <h3><?= $totalEmps ?></h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Total Revenue</h3>
                                <div id="bar-charts"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Sales Overview</h3>
                                <div id="line-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">New Employees</span>
                                </div>
                                <div>
                                    <span class="text-success">+10%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">10</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Overall Employees 218</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Earnings</span>
                                </div>
                                <div>
                                    <span class="text-success">+12.5%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,42,300</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Expenses</span>
                                </div>
                                <div>
                                    <span class="text-danger">-2.8%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Profit</span>
                                </div>
                                <div>
                                    <span class="text-danger">-75%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress mb-2" style="height: 5px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Widget -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
                <div class="card flex-fill dash-statistics">
                    <div class="card-body">
                        <h5 class="card-title">Statistics</h5>
                        <div class="stats-list">
                            <div class="stats-info">
                                <?php
                                if (!empty($totaltodayleaves)) {
                                    $totaltodayleaves = count($todayleaves);
                                } else {
                                    $totaltodayleaves = 0;
                                }

                                ?>
                                <p>Today Leave <strong><?= $totaltodayleaves ?> <small>/ <?= $totalEmps ?></small></strong></p>
                                <?php
                                if ($totalEmps != 0) {
                                    $leaveprogress = $totaltodayleaves / ($totalEmps) * 100;
                                } else {
                                    $leaveprogress = 0;
                                }
                                ?>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $leaveprogress ?>%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <!-- <div class="stats-info">
                                <p>Pending Invoice <strong>15 <small>/ 92</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 31%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div> -->
                            <div class="stats-info">
                                <p>Completed Projects <strong>0 <small>/ <?= $totalprojects ?></small></strong></p>


                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <?php if ($opentickets != null) : ?>
                                <?php $totalopentickets = count($opentickets) ?>
                                <?php if ($totalopentickets != 0) : ?>
                                    <?php $ticketprogress = $totalopentickets / ($totalopentickets) * 100; ?>
                                    <div class="stats-info">
                                        <p>Open Tickets <strong><?= $totalopentickets ?> <small>/ <?= $totalopentickets ?></small></strong></p>

                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $ticketprogress ?>%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="stats-info">
                                        <p>Open Tickets <strong><?= $totalopentickets ?> <small>/ <?= $totalopentickets ?></small></strong></p>

                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endif; ?>
                            <!--  <div class="stats-info">
                                <p>Closed Tickets <strong>22 <small>/ 212</small></strong></p>
                                <div class="progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <h4 class="card-title">Task Statistics</h4>
                        <div class="statistics">
                            <div class="row">
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Total Tasks</p>
                                        <?php if ($projecttasks != null) : ?>
                                            <?php $totaltasks = count($projecttasks); ?>
                                        <?php else : ?>
                                            <?php $totaltasks = 0; ?>
                                        <?php endif; ?>
                                        <h3><?= $totaltasks ?></h3>

                                    </div>
                                </div>
                                <div class="col-md-6 col-6 text-center">
                                    <div class="stats-box mb-4">
                                        <p>Overdue Tasks</p>
                                        <h3>0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-purple" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30%</div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 22%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">22%</div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100">24%</div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 26%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">21%</div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">10%</div>
                        </div>
                        <div>
                            <?php if ($completedtasks != null || $inProgresstasks != null || $todotasks != null) : ?>
                                <?php $totalcompletedtasks = count($completedtasks);
                                $totalinprogresstasks = count($inProgresstasks);
                                $todotasks = count($todotasks) ?>
                                <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed Tasks <span class="float-right"><?= $totalcompletedtasks ?></span></p>
                                <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress Tasks <span class="float-right"><?= $totalinprogresstasks ?></span></p>
                                <p><i class="fa fa-dot-circle-o text-success mr-2"></i>To Do Tasks <span class="float-right"><?= $todotasks ?></span></p>
                                <!--   <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Pending Tasks <span class="float-right">47</span></p>
                            <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Review Tasks <span class="float-right">5</span></p> -->
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <?php $totalabsent = count($todayleaves); ?>
                        <h4 class="card-title">Today Absent <span class="badge bg-inverse-danger ml-2"><?= $totalabsent ?></span></h4>
                        <?php foreach ($todaypendingleaves as $pending) : ?>
                            <?php foreach ($allusers as $singleuser) : ?>
                                <?php if ($singleuser->id == $pending->user_id) : ?>
                                    <div class="leave-info-box">
                                        <div class="media align-items-center">
                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $singleuser->profileFilepath ?>/<?= $singleuser->profileFilename ?>"></a>
                                            <div class="media-body">
                                                <div class="text-sm my-0"><?= $singleuser->firstname ?><?= $singleuser->lastname ?></div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mt-3">
                                            <div class="col-6">
                                                <h6 class="mb-0"><?= $pending->fromdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>- <?= $pending->todate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></h6>
                                                <span class="text-sm text-muted">Leave Date</span>
                                            </div>
                                            <div class="col-6 text-right">
                                                <span class="badge bg-inverse-danger">Pending</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <?php foreach ($todayleaves as $todayleave) : ?>
                            <?php foreach ($allusers as $singleuser) : ?>
                                <?php if ($singleuser->id == $todayleave->user_id) : ?>
                                    <div class="leave-info-box">
                                        <div class="media align-items-center">
                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $singleuser->profileFilepath ?>/<?= $singleuser->profileFilename ?>"></a>
                                            <div class="media-body">
                                                <div class="text-sm my-0"><?= $singleuser->firstname ?><?= $singleuser->lastname ?></div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mt-3">
                                            <div class="col-6">
                                                <h6 class="mb-0"><?= $todayleave->fromdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>-<?= $todayleave->todate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></h6>
                                                <span class="text-sm text-muted">Leave Date</span>
                                            </div>
                                            <div class="col-6 text-right">
                                                <span class="badge bg-inverse-success">Approved</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <div class="load-more text-center">
                            <a class="text-dark" href="/leaves/adminleaves">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Statistics Widget -->

        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Invoices</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($authuser->invoices as $invoice) : ?>
                                        <?php $invoiceitemsprice = 0; ?>
                                        <?php foreach ($invoice->invoiceitems as $item) : ?>
                                            <?php $invoiceitemsprice = $invoiceitemsprice + ($item->quantity * $item->price) ?>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td><a href="/invoices/view?invoiceId=<?= $invoice->id ?>">#<?= $invoice->id ?></a></td>
                                            <td>
                                                <h2><a href="#"><?= $invoice->client->firstname ?> <?= $invoice->client->lastname ?></a></h2>
                                            </td>
                                            <td><?= $invoice->due_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></td>
                                            <td>
                                                <?php if (!empty($invoice->projectobject) && !empty($invoice->projectobject->taskgroups && empty($invoice->invoiceitems))) : ?>
                                                    <?= Number::currency(($invoice->projectobject->price), 'EUR', ['locale' => 'it_IT']); ?>
                                                <?php elseif (!empty($invoice->invoiceitems) && empty($invoice->projectobject) && empty($invoice->projectobject->taskgroups)) : ?>
                                                    <?= Number::currency(($invoiceitemsprice), 'EUR', ['locale' => 'it_IT']); ?>
                                                <?php elseif (!empty($invoice->invoiceitems) && !empty($invoice->projectobject) && !empty($invoice->projectobject->taskgroups)) : ?>
                                                    <?= Number::currency(($invoiceitemsprice +  $invoiceitemsprice), 'EUR', ['locale' => 'it_IT']); ?>

                                                <?php endif; ?>
                                            </td>
                                            </td>
                                            <td>
                                                <?php if ($invoice->status == 'UnPaid') : ?> <span class="badge bg-inverse-danger"><?= $invoice->status ?></span>
                                                <?php elseif ($invoice->status == 'Paid') : ?><span class="badge bg-inverse-success"><?= $invoice->status ?></span>
                                                <?php else : ?><span class="badge bg-inverse-info"><?= $invoice->status ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/invoices/invoices/<?= $authuser->usercompany->id ?>">View all invoices</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Payments</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Payment Type</th>
                                        <th>Paid Date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0001</a></td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0002</a></td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0003</a></td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>Paypal</td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="payments.html">View all payments</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Clients</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($clients)) : ?>
                                        <?php foreach ($clients as $client) : ?>
                                            <?php if ($client->designation->name == 'Customer') : ?>
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="/user/view/<?= $client->user->id ?>" class="avatar">
                                                                <?php if ($client->user->profileFilepath != null && $client->user->profileFilename != null) : ?>
                                                                    <img alt="" src="<?= $client->user->profileFilepath ?>/<?= $client->user->profileFilename ?>">
                                                                <?php else : ?>
                                                                    <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                <?php endif; ?>
                                                            </a>
                                                            <a href="/user/view/<?= $client->user->id ?>"><?= $client->user->firstname ?> <?= $client->user->lastname ?><span>Client</span></a>
                                                        </h2>
                                                    </td>
                                                    <td><?= $client->user->email ?></td>
                                                    <td>
                                                        <div class="dropdown action-label">
                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Active
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="dropdown dropdown-action">
                                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">

                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_client_<?= $client->user->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_client_<?= $client->user->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view_client_<?= $client->user->id ?>"><i class="fa fa-eye m-r-5"></i> view</a>
                                                            </div>
                                                        </div>

                                                        <!-- View Client Modal -->
                                                        <div id="view_client_<?= $client->user->id ?>" class="modal custom-modal fade" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">View User Details<?= $client->user->id ?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped custom-table datatable">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>ProjectID</th>
                                                                                                <th>ProjectName</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                <?php if ($projectMember->memberId == $client->user->id) : ?>
                                                                                                    <?php foreach ($projectObjects as $projectObject) : ?>
                                                                                                        <?php if ($projectMember->projectId == $projectObject->id) : ?>
                                                                                                            <tr>
                                                                                                                <td>#<?= $projectObject->id ?></td>
                                                                                                                <td><?= $projectObject->name ?></td>

                                                                                                                <td><span class="badge bg-inverse-success"><a class="btn btn-info" href="/project-object/taskboard/<?= $projectObject->id ?>">View</a></span></td>

                                                                                                            </tr>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                <?php endif; ?>
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
                                                        <!-- /View User Modal -->
                                                    </td>
                                                </tr>
                                                <!-- Edit Client Modal -->
                                                <div id="edit_client_<?= $client->user->id ?>" class="modal custom-modal fade" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Client Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/project-member/updateclientinfo" method="post">

                                                                    <div class="form-group">
                                                                        <label>First Name <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="firstname" value="<?= $client->user->firstname ?>" type="text">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Last Name</label>
                                                                        <input class="form-control" name="lastname" value="<?= $client->user->lastname ?>" type="text">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>
                                                                            Address
                                                                        </label>
                                                                        <input class="form-control" name="address" value="<?= $client->user->address ?>" type="text">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>
                                                                            gender
                                                                        </label>
                                                                        <select class="select" name="gender">
                                                                            <?php if ($client->user->gender == 'Male') : ?>
                                                                                <option value="Male" selected>Male</option>
                                                                                <option value="Female">Female</option>
                                                                                <option value="Other">Other</option>
                                                                            <?php elseif ($client->user->gender == 'Female') : ?>

                                                                                <option value="Male">Male</option>
                                                                                <option value="Female" selected>Female</option>
                                                                                <option value="Other">Other</option>
                                                                            <?php else : ?>
                                                                                <option value="Male">Male</option>
                                                                                <option value="Female">Female</option>
                                                                                <option value="Other" selected>Other</option>
                                                                            <?php endif; ?>

                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Email <span class="text-danger">*</span></label>
                                                                        <input class="form-control" name="email" value="<?= $client->user->email ?>" type="email">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Password</label>
                                                                        <input class="form-control" name="password" type="password" value="<?= $client->user->password ?>">
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label> Password Expirationdate</label>
                                                                        <input class="form-control datetimepicker" name="passwordExpitydate" type="text" value="<?= $client->user->passwordExpirationDate ?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Phone </label>
                                                                        <input class="form-control" name="tel" value="<?= $client->user->tel ?>" type="text">
                                                                    </div>

                                                            </div>

                                                            <div class="submit-section">
                                                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                                <input type="hidden" name="userid" value="<?= $client->user->id ?>">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Edit Client Modal -->

                                                <!-- Delete Client Modal -->
                                                <div class="modal custom-modal fade" id="delete_client_<?= $client->user->id ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Delete Client</h3>
                                                                    <p>Are you sure want to delete?</p>
                                                                </div>
                                                                <div class="modal-btn delete-action">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <a href="/project-member/deleteclient/<?= $client->user->id ?>" class="btn btn-primary continue-btn">Delete</a>
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
                                                <!-- /Delete client Modal -->
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/companies-user/clients/<?= $authuser->usercompany->id ?>">View all clients</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Recent Projects</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Project Name </th>
                                        <th>Progress</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/project-object/projectlists/<?= $authuser->usercompany->id ?>">View all projects</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
<!-- Chart JS -->
<script src="/assets/plugins/morris/morris.min.js"></script>
<script src="/assets/plugins/raphael/raphael.min.js"></script>
<script src="/assets/js/chart.js"></script>

<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };
    $('.select2-icon').select2({
        width: "50%",
        templateSelection: formatText,
        templateResult: formatText
    });



    function deletefile(fid, pid) {
        console.log(fid, pid);
        $.ajax({
            url: '/project-object/deletefile',
            method: 'post',
            dataType: 'json',
            data: {
                'fid': fid,
                'pid': pid
            },
            success: function(data) {
                console.log(data, 'filedeleted');
                $('#fileinfo_' + pid).empty();
                console.log(data, 'filedeleted');
                var filedata = "";
                data.forEach((file) => {

                    filedata += '<div class="uploaded-img">' +
                        '<span class="remove-icon">' +
                        '<a onclick="deletefile(' + file.id + ',' + file.project_id + '" class="del-msg"><i class="fa fa-close"></i></a>' +
                        '</span>' +
                        '</a>' +
                        '</div>' +
                        '<div class="uploaded-img-name">' + file.filename + '</div>';
                });

                $('#fileinfo_' + pid).html(filedata);
            },
            error: function() {}
        })
    }
</script>
