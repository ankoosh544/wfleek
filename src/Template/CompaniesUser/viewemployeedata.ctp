<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



<?php

use Cake\I18n\Number;

?>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Profile</li>

                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="/payslips/employeepayslips?empid=<?= $employee->user_id ?>&companyId=<?= $employee->usercompany->id ?>"" class="btn add-btn" > Payslips</a>
                </div>

            </div>
        </div>
        <!-- /Page Header -->

        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#">
                                        <?php if ($employee->user->profileFilepath != null && $employee->user->profileFilename != null) : ?>
                                            <img alt="" src="<?= $employee->user->profileFilepath ?>/<?= $employee->user->profileFilename ?>">
                                        <?php else : ?>
                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0"><?= $employee->user->firstname ?> <?= $employee->user->lastname ?></h3>
                                            <?php if ($employee != null) : ?>
                                                <?php if ($employee->member_role == 'X') : ?>
                                                    <h6 class="text-muted">Developer</h6>
                                                <?php elseif ($employee->member_role == 'Z') : ?>
                                                    <h6 class="text-muted">Project Manager</h6>
                                                <?php elseif ($employee->member_role == 'Y') : ?>
                                                    <h6 class="text-muted">Administrator</h6>
                                                <?php elseif ($employee->member_role == 'W') : ?>
                                                    <h6 class="text-muted">Coordinator</h6>
                                                <?php elseif ($employee->member_role == 'H') : ?>
                                                    <h6 class="text-muted">HR</h6>
                                                <?php else : ?>
                                                    <h6 class="text-muted">Customer</h6>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <h6 class="text-muted">User</h6>
                                            <?php endif; ?>
                                            <?php if ($employee != null) : ?>
                                                <div class="staff-id">Employee ID : <?= $employee->user_id ?></div>
                                            <?php endif; ?>
                                            <div class="small doj text-muted">Date of Join :20/4/2020</div>
                                            <div class="staff-msg"><a class="btn btn-custom" href="/chats/chatsystem/<?= $employee->user_id ?>">Send Message</a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <?php if ($employee->user->firstname != null) : ?>
                                                    <div class="title">First Name:</div>
                                                    <div class="text"><a href=""><?= $employee->user->firstname ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($employee->user->lastname != null) : ?>
                                                    <div class="title">Last Name:</div>
                                                    <div class="text"><a href=""><?= $employee->user->lastname ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($employee->user->tel != null) : ?>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a href=""><?= $employee->user->tel ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($employee->user->email != null) : ?>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href=""><?= $employee->user->email ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($employee->user->tax_code != null) : ?>
                                                    <div class="title">Codice Fiscale:</div>
                                                    <div class="text"><a href=""><?= $employee->user->tax_code ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($employee->user->vat_code != null) : ?>
                                                    <div class="title"> Partita IVA:</div>
                                                    <div class="text"><a href=""><?= $employee->user->vat_code ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <?php if ($employee->user->birthday != null) : ?>
                                                    <div class="text"><?= $employee->user->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></div>
                                                <?php endif; ?>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <!-- <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active" id="">Profile</a></li>
                        <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                          <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory <small class="text-danger">(Admin Only)</small></a></li>
                        <li class="nav-item"><a href="#emp_companies" data-toggle="tab" class="nav-link">Companies <small class="text-danger"></small></a></li>
                    </ul> -->

                    <div id="emp_profile" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="card profile-box flex-fill">
                                    <div class="card-body">
                                        <h3 class="card-title">Employee Informations </a></h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input type="text" class="form-control" name="firstname" value="<?= $employee->user->firstname ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input type="text" class="form-control" name="lastname" value="<?= $employee->user->lastname ?>"readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <select class="select form-control" name="gender"readonly>
                                                            <?php if ($$employee->user->gender == 'Male') : ?>
                                                                <option value="male" selected>Male</option>
                                                                <option value="female">Female</option>
                                                            <?php else : ?>
                                                                <option value="male ">Male</option>
                                                                <option value="female selected">Female</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Telephone Number</label>
                                                        <input type="text" class="form-control" name="tel" value="<?= $employee->user->tel ?>"readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control" name="email" value="<?= $employee->user->email ?>"readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" class="form-control" name="address" value="<?= $employee->user->address ?>"readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <input type="text" class="form-control" name="state" value="<?= $employee->user->state ?>"readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <input type="text" class="form-control" name="country" value="<?= $employee->user->country ?>"readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pin Code</label>
                                                        <input type="text" class="form-control" name="cap" value="<?= $employee->user->cap ?>"readonly>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>Role</label>
                                                    <select class="select2-icon floating" name="role"readonly>
                                                        <?php if ($employee->member_role == 'Y') : ?>
                                                            <option value="Y" data-icon="fa fa-dot-circle-o text-danger" selected>Administrator</option>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-warning">HR</option>
                                                            <option value="Z" data-icon="fa fa-dot-circle-o text-success">Project Manager</option>
                                                            <option value="X" data-icon="fa fa-dot-circle-o text-success">Developer</option>
                                                            <option value="C" data-icon="fa fa-dot-circle-o text-success">Customer</option>
                                                        <?php elseif ($employee->member_role == 'H') : ?>
                                                            <option value="Y" data-icon="fa fa-dot-circle-o text-danger">Administrator</option>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-warning" selected>HR</option>
                                                            <option value="Z" data-icon="fa fa-dot-circle-o text-success">Project Manager</option>
                                                            <option value="X" data-icon="fa fa-dot-circle-o text-success">Developer</option>
                                                            <option value="C" data-icon="fa fa-dot-circle-o text-success">Customer</option>
                                                        <?php elseif ($employee->member_role == 'Z') : ?>
                                                            <option value="Y" data-icon="fa fa-dot-circle-o text-danger">Administrator</option>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-warning">HR</option>
                                                            <option value="Z" data-icon="fa fa-dot-circle-o text-success" selected>Project Manager</option>
                                                            <option value="X" data-icon="fa fa-dot-circle-o text-success">Developer</option>
                                                            <option value="C" data-icon="fa fa-dot-circle-o text-success">Customer</option>
                                                        <?php elseif ($employee->member_role == 'X') : ?>
                                                            <option value="Y" data-icon="fa fa-dot-circle-o text-danger">Administrator</option>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-warning">HR</option>
                                                            <option value="Z" data-icon="fa fa-dot-circle-o text-success">Project Manager</option>
                                                            <option value="X" data-icon="fa fa-dot-circle-o text-success" selected>Developer</option>
                                                            <option value="C" data-icon="fa fa-dot-circle-o text-success">Customer</option>
                                                        <?php elseif ($employee->member_role == 'C') : ?>
                                                            <option value="Y" data-icon="fa fa-dot-circle-o text-danger">Administrator</option>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-warning">HR</option>
                                                            <option value="Z" data-icon="fa fa-dot-circle-o text-success">Project Manager</option>
                                                            <option value="X" data-icon="fa fa-dot-circle-o text-success">Developer</option>
                                                            <option value="C" data-icon="fa fa-dot-circle-o text-success" selected>Customer</option>
                                                        <?php else : ?>
                                                            <option value="Y" data-icon="fa fa-dot-circle-o text-danger">Administrator</option>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-warning">HR</option>
                                                            <option value="Z" data-icon="fa fa-dot-circle-o text-success">Project Manager</option>
                                                            <option value="X" data-icon="fa fa-dot-circle-o text-success">Developer</option>
                                                            <option value="C" data-icon="fa fa-dot-circle-o text-success">Customer</option>
                                                            <option value="" data-icon="fa fa-dot-circle-o text-success" selected>Co-Ordinator</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tax Code</label>
                                                        <input type="text" class="form-control" name="tax_code" value="<?= $employee->user->tax_code ?>"readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Vat Code</label>
                                                        <input type="text" class="form-control" name="vat_code" value="<?= $employee->user->vat_code ?>"readonly>
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
        </div>
    </div>
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
</script>
