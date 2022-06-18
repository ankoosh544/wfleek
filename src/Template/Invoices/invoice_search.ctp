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
                    <h3 class="page-title">Invoices Search</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="row">
            <div class="col-12">
                <div class="search-result">
                    <h3>Search Result Found For: <u>
                            <?php if (!empty($fromdate) && !empty($todate) && !empty($status)) : ?>
                                <?= $fromdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>, <?= $todate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>, <?= $status ?>.
                            <?php elseif (empty($fromdate) && empty($todate) && !empty($status)) : ?>
                                <?= $status ?>.
                            <?php endif; ?>
                        </u></h3>
                    <p>
                        <?php if ($companyinvoices != null) : ?>
                            <?= count($companyinvoices) ?>
                        <?php else : ?>
                            No
                        <?php endif; ?>
                        Results found</p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Number</th>
                                        <th>Client</th>
                                        <th>Project Name</th>
                                        <th>Groups</th>
                                        <th>Created Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($companyinvoices != null) : ?>
                                        <?php foreach ($companyinvoices as $index => $invoice) : ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><a href="/invoices/view?invoiceId=<?= $invoice->id ?>">#<?= $invoice->id ?></a></td>
                                                <td>
                                                    <a href="/user/view/<?= $invoice->client->id ?>">
                                                        <?= $invoice->client->firstname ?> <?= $invoice->client->lastname ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if (!empty($invoice->projectobject)) : ?>
                                                        <a href="/projectObject/view/<?= $invoice->projectobject->id ?>"> <?= $invoice->projectobject->name ?></a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php $invoiceitemsprice = 0; ?>
                                                    <?php foreach ($invoice->invoiceitems as $item) : ?>
                                                        <?php $invoiceitemsprice = $invoiceitemsprice + ($item->quantity * $item->price) ?>
                                                        <?php if (!empty($item->taskgroup)) : ?>
                                                            <p><a href="/projecttasks/grouptasks?group_id=<?= $item->taskgroup->id ?>&pid=<?= $item->taskgroup->projectId ?>"><?= $item->name ?></a></p>
                                                        <?php else : ?>
                                                            <p><a href="/invoices/invoice-itemview?id=<?= $item->id ?>"><?= $item->name ?></a></p>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td>
                                                    <?php if ($invoice->invoice_date != null) : ?>
                                                        <?= $invoice->invoice_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($invoice->due_date) : ?>
                                                        <?= $invoice->due_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($invoice->projectobject) && !empty($invoice->projectobject->taskgroups && empty($invoice->invoiceitems))) : ?>
                                                        <?= Number::currency(($invoice->projectobject->price), 'EUR', ['locale' => 'it_IT']); ?>
                                                    <?php elseif (!empty($invoice->invoiceitems) && empty($invoice->projectobject->taskgroups)) : ?>
                                                        <?= Number::currency(($invoiceitemsprice), 'EUR', ['locale' => 'it_IT']); ?>
                                                    <?php elseif (!empty($invoice->invoiceitems) &&  !empty($invoice->projectobject->taskgroups)) : ?>
                                                        <?= Number::currency(($invoiceitemsprice +  $invoiceitemsprice), 'EUR', ['locale' => 'it_IT']); ?>

                                                    <?php endif; ?>
                                                </td>
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
                                                            <a class="dropdown-item" href="/invoices/createpdfdownload?invoiceId=<?= $invoice->id ?>"><i class="fa fa-file-pdf-o m-r-5"></i> Download</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_invoice_<?= $invoice->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#history_invoice_<?= $invoice->id ?>"><i class="fa fa-history m-r-5"></i> History</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Invoice Modal -->
                                            <?= $this->element('delete_invoice', [
                                                'invoiceId' => $invoice->id
                                            ]) ?>
                                            <!-- / Delete Invoice Modal -->

                                            <!------History of Invoice modal-->
                                            <div class="modal custom-modal fade" id="history_invoice_<?= $invoice->id ?>" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-header">
                                                                <h3>Histoey of Invoice</h3>
                                                                <p>Are you sure want to delete?</p>
                                                            </div>
                                                            <div class="modal-btn delete-action">
                                                                <div class="row">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /History of Invoice moda ---->
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
