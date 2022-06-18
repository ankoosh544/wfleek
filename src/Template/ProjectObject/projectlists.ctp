<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<?php if(!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)): ?>
<?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
    <?php if ($usermodule->module->name == 'Projects' && $usermodule->isRead == true) : ?>
        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Projects</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/project-member/privatedashboard/<?= $companyId ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Projects</li>
                            </ul>
                        </div>


                        <div class="col-auto float-right ml-auto">
                            <div class="view-icons">
                                <a href="/project-object/index?companyId=<?= $companyId ?>&&type=<?= $type ?>" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <form action="/project-object/projectsearchfilter">
                    <!-- Search Filter -->
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="text" id="myInput" class="form-control" name="projectname">
                                <label class="focus-label">Project Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="text" id="searchemp" class="form-control floating" name="employeename">
                                <label class="focus-label">Employee Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus select-focus">
                                <label class="focus-label">Project Type</label>
                                <select id="searchprojecttype" class="select floating" name="projecttype">
                                    <option value="">Select Type</option>
                                    <?php foreach ($projecttypes as $projecttype) : ?>
                                        <option value="<?= $projecttype->id ?>"><?= $projecttype->name ?></option>
                                    <?php endforeach; ?>

                                </select>

                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <input type="hidden" name="companyId" value="<?= $companyId ?>">
                            <input type="hidden" name="visibility" value="<?= $type ?>">
                            <button type="submit" class="btn btn-success btn-block"> Search </button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <?php if (!empty($projectObjects)) : ?>
                                    <thead>
                                        <tr>
                                            <th>Project</th>
                                            <th>Project Id</th>
                                            <th>Leader</th>
                                            <th>Team</th>
                                            <th>Deadline</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($projectObjects as $projectObject) : ?>
                                            <tr>
                                                <td>
                                                    <a href="/project-object/view/<?= $projectObject->id ?>"><?= $projectObject->name ?></a>
                                                </td>
                                                <td><?= $projectObject->id ?></td>
                                                <td>

                                                    <ul class="team-members">
                                                        <li>
                                                            <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                                                <?php if ($projectmember->type == 'Z') : ?>
                                                                    <a href="#" data-toggle="tooltip" title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>"><img alt="" src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>"></a>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="team-members text-nowrap">
                                                        <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                                            <?php if ($projectmember->type != 'Z' && $projectmember->type != 'C') : ?>
                                                                <li>
                                                                    <a href="#" title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>" data-toggle="tooltip">
                                                                        <?php if ($projectmember->user->profileFilepath != null && $projectmember->user->profileFilename != null) : ?>
                                                                            <img alt="" src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>">
                                                                        <?php else : ?>
                                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                        <?php endif; ?>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>

                                                    </ul>
                                                </td>
                                                <td>
                                                    <?php if ($projectObject->expirydate != null) : ?>
                                                        <?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($usermodule->isWrite == true) : ?>
                                                <td>
                                                    <select class="select2-icon floating" onchange="updatepriority(<?= $projectObject->id ?>,<?= $companyId ?>)" id="priority_project_<?= $projectObject->id ?>">
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

                                                </td>
                                                <td>
                                                    <select class="select2-icon floating" onchange="updatestatus(<?= $projectObject->id ?>,<?= $companyId ?>)" id="status_project_<?= $projectObject->id ?>">
                                                        <?php if ($projectObject->status == 'A') : ?>
                                                            <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                            <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                        <?php else : ?>
                                                            <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                            <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </td>
                                                <?php else: ?>
                                                    <td>
                                                    <select class="select2-icon floating" >
                                                        <?php if ($projectObject->priority == 'H') : ?>
                                                            <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                        <?php elseif ($projectObject->priority == 'M') : ?>
                                                            <option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>
                                                        <?php else : ?>
                                                            <option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>
                                                        <?php endif; ?>
                                                    </select>

                                                </td>
                                                <td>
                                                    <select class="select2-icon floating">
                                                        <?php if ($projectObject->status == 'A') : ?>
                                                            <option value="A" selected data-icon="fa fa-dot-circle-o text-success">Active</option>

                                                        <?php else : ?>
                                                            <option value="I" selected data-icon="fa fa-dot-circle-o text-danger">Inactive</option>

                                                        <?php endif; ?>
                                                    </select>
                                                </td>
                                                    <?php endif; ?>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <?php if ($usermodule->isWrite == true && $usermodule->isDelete == true) : ?>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_<?= $projectObject->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            <?php elseif ($usermodule->isWrite == true && $usermodule->isDelete != true) : ?>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <?php elseif ($usermodule->isWrite != true && $usermodule->isDelete == true) : ?>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_<?= $projectObject->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!--------------------Edit Project--------------------------------------------->

                                            <?php $projectlists = $projectObject->id; ?>
                                            <!-- Edit Project Modal -->
                                            <?= $this->element('edit_projectmodal', [
                                                'projectObject' => $projectObject,
                                                'projecttypes' => $projecttypes,
                                                'projectlists' => $projectlists,

                                            ]) ?>
                                            <!-- /Edit Project Modal -->

                                            <!---------Delete Project Modal--------------------->
                                            <?= $this->element('delete_projectmodal', [
                                                'projectObject' => $projectObject,
                                                'projectlists' => $projectlists,

                                            ]) ?>
                                            <!---------/Delete Project Modal--------------------->
                                        <?php endforeach; ?>


                                    </tbody>
                                <?php else : ?>
                                    <h3 style="text-align: center;">No Project List Found</h3>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->
        </div>
        <!-- /Page Wrapper -->
    <?php endif; ?>
    <?php break; ?>
<?php endforeach; ?>
<?php endif; ?>

<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');

    };


    $('.select2-icon').select2({

        width: "90%",
        templateSelection: formatText,
        templateResult: formatText
    });


    function updatepriority(pid, companyId) {
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
                    window.location = '/project-object/projectlists/' + companyId;
                }



            },
            error: function() {}
        })

    }

    function updatestatus(pid, companyId) {
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
                    window.location = '/project-object/projectlists/' + companyId;
                }



            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })

    }
</script>
