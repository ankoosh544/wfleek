<?php

use Cake\I18n\Number;

?>
<style>
    .desc {
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>



<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
        <?php if(!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)): ?>
        <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
            <?php if ($usermodule->module->name == 'Projects' && $usermodule->isAccessed && $usermodule->isRead == true) : ?>

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
                        <?php if ($usermodule->isCreate == true) : ?>
                            <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i> Create Project</a>
                            </div>
                        <?php endif; ?>
                        <div class="col-auto float-right ml-auto">
                            <a href="/project-object/archieve_projects?companyId=<?= $companyId ?>&&type=<?= $type ?>" class="btn btn-info">Archieve Projects</a>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="/project-object/futureprojects?companyId=<?= $companyId ?>&&type=<?= $type ?>" class="btn btn-info">Future Projects</a>
                        </div>

                        <div class="col-auto float-right ml-auto">
                            <div class="view-icons">

                                <a href="/project-object/index?companyId=<?= $companyId ?>&&type=<?= $type ?>" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                <a href="/project-object/projectlists?companyId=<?= $companyId ?>&&type=<?= $type ?>" class="list-view btn btn-link "><i class="fa fa-bars"></i> All Projects</a>
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
                                <input type="text" id="myInput" onkeyup="myjava(<?= $total ?>)" class="form-control" name="projectname">
                                <label class="focus-label">Project Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="text" id="searchemp" class="form-control floating" onkeyup="searchEmployee(<?= $total ?>)" name="employeename">
                                <label class="focus-label">Employee Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus select-focus">
                                <label class="focus-label">Project Type</label>
                                <select id="searchprojecttype" class="select floating" onchange="searchProjectType(<?= $total ?>);return;" name="projecttype">
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

                <!-- Search Filter -->
                <div class="row" id="searchfilter_result">
                    <?php if ($projectObjects != null) : ?>
                        <?php foreach ($projectObjects as $index => $projectObject) : ?>
                            <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                                <div class="card" id="mycard_<?= $index ?>">
                                    <div class="card-body" id="mytype_<?= $index ?>">
                                        <div class="dropdown dropdown-action profile-action">
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

                                        <h4 id="myrow_<?= $index ?>" class="project-title"><a href="/project-object/view/<?= $projectObject->id ?>" ><?= $projectObject->name ?></a></h4>

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
                                        <p class="desc"><?= $projectObject->description ?></p>
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
                                                    <?php if ($manager->designation->name == 'Project Manager') : ?>
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
                                                    <?php if ($projectMember->designation->name != 'Customer') : ?>
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
                                        <?php if ($usermodule->isWrite == true) : ?>
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
                                        <?php else : ?>
                                            <div class="priority m-b-15">
                                                <div>Priority :</div>
                                                <select class="select2-icon floating">
                                                    <?php if ($projectObject->priority == 'H') : ?>
                                                        <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                    <?php elseif ($projectObject->priority == 'M') : ?>
                                                        <option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>
                                                    <?php else : ?>
                                                        <option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            </br>
                                            <div class="project_status m-b-30">
                                                <div>Status :</div>
                                                <select class="select2-icon floating">
                                                    <?php if ($projectObject->status == 'A') : ?>
                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                    <?php else : ?>
                                                        <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        <?php endif; ?>
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

                            <!--------------Edit Project Modal------------------->
                            <?= $this->element('edit_projectmodal', [
                                'projectObject' => $projectObject,
                                'companymembers' => $companymembers

                            ]) ?>
                            <!--------------/Edit Project Modal------------------->


                            <!---------Delete Project Modal--------------------->
                            <?= $this->element('delete_projectmodal', [
                                'projectObject' => $projectObject,

                            ]) ?>
                            <!---------/Delete Project Modal--------------------->



                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php break; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <!-- /Page Content -->
    <?= $this->element('create_projectmodal',[
        'companymembers' => $companymembers
    ]) ?>
</div>



<!-- /Page Wrapper -->

<!-- /Main Wrapper -->
<script type="text/javascript">
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };

    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });


    function myjava(total) {
        var input, filter, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('myrow_' + i);
            var mycard = document.getElementById('mycard_' + i);
            var txt = myrow.getElementsByTagName('a')[0].innerText

            if (txt) {
                if (txt.toUpperCase().includes(filter)) {
                    mycard.style.display = "";
                } else {
                    mycard.style.display = "none";
                }
            }
        }
    }

    function searchEmployee(total) {
        var input, filter, a, i, txtValue;
        input = document.getElementById("searchemp");
        filter = input.value.toUpperCase();
        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('myli_' + i);
            var mycard = document.getElementById('mycard_' + i);
            var txt = $('#allemps').val()
            if (txt) {

                if (txt.toUpperCase().includes(filter)) {
                    mycard.style.display = "";
                } else {
                    mycard.style.display = "none";
                }
            }
        }
    }

    function searchProjectType(total) {
        var input, filter, tr, td, i, txtValue;
        input = $('#searchprojecttype').val();
        //console.log(input);
        filter = input.toUpperCase();
        for (i = 0; i < total; i++) {
            //var mycard = document.getElementById('mycard_' + i);
            var myrow = document.getElementById('mytype_' + i);

            console.log(myrow);
            var txt = myrow.getElementsByTagName('p')[0].innerHTML;
            console.log(txt);
            //console.log(txt);
            if (txt) {
                if (txt.toUpperCase().includes(filter)) {
                    console.log(filter, txt.toUpperCase());
                    myrow.style.display = "";
                } else {
                    myrow.style.display = "none";
                }
            }
        }
    }

    //delete projectfiles

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
                    '  <ul>' +
                    '<li> <a href="/projectfiles/downloadfile?fileid=' + file.id + '&pid=' + pid + '">' + file.filename + '</a></li>' +
                        '</ul>';
                });

                $('#fileinfo_' + pid).html(filedata);
            },
            error: function() {}
        })
    }


    function updatepriority(pid) {
        $.ajax({
            url: '/project-object/updatepriority',
            method: 'post',
            dataType: 'json',
            data: {
                'pid': pid,
                'priority': $('#priority_project_' + pid).val(),
            },
            success: function(data) {
                if (data != null) {
                   location.reload();
                }
            },
            error: function() {}
        })

    }

    function updatestatus(pid) {
        $.ajax({
            url: '/project-object/updatestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'pid': pid,
                'status': $('#status_project_' + pid).val(),
            },
            success: function(data) {
                if (data != null) {
                   location.reload();
                }
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })

    }
</script>
