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
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating" id="myInput" onkeyup="myFunction(this)">
                    <label class="focus-label">Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Company</option>
                        <option>Global Technologies</option>
                        <option>Delta Infotech</option>
                    </select>
                    <label class="focus-label">Company</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Roll</option>
                        <option>Web Developer</option>
                        <option>Web Designer</option>
                        <option>Android Developer</option>
                        <option>Ios Developer</option>
                    </select>
                    <label class="focus-label">Role</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Registration Date</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($companymembers as $companymember) : ?>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <?php if ($companymember->user->profileFilename != null) : ?>
                                                <a href="/project-member/userprofile/<?= $companymember->user->id ?>" class="avatar"><img src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>" alt=""></a>
                                            <?php else : ?>
                                                <a class="avatar"><img src="/assets/img/profiles/avatar-02.jpg"></a>
                                            <?php endif; ?>

                                            <a href="/project-member/userprofile/<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?>
                                            </a>

                                        </h2>
                                    </td>
                                    <td><?= $companymember->user->email ?></td>
                                    <td>SocialLibreria Srl.</td>
                                    <?php if ($companymember->user->registrationDate != null) : ?>
                                        <td><?= $companymember->user->registrationDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php endif; ?>

                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_user_<?= $companymember->user->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user_<?= $companymember->user->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view_user_<?= $companymember->user->id ?>"><i class="fa fa-eye m-r-5"></i> view</a>
                                            </div>
                                        </div>
                                        <!-- View User Modal -->
                                        <div id="view_user_<?= $companymember->user->id ?>" class="modal custom-modal fade" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">View User Details<?= $companymember->user->id ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped custom-table datatable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ProjectID</th>
                                                                                <th>ProjectName</th>
                                                                                <th>Role</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>


                                                                          <!--   <?php foreach ($projectObjects as $projectObject) : ?>
                                                                                <?php if ($projectMember->projectId == $projectObject->id) : ?>
                                                                                    <tr>
                                                                                        <td>#<?= $projectObject->id ?></td>
                                                                                        <td><?= $projectObject->name ?></td>

                                                                                        <?php if ($projectMember->type == 'Y') : ?>
                                                                                            <td><span class="badge bg-inverse-success">Administrator</span></td>
                                                                                        <?php elseif ($projectMember->type == 'H') : ?>
                                                                                            <td><span class="badge bg-inverse-info">HR</span></td>

                                                                                        <?php elseif ($projectMember->type == 'X') : ?>
                                                                                            <td><span class="badge bg-inverse-danger">Developer</span></td>
                                                                                        <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                            <td><span class="badge bg-inverse-info">Project Manager</span></td>
                                                                                        <?php else : ?>
                                                                                            <td><span class="badge bg-inverse-success"></span></td>
                                                                                        <?php endif; ?>


                                                                                    </tr>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?> -->
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /View User Modal -->

                                        <!-- Delete User Modal -->
                                        <div class="modal custom-modal fade" id="delete_user_<?= $companymember->user->id ?>" role="dialog">
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
                                                                    <a href="/user/deleteuser?uid=<?= $companymember->user->id ?>&users=<?= $companymember->user->id ?>" class="btn btn-primary continue-btn">Delete</a>
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

                                        <!-- Edit User Modal -->
                                        <div id="edit_user_<?= $companymember->user->id ?>" class="modal custom-modal fade" role="dialog">
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
                                                                <input class="form-control" name="firstname" value="<?= $companymember->user->firstname ?>" type="text">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input class="form-control" name="lastname" value="<?= $companymember->user->lastname ?>" type="text">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date of Birth</label>
                                                                <?php if ($companymember->user->birthday != null) : ?>
                                                                    <input class="form-control datetimepicker" name="dob" value="<?= $companymember->user->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>" type="text">
                                                                <?php else : ?>
                                                                    <input class="form-control datetimepicker" name="dob" type="text">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>
                                                                    Address
                                                                </label>
                                                                <input class="form-control" name="address" value="<?= $companymember->user->address ?>" type="text">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>
                                                                    gender

                                                                </label>
                                                                <select class="select" name="gender">
                                                                    <?php if ($companymember->user->gender == 'Male') : ?>
                                                                        <option value="Male" selected>Male</option>
                                                                        <option value="Female">Female</option>
                                                                        <option value="Other">Other</option>
                                                                    <?php elseif ($companymember->user->gender == 'Female') : ?>

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
                                                                <input class="form-control" name="email" value="<?= $companymember->user->email ?>" type="email">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input class="form-control" name="password" type="password" value="<?= $companymember->user->password ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Confirm Password</label>
                                                                <input class="form-control" name="confirmpassword" type="password" value="<?= $companymember->user->password ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label> Password Expirationdate</label>
                                                                <input class="form-control datetimepicker" name="passwordExpitydate" type="text" value="<?= $companymember->user->passwordExpirationDate ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Phone </label>
                                                                <input class="form-control" name="tel" value="<?= $companymember->user->tel ?>" type="text">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Role</label>
                                                                <select class="select" name="role">
                                                                    <option value="Y">Admin</option>
                                                                    <option value="C">Client</option>
                                                                    <option value="E">Employee</option>
                                                                </select>
                                                            </div>
                                                            <!--  <div class="form-group">
                                                                <label>Employee ID <span class="text-danger">*</span></label>
                                                                <input type="text" value="FT-0001" class="form-control floating">
                                                            </div> -->

                                                    </div>

                                                    <div class="submit-section">
                                                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                                        <input type="hidden" name="userid" value="<?= $companymember->user->id ?>">
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- /Edit User Modal -->

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

    <!-- Add User Modal -->
    <div id="add_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select">
                                        <option>Admin</option>
                                        <option>Client</option>
                                        <option>Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="select">
                                        <option>Global Technologies</option>
                                        <option>Delta Infotech</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control floating">
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
                                        <td>Employee</td>
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Holidays</td>
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Events</td>
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
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
    <!-- /Add User Modal -->

    <!-- Edit User Modal -->
    <div id="edit_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input class="form-control" value="John" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" value="Doe" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input class="form-control" value="johndoe" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" value="johndoe@example.com" type="email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input class="form-control" value="9876543210" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select">
                                        <option>Admin</option>
                                        <option>Client</option>
                                        <option selected>Employee</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="select">
                                        <option>Global Technologies</option>
                                        <option>Delta Infotech</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" value="FT-0001" class="form-control floating">
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
                                        <td>Employee</td>
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Holidays</td>
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Events</td>
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
                                            <input checked="" type="checkbox">
                                        </td>
                                        <td class="text-center">
                                            <input checked="" type="checkbox">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit User Modal -->

</div>
<!-- /Page Wrapper -->
<script>
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
        console.log('values', values)
        var form_data = new FormData();
        console.log(values, 'stringfy valuesnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn');
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
