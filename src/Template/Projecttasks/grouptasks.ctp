
<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

<style>
    .atagcss {
        cursor: pointer;
    }
</style>

<style>
    #taskStatus {
        position: relative;
        font-family: Arial;
    }

    #taskStatus select {
        display: none;
    }


    /* modal backdrop fix */
    .modal-backdrop.show {
        z-index: 1051 !important;
    }

    .modal-backdrop {
        visibility: hidden !important;
    }

    .modal.in {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title"><?= $projectObject->name ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Task Board</li>
                    </ul>
                     <div class="col-auto float-right ml-auto">
                        <?php if ($data2->designation->name == 'Customer' || $data2->designation->name == 'Administrator') : ?>
                            <a  href="/projecttasks/newticket?pid=<?=$projectObject->id?>&&grouptasks=<?=$group_id?>" class="btn add-btn" ><i class="fa fa-plus"></i> Add Ticket</a>
                            <a href="/project-object/archievedTickets/<?= $projectObject->id ?>" class="btn add-btn" style="margin-right: 10px;"></i>Archieve Tickets</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row board-view-header">
            <div class="col-4" style="z-index: 100;">
                <div class="pro-teams">
                    <div class="pro-team-lead">
                        <h4>Lead</h4>
                        <div class="avatar-group">
                            <?php foreach ($managers as $manager) : ?>
                                <?php foreach ($allUsers as $singleUser) : ?>
                                    <?php if ($manager->memberId == $singleUser->id) : ?>
                                        <div class="avatar">
                                            <img data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <div class="avatar">
                                <a href="" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_leader"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="pro-team-members">
                        <h4>Team</h4>
                        <div class="avatar-group">
                            <?php foreach ($projectMembers as $projectMember) : ?>
                                <?php foreach ($allUsers as $singleUser) : ?>
                                    <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                        <div class="avatar">
                                            <img data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" <?php if ($singleUser->profileFilepath != null && $singleUser->profileFilename != null) : ?> src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>" <?php else : ?> src="/assets/img/profiles/avatar-12.jpg">
                                        <?php endif; ?>
                                        >
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <div class="avatar">
                                <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#assign_user"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 text-right">
                <div class="form-group form-focus select-focus m-b-30">
                    <div class="dropdown action-label" style="margin-right: 15px;">
                        <a href="#" class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Select Group </a>
                        <div class="dropdown-menu">
                            <?php foreach ($taskgroups as $group) : ?>
                                <a class="dropdown-item" href="/projecttasks/grouptasks?group_id=<?= $group->id ?>&pid=<?= $projectObject->id ?>"><?= $group->title ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <span>
                        <a href="/project-object/taskboard/<?= $projectObject->id ?>" class="btn btn-white float-right m-r-10" data-toggle="tooltip" title="Task Board"><i class="fa fa-bars"></i></a>
                    </span>
                </div>

            </div>

            <?php $opentask = 0;
            $completedtask = 0 ?>
            <?php if ($tasks != null) : ?>
                <?php foreach ($tasks as $task) : ?>
                    <?php if ($task->isDeleted == false && $task->status != 'A') : ?>
                        <?php if ($task->status == 'T' or $task->status == 'I') : ?>
                            <?php $opentask = $opentask + 1;    ?>
                        <?php else : ?>
                            <?php $completedtask = $completedtask + 1; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php $totaltasks = $opentask + $completedtask ?>
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
    </div>

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
                        <?php if ($todoTasks != null) : ?>
                            <?php foreach ($todoTasks as $task) : ?>
                                <div class="card panel taskelement" id="<?= $task->id ?>">
                                    <?php if ($data2->designation->name == 'Administrator') : ?>
                                        <div class="kanban-box">
                                            <div class="task-board-header">
                                                <span class="status-title">
                                                    <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                        <h4><?= $task->title ?></h4>
                                                    </a>
                                                </span>
                                                <div class="dropdown kanban-task-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($data2->designation->name == 'Administrator') : ?>
                                                            <form method="post" action="/projecttasks/modify" enctype="multipart/form-data">
                                                                <input type="hidden" name="tid" id="tid" value="<?= $task->id ?>">
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <button class="btn btn-light btn-sm btn-block " type="submit">Modify</button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                            <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                            <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                        </form>


                                                        <a href="/projecttasks/view/<?= $task->id ?>" class="btn btn-light btn-sm btn-block">View</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-board-body">
                                                <div class="kanban-info">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span>0%</span>
                                                </div>
                                                <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o"></i><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
                                                        <?php if ($task->priority == 'H') : ?>
                                                            <span class="task-priority badge bg-inverse-danger">High</span>
                                                        <?php elseif ($task->priority == 'M') : ?>
                                                            <span class="task-priority badge bg-inverse-warning">Normal</span>
                                                        <?php else : ?>
                                                            <span class="task-priority badge bg-inverse-warning">Low</span>
                                                        <?php endif; ?>
                                                    </span>
                                                    <span class="task-users">
                                                        <?php foreach ($taskusers as $user) : ?>
                                                            <?php if ($user->taskId == $task->id) : ?>
                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                    <?php if ($user->assignee_id == $singleUser->id) : ?>
                                                                        <img data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>" class="task-avatar" width="24" height="24" alt="">
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <div class="avatar">
                                                            <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#todoassign_taskuser_<?= $task->id ?>"><i class="fa fa-plus"></i></a>
                                                        </div>
                                                        <!-------------------------------Assign User for Task------------------------------------->
                                                        <div id="todoassign_taskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Assign the user to this project</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group form-focus select-focus m-b-30">
                                                                            <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                            <select id="alltaskassignuser_<?= $task->id ?>" class="select2-icon floating" name="adduser" multiple>
                                                                                <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                        <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                <?php if ($projectMember->type == 'Y') : ?>
                                                                                                    <span class="message-content">Administrator</span>
                                                                                                <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                    <span class="message-content">Developer</span>
                                                                                                <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                    <span class="message-content">ProjectManager</span>
                                                                                                <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                    <span class="message-content">HR</span>
                                                                                                <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                    <span class="message-content">Co-Ordinator</span>
                                                                                                <?php endif; ?>
                                                                                            </option>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="submit-section">
                                                                            <a class="btn btn-success" onclick="addusersfortask(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                        </div>
                                                                    </div </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /Assign User Modal -->

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($data2->designation->name == 'Customer' &&  $task->type == 'TC') : ?>
                                        <div class="kanban-box">
                                            <div class="task-board-header">
                                                <span class="status-title">
                                                <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                        <h4><?= $task->title ?></h4>
                                                    </a>
                                                </span>
                                                <div class="dropdown kanban-task-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($data2->designation->name == 'Administrator') : ?>
                                                            <form method="post" action="/projecttasks/modify" enctype="multipart/form-data">
                                                                <input type="hidden" name="tid" id="tid" value="<?= $task->id ?>">
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <button class="btn btn-light btn-sm btn-block " type="submit">Modify</button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                            <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                            <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
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
                                                        <span class="task-date"><i class="fa fa-clock-o"></i><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
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
                                    <?php endif; ?>
                                    <?php if ($data2->designation->name == 'Developer' &&  $task->type == 'TS' or $data2->designation->name == 'Project Manager' && $task->type == 'TS') : ?>
                                        <div class="kanban-box">
                                            <div class="task-board-header">
                                                <span class="status-title">
                                                <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                        <h4><?= $task->title ?></h4>
                                                    </a>
                                                </span>
                                                <div class="dropdown kanban-task-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">

                                                        <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                            <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                            <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
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
                                                        <span class="task-date"><i class="fa fa-clock-o"></i> <?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
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

                                    <?php endif; ?>

                                </div>
                                <!--------View Task- & Edit------------------>
                                <div class="modal fade" id="task_<?= $task->id ?>" tabindex="-1" role="dialog" aria-labelledby="task" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title" id="task"><?= $task->title ?> </h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRefreshModal();">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <?php if ($data2->designation->name == 'Customer') : ?>
                                                        <div class="container">
                                                            <div class="form-group">
                                                                <label for="name"><?= __('Task title') ?></label>
                                                                <input class="form-control" type="text" name="name" value="<?= $task->title ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description"><?= __('Description') ?></label>
                                                                <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10"><?= $task->description ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="startdate"><?= __('Start Date') ?></label>
                                                                <input type="text" name="startdate" id="editstartdateTodo_<?= $task->id ?>" class="datetimepicker form-control" value="<?= $task->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                <span class="text-danger" id="errorstartdateMsg_<?= $task->id ?>"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expirydate"><?= __('Expire Date') ?></label>
                                                                <input type="text" name="expirydate" id="editexpirydateTodo_<?= $task->id ?>" class="datetimepicker form-control" value="<?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                <span class="text-danger" id="errorexpirydateMsg_<?= $task->id ?>"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="price"><?= __('Price') ?></label>
                                                                <input class="form-control" type="number" name="price" id="price" value="<?= $task->price ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tax"><?= __('Tax') ?></label>
                                                                <input class="form-control" type="number" name="tax" id="tax" value="<?= $task->tax_percentage ?>">

                                                            </div>

                                                            <div class="row" style="padding:20px">
                                                                <div class="form-group">
                                                                    <form method="post" action="/projecttasks/modify" enctype="multipart/form-data">
                                                                        <button class="btn btn-success" type="submit">Accept</button>
                                                                        <input name="updatedtaskId" type="hidden" value="<?= $task->id ?>">
                                                                        <input name="updatedtaskpid" type="hidden" value="<?= $projectObject->id ?>">
                                                                        <input name="custid" type="hidden" value="<?= $user_id ?>">

                                                                    </form>
                                                                </div>

                                                                <div class="form-group">
                                                                    <a href="/projecttasks/delete?pid=<?= $projectObject->id ?>&taskId=<?= $task->id ?>&uid=<?= $user_id ?>" class="btn add-btn"></i>Reject</a>
                                                                </div>
                                                                <div class="form-group">
                                                                    <form method="post" action="/projecttasks/archiveTicket" enctype="multipart/form-data">
                                                                        <button class="btn btn-success" type="submit">Archive</button>
                                                                        <input name="updatedtaskId" type="hidden" value="<?= $task->id ?>">
                                                                        <input name="updatedtaskpid" type="hidden" value="<?= $projectObject->id ?>">
                                                                        <input name="custid" type="hidden" value="<?= $user_id ?>">
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="col-lg-5 task-left-sidebar">

                                                            <form method="post" action="/projecttasks/updatetask" enctype="multipart/form-data">
                                                                <?php if ($data2->designation->name != 'Customer') : ?>
                                                                    <div class="form-group form-focus select-focus">
                                                                        <label for="type"><?= __('Select Group') ?></label>
                                                                        <select class="select floating" id="edittasktsgrouptype_<?= $task->id ?>" name="type">

                                                                            <?php foreach ($manyObject as $object) : ?>
                                                                                <?php if ($task->id === $object->projecttask_id) : ?>
                                                                                    <?php foreach ($taskgroups as $group) : ?>
                                                                                        <?php if ($object->taskgroup_id == $group->id) : ?>
                                                                                            <option selected value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                                        <?php else : ?>
                                                                                            <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>

                                                                        </select>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <br />
                                                                <div class="form-group">
                                                                    <label for="name"><?= __('Task title') ?></label>
                                                                    <input class="form-control" type="text" name="name" value="<?= $task->title ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="description"><?= __('Description') ?></label>
                                                                    <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10"><?= $task->description ?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="startdate"><?= __('Start Date') ?></label>
                                                                    <input type="text" name="startdate" id="editstartdateTodo_<?= $task->id ?>" class="datetimepicker tododatetimepicker form-control" value="<?= $task->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                    <span class="text-danger" id="errorstartdateMsg_<?= $task->id ?>"></span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="expirydate"><?= __('Expire Date') ?></label>
                                                                    <input type="text" name="expirydate" id="editexpirydateTodo_<?= $task->id ?>" class="datetimepicker todoexpirydatetimepicker form-control" value="<?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                    <span class="text-danger" id="errorexpirydateMsg_<?= $task->id ?>"></span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="price"><?= __('Price') ?></label>
                                                                    <input class="form-control" type="number" name="price" id="price" value="<?= $task->price ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tax"><?= __('Tax') ?></label>
                                                                    <input class="form-control" type="number" name="tax" id="tax" value="<?= $task->tax_percentage ?>">
                                                                </div>
                                                                <div class="form-group form-focus select-focus">
                                                                    <label for="priority"><?= __('Priority ') ?></label><span class="text-success" id="successDiv_<?= $task->id ?>"></span>
                                                                    <select class="select floating" id="taskStatus" name="priority">
                                                                        <?php if ($task->priority == 'H') : ?>
                                                                            <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                                            <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                            <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                                        <?php elseif ($task->priority == 'M') : ?>
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
                                                                <?php if ($data2->designation->name != 'Customer') : ?>
                                                                    <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                                    <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                    <!-- <button type="button" style="padding:0px" name="edit" id="edit" value="Edit" onclick="myfunction(); return false;">Edit</button>---->
                                                                    <button type="submit" class=" btn btn-info" name="update" value="Update">Update</button>
                                                                <?php endif; ?>
                                                            </form>

                                                        </div>
                                                        <?php if ($data2->designation->name != 'Customer') : ?>
                                                            <div class="col-lg-7 task-right-sidebar" id="task_window">
                                                                <div class="chat-window">
                                                                    <div class="fixed-header">
                                                                        <div class="navbar">

                                                                            <?php if ($data2->designation->name != 'Customer' && $task->type != 'TC') : ?>
                                                                                <div class="form-group form-focus select-focus">
                                                                                    <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDiv_<?= $task->id ?>"></span>
                                                                                    <select class="select floating" id="taskStatus" name="taskStatus" onchange="changeStatusTodo(this,<?= $task->id ?>); return false;">
                                                                                        <option value="T"> Mark Todo </option>
                                                                                        <option value="I">Mark In-Progress</option>
                                                                                        <option value="D">Mark Complete</option>
                                                                                    </select>
                                                                                </div>
                                                                            <?php endif; ?>

                                                                            <ul class="nav float-right custom-menu">
                                                                                <li class="dropdown dropdown-action">
                                                                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <br />

                                                                    <div class="task-information" id="todotaskinfo">
                                                                        <span class="task-info-line">
                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                <?php if ($task->status_updatedby == $singleUser->id) : ?>
                                                                                    <a class="task-user" href="#"><?= $singleUser->firstname ?><?= $singleUser->lastname ?></a>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <span class="task-info-subject"> Marked Task as
                                                                                <?php if ($task->status == 'T') : ?> ToDo
                                                                                <?php elseif ($task->status == 'I') : ?> InComplete
                                                                                <?php else : ?> Completed
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </span>
                                                                        <div class="task-time"><?= $task->creation_date ?></div>
                                                                    </div>

                                                                    <div class="chat-contents task-chat-contents">
                                                                        <div class="chat-content-wrap">
                                                                            <div class="chat-wrap-inner">
                                                                                <div class="chat-box">
                                                                                    <div class="chats">
                                                                                        <h4><?= $task->title ?></h4>
                                                                                        <div class="task-header">
                                                                                            <div class="assignee-info" id="todoassigneeinfo_<?= $task->id ?>">
                                                                                                <?php foreach ($taskusers as $taskuser) : ?>
                                                                                                    <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                            <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                                                <span class="remove-icon" onclick="tododeletetaskuser(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $singleUser->id ?>)">
                                                                                                                    <a class="del-msg"><i class="fa fa-close"></i></a>
                                                                                                                </span>
                                                                                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                                                                                    <div class="avatar">
                                                                                                                        <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                    </div>
                                                                                                                    <div class="assigned-info">
                                                                                                                        <div class="task-head-title">Assigned To</div>
                                                                                                                        <div class="task-assignee"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></div>
                                                                                                                    </div>
                                                                                                                </a>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endforeach; ?>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                            <a href="#" onclick="todoshowModal(<?= $task->id ?>)"><i class="material-icons">person_add</i></a>
                                                                                            <div class="modal " id="todoadd_userforalltask_<?= $task->id ?>">
                                                                                                <div class="modal-dialog-centered modal-md" role="dialog" style="align-self: center;position: relative;left: 33%;top: 0;">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title">Assign the user to task<?= $task->id ?></h5>
                                                                                                            <button type="button" class="close" data-dismiss="modal2 " aria-label="Close" onclick="closeModal(<?= $task->id ?>)">
                                                                                                                <span aria-hidden="true">&times;</span>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <div class="form-group form-focus select-focus m-b-30">
                                                                                                                <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                                                                <select id="alltaskassignuser_<?= $task->id ?>" class="select2-icon floating" name="adduser" multiple>

                                                                                                                    <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                                                                                                                <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                                                    <?php if ($projectMember->type == 'Y') : ?>
                                                                                                                                        <span class="message-content">Administrator</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                                                        <span class="message-content">Developer</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                                                        <span class="message-content">ProjectManager</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                                                        <span class="message-content">HR</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                                                        <span class="message-content">Co-Ordinator</span>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </option>
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    <?php endforeach; ?>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="submit-section">
                                                                                                                <a class="btn btn-success" onclick="todoselect2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <br />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr class="task-line">


                                                                                        <div class="task-desc">
                                                                                            <div class="task-desc-icon">
                                                                                                <i class="material-icons">subject</i>
                                                                                            </div>
                                                                                            <div class="task-textarea">
                                                                                                <textarea class="form-control" placeholder="Description"><?= $task->description ?></textarea>
                                                                                            </div>
                                                                                            <div class="task-due-date">
                                                                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                                                                    <div class="due-icon">
                                                                                                        <span>
                                                                                                            <i class="material-icons">date_range</i>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div class="due-info">
                                                                                                        <div class="task-head-title">Due Date</div>
                                                                                                        <div class="due-date"><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                                    </div>
                                                                                                </a>
                                                                                                <span class="remove-icon">
                                                                                                    <i class="fa fa-close"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>

                                                                                        <hr class="task-line">
                                                                                        <div class="task-information">
                                                                                            <span class="task-info-line"><a class="task-user" href="#">
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                            <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                        <?php endif; ?>

                                                                                                    <?php endforeach; ?>
                                                                                                </a> <span class="task-info-subject">created task</span></span>
                                                                                            <div class="task-time"><?= $task->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                        </div>
                                                                                        <div class="task-information">
                                                                                            <span class="task-info-line"><a class="task-user" href="#">
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                            <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </a> <span class="task-info-subject"><?= $projectObject->name ?></span></span>
                                                                                            <div class="task-time"><?= $projectObject->createDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                        </div>
                                                                                        <div class="task-information">
                                                                                            <span class="task-info-line"><a class="task-user" href="#">
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                            <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </a> <span class="task-info-subject">assigned to
                                                                                                    <?php foreach ($taskusers as $taskuser) : ?>
                                                                                                        <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                                                    <?= $singleUser->firstname ?> <?= $singleUser->lastname ?> at
                                                                                                                <?php endif; ?>
                                                                                                            <?php endforeach; ?>
                                                                                                            <div class="task-time"><?= $taskuser->assigned_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome')  ?></div>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </span></span>
                                                                                        </div>

                                                                                        <!-----------Task Update Info-------------------------------------------->
                                                                                        <hr class="task-line">
                                                                                        <!------------------------Chat----------------------------->

                                                                                        </br>
                                                                                        <div id="ajaxmessages_<?= $task->id ?>">

                                                                                            <?php $todotaskcomments = array();
                                                                                            foreach ($allcomments as $index => $comment) {
                                                                                                if ($comment->taskId == $task->id) {
                                                                                                    array_push($todotaskcomments, $comment);
                                                                                                }
                                                                                            }
                                                                                            ?>

                                                                                            <a class="btn btn-info" onclick=" showComments(<?= $task->id ?>,<?= $user_id ?>); return false;" id="todoviewcomments_<?= $task->id ?>">View all Comments</a>
                                                                                            <?php foreach ($todotaskcomments as $index => $comment) : ?>

                                                                                                <!----New and top3 Comment--->
                                                                                                <?php if ($index >= (count($todotaskcomments) - 3)) : ?>
                                                                                                    <div class="todoNewCommentsSection_<?= $task->id ?>" id="todoNewComments_<?= $task->id ?>_<?= $comment->id ?>">

                                                                                                        <?php if ($comment->user_id != $user_id) : ?>
                                                                                                            <div class="chat chat-left container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-50px, 22px, 0px); ">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="todo_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <p id="todoCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                                                                                            </span>
                                                                                                                            <span class="chat-time">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php if ($comment->isSeen == true) : ?>
                                                                                                                                    <i class="material-icons">check</i>
                                                                                                                                <?php endif; ?>

                                                                                                                            </span>
                                                                                                                            <p id="todoCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i>
                                                                                                                                            <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                                                                                                <?= $taskfile->filename ?>
                                                                                                                                            </a>
                                                                                                                                        </li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <?php if ($comment->replies) : ?>
                                                                                                                    <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                        <div class="form-group row">

                                                                                                                            <div class="chat-avatar col-3">
                                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                                    <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div class="chat-bubble col-9">
                                                                                                                                <div class="chat-content" style="width: 80%;">
                                                                                                                                    <?php if ($reply->user->id == $user_id) : ?>
                                                                                                                                        <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                                            </a>
                                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                                <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>

                                                                                                                                    <p><?= $reply->content ?></p>
                                                                                                                                    <span class="chat-time">
                                                                                                                                        <?php if ($reply->last_update == null) : ?>
                                                                                                                                            Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php else : ?>
                                                                                                                                            Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                        <?php if ($reply->isSeen == true) : ?>
                                                                                                                                            <i class="material-icons">check</i>
                                                                                                                                        <?php endif; ?>
                                                                                                                                    </span>

                                                                                                                                    <?php if ($reply->taskfiles) : ?>
                                                                                                                                        <ul class="attach-list">
                                                                                                                                            <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                            <?php endforeach; ?>
                                                                                                                                        </ul>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endif; ?>
                                                                                                            </div>
                                                                                                            <!--------Right part------------------>
                                                                                                        <?php else : ?>
                                                                                                            <div class="chat chat-right container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="todo_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                                                                                                    <a class="dropdown-item" onclick="todoeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                                                                                                    <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                        <p id="todorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                                                                                    <?php endif; ?>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </span>
                                                                                                                            <div>
                                                                                                                                <p class="commenttasktodo_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="todorightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                                                                                                <span class="chat-time" style="align-items: center">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if ($comment->isSeen == true) : ?>
                                                                                                                                        <i class="material-icons">check</i>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                            </div>

                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>

                                                                                                                        </div>
                                                                                                                        <div class="modal submodal" id="todoedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header">
                                                                                                                                        <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                                                        <button type="button" class="close" aria-label="Close" onclick="closetodoedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body">

                                                                                                                                        <div class="form-group">
                                                                                                                                            <label for="reply">Comment</label>
                                                                                                                                            <!--- <textarea type="text" class="form-control" id="content" name="content"><?= $comment->content ?></textarea>---->
                                                                                                                                            <div id="content_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer">
                                                                                                                                        <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                                                                                        <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                                                                                        <button type="button" class="btn btn-primary " onclick="updatetodocomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <?php if ($comment->replies) : ?>
                                                                                                                <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                    <div class="chat chat-right row">
                                                                                                                        <div class="chat-bubble col-9">
                                                                                                                            <div class="chat-content" style="width: 80%;">
                                                                                                                                <?php if ($reply->user_id == $user_id) : ?>
                                                                                                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                        <a href="" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                                                                        </a>
                                                                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                            <a class="dropdown-item" onclick="todoeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                                                                                            <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>

                                                                                                                                <p><?= $reply->content ?></p>
                                                                                                                                <span class="chat-time" style="text-align:left">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $reply->last_update ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                                <?php if ($reply->taskfiles) : ?>
                                                                                                                                    <ul class="attach-list">
                                                                                                                                        <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                            <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                        <?php endforeach; ?>
                                                                                                                                        <?php if ($reply->isSeen == true) : ?>
                                                                                                                                            <i class="material-icons">check</i>
                                                                                                                                        <?php endif; ?>
                                                                                                                                    </ul>
                                                                                                                                <?php endif; ?>

                                                                                                                            </div>

                                                                                                                        </div>
                                                                                                                        <div class="chat-avatar col-3">
                                                                                                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!---------------------Edit -Reply Modal--------------------------------------------->
                                                                                                                    <div class="modal submodal" id="todoeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                                                                                                    <button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">

                                                                                                                                    <div class="form-group">
                                                                                                                                        <label for="reply">Reply</label>

                                                                                                                                        <div id="replycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                    <button type="button" class="btn btn-primary " onclick="updatetodoReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php endforeach; ?>
                                                                                                            <?php endif; ?>


                                                                                                        <?php endif; ?>

                                                                                                    </div>
                                                                                                <?php else : ?>
                                                                                                    <div class="todoNewCommentsSection_<?= $task->id ?>" id="todoRemainingComments_<?= $task->id ?>_<?= $comment->id ?>" style="display: none;">
                                                                                                        <?php if ($comment->user_id != $user_id) : ?>
                                                                                                            <div class="chat chat-left container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-50px, 22px, 0px); ">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="todo_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <p id="todoCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                                                                                            </span>
                                                                                                                            <span class="chat-time">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php if ($comment->isSeen == true) : ?>
                                                                                                                                    <i class="material-icons">check</i>
                                                                                                                                <?php endif; ?>
                                                                                                                            </span>
                                                                                                                            <p id="todoCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i>
                                                                                                                                            <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                                                                                                <?= $taskfile->filename ?>
                                                                                                                                            </a>
                                                                                                                                        </li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>
                                                                                                                        </div>



                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <?php if ($comment->replies) : ?>
                                                                                                                    <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                        <div class="form-group row">

                                                                                                                            <div class="chat-avatar col-3">
                                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                                    <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div class="chat-bubble col-9">
                                                                                                                                <div class="chat-content" style="width: 80%;">
                                                                                                                                    <?php if ($reply->user->id == $user_id) : ?>
                                                                                                                                        <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                                            </a>
                                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                                <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>

                                                                                                                                    <p><?= $reply->content ?></p>
                                                                                                                                    <span class="chat-time">
                                                                                                                                        <?php if ($reply->last_update == null) : ?>
                                                                                                                                            Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php else : ?>
                                                                                                                                            Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                        <?php if ($reply->isSeen == true) : ?>
                                                                                                                                            <i class="material-icons">check</i>
                                                                                                                                        <?php endif; ?>
                                                                                                                                    </span>

                                                                                                                                    <?php if ($reply->taskfiles) : ?>
                                                                                                                                        <ul class="attach-list">
                                                                                                                                            <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                            <?php endforeach; ?>
                                                                                                                                        </ul>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>

                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endif; ?>



                                                                                                            </div>
                                                                                                            <!--------Right part------------------>
                                                                                                        <?php else : ?>
                                                                                                            <div class="chat chat-right container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="todo_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                                                                                                    <a class="dropdown-item" onclick="todoeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                                                                                                    <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                        <p id="todorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                                                                                    <?php endif; ?>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </span>
                                                                                                                            <div>
                                                                                                                                <p class="commenttasktodo_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="todorightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                                                                                                <span class="chat-time">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if ($comment->isSeen == true) : ?>
                                                                                                                                        <i class="material-icons">check</i>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                            </div>

                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>

                                                                                                                        </div>
                                                                                                                        <div class="modal submodal" id="todoedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header">
                                                                                                                                        <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                                                        <button type="button" class="close" aria-label="Close" onclick="closetodoedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body">

                                                                                                                                        <div class="form-group">
                                                                                                                                            <label for="reply">Comment</label>
                                                                                                                                            <!--- <textarea type="text" class="form-control" id="content" name="content"><?= $comment->content ?></textarea>---->
                                                                                                                                            <div id="content_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer">
                                                                                                                                        <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                                                                                        <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                                                                                        <button type="button" class="btn btn-primary " onclick="updatetodocomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <?php if ($comment->replies) : ?>
                                                                                                                <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                    <div class="chat chat-right row">
                                                                                                                        <div class="chat-bubble col-9">
                                                                                                                            <div class="chat-content" style="width: 80%;">
                                                                                                                                <?php if ($reply->user_id == $user_id) : ?>
                                                                                                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                        <a href="" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                                                                        </a>
                                                                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                            <a class="dropdown-item" onclick="todoeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                                                                                            <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>

                                                                                                                                <p><?= $reply->content ?></p>
                                                                                                                                <span class="chat-time" style="text-align:left">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $reply->last_update ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if ($reply->isSeen == true) : ?>
                                                                                                                                        <i class="material-icons">check</i>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                                <?php if ($reply->taskfiles) : ?>
                                                                                                                                    <ul class="attach-list">
                                                                                                                                        <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                            <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                        <?php endforeach; ?>
                                                                                                                                    </ul>
                                                                                                                                <?php endif; ?>

                                                                                                                            </div>

                                                                                                                        </div>
                                                                                                                        <div class="chat-avatar col-3">
                                                                                                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!---------------------Edit -Reply Modal--------------------------------------------->
                                                                                                                    <div class="modal submodal" id="todoeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                                                                                                    <button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">

                                                                                                                                    <div class="form-group">
                                                                                                                                        <label for="reply">Reply</label>

                                                                                                                                        <div id="replycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                    <button type="button" class="btn btn-primary " onclick="updatetodoReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php endforeach; ?>
                                                                                                            <?php endif; ?>


                                                                                                        <?php endif; ?>
                                                                                                    </div>
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; ?>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                        </div>

                                                                    </div>
                                                                    <div class="chat-footer">
                                                                        <div class="message-bar">
                                                                            <div class="message-inner">
                                                                                <div class="file-options" id="uploadfileoption">

                                                                                    <span class="btn-file" style="padding: 10px;">

                                                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="todoimages_<?= $task->id ?>" name="images" type="file" multiple />

                                                                                        <img src="/assets/img/attachment.png" alt="">
                                                                                    </span>
                                                                                </div>
                                                                                <div class="message-area">
                                                                                    <div id="chatBubble_<?= $task->id ?>" style="background-color: whitesmoke;">

                                                                                    </div>
                                                                                    <div class="input-group">
                                                                                        <textarea class="form-control" type="text" onkeypress="onEntertodo(event,<?= $projectObject->id ?>, <?= $task->id ?>, <?= $user_id ?>)" id="textcontent_<?= $task->id ?>" placeholder="Type message..."></textarea>
                                                                                        <span class="input-group-append">
                                                                                            <button class="btn btn-primary" type="button" onclick="submitMessage(<?= $projectObject->id ?>, <?= $task->id ?>, <?= $user_id ?>);return false;"><i class="fa fa-send"></i></button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!--------Task followers-------------------------------------------------->
                                                                        <div class="project-members task-followers">
                                                                            <span class="followers-title">Followers</span>
                                                                            <div id="todotask_followersinfo_<?= $task->id ?>">
                                                                                <?php foreach ($alltaskfollowers as $follower) : ?>
                                                                                    <?php if ($follower->task_id == $task->id) : ?>
                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                            <?php if ($singleUser->id == $follower->user_id) : ?>
                                                                                                <span class="remove-icon" onclick="tododeletefollower(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $singleUser->id ?>)">
                                                                                                    <a class="del-msg"><i class="fa fa-close"></i></a>
                                                                                                </span>
                                                                                                <a class="avatar" href="#" data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>">
                                                                                                    <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                </a>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>

                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </div>

                                                                            <a href="#" onclick="todotaskfollowers(<?= $task->id ?>)" class="followers-add"><i class="material-icons">add</i></a>
                                                                        </div>

                                                                        <!--------------Modal for Task followers----------------------------------------->
                                                                        <div class="modal" id="todoadd_followerfortask_<?= $task->id ?>" style="left: 32%;">
                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Assign the follower to task <?= $task->id ?></h5>
                                                                                        <button type="button" class="close" data-dismiss="modal2 " aria-label="Close" onclick="closetodofollowerModal(<?= $task->id ?>)">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group form-focus select-focus m-b-30">
                                                                                            <label for="addfollower"><?= __('Add Follower') ?> <span class="text-danger">*</span></label>
                                                                                            <select class="select2-icon floating" name="addfollower" multiple>

                                                                                                <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($projectMember->memberId == $singleUser->id) : ?>

                                                                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>

                                                                                                                <?php if ($projectMember->type == 'Y') : ?>
                                                                                                                    <span class="message-content">Administrator</span>
                                                                                                                <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                                    <span class="message-content">Developer</span>
                                                                                                                <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                                    <span class="message-content">ProjectManager</span>
                                                                                                                <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                                    <span class="message-content">HR</span>
                                                                                                                <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                                    <span class="message-content">Co-Ordinator</span>
                                                                                                                <?php endif; ?>
                                                                                                            </option>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </select>

                                                                                        </div>
                                                                                        <div class="submit-section">
                                                                                            <a class="btn btn-success" onclick="todoaddfollowers(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <br />
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!------/View Task  & Edit----->


                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                    <div class="add-new-task">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#add_task_modal">Add New Task</a>
                    </div>
                </div>
                <!----/TO DO ------>
                <?php if ($data2->designation->name != 'Customer') : ?>
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
                            <?php if ($inProTasks != null) : ?>
                                <?php foreach ($inProTasks  as $task) : ?>
                                    <div class="card panel taskelement" id="<?= $task->id ?>">
                                        <?php if ($data2->type == 'Y') : ?>
                                            <div class="kanban-box">
                                                <div class="task-board-header">
                                                    <span class="status-title">
                                                    <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                            <h4><?= $task->title ?></h4>
                                                        </a>
                                                    </span>
                                                    <div class="dropdown kanban-task-action">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <?php if ($data2->type == 'Y') : ?>
                                                                <form method="post" action="/projecttasks/modify" enctype="multipart/form-data">
                                                                    <input type="hidden" name="tid" id="tid" value="<?= $task->id ?>">
                                                                    <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                    <button class="btn btn-light btn-sm btn-block" type="submit">Modify</button>
                                                                </form>
                                                            <?php endif; ?>
                                                            <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                                <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                            <?php if ($task->priority == 'H') : ?>
                                                                <span class="task-priority badge bg-inverse-danger">High</span>
                                                            <?php elseif ($task->priority == 'M') : ?>
                                                                <span class="task-priority badge bg-inverse-warning">Normal</span>
                                                            <?php else : ?>
                                                                <span class="task-priority badge bg-inverse-warning">Low</span>
                                                            <?php endif; ?>
                                                        </span>
                                                        <span class="task-users">
                                                            <?php foreach ($taskusers as $user) : ?>
                                                                <?php if ($user->taskId == $task->id) : ?>
                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                        <?php if ($user->assignee_id == $singleUser->id) : ?>
                                                                            <img data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>" class="task-avatar" width="24" height="24" alt="">
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>

                                                            <div class="avatar">
                                                                <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#inproassign_taskuser_<?= $task->id ?>"><i class="fa fa-plus"></i></a>
                                                            </div>
                                                            <!-------------------------------Assign User for Task------------------------------------->
                                                            <div id="inproassign_taskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Assign the user to this project</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group form-focus select-focus m-b-30">
                                                                                <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                                <select id="alltaskassignuser_<?= $task->id ?>" class="select2-icon floating" name="adduser" multiple>

                                                                                    <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                            <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                                                                                <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                    <?php if ($projectMember->type == 'Y') : ?>
                                                                                                        <span class="message-content">Administrator</span>
                                                                                                    <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                        <span class="message-content">Developer</span>
                                                                                                    <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                        <span class="message-content">ProjectManager</span>
                                                                                                    <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                        <span class="message-content">HR</span>
                                                                                                    <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                        <span class="message-content">Co-Ordinator</span>
                                                                                                    <?php endif; ?>
                                                                                                </option>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="submit-section">
                                                                                <a class="btn btn-success" onclick="addusersfortask(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                            </div>
                                                                        </div </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /Assign User Modal -->

                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($data2->designation->name == 'Developer' &&  $task->type == 'TS' or $data2->designation->name == 'Project Manager' && $task->type == 'TS') : ?>
                                            <div class="kanban-box">
                                                <div class="task-board-header">
                                                    <span class="status-title">
                                                    <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                            <h4><?= $task->title ?></h4>
                                                        </a>
                                                    </span>
                                                    <div class="dropdown kanban-task-action">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                                <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!--------View Task------------------->
                                        <div class="modal fade" id="task_<?= $task->id ?>" tabindex="-1" role="dialog" aria-labelledby="task" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h2 class="modal-title" id="task"><?= $task->title ?><?= $task->id ?></h2>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRefreshModal()">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-5 task-left-sidebar">

                                                                <form method="post" action="/projecttasks/updatetask" enctype="multipart/form-data">
                                                                    <?php if ($data2->designation->name != 'Customer') : ?>
                                                                        <div class="form-group form-focus select-focus">
                                                                            <label for="type"><?= __('Select Group') ?></label>
                                                                            <select class="select floating" id="edittasktsgrouptypeinpro_<?= $task->id ?>" name="type">

                                                                                <?php foreach ($manyObject as $object) : ?>
                                                                                    <?php if ($task->id === $object->projecttask_id) : ?>
                                                                                        <?php foreach ($taskgroups as $group) : ?>
                                                                                            <?php if ($object->taskgroup_id == $group->id) : ?>
                                                                                                <option selected value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                                            <?php else : ?>
                                                                                                <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <br />
                                                                    <div class="form-group">
                                                                        <label for="name"><?= __('Task title') ?></label>
                                                                        <input class="form-control" type="text" name="name" value="<?= $task->title ?>">
                                                                    </div>

                                                                    <?php if ($data2->designation->name != 'Customer') : ?>
                                                                        <div class="form-group">
                                                                            <label for="description"><?= __('Description') ?></label>
                                                                            <input name="description" id="description" type="text" class="form-control btn-mod-input height10" value="<?= $task->description ?>" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="startdate"><?= __('Start Date') ?></label>
                                                                            <input type="text" id="editstartdateinpro_<?= $task->id ?>" name="startdate" class="datetimepicker form-control" value="<?= $task->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                            <span class="text-danger" id="errorstartdateMsginpro_<?= $task->id ?>"></span>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="expirydate"><?= __('Expire Date') ?></label>
                                                                            <input type="text" id="editexpirydateinpro_<?= $task->id ?>" name="expirydate" class="datetimepicker form-control" value="<?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                            <span class="text-danger" id="errorexpirydateMsginpro_<?= $task->id ?>"></span>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                    <div class="form-group">
                                                                        <label for="price"><?= __('Price') ?></label>
                                                                        <input class="form-control" type="number" name="price" id="price" value="<?= $task->price ?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="tax"><?= __('Tax') ?></label>
                                                                        <input class="form-control" type="number" name="tax" id="tax" value="<?= $task->tax_percentage ?>">

                                                                    </div>
                                                                    <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                                    <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                    <button class="btn btn-info" type="submit" class="update" name="update" value="Update">Update</button>
                                                                </form>
                                                            </div>
                                                            <div class="col-lg-7 task-right-sidebar" id="task_window">
                                                                <div class="chat-window">
                                                                    <div class="fixed-header">
                                                                        <div class="navbar">
                                                                            <?php if ($data2->designation->name != 'Customer') : ?>
                                                                                <div class="form-group form-focus select-focus">
                                                                                    <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivInpro_<?= $task->id ?>"></span>
                                                                                    <select class="select floating" id="taskStatus" name="taskStatus" onchange="changeStatusIn(this,<?= $task->id ?>); return false;">
                                                                                        <option value="T"> To Do</option>
                                                                                        <option selected value="I">In Progress</option>
                                                                                        <option value="D">Done</option>
                                                                                    </select>
                                                                                </div>
                                                                            <?php endif; ?>

                                                                            <ul class="nav float-right custom-menu">
                                                                                <li class="dropdown dropdown-action">
                                                                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                                                                        <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    </br>



                                                                    <div class="task-information" id="inprotaskinfo">
                                                                        <span class="task-info-line">
                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                <?php if ($task->status_updatedby == $singleUser->id) : ?>
                                                                                    <a class="task-user" href="#"><?= $singleUser->firstname ?><?= $singleUser->lastname ?></a>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <span class="task-info-subject"> Marked task as
                                                                                <?php if ($task->status == 'T') : ?> ToDo
                                                                                <?php elseif ($task->status == 'I') : ?> InComplete
                                                                                <?php else : ?> Completed
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </span>
                                                                        <div class="task-time"><?= $task->creation_date ?></div>
                                                                    </div>
                                                                    <div class="chat-contents task-chat-contents">
                                                                        <div class="chat-content-wrap">
                                                                            <div class="chat-wrap-inner">
                                                                                <div class="chat-box">
                                                                                    <div class="chats">
                                                                                        <h4><?= $task->title ?></h4>
                                                                                        <div class="task-header">
                                                                                            <div class="assignee-info" id="inproassigneeinfo_<?= $task->id ?>">
                                                                                                <?php foreach ($taskusers as $taskuser) : ?>
                                                                                                    <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                            <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                                                                                    <div class="avatar">
                                                                                                                        <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                                    </div>
                                                                                                                    <div class="assigned-info">
                                                                                                                        <div class="task-head-title">Assigned To</div>
                                                                                                                        <div class="task-assignee"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></div>
                                                                                                                    </div>
                                                                                                                </a>
                                                                                                                <span class="remove-icon" onclick="inprodeletetaskuser(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $singleUser->id ?>)">
                                                                                                                    <a class="del-msg"><i class="fa fa-close"></i></a>
                                                                                                                </span>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endforeach; ?>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                            <a href="#" onclick="inproshowModal(<?= $task->id ?>)"><i class="material-icons">person_add</i></a>
                                                                                            <div class="modal" id="inproadd_userforalltask_<?= $task->id ?>">
                                                                                                <div class="modal-dialog-centered modal-md" role="dialog" style="align-self: center;position: relative;left: 33%;top: 0;">
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                            <button type="button" class="close" data-dismiss="modal2 " aria-label="Close" onclick="inprocloseModal(<?= $task->id ?>)">
                                                                                                                <span aria-hidden="true">&times;</span>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <div class="form-group form-focus select-focus m-b-30">
                                                                                                                <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                                                                <select id="alltaskassignuser" class="select2-icon floating" name="adduser" multiple>
                                                                                                                    <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                                                                                                                <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                                                    <?php if ($projectMember->type == 'Y') : ?>
                                                                                                                                        <span class="message-content">Administrator</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                                                        <span class="message-content">Developer</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                                                        <span class="message-content">ProjectManager</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                                                        <span class="message-content">HR</span>
                                                                                                                                    <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                                                        <span class="message-content">Co-Ordinator</span>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </option>
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    <?php endforeach; ?>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="submit-section">
                                                                                                                <a class="btn btn-success" onclick="inproselect2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <br />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <hr class="task-line">
                                                                                        <div class="task-desc">
                                                                                            <div class="task-desc-icon">
                                                                                                <i class="material-icons">subject</i>
                                                                                            </div>
                                                                                            <div class="task-textarea">
                                                                                                <textarea class="form-control" placeholder="Description"><?= $task->description ?></textarea>
                                                                                            </div>
                                                                                            <div class="task-due-date">
                                                                                                <a href="#" data-toggle="modal" data-target="#assignee">
                                                                                                    <div class="due-icon">
                                                                                                        <span>
                                                                                                            <i class="material-icons">date_range</i>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div class="due-info">
                                                                                                        <div class="task-head-title">Due Date</div>
                                                                                                        <div class="due-date"><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                                    </div>
                                                                                                </a>
                                                                                                <span class="remove-icon">
                                                                                                    <i class="fa fa-close"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr class="task-line">
                                                                                        <div class="task-information">
                                                                                            <span class="task-info-line"><a class="task-user" href="#">
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                            <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                        <?php endif; ?>

                                                                                                    <?php endforeach; ?>
                                                                                                </a> <span class="task-info-subject">created task</span></span>
                                                                                            <div class="task-time"><?= $task->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                        </div>
                                                                                        <div class="task-information">
                                                                                            <span class="task-info-line"><a class="task-user" href="#">
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                            <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </a> <span class="task-info-subject"><?= $projectObject->name ?></span></span>
                                                                                            <div class="task-time"><?= $projectObject->createDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                        </div>
                                                                                        <div class="task-information">
                                                                                            <span class="task-info-line"><a class="task-user" href="#">
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                            <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </a> <span class="task-info-subject">assigned to
                                                                                                    <?php foreach ($taskusers as $taskuser) : ?>
                                                                                                        <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                                                    <?= $singleUser->firstname ?> <?= $singleUser->lastname ?> at
                                                                                                                <?php endif; ?>
                                                                                                            <?php endforeach; ?>
                                                                                                            <div class="task-time"><?= $taskuser->assigned_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome')  ?></div>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </span></span>


                                                                                        </div>

                                                                                        <!-----------Task Update Info-------------------------------------------->

                                                                                        <!------------------------Chat----------------------------->
                                                                                        </br>
                                                                                        <div id="inproajaxmessages_<?= $task->id ?>">

                                                                                            <a class="btn btn-info" onclick=" inproshowComments(<?= $task->id ?>,<?= $user_id ?>); return false;" id="viewcomments_<?= $task->id ?>">View all Comments</a>

                                                                                            <?php $inprotaskcomments = array();
                                                                                            foreach ($allcomments as $index => $comment) {
                                                                                                if ($comment->taskId == $task->id) {
                                                                                                    array_push($inprotaskcomments, $comment);
                                                                                                }
                                                                                            }
                                                                                            ?>

                                                                                            <?php foreach ($inprotaskcomments as $index => $comment) : ?>

                                                                                                <!----New and top3 Comment--->
                                                                                                <?php if ($index >= (count($inprotaskcomments) - 3)) : ?>
                                                                                                    <div class="inproNewCommentsSection_<?= $task->id ?>">
                                                                                                        <?php if ($comment->user_id != $user_id) : ?>
                                                                                                            <div class="chat chat-left container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-50px, 22px, 0px); ">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="inpro_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <p id="inproCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                                                                                            </span>
                                                                                                                            <span class="chat-time">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php if ($comment->isSeen == true) : ?>
                                                                                                                                    <i class="material-icons">check</i>
                                                                                                                                <?php endif; ?>


                                                                                                                            </span>

                                                                                                                            <p id="inproCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i>
                                                                                                                                            <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                                                                                                <?= $taskfile->filename ?>
                                                                                                                                            </a>
                                                                                                                                        </li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>
                                                                                                                        </div>



                                                                                                                    </div>
                                                                                                                </div>

                                                                                                                <?php if ($comment->replies) : ?>
                                                                                                                    <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                        <div class="form-group row">

                                                                                                                            <div class="chat-avatar col-3">
                                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                                    <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div class="chat-bubble col-9">
                                                                                                                                <div class="chat-content" style="width: 80%;">
                                                                                                                                    <?php if ($reply->user->id == $user_id) : ?>
                                                                                                                                        <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                                            </a>
                                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                                <a class="dropdown-item" onclick="inprodeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>

                                                                                                                                    <p><?= $reply->content ?></p>
                                                                                                                                    <span class="chat-time">
                                                                                                                                        <?php if ($reply->last_update == null) : ?>
                                                                                                                                            Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php else : ?>
                                                                                                                                            Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                    </span>

                                                                                                                                    <?php if ($reply->taskfiles) : ?>
                                                                                                                                        <ul class="attach-list">
                                                                                                                                            <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                            <?php endforeach; ?>
                                                                                                                                        </ul>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>

                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endif; ?>



                                                                                                            </div>
                                                                                                            <!--------Right part------------------>
                                                                                                        <?php else : ?>
                                                                                                            <div class="chat chat-right container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="inpro_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                                                                                                    <a class="dropdown-item" onclick="inproeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                                                                                                    <a class="dropdown-item" onclick="inprodeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                        <p id="inprorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                                                                                    <?php endif; ?>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </span>
                                                                                                                            <div>
                                                                                                                                <p class="commenttaskinpro_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="inprorightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                                                                                                <span class="chat-time">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if ($comment->isSeen == true) : ?>
                                                                                                                                        <i class="material-icons">check</i>
                                                                                                                                    <?php endif; ?>

                                                                                                                                </span>
                                                                                                                            </div>

                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>

                                                                                                                        </div>
                                                                                                                        <div class="modal submodal" id="inproedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header">
                                                                                                                                        <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                                                        <button type="button" class="close" aria-label="Close" onclick="closeinproedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body">

                                                                                                                                        <div class="form-group">
                                                                                                                                            <label for="reply">Comment</label>

                                                                                                                                            <div id="inprocontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer">
                                                                                                                                        <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                                                                                        <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                                                                                        <button type="button" class="btn btn-primary " onclick="updateinprocomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <?php if ($comment->replies) : ?>
                                                                                                                <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                    <div class="chat chat-right row">
                                                                                                                        <div class="chat-bubble col-9">
                                                                                                                            <div class="chat-content" style="width: 80%;">
                                                                                                                                <?php if ($reply->user_id == $user_id) : ?>
                                                                                                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                        <a href="" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                                                                        </a>
                                                                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                            <a class="dropdown-item" onclick="inproeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                                                                                            <a class="dropdown-item" onclick="inprodeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>

                                                                                                                                <p><?= $reply->content ?></p>
                                                                                                                                <span class="chat-time" style="text-align:left">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $reply->last_update ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                                <?php if ($reply->taskfiles) : ?>
                                                                                                                                    <ul class="attach-list">
                                                                                                                                        <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                            <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                        <?php endforeach; ?>
                                                                                                                                    </ul>
                                                                                                                                <?php endif; ?>

                                                                                                                            </div>

                                                                                                                        </div>
                                                                                                                        <div class="chat-avatar col-3">
                                                                                                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!---------------------Edit -Reply Modal--------------------------------------------->
                                                                                                                    <div class="modal submodal" id="inproeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                                                                                                    <button type="button" class="close" aria-label="Close" onclick="closeinproeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">

                                                                                                                                    <div class="form-group">
                                                                                                                                        <label for="reply">Reply</label>

                                                                                                                                        <div id="inproreplycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                    <button type="button" class="btn btn-primary " onclick="updateinproReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php endforeach; ?>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endif; ?>
                                                                                                    </div>
                                                                                                <?php else : ?>
                                                                                                    <div class="inproNewCommentsSection_<?= $task->id ?>" style="display:none">
                                                                                                        <?php if ($comment->user_id != $user_id) : ?>
                                                                                                            <div class="chat chat-left container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-50px, 22px, 0px); ">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="inpro_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <p id="inproCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                                                                                            </span>
                                                                                                                            <span class="chat-time">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php if ($comment->isSeen == true) : ?>
                                                                                                                                    <i class="material-icons">check</i>
                                                                                                                                <?php endif; ?>
                                                                                                                            </span>
                                                                                                                            <p id="inproCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i>
                                                                                                                                            <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                                                                                                <?= $taskfile->filename ?>
                                                                                                                                            </a>
                                                                                                                                        </li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <?php if ($comment->replies) : ?>
                                                                                                                    <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                        <div class="form-group row">

                                                                                                                            <div class="chat-avatar col-3">
                                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                                    <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div class="chat-bubble col-9">
                                                                                                                                <div class="chat-content" style="width: 80%;">
                                                                                                                                    <?php if ($reply->user->id == $user_id) : ?>
                                                                                                                                        <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                                            </a>
                                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                                <a class="dropdown-item" onclick="inprodeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>

                                                                                                                                    <p><?= $reply->content ?></p>
                                                                                                                                    <span class="chat-time">
                                                                                                                                        <?php if ($reply->last_update == null) : ?>
                                                                                                                                            Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php else : ?>
                                                                                                                                            Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                    </span>

                                                                                                                                    <?php if ($reply->taskfiles) : ?>
                                                                                                                                        <ul class="attach-list">
                                                                                                                                            <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                            <?php endforeach; ?>
                                                                                                                                        </ul>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>

                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endif; ?>



                                                                                                            </div>
                                                                                                            <!--------Right part------------------>
                                                                                                        <?php else : ?>
                                                                                                            <div class="chat chat-right container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="inpro_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                                                                                                    <a class="dropdown-item" onclick="inproeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                                                                                                    <a class="dropdown-item" onclick="inprodeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                        <p id="inprorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                                                                                    <?php endif; ?>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </span>
                                                                                                                            <div>
                                                                                                                                <p class="commenttaskinpro_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="inprorightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                                                                                                <span class="chat-time">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if ($comment->isSeen == true) : ?>
                                                                                                                                        <i class="material-icons">check</i>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                            </div>

                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>

                                                                                                                        </div>
                                                                                                                        <div class="modal submodal" id="inproedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header">
                                                                                                                                        <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                                                        <button type="button" class="close" aria-label="Close" onclick="closeinproedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body">

                                                                                                                                        <div class="form-group">
                                                                                                                                            <label for="reply">Comment</label>

                                                                                                                                            <div id="inprocontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer">
                                                                                                                                        <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                                                                                        <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                                                                                        <button type="button" class="btn btn-primary " onclick="updateinprocomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <?php if ($comment->replies) : ?>
                                                                                                                <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                    <div class="chat chat-right row">
                                                                                                                        <div class="chat-bubble col-9">
                                                                                                                            <div class="chat-content" style="width: 80%;">
                                                                                                                                <?php if ($reply->user_id == $user_id) : ?>
                                                                                                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                        <a href="" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                                                                        </a>
                                                                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                            <a class="dropdown-item" onclick="inproeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                                                                                            <a class="dropdown-item" onclick="inprodeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>

                                                                                                                                <p><?= $reply->content ?></p>
                                                                                                                                <span class="chat-time" style="text-align:left">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $reply->last_update ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                                <?php if ($reply->taskfiles) : ?>
                                                                                                                                    <ul class="attach-list">
                                                                                                                                        <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                            <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                        <?php endforeach; ?>
                                                                                                                                    </ul>
                                                                                                                                <?php endif; ?>

                                                                                                                            </div>

                                                                                                                        </div>
                                                                                                                        <div class="chat-avatar col-3">
                                                                                                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!---------------------Edit -Reply Modal--------------------------------------------->
                                                                                                                    <div class="modal submodal" id="inproeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                                                                                                    <button type="button" class="close" aria-label="Close" onclick="closeinproeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">

                                                                                                                                    <div class="form-group">
                                                                                                                                        <label for="reply">Reply</label>

                                                                                                                                        <div id="inproreplycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                    <button type="button" class="btn btn-primary " onclick="updateinproReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php endforeach; ?>
                                                                                                            <?php endif; ?>


                                                                                                        <?php endif; ?>
                                                                                                    </div>
                                                                                                <?php endif; ?>

                                                                                            <?php endforeach; ?>


                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="chat-footer">
                                                                        <div class="message-bar">
                                                                            <div class="message-inner">
                                                                                <div class="file-options" id="inprouploadfileoption">
                                                                                    <span class="btn-file" style="padding: 10px;">

                                                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="inproimages_<?= $task->id ?>" name="images" type="file" multiple />

                                                                                        <img src="/assets/img/attachment.png" alt="">
                                                                                    </span>
                                                                                </div>
                                                                                <div class="message-area">
                                                                                    <div id="inprochatBubble_<?= $task->id ?>" style="background-color: pink;">

                                                                                    </div>
                                                                                    <div class="input-group">
                                                                                        <textarea class="form-control" type="text" onkeypress="onEnterinpro(event,<?= $projectObject->id ?>, <?= $task->id ?>, <?= $user_id ?>)" id="inprotextcontent_<?= $task->id ?>" name="inprotextcontent" placeholder="Type message..."></textarea>
                                                                                        <span class="input-group-append">
                                                                                            <button class="btn btn-primary" type="button" onclick="inprosubmitMessage(<?= $projectObject->id ?>, <?= $task->id ?>,<?= $user_id ?>);return false;"><i class="fa fa-send"></i></button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>




                                                                        <!--------Task followers-------------------------------------------------->
                                                                        <div class="project-members task-followers">
                                                                            <span class="followers-title">Followers</span>
                                                                            <div id="inprotask_followersinfo_<?= $task->id ?>">
                                                                                <?php foreach ($alltaskfollowers as $follower) : ?>
                                                                                    <?php if ($follower->task_id == $task->id) : ?>
                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                            <?php if ($singleUser->id == $follower->user_id) : ?>
                                                                                                <span class="remove-icon" onclick="inprodeletefollower(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $singleUser->id ?>)">
                                                                                                    <a class="del-msg"><i class="fa fa-close"></i></a>
                                                                                                </span>
                                                                                                <a class="avatar" href="#" data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>">
                                                                                                    <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                </a>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>

                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            </div>

                                                                            <a href="#" onclick="inprotaskfollowers(<?= $task->id ?>)" class="followers-add"><i class="material-icons">add</i></a>
                                                                        </div>

                                                                        <!--------------Modal for Task followers----------------------------------------->
                                                                        <div class="modal" id="inproadd_followerfortask_<?= $task->id ?>" style="left: 32%;">
                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Assign the follower to task <?= $task->id ?></h5>
                                                                                        <button type="button" class="close" data-dismiss="modal2 " aria-label="Close" onclick="closeinprofollowerModal(<?= $task->id ?>)">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group form-focus select-focus m-b-30">
                                                                                            <label for="addfollower"><?= __('Add Follower') ?> <span class="text-danger">*</span></label>
                                                                                            <select class="select2-icon floating" name="addfollower" multiple>

                                                                                                <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($projectMember->memberId == $singleUser->id) : ?>

                                                                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>

                                                                                                                <?php if ($projectMember->type == 'Y') : ?>
                                                                                                                    <span class="message-content">Administrator</span>
                                                                                                                <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                                    <span class="message-content">Developer</span>
                                                                                                                <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                                    <span class="message-content">ProjectManager</span>
                                                                                                                <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                                    <span class="message-content">HR</span>
                                                                                                                <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                                    <span class="message-content">Co-Ordinator</span>
                                                                                                                <?php endif; ?>
                                                                                                            </option>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </select>

                                                                                        </div>
                                                                                        <div class="submit-section">
                                                                                            <a class="btn btn-success" onclick="inproaddfollowers(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>

                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <br />
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
                                        <!------/View Task ----->
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!----------/In-Progress---------->
                <?php endif; ?>


                <!------------Success-------------->

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
                        <?php if ($doneTasks != null) : ?>
                            <?php foreach ($doneTasks as $task) : ?>
                                <div class="card panel taskelement" id="<?= $task->id ?>">
                                    <?php if ($data2->designation->name == 'Administrator') : ?>
                                        <div class="kanban-box">
                                            <div class="task-board-header">
                                                <span class="status-title">
                                                <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                        <h4><?= $task->title ?></h4>
                                                    </a>
                                                </span>
                                                <div class="dropdown kanban-task-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($data2->designation->name == 'Administrator') : ?>
                                                            <form method="post" action="/projecttasks/modify" enctype="multipart/form-data">
                                                                <input type="hidden" name="tid" id="tid" value="<?= $task->id ?>">
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <button class="btn btn-light btn-sm btn-block" type="submit">Modify</button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                            <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                            <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-board-body">
                                                <div class="kanban-info">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span>100%</span>
                                                </div>
                                                <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o"></i><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
                                                        <span class="task-priority badge bg-success">completed</span>
                                                    </span>
                                                    <span class="task-users">
                                                        <?php foreach ($taskusers as $user) : ?>
                                                            <?php if ($user->taskId == $task->id) : ?>
                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                    <?php if ($user->assignee_id == $singleUser->id) : ?>
                                                                        <img data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" src="/assets/img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24" alt="">
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>

                                                        <div class="avatar">
                                                            <a href="#" class="avatar-title rounded-circle border border-white" data-toggle="modal" data-target="#doneassign_taskuser_<?= $task->id ?>"><i class="fa fa-plus"></i></a>
                                                        </div>
                                                        <!-------------------------------Assign User for Task------------------------------------->
                                                        <div id="doneassign_taskuser_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Assign the user to this project</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group form-focus select-focus m-b-30">
                                                                            <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                            <select id="alltaskassignuser_<?= $task->id ?>" class="select2-icon floating" name="adduser" multiple>

                                                                                <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                        <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                <?php if ($projectMember->type == 'Y') : ?>
                                                                                                    <span class="message-content">Administrator</span>
                                                                                                <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                    <span class="message-content">Developer</span>
                                                                                                <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                    <span class="message-content">ProjectManager</span>
                                                                                                <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                    <span class="message-content">HR</span>
                                                                                                <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                    <span class="message-content">Co-Ordinator</span>
                                                                                                <?php endif; ?>
                                                                                            </option>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="submit-section">
                                                                            <a class="btn btn-success" onclick="addusersfortask(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                        </div>
                                                                    </div </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /Assign User Modal -->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($data2->designation->name == 'Customer' &&  $task->type == 'TS') : ?>
                                        <div class="kanban-box">
                                            <div class="task-board-header">
                                                <span class="status-title">
                                                <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                        <h4><?= $task->title ?></h4>
                                                    </a>
                                                </span>
                                                <div class="dropdown kanban-task-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                            <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                            <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-board-body">
                                                <div class="kanban-info">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span>100%</span>
                                                </div>
                                                <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o"></i><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
                                                        <span class="task-priority badge bg-inverse-danger">High</span>
                                                    </span>
                                                    <span class="task-users">
                                                        <img src="/assets/img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24" alt="">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($data2->designation->name == 'Developer' &&  $task->type == 'TS' or $data2->designation->name == 'Project Manager' && $task->type == 'TS') : ?>
                                        <div class="kanban-box">
                                            <div class="task-board-header">
                                                <span class="status-title">
                                                <a class="atagcss" href="/projecttasks/taskview/<?=$task->id?>">
                                                        <h4><?= $task->title ?></h4>
                                                    </a>
                                                </span>
                                                <div class="dropdown kanban-task-action">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <form method="post" action="/projecttasks/delete" enctype="multipart/form-data">
                                                            <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                            <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                            <button type="submit" class="btn btn-light btn-sm btn-block" data-toggle="modal">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-board-body">
                                                <div class="kanban-info">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span>100%</span>
                                                </div>
                                                <div class="kanban-footer">
                                                    <span class="task-info-cont">
                                                        <span class="task-date"><i class="fa fa-clock-o"></i> <?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></span>
                                                        <span class="task-priority badge bg-inverse-danger">High</span>
                                                    </span>
                                                    <span class="task-users">
                                                        <img src="/assets/img/profiles/avatar-12.jpg" class="task-avatar" width="24" height="24" alt="">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <!--------View Task------------------->
                                    <div class="modal fade" id="task_<?= $task->id ?>" tabindex="-1" role="dialog" aria-labelledby="task" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="task"><?= $task->title ?><?= $task->id ?></h2>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRefreshModal();">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-5 task-left-sidebar">
                                                            <form method="post" action="/projecttasks/updatetask" enctype="multipart/form-data">
                                                                <?php if ($data2->designation->name != 'Customer') : ?>
                                                                    <div class="form-group form-focus select-focus">
                                                                        <label for="type"><?= __('Select Group') ?></label>
                                                                        <select class="select floating" id="edittasktsgrouptypedone_<?= $task->id ?>" name="type">

                                                                            <?php foreach ($manyObject as $object) : ?>
                                                                                <?php if ($task->id === $object->projecttask_id) : ?>
                                                                                    <?php foreach ($taskgroups as $group) : ?>
                                                                                        <?php if ($object->taskgroup_id == $group->id) : ?>
                                                                                            <option selected value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                                        <?php else : ?>
                                                                                            <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <br />
                                                                <div class="form-group">
                                                                    <label for="name"><?= __('Task title') ?></label>
                                                                    <input class="form-control" type="text" name="name" value="<?= $task->title ?>">
                                                                </div>
                                                                <?php if ($data2->designation->name != 'Customer') : ?>
                                                                    <div class="form-group">
                                                                        <label for="description"><?= __('Description') ?></label>
                                                                        <input name="description" id="description" type="text" class="form-control btn-mod-input height10" value="<?= $task->description ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="startdate"><?= __('Start Date') ?></label>
                                                                        <input type="text" id="editstartdatedone_<?= $task->id ?>" name="startdate" class="datetimepicker form-control" value="<?= $task->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                        <span class="text-danger" id="errorstartdateMsgdone_<?= $task->id ?>"></span>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="expirydate"><?= __('Expire Date') ?></label>
                                                                        <input type="text" id="editexpirydatedone_<?= $task->id ?>" name="expirydate" class="datetimepicker form-control" value="<?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                                        <span class="text-danger" id="errorexpirydateMsgdone_<?= $task->id ?>"></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="form-group">
                                                                    <label for="price"><?= __('Price') ?></label>
                                                                    <input class="form-control" type="number" name="price" id="price" value="<?= $task->price ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tax"><?= __('Tax') ?></label>
                                                                    <input class="form-control" type="number" name="tax" id="tax" value="<?= $task->tax_percentage ?>">
                                                                </div>
                                                                <input type="hidden" name="id" id="id" value="<?= $task->id ?>">
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <button class="btn btn-info" type="submit" class="update" name="update" value="Update">Update</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-7 task-right-sidebar" id="task_window">
                                                            <div class="chat-window">
                                                                <div class="fixed-header">
                                                                    <div class="navbar">
                                                                        <?php if ($data2->designation->name != 'Customer') : ?>
                                                                            <div class="form-group form-focus select-focus">
                                                                                <label for="taskStatus"><?= __('Status ') ?></label>
                                                                                <select class="select2-icon floating" id="taskStatus" name="taskStatus" onchange="changeStatusDone(this,<?= $task->id ?>); return false;">
                                                                                    <option value="T" data-toggle="modal" data-target="#approve_leave"> To Do</option>
                                                                                    <option value="I">In Prograss</option>
                                                                                    <option selected value="D">Done</option>
                                                                                </select>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <ul class="nav float-right custom-menu">
                                                                            <li class="dropdown dropdown-action">
                                                                                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                                                                    <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    </br>

                                                                    <div class="task-information" id="donetaskinfo">
                                                                        <span class="task-info-line">
                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                <?php if ($task->status_updatedby == $singleUser->id) : ?>
                                                                                    <a class="task-user" href="#"><?= $singleUser->firstname ?><?= $singleUser->lastname ?></a>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                            <span class="task-info-subject">Marked task as
                                                                                <?php if ($task->status == 'T') : ?> ToDo
                                                                                <?php elseif ($task->status == 'I') : ?> InComplete
                                                                                <?php else : ?> Completed
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </span>
                                                                        <div class="task-time"><?= $task->creation_date ?></div>
                                                                    </div>

                                                                </div>
                                                                <div class="chat-contents task-chat-contents">
                                                                    <div class="chat-content-wrap">
                                                                        <div class="chat-wrap-inner">
                                                                            <div class="chat-box">
                                                                                <div class="chats">
                                                                                    <h4><?= $task->title ?></h4>
                                                                                    <div class="task-header">
                                                                                        <div class="assignee-info" id="doneassigneeinfo_<?= $task->id ?>">
                                                                                            <?php foreach ($taskusers as $taskuser) : ?>
                                                                                                <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                        <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                                            <a href="#" data-toggle="modal" data-target="#assignee">
                                                                                                                <div class="avatar">
                                                                                                                    <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                                                                                                </div>
                                                                                                                <div class="assigned-info">
                                                                                                                    <div class="task-head-title">Assigned To</div>
                                                                                                                    <div class="task-assignee"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></div>
                                                                                                                </div>
                                                                                                            </a>
                                                                                                            <span class="remove-icon" onclick="donedeletetaskuser(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $singleUser->id ?>)">
                                                                                                                <a class="del-msg"><i class="fa fa-close"></i></a>
                                                                                                            </span>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; ?>
                                                                                        </div>
                                                                                        <a href="#" onclick="doneshowModal(<?= $task->id ?>)"><i class="material-icons">person_add</i></a>

                                                                                        <div class="modal" id="doneadd_userforalltask_<?= $task->id ?>">
                                                                                            <div class="modal-dialog-centered modal-md" role="dialog" style="align-self: center;position: relative;left: 33%;top: 0;">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal2 " aria-label="Close" onclick="donecloseModal(<?= $task->id ?>)">
                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="form-group form-focus select-focus m-b-30">
                                                                                                            <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                                                            <select id="alltaskassignuser" class="select2-icon floating" name="adduser" multiple>
                                                                                                                <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                        <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                                                                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                                                <?php if ($projectMember->type == 'Y') : ?>
                                                                                                                                    <span class="message-content">Administrator</span>
                                                                                                                                <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                                                    <span class="message-content">Developer</span>
                                                                                                                                <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                                                    <span class="message-content">ProjectManager</span>
                                                                                                                                <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                                                    <span class="message-content">HR</span>
                                                                                                                                <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                                                    <span class="message-content">Co-Ordinator</span>
                                                                                                                                <?php endif; ?>
                                                                                                                            </option>
                                                                                                                        <?php endif; ?>
                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endforeach; ?>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="submit-section">
                                                                                                            <a class="btn btn-success" onclick="doneselect2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <br />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr class="task-line">
                                                                                    <div class="task-desc">
                                                                                        <div class="task-desc-icon">
                                                                                            <i class="material-icons">subject</i>
                                                                                        </div>
                                                                                        <div class="task-textarea">
                                                                                            <textarea class="form-control" placeholder="Description"><?= $task->description ?></textarea>
                                                                                        </div>
                                                                                        <div class="task-due-date">
                                                                                            <a href="#" data-toggle="modal" data-target="#assignee">
                                                                                                <div class="due-icon">
                                                                                                    <span>
                                                                                                        <i class="material-icons">date_range</i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="due-info">
                                                                                                    <div class="task-head-title">Due Date</div>
                                                                                                    <div class="due-date"><?= $task->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                                </div>
                                                                                            </a>
                                                                                            <span class="remove-icon">
                                                                                                <i class="fa fa-close"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr class="task-line">
                                                                                    <div class="task-information">
                                                                                        <span class="task-info-line"><a class="task-user" href="#">
                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                    <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                        <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                    <?php endif; ?>

                                                                                                <?php endforeach; ?>
                                                                                            </a> <span class="task-info-subject">created task</span></span>
                                                                                        <div class="task-time"><?= $task->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                    </div>
                                                                                    <div class="task-information">
                                                                                        <span class="task-info-line"><a class="task-user" href="#">
                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                    <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                        <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </a> <span class="task-info-subject"><?= $projectObject->name ?></span></span>
                                                                                        <div class="task-time"><?= $projectObject->createDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></div>
                                                                                    </div>
                                                                                    <div class="task-information">
                                                                                        <span class="task-info-line"><a class="task-user" href="#">
                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                    <?php if ($singleUser->id == $task->creatorId) : ?>
                                                                                                        <?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </a> <span class="task-info-subject">assigned to
                                                                                                <?php foreach ($taskusers as $taskuser) : ?>
                                                                                                    <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                            <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                                                <?= $singleUser->firstname ?> <?= $singleUser->lastname ?> at
                                                                                                            <?php endif; ?>
                                                                                                        <?php endforeach; ?>
                                                                                                        <div class="task-time"><?= $taskuser->assigned_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome')  ?></div>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            </span></span>
                                                                                    </div>

                                                                                    <!-----------Task Update Info-------------------------------------------->
                                                                                    <hr class="task-line">
                                                                                    <div class="task-information">
                                                                                        <span class="task-info-line"><a class="task-user" href="#">John Doe</a> <span class="task-info-subject">changed the due date to Sep 28</span> </span>
                                                                                        <div class="task-time">9:09pm</div>
                                                                                    </div>
                                                                                    <div class="task-information">
                                                                                        <span class="task-info-line"><a class="task-user" href="#">John Doe</a> <span class="task-info-subject">assigned to you</span></span>
                                                                                        <div class="task-time">9:10pm</div>
                                                                                    </div>


                                                                                    <!------------------------Chat----------------------------->
                                                                                    </br>

                                                                                    <div id="doneajaxmessages_<?= $task->id ?>">

                                                                                        <a class="btn btn-info" onclick=" doneshowComments(<?= $task->id ?>,<?= $user_id ?>); return false;" id="viewcomments_<?= $task->id ?>">View all Comments</a>

                                                                                        <?php $taskcomments = array();
                                                                                        foreach ($allcomments as $index => $comment) {
                                                                                            if ($comment->taskId == $task->id) {
                                                                                                array_push($taskcomments, $comment);
                                                                                            }
                                                                                        }

                                                                                        ?>
                                                                                        <?php foreach ($taskcomments as $index => $comment) : ?>


                                                                                            <!----New and top3 Comment--->
                                                                                            <?php if ($index >= (count($taskcomments) - 3)) : ?>
                                                                                                <div class="doneNewCommentsSection_<?= $task->id ?>" id="doneNewComments_<?= $task->id ?>_<?= $comment->id ?>">
                                                                                                    <?php if ($comment->user_id != $user_id) : ?>
                                                                                                        <div class="chat chat-left container">
                                                                                                            <div class="chat-avatar">
                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                    <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            <div class="chat-body">
                                                                                                                <div class="chat-bubble">
                                                                                                                    <div class="comment-content">
                                                                                                                        <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-50px, 22px, 0px); ">
                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                            </a>
                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                <a class="dropdown-item" href="#" onclick="done_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <span class="task-chat-user">
                                                                                                                            <p id="doneCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                                                                                        </span>
                                                                                                                        <span class="chat-time">
                                                                                                                            <?php if ($comment->last_update == null) : ?>
                                                                                                                                Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                            <?php else : ?>
                                                                                                                                Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                            <?php endif; ?>

                                                                                                                            <?php if ($comment->isSeen == true) : ?>
                                                                                                                                <i class="material-icons">check</i>
                                                                                                                            <?php endif; ?>
                                                                                                                        </span>
                                                                                                                        <p id="doneCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                                                                                        <?php if ($comment->taskfiles) : ?>
                                                                                                                            <ul class="attach-list">
                                                                                                                                <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                    <li><i class="fa fa-file"></i>
                                                                                                                                        <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                                                                                            <?= $taskfile->filename ?>
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </ul>
                                                                                                                        <?php endif; ?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <?php if ($comment->replies) : ?>
                                                                                                                <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                    <div class="form-group row">

                                                                                                                        <div class="chat-avatar col-3">
                                                                                                                            <a href="profile.html" class="avatar">
                                                                                                                                <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                                                                                            </a>
                                                                                                                        </div>
                                                                                                                        <div class="chat-bubble col-9">
                                                                                                                            <div class="chat-content" style="width: 80%;">
                                                                                                                                <?php if ($reply->user->id == $user_id) : ?>
                                                                                                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                        <a href="" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                                                                        </a>
                                                                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                            <a class="dropdown-item" onclick="donedeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>

                                                                                                                                <p><?= $reply->content ?></p>
                                                                                                                                <span class="chat-time">
                                                                                                                                    <?php if ($reply->last_update == null) : ?>
                                                                                                                                        Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>

                                                                                                                                <?php if ($reply->taskfiles) : ?>
                                                                                                                                    <ul class="attach-list">
                                                                                                                                        <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                            <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                        <?php endforeach; ?>
                                                                                                                                    </ul>
                                                                                                                                <?php endif; ?>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php endforeach; ?>
                                                                                                            <?php endif; ?>
                                                                                                        </div>
                                                                                                        <!--------Right part------------------>
                                                                                                    <?php else : ?>
                                                                                                        <div class="chat chat-right container">
                                                                                                            <div class="chat-avatar">
                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                        <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                            <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                        <?php endif; ?>
                                                                                                                    <?php endforeach; ?>
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            <div class="chat-body">
                                                                                                                <div class="chat-bubble">
                                                                                                                    <div class="comment-content">
                                                                                                                        <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                            </a>
                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                <a class="dropdown-item" href="#" onclick="done_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                                                                                                <a class="dropdown-item" onclick="doneeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                                                                                                <a class="dropdown-item" onclick="donedeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <span class="task-chat-user">
                                                                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                                <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                    <p id="donerightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                                                                                <?php endif; ?>
                                                                                                                            <?php endforeach; ?>
                                                                                                                        </span>
                                                                                                                        <div>
                                                                                                                            <p class="commenttaskdone_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="donerightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                                                                                            <span class="chat-time">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php if ($comment->isSeen == true) : ?>
                                                                                                                                    <i class="material-icons">check</i>
                                                                                                                                <?php endif; ?>

                                                                                                                            </span>
                                                                                                                        </div>

                                                                                                                        <?php if ($comment->taskfiles) : ?>
                                                                                                                            <ul class="attach-list">
                                                                                                                                <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                    <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </ul>
                                                                                                                        <?php endif; ?>

                                                                                                                    </div>
                                                                                                                    <div class="modal submodal" id="doneedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                                                    <button type="button" class="close" aria-label="Close" onclick="closedoneedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">

                                                                                                                                    <div class="form-group">
                                                                                                                                        <label for="reply">Comment</label>
                                                                                                                                        <!--- <textarea type="text" class="form-control" id="content" name="content"><?= $comment->content ?></textarea>---->
                                                                                                                                        <div id="donecontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                    <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                                                                                    <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                                                                                    <button type="button" class="btn btn-primary " onclick="updatedonecomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <?php if ($comment->replies) : ?>
                                                                                                            <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                <div class="chat chat-right row">
                                                                                                                    <div class="chat-bubble col-9">
                                                                                                                        <div class="chat-content" style="width: 80%;">
                                                                                                                            <?php if ($reply->user_id == $user_id) : ?>
                                                                                                                                <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                    <a href="" data-toggle="dropdown">
                                                                                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                                                                                    </a>
                                                                                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                        <a class="dropdown-item" onclick="doneeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                                                                                        <a class="dropdown-item" onclick="donedeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            <?php endif; ?>

                                                                                                                            <p><?= $reply->content ?></p>
                                                                                                                            <span class="chat-time" style="text-align:left">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $reply->last_update ?>
                                                                                                                                <?php endif; ?>
                                                                                                                            </span>
                                                                                                                            <?php if ($reply->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>

                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="chat-avatar col-3">
                                                                                                                        <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <!---------------------Edit -Reply Modal--------------------------------------------->
                                                                                                                <div class="modal submodal" id="doneeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                                                                                    <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                        <div class="modal-content">
                                                                                                                            <div class="modal-header">
                                                                                                                                <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                                                                                                <button type="button" class="close" aria-label="Close" onclick="closedoneeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                                                </button>
                                                                                                                            </div>
                                                                                                                            <div class="modal-body">

                                                                                                                                <div class="form-group">
                                                                                                                                    <label for="reply">Reply</label>

                                                                                                                                    <div id="donereplycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="modal-footer">
                                                                                                                                <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                <button type="button" class="btn btn-primary " onclick="updatedoneReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            <?php endforeach; ?>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            <?php else : ?>
                                                                                                <div class="doneNewCommentsSection_<?= $task->id ?>" id="doneNewComments_<?= $task->id ?>_<?= $comment->id ?>" style="display: none;">
                                                                                                    <?php if ($comment->taskId == $task->id) : ?>
                                                                                                        <?php if ($comment->user_id != $user_id) : ?>
                                                                                                            <div class="chat chat-left container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-50px, 22px, 0px); ">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="done_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <p id="doneCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                                                                                            </span>
                                                                                                                            <span class="chat-time">
                                                                                                                                <?php if ($comment->last_update == null) : ?>
                                                                                                                                    Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php else : ?>
                                                                                                                                    Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                <?php endif; ?>
                                                                                                                                <?php if ($comment->isSeen == true) : ?>
                                                                                                                                    <i class="material-icons">check</i>
                                                                                                                                <?php endif; ?>
                                                                                                                            </span>
                                                                                                                            <p id="doneCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i>
                                                                                                                                            <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                                                                                                <?= $taskfile->filename ?>
                                                                                                                                            </a>
                                                                                                                                        </li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <?php if ($comment->replies) : ?>
                                                                                                                    <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                        <div class="form-group row">

                                                                                                                            <div class="chat-avatar col-3">
                                                                                                                                <a href="profile.html" class="avatar">
                                                                                                                                    <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                                                                                                </a>
                                                                                                                            </div>
                                                                                                                            <div class="chat-bubble col-9">
                                                                                                                                <div class="chat-content" style="width: 80%;">
                                                                                                                                    <?php if ($reply->user->id == $user_id) : ?>
                                                                                                                                        <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                            <a href="" data-toggle="dropdown">
                                                                                                                                                <i class="fa fa-ellipsis-v"></i>
                                                                                                                                            </a>
                                                                                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                                <a class="dropdown-item" onclick="donedeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    <?php endif; ?>

                                                                                                                                    <p><?= $reply->content ?></p>
                                                                                                                                    <span class="chat-time">
                                                                                                                                        <?php if ($reply->last_update == null) : ?>
                                                                                                                                            Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php else : ?>
                                                                                                                                            Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                        <?php endif; ?>
                                                                                                                                    </span>

                                                                                                                                    <?php if ($reply->taskfiles) : ?>
                                                                                                                                        <ul class="attach-list">
                                                                                                                                            <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                            <?php endforeach; ?>
                                                                                                                                        </ul>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endif; ?>
                                                                                                            </div>
                                                                                                            <!--------Right part------------------>
                                                                                                        <?php else : ?>
                                                                                                            <div class="chat chat-right container">
                                                                                                                <div class="chat-avatar">
                                                                                                                    <a href="profile.html" class="avatar">
                                                                                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endforeach; ?>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                                <div class="chat-body">
                                                                                                                    <div class="chat-bubble">
                                                                                                                        <div class="comment-content">
                                                                                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                <a href="" data-toggle="dropdown">
                                                                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                                                                </a>
                                                                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                    <a class="dropdown-item" href="#" onclick="done_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                                                                                                    <a class="dropdown-item" onclick="doneeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                                                                                                    <a class="dropdown-item" onclick="donedeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <span class="task-chat-user">
                                                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                                                                                        <p id="donerightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                                                                                    <?php endif; ?>
                                                                                                                                <?php endforeach; ?>
                                                                                                                            </span>
                                                                                                                            <div>
                                                                                                                                <p class="commenttaskdone_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="donerightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                                                                                                <span class="chat-time">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                    <?php if ($comment->isSeen == true) : ?>
                                                                                                                                        <i class="material-icons">check</i>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                            </div>

                                                                                                                            <?php if ($comment->taskfiles) : ?>
                                                                                                                                <ul class="attach-list">
                                                                                                                                    <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                    <?php endforeach; ?>
                                                                                                                                </ul>
                                                                                                                            <?php endif; ?>

                                                                                                                        </div>
                                                                                                                        <div class="modal submodal" id="doneedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                                                                                            <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                                <div class="modal-content">
                                                                                                                                    <div class="modal-header">
                                                                                                                                        <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                                                                                        <button type="button" class="close" aria-label="Close" onclick="closedoneedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-body">

                                                                                                                                        <div class="form-group">
                                                                                                                                            <label for="reply">Comment</label>
                                                                                                                                            <!--- <textarea type="text" class="form-control" id="content" name="content"><?= $comment->content ?></textarea>---->
                                                                                                                                            <div id="donecontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                    <div class="modal-footer">
                                                                                                                                        <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                        <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                                                                                        <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                                                                                        <button type="button" class="btn btn-primary " onclick="updatedonecomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <?php if ($comment->replies) : ?>
                                                                                                                <?php foreach ($comment->replies as $reply) : ?>
                                                                                                                    <div class="chat chat-right row">
                                                                                                                        <div class="chat-bubble col-9">
                                                                                                                            <div class="chat-content" style="width: 80%;">
                                                                                                                                <?php if ($reply->user_id == $user_id) : ?>
                                                                                                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                                                                                                        <a href="" data-toggle="dropdown">
                                                                                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                                                                                        </a>
                                                                                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                                                                                            <a class="dropdown-item" onclick="doneeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                                                                                            <a class="dropdown-item" onclick="donedeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                <?php endif; ?>

                                                                                                                                <p><?= $reply->content ?></p>
                                                                                                                                <span class="chat-time" style="text-align:left">
                                                                                                                                    <?php if ($comment->last_update == null) : ?>
                                                                                                                                        Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                                                                                                                    <?php else : ?>
                                                                                                                                        Updated At <?= $reply->last_update ?>
                                                                                                                                    <?php endif; ?>
                                                                                                                                </span>
                                                                                                                                <?php if ($reply->taskfiles) : ?>
                                                                                                                                    <ul class="attach-list">
                                                                                                                                        <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                                                                                            <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                                                                                        <?php endforeach; ?>
                                                                                                                                    </ul>
                                                                                                                                <?php endif; ?>

                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="chat-avatar col-3">
                                                                                                                            <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!---------------------Edit -Reply Modal--------------------------------------------->
                                                                                                                    <div class="modal submodal" id="doneeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                                                                                                    <button type="button" class="close" aria-label="Close" onclick="closedoneeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                                                    </button>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">

                                                                                                                                    <div class="form-group">
                                                                                                                                        <label for="reply">Reply</label>

                                                                                                                                        <div id="donereplycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                                <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-secondary">Close</button>
                                                                                                                                    <button type="button" class="btn btn-primary " onclick="updatedoneReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                <?php endforeach; ?>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endif; ?>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            <?php endif; ?>

                                                                                        <?php endforeach; ?>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="chat-footer">
                                                                    <div class="message-bar">
                                                                        <div class="message-inner">
                                                                            <div class="file-options" id="doneuploadfileoption">
                                                                                <span class="btn-file" style="padding: 10px;">

                                                                                    <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="doneimages_<?= $task->id ?>" name="images" type="file" multiple />

                                                                                    <img src="/assets/img/attachment.png" alt="">
                                                                                </span>
                                                                            </div>
                                                                            <div class="message-area">
                                                                                <div id="donechatBubble_<?= $task->id ?>" style="background-color: pink;">

                                                                                </div>
                                                                                <div class="input-group">
                                                                                    <textarea class="form-control" type="text" onkeypress="onEnterdone(event,<?= $projectObject->id ?>, <?= $task->id ?>, <?= $user_id ?>)" id="donetextcontent_<?= $task->id ?>" placeholder="Type message..."></textarea>
                                                                                    <span class="input-group-append">
                                                                                        <button class="btn btn-primary" type="button" onclick="donesubmitMessage(<?= $projectObject->id ?>, <?= $task->id ?>,<?= $user_id ?>);return false;"><i class="fa fa-send"></i></button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!--------Task followers-------------------------------------------------->
                                                                    <div class="project-members task-followers">
                                                                        <span class="followers-title">Followers</span>
                                                                        <div id="donetask_followersinfo_<?= $task->id ?>">
                                                                            <?php foreach ($alltaskfollowers as $follower) : ?>
                                                                                <?php if ($follower->task_id == $task->id) : ?>
                                                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                                                        <?php if ($singleUser->id == $follower->user_id) : ?>
                                                                                            <span class="remove-icon" onclick="donedeletefollower(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $singleUser->id ?>)">
                                                                                                <a class="del-msg"><i class="fa fa-close"></i></a>
                                                                                            </span>
                                                                                            <a class="avatar" href="#" data-toggle="tooltip" title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>">
                                                                                                <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                                                            </a>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>

                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                        <a href="#" onclick="donetaskfollowers(<?= $task->id ?>)" class="followers-add"><i class="material-icons">add</i></a>
                                                                    </div>

                                                                    <!--------------Modal for Task followers----------------------------------------->
                                                                    <div class="modal" id="doneadd_followerfortask_<?= $task->id ?>" style="left: 32%;">
                                                                        <div class="modal-dialog-centered modal-md" role="dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Assign the follower to task <?= $task->id ?></h5>
                                                                                    <button type="button" class="close" data-dismiss="modal2 " aria-label="Close" onclick="closedonefollowerModal(<?= $task->id ?>)">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="form-group form-focus select-focus m-b-30">
                                                                                        <label for="addfollower"><?= __('Add Follower') ?> <span class="text-danger">*</span></label>
                                                                                        <select class="select2-icon floating" name="addfollower" multiple>

                                                                                            <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                    <?php if ($projectMember->memberId == $singleUser->id) : ?>

                                                                                                        <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>

                                                                                                            <?php if ($projectMember->type == 'Y') : ?>
                                                                                                                <span class="message-content">Administrator</span>
                                                                                                            <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                                <span class="message-content">Developer</span>
                                                                                                            <?php elseif ($projectMember->type == 'Z') : ?>
                                                                                                                <span class="message-content">ProjectManager</span>
                                                                                                            <?php elseif ($projectMember->type == 'H') : ?>
                                                                                                                <span class="message-content">HR</span>
                                                                                                            <?php elseif ($projectMember->type == 'W') : ?>
                                                                                                                <span class="message-content">Co-Ordinator</span>
                                                                                                            <?php endif; ?>
                                                                                                        </option>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>
                                                                                            <?php endforeach; ?>
                                                                                        </select>

                                                                                    </div>
                                                                                    <div class="submit-section">
                                                                                        <a class="btn btn-success" onclick="doneaddfollowers(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <br />
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
                                    <!------/View Task ----->
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>

                <!-----------/Success------------------->


            </div>
        </div>
    </div>


    <!-- Assign Leader Modal -->
    <div id="assign_leader" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Leader to this project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/project-object/inviteMembers/" id="add" enctype="multipart/form-data">
                        <div class="form-group form-focus select-focus m-b-30">
                            <label for="adduser"><?= __('Add Project Manager') ?> <span class="text-danger">*</span></label>
                            <select id="adduser" class="select2-icon floating" name="adduser">
                                <option id='' selected disabled>-------</option>
                                <?php foreach ($allUsers as $singleUser) : ?>
                                    <?php if (!in_array($singleUser->id, $totalprojectmemberids)) : ?>

                                        <option value=" <?= $singleUser->id ?>">
                                            <p><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p><br />
                                            <span class="designation"><?= $singleUser->email ?></span>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br />
                        <div class="form-group form-focus select-focus m-b-30">
                            <label for="adddesignation"><?= __('Add Designation') ?><span class="text-danger">*</span></label>
                            <select id="adddesignation" class="select2-icon floating" name="adddesignation">

                                <option value="Z">Project Manager</option>

                            </select>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            <input type="hidden" name=taskboard value="<?= $projectObject->id ?>">
                            <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Assign Leader Modal -->


    <!-- Assign User Modal -->
    <div id="assign_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign the user to this project</h5>
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
                    <div class="form-group form-focus select-focus m-b-30">
                        <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                        <select name="adduser" id="assignuser" class="select2-icon floating multipleusers" multiple>
                        </select>
                    </div>
                    <br />
                    <div class="form-group form-focus select-focus m-b-30">
                        <label for="adddesignation"><?= __('Add Designation') ?><span class="text-danger">*</span></label>
                        <select id="selecteddesignation" class="select2-icon floating" name="adddesignation">

                            <option value="W">COORDINATOR</option>
                            <option value="X">DEVELOPER</option>
                            <option value="Y">ADMINISTRATOR</option>
                            <option value="Z"> PROJECT MANAGER</option>
                            <option value="H"> HR</option>
                        </select>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" onclick="inviteMembersforproject(<?= $projectObject->id ?>)">Submit</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /Assign User Modal -->




    <!-- Add Ticket Modal -->
    <div id="add_ticket" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/projecttasks/createTicket" id="add" enctype="multipart/form-data">
                        <?php if ($data2->type == 'Y') : ?>
                            <div class="form-group form-focus select-focus">
                                <label for="ticketstatus">Ticket Status<span class="text-danger">*</span></label>
                                <select id="ticketstatus" class="select floating" name="ticketstatus" required style="height:60%;">
                                    <option id='' disabled selected>-------</option>
                                    <option value=1>Approved</option>
                                    <option value=0>Not Approved</option>

                                </select>
                            </div>
                        <?php endif; ?>
                        <br />

                        <div class="form-group form-focus select-focus">
                            <label for="grouptype"><?= __('Select the Task Group') ?><span class="text-danger">*</span></label>
                            <select name="grouptype" id="addticketgrouptype" class="select floating" name="type" required>
                                <option id='' disabled selected>-------</option>
                                <?php foreach ($taskgroups as $group) : ?>
                                    <option value="<?= $group->id ?>"><?= $group->title ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br />

                        <div class="form-group">
                            <label for="name"><?= __('Ticket name') ?><span class="text-danger">*</span></label>
                            <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" required />
                        </div>
                        <div class="form-group">
                            <label for="description"><?= __('Description') ?><span class="text-danger">*</span></label>
                            <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10" placeholder="<?= __('Describe your project...') ?>" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="startdate"><?= __('Start Date') ?></label>
                            <input type="text" name="startdate" id="addticketstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" required />
                            <span class="text-danger" id="ticketstartdateMsg"></span>
                        </div>

                        <div class="form-group">
                            <label>Expire Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="expirydate" id="addticketexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                <span class="text-danger" id="addticketexpirydateMsg"></span>
                            </div>
                        </div>

                        <?php if ($data2->type != 'C') : ?>
                            <div class="form-group">
                                <label for="price"><?= __('Price') ?><span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="price" id="price" placeholder="<?= __('Enter Price...') ?> " required>
                            </div>

                            <div class="form-group">
                                <label for="tax"><?= __('Tax') ?><span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="tax" id="tax" placeholder="<?= __('Enter Tax...') ?> " required>

                            </div>
                        <?php endif; ?>
                        <div class="form-group"><span>Priority:</span>
                            <select class="select2-icon floating" name="task_prority">
                                <option>Select Priority</option>
                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                            </select>
                        </div>
                        </br>

                        <div class="text-center">
                            <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('create Ticket') ?></button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- /Add Ticket Modal -->

    <!-- Add Group Modal -->
    <div id="add_group" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Group
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/taskgroups/addtaskgroups" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name"><?= __('Group Name') ?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control btn-mod-input" name="group_title" id="group_title" placeholder="Name" required />
                            </div>

                            <div class="form-group">
                                <label for="name"><?= __('Group Description') ?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control btn-mod-input" name="group_description" id="group_description" placeholder="Description" required />
                            </div>
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <div class="cal-icon" id="errormessage">
                                    <input class="form-control datetimepicker" name="startdate" id="groupstartdate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Expire Date <span class="text-danger">*</span></label>
                                <div class="cal-icon" id="errorgroupexpirymessage">
                                    <input class="form-control datetimepicker" name="expirydate" id="groupexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price"><?= __('Price') ?><span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="price" id="price" placeholder="<?= __('Enter Price...') ?> " required>
                            </div>
                            <div class="form-group">
                                <label for="tax"><?= __('Tax') ?><span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="tax" id="tax" placeholder="<?= __('Enter Tax...') ?> " required>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                            </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!---/ Add Group Modal--->

</div>
<!-- /Page Content -->
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    function closeRefreshModal() {
        location.reload();
    }

    function closeModal(tid) {
        $('#todoadd_userforalltask_' + tid).hide();

    }

    function inprocloseModal(tid) {
        $('#inproadd_userforalltask_' + tid).hide();
    }

    function donecloseModal(tid) {
        $('#doneadd_userforalltask_' + tid).hide();

    }

    function closetodofollowerModal(tid) {
        $('#todoadd_followerfortask_' + tid).hide();
    }



    function todotaskfollowers(tid) {
        $('#todoadd_followerfortask_' + tid).show();
    }

    //inpro followers
    function closeinprofollowerModal(tid) {
        $('#inproadd_followerfortask_' + tid).hide();
    }

    function inprotaskfollowers(tid) {
        $('#inproadd_followerfortask_' + tid).show();
    }

    function donetaskfollowers(tid) {
        $('#doneadd_followerfortask_' + tid).show();
    }

    function closedonefollowerModal(tid) {
        $('#doneadd_followerfortask_' + tid).hide();
    }

    function todoshowModal(tid) {
        $('#todoadd_userforalltask_' + tid).show();
    }

    function todoeditModal(tid, pid, cid) {
        $('#todoedit_' + tid + '_' + pid + '_' + cid).show();
    }

    function todoeditReplyModal(tid, pid, rid) {
        $('#todoeditReply_' + tid + '_' + pid + '_' + rid).show();
    }

    function closetodoeditreply(tid, pid, rid) {
        $('#todoeditReply_' + tid + '_' + pid + '_' + rid).hide();
    }


    //done replymodal functions
    function doneeditReplyModal(tid, pid, rid) {
        $('#doneeditReply_' + tid + '_' + pid + '_' + rid).show();
    }

    function closedoneeditreply(tid, pid, rid) {
        $('#doneeditReply_' + tid + '_' + pid + '_' + rid).hide();
    }




    function inproeditReplyModal(tid, pid, rid) {
        $('#inproeditReply_' + tid + '_' + pid + '_' + rid).show();
    }

    function closeinproeditreply(tid, pid, rid) {
        $('#inproeditReply_' + tid + '_' + pid + '_' + rid).hide();
    }

    function inproeditModal(tid, pid, cid) {
        $('#inproedit_' + tid + '_' + pid + '_' + cid).show();
    }

    function doneeditModal(tid, pid, cid) {
        $('#doneedit_' + tid + '_' + pid + '_' + cid).show();
    }

    function closetodoedit(tid, pid, cid) {
        $('#todoedit_' + tid + '_' + pid + '_' + cid).hide();

    }

    function closeinproedit(tid, pid, cid) {
        $('#inproedit_' + tid + '_' + pid + '_' + cid).hide();

    }

    function closedoneedit(tid, pid, cid) {
        $('#doneedit_' + tid + '_' + pid + '_' + cid).hide();

    }

    function inproshowModal(tid) {
        $('#inproadd_userforalltask_' + tid).show();

    }

    function doneshowModal(tid) {
        $('#doneadd_userforalltask_' + tid).show();

    }



    function changeStatusTodo(event, taskId) {
        var taskStatus = event.value;
        $.ajax({
            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus,
            },
            success: function(data) {
                $('#todotaskinfo').empty();
                var taskdata = "";
                let status;
                data.forEach((task) => {
                    if (task.status == 'T') {
                        status = 'Todo';
                    } else if (task.status == 'I') {
                        status = 'InProgress';
                    } else {
                        status = 'Completed'
                    }
                    if (task.id == taskId) {
                        taskdata += '<span class="task-info-line">' +
                            '<a class="task-user" href="#" >' + task.statusupdatedby.firstname + ' ' + task.statusupdatedby.lastname + '</a>' +
                            '<span class="task-info-subject" > Marked task as ' + status + '</span>' +
                            '</span>' +
                            '<div class="task-time">' + task.creation_date + '</div>';
                    }
                });
                $('#todotaskinfo').append(taskdata);
            },
            error: function() {

            }
        })

    }


    function changeStatusIn(event, taskId) {
        var taskStatus = event.value;
        $.ajax({
            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'status': taskStatus
            },
            success: function(data) {
                $('#inprotaskinfo').empty();
                var taskdata = "";
                let status;
                data.forEach((task) => {
                    console.log(task.status, 'inprogess');
                    if (task.status == 'T') {
                        status = 'Todo';
                    } else if (task.status == 'I') {
                        status = 'InProgress';
                    } else {
                        status = 'Completed'
                    }
                    if (task.id == taskId) {
                        taskdata += '<span class="task-info-line">' +
                            '<a class="task-user" href="#" >' + task.statusupdatedby.firstname + ' ' + task.statusupdatedby.lastname + '</a>' +
                            '<span class="task-info-subject" > Marked task as ' + status + '</span>' +
                            '</span>' +
                            '<div class="task-time">' + task.creation_date + '</div>';
                    }
                });
                $('#inprotaskinfo').append(taskdata);
            },
            error: function() {

            }
        })

    }

    function changeStatusDone(event, taskId) {
        var taskStatus = event.value;
        $.ajax({
            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus
            },
            success: function(data) {
                $('#donetaskinfo').empty();
                var taskdata = "";
                let status;
                data.forEach((task) => {
                    console.log(task.status, 'Completed');
                    if (task.status == 'T') {
                        status = 'Todo';
                    } else if (task.status == 'I') {
                        status = 'InProgress';
                    } else {
                        status = 'Completed'
                    }
                    if (task.id == taskId) {
                        taskdata += '<span class="task-info-line">' +
                            '<a class="task-user" href="#" >' + task.statusupdatedby.firstname + ' ' + task.statusupdatedby.lastname + '</a>' +
                            '<span class="task-info-subject" >  Marked task as ' + status + '</span>' +
                            '</span>' +
                            '<div class="task-time">' + task.creation_date + '</div>';
                    }
                });
                $('#donetaskinfo').append(taskdata);
            },
            error: function() {

            }
        })

    }

    function myfunction(event) {
        var tsgrouptype = event.value;
        $.ajax({
            url: '/project-object/taskgroupDetails',
            method: 'post',
            dataType: 'json',
            data: {
                'tsgrouptype': tsgrouptype, //tsgrouptype
            },
            success: function(data) {
                $('#successAddtask').show();
                $startdate = data.startdate;
            },

            error: function() {
                console.log("error")
            }
        })
    }


    $(function() {

        $(document).ready(function() {

            var commentvalue = false;
            var replay = 0;

            //groupstart date
            $("#groupstartdate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();
                var splittedDate = $("#groupstartdate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var groupstartdate = new Date(dateToString);
                if (groupstartdate < (new Date())) {
                    $('#errormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to current date</p>');
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
                        $('#errorgroupexpirymessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to Start Date</p>');
                } else {
                    $('#errorgroupexpirymessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to current date</p>');
                }
            });



            //taskstartdate
            $('#addtaskstartdate').on('dp.change', function(ev) {
                var ts = $('#addtaskstartdate').val();
                var gid = $('#addtasktsgrouptype').val()
                $.ajax({
                    url: '/projecttasks/checkstartdate',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'groupid': gid,
                    },
                    success: function(data) {
                        var error = "";
                        var splittedDate = ts.split("/");
                        var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                        if (new Date(dateToString) > new Date()) {
                            if (((new Date(data.startdate)) <= (new Date(dateToString))) && ((new Date(data.expirydate)) >= (new Date(dateToString)))) {
                                console.log('Valid Date');
                            } else {
                                error = "Invalid Date";
                            }
                        } else {
                            error = "Invalid Date Start Date should be greaterthan today date";
                        }
                        $('#errorstartdateMsg').html(error);
                    },
                    error: function() {}
                });

            });

            // task ExpiryDate
            $('#addtaskexpirydate').on('dp.change', function(ev) {
                var str = $('#addtaskstartdate').val()
                var exp = $('#addtaskexpirydate').val()
                $.ajax({
                    url: '/projecttasks/checkexpirydate',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'groupid': $('#addtasktsgrouptype').val(),

                    },
                    success: function(data) {
                        var error = "";
                        var splittedstartDate = str.split("/");
                        var splittedexpiryDate = exp.split("/");
                        var startdateToString = splittedstartDate[2] + "-" + splittedstartDate[1] + "-" + splittedstartDate[0];
                        var expirydateToString = splittedexpiryDate[2] + "-" + splittedexpiryDate[1] + "-" + splittedexpiryDate[0];
                        if (new Date(expirydateToString) > new Date(startdateToString)) {
                            if (((new Date(data.startdate)) <= (new Date(expirydateToString))) && ((new Date(data.expirydate)) >= (new Date(expirydateToString)))) {} else {
                                error = 'ExpiryDate Invalid';
                            }
                        } else {
                            error = 'ExpiryDate not Lessthan StartDate';
                        }
                        $('#errorexpirydateMsg').html(error);
                    },
                    error: function() {}
                });
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
                $(".kanban-wrap").draggable();
                $(".kanban-list").droppable({
                    drop: function(event, ui) {
                        var draggableId = $(ui.draggable).attr('id');
                        var status = this.children[0].innerText;
                        // console.log($(this).sortable("serialize"), 'sortable');
                        if (status == 'ToDo') {
                            status = 'T';
                        } else if (status == 'InProgress') {
                            status = 'I';
                        } else {
                            status = 'D';
                        }
                        $.ajax({
                            url: '/projecttasks/changeStatusOfTask',
                            method: 'post',
                            dataType: 'json',
                            data: {
                                'status': status,
                                'taskId': draggableId
                            },
                            success: function(data) {},
                            error: function(e) {}
                        });

                    }
                });
            });



            $.ajax({
                url: '/projecttasks/docalltasks',
                dataType: 'json',
                success: function(data) {
                    console.log('all tasks', data);
                    data.forEach((task) => {

                        //updatestartdate
                        $('#editstartdateTodo_' + task.id).on('dp.change', function(ev) {
                            var ts = $('#editstartdateTodo_' + task.id).val();
                            console.log(ts)
                            $.ajax({
                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptype_' + task.id).val()
                                },
                                success: function(data) {

                                    //draggable operations  event.target.children[1]


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
                                    $('#errorstartdateMsg_' + task.id).html(error);
                                },
                                error: function() {}
                            });
                        });

                        //updateexpirydate
                        $('#editexpirydateTodo_' + task.id).on('dp.change', function(ev) {


                            var ts = $('#editexpirydateTodo_' + task.id).val();
                            var str = $('#editstartdateTodo_' + task.id).val();
                            console.log(ts)

                            $.ajax({

                                url: '/projecttasks/checkstartdate',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'groupid': $('#edittasktsgrouptype_' + task.id).val()

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



    function todorenderComments(data, auth, tid, text) {
        $('#textcontent_' + tid).empty();
        $('#ajaxmessages_' + tid).empty();
        var commentsHtml = "";
        commentsHtml += ' <a class="btn btn-info" onclick=" showComments(' + tid + ',' + auth + '); return false;" id="todoviewcomments_' + tid + '">' + text + '</a>';
        data.forEach((comment, index) => {
            var isSeen = comment.isSeen == true ? '<i class="material-icons">check</i>' : '';
            if (index >= (data.length - 3)) {
                commentsHtml += '<div class="todoNewCommentsSection_' + comment.taskId + '">';

                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +

                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +

                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="todoeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="tododeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="todorightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + '</span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                    }

                    commentsHtml += '<p class="commenttasktodo_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="todorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';


                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +

                                '</div>' +

                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +

                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml += '</div>';
                    commentsHtml += ' <div class="modal submodal" id="todoedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closetodoedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +

                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="content_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +

                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updatetodocomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +

                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +

                        '<span id="todoCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';

                    }
                    commentsHtml += '<p id="todoCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';
                }
                commentsHtml += '</div>';
            } else {
                var display = text === "View all Comments" ? "none" : "block";
                commentsHtml += '<div class="todoNewCommentsSection_' + comment.taskId + '"  style="display:' + display + ';">';

                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="todoeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="tododeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="todorightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                    }
                    commentsHtml += '<p class="commenttasktodo_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="todorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';


                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +

                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml += '</div>';
                    commentsHtml += ' <div class="modal submodal" id="todoedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closetodoedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="content_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updatetodocomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="todoCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';

                    }
                    commentsHtml += '<p id="todoCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';

                }

                commentsHtml += '</div>';
            }
        });
        $('#ajaxmessages_' + tid).html(commentsHtml);

    }



    function inprorenderComments(data, auth, tid, text) {
        $('#inprotextcontent_' + tid).val('');
        $('#inproajaxmessages_' + tid).empty();
        var commentsHtml = "";
        commentsHtml += ' <a class="btn btn-info" onclick=" inproshowComments(' + tid + ',' + auth + '); return false;" id="viewcomments_' + tid + '">' + text + '</a>';
        data.forEach((comment, index) => {
            var isSeen = comment.isSeen == true ? '<i class="material-icons">check</i>' : '';
            if (index >= (data.length - 3)) {
                commentsHtml += '<div class="inproNewCommentsSection_' + comment.taskId + '">';
                console.log("UserId: " + comment.user_id);
                console.log("Auth: " + auth);

                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="inpro_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="inproeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="inprodeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="inprorightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + ' ' + isSeen + '</span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                    }
                    commentsHtml += '<p class="commenttaskinpro_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="inprorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="inproeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="inprodeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';

                            commentsHtml += '<div class="modal submodal" id="inproeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closeinproeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +

                                '<div id="inproreplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updateinproReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml += '</div>';
                    commentsHtml += ' <div class="modal submodal" id="inproedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closeinproedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="inprocontent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updateinprocomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="inpro_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="inproCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';

                    }
                    commentsHtml += '<p id="inproCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="inproeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="inprodeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="inproeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closeinproeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="inproreplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updateinproReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';

                }
                commentsHtml += '</div>';
            } else {
                var display = text === "View all Comments" ? "none" : "block";
                commentsHtml += '<div class="inproNewCommentsSection_' + comment.taskId + '"  style="display:' + display + ';">';

                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="inpro_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="inproeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="inprodeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="inprorightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                    }
                    commentsHtml += '<p class="commenttaskinpro_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="inprorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="inproeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="inprodeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';

                            commentsHtml += '<div class="modal submodal" id="inproeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closeinproeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="inproreplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updateinproReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml += '</div>';
                    commentsHtml += ' <div class="modal submodal" id="inproedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closeinproedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="inprocontent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updateinprocomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="inpro_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="inproCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';

                    }
                    commentsHtml += '<p id="inproCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="inproeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="inprodeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="inproeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closeinproeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="inproreplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updateinproReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';
                }
                commentsHtml += '</div>';

            }

        });
        console.log(commentsHtml);
        $('#inproajaxmessages_' + tid).html(commentsHtml);

    }



    //donerendercomments
    function donerenderComments(data, auth, tid, text) {
        $('#donetextcontent_' + tid).empty();
        $('#doneajaxmessages_' + tid).empty();
        var commentsHtml = "";
        commentsHtml += ' <a class="btn btn-info" onclick=" doneshowComments(' + tid + ',' + auth + '); return false;" id="viewcomments_' + tid + '">' + text + '</a>';
        data.forEach((comment, index) => {
            var isSeen = comment.isSeen == true ? '<i class="material-icons">check</i>' : '';
            if (index >= (data.length - 3)) {
                '<div class="doneNewCommentsSection_' + comment.taskId + '">';
                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="done_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="doneeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="donedeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="donerightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                    }
                    commentsHtml += '<p class="commenttaskdone_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="donerightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="doneeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="donedeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';

                            commentsHtml += '<div class="modal submodal" id="doneeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closedoneeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +

                                '<div id="donereplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatedoneReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml += '</div>';
                    commentsHtml += ' <div class="modal submodal" id="doneedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closedoneedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="donecontent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updatedonecomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="done_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="doneCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';

                    }
                    commentsHtml += '<p id="doneCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="doneeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="donedeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="doneeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closedoneeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="donereplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatedoneReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';

                }
                commentsHtml += '</div>';
            } else {
                var display = text === "View all Comments" ? "none" : "block";
                commentsHtml += '<div class="doneNewCommentsSection_' + comment.taskId + '"  style="display:' + display + ';">';
                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="done_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="doneeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="donedeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="donerightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                    }
                    commentsHtml += '<p class="commenttaskdone_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="donerightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="doneeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="donedeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';

                            commentsHtml += '<div class="modal submodal" id="doneeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closedoneeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +

                                '<div id="donereplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatedoneReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml += '</div>';
                    commentsHtml += ' <div class="modal submodal" id="doneedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closedoneedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="donecontent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updatedonecomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="done_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="doneCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';

                    }
                    commentsHtml += '<p id="doneCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="doneeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="donedeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="doneeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closedoneeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="donereplycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatedoneReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';

                }
                commentsHtml += '</div>';


            }


        });
        console.log(commentsHtml);
        $('#doneajaxmessages_' + tid).html(commentsHtml);

    }


    function onEntertodo(e, pid, tid, auth) {
        console.log(e.which, 'enter key');
        if (e.which === 13) {
            e.preventDefault();
            submitMessage(pid, tid, auth);
        }
    }


    function onEnterinpro(e, pid, tid, auth) {
        console.log(e.which, 'enter key');
        if (e.which === 13) {
            e.preventDefault();
            inprosubmitMessage(pid, tid, auth)
        }
    }

    function onEnterdone(e, pid, tid, auth) {
        console.log(e.which, 'enter key');
        if (e.which === 13) {
            e.preventDefault();
            donesubmitMessage(pid, tid, auth)
        }
    }



    var replay = 0;

    function submitMessage(pid, tid, auth) {
        var testing = $('#chatBubble_tid').text()
        var content = $('#textcontent_' + tid).val();
        var file_data = $("#todoimages_" + tid).prop("files");
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = pid;
        }
        var content = $('#textcontent_' + tid).val();
        form_data.append("replay", replay);
        form_data.append("pid", pid);
        form_data.append("tid", tid);
        form_data.append("content", content);
        if (replay == 1) {
            var cid = $('#chatBubble_' + tid + ' input').val();
            form_data.append("cid", cid);
            $('#chatBubble_' + tid).empty()
        }
        form_data.append('isFileNotAttached', isFileNotAttached);
        $('#textcontent_' + tid).val('');


        $.ajax({
            url: '/comments/submit-message',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                todorenderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
                $("#todoimages_" + tid).replaceWith($("#todoimages_" + tid).val('').clone(true));
            },
            error: function() {

            }
        });



    }


    function tododownloadfile(fileId) {
        $.ajax({
            url: '/taskfiles/downloadtaskfile',
            method: 'post',
            dataType: 'json',
            data: {
                'fileId': fileId
            },
            success: function(data) {},
            error: function() {

            }
        });
    }



    //update todocomment

    function updatetodocomments(tid, pid, cid, auth) {
        var isTaskboard = tid;
        var content = $('#content_' + tid + '_' + pid + '_' + cid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': cid,
                'content': content
            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
                $('#todoedit_' + tid + '_' + pid + '_' + cid).modal('hide');
            },
            error: function() {}
        });
    }


    function updatetodoReply(tid, pid, rid, auth) {
        var isTaskboard = tid;
        var content = $('#replycontent_' + tid + '_' + pid + '_' + rid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': rid,
                'content': content
            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
                $('#todoeditReply_' + tid + '_' + pid + '_' + rid).modal('hide');
            },
            error: function() {}
        });
    }



    //tododeletecomment
    function tododeletecomment(tid, pid, cid, auth) {
        $.ajax({
            url: '/comments/delete',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
                'pid': pid,
                'cid': cid

            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
            },

            error: function() {

            }
        });


    }

    function todo_reply_comment(tid, pid, cid) {
        replay = 1;
        var str = '<input name="cid" id="cid" type="hidden" value="' + cid + '">';
        var replaystr = '<p name="replay" id="replay_' + cid + '" type="hidden">' + replay + '</p>';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="closeReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#chatBubble_" + tid).empty();
        $('#todoreplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#chatBubble_" + tid).append('<div class="form-group" id="todoreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="todoreplayPara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '' + replaystr + '</div>');
        $('#todoreplayPara_' + tid + '_' + pid + '_' + cid).html($('#todoCommentUsername_' + tid + '_' + pid + '_' + cid + '').text() + '</br>' + $('#todoCommentContent_' + tid + '_' + pid + '_' + cid + '').text());

    }


    function closeReplyModal(tid) {
        $('#chatBubble_' + tid).empty();
    }

    function todo_replyrightside_comment(tid, pid, cid) {
        replay = 1;
        var replaystr = "";
        var replaystr = '<p name="replay" id="replay" type="hidden">' + replay + '</p>';
        var str = '<input name="cid" id="cid" type="hidden" value="' + cid + '">';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="closeReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#chatBubble_" + tid).empty();
        $('#todoreplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#chatBubble_" + tid).append('<div class="form-group" id="todoreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="todoreplayrightsidePara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '' + replaystr + '</div>');
        $('#todoreplayrightsidePara_' + tid + '_' + pid + '_' + cid).html($('#todorightsideCommentUsername_' + tid + '_' + pid + '_' + cid + '').text() + '</br>' + $('#todorightsideCommentContent_' + tid + '_' + pid + '_' + cid + '').text());

    }



    //inpro functions
    function updateinproReply(tid, pid, rid, auth) {
        var isTaskboard = tid;
        var content = $('#inproreplycontent_' + tid + '_' + pid + '_' + rid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': rid,
                'content': content
            },
            success: function(data) {
                inprorenderComments(data, auth, tid);
                $('#inproeditReply_' + tid + '_' + pid + '_' + rid).modal('hide');
            },
            error: function() {}
        });
    }


    function inprodeletecomment(tid, pid, cid, auth) {
        $.ajax({
            url: '/comments/delete',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
                'pid': pid,
                'cid': cid

            },
            success: function(data) {
                inprorenderComments(data, auth, tid, $('#viewcomments_' + tid + '').text());
            },
            error: function() {}
        });


    }

    function inpro_replyrightside_comment(tid, pid, cid) {
        replay = 1;
        var replaystr = "";
        var replaystr = '<p name="replay" id="replay" type="hidden">' + replay + '</p>';
        var str = '<input name="cid" id="cid" type="hidden" value="' + cid + '">';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="inprocloseReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#inprochatBubble_" + tid).empty();
        $('#inproreplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#inprochatBubble_" + tid).append('<div class="form-group" id="inproreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="inproreplayrightsidePara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '' + replaystr + '</div>');
        $('#inproreplayrightsidePara_' + tid + '_' + pid + '_' + cid).html($('#inprorightsideCommentUsername_' + tid + '_' + pid + '_' + cid + '').text() + '</br>' + $('#inprorightsideCommentContent_' + tid + '_' + pid + '_' + cid + '').text());
    }

    function inpro_reply_comment(tid, pid, cid) {
        replay = 1;
        var str = '<input name="cid" id="cid" type="hidden" value="' + cid + '">';
        var replaystr = '<p name="replay" id="replay_' + cid + '" type="hidden">' + replay + '</p>';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="inprocloseReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#inprochatBubble_" + tid).empty();
        $('#inproreplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#inprochatBubble_" + tid).append('<div class="form-group" id="inproreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="inproreplayPara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '' + replaystr + '</div>');
        $('#inproreplayPara_' + tid + '_' + pid + '_' + cid).html($('#inproCommentUsername_' + tid + '_' + pid + '_' + cid + '').text() + '</br>' + $('#inproCommentContent_' + tid + '_' + pid + '_' + cid + '').text());
    }


    function inprocloseReplyModal(tid) {
        $('#inprochatBubble_' + tid).empty();
    }

    function updateinprocomments(tid, pid, cid, auth) {
        var isTaskboard = tid;
        var content = $('#inprocontent_' + tid + '_' + pid + '_' + cid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': cid,
                'content': content
            },
            success: function(data) {
                inprorenderComments(data, auth, tid, $('#viewcomments_' + tid + '').text());
                $('#inproedit_' + tid + '_' + pid + '_' + cid).modal('hide');
            },
            error: function() {}
        });
    }



    //inpro ajax
    function inprosubmitMessage(pid, tid, auth) {
        var file_data = $("#inproimages_" + tid).prop("files");
        var content = $('#inprotextcontent_' + tid).val();
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = pid;
        }
        form_data.append("replay", replay);
        form_data.append("pid", pid);
        form_data.append("tid", tid);
        form_data.append("content", content);
        form_data.append('isFileNotAttached', isFileNotAttached);
        if (replay == 1) {
            var cid = $('#inprochatBubble_' + tid + ' input').val();
            form_data.append("cid", cid);
            $('#inprochatBubble_' + tid).empty()
        }

        $.ajax({
            url: '/comments/submit-message',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                inprorenderComments(data, auth, tid, $('#viewcomments_' + tid).text());
                $("#inproimages_" + tid).replaceWith($("#inproimages_" + tid).val('').clone(true));
            },

            error: function() {

            }
        });



    }


    //done ajax
    function donesubmitMessage(pid, tid, auth) {
        var file_data = $("#doneimages_" + tid).prop("files");
        var content = $('#donetextcontent_' + tid).val();
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = pid;
        }
        form_data.append("replay", replay);
        form_data.append("pid", pid);
        form_data.append("tid", tid);
        form_data.append("content", content);
        form_data.append('isFileNotAttached', isFileNotAttached);
        if (replay == 1) {
            var cid = $('#donechatBubble_' + tid + ' input').val();
            form_data.append("cid", cid);
            $('#donechatBubble_' + tid).empty()
        }

        $.ajax({
            url: '/comments/submit-message',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                donerenderComments(data, auth, tid, $('#viewcomments_' + tid).text());
                $("#doneimages_" + tid).replaceWith($("#doneimages_" + tid).val('').clone(true));
                $('#donetextcontent_' + tid).val("");
            },
            error: function() {}
        });



    }

    //done task functions
    function updatedoneReply(tid, pid, rid, auth) {
        var isTaskboard = tid;
        var content = $('#donereplycontent_' + tid + '_' + pid + '_' + rid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': rid,
                'content': content
            },
            success: function(data) {
                donerenderComments(data, auth, tid, $('#viewcomments_' + tid).text());
                $('#doneeditReply_' + tid + '_' + pid + '_' + rid).modal('hide');
            },
            error: function() {}
        });
    }



    function done_replyrightside_comment(tid, pid, cid) {
        replay = 1;
        var replaystr = "";
        var replaystr = '<p name="replay" id="replay" type="hidden">' + replay + '</p>';
        var str = '<input name="cid" id="donecid" type="hidden" value="' + cid + '">';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="donecloseReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#donechatBubble_" + tid).empty();
        $('#donereplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#donechatBubble_" + tid).append('<div class="form-group" id="donereplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="donereplayrightsidePara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '' + replaystr + '</div>');
        $('#donereplayrightsidePara_' + tid + '_' + pid + '_' + cid).html($('#donerightsideCommentUsername_' + tid + '_' + pid + '_' + cid + '').text() + '</br>' + $('#donerightsideCommentContent_' + tid + '_' + pid + '_' + cid + '').text());

    }

    function done_reply_comment(tid, pid, cid) {
        replay = 1;
        var str = '<input name="cid" id="donecid" type="hidden" value="' + cid + '">';
        var replaystr = '<p name="replay" id="replay_' + cid + '" type="hidden">' + replay + '</p>';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="donecloseReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#donechatBubble_" + tid).empty();
        $('#donereplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#donechatBubble_" + tid).append('<div class="form-group" id="donereplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="donereplayPara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '' + replaystr + '</div>');
        $('#donereplayPara_' + tid + '_' + pid + '_' + cid).html($('#doneCommentUsername_' + tid + '_' + pid + '_' + cid + '').text() + '</br>' + $('#doneCommentContent_' + tid + '_' + pid + '_' + cid + '').text());

    }

    function donecloseReplyModal(tid) {
        $('#donechatBubble_' + tid).empty();
    }

    function donedeletecomment(tid, pid, cid, auth) {
        $.ajax({
            url: '/comments/delete',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
                'pid': pid,
                'cid': cid
            },
            success: function(data) {
                donerenderComments(data, auth, tid, $('#viewcomments_' + tid).text());

            },

            error: function() {

            }
        });


    }

    function updatedonecomments(tid, pid, cid, auth) {
        var isTaskboard = tid;
        var content = $('#donecontent_' + tid + '_' + pid + '_' + cid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': cid,
                'content': content
            },
            success: function(data) {
                donerenderComments(data, auth, tid, $('#viewcomments_' + tid).text());
                $('#doneedit_' + tid + '_' + pid + '_' + cid).modal('hide');
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


    function todoselect2function(pid, tid) {
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

                $('#todoassigneeinfo_' + tid).empty();
                var assignee = "";
                data.forEach((addeduser) => {
                    assignee += ' <a href="#" data-toggle="modal" data-target="#assignee">' +
                        '<div class="avatar">' +
                        '<img alt="" src="' + addeduser.user.profileFilepath + '/' + addeduser.user.profileFilename + '">' +
                        '</div>' +
                        '<div class="assigned-info">' +
                        '<div class="task-head-title">Assigned To</div>' +
                        '<div class="task-assignee">' + addeduser.user.firstname + ' ' + addeduser.user.lastname + '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="remove-icon" onclick="tododeletetaskuser(' + addeduser.taskId + ',' + pid + ',' + addeduser.assignee_id + '">' +
                        '<a class="del-msg"><i class="fa fa-close"></i></a></span>';
                });
                $('#todoassigneeinfo_' + tid).html(assignee);
                $('#todoadd_userforalltask_' + tid).hide();
            },
            error: function(e) {}
        });
    }


    //inpro
    function doneselect2function(pid, tid) {
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
                $('#doneassigneeinfo_' + tid).empty();
                var assignee = "";
                data.forEach((addeduser) => {
                    assignee += ' <a href="#" data-toggle="modal" data-target="#assignee">' +
                        '<div class="avatar">' +
                        '<img alt="" src="' + addeduser.user.profileFilepath + '/' + addeduser.user.profileFilename + '">' +
                        '</div>' +
                        '<div class="assigned-info">' +
                        '<div class="task-head-title">Assigned To</div>' +
                        '<div class="task-assignee">' + addeduser.user.firstname + ' ' + addeduser.user.lastname + '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="remove-icon" onclick="donedeletetaskuser(' + addeduser.taskId + ',' + pid + ',' + addeduser.assignee_id + '">' +
                        '<a class="del-msg"><i class="fa fa-close"></i></a></span>';
                });
                $('#doneassigneeinfo_' + tid).html(assignee);
                $('#doneadd_userforalltask_' + tid).modal('hide');

            },

            error: function(e) {}
        });
    }


    //Done task
    function inproselect2function(pid, tid) {
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

                $('#inproassigneeinfo_' + tid).empty();
                var assignee = "";
                data.forEach((addeduser) => {
                    assignee += ' <a href="#" data-toggle="modal" data-target="#assignee">' +
                        '<div class="avatar">' +
                        '<img alt="" src="' + addeduser.user.profileFilepath + '/' + addeduser.user.profileFilename + '">' +
                        '</div>' +
                        '<div class="assigned-info">' +
                        '<div class="task-head-title">Assigned To</div>' +
                        '<div class="task-assignee">' + addeduser.user.firstname + ' ' + addeduser.user.lastname + '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="remove-icon" onclick="tododeletetaskuser(' + addeduser.taskId + ',' + pid + ',' + addeduser.assignee_id + '">' +
                        '<a class="del-msg"><i class="fa fa-close"></i></a></span>';
                });
                $('#inproassigneeinfo_' + tid).html(assignee);
                $('#inproadd_userforalltask_' + tid).hide();
            },
            error: function(e) {}
        });
    }



    function todoaddfollowers(pid, tid) {
        $.ajax({
            url: '/followers/addfollowers/',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': values,
                'pid': pid,
                'tid': tid

            },
            success: function(data) {
                $('#todotask_followersinfo_' + tid).empty();
                var followerhtml = "";
                data.forEach((addfollower) => {
                    if (addfollower.task_id == tid) {
                        followerhtml += '<a class="avatar" href="#" data-toggle="tooltip" title="' + addfollower.user.firstname + '' + addfollower.user.lastname + '">' +
                            '<img alt="" src="' + addfollower.user.profileFilepath + '/' + addfollower.user.profileFilename + '">' +
                            '</a>';
                    }
                });
                $('#todotask_followersinfo_' + tid).html(followerhtml);
                $('#todoadd_followerfortask_' + tid).hide();
            },
            error: function(e) {}
        });
    }


    function inproaddfollowers(pid, tid) {
        $.ajax({
            url: '/followers/addfollowers/',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': values,
                'pid': pid,
                'tid': tid
            },
            success: function(data) {
                $('#inprotask_followersinfo_' + tid).empty();
                var followerhtml = "";
                data.forEach((addfollower) => {
                    if (addfollower.task_id == tid) {
                        console.log(addfollower, 'this is first follower');
                        followerhtml += '<a class="avatar" href="#" data-toggle="tooltip" title="' + addfollower.user.firstname + '' + addfollower.user.lastname + '">' +
                            '<img alt="" src="' + addfollower.user.profileFilepath + '/' + addfollower.user.profileFilename + '">' +
                            '</a>';
                    }
                });
                $('#inprotask_followersinfo_' + tid).html(followerhtml);
                $('#inproadd_followerfortask_' + tid).hide();
            },
            error: function(e) {}
        });


    }

    function doneaddfollowers(pid, tid) {
        $.ajax({
            url: '/followers/addfollowers/',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': values,
                'pid': pid,
                'tid': tid
            },
            success: function(data) {
                $('#donetask_followersinfo_' + tid).empty();
                var followerhtml = "";
                data.forEach((addfollower) => {
                    if (addfollower.task_id == tid) {
                        followerhtml += '<a class="avatar" href="#" data-toggle="tooltip" title="' + addfollower.user.firstname + '' + addfollower.user.lastname + '">' +
                            '<img alt="" src="' + addfollower.user.profileFilepath + '/' + addfollower.user.profileFilename + '">' +
                            '</a>';
                    }
                });
                $('#donetask_followersinfo_' + tid).html(followerhtml);
                $('#doneadd_followerfortask_' + tid).hide();
            },
            error: function(e) {}
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


    //inpromarkcomplete
    function inpromarkcomplete(user_id, tid, status) {
        var realClass = $("#task_inpro_" + tid).attr("class");
        var controlsEnabled = 0;
        if (realClass == "task-complete-btn") {
            $("#task_inpro_" + tid).addClass('task-completed');
            controlsEnabled = 1;
        } else {
            $("#task_inpro_" + tid).removeClass('task-completed');
            controlsEnabled = 0;
        }
        var dummy = 'mark';
        $.ajax({
            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
                'controlsEnabled': controlsEnabled,
                'status': status,
                'dummy': dummy

            },
            success: function(data) {
                $('#inprotaskinfo').empty();
                var taskdata = "";
                let status;
                data.forEach((task) => {
                    if (task.status == 'T') {
                        status = 'Todo';
                    } else if (task.status == 'I') {
                        status = 'InProgress';
                    } else {
                        status = 'Completed'
                    }
                    if (task.id == tid) {
                        taskdata += '<span class="task-info-line">' +
                            '<a class="task-user" href="#" >' + task.statusupdatedby.firstname + ' ' + task.statusupdatedby.lastname + '</a>' +
                            '<span class="task-info-subject" > Marked task as ' + status + '</span>' +
                            '</span>' +
                            '<div class="task-time">' + task.creation_date + '</div>';
                    }
                });
                $('#inprotaskinfo').append(taskdata);
            },
            error: function(a, b, c) {}
        });
    }


    //donemarkcomplete
    function donemarkcomplete(user_id, tid, status) {
        var realClass = $("#task_done_" + tid).attr("class");
        var controlsEnabled = 0;
        if (realClass == "task-complete-btn") {
            $("#task_done_" + tid).addClass('task-completed');
            controlsEnabled = 1;
        } else {
            $("#task_done_" + tid).removeClass('task-completed');
            controlsEnabled = 0;
        }
        var dummy = 'mark';
        $.ajax({
            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
                'controlsEnabled': controlsEnabled,
                'status': status,
                'dummy': dummy
            },
            success: function(data) {
                $('#donetaskinfo').empty();
                var taskdata = "";
                let status;
                data.forEach((task) => {
                    if (task.status == 'T') {
                        status = 'Todo';
                    } else if (task.status == 'I') {
                        status = 'InProgress';
                    } else {
                        status = 'Completed'
                    }
                    if (task.id == tid) {
                        taskdata += '<span class="task-info-line">' +
                            '<a class="task-user" href="#" >' + task.statusupdatedby.firstname + ' ' + task.statusupdatedby.lastname + '</a>' +
                            '<span class="task-info-subject" > Marked task as ' + status + '</span>' +
                            '</span>' +
                            '<div class="task-time">' + task.creation_date + '</div>';
                    }
                });
                $('#donetaskinfo').append(taskdata);
            },
            error: function(a, b, c) {}
        });
    }

    function tododeletetaskuser(tid, pid, uid) {
        $.ajax({
            url: '/taskusers/deletetaskuser/',
            method: 'post',
            dataType: 'json',
            data: {
                'uid': uid,
                'pid': pid,
                'tid': tid

            },
            success: function(data) {

                $('#todoassigneeinfo_' + tid).empty();
                var assignee = "";
                data.forEach((addeduser) => {
                    assignee += ' <a href="#" data-toggle="modal" data-target="#assignee">' +
                        '<div class="avatar">' +
                        '<img alt="" src="/' + addeduser.user.profileFilepath + '/' + addeduser.user.profileFilename + '">' +
                        '</div>' +
                        '<div class="assigned-info">' +
                        '<div class="task-head-title">Assigned To</div>' +
                        '<div class="task-assignee">' + addeduser.user.firstname + ' ' + addeduser.user.lastname + '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="remove-icon" onclick="tododeletetaskuser(' + addeduser.taskId + ',' + pid + ',' + addeduser.assignee_id + ')">' +
                        '<a class="del-msg"><i class="fa fa-close"></i></a></span>';

                    '</span>';
                });
                $('#todoassigneeinfo_' + tid).html(assignee);
                $('#todoadd_userforalltask_' + tid).modal('hide');
            },
            error: function(e) {}
        });

    }

    function inprodeletetaskuser(tid, pid, uid) {
        $.ajax({
            url: '/taskusers/deletetaskuser/',
            method: 'post',
            dataType: 'json',
            data: {
                'uid': uid,
                'pid': pid,
                'tid': tid
            },
            success: function(data) {
                $('#inproassigneeinfo_' + tid).empty();
                var assignee = "";
                data.forEach((addeduser) => {
                    assignee += ' <a href="#" data-toggle="modal" data-target="#assignee">' +
                        '<div class="avatar">' +
                        '<img alt="" src="/' + addeduser.user.profileFilepath + '/' + addeduser.user.profileFilename + '">' +
                        '</div>' +
                        '<div class="assigned-info">' +
                        '<div class="task-head-title">Assigned To</div>' +
                        '<div class="task-assignee">' + addeduser.user.firstname + ' ' + addeduser.user.lastname + '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="remove-icon" onclick="inprodeletetaskuser(' + addeduser.taskId + ',' + pid + ',' + addeduser.assignee_id + ')">' +
                        '<a class="del-msg"><i class="fa fa-close"></i></a></span>';
                    '</span>';
                });
                $('#inproassigneeinfo_' + tid).html(assignee);
                $('#inproadd_userforalltask_' + tid).modal('hide');
            },
            error: function(e) {}
        });

    }

    function donedeletetaskuser(tid, pid, uid) {
        $.ajax({
            url: '/taskusers/deletetaskuser/',
            method: 'post',
            dataType: 'json',
            data: {
                'uid': uid,
                'pid': pid,
                'tid': tid
            },
            success: function(data) {
                $('#doneassigneeinfo_' + tid).empty();
                var assignee = "";
                data.forEach((addeduser) => {
                    assignee += ' <a href="#" data-toggle="modal" data-target="#assignee">' +
                        '<div class="avatar">' +
                        '<img alt="" src="/' + addeduser.user.profileFilepath + '/' + addeduser.user.profileFilename + '">' +
                        '</div>' +
                        '<div class="assigned-info">' +
                        '<div class="task-head-title">Assigned To</div>' +
                        '<div class="task-assignee">' + addeduser.user.firstname + ' ' + addeduser.user.lastname + '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="remove-icon" onclick="donedeletetaskuser(' + addeduser.taskId + ',' + pid + ',' + addeduser.assignee_id + ')">' +
                        '<a class="del-msg"><i class="fa fa-close"></i></a></span>';
                    '</span>';
                });
                $('#doneassigneeinfo_' + tid).html(assignee);
                $('#doneadd_userforalltask_' + tid).modal('hide');
            },

            error: function(e) {}
        });

    }

    var commentvalue = false;

    function showComments(tid, auth) {
        commentvalue = !commentvalue;
        if ($('#todoviewcomments_' + tid).text() == 'View all Comments') {
            $('#todoviewcomments_' + tid).text('Hide');
        } else {
            $('#todoviewcomments_' + tid).text('View all Comments');
        }
        $('.todoNewCommentsSection_' + tid).show();
        $.ajax({
            url: '/comments/updateIsseen',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
            },
            error: function() {}
        });
    }

    function inproshowComments(tid, auth) {
        commentvalue = !commentvalue;
        if ($('#viewcomments_' + tid).text() == 'View all Comments') {
            $('#viewcomments_' + tid).text('Hide');
        } else {
            $('#viewcomments_' + tid).text('View all Comments');
        }
        $('.inproNewCommentsSection_' + tid).show();
        $.ajax({
            url: '/comments/updateIsseen',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
            },
            success: function(data) {
                inprorenderComments(data, auth, tid, $('#viewcomments_' + tid).text());
            },
            error: function() {}
        });
    }

    function doneshowComments(tid, auth) {
        commentvalue = !commentvalue;
        if ($('#viewcomments_' + tid).text() == 'View all Comments') {
            $('#viewcomments_' + tid).text('Hide');
        } else {
            $('#viewcomments_' + tid).text('View all Comments');
        }
        $('.doneNewCommentsSection_' + tid).show();
        $.ajax({
            url: '/comments/updateIsseen',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
            },
            success: function(data) {
                donerenderComments(data, auth, tid, $('#viewcomments_' + tid).text());
            },

            error: function() {}
        });
    }


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
</script>
