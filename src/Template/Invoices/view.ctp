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
                    <h3 class="page-title">Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="btn-group btn-group-sm">
                        <a data-toggle="modal" data-target="#invoice-typealert_<?= $invoice->id ?>" class="btn btn-white">CSV</a>
                        <a href="/invoices/createpdfdownload?invoiceId=<?= $invoice->id ?>" class="btn btn-white">PDF</a>
                        <button class="btn btn-white"><i class="fa fa-print fa-lg"></i> Print</button>
                    </div>
                </div>
                <!-- Delete Trainers List Modal -->
                <div class="modal custom-modal fade" id="invoice-typealert_<?= $invoice->id ?>" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">

                                <div class="modal-btn delete-action">
                                    <div class="row">
                                        <div class="form-header">
                                            <h3>Download Header</h3>
                                        </div>
                                        <div class="col-12">
                                            <a href="/invoices/createcsvdownload?invoiceId=<?= $invoice->id ?>&&part=<?= 'header' ?>" class="btn btn-primary continue-btn">Download</a>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="row">
                                        <div class="form-header">
                                            <h3>Download Items </h3>
                                        </div>
                                        <div class="col-12">
                                            <a href="/invoices/createcsvdownload?invoiceId=<?= $invoice->id ?>&&part=<?= 'items' ?>" class="btn btn-primary continue-btn">Download</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Delete Trainers List Modal -->
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 m-b-20">
                                <img src="assets/img/logo2.png" class="inv-logo" alt="">
                                <ul class="list-unstyled">
                                    <li><?= $invoice->usercompany->name ?></li>
                                    <li><?= $invoice->usercompany->address ?>,</li>
                                    <li><?= $invoice->usercompany->city ?>, <?= $invoice->usercompany->state ?>, <?= $invoice->usercompany->postal_code ?></li>
                                    <li>GST No:</li>
                                </ul>
                            </div>
                            <div class="col-sm-6 m-b-20">
                                <div class="invoice-details">
                                    <h3 class="text-uppercase">Invoice #<?= $invoice->id ?></h3>
                                    <ul class="list-unstyled">
                                        <li>Date: <span> <?php if ($invoice->invoice_date != null) : ?>
                                                    <?= $invoice->invoice_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                                <?php endif; ?></span></li>
                                        <li>Due date: <span> <?php if ($invoice->due_date) : ?>
                                                    <?= $invoice->due_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                                <?php endif; ?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                                <h5>Invoice to:</h5>
                                <ul class="list-unstyled">
                                    <li>
                                        <h5><strong><?= $invoice->client->firstname ?> <?= $invoice->client->lastname ?></strong></h5>
                                    </li>
                                    <li><?= $invoice->client->address ?></li>
                                    <li><?= $invoice->client->city ?>, <?= $invoice->client->state ?>, <?= $invoice->cap ?></li>
                                    <li><?= $invoice->client->country ?></li>
                                    <li><?= $invoice->client->tel ?></li>
                                    <li><a href="#"><?= $invoice->client->email ?></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                                <span class="text-muted">Payment Details:</span>
                                <ul class="list-unstyled invoice-payment-details">
                                    <li>
                                        <h5>Total Due: <span class="text-right"></span></h5>
                                    </li>
                                    <li>Bank name: <span>Profit Bank Europe</span></li>
                                    <li>Country: <span>United Kingdom</span></li>
                                    <li>City: <span>London E1 8BF</span></li>
                                    <li>Address: <span>3 Goodman Street</span></li>
                                    <li>IBAN: <span>KFH37784028476740</span></li>
                                    <li>SWIFT code: <span>BPT4E</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ITEM</th>
                                        <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                        <th>UNIT COST</th>
                                        <th>QUANTITY</th>
                                        <th class="text-right">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $invoiceitemsprice = 0;
                                    $invoicegrouptaskprice = 0;
                                    $totaltax =0;


                                    ?>

                                    <?php foreach ($invoice->invoiceitems as $index =>$item) : ?>

                                         <?php if (!empty($item->taskgroup)) : ?>
                                            <?php $invoicegrouptaskprice = $invoicegrouptaskprice + ($item->taskgroup->price);
                                        ?>
                                        <tr>
                                            <td><?= $index + 1 ?> </td>
                                            <td><?= $taskgroup->title ?></td>
                                            <td class="d-none d-sm-table-cell"><?= $taskgroup->description ?></td>
                                            <td><?= Number::currency(($taskgroup->price), 'EUR', ['locale' => 'it_IT']); ?></td>
                                            <td>1</td>
                                            <td class="text-right"><?= Number::currency(($taskgroup->price), 'EUR', ['locale' => 'it_IT']); ?></td>
                                        </tr>
                                        <?php else: ?>
                                            <?php $invoiceitemsprice = $invoiceitemsprice + ($item->quantity * $item->price);
                                        ?>
                                            <tr>
                                            <td> <?= $index + 1 ?> </td>
                                            <td><?= $item->name ?></td>
                                            <td class="d-none d-sm-table-cell"><?= $item->description ?></td>
                                            <td><?= Number::currency(($item->price), 'EUR', ['locale' => 'it_IT']); ?></td>
                                            <td><?=$item->quantity?></td>
                                            <td class="text-right"><?= Number::currency(($invoiceitemsprice), 'EUR', ['locale' => 'it_IT']); ?></td>
                                        </tr>
                                            <?php endif; ?>
                                    <?php endforeach; ?>

                                    <?php

                                    $totalprice = $invoicegrouptaskprice + $invoiceitemsprice;
                                    $finaltoaltax = ($totaltax / 100) * $totalprice;
                                    $discount = ($invoice->discount_percentage / 100) * ($totalprice);
                                    $grandtotal = ($totalprice - $discount) + $finaltoaltax;
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="row invoice-payment">
                                <div class="col-sm-7">
                                </div>
                                <div class="col-sm-5">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th>Subtotal:</th>
                                                        <td class="text-right"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax: <span class="text-regular">(<?= $totaltax ?>%)</span></th>
                                                        <td class="text-right"><?= Number::currency(($finaltoaltax), 'EUR', ['locale' => 'it_IT']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td class="text-right text-primary">
                                                            <h5><?= Number::currency(($totalprice + $finaltoaltax), 'EUR', ['locale' => 'it_IT']); ?></h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-info">
                                <h5>Other information</h5>
                                <p class="text-muted"><?= $invoice->description ?></p>
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
