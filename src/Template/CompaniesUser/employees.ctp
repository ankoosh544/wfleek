

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ul>



                </div>
                <?php foreach ($allemployees as $employee) : ?>
                    <?php if ($employee->user_id == $user_id) : ?>
                        <?php if ($employee->designation->name == 'Administrator' || $employee->designation->name == 'HR') : ?>
                            <div class="col-auto float-right ml-auto">
                                <a style="margin-left: -25%;" href="/companies-user/addemployees/<?= $companyId ?>" class="btn add-btn"> Add Employees </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="/companies-user/searchdata" method="POST">
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="name">
                        <label class="focus-label">Name</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select2-icon floating" name="companyname">
                            <option value="null">Select Company Name</option>
                            <option value="Social">Social</option>
                            <option value="FaceBook">FaceBook</option>
                        </select>
                        <label class="focus-label">Company</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus select-focus">
                        <select class="select2-icon floating" name="role">
                            <option value="null">Select Designation</option>
                            <option value="X">Developer</option>
                            <option value="Y">Administrator</option>
                            <option value="H">HR</option>
                            <option value="Z">Project Manager</option>
                        </select>
                        <label name="role" class="focus-label">Role</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                    <input type="hidden" name="companyId" value="<?= $companyId ?>">
                </div>
            </div>
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Created Date</th>
                                <th>Role</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            use Cake\I18n\Time;

                            foreach ($allemployees as $employee) : ?>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <?php if ($employee->user->profileFilepath != null && $employee->user->profileFilename) : ?>
                                                <a href="/project-member/userprofile/<?= $employee->user->id ?>" class="avatar"><img src="<?= $employee->user->profileFilepath ?>/<?= $employee->user->profileFilename ?>" alt=""></a>
                                            <?php else : ?>
                                                <a href="/project-member/userprofile/<?= $employee->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                            <?php endif; ?>
                                            <a href="/user/view/<?= $employee->user->id ?>"><?= $employee->user->firstname ?> <?= $employee->user->lastname ?>
                                                <span><?= $employee->designation->name ?></span>
                                            </a>
                                        </h2>
                                    </td>
                                    <td><?= $employee->user->email ?></td>
                                    <td><?= $employee->usercompany->name ?></td>
                                    <td><?= $employee->user->registrationDate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                    <td>
                                        <span class="badge bg-inverse-danger"><?= $employee->designation->name ?></span>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item" href="/companies-user/viewemployeedata?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->usercompany->id ?>"><i class="fa fa-eye m-r-5"></i> view</a>
                                                <a class="dropdown-item" href="/companies-user/employeesdata?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->usercompany->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user_<?= $employee->user_id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#punch_in_<?= $employee->user_id ?>">PunchIn</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#punch_out_<?= $employee->user_id ?>">PunchOut</a>
                                                <a class="dropdown-item" href="/workinghours/attendance?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->usercompany->id ?>">Attendence</i></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Delete User Modal -->
                                <div class="modal custom-modal fade" id="delete_user_<?= $employee->user_id ?>" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                    <h3>Delete User</h3>
                                                    <p>Are you sure want to delete?</p>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="/companies-user/delete?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->company_id ?>" class="btn btn-primary continue-btn">Delete</a>
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
                                <!-- /Delete User Modal -->

                                <!-- Attendance Modal -->
                                <div class="modal custom-modal fade" id="punch_in_<?= $employee->user_id ?>" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Punch In</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card punch-status">
                                                            <div class="card-body">

                                                                <?php $date = Time::now(); ?>
                                                                <h5 class="card-title" style="text-align: center;">Timesheet <small class="text-muted"><?= $date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></small></h5>

                                                                <div class="punch-btn-section">
                                                                    <a href="/companies-user/employeepunchin?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->company_id ?>" class="btn btn-primary punch-btn">Punch In</a>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Attendance Modal -->

                                <div class="modal custom-modal fade" id="punch_out_<?= $employee->user_id ?>" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Punch Out</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card punch-status">
                                                            <div class="card-body">
                                                                <div class="card-body">
                                                                    <h5 class="card-title" style="text-align: center;">Timesheet <small class="text-muted"><?= Time::now()->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></small></h5>
                                                                    <div class="punch-btn-section">
                                                                        <a href="/companies-user/employeepunchout?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->company_id ?>" class="btn btn-primary punch-btn">Punch Out</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add User Modal -->
    <div id="add_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User to Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group form-focus select-focus m-b-30">
                        <label for="tag"><?= __('Select Tag') ?> <span class="text-danger">*</span></label>
                        <select id="tag" class="select2-icon floating" name="tag" onchange="filtertags(this)">

                            <?php foreach ($result as $item) : ?>
                                <option value="<?= $item ?>"><?= $item ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    </br>

                    <div class="form-group form-focus select-focus m-b-30">
                        <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                        <select name="adduser" id="assignuser" class="select2-icon floating multiselector" multiple>
                        </select>
                    </div>
                    <br />
                    <div class="form-group form-focus select-focus m-b-30">
                        <label for="adddesignation"><?= __('Add Designation') ?><span class="text-danger">*</span></label>
                        <select id="selecteddesignation" class="select2-icon floating">
                            <option value="W">COORDINATOR</option>
                            <option value="X">DEVELOPER</option>
                            <option value="Y">ADMINISTRATOR</option>
                            <option value="Z">PROJECT MANAGER</option>
                            <option value="H">HR</option>
                        </select>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" onclick="inviteMembersforcompany(<?= $companyId ?>)">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /Add User Modal -->
</div>
<!-- /Page Wrapper -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    function updaterole(userid, companyId) {
        console.log($('#member_role_' + userid).val());
        $.ajax({
            url: '/companies-user/updaterole',
            method: 'post',
            dataType: 'json',
            data: {
                'userid': userid,
                'role': $('#member_role_' + userid).val()
            },
            success: function(data) {

                if (data != null) {
                    window.location = '/companies-user/employees/' + companyId + '';
                }



            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })
    }

    function filtertags() {
        $.ajax({
            url: '/project-object/filtertags',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': $('#tag').val(),
            },
            success: function(data) {
                console.log(data);
                var htmlCode = "";
                // i = 0;
                for (var i = 0; i < data.length; i++) {
                    htmlCode += "<option value='" + data[i].id + "'>" + data[i].firstname + " " + data[i].lastname + "<br/> " + data[i].email + "</option>";

                }
                $("#assignuser").html(htmlCode);
            },
            error: function() {}
        });
    }
    var values;
    $(".multiselector").on("select2:select", function(event) {

        values = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            values[i] = parseInt($(selected).val());

        });
    });

    function inviteMembersforcompany(cid) {

        var tag = $('#selecteddesignation').val();
        var form_data = new FormData();
        form_data.append("tagvalues", JSON.stringify(values));
        form_data.append("tag", tag);
        form_data.append("cid", cid);

        $.ajax({
            url: '/companies-user/invitemembers/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                console.log('sucess');
                location.reload();
            },
            error: function(e) {}
        });

    }
</script>
