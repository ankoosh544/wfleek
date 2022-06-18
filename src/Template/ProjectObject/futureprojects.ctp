<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
            <ul>
                <li>
                    <?php if ($authuser->choosen_companyId != null) : ?>
                        <a href="/companiesUser/companydashboard/<?= $authuser->choosen_companyId ?>"><i class="la la-home"></i> <span>Back to Home</span></a>
                    <?php else : ?>
                        <a href="/project-member/privatedashboard"><i class="la la-home"></i> <span>Back to Home</span></a>
                    <?php endif; ?>
                </li>
                <li class="menu-title">Projects <a href="#" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i></a></li>
                <?php foreach ($projectObjects as $projectObject) : ?>

                    <li>
                        <a href="/project-object/futureprojects?companyId=<?= $authuser->choosen_companyId ?>&&type=<?= $type ?>&&projectId=<?= $projectObject->id ?>"><?= $projectObject->name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-12 message-view task-view task-left-sidebar">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="float-left mr-auto">
                                <div class="add-task-btn-wrapper">
                                    <div class="col-auto float-right ml-auto">
                                        <a class="btn add-btn" data-toggle="modal" data-target="#add_task_modal"><i class="fa fa-plus"></i> Add Task</a>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i> Add Group</a>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_ticket"><i class="fa fa-plus"></i> Add Ticket</a>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <a class="btn add-btn float-right ml-2" data-toggle="modal" data-target="#create_epictask_modal"><i class="fa fa-plus"></i> Create Epic-Task</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="task-wrapper">
                        <?php if (!empty($projectObject->projecttasks)) : ?>
                            <?php foreach ($projectObject->projecttasks as $task) : ?>
                                <div class="task-list-container">
                                    <div class="task-list-body">
                                        <ul id="task-list">
                                            <li class="task">
                                                <div class="task-container">
                                                    <span class="task-action-btn task-check">
                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                            <i class="material-icons">check</i>
                                                        </span>
                                                    </span>
                                                    <span class="task-label"><?= $task->title ?></span>
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
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- Create Project Modal -->
    <?php $futureorojects = 'future' ?>
    <?= $this->element('create_projectmodal', [
        'futureorojects' => $futureorojects,
        'companymembers' => $companymembers


    ]) ?>
    <!-- /Create Project Modal -->

    <!----------Create Task modal------------->
    <?= $this->element('create_taskmodal', [
        'futureorojects' => $futureorojects,
    ]) ?>
    <!----------/Create Task modal--------------->

    <!--------Create Epic Task modal------------>
    <?= $this->element('create_epictask', [
        'futureorojects' => $futureorojects,
    ]) ?>
    <!--------/Create Epic Task modal-------------->


    <!-- Add Group Modal -->
    <?= $this->element('create_taskgroup', [
        'futureorojects' => $futureorojects,
    ]) ?>
    <!---/ Add Group Modal--->
</div>
<!-- /Page Wrapper -->
