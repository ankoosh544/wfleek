<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usercompany[]|\Cake\Collection\CollectionInterface $usercompanies
 */
?>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Tickets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_company"><i class="fa fa-plus"></i> Add Company</a>
                    <!--<a style="margin-left: 80%;" class="btn btn-info" data-toggle="modal" data-target="#add_company">Add Company</a>--->
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option> Pending </option>
                        <option> Approved </option>
                        <option> Returned </option>
                    </select>
                    <label class="focus-label">Status</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option> -- Select -- </option>
                        <option> High </option>
                        <option> Low </option>
                        <option> Medium </option>
                    </select>
                    <label class="focus-label">Priority</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
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
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Id</th>
                                <th>Company Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th class="text-center">Status</th>
                                <!-- <th class="text-right">Actions</th>--->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usercompanies as $company) : ?>

                                <tr>
                                    <td>1</td>

                                    <td><a href="company-view.html"><?= $company->id ?></a></td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a class="avatar avatar-xs" href="profile.html"><img alt="" src="assets/img/profiles/avatar-10.jpg"></a>
                                            <a href="#"> <?= $company->name ?></a>
                                        </h2>
                                    </td>
                                    <td>

                                        <?= $company->address ?>

                                    </td>
                                    <td>
                                        <?= $company->city ?>
                                    </td>
                                    <td>
                                        <?= $company->email ?>
                                    </td>
                                    <td>
                                        <?= $company->mobile_number ?>
                                    </td>
                                    <td class="text-center">


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

    <!-- Add Company Modal -->
    <div id="add_company" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form method="post" action="/usercompanies/add">
                        <div class="form-control col">
                            <label>Company Name</label>
                            <input class="form-control" type="text" name="company_name">
                        </div>
                        </br>
                        <div class="container">
                            <label>Address</label>

                            <label>Company Address</label>
                            <input class="form-control" type="text" name="company_address">

                            <div class="row">
                                <div class="form-control col">
                                    <label>Country</label>
                                    <input class="form-control" type="text" name="country">
                                </div>
                                <div class="form-control col">
                                    <label>City</label>
                                    <input class="form-control" type="text" name="city">
                                </div>
                                <div class="form-control col">
                                    <label>State/Province</label>
                                    <input class="form-control" type="text" name="state">

                                </div>
                                <div class="form-control col">
                                    <label>Postal Code</label>
                                    <input class="form-control" type="number" name="postalcode">
                                </div>
                            </div>
                        </div>
                        </br>

                        <div class="form-control col">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email">
                        </div>
                        </br>
                        <div class="form-control col">
                            <label>Phone Number</label>
                            <input class="form-control" type="number" name="phonenumber">
                        </div>
                        </br>
                        <div class="form-control col">
                            <label>Mobile Number</label>
                            <input class="form-control" type="text" name="mobilenumber">
                        </div>

                        <div class="form-control col">
                            <label>IBAN</label>
                            <input class="form-control" type="text" name="iban">
                        </div>
                        <div class="form-control col">
                            <label>Website Link</label>
                            <input class="form-control" type="text" name="weblink">
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>



                </div>

            </div>
        </div>
    </div>


    <!-- Edit Ticket Modal -->
    <div id="edit_company" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ticket Subject</label>
                                    <input class="form-control" type="text" value="Laptop Issue">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ticket Id</label>
                                    <input class="form-control" type="text" readonly value="TKT-0001">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assign Staff</label>
                                    <select class="select">
                                        <option>-</option>
                                        <option selected>Mike Litorus</option>
                                        <option>John Smith</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="select">
                                        <option>-</option>
                                        <option>Delta Infotech</option>
                                        <option selected>International Software Inc</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Priority</label>
                                    <select class="select">
                                        <option>High</option>
                                        <option selected>Medium</option>
                                        <option>Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>CC</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Assign</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ticket Assignee</label>
                                    <div class="project-members">
                                        <a title="John Smith" data-placement="top" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-02.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Add Followers</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Ticket Followers</label>
                                    <div class="project-members">
                                        <a title="Richard Miles" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-09.jpg" alt="">
                                        </a>
                                        <a title="John Smith" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                        </a>
                                        <a title="Mike Litorus" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-05.jpg" alt="">
                                        </a>
                                        <a title="Wilmer Deluna" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-11.jpg" alt="">
                                        </a>
                                        <span class="all-team">+2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload Files</label>
                                    <input class="form-control" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Ticket Modal -->

    <!-- Delete Ticket Modal -->
    <div class="modal custom-modal fade" id="delete_company" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Ticket</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
    <!-- /Delete Ticket Modal -->

</div>
<!-- /Page Wrapper -->
<script>
    function updatecompanystatus(event, id) {
        var status = event.value;
        console.log(id);
        console.log(status);
        $.ajax({

            url: '/projecttasks/updatecompanyStatus',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': id, //userid
                'status': status,


            },

            success: function(data) {
                // window.location.href = "/project-object/view/";
                // close popup click event trigger
                // div show $("#id").show();
                console.log(data);
            },
            error: function() {

            }
        })

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
</script>
