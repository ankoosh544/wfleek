<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add Employees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ul>
                </div>
            </div>
            <div class="row" style="justify-content: center;">
                <div class="col-lg-12 col-md-12">
                    <div class="">
                        <section>
                            <h5 class="dash-title"></h5>
                            <div class="card">
                                <div class="card-body">
                                    <form action="/companies-user/filteremployees">
                                        <div class="row filter-row">
                                            <div class="col">
                                                <div class="form-group form-focus select-focus">
                                                    <select class="select floating" id="employee" name="employee">
                                                        <?php foreach ($result as $item) : ?>
                                                            <option value="<?= $item ?>"><?= $item ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label class="focus-label">Employees </label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-success btn-block"> Search </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
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
                                                <a href="profile.html"><?= $employee->user->firstname ?> <?= $employee->user->lastname ?>
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
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#punch_in_<?= $employee->user_id ?>"><i class="fa fa-time">PushIn</i></a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#punch_out_<?= $employee->user_id ?>"><i class="fa fa-time">PushOut</i></a>
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

                                                                        <?php $date = Time::now(); ?>
                                                                        <h5 class="card-title" style="text-align: center;">Timesheet <small class="text-muted"><?= $date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></small></h5>

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
        <!-- /Page Header -->


    </div>
    <!-- /Page Content -->


</div>
<!-- /Page Wrapper -->
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


    /*  function filtertags() {
             $.ajax({
                 url: '/project-object/alluserfiltertags',
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
                     //$('#assignuser').val("");
                     //$('#assignuser').select2().trigger('change');


                 },
                 error: function() {}
             });
         } */
</script>
