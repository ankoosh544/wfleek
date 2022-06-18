<style>
    body {
        background-color: whitesmoke;
    }


    #invoice {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #invoice td,
    #invoice th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #invoice tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #invoice tr:hover {
        background-color: #ddd;
    }

    #invoice th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>


</style>
</head>

<body>
    <?php

    use Cake\I18n\Number;
    ?>
    <table id="projectDetails">
        <thead>
            <tr style="text-align: center;">
                <th colspan="4"><img style="width: 35%;" src="https://www.epebook.it/images/epebook-logo.png" /></th>
                <th colspan="6">
                    <h1><?= $invoice->client->firstname ?> <?= $invoice->client->lastname ?></h1>
                </th>
            </tr>
        </thead>
    </table><br>

<div class="row invoice">
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
                                <h5>Total Due: <span class="text-right"><?= Number::currency(($invoice->projectobject->price), 'EUR', ['locale' => 'it_IT']); ?></span></h5>
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
                            <?php $totalprice = 0;
                            $totaltax = 0; ?>
                            <?php foreach ($invoice->projectobject->taskgroups as $taskgroup) : ?>
                                <?php $totalprice = $totalprice + $taskgroup->price;
                                $totaltax = $totaltax + $taskgroup->tax_percentage; ?>
                                <tr>
                                    <td>1</td>
                                    <td><?= $taskgroup->title ?></td>
                                    <td class="d-none d-sm-table-cell"><?= $taskgroup->description ?></td>
                                    <td><?= Number::currency(($taskgroup->price), 'EUR', ['locale' => 'it_IT']); ?></td>
                                    <td>1</td>
                                    <td class="text-right"><?= Number::currency(($taskgroup->price), 'EUR', ['locale' => 'it_IT']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php $finaltoaltax = ($totaltax / 100) * $totalprice;
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
</body>
