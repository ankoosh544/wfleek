<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
                    <div class="view-icons">
                        <a href="employees.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="employees-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <?php $total = count($allUsers);

                   ?>

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating" id="searchIds" onkeyup="searchbyids(<?=$total?>)">
                    <label class="focus-label">Employee ID</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">

                    <input type="text" class="form-control floating" id="myInput" onkeyup="myFunction(<?= $total?>)">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Designation</option>
                        <option>Web Developer</option>
                        <option>Web Designer</option>
                        <option>Android Developer</option>
                        <option>Ios Developer</option>
                    </select>
                    <label class="focus-label">Designation</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- Search Filter -->

        <div class="row staff-grid-row" id="myTable">
            <?php foreach ($allUsers as $index => $singleUser) : ?>
                <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3" id="mydiv_<?=$index?>">
                <input type="hidden" id="searchinput_<?=$index?>" value="<?=$singleUser->id?>">
                    <div class="profile-widget">
                        <div class="profile-img">
                            <?php if ($singleUser->profileFilename != null) : ?>
                                <a href="/projectmember/userprofile/<?= $singleUser->id ?>" class="avatar"><img src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>" alt=""></a>
                            <?php else : ?>
                              <a class="avatar"><img src="/assets/img/profiles/avatar-02.jpg" ></a>
                            <?php endif; ?>
                        </div>
                        <div class="dropdown profile-action">
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_employee_<?= $singleUser->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_employee_<?= $singleUser->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                        <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="/projectmember/userprofile/<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></a></h4>
                        <!--  <?php foreach ($employees as $employee) : ?>
                            <?php if ($employee->memberId == $singleUser->id) : ?>
                                <?php if ($employee->type == 'Y') : ?>
                                    <div class="small text-muted">Administrator</div>
                                    <div class="small text-muted"><?= $singleUser->email ?></div>
                                <?php elseif ($employee->type == 'Z') : ?>
                                    <div class="small text-muted">Project Manager</div>
                                    <div class="small text-muted"><?= $singleUser->email ?></div>
                                <?php elseif ($employee->type == 'X') : ?>
                                    <div class="small text-muted">Developer</div>
                                    <div class="small text-muted"><?= $singleUser->email ?></div>
                                <?php else : ?>
                                    <div class="small text-muted">HR</div>
                                    <div class="small text-muted"><?= $singleUser->email ?></div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?> -->
                    </div>
                </div>


                <!-- Edit Employee Modal -->

                <div id="edit_employee_<?= $singleUser->id ?>" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/user/updateuser" method="post">

                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input class="form-control" name="firstname" value="<?= $singleUser->firstname ?>" type="text">
                                    </div>

                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" name="lastname" value="<?= $singleUser->lastname ?>" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <?php if ($singleUser->birthday != null) : ?>
                                            <input class="form-control datetimepicker" name="dob" value="<?= $singleUser->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>" type="text">
                                        <?php else : ?>
                                            <input class="form-control datetimepicker" name="dob" type="text">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Address
                                        </label>
                                        <input class="form-control" name="address" value="<?= $singleUser->address ?>" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            gender

                                        </label>
                                        <select class="select" name="gender">
                                            <?php if ($singleUser->gender == 'Male') : ?>
                                                <option value="Male" selected>Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            <?php elseif ($singleUser->gender == 'Female') : ?>

                                                <option value="Male">Male</option>
                                                <option value="Female" selected>Female</option>
                                                <option value="Other">Other</option>
                                            <?php else : ?>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other" selected>Other</option>
                                            <?php endif; ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input class="form-control" name="email" value="<?= $singleUser->email ?>" type="email">
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" name="password" type="password" value="<?= $singleUser->password ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" name="confirmpassword" type="password" value="<?= $singleUser->password ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> Password Expirationdate</label>
                                        <input class="form-control datetimepicker" name="passwordExpitydate" type="text" value="<?= $singleUser->passwordExpirationDate ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Phone </label>
                                        <input class="form-control" name="tel" value="<?= $singleUser->tel ?>" type="text">
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="select" name="role">
                                            <option value="Y">Admin</option>
                                            <option value="C">Client</option>
                                            <option value="E">Employee</option>
                                        </select>
                                    </div>
                            </div>

                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                <input type="hidden" name="userid" value="<?= $singleUser->id ?>">
                                <input type="hidden" name="employee" value="<?= $singleUser->id ?>">
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- /Edit Employee Modal -->


                <!-- Delete Employee Modal -->
                <div class="modal custom-modal fade" id="delete_employee_<?= $singleUser->id ?>" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Delete Employee</h3>
                                    <p>Are you sure want to delete?</p>
                                </div>
                                <div class="modal-btn delete-action">
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="/user/deleteuser?uid=<?= $singleUser->id ?>&emp=<?=$singleUser->id?>" class="btn btn-primary continue-btn">Delete</a>
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


            <?php endforeach; ?>

        </div>
    </div>
    <!-- /Page Content -->

    <!-- Add Employee Modal -->
    <div id="add_employee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Last Name</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Username <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Joining Date <span class="text-danger">*</span></label>
                                    <div class="cal-icon"><input class="form-control datetimepicker" type="text"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Phone </label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Company</label>
                                    <select class="select">
                                        <option value="">Global Technologies</option>
                                        <option value="1">Delta Infotech</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Department</option>
                                        <option>Web Development</option>
                                        <option>IT Management</option>
                                        <option>Marketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Designation</option>
                                        <option>Web Designer</option>
                                        <option>Web Developer</option>
                                        <option>Android Developer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive m-t-15">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>Module Permission</th>
                                        <th class="text-center">Read</th>
                                        <th class="text-center">Write</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">Delete</th>
                                        <th class="text-center">Import</th>
                                        <th class="text-center">Export</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Holidays</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Leaves</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Clients</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Projects</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tasks</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Chats</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Assets</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Timing Sheets</td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Employee Modal -->



    <!-- Delete Employee Modal -->
    <div class="modal custom-modal fade" id="delete_employee" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Employee</h3>
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
    <!-- /Delete Employee Modal -->

</div>
<!-- /Page Wrapper -->


<script>
    function myFunction(total) {

        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");

        console.log(input);
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");

        console.log(table, 'table');


        for (i = 0; i < total; i++) {
            tr = document.getElementById("mydiv_"+i);

            td = tr.getElementsByTagName("h4")[0].innerText;
            // name = td.getElementsByTagName("h4");
            console.log(td, 'td');
            if (td) {
                txtValue = td;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr.style.display = "";
                } else {
                    tr.style.display = "none";
                }
            }
        }
    }

    function searchbyids(total){

        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchIds").value;
        console.log(input);
        table = document.getElementById("myTable");
        for (i = 0; i < total; i++) {
            tr = document.getElementById("mydiv_"+i);
            txtValue = document.getElementById("searchinput_"+i).value;
            if (txtValue) {
                if (input === '' || input === txtValue) {
                    tr.style.display = "";
                } else {
                    tr.style.display = "none";
                }
            }
        }
    }
</script>

