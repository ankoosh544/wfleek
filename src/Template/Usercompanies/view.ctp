<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<style>
    .group-post {
        float: right;
    }
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/<?= $companyData->id ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i> Create Project</a>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="/companies-user/addemployees/<?= $companyData->id ?>" class="btn add-btn"><i class="fa fa-plus"></i> Add Employees </a>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_client"><i class="fa fa-plus"></i> Add Clients </a>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="/groups/newgroup/<?= $company_id ?>" class="btn add-btn"> Create Group </a>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->



        <!------Assign Client Modal---->
        <?= $this->element('addclient_tocompany') ?>
        <!------/Assign Client Modal------>



        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <?php if ($companyData->company_logoFilepath != null && $companyData->company_logoFilename != null) : ?>
                                        <a href="#"><img alt="" src="<?= $companyData->company_logoFilepath ?>/<?= $companyData->company_logoFilename ?>"></a>
                                    <?php else : ?>
                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0"><?= $companyData->name ?></h3>
                                            <h6 class="text-muted"><?= $companyData->description ?></h6>
                                            <div class="staff-id">Company ID : <?= $companyData->id ?></div>
                                            <div class="staff-msg"><a class="btn btn-custom" href="/chats/chatsystem/<?= $authuser->user->id ?>">Send Message</a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="personal-info">
                                            <li>
                                                <?php if ($companyData->phone_number != null) : ?>
                                                    <div class="title">Phone:</div>
                                                    <div class="text"><a href=""><?= $companyData->phone_number ?></a></div>
                                                <?php endif; ?>
                                            </li>

                                            <li>
                                                <?php if ($companyData->mobile_number != null) : ?>
                                                    <div class="title">Mobile Number:</div>
                                                    <div class="text"><?= $companyData->mobile_number ?></div>
                                                <?php endif; ?>
                                            </li>


                                            <li>
                                                <?php if ($companyData->email != null) : ?>
                                                    <div class="title">Email:</div>
                                                    <div class="text"><a href=""><?= $companyData->email ?></a></div>

                                                <?php endif; ?>
                                            </li>


                                            <li>
                                                <?php if ($companyData->address != null) : ?>
                                                    <div class="title">Address:</div>
                                                    <div class="text"><?= $companyData->address ?></div>
                                                <?php endif; ?>
                                            </li>

                                            <li>
                                                <?php if ($companyData->website != null) : ?>
                                                    <div class="title">web-site:</div>
                                                    <div class="text"><a href="https://www.socialibreria.com/"><?= $companyData->website ?></a></div>
                                                <?php endif; ?>
                                            </li>

                                            <li>
                                                <div class="title">Contact to:</div>
                                                <div class="text">
                                                    <div class="avatar-box">
                                                        <div class="avatar avatar-xs">
                                                            <img src="<?= $authuser->user->profileFilepath ?>/<?= $authuser->user->profileFilename ?>" alt="">
                                                        </div>
                                                    </div>
                                                    <a href="profile.html"> <?= $authuser->user->firstname ?> <?= $authuser->user->lastname ?></a>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                    <?php if ($authuser->user->id == $user_id || $admin->type == 'Y') : ?>
                                        <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                                    <?php endif; ?>
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
                            <li class="nav-item col-sm-3"><a class="nav-link active" data-toggle="tab" href="#company_projects">Projects</a></li>
                            <li class="nav-item col-sm-3"><a class="nav-link" data-toggle="tab" href="#tasks">Tasks</a></li>
                            <li class="nav-item col-sm-3"><a class="nav-link" data-toggle="tab" href="#employees">Employees</a></li>
                            <li class="nav-item col-sm-3"><a class="nav-link" data-toggle="tab" href="#company_groups">Groups</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content profile-tab-content">

                        <!-- Projects Tab -->
                        <div class="tab-pane fade show active" id="company_projects">
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
                                                        $completedtask = 0;
                                                        foreach ($projectObject->projecttasks as $projecttask) {
                                                            if ($projecttask->status == 'T' or $projecttask->status == 'I') {
                                                                $opentask = $opentask + 1;
                                                            } else {
                                                                $completedtask = $completedtask + 1;
                                                            }
                                                        }
                                                        $totaltasks = $opentask + $completedtask ?>


                                                        <span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span>
                                                        <span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                    <p class="text-muted"><?= nl2br($projectObject->description) ?></p>
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
                                                                <?php if ($manager->type == 'Z') : ?>
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
                                                            <?php foreach ($projectObject->projectmembers as $projectMember) : ?>
                                                                <?php if ($projectMember->type != 'C') : ?>
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
                                                        <select class="select2-icon floating" onchange="updatepriority(<?= $projectObject->id ?>)" id="priority_project_<?= $projectObject->id ?>">
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
                                                        <select class="select2-icon floating" onchange="updatestatus(<?= $projectObject->id ?>)" id="status_project_<?= $projectObject->id ?>">
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

                                        <?php $rendercompanyId = $company_id; ?>
                                        <!--------Edit Project------------------>
                                        <?= $this->element('edit_projectmodal', [
                                            'projectObject' => $projectObject,
                                            'rendercompanyId' => $rendercompanyId

                                        ]) ?>
                                        <!--------/Edit Project------------------>

                                        <!--------Delete Project------------------>

                                        <?= $this->element('delete_projectmodal', [
                                            'projectObject' => $projectObject,
                                            'rendercompanyId' => $rendercompanyId
                                        ]) ?>

                                        <!--------/Delete Project------------------>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                        <!-- /Projects Tab -->



                        <!-- Task Tab -->
                        <div id="tasks" class="tab-pane fade">
                            <div class="project-task">
                                <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                                    <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">All Tasks</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="all_tasks">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    <ul id="task-list">
                                                        <?php if ($projectObjects != null) : ?>
                                                            <?php foreach ($projectObjects as $projectObject) : ?>
                                                                <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                                    <?php if ($projecttask->status == 'D' && $projecttask->type == "TS") : ?>
                                                                        <li class="completed task">
                                                                            <div class="task-container">
                                                                                <span class="task-action-btn task-check">
                                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                        <i class="material-icons">check</i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="task-label"><?= $projecttask->title ?></span>
                                                                                <span class="task-action-btn task-btn-right">
                                                                                    <span class="action-circle large" title="Assign">
                                                                                        <i class="material-icons">person_add</i>
                                                                                    </span>
                                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                                        <i class="material-icons">delete</i>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                    <?php else : ?>
                                                                        <li class="task">
                                                                            <div class="task-container">
                                                                                <span class="task-action-btn task-check">
                                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                        <i class="material-icons">check</i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="task-label" contenteditable="true"><?= $projecttask->title ?></span>
                                                                                <span class="task-action-btn task-btn-right">
                                                                                    <span class="action-circle large" title="Assign">
                                                                                        <i class="material-icons">person_add</i>
                                                                                    </span>
                                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                                        <i class="material-icons">delete</i>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                                <div class="task-list-footer">
                                                    <div class="new-task-wrapper">
                                                        <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                                        <span class="error-message hidden">You need to enter a task first</span>
                                                        <span class="add-new-task-btn btn" id="add-task">Add Task</span>
                                                        <span class="btn" id="close-task-panel">Close</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pending_tasks">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    <ul id="task-list">
                                                        <?php if ($projectObjects != null) : ?>
                                                            <?php foreach ($projectObjects as $projectObject) : ?>
                                                                <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                                    <?php if ($projecttask->status != 'D' && $projecttask->type == "TS") : ?>
                                                                        <li class="task">
                                                                            <div class="task-container">
                                                                                <span class="task-action-btn task-check">
                                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                        <i class="material-icons">check</i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="task-label" contenteditable="true"><?= $projecttask->title ?></span>
                                                                                <span class="task-action-btn task-btn-right">
                                                                                    <span class="action-circle large" title="Assign">
                                                                                        <i class="material-icons">person_add</i>
                                                                                    </span>
                                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                                        <i class="material-icons">delete</i>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="completed_tasks">
                                        <div class="task-wrapper">
                                            <div class="task-list-container">
                                                <div class="task-list-body">
                                                    <ul id="task-list">
                                                        <?php if ($projectObjects != null) : ?>
                                                            <?php foreach ($projectObjects as $projectObject) : ?>
                                                                <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                                    <?php if ($projecttask->status == 'D'  && $projecttask->type == "TS") : ?>
                                                                        <li class="completed task">
                                                                            <div class="task-container">
                                                                                <span class="task-action-btn task-check">
                                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                        <i class="material-icons">check</i>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="task-label" contenteditable="true"><?= $projecttask->title ?></span>
                                                                                <span class="task-action-btn task-btn-right">
                                                                                    <span class="action-circle large" title="Assign">
                                                                                        <i class="material-icons">person_add</i>
                                                                                    </span>
                                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                                        <i class="material-icons">delete</i>
                                                                                    </span>
                                                                                </span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Task Tab -->

                        <!--Employees Tab--->
                        <div class="tab-pane" id="employees">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table">
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
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="/user/view/<?= $companymember->user->id ?>" class="avatar">
                                                            <?php if ($companymember->user->profileFilepath != null && $companymember->user->profileFilename != null) : ?>
                                                                <img src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>" alt="">
                                                            <?php else : ?>
                                                            <?php endif; ?>
                                                        </a>
                                                        <a href="/user/view/<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?> <span><?= $companymember->designation->name ?></span></a>
                                                    </h2>
                                                </td>
                                                <td><?= $companymember->user->email ?></td>
                                                <td><?= $companymember->usercompany->name ?></td>
                                                <td>1 Jan 2013</td>
                                                <td>
                                                    <span class="badge bg-inverse-danger"><?= $companymember->designation->name ?></span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="/user/view/<?= $companymember->user->id ?>"><i class="fa fa-eye m-r-5"></i> View</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user_<?= $companymember->user->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!----------Delete User Modal---------->
                                            <?php $user_companyId = $company_id; ?>

                                            <?= $this->element('delete_user', [
                                                'companymember' => $companymember,
                                                'user_companyId' => $user_companyId

                                            ]) ?>
                                            <!-----/Delete User Modal------------------->

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="tab-pane fade show" id="company_groups">

                            <div class="row" style="justify-content: center;">
                                <div class="col-lg- col-md-8">
                                    <div class="dash-sidebar">
                                        <section>
                                            <h5 class="dash-title"></h5>
                                            <?php if ($allcompanygroups != null) : ?>
                                                <?php foreach ($allcompanygroups as $companygroup) : ?>

                                                    <div class="card" style="background-color: #ded7d7;">
                                                        <div class="card-body">
                                                            <div class="dropdown kanban-action group-post">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board"><i class="fa fa-pencil m-r-5"></i>Edit</a>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_group_<?= $companygroup->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                            <?= $this->element('delete_companygroup', [
                                                                'companygroup' => $companygroup,
                                                            ]) ?>

                                                            <div class="form-group">
                                                                <a href="/groups/view/<?= $companygroup->id ?>">
                                                                    <h3><?= $companygroup->name ?></h3>
                                                                </a>
                                                                <p><span><img src="/assets/img/lock-in-a-circle.png" alt="" style="width: 25px;"></span> Private group</p>
                                                                <p><span><img src="/assets/img/group.png" alt="" style="width: 25px;"></span><?= count($companygroup->groupmembers) ?> Members</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/Employees Tab---->

                    </div>
                </div>
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
                        <form action="/usercompanies/updatecompanyinfo/<?= $companyData->id ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">

                                        <?php if ($companyData->company_logoFilepath != null && $authuser->user->company_logoFilename != null) : ?>
                                            <img class="inline-block" src="<?= $companyData->company_logoFilepath ?>/<?= $companyData->company_logoFilename ?>" alt="">
                                        <?php else : ?>
                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                        <?php endif; ?>
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="userIMG" name="profilepic" type="file" onchange="validateFileSize(); return false;" multiple />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" class="form-control" name="company_name" value="<?= $companyData->name ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Name</label>
                                                <input type="text" class="form-control" name="businessname" value="<?= $companyData->businessname ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fiscal Code</label>
                                                <input type="text" class="form-control" name="fiscal_code" value="<?= $companyData->fiscal_code ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Vat Code</label>
                                                <input type="text" class="form-control" name="vat_code" value="<?= $companyData->vat_code ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="company_description" id="" row="5"><?= $companyData->description ?></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="container">
                                <label>Address</label>
                                <label>Company Address</label>
                                <input class="form-control" type="text" name="company_address" value="<?= $companyData->address ?>">
                                </br>
                                <div class="row">
                                    <div class="form-group col">
                                        <label><?= __('Stato') ?><span class="text-danger">*</span></label>
                                        <select class="form-control select" name="country">
                                            <option selected value="ITALIA"><?= __('Italia') ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col">
                                        <label><?= __('Province') ?><span class="text-danger">*</span></label>
                                        <select class="select2-icon floating" id="editprovince_<?= $companyData->id ?>" name="province" onchange="filtercitiesedit(<?= $companyData->id ?>)">
                                            <?php foreach ($cities as $city) : ?>
                                                <?php if ($companyData->province == $city->province) : ?>
                                                    <option selected value="<?= $city->province ?>"><?= $city->province ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $city->province ?>"><?= $city->province ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col">
                                        <label><?= __('Città') ?><span class="text-danger">*</span></label>
                                        <select class="select2-icon floating" name="city" id="editcompany_city_<?= $companyData->id ?>">
                                            <?php foreach ($cities as $city) : ?>
                                                <?php if ($companyData->city == $city->name) : ?>
                                                    <option selected value="<?= $city->name ?>"><?= $city->name ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $city->name ?>"><?= $city->name ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col">
                                        <label>Postal Code</label>
                                        <input type="number" id="editcompany_postalcode_<?= $companyData->id ?>" name="postalcode" value="<?= $companyData->postal_code ?>" onkeyup="checkpostalcodeedit(<?= $companyData->id ?>); return false;">
                                        <span style="color: red;" id="editpostalcode_errormessage_<?= $companyData->id ?>"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                <input type="hidden" value="<?= $companyData->id ?>" name="companyId">
                                <input type="hidden" value="<?= $companyData->id ?>" name="companyprofile">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Project Modal -->

        <?php $keyforrender = $company_id; ?>

        <?= $this->element('create_projectmodal', [
            'companymembers' => $companymembers,
            'keyforrender' => $keyforrender
        ]) ?>
        <!-- /Create Project Modal -->



        <!-- Add Company Modal -->
        <div id="add_company" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <form method="post" action="/usercompanies/add">
                            <div class="form-control col">
                                <label>Company Name</label>
                                <input class="form-control" type="text" name="company_name">
                            </div>
                            </br>
                            <div class="container">
                                <label>Address</label>

                                <label>Company Address</label>
                                <input class="form-control" type="text" name="company_address">

                                <div class="row">
                                    <div class="form-control col">
                                        <label>Country</label>
                                        <input class="form-control" type="text" name="country">
                                    </div>
                                    <div class="form-control col">
                                        <label>City</label>
                                        <input class="form-control" type="text" name="city">
                                    </div>
                                    <div class="form-control col">
                                        <label>State/Province</label>
                                        <input class="form-control" type="text" name="state">

                                    </div>
                                    <div class="form-control col">
                                        <label>Postal Code</label>
                                        <input class="form-control" type="number" name="postalcode">
                                    </div>
                                </div>
                            </div>
                            </br>

                            <div class="form-control col">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email">
                            </div>
                            </br>
                            <div class="form-control col">
                                <label>Phone Number</label>
                                <input class="form-control" type="number" name="phonenumber">
                            </div>
                            </br>
                            <div class="form-control col">
                                <label>Mobile Number</label>
                                <input class="form-control" type="text" name="mobilenumber">
                            </div>

                            <div class="form-control col">
                                <label>IBAN</label>
                                <input class="form-control" type="text" name="iban">
                            </div>
                            <div class="form-control col">
                                <label>Website Link</label>
                                <input class="form-control" type="text" name="weblink">
                            </div>

                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>



                    </div>

                </div>
            </div>
        </div>
        <!-- /Add Ticket Modal -->

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

        $(function() {
            $(document).ready(function() {

                $("#create_expirydate").datetimepicker().on('dp.change', function() {
                    $('#ptagerrorMessage').remove();

                    //var expiry_date = $("#create_expirydate").val();
                    var splittedDate = $("#create_expirydate").val().split("/");
                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                    var createExpiryDate = new Date(dateToString);

                    var todaydate = $("#currentdate").val();


                    createExpiryDate < (new Date())
                    if (createExpiryDate < (new Date())) {


                        $('#errormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to current date</p>');

                    }
                });
            });
        });

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

        function inviteMembersforcompany(companyId) {
            var tag = $('#selecteddesignation').val();
            var form_data = new FormData();
            form_data.append("tagvalues", JSON.stringify(values));
            form_data.append("tag", tag);
            form_data.append("companyId", companyId);

            $.ajax({
                url: '/companiesuser/invitemembers/',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    location.reload();
                },
                error: function(e) {}
            });

        }



        function filtertags() {
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
        }

        // multi values, with last selected

        var values;
        $(".multiselector").on("select2:select", function(event) {
            values = [];
            // copy all option values from selected
            $(event.currentTarget).find("option:selected").each(function(i, selected) {
                values[i] = parseInt($(selected).val());
                console.log('hi alltasks', values)
            });
        });

        function inviteclients(companyId) {
            var client = $('#selectedclient').val();

            var tag = $('#clientdesignation').val();
            var form_data = new FormData();
            form_data.append("client", client);
            form_data.append("tag", tag);
            form_data.append("companyId", companyId);

            $.ajax({
                url: '/companies-user/addclients/',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    location.reload();
                },
                error: function(e) {}
            });

        }
    </script>
