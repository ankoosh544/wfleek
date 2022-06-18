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
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Employee Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Profile</li>

                    </ul>
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
                                        <h3 class="card-title">Edit Employee Informations </a></h3>

                                        <form method="post" action="/additionaldatausers/addupdatedemployee" enctype="multipart/form-data">
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label>Role</label>
                                                    <select class="select2-icon floating" name="role">
                                                        <?php foreach ($designations as $designation) : ?>
                                                            <?php if ($employee->user->additionaldatauser->designation->name == $designation->name) : ?>
                                                                <option value="<?= $designation->id ?>" data-icon="fa fa-dot-circle-o text-danger" selected><?= $designation->name ?></option>
                                                            <?php else : ?>
                                                                <option value="<?= $designation->id ?>" data-icon="fa fa-dot-circle-o text-warning"><?= $designation->name ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tax Code</label>
                                                        <input type="text" class="form-control" name="tax_code" value="<?= $employee->user->additionaldatauser->tax_code ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Vat Code</label>
                                                        <input type="text" class="form-control" name="vat_code" value="<?= $employee->user->additionaldatauser->vat_code ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Contract Type</label>
                                                        <input type="text" class="form-control" name="contract_name" value="<?= $employee->user->additionaldatauser->employee_contract_type ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Upload Contract file <span style="color: red;">(If You Add New Doc, it will override old Doc)</span></label>
                                                        <input type="file" class="form-control" name="contractfile">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group m-b-20">
                                                    <?php if ($employee->user->additionaldatauser->contract_filepath != null && $employee->user->additionaldatauser->contract_filename != null) : ?>
                                                        <ul>
                                                            <li>
                                                                <a href=""><?= $employee->user->additionaldatauser->contract_filename ?></a>
                                                            </li>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Update</button>
                                        <input type="hidden" value="<?= $employee->user_id ?>" name="emp_id">
                                        <input type="hidden" value="<?= $employee->company_id ?>" name="company_id">

                                    </div>
                                    </form>

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
