<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Create Invoice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Invoice</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_client"><i class="fa fa-plus"></i> Add Client</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <form action="/invoices/saveinvoice?companyId=<?= $companyId ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Client <span class="text-danger">*</span></label>
                                <select class="select" id="clientid" name="clientid" onchange="filterprojectsofclient(<?= $companyId ?>)">
                                    <option value="">--Select Client--</option>
                                    <?php foreach ($companymembers as $companymember) : ?>
                                        <?php if ($companymember->designation->name == 'Customer') : ?>
                                            <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->lastname ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Project <span class="text-danger">*</span></label>
                                <select class="select" id="client_projects" name="client_project" onchange="filterprojectgroup()">
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="text" name="client_email" id="client_email">
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
                                <textarea class="form-control" rows="3" id="client_address" name="client_address"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Billing Address</label>
                                <textarea class="form-control" rows="3" name="billing_address"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Invoice date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="invoice_date" id="invoice_date" required>
                                </div>
                                <div id="errormessage"></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Due Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" name="due_date" id="due_date" required>
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
                                            <th style="width: 20px">#Item</th>
                                            <th class="col-sm-2">name</th>
                                            <th class="col-md-6">Description</th>
                                            <th style="width:100px;">Unit Cost</th>
                                            <th style="width:80px;">Qty</th>
                                            <th>Amount</th>
                                            <th><a href="javascript:void(0)" class="text-success font-18" title="Add" onclick="addelement(<?= $companyId ?>)"><i class="fa fa-plus"></i></a> </th>
                                        </tr>
                                    </thead>
                                    <tbody id="projectgroups">


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
                                                <input class="form-control text-right" value="0" readonly type="text" id="total_amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Tax</td>
                                            <td style="text-align: right; padding-right: 30px;width: 230px">
                                                <input class="form-control text-right" value="0" readonly type="text" id="total_tax">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">
                                                Discount %
                                            </td>
                                            <td style="text-align: right; padding-right: 30px;width: 230px">
                                                <input class="form-control text-right" id="discountamount" name="discountamount" type="text" onkeyup="discountcalculate()">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="text-align: right; font-weight: bold">
                                                Grand Total
                                            </td>
                                            <td style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px;width: 230px" id="grand_total">
                                                $ 0.00
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Other Information</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn m-r-10">Save & Send</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!------Assign Client Modal---->
    <?= $this->element('addclient_tocompany', [
        'allclientData' => $companymembers,
        'invoice' =>  $companyId
    ]) ?>
    <!------/Assign Client Modal------>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<script>
    function filterprojectsofclient(companyId) {
        var clientId = $('#clientid').val();
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
                    htmlCode += "<option value='" + data[i].projectobject.id + "'>" + data[i].projectobject.name + "</option>";
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
                        '<td>' +
                        '<input class="form-control" type="text" value="' + data[i].id + '" style="min-width:150px" name="items[]">' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" type="text" value="' + data[i].title + '" style="min-width:150px" name="itemnames[]">' +
                        '</td>' +
                        '<td>' +
                        '<table class="table table-hover table-white" style="width: 100%;">' +
                        '<tr>' +
                        '<th>Title</th>' +
                        '<th>Description</th>' +
                        '</tr>';
                    data[i].projecttasks.forEach((projecttask) => {
                        htmlCode += '<tr>' +
                            '<td>' + projecttask.title + '</td>' +
                            '<td>' +
                            '<textarea class="form-control" type="text" style="min-width:100px" name="itemdescription[]">' + projecttask.description + ' </textarea>' +
                            '</td>' +
                            '</tr>';
                    });
                    htmlCode += '</table>' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" style="width:100px" type="text" value="' + data[i].price + '" name="price[]">' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" style="width:80px" type="text" value="' + data[i].projecttasks.length + '" onkeyup="counttotalamount(' + data[i].id + ')" name="qty[]">' +
                        '</td>' +
                        '<td>' +
                        '<input class="form-control" readonly style="width:120px" type="text" id="amount_' + data[i].id + '">' +
                        '</td>' +
                        '<td><a href="javascript:void(0)" class="text-danger font-18" title="Remove" onclick="deleteelement()"><i class="fa fa-trash-o"></i></a></td>' +
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

    var totalamount = 0;
    var rownumber = 0;
    var itemnames = [];

    function addelement(companyId) {
        rownumber = rownumber + 1;
        var str = "";
        str = '<tr id="element_' + rownumber + '">' +
            '<td>' +
            '<input class="form-control" type="text" style="min-width:150px" id="itemnumber_' + rownumber + '" name="items[]">' +
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

    function discountcalculate() {
        var totalamount = $('#total_amount').val();
        var totaltax = $('#total_tax').val();
        var discountpercentage = $('#discountamount').val();
        discount = (discountpercentage / 100) * (totalamount);
        finaltotal = (totalamount - discount);
        $('#grand_total').html(finaltotal + totaltax);
    }

    function counttotalamount(id) {
        var name = $('#groupname_' + id).val();
        itemnames.push(name);
        console.log(name, 'name');
        console.log(itemnames);
        var amount = $('#price_' + id).val();
        var qty = $('#qty_' + id).val();
        var finalamt = amount * qty;
        $('#amount_' + id).val(finalamt);
        totalamount += finalamt;
        $('#total_amount').val(totalamount);
    }




    $("#invoice_date").datetimepicker().on('dp.change', function() {
        $('#ptagerrorMessage').remove();

        var splittedDate = $("#invoice_date").val().split("/");
        var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

        var invoicedate = moment(dateToString).format("YYYY-MM-DD");
        var todaydate = moment().format("YYYY-MM-DD");
        if ((invoicedate) < (todaydate)) {
            $('#errormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Invoice Date cannot be less than Today date</p>');

        }
    });
</script>
