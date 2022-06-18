<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

<style>
    .atagcss {
        cursor: pointer;
    }
</style>
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
            <?php foreach ($authcompanymember->designation->usermodulepermissions as $projectmodule) : ?>
                <?php if ($projectmodule->module->name == 'Projects' && ($projectmodule->isAccessed && $projectmodule->isRead == true)) : ?>

                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title"><?= $projectObject->name ?></h3>
                                <input type="hidden" id="projectID" value="<?= $projectObject->id ?>">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Task Board</li>
                                </ul>

                                <div class="col-auto float-right">
                                    <div class="dropdown action-label">
                                        <a href="#" class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Select Group </a>
                                        <div class="dropdown-menu">
                                            <?php foreach ($projectObject->taskgroups as $group) : ?>
                                                <a class="dropdown-item" href="/projecttasks/grouptasks?group_id=<?= $group->id ?>&pid=<?= $projectObject->id ?>"><?= $group->title ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto float-right ml-auto">
                                    <a href="/project-object/view/<?= $projectObject->id ?>" class="btn add-btn float-right" title="View Board"><i class="fa fa-link"></i> View Board</a>
                                </div>

                                <?php if ($data2->designation->name == 'Customer' || $data2->designation->name == 'Administrator') : ?>
                                    <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                                        <?php foreach ($authcompanymember->designation->usermodulepermissions as $ticketmodule) : ?>
                                            <?php if ($ticketmodule->module->name == 'Tickets' && $ticketmodule->isAccessed && $ticketmodule->isRead == true && $ticketmodule->isCreate == true) : ?>
                                                <div class="col-auto float-right ml-auto">
                                                    <a href="/projecttasks/newticket?pid=<?= $projectObject->id ?>&&taskboard=<?= $projectObject->id ?>" class="btn add-btn"><i class="fa fa-plus"></i> Add Ticket</a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if ($projectmodule->isWrite == true) : ?>
                                        <div class="col-auto float-right ml-auto">
                                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i> Add Group</a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                                    <?php foreach ($authcompanymember->designation->usermodulepermissions as $taskmodule) : ?>
                                        <?php if ($taskmodule->module->name == 'Tasks' && $taskmodule->isAccessed && $taskmodule->isRead == true && $taskmodule->isCreate == true) : ?>
                                            <div class="col-auto float-right ml-auto">
                                                <a class="btn add-btn" data-toggle="modal" data-target="#add_task_modal"><i class="fa fa-plus"></i> Add Task</a>
                                            </div>
                                            <?php if ($data2->designation->name == 'Developer' || $data2->designation->name == 'Administrator' || $data2->designation->name == 'Project Manager') : ?>
                                                <div class="col-auto float-right ml-auto">
                                                    <a class="btn add-btn float-right ml-2" data-toggle="modal" data-target="#create_epictask_modal"><i class="fa fa-plus"></i> Create Epic-Task</a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="col-auto float-right ml-auto">
                                    <a href="/projecttasks/recyclebin/<?= $projectObject->id ?>" class="btn add-btn float-right">
                                        <span class="iconify" data-icon="icomoon-free:bin" data-inline="false"> </span> Recycle-Bin
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->

                    <div class="row board-view-header">
                        <div class="col-4">
                            <div class="pro-teams">
                                <div class="pro-team-lead">
                                    <h4>Lead</h4>
                                    <div class="avatar-group">
                                        <?php foreach ($projectObject->projectmembers as $manager) : ?>
                                            <?php if ($manager->designation->name == 'Project Manager') : ?>
                                                <div class="avatar">

                                                    <img data-toggle="tooltip" title="<?= $manager->user->firstname ?> <?= $manager->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" <?php if ($manager->user->profileFilename != null && $manager->user->profileFilepath != null) : ?>src="<?= $manager->user->profileFilepath ?>/<?= $manager->user->profileFilename ?>" <?php else : ?>src="/assets/img/profiles/avatar-12.jpg" <?php endif; ?>>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <div class="avatar">
                                            <?php if ($projectmodule->isWrite == true) : ?>
                                                <a href="" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_leader"><i class="fa fa-plus"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-team-members">
                                    <h4>Team</h4>
                                    <div class="avatar-group">
                                        <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                            <div class="avatar">
                                                <img data-toggle="tooltip" title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" <?php if ($projectmember->user->profileFilepath != null && $projectmember->user->profileFilename != null) : ?> src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>" <?php else : ?> src="/assets/img/profiles/avatar-12.jpg">
                                            <?php endif; ?>
                                            >
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="avatar">
                                            <?php if ($projectmodule->isWrite == true) : ?>
                                                <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_user"><i class="fa fa-plus"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $opentask = 0;
                        $completedtask = 0;
                        foreach ($projectObject->projecttasks as $task) {
                            if ($task->status != 'A' && ($task->status == 'T' || $task->status == 'I')) {
                                $opentask = $opentask + 1;
                            } else {
                                $completedtask = $completedtask + 1;
                            }
                        }
                        $totaltasks = $opentask + $completedtask;
                        ?>
                        <div class="col-12">
                            <div class="pro-progress">
                                <div class="pro-progress-bar">
                                    <h4>Progress</h4>
                                    <?php if ($totaltasks != 0) : ?>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= round($completedtask / ($totaltasks) * 100); ?>%"></div>
                                        </div>
                                        <span><?= round($completedtask / ($totaltasks) * 100); ?>%</span>
                                    <?php else : ?>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <span>0%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                        <?php foreach ($authcompanymember->designation->usermodulepermissions as $taskmodule) : ?>
                            <?php if ($taskmodule->module->name == 'Tasks' && $taskmodule->isAccessed && $taskmodule->isRead == true) : ?>
                                <div class="kanban-board card mb-0">
                                    <div class="card-body">
                                        <div class="kanban-cont">
                                            <!----TO DO ------>
                                            <div class="kanban-list kanban-danger">
                                                <div class="kanban-header">
                                                    <span class="status-title">ToDo</span>

                                                    <div class="dropdown kanban-action">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kanban-wrap">
                                                    <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                        <?php if ($projecttask->status == 'T') : ?>
                                                            <div class="card panel taskelement" id="<?= $projecttask->id ?>">
                                                                <?php if ($data2->type == 'C' &&  $projecttask->type == 'TC') : ?>
                                                                    <div class="kanban-box">
                                                                        <div class="task-board-header">
                                                                            <span class="status-title">
                                                                                <a class="atagcss" href="/projecttasks/taskview/<?= $projecttask->id ?>">
                                                                                    <h4><?= $projecttask->title ?></h4>
                                                                                </a>
                                                                            </span>
                                                                            <?php if ($data2->type == 'Y') : ?>
                                                                                <div class="dropdown kanban-task-action">
                                                                                    <a href="" data-toggle="dropdown">
                                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                                    </a>
                                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                                        <a href="/projecttasks/modify?taskId=<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block " type="submit">Modify</a>
                                                                                        <a href="/projecttasks/delete?taskId=<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</a>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="task-board-body">
                                                                            <div class="kanban-info">
                                                                                <div class="progress progress-xs">
                                                                                    <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                                <span>0%</span>
                                                                            </div>
                                                                            <div class="kanban-footer">
                                                                                <span class="task-info-cont">
                                                                                    <?php if ($task->expiration_date != null) : ?>
                                                                                        <span class="task-date"><i class="fa fa-clock-o"></i>
                                                                                            <?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                                                                        </span>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($task->priority == 'H') : ?>
                                                                                        <span class="task-priority badge bg-inverse-danger">High</span>
                                                                                    <?php elseif ($task->priority == 'M') : ?>
                                                                                        <span class="task-priority badge bg-inverse-warning">Normal</span>
                                                                                    <?php else : ?>
                                                                                        <span class="task-priority badge bg-inverse-warning">Low</span>
                                                                                    <?php endif; ?>
                                                                                </span>
                                                                                <span class="task-users">
                                                                                    <img src="/assets/img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24" alt="">
                                                                                    <div class="avatar">
                                                                                        <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_user"><i class="fa fa-plus"></i></a>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php else : ?>
                                                                    <div class="kanban-box">
                                                                        <div class="task-board-header">
                                                                            <span class="status-title">
                                                                                <a class="atagcss" href="/projecttasks/taskview/<?= $projecttask->id ?>">
                                                                                    <h4><?= $projecttask->title ?></h4>
                                                                                </a>
                                                                            </span>
                                                                            <div class="dropdown kanban-task-action">
                                                                                <a href="" data-toggle="dropdown">
                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a href="/projecttasks/modify?taskId=<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block " type="submit">Modify</a>
                                                                                    <a data-toggle="modal" data-target="#delete_task_<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Delete Ticket Modal -->
                                                                        <?= $this->element('delete_task', [
                                                                            'ticket' => $projecttask,
                                                                        ]) ?>
                                                                        <!-- /Delete Ticket Modal -->
                                                                        <div class="task-board-body">
                                                                            <div class="kanban-info">
                                                                                <div class="progress progress-xs">
                                                                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                                <span>0%</span>
                                                                            </div>
                                                                            <div class="kanban-footer">
                                                                                <span class="task-info-cont">
                                                                                    <?php if ($projecttask->expiration_date != null) : ?>
                                                                                        <span class="task-date"><i class="fa fa-clock-o"></i><?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($projecttask->priority == 'H') : ?>
                                                                                        <span class="task-priority badge bg-inverse-danger">High</span>
                                                                                    <?php elseif ($projecttask->priority == 'M') : ?>
                                                                                        <span class="task-priority badge bg-inverse-warning">Normal</span>
                                                                                    <?php else : ?>
                                                                                        <span class="task-priority badge bg-inverse-warning">Low</span>
                                                                                    <?php endif; ?>
                                                                                </span>
                                                                                <span class="task-users">
                                                                                    <?php foreach ($projecttask->taskusers as $taskuser) : ?>
                                                                                        <img data-toggle="tooltip" title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>" class="task-avatar" width="24" height="24" alt="">
                                                                                    <?php endforeach; ?>
                                                                                    <div class="avatar">
                                                                                        <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#update_taskusers_<?= $projecttask->id ?>"><i class="fa fa-plus"></i></a>
                                                                                    </div>
                                                                                    <!-------------------------------Assign User for Task------------------------------------->

                                                                                    <?= $this->element('update_taskusers', [
                                                                                        'projecttask' => $projecttask
                                                                                    ]) ?>
                                                                                    <!-- /Assign User Modal -->
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>

                                                </div>
                                                <div class="add-new-task">
                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_task_modal">Add New Task</a>
                                                </div>
                                            </div>
                                            <!----/TO DO ------>

                                            <?php if ($data2->type != 'C') : ?>
                                                <!----------In-Progress---------->
                                                <div class="kanban-list kanban-info">
                                                    <div class="kanban-header">
                                                        <span class="status-title">InProgress</span>
                                                        <div class="dropdown kanban-action">
                                                            <a href="" data-toggle="dropdown">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>
                                                                <a class="dropdown-item" href="#">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="kanban-wrap">
                                                        <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                            <?php if ($projecttask->status == 'I') : ?>
                                                                <div class="card panel taskelement" id="<?= $projecttask->id ?>">
                                                                    <div class="kanban-box">
                                                                        <div class="task-board-header">
                                                                            <span class="status-title">
                                                                                <a class="atagcss" href="/projecttasks/taskview/<?= $projecttask->id ?>">
                                                                                    <h4><?= $projecttask->title ?></h4>
                                                                                </a>
                                                                            </span>
                                                                            <div class="dropdown kanban-task-action">
                                                                                <a href="" data-toggle="dropdown">
                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a href="/projecttasks/modify?taskId=<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block " type="submit">Modify</a>
                                                                                    <a data-toggle="modal" data-target="#delete_task_<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Delete Ticket Modal -->
                                                                        <?= $this->element('delete_task', [
                                                                            'ticket' => $projecttask,
                                                                        ]) ?>
                                                                        <!-- /Delete Ticket Modal -->
                                                                        <div class="task-board-body">
                                                                            <div class="kanban-info">
                                                                                <div class="progress progress-xs">
                                                                                    <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                </div>
                                                                                <span>50%</span>
                                                                            </div>
                                                                            <div class="kanban-footer">
                                                                                <span class="task-info-cont">
                                                                                    <span class="task-date"><i class="fa fa-clock-o"></i> Sep 26</span>
                                                                                    <?php if ($projecttask->priority == 'H') : ?>
                                                                                        <span class="task-priority badge bg-inverse-danger">High</span>
                                                                                    <?php elseif ($projecttask->priority == 'M') : ?>
                                                                                        <span class="task-priority badge bg-inverse-warning">Normal</span>
                                                                                    <?php else : ?>
                                                                                        <span class="task-priority badge bg-inverse-warning">Low</span>
                                                                                    <?php endif; ?>
                                                                                </span>
                                                                                <span class="task-users">
                                                                                    <?php foreach ($projecttask->taskusers as $taskuser) : ?>
                                                                                        <img data-toggle="tooltip" title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>" class="task-avatar" width="24" height="24" alt="">
                                                                                    <?php endforeach; ?>

                                                                                    <div class="avatar">
                                                                                        <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#update_taskusers_<?= $projecttask->id ?>"><i class="fa fa-plus"></i></a>
                                                                                    </div>
                                                                                    <!-------------------------------Assign User for Task------------------------------------->
                                                                                    <?= $this->element('update_taskusers', [
                                                                                        'projecttask' => $projecttask
                                                                                    ]) ?>
                                                                                    <!-- /Assign User Modal -->

                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <!----------/In-Progress---------->
                                            <?php endif; ?>

                                            <!------------Completed-------------->
                                            <div class="kanban-list kanban-success">
                                                <div class="kanban-header">
                                                    <span class="status-title">Completed</span>
                                                    <div class="dropdown kanban-action">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="kanban-wrap ks-empty">
                                                    <?php foreach ($projectObject->projecttasks as $projecttask) : ?>
                                                        <?php if ($projecttask->status == 'D') : ?>
                                                            <div class="card panel taskelement" id="<?= $projecttask->id ?>">
                                                                <div class="kanban-box">
                                                                    <div class="task-board-header">
                                                                        <span class="status-title">
                                                                            <a class="atagcss" href="/projecttasks/taskview/<?= $projecttask->id ?>">
                                                                                <h4><?= $projecttask->title ?></h4>
                                                                            </a>
                                                                        </span>
                                                                        <div class="dropdown kanban-task-action">
                                                                            <a href="" data-toggle="dropdown">
                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a href="/projecttasks/modify?taskId=<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block " type="submit">Modify</a>
                                                                                <a data-toggle="modal" data-target="#delete_task_<?= $projecttask->id ?>" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Delete Ticket Modal -->
                                                                    <?= $this->element('delete_task', [
                                                                        'ticket' => $projecttask,
                                                                    ]) ?>
                                                                    <!-- /Delete Ticket Modal -->
                                                                    <div class="task-board-body">
                                                                        <div class="kanban-info">
                                                                            <div class="progress progress-xs">
                                                                                <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                            </div>
                                                                            <span>100%</span>
                                                                        </div>
                                                                        <div class="kanban-footer">
                                                                            <span class="task-info-cont">
                                                                                <?php if ($projecttask->expiration_date != null) : ?>
                                                                                    <span class="task-date"><i class="fa fa-clock-o"></i><?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
                                                                                <?php endif; ?>
                                                                                <span class="task-priority badge bg-success">completed</span>
                                                                            </span>
                                                                            <span class="task-users">
                                                                                <?php foreach ($projecttask->taskusers as $taskuser) : ?>
                                                                                    <img data-toggle="tooltip" title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" src="/assets/img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24" alt="">
                                                                                <?php endforeach; ?>

                                                                                <div class="avatar">
                                                                                    <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#update_taskusers_<?= $projecttask->id ?>"><i class="fa fa-plus"></i></a>
                                                                                </div>
                                                                                <!-------------------------------Assign User for Task------------------------------------->
                                                                                <?= $this->element('update_taskusers', [
                                                                                    'projecttask' => $projecttask
                                                                                ]) ?>
                                                                                <!-- /Assign User Modal -->
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>

                                            </div>
                                            <!-----------/Completed------------------->


                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-----All modals---------------------->

        <!-- Assign Leader Modal -->
        <?= $this->element('assign_projectleader') ?>
        <!-- /Assign Leader Modal -->

        <!----------Assign User to Project------------->
        <?= $this->element('assign_users') ?>
        <!----------/Assign User to Project--------------->


        <!----------Create Task modal------------->
        <?= $this->element('create_taskmodal') ?>
        <!----------/Create Task modal--------------->

        <!--------Create Epic Task modal------------>
        <?= $this->element('create_epictask') ?>
        <!--------/Create Epic Task modal-------------->



        <!-- Add Group Modal -->
        <?= $this->element('create_taskgroup') ?>
        <!---/ Add Group Modal--->


        <!-----/All modals------>
    </div>
    <!-- /Page Content -->
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    $(function() {
        $(document).ready(function() {
            var commentvalue = false;
            var replay = 0;
            //groupstart date
            $("#groupstartdate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();
                var splittedDate = $("#groupstartdate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                var startdate = moment(dateToString).format("YYYY-MM-DD");
                var todaydate = moment().format("YYYY-MM-DD");

                if ((startdate) < (todaydate)) {
                    $('#errormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Start Date must be Greater than or equal to current date</p>');
                }
            });

            // group expiry date
            $("#groupexpirydate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();
                var startdate = $("#groupstartdate").val().split("/");
                var datetostringstartdate = startdate[2] + "-" + startdate[1] + "-" + startdate[0];
                var splittedDate = $("#groupexpirydate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var groupexpirydate = new Date(dateToString);
                if (groupexpirydate > (new Date())) {
                    if (groupexpirydate < (new Date(datetostringstartdate)))
                        $('#errorgroupexpirymessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date Must be Greater than Start Date</p>');
                } else {
                    $('#errorgroupexpirymessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to current date</p>');
                }
            });


            //ticket startdate
            $('#addticketstartdate').on('dp.change', function(ev) {
                var ts = $('#addticketstartdate').val();
                $.ajax({
                    url: '/projecttasks/checkstartdate',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'groupid': $('#addticketgrouptype').val()
                    },
                    success: function(data) {
                        var error = "";
                        var splittedDate = ts.split("/");
                        var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                        if ((new Date(dateToString)) > (new Date())) {
                            if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                console.log('Valid Date');
                            } else {
                                error = "Invalid Date";
                            }
                        } else {
                            error = "Start date should be greater than today Date";
                        }
                        $('#ticketstartdateMsg').html(error);
                    },
                    error: function() {}
                });

            });

            //ticket expirydate
            $('#addticketexpirydate').on('dp.change', function(ev) {
                var ts = $('#addticketexpirydate').val();
                var str = $('#addticketstartdate').val();
                var exp = $('#addticketexpirydate').val();
                $.ajax({
                    url: '/projecttasks/checkexpirydate',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'groupid': $('#addticketgrouptype').val(),

                    },
                    success: function(data) {
                        var error = "";
                        var splittedstartDate = str.split("/");
                        var splittedexpiryDate = exp.split("/");
                        var startdateToString = splittedstartDate[2] + "-" + splittedstartDate[1] + "-" + splittedstartDate[0];
                        var expirydateToString = splittedexpiryDate[2] + "-" + splittedexpiryDate[1] + "-" + splittedexpiryDate[0];
                        if (new Date(expirydateToString) >= new Date(startdateToString)) {
                            if (((new Date(data.startdate)) <= (new Date(expirydateToString))) && ((new Date(data.expirydate)) >= (new Date(expirydateToString)))) {} else {
                                error = 'ExpiryDate Invalid';
                            }
                        } else {
                            error = 'ExpiryDate not Lessthan StartDate';
                        }
                        $('#addticketexpirydateMsg').html(error);
                    },
                    error: function() {}
                });

            });

            $(function() {
                if ($('.kanban-wrap').length > 0) {
                    $('.kanban-wrap').sortable({
                        connectWith: ".kanban-wrap",
                        handle: ".kanban-box",
                        placeholder: "drag-placeholder",
                        //  axis: 'y',
                        stop: function(event, ui) {
                            console.log($(this), 'thid');
                            var data = $(this).sortable('toArray');
                            $.ajax({
                                data: {
                                    'data': data,
                                },
                                type: 'POST',
                                url: '/projecttasks/updateindex',
                            });
                        }
                    });
                }

                $(".kanban-wrap").draggable();
                $(".kanban-list").droppable({
                    drop: function(event, ui) {
                        var draggableId = $(ui.draggable).attr('id');
                        var status = this.children[0].innerText;
                        projectID = $('#projectID').val();
                        $.ajax({
                            url: '/projecttasks/checktype',
                            method: 'post',
                            dataType: 'json',
                            data: {
                                'taskId': draggableId,
                                'pid': projectID
                            },
                            success: function(data) {
                                if (data['RESULT'] == "ERROR") {
                                    alert(data['MESSAGE']);
                                    window.location = '/project-object/taskboard/' + projectID

                                } else {
                                    if (status == 'ToDo') {
                                        status = 'T';
                                    } else if (status == 'InProgress') {
                                        status = 'I';
                                    } else {
                                        status = 'D';
                                    }
                                    $.ajax({
                                        url: '/projecttasks/changestatus',
                                        method: 'post',
                                        dataType: 'json',
                                        data: {
                                            'status': status,
                                            'taskId': draggableId
                                        },
                                        success: function(data) {
                                            window.location = '/project-object/taskboard/' + projectID
                                        },
                                        error: function(e) {}
                                    });
                                }
                            },
                            error: function(e) {}
                        });


                    }
                });
            });



            $.ajax({
                url: '/projecttasks/docalltasks',
                dataType: 'json',
                success: function(data) {
                    data.forEach((task) => {

                        //updatestartdate
                        $('#editstartdateTodo_' + task.id).on('dp.change', function(ev) {
                            var ts = $('#editstartdateTodo_' + task.id).val();
                            $.ajax({
                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptype_' + task.id).val()
                                },
                                success: function(data) {
                                    //draggable operations  event.target.children[1]
                                    var error = "";
                                    var splittedDate = ts.split("/");
                                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                                    new Date(dateToString)
                                    if (new Date(dateToString) > new Date()) {
                                        if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                            console.log('Valid Date');
                                        } else {
                                            error = "Invalid Date";
                                        }
                                    } else {
                                        error = " Date should be greater than todate Invalid Date";
                                    }
                                    $('#errorstartdateMsg_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });

                        //updateexpirydate
                        $('#editexpirydateTodo_' + task.id).on('dp.change', function(ev) {
                            var ts = $('#editexpirydateTodo_' + task.id).val();
                            var str = $('#editstartdateTodo_' + task.id).val();
                            $.ajax({
                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptype_' + task.id).val()

                                },
                                success: function(data) {
                                    var error = "";
                                    var splittedDate = ts.split("/");
                                    var startdate = str.split("/");
                                    var dateToStringStartdate = startdate[2] + "-" + startdate[1] + "-" + startdate[0];
                                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                                    if (new Date(dateToString) > new Date(dateToStringStartdate)) {
                                        if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                            console.log('Valid Date');
                                        } else {
                                            error = "Invalid Date";
                                        }
                                    } else {
                                        error = " Date should be greater than Startdate Invalid Date";
                                    }
                                    $('#errorexpirydateMsg_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });


                        //inprogress updatedate system

                        //updatestartdate
                        $('#editstartdateinpro_' + task.id).on('dp.change', function(ev) {
                            var ts = $('#editstartdateinpro_' + task.id).val();
                            console.log(ts)
                            $.ajax({
                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptypeinpro_' + task.id).val()
                                },
                                success: function(data) {
                                    console.log(data);
                                    var error = "";
                                    console.log(ts, 'task start date');
                                    var splittedDate = ts.split("/");
                                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                                    new Date(dateToString)
                                    if (new Date(dateToString) > new Date()) {
                                        if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                            console.log('Valid Date');
                                        } else {
                                            error = "Invalid Date";
                                        }
                                    } else {
                                        error = " Date should be greater than todate Invalid Date";
                                    }
                                    $('#errorstartdateMsginpro_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });

                        //updateexpirydate
                        $('#editexpirydateinpro_' + task.id).on('dp.change', function(ev) {


                            var ts = $('#editexpirydateinpro_' + task.id).val();
                            var str = $('#editstartdateinpro_' + task.id).val();
                            console.log(ts)

                            $.ajax({

                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptypeinpro_' + task.id).val()

                                },
                                success: function(data) {
                                    console.log(data);
                                    var error = "";
                                    console.log(ts, 'task expiry date');
                                    var splittedDate = ts.split("/");
                                    var startdate = str.split("/");
                                    var dateToStringStartdate = startdate[2] + "-" + startdate[1] + "-" + startdate[0];
                                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                                    if (new Date(dateToString) > new Date(dateToStringStartdate)) {
                                        if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                            console.log('Valid Date');
                                        } else {
                                            error = "Invalid Date";
                                        }
                                    } else {
                                        error = " Date should be greater than Startdate Invalid Date";
                                    }
                                    $('#errorexpirydateMsginpro_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });

                        //done updatetask date system

                        //updatestartdate
                        $('#editstartdatedone_' + task.id).on('dp.change', function(ev) {
                            var ts = $('#editstartdatedone_' + task.id).val();
                            console.log(ts)
                            $.ajax({
                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptypedone_' + task.id).val()
                                },
                                success: function(data) {
                                    console.log(data);
                                    var error = "";
                                    console.log(ts, 'task start date');
                                    var splittedDate = ts.split("/");
                                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                                    new Date(dateToString)
                                    if (new Date(dateToString) > new Date()) {
                                        if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                            console.log('Valid Date');
                                        } else {
                                            error = "Invalid Date";
                                        }
                                    } else {
                                        error = " Date should be greater than todate Invalid Date";
                                    }
                                    $('#errorstartdateMsgdone_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });

                        //updateexpirydate
                        $('#editexpirydatedone_' + task.id).on('dp.change', function(ev) {


                            var ts = $('#editexpirydatedone_' + task.id).val();
                            var str = $('#editstartdatedone_' + task.id).val();
                            console.log(ts)

                            $.ajax({

                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptypedone_' + task.id).val()
                                },
                                success: function(data) {
                                    console.log(data);
                                    var error = "";
                                    console.log(ts, 'task expiry date');
                                    var splittedDate = ts.split("/");
                                    var startdate = str.split("/");
                                    var dateToStringStartdate = startdate[2] + "-" + startdate[1] + "-" + startdate[0];
                                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                                    if (new Date(dateToString) > new Date(dateToStringStartdate)) {
                                        if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                            console.log('Valid Date');
                                        } else {
                                            error = "Invalid Date";
                                        }
                                    } else {
                                        error = " Date should be greater than Startdate Invalid Date";
                                    }
                                    $('#errorexpirydateMsgdone_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });
                    });
                },
                error: function() {}
            });

        });
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
                var htmlCode = "";
                for (var i = 0; i < data.length; i++) {
                    htmlCode += "<option value='" + data[i].id + "'>" + data[i].firstname + " " + data[i].lastname + "<br/>" + data[i].email + "</option>";
                }
                $("#assignuser").html(htmlCode);
            },
            error: function() {}
        });

    }




    var values;
    $(".select2-icon").on("select2:select", function(event) {
        values = [];
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            values[i] = parseInt($(selected).val());
        });
    });

    function select2function(pid, tid) {
        $.ajax({
            url: '/taskusers/addusertask/',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': values,
                'pid': pid,
                'tid': tid
            },
            success: function(data) {
                $('#add_userfortask_' + tid).modal('hide')
                location.reload();
            },
            error: function(e) {}
        });
    }


    function addusersfortask(pid, tid) {
        $.ajax({
            url: '/taskusers/addusertask/',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': values,
                'pid': pid,
                'tid': tid
            },
            success: function(data) {
                window.location = "/project-object/taskboard/" + pid;
            },
            error: function(e) {
                console.log('error');
            }
        });


    }





    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };

    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    function inviteMembersforproject(pid) {
        var tag = $('#selecteddesignation').val();
        userIds = [];
        $(".multipleusers :selected").each(function() {
            userIds.push(this.value);
        });
        var form_data = new FormData();
        form_data.append("tagvalues", JSON.stringify(userIds));
        form_data.append("tag", tag);
        form_data.append("pid", pid);
        $.ajax({
            url: '/project-object/invitemembers/',
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


    function updatepriorityTodo(taskId) {
        var priority = $('#task_prority').val();
        $.ajax({
            url: '/projecttasks/updatepriority',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'priority': priority
            },
            success: function(data) {
                if (data != null) {
                    window.location = '/projecttasks/view/' + taskId
                }
            },
            error: function() {}
        })
    }

    function deletesubtask(taskId, subtaskid) {
        $.ajax({
            url: '/projecttasks/deletesubtask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'subtaskid': subtaskid
            },
            success: function(data) {
                $('#linksforsubtask_' + taskId).empty();
                var str = "";

                if (data.epictasks_projecttasks) {
                    data.epictasks_projecttasks.forEach((epic) => {

                        str += '<li>' +
                            '<a href=""> ' + epic.projecttask.title + '</a>' +
                            '<span class="action-circle large delete-btn" title="Delete Task">' +
                            '<a onclick="deletesubtask(' + taskId + ',' + epic.projecttask.id + ')" class="del-msg"><i class="material-icons">delete</i></a>' +
                            '</span>' +
                            '</li>';

                    });
                    $('#linksforsubtask_' + taskId).html(str);

                }
            },
            error: function() {}
        })

    }

    function unlinktoepic(taskId, epictaskid) {
        $.ajax({
            url: '/projecttasks/unlinktoepic',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'epictaskid': epictaskid
            },
            success: function(data) {
                $('#epictasks_' + taskId).empty();
                $('#epicblock_' + taskId).show();
            },
            error: function() {}
        })

    }
</script>
