<?php

use Cake\I18n\Number;
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title"><?= __('Il mio profilo') ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Profile</li>
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/<?= $authuser->choosen_companyId ?>"><?= __('Dashboard') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Il mio profilo') ?></li>
                        <a style="margin-left: 88%;" class="btn btn-info" data-toggle="modal" data-target="#add_company"><?= __('Crea un\'azienda') ?></a>
                        <a style="margin-left: -25%;" class="btn btn-info" href="/favoriteposts/view/">Favourite Posts</a>
                        <?php if (!empty($admin) && $authuser->id == $admin->user_id) : ?>
                            <a style="margin-left: -25%;" class="btn btn-info" href="/usercompanies/generateqrcode?companyId=<?= $authuser->choosen_companyId ?>&type=Entrance">Entrance</a>

                            <a style="margin-left: 2%;" class="btn btn-info" href="/usercompanies/generateqrcode?companyId=<?= $authuser->choosen_companyId ?>&type=Exit">Exit</a>
                        <?php endif; ?>

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
                                <div class="edit-profile-img">
                                    <a data-toggle="modal" data-target="#editprofile_picture_<?= $authuser->id ?>">
                                        <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                            <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>">
                                        <?php else : ?>
                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                        <?php endif; ?>
                                        <span class="change-img">Change Image</span>
                                    </a>
                                </div>
                            </div>
                            <!-- Edit profile picture Modal -->
                            <?= $this->element('editprofile_picture', [
                                'authuser' => $authuser
                            ]) ?>
                            <!-- /Edit Project Modal -->


                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0"><?= $authuser->firstname ?> <?= $authuser->lastname ?></h3>
                                            <?php if (!empty($projectObject->projectMember)) : ?>
                                                <?php if ($projectMember->type == 'X') : ?>
                                                    <h6 class="text-muted">Developer</h6>
                                                <?php elseif ($projectMember->type == 'Z') : ?>
                                                    <h6 class="text-muted">Project Manager</h6>
                                                <?php elseif ($projectMember->type == 'Y') : ?>
                                                    <h6 class="text-muted">Administrator</h6>
                                                <?php elseif ($projectMember->type == 'W') : ?>
                                                    <h6 class="text-muted">Coordinator</h6>
                                                <?php elseif ($projectMember->type == 'H') : ?>
                                                    <h6 class="text-muted">HR</h6>
                                                <?php else : ?>
                                                    <h6 class="text-muted">Customer</h6>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <h6 class="text-muted">User</h6>
                                            <?php endif; ?>
                                            <?php if (!empty($projectObject->projectMember)) : ?>
                                                <div class="staff-id">Employee ID : <?= $projectMember->memberId ?></div>
                                            <?php endif; ?>
                                            <div class="small doj text-muted">Date of Join :20/4/2020</div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="staff-msg">
                                                    <a class="btn btn-custom" href="/chats/chatsystem/<?= $authuser->id ?>">Send Message</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">First Name:</div>
                                                <div class="text"><a href=""><?= $authuser->firstname ?></a></div>
                                            </li>
                                            <li>
                                                <div class="title">Last Name:</div>
                                                <div class="text"><a href=""><?= $authuser->lastname ?></a></div>
                                            </li>
                                            <li>
                                                <?php if ($authuser->tel != null) : ?>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a href=""><?= $authuser->tel ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($authuser->email != null) : ?>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href=""><?= $authuser->email ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($authuser->tax_code != null) : ?>
                                                    <div class="title">Codice Fiscale:</div>
                                                    <div class="text"><a href=""><?= $authuser->tax_code ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($authuser->vat_code != null) : ?>
                                                    <div class="title"> Partita IVA:</div>
                                                    <div class="text"><a href=""><?= $authuser->vat_code ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <?php if ($authuser->birthday != null) : ?>
                                                    <div class="text"><?= $authuser->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></div>
                                                <?php endif; ?>
                                            </li>
                                            <!--  <li>
                                                <div class="title">List of Comapanies :</div>
                                                <?php foreach ($authusercompanies as $usercompany) : ?>
                                                <div class="text">
                                                    <div class="avatar-box">
                                                        <div class="avatar avatar-xs">
                                                            <img src="/assets/img/profiles/avatar-16.jpg" alt="">
                                                        </div>
                                                    </div>
                                                    <a href="profile.html"><?= $usercompany->usercompany->name ?> </a>
                                                </div>
                                                <?php endforeach; ?>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php if ($authuser->id == $user_id || $admin->type == 'Y') : ?>
                                <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active" id="">Profile</a></li>
                        <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                        <!--   <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory <small class="text-danger">(Admin Only)</small></a></li>-->
                        <li class="nav-item"><a href="#emp_companies" data-toggle="tab" class="nav-link">Companies <small class="text-danger"></small></a></li>
                        <li class="nav-item"><a href="#emp_contract" data-toggle="tab" class="nav-link">Contracts <small class="text-danger"></small></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content">

            <!-- Profile Info Tab--->
            <div id="emp_profile" class="pro-overview tab-pane fade show active">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Personal Informations <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">First Name</div>
                                        <div class="text"><?= $authuser->firstname ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Last Name</div>
                                        <div class="text"><?= $authuser->lastname ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Gender</div>
                                        <div class="text"><?= $authuser->gender ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Tel</div>
                                        <div class="text"><a href=""><?= $authuser->tel ?></a></div>
                                    </li>
                                    <li>
                                        <div class="title">Email</div>
                                        <div class="text"><a href=""><?= $authuser->email ?></a></div>
                                    </li>
                                    <li>
                                        <div class="title">Date of Birth</div>
                                        <?php if ($authuser->birthday != null) : ?>
                                            <div class="text"><a href=""><?= $authuser->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></a></div>
                                        <?php else : ?>
                                            <div class="text"><a href=""></a></div>
                                        <?php endif; ?>
                                    </li>
                                    <li>
                                        <div class="title">Address</div>
                                        <div class="text"><?= $authuser->address ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Country</div>
                                        <div class="text"><?= $authuser->country ?></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Bank information <a href="#" class="edit-icon" data-toggle="modal" data-target="#bank_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Bank name</div>
                                        <div class="text">
                                            <?php if (!empty($authuser->userbank) && $authuser->userbank->bank_name != null) : ?>
                                                <?= $authuser->userbank->bank_name ?></div>
                                    <?php endif; ?>
                                    </li>
                                    <li>
                                        <div class="title">Bank IBAN No.</div>

                                        <div class="text">
                                            <?php if (!empty($authuser->userbank) && $authuser->userbank->iban != null) : ?>
                                                <?= $authuser->userbank->iban ?>
                                            <?php endif; ?>
                                        </div>

                                    </li>
                                    <li>
                                        <div class="title">City</div>

                                        <div class="text"> <?php if (!empty($authuser->userbank) && $authuser->userbank->city_bankbranch != null) : ?><?= $authuser->userbank->city_bankbranch ?><?php endif; ?></div>

                                    </li>
                                    <li>
                                        <div class="title">Province</div>

                                        <div class="text">
                                            <?php if (!empty($authuser->userbank) && $authuser->userbank->province_bankbranch != null) : ?>
                                                <?= $authuser->userbank->province_bankbranch ?>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="title">Country</div>
                                        <div class="text">
                                        <?php if(!empty($authuser->userbank) && $authuser->userbank->state_bankbranch != null) : ?>
                                        <?= $authuser->userbank->state_bankbranch ?></div>
                                        <?php endif;?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /Profile Info Tab -->

            <!-- Company Info Tab--->
            <div id="emp_companies" class="pro-overview tab-pane fade">
                <div class="row">
                    <?php foreach ($authusercompanies as $company) : ?>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title"><a href="/usercompanies/view?company_id=<?= $company->usercompany->id ?>"> <?= $company->usercompany->name ?></a>
                                        <?php if ($authuser->id == $user_id || $admin->type == 'Y') : ?>
                                            <a href="#" class="edit-icon" data-toggle="modal" data-target="#companies_info_modal_<?= $company->usercompany->id ?>"><i class="fa fa-pencil"></i></a>
                                        <?php endif; ?>
                                    </h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Description.</div>
                                            <div class="text"><?= $company->usercompany->description ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Designation</div>
                                            <?php if ($company->member_role == 'Y') : ?>
                                                <div class="text">Administrator</div>
                                            <?php elseif ($company->member_role == 'C') : ?>
                                                <div class="text">Customer</div>
                                            <?php elseif ($company->member_role == 'Z') : ?>
                                                <div class="text">ProjectManager</div>
                                            <?php elseif ($company->member_role == 'X') : ?>
                                                <div class="text">Developer</div>
                                            <?php elseif ($company->member_role == 'H') : ?>
                                                <div class="text">HR</div>
                                            <?php else : ?>
                                                <div class="text">CO-Ordinator</div>
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                            <div class="title">Tel</div>
                                            <div class="text"><a href=""><?= $company->usercompany->phone_number ?></a></div>
                                        </li>
                                        <li>
                                            <div class="title">Email</div>
                                            <div class="text"><a href=""><?= $company->usercompany->email ?></a></div>
                                        </li>
                                        <li>
                                            <div class="title">WebSite</div>
                                            <div class="text"><?= $company->usercompany->website ?></div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>


                        <!---Company Info Modal ----->
                        <div id="companies_info_modal_<?= $company->usercompany->id ?>" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit <?= $company->usercompany->name ?> </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="/usercompanies/updatecompanyinfo" enctype="multipart/form-data">

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Company Name</label>
                                                        <input class="form-control" type="text" name="company_name" value="<?= $company->usercompany->name ?>">
                                                    </div>

                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Company Address</label>
                                                        <input class="form-control" type="text" name="company_address" value="<?= $company->usercompany->address ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            </br>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label><?= __('Stato') ?><span class="text-danger">*</span></label>
                                                        <select class="form-control select" name="country">
                                                            <option selected value="ITALIA"><?= __('Italia') ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label><?= __('Province') ?><span class="text-danger">*</span></label>
                                                        <select class="select2-icon floating" id="editprovince_<?= $company->usercompany->id ?>" name="province" onchange="filtercitiesedit(<?= $company->usercompany->id ?>)">
                                                            <?php foreach ($cities as $city) : ?>
                                                                <?php if ($company->usercompany->province == $city->province) : ?>
                                                                    <option selected value="<?= $city->province ?>"><?= $city->province ?></option>
                                                                <?php else : ?>
                                                                    <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label><?= __('Città') ?><span class="text-danger">*</span></label>
                                                        <select class="select2-icon floating" name="city" id="editcompany_city_<?= $company->usercompany->id ?>">
                                                            <?php foreach ($cities as $city) : ?>
                                                                <?php if ($company->usercompany->city == $city->name) : ?>
                                                                    <option selected value="<?= $city->name ?>"><?= $city->name ?></option>
                                                                <?php else : ?>
                                                                    <option value="<?= $city->name ?>"><?= $city->name ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Postal Code</label>
                                                        <input type="number" id="editcompany_postalcode_<?= $company->usercompany->id ?>" name="postalcode" value="<?= $company->usercompany->postal_code ?>" onkeyup="checkpostalcodeedit(<?= $company->usercompany->id ?>); return false;">
                                                        <span style="color: red;" id="editpostalcode_errormessage_<?= $company->usercompany->id ?>"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            </br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Fiscal Code</label>
                                                        <input type="text" class="form-control" name="fiscal_code" value="<?= $company->usercompany->fiscal_code ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Vat Code</label>
                                                        <input type="text" class="form-control" name="vat_code" value="<?= $company->usercompany->vat_code ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            </br>
                                            <div class="bankinfo">
                                                <label>Bank Information</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Bank Name</label>
                                                            <input class="form-control" type="text" name="bank_name" value="<?= $company->usercompany->bank_name ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>IBAN</label>
                                                            <input class="form-control" type="text" name="iban" value="<?= $company->usercompany->iban ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                </br>

                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label><?= __('Stato Banka') ?><span class="text-danger">*</span></label>
                                                        <select class="form-control select" name="state_bankbranch">
                                                            <option selected value="ITALIA"><?= __('Italia') ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col">
                                                        <label><?= __('Province') ?><span class="text-danger">*</span></label>
                                                        <select class="select2-icon floating" id="editbankprovince_<?= $company->usercompany->id ?>" name="bankprovince" onchange="filterbankcitiesedit(<?= $company->usercompany->id ?>)">
                                                            <option value="NULL">Not Selected</option>
                                                            <?php foreach ($cities as $city) : ?>
                                                                <?php if ($company->usercompany->province_bankbranch == $city->province) : ?>
                                                                    <option selected value="<?= $city->province ?>"><?= $city->province ?></option>
                                                                <?php else : ?>
                                                                    <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col">
                                                        <label>City of Bank</label>
                                                        <select class="select2-icon floating" name="city_bankbranch" id="editbank_city_<?= $company->usercompany->id ?>">
                                                            <?php foreach ($cities as $city) : ?>
                                                                <?php if ($company->usercompany->city_bankbranch == $city->name) : ?>
                                                                    <option selected value="<?= $city->name ?>"><?= $city->name ?></option>
                                                                <?php else : ?>
                                                                    <option value="NULL"></option>
                                                                    <option value="<?= $city->name ?>"><?= $city->name ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            </br>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input class="form-control" type="email" name="email" value="<?= $company->usercompany->email ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input class="form-control" type="number" name="phonenumber" value="<?= $company->usercompany->phone_number ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            </br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Mobile Number</label>
                                                        <input class="form-control" type="text" name="mobilenumber" value="<?= $company->usercompany->mobile_number ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>PEC Email</label>
                                                        <input class="form-control" type="text" name="pec_mail" value="<?= $company->usercompany->pec_mail ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>SDI Code</label>
                                                        <input class="form-control" type="text" name="sdi_code" value="<?= $company->usercompany->sdi_code ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Website Link</label>
                                                <input class="form-control" type="text" name="weblink" value="<?= $company->usercompany->website ?>">
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label>Company Description</label>
                                                <textarea class="form-control summernote" type="text" name="company_description"><?= $company->usercompany->description ?></textarea>
                                            </div>


                                            <div class="submit-section">
                                                <button class="btn btn-primary submit-btn">Update</button>
                                                <input type="hidden" name="companyId" value="<?= $company->usercompany->id ?>">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---/Company Info Modal ----->
                    <?php endforeach; ?>

                </div>

            </div>
            <!-- /Company Info Tab -->

            <!-- Projects Tab -->
            <div class="tab-pane fade" id="emp_projects">
                <div class="row">
                    <?php if ($projectObjects != null) : ?>
                        <?php foreach ($projectObjects as $index => $projectObject) : ?>
                            <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                <div class="card" id="mycard_<?= $index ?>">
                                    <div class="card-body" id="mytype_<?= $index ?>">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_<?= $projectObject->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                        <h4 id="myrow_<?= $index ?>" class="project-title"><a href="/project-object/view/<?= $projectObject->id ?>" onclick="checkuserType(<?= $projectObject->id ?>, <?= $user_id ?>)"><?= $projectObject->name ?></a></h4>

                                        <p><?= $projectObject->projecttype->name ?></p>

                                        <small class="block text-ellipsis m-b-15">
                                            <?php $opentask = 0;
                                            $completedtask = 0 ?>
                                            <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                <?php if ($projecttask->status == 'T' || $projecttask->status == 'I') : ?>
                                                    <?php $opentask = $opentask + 1;    ?>
                                                <?php elseif ($projecttask->status == 'D') : ?>
                                                    <?php $completedtask = $completedtask + 1; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php $totaltasks = $opentask + $completedtask ?>
                                            <span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span>
                                            <span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span>
                                        </small>
                                        <p class="text-muted"><?= $projectObject->description ?></p>
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                <?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                            </div>
                                        </div>
                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <?php foreach ($projectObject->projectmembers as $manager) : ?>
                                                    <li>
                                                        <a href="#" data-toggle="tooltip" title="<?= $manager->user->firstname ?> <?= $manager->user->lastname ?>">
                                                            <?php if ($manager->user->profileFilepath != null && $manager->user->profileFilename != null) : ?>
                                                                <img alt="" src="<?= $manager->user->profileFilepath ?>/<?= $manager->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="project-members m-b-15">
                                            <div>Team :</div>
                                            <ul class="team-members">
                                                <?php foreach ($projectObject->projectmembers as $projectMember) : ?>
                                                    <li id="myli_<?= $index ?>">
                                                        <?php $allemps = array();
                                                        array_push($allemps, $projectMember->user->firstname . ' ' . $projectMember->user->lastname);
                                                        ?>
                                                        <input id="allemps" type="hidden" value="<?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?>">
                                                        <a href="#" data-toggle="tooltip" title="<?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?>">
                                                            <?php if ($projectMember->user->profileFilepath != null && $projectMember->user->profileFilename != null) : ?>
                                                                <img alt="" src="<?= $projectMember->user->profileFilepath ?>/<?= $projectMember->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>

                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="priority m-b-15">
                                            <div>Priority :</div>
                                            <select class="select2-icon floating" onchange="updatepriority(<?= $projectObject->id ?>, <?= $authuser->id ?>)" id="priority_project_<?= $projectObject->id ?>">
                                                <?php if ($projectObject->priority == 'H') : ?>
                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                <?php elseif ($projectObject->priority == 'M') : ?>
                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>
                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                <?php else : ?>
                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        </br>
                                        <div class="project_status m-b-30">
                                            <div>Status :</div>
                                            <select class="select2-icon floating" onchange="updatestatus(<?= $projectObject->id ?>, <?= $authuser->id ?>)" id="status_project_<?= $projectObject->id ?>">
                                                <?php if ($projectObject->status == 'A') : ?>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                <?php else : ?>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        </br>
                                        <?php if ($totaltasks != 0) : ?>
                                            <?php $progress = round($completedtask / ($totaltasks) * 100); ?>
                                            <p class="m-b-5">Progress <span class="text-success float-right"><?= $progress = round($completedtask / ($opentask + $completedtask) * 100); ?>%</span></p>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: <?= $progress ?>%"></div>
                                            </div>
                                        <?php else : ?>
                                            <p class="m-b-5">Progress <span class="text-success float-right">0%</span></p>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="0%" style="width: 0%"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>


                            <?php $userprofile = $projectObject->id; ?>

                            <!-- Edit Project Modal -->
                            <?= $this->element('edit_projectmodal', [
                                'projectObject' => $projectObject,
                                'userprofile' => $userprofile

                            ]) ?>
                            <!-- /Edit Project Modal -->




                            <!-- Delete Project Modal -->
                            <!--------Delete Project------------------>

                            <?= $this->element('delete_projectmodal', [
                                'projectObject' => $projectObject,
                                'userprofile' => $userprofile
                            ]) ?>

                            <!--------/Delete Project------------------>
                            <!-- /Delete Project Modal ---->
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /Projects Tab -->

            <!-- Projects Tab -->
            <div class="tab-pane fade" id="emp_contract">
                <div class="row">
                    <?php if ($projectObjects != null) : ?>
                        <?php foreach ($projectObjects as $index => $projectObject) : ?>
                            <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                <div class="card" id="mycard_<?= $index ?>">
                                    <div class="card-body" id="mytype_<?= $index ?>">
                                        <div class="dropdown dropdown-action profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_<?= $projectObject->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                        <h4 id="myrow_<?= $index ?>" class="project-title"><a href="/project-object/view/<?= $projectObject->id ?>" onclick="checkuserType(<?= $projectObject->id ?>, <?= $user_id ?>)"><?= $projectObject->name ?></a></h4>

                                        <p><?= $projectObject->projecttype->name ?></p>

                                        <small class="block text-ellipsis m-b-15">
                                            <?php $opentask = 0;
                                            $completedtask = 0 ?>
                                            <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                <?php if ($projecttask->status == 'T' || $projecttask->status == 'I') : ?>
                                                    <?php $opentask = $opentask + 1;    ?>
                                                <?php elseif ($projecttask->status == 'D') : ?>
                                                    <?php $completedtask = $completedtask + 1; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php $totaltasks = $opentask + $completedtask ?>
                                            <span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span>
                                            <span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span>
                                        </small>
                                        <p class="text-muted"><?= $projectObject->description ?></p>
                                        <div class="pro-deadline m-b-15">
                                            <div class="sub-title">
                                                Deadline:
                                            </div>
                                            <div class="text-muted">
                                                <?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                            </div>
                                        </div>
                                        <div class="project-members m-b-15">
                                            <div>Project Leader :</div>
                                            <ul class="team-members">
                                                <?php foreach ($projectObject->projectmembers as $manager) : ?>
                                                    <li>
                                                        <a href="#" data-toggle="tooltip" title="<?= $manager->user->firstname ?> <?= $manager->user->lastname ?>">
                                                            <?php if ($manager->user->profileFilepath != null && $manager->user->profileFilename != null) : ?>
                                                                <img alt="" src="<?= $manager->user->profileFilepath ?>/<?= $manager->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="project-members m-b-15">
                                            <div>Team :</div>
                                            <ul class="team-members">
                                                <?php foreach ($projectObject->projectmembers as $projectMember) : ?>
                                                    <li id="myli_<?= $index ?>">
                                                        <?php $allemps = array();
                                                        array_push($allemps, $projectMember->user->firstname . ' ' . $projectMember->user->lastname);
                                                        ?>
                                                        <input id="allemps" type="hidden" value="<?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?>">
                                                        <a href="#" data-toggle="tooltip" title="<?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?>">
                                                            <?php if ($projectMember->user->profileFilepath != null && $projectMember->user->profileFilename != null) : ?>
                                                                <img alt="" src="<?= $projectMember->user->profileFilepath ?>/<?= $projectMember->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>

                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="priority m-b-15">
                                            <div>Priority :</div>
                                            <select class="select2-icon floating" onchange="updatepriority(<?= $projectObject->id ?>, <?= $authuser->id ?>)" id="priority_project_<?= $projectObject->id ?>">
                                                <?php if ($projectObject->priority == 'H') : ?>
                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                <?php elseif ($projectObject->priority == 'M') : ?>
                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>
                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                <?php else : ?>
                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        </br>
                                        <div class="project_status m-b-30">
                                            <div>Status :</div>
                                            <select class="select2-icon floating" onchange="updatestatus(<?= $projectObject->id ?>, <?= $authuser->id ?>)" id="status_project_<?= $projectObject->id ?>">
                                                <?php if ($projectObject->status == 'A') : ?>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                <?php else : ?>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        </br>
                                        <?php if ($totaltasks != 0) : ?>
                                            <?php $progress = round($completedtask / ($totaltasks) * 100); ?>
                                            <p class="m-b-5">Progress <span class="text-success float-right"><?= $progress = round($completedtask / ($opentask + $completedtask) * 100); ?>%</span></p>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: <?= $progress ?>%"></div>
                                            </div>
                                        <?php else : ?>
                                            <p class="m-b-5">Progress <span class="text-success float-right">0%</span></p>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="0%" style="width: 0%"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>


                            <?php $userprofile = $projectObject->id; ?>

                            <!-- Edit Project Modal -->
                            <?= $this->element('edit_projectmodal', [
                                'projectObject' => $projectObject,
                                'userprofile' => $userprofile

                            ]) ?>
                            <!-- /Edit Project Modal -->

                            <!-- Delete Project Modal -->
                            <!--------Delete Project------------------>

                            <?= $this->element('delete_projectmodal', [
                                'projectObject' => $projectObject,
                                'userprofile' => $userprofile
                            ]) ?>

                            <!--------/Delete Project------------------>
                            <!-- /Delete Project Modal ---->
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /Projects Tab -->
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Profile Modal -->
    <div id="profile_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/user/updateuserprofile/" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                    <img class="inline-block" src="/assets/img/profiles/avatar-02.jpg" alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="userIMG" name="profilepic" type="file" onchange="validateFileSize(); return false;" multiple />
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Birth Date</label>
                                    <div class="cal-icon">
                                        <?php if ($authuser->birthday != null) : ?>
                                            <input class="form-control datetimepicker" type="text" name="dob" value="<?= $authuser->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?> ?>" required>
                                        <?php else : ?>
                                            <input class="form-control datetimepicker" type="text" name="dob" required>

                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Codice Fiscale</label>
                                    <input class="form-control" type="text" name="tax_code" value="<?= $authuser->tax_code ?>">
                                </div>

                                <div class="form-group">
                                    <label>Partita IVA</label>
                                    <input class="form-control" type="text" name="vat_code" value="<?= $authuser->vat_code ?>">
                                </div>


                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="tel" value="<?= $authuser->tel ?>">
                                </div>

                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Company Modal -->

    <?= $this->element('create_company') ?>

    <!-- /Create Company Modal -->


    <!-- Personal Info Modal --->
    <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Personal Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/user/updateuserprofile">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?= $authuser->firstname ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?= $authuser->lastname ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Birth Date</label>
                                    <div class="cal-icon">
                                        <?php if ($authuser->birthday != null) : ?>
                                            <input class="form-control datetimepicker" type="text" name="dob" value="<?= $authuser->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>">
                                        <?php else : ?>
                                            <input class="form-control datetimepicker" type="text" name="dob">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="select form-control" name="gender">
                                        <?php if ($authuser->gender == 'Male') : ?>
                                            <option value="male" selected>Male</option>
                                            <option value="female">Female</option>
                                        <?php else : ?>
                                            <option value="male ">Male</option>
                                            <option value="female selected">Female</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" value="<?= $authuser->address ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="<?= $authuser->state ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" name="country" value="<?= $authuser->country ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pin Code</label>
                                    <input type="text" class="form-control" name="cap" value="<?= $authuser->cap ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" name="tel" value="<?= $authuser->tel ?>">
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
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/Personal Info Modal------->

    <!-- Bank Info Modal --->
    <div id="bank_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bank Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/user/updateuserbankinfo">


                        <div class="form-group col">
                            <label>Bank Name</label>
                            <?php if (!empty($authuser->userbank) && $authuser->userbank->bank_name != null) : ?>
                                <input type="text" class="form-control" name="bankname" value="<?= $authuser->userbank->bank_name ?>">
                            <?php else : ?>
                                <input type="text" class="form-control" name="bankname">
                            <?php endif; ?>
                        </div>


                        <div class="form-group col">
                            <label>Iban</label>
                            <?php if (!empty($authuser->userbank) && $authuser->userbank->iban != null) : ?>
                                <input type="text" class="form-control" name="iban" value="<?= $authuser->userbank->iban ?>">
                            <?php else : ?>
                                <input type="text" class="form-control" name="iban">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col">
                            <label><?= __('Stato Banka') ?><span class="text-danger">*</span></label>
                            <select class="form-control select" name="state_bankbranch">
                                <option selected value="ITALIA"><?= __('Italia') ?></option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label><?= __('Province') ?><span class="text-danger">*</span></label>
                            <select class="select2-icon floating" id="editbankprovince_<?= $authuser->id ?>" name="bankprovince" onchange="filterbankcitiesedit(<?= $authuser->id ?>)">
                                <option value="NULL">Not Selected</option>
                                <?php foreach ($cities as $city) : ?>

                                    <?php if (!empty($authuser->userbank) && $authuser->userbank->province_bankbranch != null && $authuser->userbank->province_bankbranch == $city->province) : ?>
                                        <option selected value="<?= $city->province ?>"><?= $city->province ?></option>
                                    <?php else : ?>
                                        <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>City of Bank</label>
                            <select class="select2-icon floating" name="city_bankbranch" id="editbank_city_<?= $authuser->id ?>">
                                <?php foreach ($cities as $city) : ?>
                                    <?php if (!empty($authuser->userbank) && $authuser->userbank->city_bankbranch != null && $authuser->userbank->city_bankbranch == $city->name) : ?>
                                        <option selected value="<?= $city->name ?>"><?= $city->name ?></option>
                                    <?php else : ?>
                                        <option value="NULL"></option>
                                        <option value="<?= $city->name ?>"><?= $city->name ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="submit-section">
                            <input type="hidden" value="<?= $authuser->id ?>" name="userId">
                            <button class="btn btn-primary submit-btn">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /Page Wrapper -->
<script>
    function checkuserType(pid, uid) {
        $.ajax({
            url: '/project-object/projectusers',
            method: 'post',
            dataType: 'json',
            data: {
                'pid': pid,
                'uid': uid
            },
            success: function(data) {

                if (data != null) {
                    alert(data);
                    window.location = '/project-member/userprofile/' + uid;
                }
            },
            error: function() {}
        })

    }



    function deletefile(fid, pid) {
        console.log(fid, pid);
        $.ajax({
            url: '/project-object/deletefile',
            method: 'post',
            dataType: 'json',
            data: {
                'fid': fid,
                'pid': pid
            },
            success: function(data) {
                console.log(data, 'filedeleted');
                $('#fileinfo_' + pid).empty();
                console.log(data, 'filedeleted');
                var filedata = "";
                data.forEach((file) => {

                    filedata += '<div class="uploaded-img">' +
                        '<span class="remove-icon">' +
                        '<a onclick="deletefile(' + file.id + ',' + file.project_id + '" class="del-msg"><i class="fa fa-close"></i></a>' +
                        '</span>' +
                        '</a>' +
                        '</div>' +
                        '<div class="uploaded-img-name">' + file.filename + '</div>';
                });

                $('#fileinfo_' + pid).html(filedata);
            },
            error: function() {}
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

    function updatepriority(pid, userid) {
        var priority = $('#priority_project_' + pid).val();
        $.ajax({
            url: '/project-object/updatepriority',
            method: 'post',
            dataType: 'json',
            data: {
                'pid': pid,
                'priority': priority
            },
            success: function(data) {

                if (data != null) {
                    window.location = '/project-member/userprofile/' + userid;
                }



            },
            error: function() {}
        })

    }


    function updatestatus(pid, userid) {
        var status = $('#status_project_' + pid).val();

        console.log(status, 'status');
        $.ajax({
            url: '/project-object/updatestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'pid': pid,
                'status': status
            },
            success: function(data) {

                if (data != null) {
                    window.location = '/project-member/userprofile/' + userid;
                }



            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })

    }

    function checkpostalcode() {
        city = $('#company_city').val();

        console.log($('#company_postalcode').val());
        $.ajax({
            url: '/cities/checkpostalcode',
            method: 'post',
            dataType: 'json',
            data: {
                'city': city,
                'postalcode': $('#company_postalcode').val()
            },
            success: function(data) {
                $('#postalcode_errormessage').empty();

                if (data['RESULT'] == "ERROR") {
                    $('#postalcode_errormessage').append(data['MESSAGE']);
                } else {
                    $('#postalcode_errormessage').empty();
                }
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })
    }

    function checkpostalcodeedit(companyId) {

        city = $('#editcompany_city_' + companyId).val();

        $.ajax({
            url: '/cities/checkpostalcode',
            method: 'post',
            dataType: 'json',
            data: {
                'city': city,
                'postalcode': $('#editcompany_postalcode_' + companyId).val()
            },
            success: function(data) {
                $('#editpostalcode_errormessage_' + companyId).empty();
                if (data['RESULT'] == "ERROR") {
                    $('#editpostalcode_errormessage_' + companyId).append(data['MESSAGE']);
                } else {
                    $('#editpostalcode_errormessage_' + companyId).empty();
                }
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })
    }


    function filtercities() {

        console.log($('#province').val());
        $.ajax({
            url: '/cities/filtercities',
            method: 'post',
            dataType: 'json',
            data: {
                'province': $('#province').val(),
            },
            success: function(data) {
                $("#company_city").empty();
                var htmlCode = "";
                data['cities'].forEach((city) => {
                    htmlCode += "<option value='" + city.name + "'>" + city.name + " " + "</option>";
                });
                $("#company_city").html(htmlCode);
            },
            error: function() {}
        });

    }

    function filterbankcities() {

        console.log($('#province').val());
        $.ajax({
            url: '/cities/filtercities',
            method: 'post',
            dataType: 'json',
            data: {
                'province': $('#bankprovince').val(),
            },
            success: function(data) {
                $("#bank_city").empty();

                var htmlCode = "";
                data['cities'].forEach((city) => {
                    htmlCode += "<option value='" + city.name + "'>" + city.name + " " + "</option>";
                });
                $("#bank_city").html(htmlCode);
            },
            error: function() {}
        });

    }



    function filtercitiesedit(companyId) {

        console.log($('#editprovince_' + companyId).val(), 'result');

        $.ajax({
            url: '/cities/filtercities',
            method: 'post',
            dataType: 'json',
            data: {
                'province': $('#editprovince_' + companyId).val(),
                'companyId': companyId
            },
            success: function(data) {

                var htmlCode = "";
                $("#editcompany_city_" + companyId).empty();
                console.log(data['cities'], 'citiesdata')

                data['cities'].forEach((city) => {

                    if (data['company'].name == city.name) {

                        htmlCode += "<option selected value='" + city.name + "'>" + city.name + " " + "</option>";

                    } else {
                        htmlCode += "<option value='" + city.name + "'>" + city.name + " " + "</option>";

                    }
                });
                $("#editcompany_city_" + companyId).html(htmlCode);

            },
            error: function() {}
        });


    }

    function filterbankcitiesedit(companyId) {

        console.log($('#editbankprovince_' + companyId).val(), 'result');

        $.ajax({
            url: '/cities/filtercities',
            method: 'post',
            dataType: 'json',
            data: {
                'province': $('#editbankprovince_' + companyId).val(),
                'companyId': companyId
            },
            success: function(data) {
                var htmlCode = "";
                $("#editbank_city_" + companyId).empty();
                console.log(data['cities'], 'citiesdata')
                data['cities'].forEach((city) => {
                    if (data['company'] != null) {
                        if (data['company'].name == city.name) {
                            htmlCode += "<option selected value='" + city.name + "'>" + city.name + " " + "</option>";
                        } else {
                            htmlCode += "<option value='" + city.name + "'>" + city.name + " " + "</option>";
                        }
                    } else {
                        htmlCode += "<option value='" + city.name + "'>" + city.name + " " + "</option>";

                    }

                });
                $("#editbank_city_" + companyId).html(htmlCode);

            },
            error: function() {}
        });


    }


    function updateProfilepic(authuser) {
        var file_data = $("#profilepic").prop("files")[0];
        var form_data = new FormData();
        form_data.append("file", file_data);
        $.ajax({
            url: '/user/updateProfilepic',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data) {
                window.location = '/user/userprofile/' + authuser;
            },


            error: function(a, b, c) {}
        });
    }
</script>
