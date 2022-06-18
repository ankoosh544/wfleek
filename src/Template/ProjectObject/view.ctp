<style>
    .button-sk {
        display: flex;
        margin-top: 10 px;
        justify-content: end;
        width: 100%;
        padding: 15 px;

    }

    .atagcss {
        cursor: pointer;
    }

    .innerbuttonsweb {

        display: flex;
        justify-content: space-between;
        width: 28%;
    }
</style>

<?php

use Cake\I18n\Number;

?>
<?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
    <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
        <?php if ($usermodule->module->name == 'Projects' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
            <!-- Page Wrapper -->
            <div class="page-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="width: 50%;display: flex;justify-content: space-between;">
                                <li class="nav-item">
                                    <a href="/projecttasks/newticket?pid=<?= $projectObject->id ?>" class="nav-link btn btn-info" data-mdb-ripple-color="dark">Create Ticket </a>
                                </li>
                                <li class="nav-item">
                                    <?php if (!empty($projectObject->contracts[0])) : ?>
                                        <?php if ($projectObject->contracts[0]->acceptance_date != null) : ?> <div class="col-auto float-right ml-auto">
                                                <a class="nav-link btn btn-info" href="/project-object/contractsummary?projectId=<?= $projectObject->id ?>&&contractId=<?= $projectObject->contracts[0]->id ?>" data-mdb-ripple-color="dark">Contract</a>
                                            <?php else : ?>
                                                <a class="nav-link btn btn-info" href="/project-object/summaryPrices?projectId=<?= $projectObject->id ?>" data-mdb-ripple-color="dark" type="submit">Summary</a>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <a class="nav-link btn btn-info" href="/project-object/summaryPrices?projectId=<?= $projectObject->id ?>" data-mdb-ripple-color="dark" type="submit">Summary</a>
                                        <?php endif; ?>
                                </li>
                                <?php if ($usermodule->isWrite == true) : ?>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link btn btn-info" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-plus"></i> Edit Project</a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item ">
                                    <a class="nav-link btn btn-info" href="/project-object/ganttdata/<?= $projectObject->id ?>" data-mdb-ripple-color="dark"> Tasks-Gantt</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link btn btn-info" href="/project-object/contractversions/<?= $projectObject->id ?>" data-mdb-ripple-color="dark">Projects-Gantt</a>
                                </li>

                                <li class="nav-item ">
                                    <a href="/project-object/comments?projectId=<?= $projectObject->id ?>" class="nav-link btn btn-info" data-mdb-ripple-color="dark">Comments</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Page Content -->
                <div class="content container-fluid">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <div>
                                    <h3 class="page-title"><?= $projectObject->name ?></h3>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Project</li>
                                    </ul>
                                </div>
                                <div class="view-icons">
                                    <div class="col-auto float-right ml-auto">
                                        <a href="/project-object/index?companyId=<?= $userData->choosen_companyId ?>&&type=<?= $type ?>" class="grid-view btn btn-link active"><i class="fa fa-th"></i> Projects </a>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <a href="/project-object/taskboard/<?= $projectObject->id ?>" class="btn btn-white float-right m-r-10 " data-toggle="tooltip" title="Task Board"><i class="fa fa-bars"></i> Task Board </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- /Page Header -->

                    <div class="row">
                        <?php if ($member_role->designation->name == 'Administrator') : ?>
                            <div class="col-lg-8 col-xl-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="project-title">
                                            <h5 class="card-title"><?= $projectObject->name ?></h5>
                                            <?php $opentask = 0;
                                            $completedtask = 0 ?>
                                            <?php foreach ($projectObject->projecttasks as $task) : ?>
                                                <?php if ($task->status == 'T' or $task->status == 'I') : ?>
                                                    <?php $opentask = $opentask + 1;    ?>
                                                <?php elseif ($task->status == 'D') : ?>
                                                    <?php $completedtask = $completedtask + 1; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php $totaltasks = $opentask + $completedtask ?>
                                            <small class="block text-ellipsis m-b-15"><span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span><span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span></small>
                                        </div>
                                        <p> <?= nl2br($projectObject->description) ?> </p>
                                        <p> <?= nl2br($projectObject->description2) ?></p>
                                    </div>
                                </div>
                                <?php if (!empty($projectObject->projectfiles)) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-20">Uploaded files</h5>
                                            <ul class="files-list">
                                                <?php foreach ($projectObject->projectfiles as $file) : ?>
                                                    <?php
                                                    $path = WWW_ROOT . str_replace('/', '\\', $file->filepath . DS . $file->filename);
                                                    $ext  = (new SplFileInfo($path))->getExtension();
                                                    ?>
                                                    <li>
                                                        <div class="files-cont">
                                                            <div class="file-type">
                                                                <?php if ($ext == 'pdf') : ?>
                                                                    <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                <?php elseif ($ext == 'word') : ?>
                                                                    <span class="files-icon"><i class="fa fa-file-word-o"></i></span>
                                                                <?php elseif ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp') : ?>
                                                                    <span class="files-icon"><i class="fa fa-image"></i></span>
                                                                <?php else : ?>
                                                                    <span class="files-icon"><i class="fa fa-file"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="files-info">
                                                                <span class="file-name text-ellipsis"><a href="#"><?= $file->filename ?></a></span>
                                                                <span class="file-author"><a href="#">
                                                                    </a></span>
                                                                <span class="file-date">
                                                                    <?php if (!empty($file->creation_date)) : ?>
                                                                        <?= $file->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                                <div class="file-size">Size: <?= Number::toReadableSize($file->size); ?></div>
                                                            </div>
                                                            <ul class="files-action">
                                                                <li class="dropdown dropdown-action">
                                                                    <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">

                                                                        <?php if ($usermodule->isImport == true && $usermodule->isExport == true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php elseif ($usermodule->isImport == true && $usermodule->isExport == true && $usermodule->isDelete != true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                        <?php elseif ($usermodule->isImport == true && $usermodule->isExport != true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php elseif ($usermodule->isImport != true && $usermodule->isExport == true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php elseif ($usermodule->isImport == true && $usermodule->isExport != true && $usermodule->isDelete != true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                        <?php elseif ($usermodule->isImport != true && $usermodule->isExport == true && $usermodule->isDelete != true) : ?>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                        <?php elseif ($usermodule->isImport != true && $usermodule->isExport != true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php endif; ?>


                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <!-- Delete File Modal -->
                                                    <div class="modal" id="delete_approvefile_<?= $projectObject->id ?>_<?= $file->id ?>" role="dialog" style="z-index: 999 important!;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="form-header">
                                                                        <h3>Delete File</h3>
                                                                        <p>Are you sure want to Delete this File?</p>
                                                                    </div>
                                                                    <div class="modal-btn delete-action">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <a href="/project-object/deletefile?fileId=<?= $file->id ?>&pid=<?= $projectObject->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <a href="javascript:void(0);" onclick="closedeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)" class="btn btn-primary cancel-btn">Cancel</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Delete file Modal -->
                                                <?php endforeach; ?>

                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="project-task">
                                    <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                                        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                                            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                                <?php if ($usermodule->module->name == 'Tasks' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                    <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">All Tasks</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>


                                            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                                <?php if ($usermodule->module->name == 'Tickets' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                    <li class="nav-item"><a class="nav-link" href="#project_tickets" data-toggle="tab" aria-expanded="false">Tickets</a></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="tab-content">
                                        <!------------alltaskss---------------------------->
                                        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                                            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                                <?php if ($usermodule->module->name == 'Tasks' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                    <div class="tab-pane show active" id="all_tasks">
                                                        <div class="task-wrapper">
                                                            <div class="task-list-container">
                                                                <div class="task-list-body">

                                                                    <ul id="task-list">
                                                                        <?php foreach ($projectObject->projecttasks as $task) : ?>
                                                                            <?php if ($task->type != 'TC') : ?>
                                                                                <li class="task">
                                                                                    <div class="task-container">
                                                                                        <span class="task-action-btn task-check">
                                                                                            <?php if ($task->status == 'D') : ?>
                                                                                                <span class="action-circle large completed" title="Mark Complete">
                                                                                                    <?php if ($usermodule->isWrite == true) : ?>
                                                                                                        <a href="#" data-toggle="modal" data-target="#alltaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                                    <?php else : ?>
                                                                                                        <a href="#"> <i class="material-icons">check</i></a>
                                                                                                    <?php endif; ?>
                                                                                                </span>

                                                                                            <?php else : ?>
                                                                                                <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                                    <?php if ($usermodule->isWrite == true) : ?>
                                                                                                        <a href="#" data-toggle="modal" data-target="#alltaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                                    <?php else : ?>
                                                                                                        <a href="#"> <i class="material-icons">check</i></a>
                                                                                                    <?php endif; ?>
                                                                                                </span>
                                                                                            <?php endif; ?>

                                                                                        </span>
                                                                                        <span class="task-label"><a class="atagcss" href="/projecttasks/taskview/<?= $task->id ?>"><?= $task->title ?></a></span>
                                                                                        <!------task user ---------->

                                                                                        <div class="form-control">

                                                                                            <div class="avatar-group deleteuser">

                                                                                                <?php foreach ($task->taskusers as $taskuser) : ?>

                                                                                                    <div class="avatar">
                                                                                                        <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                        <?php else : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                        <?php endif; ?>
                                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                                            <a data-toggle="modal" data-target="#delete_taskuser_<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                        <?php endif; ?>
                                                                                                    </div>


                                                                                                    <!-- Delete Taskuser Modal -->

                                                                                                    <?= $this->element('delete_taskuser', [
                                                                                                        'taskuser' => $taskuser,
                                                                                                        'task' => $task
                                                                                                    ]) ?>

                                                                                                    <!-- /Delete taskuser Modal -->

                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!---------/teamtask---------------------->
                                                                                        <?php if ($member_role->designation->name == 'Administrator') : ?>

                                                                                            <span class="task-action-btn ">
                                                                                                <?php if ($usermodule->isWrite == true) : ?>
                                                                                                    <span class="action-circle large" title="Assign">
                                                                                                        <a href="#" data-toggle="modal" data-target="#assign_alltaskuser_<?= $task->id ?>"><i class="material-icons">person_add</i></a>
                                                                                                    </span>
                                                                                                <?php endif; ?>
                                                                                                <?php if ($usermodule->isDelete == true) : ?>
                                                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                        <a href="/projecttasks/deletesingletask?tid=<?= $task->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                                    </span>
                                                                                                <?php endif; ?>
                                                                                            </span>
                                                                                        <?php endif; ?>

                                                                                        <!---------------------Assign User for Task------------------------------------------>
                                                                                        <?= $this->element('assign_taskuser', [
                                                                                            'task' => $task,
                                                                                            'projectMembers' => $projectObject->projectmembers,
                                                                                            'alltasks' => $task
                                                                                        ]) ?>

                                                                                        <!--------------------/Assign User for task------------------------------------------>

                                                                                        <!---------------------------Alltask Update Statu---------------------------------------------->
                                                                                        <div id="alltaskupdateStatus_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title">Assign the user to task</h5>
                                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                            <span aria-hidden="true">&times;</span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="form-group form-focus select-focus m-b-30">

                                                                                                            <div class="form-group form-focus select-focus">
                                                                                                                <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDiv_<?= $task->id ?>"></span>
                                                                                                                <select class="select floating" id="taskStatus" name="taskStatus" onchange="changeStatusTodo(this,<?= $task->id ?>); return false;">
                                                                                                                    <option value="">--Select--</option>
                                                                                                                    <option value="T"> To Do</option>
                                                                                                                    <option value="I">In Prograss</option>
                                                                                                                    <option value="D">Done</option>
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <br />
                                                                                                        </div>

                                                                                                    </div>
                                                                                                </div>
                                                                                                <br />
                                                                                            </div>
                                                                                        </div>
                                                                                        <!---------------------------Alltask Update Statu---------------------------------------------->
                                                                                    </div>
                                                                                </li>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
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

                                                    <!------------pendingtasks---------------------------->
                                                    <div class="tab-pane" id="pending_tasks">
                                                        <div class="task-wrapper">
                                                            <div class="task-list-container">
                                                                <div class="task-list-body">
                                                                    <ul id="task-list">
                                                                        <?php foreach ($projectObject->projecttasks as $task) : ?>
                                                                            <?php if ($task->type != 'TC' && $task->status == 'I') : ?>
                                                                                <li class="task">
                                                                                    <div class="task-container">
                                                                                        <span class="task-action-btn task-check">
                                                                                            <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                                <?php if ($usermodule->isWrite == true) : ?>
                                                                                                    <a href="#" data-toggle="modal" data-target="#pendingtaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                                <?php else : ?>
                                                                                                    <a href="#"> <i class="material-icons">check</i></a>
                                                                                                <?php endif; ?>
                                                                                            </span>
                                                                                        </span>
                                                                                        <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $task->id ?>"><?= $task->title ?></a></span>

                                                                                        <!------task user ---------->

                                                                                        <div class="form-control">

                                                                                            <div class="avatar-group deleteuser">

                                                                                                <?php foreach ($task->taskusers as $taskuser) : ?>

                                                                                                    <div class="avatar">
                                                                                                        <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                        <?php else : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                        <?php endif; ?>
                                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                                            <a data-toggle="modal" data-target="#delete_taskuser_<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                        <?php endif; ?>
                                                                                                    </div>


                                                                                                    <!-- Delete Taskuser Modal -->
                                                                                                    <?= $this->element('delete_taskuser', [
                                                                                                        'taskuser' => $taskuser,
                                                                                                        'task' => $task
                                                                                                    ]) ?>
                                                                                                    <!-- /Delete taskuser Modal -->
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <span class="task-action-btn ">
                                                                                            <?php if ($usermodule->isWrite == true) : ?>
                                                                                                <span class="action-circle large" title="Assign">
                                                                                                    <a href="#" data-toggle="modal" data-target="#assign_pendingtaskuser_<?= $task->id ?>"><i class="material-icons">person_add</i></a>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                            <?php if ($usermodule->isDelete == true) : ?>
                                                                                                <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                    <a href="/projecttasks/deletesingletask?tid=<?= $task->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                    </div>
                                                                                    <!---------------------Assign User for Task------------------------------------------>
                                                                                    <?= $this->element('assign_taskuser', [
                                                                                        'task' => $task,
                                                                                        'pendingtasks' => $task,
                                                                                        'projectMembers' => $projectObject->projectmembers
                                                                                    ]) ?>
                                                                                    <!-----------------/Assign User for task------------------------------------------>



                                                                                    <!-----------------------Pending task update------>
                                                                                    <div id="pendingtaskupdateStatus_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title">Assign the user to task</h5>
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div class="form-group form-focus select-focus m-b-30">

                                                                                                        <div class="form-group form-focus select-focus">
                                                                                                            <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivInpro_<?= $task->id ?>"></span>
                                                                                                            <select class="select floating" id="taskStatus" name="taskStatus" onchange="changeStatusIn(this,<?= $task->id ?>); return false;">
                                                                                                                <option value="T"> To Do</option>
                                                                                                                <option selected value="I">In Progress</option>
                                                                                                                <option value="D">Done</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <br />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <br />
                                                                                        </div>
                                                                                    </div>
                                                                                    <!----------------------------------------------------------->

                                                                                </li>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
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

                                                    <!------------completedtasks---------------------------->
                                                    <div class="tab-pane" id="completed_tasks">
                                                        <div class="task-wrapper">
                                                            <div class="task-list-container">
                                                                <div class="task-list-body">
                                                                    <ul id="task-list">
                                                                        <?php foreach ($projectObject->projecttasks as $task) : ?>
                                                                            <?php if ($task->type != 'TC' && $task->status == 'D') : ?>
                                                                                <li class="task">
                                                                                    <div class="task-container">
                                                                                        <span class="task-action-btn task-check">
                                                                                            <span class="action-circle large completed" title="Mark Complete">
                                                                                                <?php if ($usermodule->isWrite == true) : ?>
                                                                                                    <a href="#" data-toggle="modal" data-target="#updatecompletedtaskStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                                <?php else : ?>
                                                                                                    <a href="#"> <i class="material-icons">check</i></a>
                                                                                                <?php endif; ?>
                                                                                            </span>
                                                                                        </span>
                                                                                        <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $task->id ?>"><?= $task->title ?></a></span>
                                                                                        <!------task user ---------->

                                                                                        <div class="form-control">

                                                                                            <div class="avatar-group deleteuser">

                                                                                                <?php foreach ($task->taskusers as $taskuser) : ?>

                                                                                                    <div class="avatar">
                                                                                                        <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                        <?php else : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                        <?php endif; ?>

                                                                                                        <?php if ($usermodule->isDelete == true) : ?>
                                                                                                            <a data-toggle="modal" data-target="#delete_taskuser_<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                        <?php endif; ?>
                                                                                                    </div>


                                                                                                    <!-- Delete Taskuser Modal -->

                                                                                                    <?= $this->element('delete_taskuser', [
                                                                                                        'taskuser' => $taskuser,
                                                                                                        'task' => $task
                                                                                                    ]) ?>


                                                                                                    <!-- /Delete taskuser Modal -->
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <span class="task-action-btn ">
                                                                                            <?php if ($usermodule->isWrite == true) : ?>
                                                                                                <span class="action-circle large" title="Assign">
                                                                                                    <a href="#" data-toggle="modal" data-target="#add_completedtaskusers_<?= $task->id ?>"> <i class="material-icons">person_add</i></a>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                            <?php if ($usermodule->isDelete == true) : ?>
                                                                                                <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                    <a href="/projecttasks/deletesingletask?tid=<?= $task->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                    </div>
                                                                                    <!---------------------Assign User for Task------------------------------------------>
                                                                                    <?= $this->element('assign_taskuser', [
                                                                                        'task' => $task,
                                                                                        'completedtasks' => $task,
                                                                                        'projectMembers' => $projectObject->projectmembers
                                                                                    ]) ?>

                                                                                    <!--------------------/Assign User for task------------------------------------------>

                                                                                    <!---------------------------completed tASK Update Statu---------------------------------------------->
                                                                                    <div id="updatecompletedtaskStatus_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title">Assign the user to task</h5>
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div class="form-group form-focus select-focus m-b-30">

                                                                                                        <div class="form-group form-focus select-focus">
                                                                                                            <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivDone_<?= $task->id ?>"></span>
                                                                                                            <select class="select2-icon floating" id="taskStatus" name="taskStatus" onchange="changeStatusDone(this,<?= $task->id ?>); return false;">
                                                                                                                <option value="">-----Select-----</option>
                                                                                                                <option value="T"> To Do</option>
                                                                                                                <option value="I">In Prograss</option>
                                                                                                                <option selected value="D">Done</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <br />
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <br />
                                                                                        </div>
                                                                                    </div>
                                                                                    <!---------------------------completed task Update Statu---------------------------------------------->
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
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
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <!------------project Tickets---------------------------->
                                        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                                            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                                <?php if ($usermodule->module->name == 'Tickets' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                    <div class="tab-pane" id="project_tickets">
                                                        <div class="task-wrapper">
                                                            <div class="task-list-container">
                                                                <div class="task-list-body">
                                                                    <ul id="task-list">
                                                                        <?php foreach ($projectObject->projecttasks as $ticket) : ?>
                                                                            <?php if ($ticket->type == 'TC' && $ticket->category == 'Work') : ?>
                                                                                <li class="task">
                                                                                    <div class="task-container">
                                                                                        <span class="task-action-btn task-check">
                                                                                            <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                                <?php if ($usermodule->isWrite == true) : ?>
                                                                                                    <a href="#" data-toggle="modal" data-target="#updatecompletedtaskStatus_<?= $ticket->id ?>"> <i class="material-icons">check</i></a>
                                                                                                <?php else : ?>
                                                                                                    <a href="#"> <i class="material-icons">check</i></a>
                                                                                                <?php endif; ?>
                                                                                            </span>
                                                                                        </span>
                                                                                        <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $ticket->id ?>"><?= $ticket->title ?></a></span>
                                                                                        <!------task user ---------->

                                                                                        <div class="form-control">

                                                                                            <div class="avatar-group deleteuser">

                                                                                                <?php foreach ($ticket->taskusers as $taskuser) : ?>

                                                                                                    <div class="avatar">
                                                                                                        <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                        <?php else : ?>
                                                                                                            <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                        <?php endif; ?>
                                                                                                        <?php if ($usermodule->isDelete == true) : ?>
                                                                                                            <a data-toggle="modal" data-target="#delete_taskuser_<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                        <?php endif; ?>
                                                                                                    </div>
                                                                                                    <!-- Delete Taskuser Modal -->
                                                                                                    <?= $this->element('delete_taskuser', [
                                                                                                        'taskuser' => $taskuser,
                                                                                                        'task' => $task
                                                                                                    ]) ?>
                                                                                                    <!-- /Delete taskuser Modal -->
                                                                                                <?php endforeach; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <span class="task-action-btn ">
                                                                                            <?php if ($usermodule->isWrite == true) : ?>
                                                                                                <span class="action-circle large" title="Assign">
                                                                                                    <a href="#" data-toggle="modal" data-target="#assign_taskuser_<?= $ticket->id ?>"> <i class="material-icons">person_add</i></a>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                            <?php if ($usermodule->isDelete == true) : ?>
                                                                                                <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                    <a href="/projecttasks/deletesingletask?tid=<?= $ticket->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                    </div>
                                                                                    <!---------------------Assign User for Task------------------------------------------>
                                                                                    <?= $this->element('assign_taskuser', [
                                                                                        'task' => $ticket,
                                                                                        'projectMembers' => $projectObject->projectmembers
                                                                                    ]) ?>

                                                                                    <!--------------------/Assign User for task------------------------------------------>

                                                                                    <!---------------------------completed tASK Update Statu---------------------------------------------->
                                                                                    <div id="updatecompletedtaskStatus_<?= $ticket->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h5 class="modal-title">Assign the user to task</h5>
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <div class="form-group form-focus select-focus m-b-30">

                                                                                                        <div class="form-group form-focus select-focus">
                                                                                                            <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivDone_<?= $ticket->id ?>"></span>
                                                                                                            <select class="select2-icon floating" id="taskStatus" name="taskStatus" onchange="changeStatusDone(this,<?= $ticket->id ?>); return false;">
                                                                                                                <option value="T" data-toggle="modal" data-target="#approve_leave"> To Do</option>
                                                                                                                <option value="I">In Prograss</option>
                                                                                                                <option selected value="D">Done</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <br />
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <br />
                                                                                        </div>
                                                                                    </div>
                                                                                    <!---------------------------completed task Update Statu---------------------------------------------->
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
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
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $totalprice = 0;
                            $totaltax = 0;
                            $totalhrs = 0;
                            foreach ($projectObject->projecttasks as $task) {
                                $diff = abs(strtotime($task->expiration_date) - strtotime($task->startdate));
                                $years = floor($diff / (365 * 60 * 60 * 24));
                                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                $totalhrs = $totalhrs + ($days + 1) * 8;
                                $totalprice = $totalprice + $task->price;
                                $tax = ($task->tax_percentage / 100) * $task->price;
                                $totaltax = $totaltax + $tax;
                            }
                            ?>

                            <div class="col-lg-4 col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title m-b-15">Project details</h6>
                                        <table class="table table-striped table-border">
                                            <tbody>
                                                <tr>
                                                    <td>Cost: </td>
                                                    <td class="text-right">
                                                        <?php if (!empty($contract)) : ?>
                                                            <?php foreach ($contract as $singleContract) : ?>
                                                                <?php if ($singleContract->project_object_id == $projectObject->id && $singleContract->acceptance_date != null) : ?>
                                                                    <form method="post" action="/project-object/contractsummary?projectId=<?= $projectObject->id ?>&&contractId=<?= $singleContract->id ?>" enctype="multipart/form-data">
                                                                        <input type="hidden" name="prid" id="id" value="<?= $projectObject->id ?>">

                                                                        <button class="btn btn-light" data-mdb-ripple-color="dark" type="submit"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></button>
                                                                    </form>
                                                                <?php endif; ?>
                                                                <?php if ($singleContract->project_object_id == $projectObject['id'] && $singleContract->acceptance_date == null) : ?>
                                                                    <form method="post" action="/project-object/summaryPrices" enctype="multipart/form-data">
                                                                        <input type="hidden" name="id" id="id" value="<?= $projectObject["id"] ?>">
                                                                        <button class="btn btn-light" data-mdb-ripple-color="dark" type="submit"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php else : ?>
                                                            <form method="post" action="/project-object/summaryPrices" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" id="id" value="<?= $projectObject["id"] ?>">
                                                                <button class="btn btn-light" data-mdb-ripple-color="dark" type="submit"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></button>
                                                            </form>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Hours:</td>
                                                    <td class="text-right"><?= $totalhrs ?> Hours</td>
                                                </tr>
                                                <tr>
                                                    <td>Created:</td>
                                                    <td class="text-right"><?= $projectObject->createDate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Deadline:</td>
                                                    <td class="text-right"><?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Priority:</td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="#" class="badge badge-danger dropdown-toggle" data-toggle="dropdown">Highest </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Highest priority</a>
                                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> High priority</a>
                                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-primary"></i> Normal priority</a>
                                                                <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Low priority</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Created by:</td>
                                                    <td class="text-right">
                                                        <a href="profile.html"><?= $projectObject->user->firstname ?> <?= $projectObject->user->lastname ?></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Status:</td>
                                                    <td class="text-right">Working</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php if ($totaltasks != 0) : ?>
                                            <p class="m-b-5">Progress <span class="text-success float-right"><?= round($completedtask / ($totaltasks) * 100); ?>%</span></p>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="<?= round($completedtask / ($totaltasks) * 100); ?>%" style="width: <?= round($completedtask / ($totaltasks) * 100); ?>%"></div>
                                            </div>
                                        <?php else : ?>

                                            <p class="m-b-5">Progress <span class="text-success float-right">0%</span></p>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="0%" style="width: 0%"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card project-client">
                                    <div class="card-body">
                                        <h6 class="card-title m-b-20">Assigned Client
                                            <?php if ($usermodule->isWrite == true) : ?>
                                                <button type="button" class="float-right btn btn-primary btn-sm" data-toggle="modal" data-target="#assign_client"><i class="fa fa-plus"></i> Add</button>
                                            <?php endif; ?>
                                        </h6>
                                        <ul class="list-box">
                                            <?php foreach ($projectObject->projectmembers as $client) : ?>
                                                <?php if ($client->designation->name == 'Customer') : ?>
                                                    <li>
                                                        <a href="/user/view/<?= $client->user->id ?>">
                                                            <div class="list-item">
                                                                <div class="list-left">
                                                                    <span class="avatar">
                                                                        <?php if ($client->user->profileFilepath != null && $client->user->profileFilename != null) : ?>
                                                                            <img alt="" src="<?= $client->user->profileFilepath ?>/<?= $client->user->profileFilename ?>">
                                                                        <?php else : ?>
                                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                        <?php endif; ?>
                                                                    </span>
                                                                </div>
                                                                <div class="list-body">
                                                                    <span class="message-author"><?= $client->user->firstname ?> <?= $client->user->lastname ?></span>
                                                                    <?php if ($usermodule->isWrite == true) : ?>
                                                                        <a data-toggle="modal" data-target="#delete_approve_<?= $projectObject->id ?>_<?= $client->memberId ?>" class="del-msg"><i class="fa fa-trash-o"></i></a>
                                                                    <?php endif; ?>

                                                                    <!-- Delete Member  ProjectManager Modal -->
                                                                    <?= $this->element('delete_userfromproject', [
                                                                        'projectObject' => $projectObject,
                                                                        'client' => $client

                                                                    ]) ?>

                                                                    <!-- /Delete ProjectManager Modal -->
                                                                    <div class="clearfix"></div>
                                                                    <span class="message-content">Customer</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card project-leader">
                                    <div class="card-body">
                                        <h6 class="card-title m-b-20">Assigned Leader
                                        </h6>
                                        <ul class="list-box">
                                            <?php foreach ($projectObject->projectmembers as $manager) : ?>
                                                <?php if ($manager->designation->name == 'Project Manager') : ?>
                                                    <li>
                                                        <a href="/projectmember/userprofile/<?= $manager->user->id ?>">
                                                            <div class="list-item">
                                                                <div class="list-left">
                                                                    <?php if ($manager->user->profileFilepath != null && $manager->user->profileFilename != null) : ?>
                                                                        <span class="avatar"><img alt="" src="<?= $manager->user->profileFilepath ?>/<?= $manager->user->profileFilename ?>"></span>
                                                                    <?php else : ?>
                                                                        <span class="avatar"><img alt="" src="/assets/img/profiles/avatar-16.jpg"></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="list-body">
                                                                    <span class="message-author"><?= $manager->user->firstname ?> <?= $manager->user->lastname ?></span>
                                                                    <?php if ($usermodule->isWrite == true) : ?>
                                                                        <a data-toggle="modal" data-target="#delete_approve_<?= $projectObject->id ?>_<?= $manager->memberId ?>" class="del-msg"><i class="fa fa-trash-o"></i></a>
                                                                    <?php endif; ?>


                                                                    <!-- Delete Member  ProjectManager Modal -->
                                                                    <?= $this->element('delete_userfromproject', [
                                                                        'projectObject' => $projectObject,
                                                                        'client' => $client

                                                                    ]) ?>
                                                                    <!-- /Delete ProjectManager Modal -->


                                                                    <div class="clearfix"></div>
                                                                    <span class="message-content">Project Manager</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card project-user">
                                    <div class="card-body">
                                        <h6 class="card-title m-b-20">
                                            Assigned users
                                            <?php if ($usermodule->isWrite == true) : ?>
                                                <button type="button" class="float-right btn btn-primary btn-sm" data-toggle="modal" data-target="#assign_user"><i class="fa fa-plus"></i> Add</button>
                                            <?php endif; ?>
                                        </h6>
                                        <ul class="list-box">
                                            <?php foreach ($projectObject->projectmembers as $projectMember) : ?>
                                                <?php if ($projectMember->designation->name != 'Customer') : ?>
                                                    <li>
                                                        <a href="/projectmember/userprofile/<?= $projectMember->user->id ?>">
                                                            <div class="list-item">
                                                                <div class="list-left">
                                                                    <span class="avatar">
                                                                        <?php if ($projectMember->user->profileFilepath != null && $projectMember->user->profileFilename != null) : ?>
                                                                            <img alt="" src="<?= $projectMember->user->profileFilepath ?>/<?= $projectMember->user->profileFilename ?>">
                                                                        <?php else : ?>
                                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                        <?php endif; ?>
                                                                </div>
                                                                <div class="list-body">
                                                                    <span class="message-author"><?= $projectMember->user->firstname ?> <?= $projectMember->user->lastname ?></span>
                                                                    <?php if ($usermodule->isWrite == true) : ?>
                                                                        <a data-toggle="modal" data-target="#delete_approve_<?= $projectObject->id ?>_<?= $projectMember->memberId ?>" class="del-msg"><i class="fa fa-trash-o"></i></a>
                                                                    <?php endif; ?>

                                                                    <!-- Delete Member  ProjectManager Modal -->
                                                                    <?= $this->element('delete_userfromproject', [
                                                                        'projectObject' => $projectObject,
                                                                        'client' => $projectMember

                                                                    ]) ?>
                                                                    <!---------------Delete Project Member-------------------->
                                                                    <div class="clearfix"></div>
                                                                    <span class="message-content"><?= $projectMember->designation->name ?></span>

                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        <?php else : ?>
                            <div class="col-lg-12 col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="project-title">
                                            <h5 class="card-title"><?= $projectObject->name ?></h5>
                                            <?php $opentask = 0;
                                            $completedtask = 0;
                                            foreach ($projectObject->projecttasks as $task) {
                                                if ($task->status == 'T' && $task->type = "TC" or $task->status == 'I' && $task->type = "TC") {
                                                    $opentask = $opentask + 1;
                                                } elseif ($task->status == 'D') {
                                                    $completedtask = $completedtask + 1;
                                                }
                                            }
                                            $totaltasks = $opentask + $completedtask;
                                            ?>
                                            <small class="block text-ellipsis m-b-15"><span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span><span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span></small>
                                        </div>
                                        <p> <?= nl2br($projectObject->description) ?> </p>
                                        <p> <?= nl2br($projectObject->description2) ?></p>
                                    </div>
                                </div>
                                <?php if ($projectObject->projectfiles) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title m-b-20">Uploaded files</h5>
                                            <ul class="files-list">

                                                <?php foreach ($projectObject->projectfiles as $file) : ?>
                                                    <?php
                                                    $path = WWW_ROOT . str_replace('/', '\\', $file->filepath . DS . $file->filename);

                                                    $ext  = (new SplFileInfo($path))->getExtension();

                                                    ?>
                                                    <li>
                                                        <div class="files-cont">
                                                            <div class="file-type">
                                                                <?php if ($ext == 'pdf') : ?>
                                                                    <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                <?php elseif ($ext == 'word') : ?>
                                                                    <span class="files-icon"><i class="fa fa-file-word-o"></i></span>
                                                                <?php elseif ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp') : ?>
                                                                    <span class="files-icon"><i class="fa fa-image"></i></span>
                                                                <?php else : ?>
                                                                    <span class="files-icon"><i class="fa fa-file"></i></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="files-info">
                                                                <span class="file-name text-ellipsis"><a href="#"><?= $file->filename ?></a></span>
                                                                <span class="file-author"><a href="#">

                                                                    </a></span>

                                                                <span class="file-date">
                                                                    <?php if (!empty($file->creation_date)) : ?>
                                                                        <?= $file->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>
                                                                    <?php endif; ?>
                                                                </span>

                                                                <div class="file-size">Size: <?= Number::toReadableSize($file->size); ?></div>
                                                            </div>
                                                            <ul class="files-action">
                                                                <li class="dropdown dropdown-action">
                                                                    <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <?php if ($usermodule->isImport == true && $usermodule->isExport == true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php elseif ($usermodule->isImport == true && $usermodule->isExport == true && $usermodule->isDelete != true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                        <?php elseif ($usermodule->isImport == true && $usermodule->isExport != true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php elseif ($usermodule->isImport != true && $usermodule->isExport == true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php elseif ($usermodule->isImport == true && $usermodule->isExport != true && $usermodule->isDelete != true) : ?>
                                                                            <a class="dropdown-item" href="/projectfiles/downloadfile?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Download</a>
                                                                        <?php elseif ($usermodule->isImport != true && $usermodule->isExport == true && $usermodule->isDelete != true) : ?>
                                                                            <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $projectObject->id ?>">Share</a>
                                                                        <?php elseif ($usermodule->isImport != true && $usermodule->isExport != true && $usermodule->isDelete == true) : ?>
                                                                            <a class="dropdown-item" onclick="opendeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)">Delete</a>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                    <!-- Delete File Modal -->
                                                    <div class="modal" id="delete_approvefile_<?= $projectObject->id ?>_<?= $file->id ?>" role="dialog" style="z-index: 999 important!;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="form-header">
                                                                        <h3>Delete File</h3>
                                                                        <p>Are you sure want to Delete this File?</p>
                                                                    </div>
                                                                    <div class="modal-btn delete-action">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <a href="/project-object/deletefile?fileId=<?= $file->id ?>&pid=<?= $projectObject->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <a href="javascript:void(0);" onclick="closedeletealertModal(<?= $projectObject->id ?>,<?= $file->id ?>)" class="btn btn-primary cancel-btn">Cancel</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Delete file Modal -->
                                                <?php endforeach; ?>

                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>


                                <div class="project-task">
                                    <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                                        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
                                            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                                <?php if ($usermodule->module->name == 'Tasks' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                    <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">All Tasks</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                                <?php if ($usermodule->module->name == 'Tickets' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                    <li class="nav-item"><a class="nav-link" href="#project_tickets" data-toggle="tab" aria-expanded="false">Tickets</a></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="tab-content">
                                    <?php if(!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)): ?>
                                        <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                            <?php if ($usermodule->module->name == 'Tasks' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                <!------------alltasks---------------------------->
                                                <div class="tab-pane show active" id="all_tasks">
                                                    <div class="task-wrapper">
                                                        <div class="task-list-container">
                                                            <div class="task-list-body">
                                                                <ul id="task-list">
                                                                    <?php foreach ($projectObject->projecttasks as $task) : ?>

                                                                        <li class="task">
                                                                            <div class="task-container">
                                                                                <span class="task-action-btn task-check">
                                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                            <a href="#" data-toggle="modal" data-target="#alltaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                        <?php else : ?>
                                                                                            <a href="#"> <i class="material-icons">check</i></a>
                                                                                        <?php endif; ?>
                                                                                    </span>
                                                                                </span>
                                                                                <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $task->id ?>"><?= $task->title ?></a></span>
                                                                                <!------task user ---------->

                                                                                <div class="form-control">
                                                                                    <div class="avatar-group deleteuser">
                                                                                        <?php foreach ($task->taskusers as $taskuser) : ?>
                                                                                            <div class="avatar">
                                                                                                <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                    <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                <?php else : ?>
                                                                                                    <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                <?php endif; ?>

                                                                                                <?php if ($usermodule->isDelete == true) : ?>
                                                                                                    <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        <?php endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <!---------/teamtask---------------------->
                                                                                <?php if ($member_role->designation->name == 'Administrator') : ?>
                                                                                    <span class="task-action-btn ">
                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                            <span class="action-circle large" title="Assign">
                                                                                                <a href="#" data-toggle="modal" data-target="#assign_alltaskuser_<?= $task->id ?>"><i class="material-icons">person_add</i></a>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                        <?php if ($usermodule->isDelete == true) : ?>
                                                                                            <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                <a href="/projecttasks/deletesingletask?tid=<?= $task->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                    </span>
                                                                                <?php endif; ?>

                                                                                <!---------------------Assign User for Task------------------------------------------>
                                                                                <?= $this->element('assign_taskuser', [
                                                                                    'task' => $task,
                                                                                    'projectMembers' => $projectObject->projectmembers,
                                                                                    'alltasks' => $task
                                                                                ]) ?>
                                                                                <!--------------------/Assign User for task------------------------------------------>

                                                                                <!---------------------------Alltask Update Statu---------------------------------------------->
                                                                                <div id="alltaskupdateStatus_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">Assign the user to task</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="form-group form-focus select-focus m-b-30">

                                                                                                    <div class="form-group form-focus select-focus">
                                                                                                        <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDiv_<?= $task->id ?>"></span>
                                                                                                        <select class="select floating" id="taskStatus" name="taskStatus" onchange="changeStatusTodo(this,<?= $task->id ?>); return false;">
                                                                                                            <option value="T"> To Do</option>
                                                                                                            <option value="I">In Prograss</option>
                                                                                                            <option value="D">Done</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <br />
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                        <br />
                                                                                    </div>
                                                                                </div>
                                                                                <!---------------------------Alltask Update Statu---------------------------------------------->
                                                                            </div>
                                                                        </li>

                                                                    <?php endforeach; ?>
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

                                                <!------------pendingtasks---------------------------->
                                                <div class="tab-pane" id="pending_tasks">
                                                    <div class="task-wrapper">
                                                        <div class="task-list-container">
                                                            <div class="task-list-body">
                                                                <ul id="task-list">
                                                                    <?php foreach ($projectObject->projecttasks as $task) : ?>
                                                                        <?php if ($task->status == 'I') : ?>

                                                                            <li class="task">
                                                                                <div class="task-container">
                                                                                    <span class="task-action-btn task-check">
                                                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                            <?php if ($usermodule->isWrite == true) : ?>
                                                                                                <a href="#" data-toggle="modal" data-target="#pendingtaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                            <?php else : ?>
                                                                                                <a href="#"> <i class="material-icons">check</i></a>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                    </span>
                                                                                    <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $task->id ?>"><?= $task->title ?></a></span>


                                                                                    <div class="form-control">

                                                                                        <div class="avatar-group deleteuser">

                                                                                            <?php foreach ($task->taskusers as $taskuser) : ?>
                                                                                                <div class="avatar">
                                                                                                    <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                        <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                    <?php else : ?>
                                                                                                        <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                    <?php endif; ?>
                                                                                                    <?php if ($usermodule->isDelete == true) : ?>
                                                                                                        <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            <?php endforeach; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span class="task-action-btn ">
                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                            <span class="action-circle large" title="Assign">
                                                                                                <a href="#" data-toggle="modal" data-target="#assign_pendingtaskuser_<?= $task->id ?>"><i class="material-icons">person_add</i></a>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                        <?php if ($usermodule->is == true) : ?>
                                                                                            <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                <i class="material-icons">delete</i>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                    </span>
                                                                                </div>


                                                                                <!---------------------Assign User for Task----------------------------------------->
                                                                                <?= $this->element('assign_taskuser', [
                                                                                    'task' => $task,
                                                                                    'projectMembers' => $projectObject->projectmembers,
                                                                                    'pendingtasks' => $task
                                                                                ]) ?>

                                                                                <!-----------------/Assign User for task------------------------------------------>
                                                                                <!-----------------------Pending task update------>
                                                                                <div id="pendingtaskupdateStatus_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">Assign the user to task</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="form-group form-focus select-focus m-b-30">

                                                                                                    <div class="form-group form-focus select-focus">
                                                                                                        <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivInpro_<?= $task->id ?>"></span>
                                                                                                        <select class="select floating" id="taskStatus" name="taskStatus" onchange="changeStatusIn(this,<?= $task->id ?>); return false;">
                                                                                                            <option value="T"> To Do</option>
                                                                                                            <option selected value="I">In Progress</option>
                                                                                                            <option value="D">Done</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <br />
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                        <br />




                                                                                    </div>
                                                                                </div>
                                                                                <!----------------------------------------------------------->

                                                                            </li>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
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

                                                <!------------completedtasks---------------------------->
                                                <div class="tab-pane" id="completed_tasks">
                                                    <div class="task-wrapper">
                                                        <div class="task-list-container">
                                                            <div class="task-list-body">
                                                                <ul id="task-list">
                                                                    <?php foreach ($projectObject->projecttasks as $task) : ?>
                                                                        <?php if ($task->status == 'D') : ?>

                                                                            <li class="task">
                                                                                <div class="task-container">
                                                                                    <span class="task-action-btn task-check">
                                                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                            <?php if ($usermodule->isWrite == true) : ?>
                                                                                                <a href="#" data-toggle="modal" data-target="#updatecompletedtaskStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                                            <?php else : ?>
                                                                                                <a href="#"> <i class="material-icons">check</i></a>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                    </span>
                                                                                    <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $task->id ?>"><?= $task->title ?></a></span>
                                                                                    <!------task user ---------->

                                                                                    <div class="form-control">

                                                                                        <div class="avatar-group deleteuser">

                                                                                            <?php foreach ($task->taskusers as $taskuser) : ?>


                                                                                                <div class="avatar">
                                                                                                    <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                        <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                    <?php else : ?>
                                                                                                        <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                    <?php endif; ?>
                                                                                                    <?php if ($usermodule->isDelete == true) : ?>
                                                                                                        <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            <?php endforeach; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span class="task-action-btn ">
                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                            <span class="action-circle large" title="Assign">
                                                                                                <a href="#" data-toggle="modal" data-target="#assign_completedtaskuser_<?= $task->id ?>"> <i class="material-icons">person_add</i></a>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                        <?php if ($usermodule->isDelete == true) : ?>
                                                                                            <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                <i class="material-icons">delete</i>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                    </span>
                                                                                </div>
                                                                                <!---------------------Assign User for Task------------------------------------------>
                                                                                <?= $this->element('assign_taskuser', [
                                                                                    'task' => $task,
                                                                                    'projectMembers' => $projectObject->projectmembers,
                                                                                    'completedtasks' => $task
                                                                                ]) ?>
                                                                                <!--------------------/Assign User for task------------------------------------------>

                                                                                <!---------------------------completed tASK Update Statu---------------------------------------------->
                                                                                <div id="updatecompletedtaskStatus_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">Assign the user to task</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="form-group form-focus select-focus m-b-30">

                                                                                                    <div class="form-group form-focus select-focus">
                                                                                                        <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivDone_<?= $task->id ?>"></span>
                                                                                                        <select class="select2-icon floating" id="taskStatus" name="taskStatus" onchange="changeStatusDone(this,<?= $task->id ?>); return false;">
                                                                                                            <option value="T" data-toggle="modal" data-target="#approve_leave"> To Do</option>
                                                                                                            <option value="I">In Prograss</option>
                                                                                                            <option selected value="D">Done</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <br />
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                        <br />
                                                                                    </div>
                                                                                </div>
                                                                                <!---------------------------completed task Update Statu---------------------------------------------->
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>

                                        <!------------project Tickets---------------------------->
                                        <?php if(!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)): ?>
                                        <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                                            <?php if ($usermodule->module->name == 'Tickets' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>
                                                <div class="tab-pane" id="project_tickets">
                                                    <div class="task-wrapper">
                                                        <div class="task-list-container">
                                                            <div class="task-list-body">
                                                                <ul id="task-list">
                                                                    <?php foreach ($projectObject->projecttasks as $ticket) : ?>
                                                                        <?php if ($ticket->type == 'TC') : ?>
                                                                            <li class="task">
                                                                                <div class="task-container">
                                                                                    <span class="task-action-btn task-check">
                                                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                                                            <?php if ($usermodule->isWrite == true) : ?>
                                                                                                <a href="#" data-toggle="modal" data-target="#updatecompletedtaskStatus_<?= $ticket->id ?>"> <i class="material-icons">check</i></a>
                                                                                            <?php else : ?>
                                                                                                <a href="#"> <i class="material-icons">check</i></a>
                                                                                            <?php endif; ?>
                                                                                        </span>
                                                                                    </span>
                                                                                    <span class="task-label"><a class="atagcss" href="/projecttasks/view/<?= $ticket->id ?>"><?= $ticket->title ?></a></span>
                                                                                    <!------task user ---------->

                                                                                    <div class="form-control">

                                                                                        <div class="avatar-group deleteuser">

                                                                                            <?php foreach ($ticket->taskusers as $taskuser) : ?>

                                                                                                <div class="avatar">
                                                                                                    <?php if ($taskuser->user->profileFilename != null && $taskuser->user->profileFilepath != null) : ?>
                                                                                                        <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                                                    <?php else : ?>
                                                                                                        <img title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                                    <?php endif; ?>
                                                                                                    <?php if ($usermodule->isDelete == true) : ?>
                                                                                                        <a data-toggle="modal" data-target="#delete_taskuser_<?= $taskuser->user->id ?>" class="del-msg" hidden><i class="fa fa-minus-square-o"></i></a>
                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                                <!-- Delete Taskuser Modal -->
                                                                                                <?= $this->element('delete_taskuser', [
                                                                                                    'taskuser' => $taskuser,
                                                                                                    'task' => $task
                                                                                                ]) ?>
                                                                                                <!-- /Delete taskuser Modal -->
                                                                                            <?php endforeach; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <span class="task-action-btn ">
                                                                                        <?php if ($usermodule->isWrite == true) : ?>
                                                                                            <span class="action-circle large" title="Assign">
                                                                                                <a href="#" data-toggle="modal" data-target="#assign_taskuser_<?= $ticket->id ?>"> <i class="material-icons">person_add</i></a>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                        <?php if ($usermodule->isDelete == true) : ?>
                                                                                            <span class="action-circle large delete-btn" title="Delete Task">
                                                                                                <a href="/projecttasks/deletesingletask?tid=<?= $ticket->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                            </span>
                                                                                        <?php endif; ?>
                                                                                    </span>
                                                                                </div>
                                                                                <!---------------------Assign User for Task------------------------------------------>
                                                                                <?= $this->element('assign_taskuser', [
                                                                                    'task' => $ticket,
                                                                                    'projectMembers' => $projectObject->projectmembers
                                                                                ]) ?>
                                                                                <!--------------------/Assign User for task------------------------------------------>

                                                                                <!---------------------------completed tASK Update Statu---------------------------------------------->
                                                                                <div id="updatecompletedtaskStatus_<?= $ticket->id ?>" class="modal custom-modal fade" role="dialog">
                                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title">Assign the user to task</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="form-group form-focus select-focus m-b-30">

                                                                                                    <div class="form-group form-focus select-focus">
                                                                                                        <label for="taskStatus"><?= __('Status ') ?></label><span class="text-success" id="successDivDone_<?= $ticket->id ?>"></span>
                                                                                                        <select class="select2-icon floating" id="taskStatus" name="taskStatus" onchange="changeStatusDone(this,<?= $ticket->id ?>); return false;">
                                                                                                            <option value="T" data-toggle="modal" data-target="#approve_leave"> To Do</option>
                                                                                                            <option value="I">In Prograss</option>
                                                                                                            <option selected value="D">Done</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <br />
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                        <br />
                                                                                    </div>
                                                                                </div>
                                                                                <!---------------------------completed task Update Statu---------------------------------------------->
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
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
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /Page Content -->

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
                                <form method="post" action="/project-object/invitemembers/" id="add" enctype="multipart/form-data">
                                    <div class="form-group form-focus select-focus m-b-30">
                                        <label for="adduser"><?= __('Add Project Manager') ?> <span class="text-danger">*</span></label>
                                        <select id="adduser" class="select2-icon floating" name="adduser">
                                            <option id='' selected disabled>-------</option>
                                            <?php foreach ($companymembers as $companymember) : ?>
                                                <option value=" <?= $companymember->user->id ?>">
                                                    <p><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></p></br>

                                                    <span class="designation">(<?= $companymember->user->email ?>)</span>
                                                </option>
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
                                        <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Assign Leader Modal -->


                <!-- Assign Client Modal -->
                <div id="assign_client" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign Client to this project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/project-object/addclient">
                                    <div class="form-group form-focus select-focus m-b-30">
                                        <label for="adduser"><?= __('Add Client to Project') ?> <span class="text-danger">*</span></label>
                                        <select id="selectedclient" class="select2-icon floating" name="clientId">
                                            <?php foreach ($companymembers as $companymember) : ?>
                                                <?php if ($companymember->designation->name == 'Customer') : ?>
                                                    <option value=" <?= $companymember->user->id ?>">
                                                        <p><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></p></br>
                                                        <span class="designation">(<?= $companymember->user->email ?>)</span>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="submit-section">
                                        <input type="hidden" name="projectId" value="<?= $projectObject->id ?>">
                                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Assign Leader Modal -->


                <!-- Assign User Modal -->
                <?= $this->element('assign_users', [
                    'projectObject' => $projectObject,
                ]) ?>
                <!-- /Assign User Modal -->


                <?php $view = $projectObject->id; ?>

                <!-- Edit Project Modal -->
                <?= $this->element('edit_projectmodal', [
                    'projectObject' => $projectObject,
                    'view' => $view,
                    'companymembers' => $companymembers
                ]) ?>
                <!---/Edit Modal-->

            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
<!-- /Page Wrapper -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-alpha14/css/tempus-dominus.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };
    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });



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

    function changeStatusTodo(event, taskId) {
        var taskStatus = event.value;
        $.ajax({
            url: '/projecttasks/changestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'status': taskStatus,
            },
            success: function(data) {
                window.location.reload();
                $('#successDiv_' + taskId).html(data);
            },
            error: function() {}
        })
    }


    function changeStatusIn(event, taskId) {
        var taskStatus = event.value;
        $.ajax({

            url: '/projecttasks/changestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus
            },
            success: function(data) {
                window.location.reload();
                $('#successDivInpro_' + taskId).html(data);
            },
            error: function() {}
        })
    }

    function changeStatusDone(event, taskId) {
        var taskStatus = event.value;
        $.ajax({

            url: '/projecttasks/changestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus
            },
            success: function(data) {
                console.log(data, 'Done');
                window.location.reload();
                $('#successDivDone_' + taskId).html(data);
            },
            error: function() {}
        })
    }

    function deletefile(fid, pid) {
        $.ajax({
            url: '/project-object/deletefile',
            method: 'post',
            dataType: 'json',
            data: {
                'fid': fid,
                'pid': pid
            },
            success: function(data) {
                $('#fileinfo_' + fid).empty();
                var info = "";
                data.forEach((file) => {
                    info += '<div class="uploaded-img">' +
                        '<a href="">' +
                        '<span class="remove-icon">' +
                        '<a onclick="deletefile(' + file.id + ',' + file.project_id + '" class="del-msg"><i class="fa fa-close"></i></a>' +
                        '</span>' +
                        '</a>' +
                        '</div>' +
                        '<div class="uploaded-img-name">' + file.filename + '</div>';
                });
                $('#fileinfo_' + file.id).html(info);
            },
            error: function() {}
        })
    }

    function opendeletealertModal(pid, fid) {
        $('#delete_approvefile_' + pid + '_' + fid).show();

    }

    function closedeletealertModal(pid, fid) {
        $('#delete_approvefile_' + pid + '_' + fid).hide();
    }

    $(".deleteuser").hover(
        function() {
            $('.del-msg').attr("hidden", false);
        },
        function() {
            $('.del-msg').attr("hidden", true);
        });


    function inviteMembersforproject(pid) {
        var tag = $('#selecteddesignation').val();
        var form_data = new FormData();
        form_data.append("tagvalues", JSON.stringify(values));
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
</script>
