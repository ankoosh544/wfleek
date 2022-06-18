<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee Salary</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Salary</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_salary"><i class="fa fa-plus"></i> Add Salary</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <!-- Search Filter -->
        <form method="POST" action="/salaries/filtersalaryemps/">
            <div class="row filter-row">
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="empid">
                        <label class="focus-label">Employee Id</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <input type="text" class="form-control floating" name="name">
                        <label class="focus-label">Employee Name</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus select-focus">
                        <select class="select floating" name="role">
                            <option value=""> -- Select -- </option>
                            <option value="Z">Project Manager</option>
                            <option value="X">Developer</option>
                            <option value="Y">Administrator</option>
                            <option value="H">HR</option>
                        </select>
                        <label class="focus-label">Role</label>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group form-focus">
                        <div class="cal-icon">
                            <input class="form-control floating datetimepicker" type="text" name="joindate">
                            <input type="hidden" name="companyId" value="<?=$companyId?>">
                        </div>
                        <label class="focus-label">Date Of Join</label>
                    </div>
                </div>


                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
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
                                <th>Employee</th>
                                <th>Employee ID</th>
                                <th>Email</th>
                                <th>Join Date</th>
                                <th>Role</th>
                                <th>Salary</th>
                                <th>Payslip</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($salaries as $salary) : ?>
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar">
                                                <?php if ($salary->user->profileFilepath != null && $salary->user->profileFilename != null) : ?>
                                                    <img src="<?= $salary->user->profileFilepath ?>/<?= $salary->user->profileFilename ?>" alt="">
                                                <?php else : ?>
                                                    <img src="/assets/img/profiles/avatar-13.jpg" alt="">
                                                <?php endif; ?>
                                            </a>
                                            <a href="profile.html"><?= $salary->user->firstname ?> <?= $salary->user->lastname ?>
                                                <?php foreach ($employees as $employee) : ?>
                                                    <?php if ($employee->user->id == $salary->user->id) : ?>
                                                        <?php if ($employee->member_role == 'Y') : ?>
                                                            <span>Administrator</span>
                                                        <?php elseif ($employee->member_role == 'X') : ?>

                                                            <span>Developer</span>
                                                        <?php elseif ($employee->member_role == 'H') : ?>
                                                            <span>HR</span>

                                                        <?php elseif ($employee->member_role == 'Z') : ?>
                                                            <span>Project Manager</span>

                                                        <?php elseif ($employee->member_role == 'C') : ?>
                                                            <span>Customer</span>

                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>

                                            </a>
                                        </h2>
                                    </td>
                                    <td><?= $salary->user->id ?></td>
                                    <td><?= $salary->user->email ?></td>
                                    <td><?= $salary->user->registrationDate ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <!--   <a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Web Designer </a> -->

                                            <?php foreach ($employees as $employee) : ?>
                                                <?php if ($employee->user->id == $salary->user->id) : ?>
                                                    <?php if ($employee->member_role == 'Y') : ?>
                                                        <a class="dropdown-item" href="#">Administrator</a>
                                                    <?php elseif ($employee->member_role == 'X') : ?>
                                                        <a class="dropdown-item" href="#">Developer</a>
                                                    <?php elseif ($employee->member_role == 'H') : ?>
                                                        <a class="dropdown-item" href="#">HR</a>
                                                    <?php elseif ($employee->member_role == 'Z') : ?>
                                                        <a class="dropdown-item" href="#">Project Manager</a>
                                                    <?php elseif ($employee->member_role == 'C') : ?>
                                                        <a class="dropdown-item" href="#">Customer</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        </div>
                                    </td>
                                    <td><?= $salary->net_salary ?></td>
                                    <td><a class="btn btn-sm btn-primary" href="/salaries/viewpayslip?empid=<?= $salary->user_id ?>&companyId=<?= $salary->company_id ?>">Generate Slip</a></td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_salary"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_salary"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    <!-- /Page Content -->

    <!-- Add Salary Modal -->
    <div id="add_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/salaries/addsalary">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Staff</label>
                                    <select class="select" name="userid">
                                        <?php foreach ($employees as $employee) : ?>
                                            <option value="<?= $employee->user->id ?>"><?= $employee->user->firstname ?> <?= $employee->user->lastname ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Net Salary</label>
                                <input class="form-control" type="text" name="net_salary">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-primary">Earnings</h4>
                                <div class="form-group">
                                    <label>Basic</label>
                                    <input class="form-control" type="text" name="basic">
                                </div>
                                <div class="form-group">
                                    <label>DA(40%)</label>
                                    <input class="form-control" type="text" name="da">
                                </div>
                                <div class="form-group">
                                    <label>HRA(15%)</label>
                                    <input class="form-control" type="text" name="hra">
                                </div>

                                <div class="form-group form-focus select-focus ">
                                    <label>Select Month</label>
                                    <select id="searchprojecttype" class="select floating" name="month">
                                        <option value="gennaio">gennaio</option>
                                        <option value="febbraio">febbraio</option>
                                        <option value="marzo">marzo</option>
                                        <option value="aprile">aprile</option>
                                        <option value="maggio">maggio</option>
                                        <option value="giugno">giugno</option>
                                        <option value="luglio">luglio</option>
                                        <option value="agosto">agosto</option>
                                        <option value="settembre">settembre</option>
                                        <option value="ottobre">ottobre</option>
                                        <option value="novembre">novembre</option>
                                        <option value="dicembre">dicembre</option>
                                    </select>
                                </div>
                                </br>
                                <!--  <div class="form-group">
                                            <label>Conveyance</label>
                                            <input class="form-control" type="text" >
                                        </div> -->
                                <!--  <div class="form-group">
                                            <label>Allowance</label>
                                            <input class="form-control" type="text">
                                        </div> -->
                                <!--  <div class="form-group">
                                            <label>Medical  Allowance</label>
                                            <input class="form-control" type="text">
                                        </div> -->
                                <!-- <div class="form-group">
                                    <label>Others</label>
                                    <input class="form-control" type="text">
                                </div> -->
                              <!--   <div class="add-more">
                                    <a href="#"><i class="fa fa-plus-circle"></i> Add More</a>
                                </div> -->
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                <div class="form-group">
                                    <label>TDS</label>
                                    <input class="form-control" type="text" name="tds">
                                </div>
                                <div class="form-group">
                                    <label>ESI</label>
                                    <input class="form-control" type="text" name="esi">
                                </div>
                                <div class="form-group">
                                    <label>PF</label>
                                    <input class="form-control" type="text" name="pf">
                                </div>
                                <!--   <div class="form-group">
                                            <label>Leave</label>
                                            <input class="form-control" type="text">
                                        </div> -->
                                <div class="form-group">
                                    <label>Prof. Tax</label>
                                    <input class="form-control" type="text" name="tax">
                                </div>
                                <!--  <div class="form-group">
                                            <label>Labour Welfare</label>
                                            <input class="form-control" type="text">
                                        </div> -->
                                <!-- <div class="form-group">
                                    <label>Others</label>
                                    <input class="form-control" type="text">
                                </div> -->
                               <!--  <div class="add-more">
                                    <a href="#"><i class="fa fa-plus-circle"></i> Add More</a>
                                </div> -->
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            <input type="hidden" name="companyId" value="<?= $companyId ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Salary Modal -->

    <!-- Edit Salary Modal -->
    <div id="edit_salary" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Staff</label>
                                    <select class="select">
                                        <option>John Doe</option>
                                        <option>Richard Miles</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Net Salary</label>
                                <input class="form-control" type="text" value="$4000">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="text-primary">Earnings</h4>
                                <div class="form-group">
                                    <label>Basic</label>
                                    <input class="form-control" type="text" value="$6500">
                                </div>
                                <div class="form-group">
                                    <label>DA(40%)</label>
                                    <input class="form-control" type="text" value="$2000">
                                </div>
                                <div class="form-group">
                                    <label>HRA(15%)</label>
                                    <input class="form-control" type="text" value="$700">
                                </div>
                                <div class="form-group">
                                    <label>Conveyance</label>
                                    <input class="form-control" type="text" value="$70">
                                </div>
                                <div class="form-group">
                                    <label>Allowance</label>
                                    <input class="form-control" type="text" value="$30">
                                </div>
                                <div class="form-group">
                                    <label>Medical Allowance</label>
                                    <input class="form-control" type="text" value="$20">
                                </div>
                                <div class="form-group">
                                    <label>Others</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class="text-primary">Deductions</h4>
                                <div class="form-group">
                                    <label>TDS</label>
                                    <input class="form-control" type="text" value="$300">
                                </div>
                                <div class="form-group">
                                    <label>ESI</label>
                                    <input class="form-control" type="text" value="$20">
                                </div>
                                <div class="form-group">
                                    <label>PF</label>
                                    <input class="form-control" type="text" value="$20">
                                </div>
                                <div class="form-group">
                                    <label>Leave</label>
                                    <input class="form-control" type="text" value="$250">
                                </div>
                                <div class="form-group">
                                    <label>Prof. Tax</label>
                                    <input class="form-control" type="text" value="$110">
                                </div>
                                <div class="form-group">
                                    <label>Labour Welfare</label>
                                    <input class="form-control" type="text" value="$10">
                                </div>
                                <div class="form-group">
                                    <label>Fund</label>
                                    <input class="form-control" type="text" value="$40">
                                </div>
                                <div class="form-group">
                                    <label>Others</label>
                                    <input class="form-control" type="text" value="$15">
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
    <!-- /Edit Salary Modal -->

    <!-- Delete Salary Modal -->
    <div class="modal custom-modal fade" id="delete_salary" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Salary</h3>
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
    <!-- /Delete Salary Modal -->

</div>
<!-- /Page Wrapper -->
