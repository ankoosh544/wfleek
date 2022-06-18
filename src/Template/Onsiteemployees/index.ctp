<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>





<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Onsiteemployee[]|\Cake\Collection\CollectionInterface $onsiteemployees
 */
?>


<style>
    .form-focus.select-focus .focus-label {
        opacity: 1;
        font-weight: 300;
        top: -20px;
        font-size: 12px;
        z-index: 1;
    }
</style>


<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee's Requests</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Requests</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_request"><i class="fa fa-plus"></i> Categorize Employees</a>
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_location"><i class="fa fa-plus"></i> Add Location</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" id="myInput" class="form-control floating" onkeyup="myFunction(this)">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>


            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select id="searchleavetype" class="select floating" onchange="serachLeavetype(<?= $total ?>)">
                        <option disabled> -- Select -- </option>
                        <option>Home Location</option>
                        <option>Client Location</option>
                        <option>Office Location</option>
                    </select>
                    <label class="focus-label">Work Type</label>
                </div>
            </div>
            <br />
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select id="serachLeavestatus" class="select floating" onchange="serachLeavestatus(<?= $total ?>)">
                        <option> -- Select -- </option>
                        <option> Pending </option>
                        <option> Approved </option>
                        <option> Rejected </option>
                    </select>
                    <label class="focus-label">Work Status</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input id="searchfromdate" class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input id="todatesearch" class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>Employee</th>

                                <th>Request Type</th>
                                <th>Work Type</th>

                                <th>Description</th>
                                <th>From</th>
                                <th>To</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>






                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Create Employee record Modal -->
    <div id="add_request" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Employees for Onsite Work</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group suggessioninfo">
                        <label>Choose Company <span class="text-danger">*</span></label>
                        <!--  <select class="select" id="company" name="company" onchange="filtertags(this)">
                            <option selected>Choose Client</option>
                            <?php foreach ($clientsData as $client) : ?>
                                <option value="<?= $client->id ?>"><?= $client->firstname ?> <?= $client->lastname ?></option>
                            <?php endforeach; ?>
                        </select> -->
                        <input class="form-control" type="text" id="mysuggestedData" placeholder="Enter Client Name or Email" name="company" onchange="filtertags(this)">



                    </div>

                    <div class="form-group">
                        <label>Project Name<span class="text-danger">*</span></label>
                        <select class="select" id="seletedproject" name="projectname" onchange="getemployees(this)">

                        </select>
                    </div>


                    <div class="form-group">
                        <label> Work Locations <span class="text-danger">*</span></label>
                        <div class="row">
                            <?php foreach ($worklocations as $location) : ?>
                                <div class="col-md-4">
                                    <label> <?= $location->work_location ?> <span class="text-danger">*</span></label>
                                    <select class="select projectemps" id="worklocation_<?= $location->id ?>" onchange="checkclientlocation(<?= $location->id ?>, '<?= $location->work_location ?>')" multiple>
                                    </select>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    </br>

                    <div style="display: none;" id="clientlocationdata">
                        <div class="form-project">
                            <label>
                                <h4>Tranvelling Details</h4>
                            </label>
                            <div class="form-group">
                                <label>Type of Transport</label>
                                <select class="select2-icon floating" id="type_travel">
                                    <option selected>Select Type of Transport</option>
                                    <option value="Train">Train</option>
                                    <option value="Bus">Bus</option>
                                    <option value="Airoplan">Airoplan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="projectIMG"><?= __('Proof of Attachment') ?></label>
                                <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'transportfile', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                            </div>
                        </div>
                        <div class="form-project">
                            <label>
                                <h4>Accomodation Details</h4>
                            </label>
                            <div class="form-group">
                                <label>Hotel Name</label>
                                <input class="form-control" name="hotelname" id="hotelname">
                            </div>
                            <div class="form-group">
                                <label for="projectIMG"><?= __('Proof of Attachment') ?></label>
                                <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'accomodationfile', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="form-project">
                            <label>
                                <h4>Food Details</h4>
                            </label>
                            <div class="form-group">
                                <label>Restaurant Name</label>
                                <input class="form-control" name="restaurantname">
                            </div>
                            <div class="form-group">
                                <label for="projectIMG"><?= __('Proof of Attachment') ?></label>
                                <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'foodfile', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                            </div>
                        </div>


                    </div>
                    <div class="submit-section">
                        <button type="submit" id="addemployeebutton" class="btn btn-primary submit-btn" onclick="addemployees()">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->

    <!-- Add Add Location Modal -->
    <div id="add_location" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form action="/onsiteemployees/addlocation" method="post">
                        <div class="form-group">
                            <label>Location name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name='location_name'>
                        </div>

                        <div class="form-group">
                            <label>Location Address <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name='location_address'>
                        </div>

                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /Add Leave Modal -->
</div> -->




<script type="text/javascript">
    var company_id;
    $(document).ready(function() {
        $('#mysuggestedData').on('autocompleteselect', function(e, ui) {
            var selectedItem = ui.item.value;
            var selectedItemArray = selectedItem.split('*****');
            var emailId = selectedItemArray[0];
            company_id = selectedItemArray[1];
            console.log(emailId);
            console.log(company_id);
            $("#mysuggestedData").val(emailId);
            return false;
        });
        console.log(company_id, 'companyid');
        $.ajax({
            url: '/onsiteemployees/docworklocations',

            success: function(data) {


                var worklocation = {};

                data.forEach((location) => {

                    $("#worklocation_" + location.id).on("select2:select", function(event) {
                        console.log('hi toemails')
                        worklocation[location.id] = [];
                        $(event.currentTarget).find("option:selected").each(function(i, selected) {
                            console.log("i", i);
                            worklocation[location.id][i] = parseInt($(selected).val());
                        });
                    });
                });
                //console.log("Work locations", worklocation);

                $('#addemployeebutton').click(function() {
                    addemployees(worklocation);
                });


            },
            error: function() {}
        });
        //suggested Data ajax function
        $.ajax({

            url: "/project-member/suggesteddata",

            success: function(data) {
                console.log(data, 'Client Data');
                var emailIds = [];
                for (i = 0; i < data.length; i++) {
                    // console.log(data[i]['email']);
                    // if(i == 0)
                    // {
                    //     emailIds = data[i]['firstname'] ;
                    // }
                    // else{
                    //     emailIds = emailIds +  ", " + data[i]['firstname'] ;
                    // }
                    console.log(emailIds);
                    // array - email1, email2
                    var source = emailIds;
                    emailIds.push(data[i]['email']);
                }
                $('#mysuggestedData').autocomplete({
                    source: function(request, response) {
                        var term = $.ui.autocomplete.escapeRegex(request.term),
                            startsWithMatcher = new RegExp("^" + term, "i"),
                            startsWith = $.grep(source, function(value) {
                                return startsWithMatcher.test(value.label || value.value || value);
                            }),
                            containsMatcher = new RegExp(term, "i"),
                            contains = $.grep(source, function(value) {
                                var value = value.trim();
                                return $.inArray(value, startsWith) < 0 &&
                                    containsMatcher.test(value.label || value.value || value);
                            });
                        response(startsWith.concat(contains));
                    }
                });
                String.prototype.replaceAt = function(index, char) {
                    return this.substr(0, index) + "<span style='font-weight:normal;color:#3399ff;'>" + char + "</span>";
                }
                $.ui.autocomplete.prototype._renderItem = function(ul, item) {
                    this.term = this.term.toLowerCase();
                    var resultStr = item.label.toLowerCase().trim();
                    var emailOriginal = resultStr.split('*****');
                    resultStr = emailOriginal[0] + "";
                    var t = "";
                    while (resultStr.indexOf(this.term) != -1) {
                        var index = resultStr.indexOf(this.term);
                        item.label = allTitleCase(resultStr);
                        t = t + item.label.replaceAt(index, item.label.slice(index, index + this.term.length));
                        resultStr = resultStr.substr(index + this.term.length);
                        item.label = item.label.substr(index + this.term.length);
                    }
                    return $("<li ></li>").data("item.autocomplete", item).append("<span>" + t + item.label + "</span>").appendTo(ul);
                };

                $("#mysuggestedData").autocomplete("option", "appendTo", ".suggessioninfo");
            }
        });
    });

    function changeRequestType(event) {
        //window.location.reload();


        var type = $('#requesttype').val();
        console.log(type);
        if (requesttype != 'W') {
            $("#workrequest").show()

            //$("#otherwork").hide()
        } else {
            $("#workrequest").hide()
        }


        // ajax call
    }

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            console.log(td);
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
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


    function filtertags() {

        //  console.log($('#company').val(), 'tagvalue');
        $.ajax({
            url: '/onsiteemployees/companyproject',
            method: 'post',
            dataType: 'json',
            data: {
                'clientid': company_id,
            },
            success: function(data) {
                console.log(data);
                var htmlCode = "";
                data.forEach((project) => {
                    console.log(project.project_object.id, 'this');
                    htmlCode += "<option value='" + project.project_object.id + "'>" + project.project_object.name + "</option>";
                });
                $("#seletedproject").html(htmlCode);
                $('#seletedproject').val("");
                //$('#assignuser').select2().trigger('change');
            },
            error: function() {}
        });
    }


    function getemployees() {

        console.log($('#seletedproject').val(), 'tagvalue');
        $.ajax({
            url: '/onsiteemployees/getemployees',
            method: 'post',
            dataType: 'json',
            data: {
                'projectid': $('#seletedproject').val(),
            },
            success: function(data) {


                console.log(data);
                var htmlCode = "";
                data.forEach((emp) => {


                    htmlCode += "<option value='" + emp.user.id + "'>" + emp.user.email + "</option>";

                });
                $(".projectemps").html(htmlCode);
                $('.projectemps').val("");
                //$('#assignuser').select2().trigger('change');


            },
            error: function() {}
        });
    }


    function addemployees(worklocation) {


        var company = company_id;
        console.log(company, 'This is company id');
        var project = $('#seletedproject').val();



        var form_data = new FormData();


        if (worklocation != null) {
            var type_travel = $('#type_travel').val();
            var transportfile = $('#transportfile').prop("files");
            var hotelname = $('#hotelname').val();
            var accomodationfile = $('#accomodationfile').prop("files");
            var restaurantname = $('#restaurantname').val();
            var foodfile = $('#foodfile').prop("files");


            form_data.append("type_travel", type_travel);

            if (transportfile.length > 0) {
                for (var i = 0; i < transportfile.length; i++) {
                    form_data.append("file[]", transportfile[i]);
                }
            } else {
                transportfileNotattached = 123;
            }
            form_data.append("hotelname", hotelname);
            if (accomodationfile.length > 0) {
                for (var i = 0; i < accomodationfile.length; i++) {
                    form_data.append("file[]", accomodationfile[i]);
                }
            } else {
                accomodationfileNotattached = 123;
            }

            form_data.append("restaurantname", restaurantname);

            if (foodfile.length > 0) {
                for (var i = 0; i < foodfile.length; i++) {
                    form_data.append("file[]", foodfile[i]);
                }
            } else {
                foodfileNotattached = 123;
            }

        }
        form_data.append("company", company);
        form_data.append("project", project);
        form_data.append("worklocation", JSON.stringify(worklocation));
        $.ajax({
            url: '/onsiteemployees/add',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                window.location = '/onsiteemployees/index/';

            },
            error: function() {}
        });


    }

    function allTitleCase(inStr) {
        return inStr.replace(/\w\S*/g, function(tStr) {
            return tStr.charAt(0).toUpperCase() + tStr.substr(1).toLowerCase();
        });
    }


    function checkclientlocation(location_id, location_name) {

        console.log(location_name, "locid");
        if (location_name === 'Client Location') {
            if ($('#worklocation_' + location_id).find(':selected').length > 0) {
                clientlocationdata.style.display = "block";
            } else {
                clientlocationdata.style.display = "none";
            }
        }
        // $('#worklocation_'+locationid)


    }
</script>
