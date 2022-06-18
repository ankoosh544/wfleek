<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?php

use Cake\I18n\Number;

?>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>--->
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
                    <h3 class="page-title">View</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/<?= $authuser->choosen_companyId ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">View</li>

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
                                        <?php if ($userview->user->profileFilepath != null && $userview->user->profileFilename != null) : ?>
                                            <img alt="" src="<?= $userview->user->profileFilepath ?>/<?= $userview->user->profileFilename ?>">
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
                                            <h3 class="user-name m-t-0 mb-0"><?= $userview->user->firstname ?> <?= $userview->user->lastname ?></h3>

                                            <?php if ($userview->member_role == 'X') : ?>
                                                <h6 class="text-muted">Developer</h6>
                                            <?php elseif ($userview->member_role == 'Z') : ?>
                                                <h6 class="text-muted">Project Manager</h6>
                                            <?php elseif ($userview->member_role == 'Y') : ?>
                                                <h6 class="text-muted">Administrator</h6>
                                            <?php elseif ($userview->member_role == 'W') : ?>
                                                <h6 class="text-muted">Coordinator</h6>
                                            <?php elseif ($userview->member_role == 'H') : ?>
                                                <h6 class="text-muted">HR</h6>
                                            <?php else : ?>
                                                <h6 class="text-muted">Customer</h6>
                                            <?php endif; ?>

                                            <?php if ($userview->user->id != null) : ?>
                                                <div class="staff-id">Employee ID : <?= $userview->user->id ?></div>
                                            <?php endif; ?>
                                            <?php if ($userview->user->registrationDate != null) : ?>
                                                <div class="small doj text-muted">Date of Join :<?= $userview->user->registrationDate ?></div>
                                            <?php endif; ?>
                                            <div class="staff-msg"><a class="btn btn-custom" href="/chats/chatsystem/<?= $userview->user->id ?>">Send Message</a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">First Name:</div>
                                                <div class="text"><a href=""><?= $userview->user->firstname ?></a></div>
                                            </li>
                                            <li>
                                                <div class="title">Last Name:</div>
                                                <div class="text"><a href=""><?= $userview->user->lastname ?></a></div>
                                            </li>
                                            <li>
                                                <?php if ($userview->user->tel != null) : ?>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a href=""><?= $userview->user->tel ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($userview->user->email != null) : ?>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href=""><?= $userview->user->email ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($userview->user->tax_code != null) : ?>
                                                    <div class="title">Codice Fiscale:</div>
                                                    <div class="text"><a href=""><?= $userview->user->tax_code ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <?php if ($userview->user->vat_code != null) : ?>
                                                    <div class="title"> Partita IVA:</div>
                                                    <div class="text"><a href=""><?= $userview->user->vat_code ?></a></div>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <?php if ($userview->user->birthday != null) : ?>
                                                    <div class="text"><?= $userview->user->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></div>
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
                        <li class="nav-item"><a href="#emp_companies" data-toggle="tab" class="nav-link">Companies <small class="text-danger"></small></a></li>
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
                                        <div class="text"><?= $userview->user->firstname ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Last Name</div>
                                        <div class="text"><?= $userview->user->lastname ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Gender</div>
                                        <div class="text"><?= $userview->user->gender ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Tel</div>
                                        <div class="text"><a href=""><?= $userview->user->tel ?></a></div>
                                    </li>
                                    <li>
                                        <div class="title">Email</div>
                                        <div class="text"><a href=""><?= $userview->user->email ?></a></div>
                                    </li>
                                    <li>
                                        <div class="title">Date of Birth</div>
                                        <?php if ($userview->user->birthday != null) : ?>
                                            <div class="text"><a href=""><?= $userview->user->birthday->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></a></div>
                                        <?php else : ?>
                                            <div class="text"><a href=""></a></div>

                                        <?php endif; ?>
                                    </li>
                                    <li>
                                        <div class="title">Address</div>
                                        <div class="text"><?= $userview->user->address ?></div>
                                    </li>
                                    <li>
                                        <div class="title">Country</div>
                                        <div class="text"><?= $userview->user->country ?></div>
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
                    <?php foreach ($viewusercompanies as $company) : ?>
                        <div class="col-md-6 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">

                                    <h3 class="card-title"><a href="/usercompanies/view/<?=$company->usercompany->id?>"> <?= $company->usercompany->name ?> Informations </a> </h3>

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
                                            <?php foreach ($projecttasks as $projecttask) : ?>
                                                <?php if ($projecttask->project_id == $projectObject->id) : ?>
                                                    <?php if ($projecttask->isDeleted == false && $projecttask->status != 'A') : ?>
                                                        <?php if ($projecttask->status == 'T' or $projecttask->status == 'I') : ?>
                                                            <?php $opentask = $opentask + 1;    ?>
                                                        <?php else : ?>
                                                            <?php $completedtask = $completedtask + 1; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
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
                                                <?php foreach ($managers as $manager) : ?>
                                                    <?php if ($manager->projectId == $projectObject->id) : ?>
                                                        <li>
                                                            <a href="#" data-toggle="tooltip" title="<?= $manager->user->firstname ?> <?= $manager->user->lastname ?>">
                                                                <?php if ($manager->user->profileFilepath != null && $manager->user->profileFilename != null) : ?>
                                                                    <img alt="" src="<?= $manager->user->profileFilepath ?>/<?= $manager->user->profileFilename ?>">
                                                                <?php else : ?>
                                                                    <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                <?php endif; ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="project-members m-b-15">
                                            <div>Team :</div>
                                            <ul class="team-members">
                                                <?php foreach ($projectMembers as $projectMember) : ?>
                                                    <?php if ($projectMember->projectId == $projectObject->id) : ?>
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
                                                    <?php endif; ?>
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
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /Projects Tab -->
        </div>
    </div>
    <!-- /Page Content -->



</div>

<!-- /Page Wrapper -->
