<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>

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
                    <h3 class="page-title"><?= $projectObject->name ?></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Project</li>
                    </ul>
                </div>
                <!--  <?php if ($data2->type != 'C') : ?>
                    <form method="post" action="/project-object/comments/<?= $projectObject->id ?>" enctype="multipart/form-data">
                        <button class="btn btn-info" data-mdb-ripple-color="dark" type="submit">Comments</button>

                    </form>
                <?php endif; ?> -->
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_task_modal"><i class="fa fa-plus"></i> Add task</a>
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i> Add Group</a>

                <!----------Contract Details Start------------->
                <?php if ($projectObject->isFuturedProject == false) : ?>
                    <?php if (!empty($contract)) : ?>
                        <?php foreach ($contract as $singleContract) : ?>
                            <?php if ($singleContract->project_object_id == $projectObject->id && $singleContract->acceptance_date != null) : ?>
                                <form method="post" action="/project-object/contractsummary" enctype="multipart/form-data">
                                    <input type="hidden" name="prid" id="id" value="<?= $projectObject->id ?>">
                                    <button class="btn btn-info" data-mdb-ripple-color="dark" type="submit">Contract</button>
                                </form>
                            <?php endif; ?>
                            <?php if ($singleContract->project_object_id == $projectObject['id'] && $singleContract->acceptance_date == null) : ?>
                                <form method="post" action="/project-object/summaryPrices" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="id" value="<?= $projectObject["id"] ?>">
                                    <?php if ($data2->type == 'Y' or $data2->type == 'C') : ?>
                                        <button class="btn btn-info" data-mdb-ripple-color="dark" type="submit">Summary</button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <form method="post" action="/project-object/summaryPrices" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?= $projectObject["id"] ?>">
                            <?php if ($data2->type == 'Y' or $data2->type == 'C') : ?>
                                <button class="btn btn-info" data-mdb-ripple-color="dark" type="submit">Summary</button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if ($data2->type == 'C') : ?>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"><i class="fa fa-plus"></i> Add Ticket</a>
                    </div>
                <?php endif; ?>

                <div class="col-auto float-right ml-auto">
                    <?php if ($data2->type == 'Y' && $data2->type == 'C') : ?>
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#edit_project"><i class="fa fa-plus"></i> Edit Project</a>
                    <?php endif; ?>
                  <!--  <a href="/project-object/taskboard/<?= $projectObject->id ?>" class="btn btn-white float-right m-r-10" data-toggle="tooltip" title="Task Board"><i class="fa fa-bars"></i></a>--->

                </div>



            </div>
        </div>
        <!-- Add Task Modal -->
        <div id="add_task_modal" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Task</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/projecttasks/addtask" id="add" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group form-focus select-focus">
                                    <label for="tsgrouptype"><?= __('Select the Task Group') ?><span class="text-danger">*</span></label><span class="text-success" style="display: none;text-align:end; margin-left:200px" id="successAddtask">Updated Sucessfully</span>
                                    <select id="tsgrouptype" class="select floating" name="tsgrouptype">
                                        <!---onchange="myfunction(this, <?= $projectObject->id ?>)"---->
                                        <!--onchange="if (this.selectedIndex) groupId(); return false;"--->
                                        <option id='' disabled selected>-------</option>
                                        <?php foreach ($taskgroups as $group) : ?>
                                            <option value="<?= $group->id ?>"><?= $group->title ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <br />
                                <br />
                                <div class="form-group">
                                    <label>Task Name <span class="text-danger">*</span></label>
                                    <input id="name" name="name" class="form-control" type="text">
                                </div>
                                <div class="form-group">
                                    <label> Task Description <span class="text-danger">*</span></label>
                                    <textarea id="name" name="description" class="form-control btn-mod-input height10" type="text"></textarea>
                                </div>
                                <div class="form-group">

                                    <label for="startdate"><?= __('Start Date') ?></label>
                                    <div class="cal-icon">
                                        <input type="text" name="startdate" id="addtaskstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" />
                                    </div>
                                    <br />
                                    <span class="text-success" id="startdateMsg"></span>
                                </div>
                                <div class="form-group">

                                    <label for="expirydate"><?= __('Expire Date') ?></label>
                                    <div class="cal-icon">
                                        <input type="text" name="expirydate" id="addtaskexpirydate" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                                    </div>
                                    <br />
                                    <span class="text-success" id="expirydateMsg"></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="price"><?= __('Price') ?></label>
                                    <input type="number" class="form-control" name="price" id="price" placeholder="<?= __('Enter Price...') ?> " required>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="tax"><?= __('Tax') ?></label>
                                    <input type="number" class="form-control" name="tax" id="tax" placeholder="<?= __('Enter Tax...') ?> " required>

                                </div>
                                <div class="text-center">
                                    <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                                    <input type="hidden" name="isFutured" value="<?= $projectObject->id ?>">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('create task') ?></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Task Modal -->


        <!-- /Page Header -->

        <div class="row">
            <?php if ($data2->type == 'Y') : ?>
                <div class="col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="project-title">
                                <h5 class="card-title"><?= $projectObject->name ?></h5>
                                <?php $opentask = 0;
                                $completedtask = 0 ?>
                                <?php foreach ($tasks as $task) : ?>
                                    <?php if ($task->isDeleted == false && $task->status != 'A') : ?>
                                        <?php if ($task->status == 'T' or $task->status == 'I') : ?>
                                            <?php $opentask = $opentask + 1;    ?>
                                        <?php else : ?>

                                            <?php $completedtask = $completedtask + 1; ?>

                                        <?php endif; ?>

                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php $totaltasks = $opentask + $completedtask ?>
                                <small class="block text-ellipsis m-b-15"><span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span><span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span></small>
                            </div>
                            <p> <?= $projectObject->description ?> </p>
                            <p> <?= $projectObject->description2 ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-20">Uploaded image files</h5>
                            <div class="row">
                                <?php foreach ($projectfiles as $projectfile) : ?>
                                    <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                        <div class="uploaded-box">
                                            <div class="uploaded-img">
                                                <img src="<?= $projectfile->filepath ?>/<?= $projectfile->filename ?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="uploaded-img-name">
                                                <?= $projectfile->filename ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-20">Uploaded files</h5>
                            <ul class="files-list">
                                <li>
                                    <div class="files-cont">
                                        <div class="file-type">
                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <div class="files-info">
                                            <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile Application Test-Cases.xls</a></span>
                                            <span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                            <div class="file-size">Size: 14.8Mb</div>
                                        </div>
                                        <ul class="files-action">
                                            <li class="dropdown dropdown-action">
                                                <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                    <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="files-cont">
                                        <div class="file-type">
                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <div class="files-info">
                                            <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile Application Test-Cases.xls</a></span>
                                            <span class="file-author"><a href="#">Richard Miles</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                            <div class="file-size">Size: 14.8Mb</div>
                                        </div>
                                        <ul class="files-action">
                                            <li class="dropdown dropdown-action">
                                                <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                    <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="project-task">
                        <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                            <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">All Tasks</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                            <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
                        </ul>
                        <div class="tab-content">
                            <!------------alltasks---------------------------->
                            <div class="tab-pane show active" id="all_tasks">
                                <div class="task-wrapper">
                                    <div class="task-list-container">
                                        <div class="task-list-body">

                                            <ul id="task-list">
                                                <?php foreach ($tasks as $task) : ?>
                                                    <?php if ($task->isDeleted == false & $task->status == 'T') : ?>
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                        <a href="#" data-toggle="modal" data-target="#alltaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label" contenteditable="true"><?= $task->title ?></span>
                                                                <!------task user ---------->

                                                                <div class="form-control">

                                                                    <div class="avatar-group">

                                                                        <?php foreach ($taskusers as $taskuser) : ?>
                                                                            <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                    <?php if ($taskuser->assignee_id == $singleUser->id) : ?>
                                                                                        <div class="avatar">
                                                                                            <img title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                            <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $singleUser->id ?>" class="del-msg"><i class="fa fa-minus-square-o"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <!---------/teamtask---------------------->
                                                                <?php if ($data2->type == 'Y') : ?>
                                                                    <span class="task-action-btn task-btn-right">
                                                                        <span class="action-circle large" title="Assign">
                                                                            <a href="#" data-toggle="modal" data-target="#add_userforalltask_<?= $task->id ?>"><i class="material-icons">person_add</i></a>

                                                                        </span>
                                                                        <span class="action-circle large delete-btn" title="Delete Task">
                                                                            <a href="/projecttasks/deletesingletask?tid=<?= $task->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>

                                                                        </span>
                                                                    </span>
                                                                <?php endif; ?>

                                                                <!---------------------Assign User for Task------------------------------------------>
                                                                <div id="add_userforalltask_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
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
                                                                                    <a class="btn btn-success" onclick="select2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <br />
                                                                    </div>
                                                                </div>
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
                                                <?php foreach ($tasks as $task) : ?>
                                                    <?php if ($task->isDeleted == false && $task->status == 'I') : ?>

                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                        <a href="#" data-toggle="modal" data-target="#pendingtaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label" contenteditable="true"><?= $task->title ?></span>

                                                                <!------task user ---------->

                                                                <div class="form-control">

                                                                    <div class="avatar-group">

                                                                        <?php foreach ($taskusers as $taskuser) : ?>
                                                                            <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                    <?php if ($taskuser->assignee_id == $singleUser->id) : ?>

                                                                                        <div class="avatar">
                                                                                            <img title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                            <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $singleUser->id ?>" class="del-msg"><i class="fa fa-minus-square-o"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="action-circle large" title="Assign">
                                                                        <a href="#" data-toggle="modal" data-target="#add_userforpendingtask_<?= $task->id ?>"><i class="material-icons">person_add</i></a>
                                                                    </span>
                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                        <i class="material-icons">delete</i>
                                                                    </span>
                                                                </span>
                                                            </div>


                                                            <!---------------------Assign User for Task----------------------------------------->
                                                            <div id="add_userforpendingtask_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Assign the user to task</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="/projectMember/inviteMembers/" id="add" enctype="multipart/form-data">

                                                                                <div class="form-group form-focus select-focus m-b-30">
                                                                                    <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                                    <select id="pendingtaskassignuser" class="select2-icon floating" name="adduser">

                                                                                        <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                <?php if ($projectMember->memberId == $singleUser->id) : ?>

                                                                                                    <option><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>

                                                                                                        <?php if ($projectMember->type == 'Y') : ?>
                                                                                                            <span class="message-content">Administrator</span>
                                                                                                        <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                            <span class="message-content">Developer</span>
                                                                                                        <?php else : ?>
                                                                                                            <span class="message-content">ProjectManager</span>
                                                                                                        <?php endif; ?>
                                                                                                    </option>
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </select>

                                                                                </div>
                                                                                <div class="submit-section">
                                                                                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                                                                    <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <br />




                                                                </div>
                                                            </div>


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
                                                <?php foreach ($tasks as $task) : ?>
                                                    <?php if ($task->isDeleted == false && $task->status == 'D') : ?>

                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                        <a href="#" data-toggle="modal" data-target="#updatecompletedtaskStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label" contenteditable="true"><?= $task->title ?></span>
                                                                <!------task user ---------->

                                                                <div class="form-control">

                                                                    <div class="avatar-group">

                                                                        <?php foreach ($taskusers as $taskuser) : ?>
                                                                            <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                    <?php if ($taskuser->assignee_id == $singleUser->id) : ?>

                                                                                        <div class="avatar">
                                                                                            <img title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                            <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $singleUser->id ?>" class="del-msg"><i class="fa fa-minus-square-o"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="action-circle large" title="Assign">
                                                                        <a href="#" data-toggle="modal" data-target="#add_userforcompletedtask_<?= $task->id ?>"> <i class="material-icons">person_add</i></a>
                                                                    </span>
                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                        <i class="material-icons">delete</i>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <!---------------------Assign User for Task------------------------------------------>
                                                            <div id="add_userforcompletedtask_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
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
                                                                                <a class="btn btn-success" onclick="select2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <br />
                                                                </div>
                                                            </div>
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
                        </div>
                    </div>
                </div>

                <?php

                $totalprice = 0;
                $totaltax = 0;
                $totalhrs = 0;

                ?>
                <?php foreach ($manyObject as $object) : ?>

                    <?php foreach ($taskgroups as $group) : ?>

                        <?php foreach ($projecttask as $task) : ?>
                            <?php if ($object->taskgroup_id == $group->id && $object->projecttask_id == $task->id) : ?>
                                <?php if ($task->isDeleted == false) : ?>

                                    <?php

                                    $diff = abs(strtotime($task->expiration_date) - strtotime($task->startdate));
                                    $years = floor($diff / (365 * 60 * 60 * 24));
                                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                    $totalhrs = $totalhrs + ($days + 1) * 8;
                                    $totalprice = $totalprice + $task->price;
                                    $tax = $task->tax_percentage / 100;
                                    $totaltax = $totaltax + $tax;
                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    <?php endforeach; ?>

                <?php endforeach; ?>



                <div class="col-lg-4 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title m-b-15">Project Details</h6>
                            <table class="table table-striped table-border">
                                <tbody>
                                    <tr>
                                        <?php if ($projectObject->isFuturedProject ==  false) : ?>
                                            <td>Cost: </td>
                                            <td class="text-right">
                                                <?php if (!empty($contract)) : ?>
                                                    <?php foreach ($contract as $singleContract) : ?>
                                                        <?php if ($singleContract->project_object_id == $projectObject->id && $singleContract->acceptance_date != null) : ?>
                                                            <form method="post" action="/projectObject/contractsummary" enctype="multipart/form-data">
                                                                <input type="hidden" name="prid" id="id" value="<?= $projectObject->id ?>">

                                                                <button class="btn btn-light" data-mdb-ripple-color="dark" type="submit"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></button>
                                                            </form>
                                                        <?php endif; ?>
                                                        <?php if ($singleContract->project_object_id == $projectObject['id'] && $singleContract->acceptance_date == null) : ?>
                                                            <form method="post" action="/projectObject/summaryPrices" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" id="id" value="<?= $projectObject["id"] ?>">
                                                                <button class="btn btn-light" data-mdb-ripple-color="dark" type="submit"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></button>
                                                            </form>
                                                        <?php endif; ?>

                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <form method="post" action="/projectObject/summaryPrices" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" id="id" value="<?= $projectObject["id"] ?>">
                                                        <button class="btn btn-light" data-mdb-ripple-color="dark" type="submit"><?= Number::currency(($totalprice), 'EUR', ['locale' => 'it_IT']); ?></button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        <?php else : ?>
                                            <td colspan="2"> <a href="/projectObject/startfutureproject/<?= $projectObject->id ?>" class="btn btn-success">Start</a></td>

                                        <?php endif; ?>

                                    </tr>
                                    <tr>
                                        <td>Total Hours:</td>
                                        <td class="text-right"> Hours</td>
                                    </tr>
                                    <tr>
                                        <td>Created:</td>
                                        <td class="text-right"><?= $projectObject->createDate->i18nFormat('dd/MM/yyyy'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Deadline:</td>
                                        <td class="text-right"><?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy'); ?></td>
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
                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                <?php if ($admin->memberId == $singleUser->id) : ?>
                                                    <a href="profile.html"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></a>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <?php if ($projectObject->isFuturedProject == false) : ?>
                                            <td class="text-right">Working</td>
                                        <?php else : ?>
                                            <td class="text-right">Future purpose</td>
                                        <?php endif; ?>
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
                                    <div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: 0%"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card project-user">
                        <div class="card-body">
                            <h6 class="card-title m-b-20">Assigned Leader <button type="button" class="float-right btn btn-primary btn-sm" data-toggle="modal" data-target="#leader_of_project"><i class="fa fa-plus"></i> Add</button></h6>
                            <ul class="list-box">
                                <?php foreach ($projectmanagers as $manager) : ?>
                                    <?php foreach ($allUsers as $singleUser) : ?>
                                        <?php if ($manager->memberId == $singleUser->id) : ?>
                                            <li>
                                                <a href="profile.html">
                                                    <div class="list-item">
                                                        <div class="list-left">
                                                            <span class="avatar"><img alt="" src="assets/img/profiles/avatar-11.jpg"></span>
                                                        </div>
                                                        <div class="list-body">
                                                            <span class="message-author"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></span><a href="/project-object/deleteProjectusers?memberId=<?= $manager->memberId ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="fa fa-trash-o"></i></a>
                                                            <div class="clearfix"></div>
                                                            <span class="message-content">Project Manager</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                    <div class="card project-user">
                        <div class="card-body">
                            <h6 class="card-title m-b-20">
                                Assigned users
                                <button type="button" class="float-right btn btn-primary btn-sm" data-toggle="modal" data-target="#assign_user"><i class="fa fa-plus"></i> Add</button>
                            </h6>
                            <ul class="list-box">
                                <?php foreach ($projectMembers as $projectMember) : ?>
                                    <?php foreach ($allUsers as $singleUser) : ?>
                                        <?php if ($projectMember->memberId == $singleUser->id) : ?>
                                            <li>
                                                <a href="profile.html">
                                                    <div class="list-item">
                                                        <div class="list-left">
                                                            <span class="avatar"><img alt="" src="assets/img/profiles/avatar-02.jpg"></span>
                                                        </div>
                                                        <div class="list-body">
                                                            <span class="message-author"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?></span><a href="/project-object/deleteProjectusers?memberId=<?= $projectMember->memberId ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="fa fa-trash-o"></i></a>
                                                            <div class="clearfix"></div>
                                                            <?php if ($projectMember->type == 'Y') : ?>
                                                                <span class="message-content">Administrator</span>
                                                            <?php elseif ($projectMember->type == 'X') : ?>
                                                                <span class="message-content">Developer</span>
                                                            <?php else : ?>
                                                                <span class="message-content">ProjectManager</span>
                                                            <?php endif; ?>


                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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
                                $completedtask = 0 ?>
                                <?php foreach ($tasks as $task) : ?>
                                    <?php if ($task->isDeleted == false && $task->status != 'A') : ?>
                                        <?php if ($task->status == 'T' or $task->status == 'I') : ?>
                                            <?php $opentask = $opentask + 1;    ?>
                                        <?php else : ?>
                                            <?php $completedtask = $completedtask + 1; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php $totaltasks = $opentask + $completedtask ?>
                                <small class="block text-ellipsis m-b-15"><span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span><span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span></small>
                            </div>
                            <p> <?= $projectObject->description ?> </p>
                            <p> <?= $projectObject->description2 ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-20">Uploaded image files</h5>
                            <div class="row">
                                <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                    <div class="uploaded-box">
                                        <div class="uploaded-img">
                                            <img src="/assets/img/placeholder.jpg" class="img-fluid" alt="">
                                        </div>
                                        <div class="uploaded-img-name">
                                            demo.png
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                    <div class="uploaded-box">
                                        <div class="uploaded-img">
                                            <img src="/assets/img/placeholder.jpg" class="img-fluid" alt="">
                                        </div>
                                        <div class="uploaded-img-name">
                                            demo.png
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                    <div class="uploaded-box">
                                        <div class="uploaded-img">
                                            <img src="/assets/img/placeholder.jpg" class="img-fluid" alt="">
                                        </div>
                                        <div class="uploaded-img-name">
                                            demo.png
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-lg-4 col-xl-3">
                                    <div class="uploaded-box">
                                        <div class="uploaded-img">
                                            <img src="/assets/img/placeholder.jpg" class="img-fluid" alt="">
                                        </div>
                                        <div class="uploaded-img-name">
                                            demo.png
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title m-b-20">Uploaded files</h5>
                            <ul class="files-list">
                                <li>
                                    <div class="files-cont">
                                        <div class="file-type">
                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <div class="files-info">
                                            <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile Application Test-Cases.xls</a></span>
                                            <span class="file-author"><a href="#">John Doe</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                            <div class="file-size">Size: 14.8Mb</div>
                                        </div>
                                        <ul class="files-action">
                                            <li class="dropdown dropdown-action">
                                                <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                    <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="files-cont">
                                        <div class="file-type">
                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                        </div>
                                        <div class="files-info">
                                            <span class="file-name text-ellipsis"><a href="#">AHA Selfcare Mobile Application Test-Cases.xls</a></span>
                                            <span class="file-author"><a href="#">Richard Miles</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                            <div class="file-size">Size: 14.8Mb</div>
                                        </div>
                                        <ul class="files-action">
                                            <li class="dropdown dropdown-action">
                                                <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)">Download</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files">Share</a>
                                                    <a class="dropdown-item" href="javascript:void(0)">Delete</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="project-task">
                        <ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
                            <li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">All Tasks</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
                            <li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
                        </ul>
                        <div class="tab-content">
                            <!------------alltasks---------------------------->
                            <div class="tab-pane show active" id="all_tasks">
                                <div class="task-wrapper">
                                    <div class="task-list-container">
                                        <div class="task-list-body">

                                            <ul id="task-list">
                                                <?php foreach ($tasks as $task) : ?>
                                                    <?php if ($task->isDeleted == false & $task->status == 'T') : ?>
                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                        <a href="#" data-toggle="modal" data-target="#alltaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label" contenteditable="true"><?= $task->title ?></span>
                                                                <!------task user ---------->

                                                                <div class="form-control">

                                                                    <div class="avatar-group">

                                                                        <?php foreach ($taskusers as $taskuser) : ?>
                                                                            <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                    <?php if ($taskuser->assignee_id == $singleUser->id) : ?>

                                                                                        <div class="avatar">
                                                                                            <img title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                            <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $singleUser->id ?>" class="del-msg"><i class="fa fa-minus-square-o"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <!---------/teamtask---------------------->
                                                                <?php if ($data2->type == 'Y') : ?>
                                                                    <span class="task-action-btn task-btn-right">
                                                                        <span class="action-circle large" title="Assign">
                                                                            <a href="#" data-toggle="modal" data-target="#add_userforalltask_<?= $task->id ?>"><i class="material-icons">person_add</i></a>

                                                                        </span>
                                                                        <span class="action-circle large delete-btn" title="Delete Task">
                                                                            <a href="/projecttasks/deletesingletask?tid=<?= $task->id ?>&pid=<?= $projectObject->id ?>" class="del-msg"><i class="material-icons">delete</i></a>

                                                                        </span>
                                                                    </span>
                                                                <?php endif; ?>

                                                                <!---------------------Assign User for Task------------------------------------------>
                                                                <div id="add_userforalltask_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
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
                                                                                    <a class="btn btn-success" onclick="select2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>

                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <br />
                                                                    </div>
                                                                </div>
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
                                                <?php foreach ($tasks as $task) : ?>
                                                    <?php if ($task->isDeleted == false && $task->status == 'I') : ?>

                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                        <a href="#" data-toggle="modal" data-target="#pendingtaskupdateStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label" contenteditable="true"><?= $task->title ?></span>

                                                                <!------task user ---------->

                                                                <div class="form-control">

                                                                    <div class="avatar-group">

                                                                        <?php foreach ($taskusers as $taskuser) : ?>
                                                                            <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                    <?php if ($taskuser->assignee_id == $singleUser->id) : ?>

                                                                                        <div class="avatar">
                                                                                            <img title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                            <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $singleUser->id ?>" class="del-msg"><i class="fa fa-minus-square-o"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="action-circle large" title="Assign">
                                                                        <a href="#" data-toggle="modal" data-target="#add_userforpendingtask_<?= $task->id ?>"><i class="material-icons">person_add</i></a>
                                                                    </span>
                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                        <i class="material-icons">delete</i>
                                                                    </span>
                                                                </span>
                                                            </div>


                                                            <!---------------------Assign User for Task----------------------------------------->
                                                            <div id="add_userforpendingtask_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Assign the user to task</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="/projectMember/inviteMembers/" id="add" enctype="multipart/form-data">

                                                                                <div class="form-group form-focus select-focus m-b-30">
                                                                                    <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                                                                                    <select id="pendingtaskassignuser" class="select2-icon floating" name="adduser">

                                                                                        <?php foreach ($projectMembers as $projectMember) : ?>
                                                                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                                                                <?php if ($projectMember->memberId == $singleUser->id) : ?>

                                                                                                    <option><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>

                                                                                                        <?php if ($projectMember->type == 'Y') : ?>
                                                                                                            <span class="message-content">Administrator</span>
                                                                                                        <?php elseif ($projectMember->type == 'X') : ?>
                                                                                                            <span class="message-content">Developer</span>
                                                                                                        <?php else : ?>
                                                                                                            <span class="message-content">ProjectManager</span>
                                                                                                        <?php endif; ?>
                                                                                                    </option>
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; ?>
                                                                                        <?php endforeach; ?>
                                                                                    </select>

                                                                                </div>
                                                                                <div class="submit-section">
                                                                                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                                                                    <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <br />




                                                                </div>
                                                            </div>


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
                                                <?php foreach ($tasks as $task) : ?>
                                                    <?php if ($task->isDeleted == false && $task->status == 'D') : ?>

                                                        <li class="task">
                                                            <div class="task-container">
                                                                <span class="task-action-btn task-check">
                                                                    <span class="action-circle large complete-btn" title="Mark Complete">
                                                                        <a href="#" data-toggle="modal" data-target="#updatecompletedtaskStatus_<?= $task->id ?>"> <i class="material-icons">check</i></a>
                                                                    </span>
                                                                </span>
                                                                <span class="task-label" contenteditable="true"><?= $task->title ?></span>
                                                                <!------task user ---------->

                                                                <div class="form-control">

                                                                    <div class="avatar-group">

                                                                        <?php foreach ($taskusers as $taskuser) : ?>
                                                                            <?php if ($taskuser->taskId == $task->id) : ?>
                                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                                    <?php if ($taskuser->assignee_id == $singleUser->id) : ?>

                                                                                        <div class="avatar">
                                                                                            <img title="<?= $singleUser->firstname ?> <?= $singleUser->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                                                                                            <a href="/taskusers/deletetaskuser?taskId=<?= $task->id ?>&pid=<?= $projectObject->id ?>&assigneeId=<?= $singleUser->id ?>" class="del-msg"><i class="fa fa-minus-square-o"></i></a>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>

                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                </div>
                                                                <span class="task-action-btn task-btn-right">
                                                                    <span class="action-circle large" title="Assign">
                                                                        <a href="#" data-toggle="modal" data-target="#add_userforcompletedtask_<?= $task->id ?>"> <i class="material-icons">person_add</i></a>
                                                                    </span>
                                                                    <span class="action-circle large delete-btn" title="Delete Task">
                                                                        <i class="material-icons">delete</i>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <!---------------------Assign User for Task------------------------------------------>
                                                            <div id="add_userforcompletedtask_<?= $task->id ?>" class="modal custom-modal fade" role="dialog">
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
                                                                                <a class="btn btn-success" onclick="select2function(<?= $projectObject->id ?>,<?= $task->id ?> )">Submit</a>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <br />
                                                                </div>
                                                            </div>
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
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- /Page Content -->

    <!-- Assign Leader Modal -->
    <div id="leader_of_project" class="modal custom-modal fade" role="dialog">
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
                            <input type="hidden" name="pid" value="<?= $projectObject->id ?>">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Assign Leader Modal -->



    <!-- Add Group Modal -->

    <div id="add_group" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Group <?= $projectObject->id ?></h5>
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
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="startdate" id="startdate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Expire Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="expirydate" id="expirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
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
                                <input type="hidden" name='isFutured' value="<?= $projectObject->id ?>" />
                            </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
    <!---/ Add Group Modal--->


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
                    <form method="post" action="/project-object/inviteMembers/" id="add" enctype="multipart/form-data">
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
                            <select name="adduser" id="assignuser" class="select2-icon floating" onchange="changevalue()">
                            </select>
                        </div>
                        <br />
                        <div class="form-group form-focus select-focus m-b-30">
                            <label for="adddesignation"><?= __('Add Designation') ?><span class="text-danger">*</span></label>
                            <select id="adddesignation" class="select2-icon floating" name="adddesignation">

                                <option value="W">COORDINATOR</option>
                                <option value="X">DEVELOPER</option>
                                <option value="Y">ADMINISTRATOR</option>
                                <option value="Z"> PROJECT MANAGER</option>
                                <option value="H"> HR</option>
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
    <!-- /Assign User Modal -->

    <!-- Edit Project Modal -->
    <div id="edit_project" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Project </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/projectObject/updateproject" id="add" enctype="multipart/form-data">

                        <div class="form-group form-focus select-focus">
                            <label for="type"><?= __('Type of Project') ?></label>

                            <select class="select floating" id="type" name="type">
                                <?php if ($projectObject->type == 'A') : ?>
                                    <option value="A" selected>Commessa</option>
                                    <option value="B">Ricerca Accadenica</option>
                                    <option value="C">Raccocta Dondi</option>
                                    <option value="D">Venture Capital</option>
                                <?php elseif ($projectObject->type == 'B') : ?>
                                    <option value="A">Commessa</option>
                                    <option value="B" selected>Ricerca Accadenica</option>
                                    <option value="C">Raccocta Dondi</option>
                                    <option value="D">Venture Capital</option>
                                <?php elseif ($projectObject->type == 'C') : ?>
                                    <option value="A">Commessa</option>
                                    <option value="B">Ricerca Accadenica</option>
                                    <option value="C" selected>Raccocta Dondi</option>
                                    <option value="D">Venture Capital</option>
                                <?php else : ?>
                                    <option value="A">Commessa</option>
                                    <option value="B">Ricerca Accadenica</option>
                                    <option value="C">Raccocta Dondi</option>
                                    <option value="D" selected>Venture Capital</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <br />
                        <div class="form-group">

                            <label for="name"><?= __('Project name') ?></label>
                            <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" value="<?= $projectObject->name ?>" required />
                        </div>
                        <div class="form-project">
                            <label for="description"><?= __('Description') ?></label>
                            <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10" placeholder="<?= __('Describe your project...') ?>" required><?= $projectObject->description ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="expirydate"><?= __('Expire Date') ?></label>
                            <div class="cal-icon">
                                <input type="text" name="expirydate" id="expirydate" class="form-control datetimepicker" value="<?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                            </div>
                        </div>
                        <br />
                        <div class="form-project">
                            <label for="visibilityDiv">
                                <h4><?= __('Project type') ?></h4>
                            </label>
                            <div id="visibilityDiv">
                                <input type="radio" name="visibility" id="visibility" value="P" checked required><?= __('Public') ?>
                                <input type="radio" name="visibility" id="visibility" value="V"><?= __('Private') ?>
                                <input type="radio" name="visibility" id="visibility" value="S"><?= __('Secret') ?>
                            </div>
                            <br />
                            <label for="price">
                                <h4>Prezzo</h4>
                                <input name="price" id="price" type="text" class="form-control btn-mod-input" placeholder="<?= __('The price...') ?>" value="<?= $projectObject->price ?>" required />
                            </label>
                        </div>
                        <br />

                        <div class="form-project">
                            <label for="allowedDiv">
                                <h4><?= __('Permissions') ?></h4>
                            </label>
                            <div id="allowedDiv" style="text-align: center;">
                                <div id="membership_request_div" style="display:inline-block; float:left">
                                    <label style="display:block" for="membership_request_span"><?= __('Membership requests are allowed') ?></label>
                                    <span class="switch" id="membership_request_span" style="float:left">
                                        <label for="membership_request"><?= __('Yes') ?></label>
                                        <input type="checkbox" class="switch" id="membership_request" name="membership_request" checked="">
                                        <label for="membership_request"><?= __('No') ?></label>
                                    </span>
                                </div>

                                <div id="ban_div" style="display:inline-block; float:center">
                                    <label style="display:block" for="ban_span"><?= __('Ban is allowed') ?></label>
                                    <span class="switch" id="ban_span">
                                        <label for="ban"><?= __('Yes') ?></label>
                                        <input type="checkbox" class="switch" id="ban" name="ban" checked="">
                                        <label for="ban"><?= __('No') ?></label>
                                    </span>
                                </div>

                                <div id="invitation_div" style="display:inline-block; float:right">
                                    <label style="display:block" for="invitation_span"><?= __('Invitations are allowed') ?></label>
                                    <span class="switch" id="invitation_span" style="float:right">
                                        <label for="invitation"><?= __('Yes') ?></label>
                                        <input type="checkbox" class="switch" id="invitation" name="invitation" checked="">
                                        <label for="invitation"><?= __('No') ?></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="form-project">
                            <label for="father_projects_div">
                                <h4><?= __('Progetto Padre') ?></h4>
                            </label>
                            <div id="father_projects_div">
                                <!--<div class="form-control">-->

                                <div style="display: block">
                                    <select style="margin-bottom: 1em" class="form-control" id="father_id" name="father_id">
                                        <option selected value="0"><?= __('Choose a father project.') ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-project">
                            <label for="projectIMG"><?= __('Project Image') ?></label>
                            <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="projectIMG" name="projectIMG" type="file" onchange="validateFileSize(); return false;" />
                            <p><small id="errorFileSize" style="color: rgba(255,0,0,1);"></small></p>
                            <div class='label label-info' id="upload-file-info"></div>
                            <!--<h6 style="margin-top: 1em;">Il file deve essere in formato JPG o JPEG, con estensione massima 2MB.</h6>-->
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary margin-t-1" onclick="modalProjectClose(); return false; "><?= __('Annulla') ?></button>
                            <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                            <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Update') ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Project Modal -->



</div>
<!-- /Page Wrapper -->
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


    function filtertags() {
        //var tag = $('#tag').val();
        //console.log(tag);

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
                    //$('#assignuser').select2().trigger('change');
                }
                console.log(htmlCode);
                $("#assignuser").html(htmlCode);
                $('#assignuser').val("");
                //$('#assignuser').select2().trigger('change');

                //console.log($('#assignuser').val);
            },

            error: function() {

            }
        });

    }

    function changevalue() {
        console.log('hooooooooo')
    }



    // multi values, with last selected
    //
    //$('#alltaskassignuser').empty();
    var values;
    $(".select2-icon").on("select2:select", function(event) {
        //   $("#alltaskassignuser").on("select2:select", function(event) {
        console.log('hi')
        values = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            values[i] = parseInt($(selected).val());
        });

        // output values (all current values selected)
        console.log("selected values: ", values);

    });

    function select2function(pid, tid) {

        //console.log('submit', values);
        //console.log(pid, tid);
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
                console.log('success')
                console.log(data);
                $('#add_userfortask_' + tid).modal('hide')
                location.reload();
            },

            error: function(e) {
                console.log('error');


            }
        });


    }



    function changeStatusTodo(event, taskId) {
        //window.location.reload();
        var taskStatus = event.value;
        //console.log(taskStatus);
        // ajax call
        $.ajax({

            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus,
            },

            success: function(data) {
                console.log(data, 'todo');
                // window.location.href = "/project-object/view/";
                // close popup click event trigger
                // div show $("#id").show();

                $('#successDiv_' + taskId).html(data);
            },
            error: function() {

            }
        })

    }


    function changeStatusIn(event, taskId) {
        // window.location.reload();
        //alert("Inprogress")
        var taskStatus = event.value;
        // ajax call
        $.ajax({

            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus


            },

            success: function(data) {
                console.log(data, 'Inprogress');
                // window.location.href = "/project-object/view/";
                // close popup click event trigger
                // div show $("#id").show();
                $('#successDivInpro_' + taskId).html(data);
            },
            error: function() {

            }
        })

    }

    function changeStatusDone(event, taskId) {
        var taskStatus = event.value;
        //window.location.reload();
        //alert("Done")
        // ajax call
        $.ajax({

            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': taskStatus


            },

            success: function(data) {
                console.log(data, 'Done');
                // window.location.href = "/project-object/view/";
                // close popup click event trigger
                // div show $("#id").show();
                $('#successDivDone_' + taskId).html(data);
            },
            error: function() {

            }
        })

    }
</script>
