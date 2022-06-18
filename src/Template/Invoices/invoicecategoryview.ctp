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
                <div class="col-sm-12">
                    <h3 class="page-title">Invoice Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Invoice Report</li>
                    </ul>
                </div>

            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="/invoices/invoice-search">
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="fromdate">
                        </div>
                        <label class="focus-label">From</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="todate">
                        </div>
                        <label class="focus-label">To</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="status">
                            <option value="">Select Status</option>
                            <option value="Invia">Invia</option>
                            <option value="Paid">Paid</option>
                            <option value="UnPaid">UnPaid</option>
                        </select>
                        <label class="focus-label">Status</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <input type="hidden" name="companyId" value="<?= $companyId ?>">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                </div>
            </div>
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice Number</th>
                                <th>Client</th>
                                <th>Created Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allcompanyinvoices as $index => $invoice) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><a href="invoice-view.html">#<?= $invoice->id ?></a></td>
                                    <td><?= $invoice->client->firstname ?> <?= $invoice->lastname ?></td>
                                    <td>
                                        <?php if (!empty($invoice->invoice_date)) : ?>
                                            <?= $invoice->invoice_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($invoice->due_date)) : ?>
                                            <?= $invoice->due_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= Number::currency(($invoice->projectobject->price), 'EUR', ['locale' => 'it_IT']); ?></td>

                                    <td>
                                        <?php if ($invoice->status == 'UnPaid') : ?> <span class="badge bg-inverse-danger"><?= $invoice->status ?></span>
                                        <?php elseif ($invoice->status == 'Paid') : ?><span class="badge bg-inverse-success"><?= $invoice->status ?></span>
                                        <?php else : ?><span class="badge bg-inverse-info"><?= $invoice->status ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="/invoices/edit-invoice?invoiceId=<?= $invoice->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="/invoices/view?invoiceId=<?= $invoice->id ?>"><i class="fa fa-eye m-r-5"></i> View</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-file-pdf-o m-r-5"></i> Download</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_invoice_<?= $invoice->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#history_invoice_<?= $invoice->id ?>"><i class="fa fa-history m-r-5"></i> History</a>
                                            </div>
                                        </div>
                                    </td>
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
