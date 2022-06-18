<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Search</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                    <a href="/companies-user/employees/<?=$companyId?>" class="btn btn-success btn-block"> Go Back </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <div class="row">
            <div class="col-12">


                <div class="search-lists">

                    <div class="tab-content">
                        <div class="tab-pane show active" id="results_projects">



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

                                                <?php foreach ($matched_data  as $index => $employee) : ?>
                                                    <tr>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <?php if ($employee->user->profileFilepath != null && $employee->user->profileFilename) : ?>
                                                                    <a href="/project-member/userprofile/<?= $employee->user->id ?>" class="avatar"><img src="<?= $employee->user->profileFilepath ?>/<?= $employee->user->profileFilename ?>" alt=""></a>
                                                                <?php else : ?>
                                                                    <a href="/project-member/userprofile/<?= $employee->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                                                <?php endif; ?>
                                                                <a href="profile.html"><?= $employee->user->firstname ?> <?= $employee->user->lastname ?>
                                                                    <?php if ($employee->member_role == 'Y') : ?>
                                                                        <span>Admin</span>
                                                                    <?php elseif ($employee->member_role == 'H') : ?>
                                                                        <span>HR</span>
                                                                    <?php elseif ($employee->member_role == 'Z') : ?>
                                                                        <span>Project Manager</span>
                                                                    <?php elseif ($employee->member_role == 'X') : ?>
                                                                        <span>Developer</span>
                                                                    <?php elseif ($employee->member_role == 'C') : ?>
                                                                        <span>Customer</span>
                                                                    <?php else : ?>
                                                                        <span>CO-Ordinator</span>
                                                                    <?php endif; ?>
                                                                </a>
                                                            </h2>
                                                        </td>
                                                        <td><?= $employee->user->email ?></td>
                                                        <td><?= $employee->usercompany->name ?></td>
                                                        <td><?= $employee->user->registrationDate ?></td>
                                                        <td>
                                                            <?php if ($employee->member_role == 'Y') : ?>
                                                                <span class="badge bg-inverse-danger">Admin</span>
                                                            <?php elseif ($employee->member_role == 'H') : ?>
                                                                <span class="badge bg-inverse-danger">HR</span>
                                                            <?php elseif ($employee->member_role == 'Z') : ?>
                                                                <span class="badge bg-inverse-danger">Project Manager</span>
                                                            <?php elseif ($employee->member_role == 'X') : ?>
                                                                <span class="badge bg-inverse-danger">Developer</span>
                                                            <?php elseif ($employee->member_role == 'C') : ?>
                                                                <span class="badge bg-inverse-danger">Customer</span>
                                                            <?php else : ?>
                                                                <span class="badge bg-inverse-danger">CO-Ordinator</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="dropdown dropdown-action">
                                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">

                                                                    <a class="dropdown-item" href="/companiesuser/viewemployeedata?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->usercompany->id ?>"><i class="fa fa-eye m-r-5"></i> view</a>
                                                                    <a class="dropdown-item" href="/companiesuser/employeesdata?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->usercompany->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user_<?= $employee->user_id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#punch_in_<?= $employee->user_id ?>"><i class="fa fa-time">PushIn</i></a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#punch_out_<?= $employee->user_id ?>"><i class="fa fa-time">PushOut</i></a>
                                                                    <a class="dropdown-item" href="/workinghours/attendance?emp_id=<?= $employee->user_id ?>&company_id=<?= $employee->usercompany->id ?>">Attendence</i></a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                <?php endforeach; ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                            </div>

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
