<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Invoice</li>
                        <div class="col-auto float-right ml-auto">
                            <div>Status :</div>
                            <select class="select2-icon floating" onchange="updatestatus(<?= $invoice->id ?>)" id="invoice_status_<?= $invoice->id ?>">
                                <?php if ($invoice->status == 'Invia') : ?>
                                    <option value="UnPaid" data-icon="fa fa-dot-circle-o text-danger">UnPaid</option>
                                    <option selected value="Invia" data-icon="fa fa-dot-circle-o text-warning">Invia</option>
                                    <option value="Paid" data-icon="fa fa-dot-circle-o text-success">Paid</option>
                                <?php elseif ($invoice->status == 'Paid') : ?>
                                    <option value="UnPaid" data-icon="fa fa-dot-circle-o text-danger">UnPaid</option>
                                    <option value="Invia" data-icon="fa fa-dot-circle-o text-warning">Invia</option>
                                    <option selected value="Paid" data-icon="fa fa-dot-circle-o text-success">Paid</option>
                                <?php else : ?>
                                    <option selected value="UnPaid" data-icon="fa fa-dot-circle-o text-danger">UnPaid</option>
                                    <option value="Invia" data-icon="fa fa-dot-circle-o text-warning">Invia</option>
                                    <option value="Paid" data-icon="fa fa-dot-circle-o text-success">Paid</option>
                                <?php endif; ?>

                            </select>

                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <form action="/invoices/updateinvoice?invoiceId=<?= $invoice->id ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label>
                                <select class="select" id="clientid" name="clientid" onchange="filterprojectsofclient(<?= $companyId ?>)">
                                    <option value="">--Select Client--</option>
                                    <?php foreach ($companymembers as $companymember) : ?>
                                        <?php if ($companymember->designation->name == 'Customer') : ?>
                                            <?php if ($invoice->clienId == $companymember->id) : ?>
                                                <option selected value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->lastname ?></option>
                                            <?php else : ?>
                                                <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->lastname ?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Project <span class="text-danger">*</span></label>
                                <select class="select" id="client_projects" name="client_project" onchange="filterprojectgroup()">

                                    <?php foreach ($clientprojects as $clientproject) : ?>
                                        <?php if ($clientproject->projectId == $invoice->projectobject->id) : ?>
                                            <option selected value="<?= $invoice->projectobject->id ?>"><?= $invoice->projectobject->name ?></option>
                                        <?php else : ?>
                                            <option value="<?= $clientproject->projectobject->id ?>"><?= $clientproject->projectobject->name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="client_email" id="client_email" value="<?= $invoice->client->email ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Tax</label>
                                <select class="select" name="taxtype">
                                    <option>Select Tax</option>
                                    <option>VAT</option>
                                    <option>GST</option>
                                    <option>No Tax</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Client Address</label>
                                <textarea class="form-control" rows="3" id="client_address" name="client_address"><?= $invoice->client->address ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Billing Address</label>
                                <textarea class="form-control" rows="3" name="billing_address"> <?= $invoice->billing_address ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Invoice date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <?php if (!empty($invoice->invoice_date)) : ?>
                                        <input class="form-control datetimepicker" type="text" name="invoice_date" value="<?= $invoice->invoice_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>">
                                    <?php else : ?>
                                        <input class="form-control datetimepicker" type="text" name="invoice_date">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Due Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <?php if (!empty($invoice->due_date)) : ?>
                                        <input class="form-control datetimepicker" type="text" name="due_date" value="<?= $invoice->due_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>">
                                    <?php else : ?>
                                        <input class="form-control datetimepicker" type="text" name="due_date">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-white">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px">#ItemCode</th>
                                            <th class="col-sm-2">Name</th>
                                            <th class="col-md-6">Description</th>
                                            <th style="width:100px;">Unit Cost</th>
                                            <th style="width:80px;">Qty</th>
                                            <th>Amount</th>
                                            <th><a href="javascript:void(0)" class="text-success font-18" title="Add" onclick="addelement()"><i class="fa fa-plus"></i></a> </th>
                                        </tr>
                                    </thead>
                                    <tbody id="projectgroups">
                                        <?php $totalprice = 0;
                                        $totaltax = 0;
                                        $i = 1; ?>
                                        <?php foreach ($invoice->invoiceitems as $invoiceitem) : ?>
                                            <?php $totalprice = $totalprice + ($invoiceitem->quantity * $invoiceitem->price) ?>
                                            <input type="hidden" value="<?=$invoiceitem->id?>" name="invoicesitemids[]">
                                            <tr>
                                                <td><input class="form-control" type="text" value="<?= $invoiceitem->itemId ?>" name="items[]"></td>
                                                <td>
                                                    <input class="form-control" type="text" style="min-width:150px" id="groupname_<?=$invoiceitem->id?>" value="<?= $invoiceitem->name ?>" name="itemnames[]">
                                                </td>

                                                <td>
                                                    <?php if (!empty($invoiceitem->taskgroup)) : ?>
                                                        <table class="table table-hover table-white" style="width: 100%;">
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Description</th>
                                                            </tr>

                                                            <?php foreach ($invoiceitem->taskgroup->projecttasks as $projecttask) : ?>
                                                                <tr>
                                                                    <td><?= $projecttask->title ?></td>
                                                                    <td>
                                                                        <textarea class="form-control" type="text" style="min-width:100px" id="groupdescription_<?=$invoiceitem->id?>"  name="itemdescription[]"><?= $projecttask->description ?> </textarea>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </table>
                                                    <?php else : ?>
                                                        <textarea class="form-control" type="text" style="min-width:100px" id="groupdescription_<?=$invoiceitem->id?>" name="itemdescription[]"><?= $invoiceitem->description ?> </textarea>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <input class="form-control" style="width:100px" type="text" value="<?= $invoiceitem->price ?>" id="price_<?=$invoiceitem->id?>" name="price[]">
                                                </td>
                                                <td>
                                                    <input class="form-control" style="width:80px" type="text" value="<?= $invoiceitem->quantity ?>" id="qty_<?=$invoiceitem->id?>" onkeyup="counttotalamount(<?= $invoiceitem->id ?>)" name="qty[]">
                                                </td>
                                                <td>
                                                    <input class="form-control" readonly style="width:120px" type="text" id="amount_<?= $invoiceitem->id ?>" value="<?=($invoiceitem->quantity* $invoiceitem->price)?>">
                                                </td>
                                                <td><a href="/invoiceitems/delete?id=<?= $invoiceitem->id ?>&&invoiceId=<?= $invoiceitem->invoiceId ?>" class="text-danger font-18" title="Remove" onclick="deleteelement()"><i class="fa fa-trash-o"></i></a></td>
                                            </tr>

                                        <?php endforeach; ?>

                                        <input type="hidden" id="totalrows" value="">

                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-white">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">Total</td>
                                            <td style="text-align: right; padding-right: 30px;width: 230px">

                                                <input class="form-control text-right" readonly type="text" id="total_amount" value="<?= $totalprice ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Tax</td>
                                            <td style="text-align: right; padding-right: 30px;width: 230px">
                                                <input class="form-control text-right" readonly type="text" id="total_tax" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                Discount %
                                            </td>
                                            <td style="text-align: right; padding-right: 30px;width: 230px">
                                                <input class="form-control text-right" id="discountamount" name="discountamount" type="text" onkeyup="discountcalculate()" value="<?= $invoice->discount_percentage ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right; font-weight: bold">
                                                Grand Total
                                            </td>
                                            <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px;width: 230px" id="grand_total">
                                                $ <?= $totalprice ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Other Information</label>
                                        <textarea class="form-control summernote" name="description"><?= $invoice->description ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn m-r-10">Update & Send</button>
                        <button class="btn btn-primary submit-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<script>
    function filterprojectsofclient(companyId) {
        var clientId = $('#clientid').val();
        console.log(clientId);

        $.ajax({
            url: '/invoices/filterprojectsofclient',
            method: 'post',
            dataType: 'json',
            data: {
                'clientId': clientId,
                'companyId': companyId
            },
            success: function(data) {
                console.log(data);

                var htmlCode = "";
                var address = "";
                var email = "";
                htmlCode += '<option>--Select Project--</option>';
                for (var i = 0; i < data.length; i++) {
                    htmlCode += "<option value='" + data[i].ProjectObject.id + "'>" + data[i].ProjectObject.name + "</option>";



                }

                address += data[0].user.address;
                email += data[0].user.email;

                $("#client_projects").html(htmlCode);
                $('#client_email').val(email);
                $('#client_address').html(address);

            },
            error: function() {}
        });
    }

    function filterprojectgroup() {

        $.ajax({
            url: '/projecttasks/filterprojects',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': $('#client_projects').val(),
            },
            success: function(data) {

                var htmlCode = "";
                var totalamount = 0;
                var tax = 0;
                for (var i = 0; i < data.length; i++) {

                    htmlCode += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' +
                        '<input class="form-control" type="text" value="' + data[i].title + '" style="min-width:150px">' +
                        '</td>' +
                        '<td>' +
                        '<textarea class="form-control summernote" type="text">' + data[i].description + '</textarea> ' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" style="width:100px" type="text">' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" style="width:80px" type="text" value="' + data[i].projecttasks.length + '">' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" readonly style="width:120px" type="text" value="' + data[i].price + '">' +
                        '</td>' +
                        '<td><a href="javascript:void(0)" class="text-success font-18" title="Add" onclick="addelement()"><i class="fa fa-plus"></i></a></td>' +
                        '</tr>';
                    totalamount = totalamount + data[i].price;
                    tax = tax + data[i].tax_percentage;

                }
                finaltoaltax = (tax / 100) * totalamount;
                $('#total_amount').val(totalamount);
                $('#total_tax').val(finaltoaltax);
                $("#projectgroups").html(htmlCode);
            },
            error: function() {}
        });
    }
    var rownumber = $('#totalrows').val();
    var totalamount = Number($('#total_amount').val());

    function addelement() {
        var str = "";
        rownumber = Number(rownumber) + 1;
        var str = "";
        str = '<tr id="element_' + rownumber + '">' +
            '<td>' +
            '<input class="form-control" type="text" style="min-width:150px" id="groupname_' + rownumber + '" name="items[]">' +
            '</td>' +
            '<td>' +
            '<input class="form-control" type="text" style="min-width:150px" id="groupname_' + rownumber + '" name="itemnames[]">' +
            '</td>' +
            '<td>' +
            '<input class="form-control" type="text" style="min-width:150px" id="groupdescription_' + rownumber + '" name="itemdescription[]">' +
            '</td>' +
            '<td>' +
            '<input class="form-control" style="width:100px" type="text" id="price_' + rownumber + '" name="price[]">' +
            '</td>' +
            '<td>' +
            '<input class="form-control" style="width:80px" type="text" id="qty_' + rownumber + '" onkeyup="counttotalamount(' + rownumber + ')" name="qty[]">' +
            '</td>' +
            '<td>' +
            '<input class="form-control" readonly style="width:120px" type="text" id="amount_' + rownumber + '">' +
            '</td>' +
            '<td><a href="javascript:void(0)" class="text-danger font-18" title="Remove" onclick="deleteelement(' + rownumber + ')"><i class="fa fa-trash-o"></i></a></td>' +
            '</tr>';
        $('#projectgroups').append(str);
    }

    function deleteelement(id) {
        $('#element_' + id).empty();
    }

    function counttotalamount(id) {
        var amount = $('#price_' + id).val();
        var qty = $('#qty_' + id).val();
        var finalamt = amount * qty;
        $('#amount_' + id).val(finalamt);
        totalamount += finalamt;

        $('#total_amount').val(totalamount);
    }


    function calculatequantity() {
        var price = $('#invoice_price').val();
        var qty = $('#invoice_quantity').val();
        console.log(price);
        console.log(qty);
        $('#invoice_amount').val(price * qty);

    }

    function discountcalculate() {
        var totalamount = $('#total_amount').val();
        var totaltax = $('#total_tax').val();
        var discountpercentage = $('#discountamount').val();
        discount = (discountpercentage / 100) * (totalamount);
        finaltotal = (totalamount - discount);
        $('#grand_total').html(finaltotal + totaltax);

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


    function updatestatus(invoiceId) {
        var status = $('#invoice_status_' + invoiceId).val();

        $.ajax({
            url: '/invoices/updatestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'status': status,
                'invoiceId': invoiceId
            },
            success: function(data) {
                location.reload();
            },
            error: function() {}
        });

    }
</script>
