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
                    <h3 class="page-title">Task Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Task Reports</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                        <a href="/projecttasks/taskcategized?companyId=<?= $companyId ?>&&status=<?= 'T' ?>" class="btn btn-info"> New(ToDo) Tasks</a>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="/projecttasks/taskcategized?companyId=<?= $companyId ?>&&status=<?= 'I' ?>" class="btn btn-info"> Pending Tasks</a>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="/projecttasks/taskcategized?companyId=<?= $companyId ?>&&status=<?= 'D' ?>" class="btn btn-info"> Closed Tasks</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <!-- Search Filter -->
        <div class="row filter-row">

            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <select class="form-control floating select">
                            <option>
                                Name1
                            </option>
                            <option>
                                Name2
                            </option>
                        </select>
                    </div>
                    <label class="focus-label">Project Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <select class="form-control floating select">
                            <option>
                                All
                            </option>
                            <option>
                                Pending
                            </option>
                            <option>
                                Completed
                            </option>
                        </select>
                    </div>
                    <label class="focus-label">Status</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="#" class="btn btn-success btn-block"> Search </a>
            </div>
        </div>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#TaskId</th>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projectobjects as $projectobject) : ?>
                                <?php foreach ($projectobject->projecttasks  as $projecttask) : ?>
                                    <tr>
                                        <td><?= $projecttask->id ?></td>
                                        <td><?= $projecttask->title ?></td>
                                        <td><?= $projecttask->startdate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                        <td><?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                        <td>
                                            <select class="select2-icon floating" id="taskStatus_<?=$projecttask->id?>" name="taskStatus" onchange="updatetaskstatus(<?= $projecttask->id ?>); return false;">
                                                <?php if ($projecttask->status == 'T') : ?>
                                                    <option selected value="T" data-icon="fa fa-dot-circle-o text-danger">To Do</option>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-warning">In Progress</option>
                                                    <option value="D" data-icon="fa fa-dot-circle-o text-success">Completed</option>
                                                <?php elseif ($projecttask->status == 'I') : ?>
                                                    <option value="T" data-icon="fa fa-dot-circle-o text-danger">To Do</option>
                                                    <option selected value="I" data-icon="fa fa-dot-circle-o text-warning">In Progress</option>
                                                    <option value="D" data-icon="fa fa-dot-circle-o text-success">Completed</option>
                                                <?php else : ?>
                                                    <option value="T" data-icon="fa fa-dot-circle-o text-danger">To Do</option>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-warning">In Progress</option>
                                                    <option selected value="D" data-icon="fa fa-dot-circle-o text-success">Completed</option>
                                                <?php endif; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <ul class="team-members">
                                                <li>
                                                    <?php foreach ($projecttask->taskusers as $taskuser) : ?>
                                                        <a href="#" data-toggle="tooltip" title="" data-original-title="<?= $taskuser->user->firstname ?>  <?= $taskuser->user->lastname ?>">
                                                            <?php if ($taskuser->user->profileFilepath != null && $taskuser->user->profileFilename != null) : ?>
                                                                <img alt="" class="avatar-img rounded-circle border border-black" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                            <?php else : ?>
                                                                <img alt="" class="avatar-img rounded-circle border border-black" src="/assets/img/profiles/avatar-02.jpg">
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_<?= $projecttask->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_task_<?= $projecttask->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <!---------Delete Project Modal--------------------->
                                    <?= $this->element('delete_task', [
                                        'ticket' => $projecttask

                                    ]) ?>
                                    <!---------/Delete Project Modal--------------------->
                                <?php endforeach; ?>
                            <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

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

    function updatetaskstatus(taskId) {
        var taskStatus = $('#taskStatus_'+taskId).val();
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

            },
            error: function() {}
        })

    }
</script>
