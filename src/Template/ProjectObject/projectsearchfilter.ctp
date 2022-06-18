<style>
    .multipledivs {
        display: flex;
        flex-direction: column;
    }
</style>

<?php

use Cake\I18n\Number;

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    $(function() {
        $(document).ready(function() {

            $.ajax({
                url: '/project-object/docallprojects',
                dataType: 'json',
                success: function(data) {
                    console.log('allprojects', data);
                    data.forEach((projectObject) => {
                        $("#edit_expirydate_" + projectObject.id).datetimepicker().on('dp.change', function() {
                            console.log(projectObject.id, 'this is id');
                            $('#ptagerrorMessage').remove();


                            var splittedDate = $("#edit_expirydate_" + projectObject.id).val().split("/");

                            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                            var createExpiryDate = new Date(dateToString);

                            createExpiryDate < (new Date())
                            if (createExpiryDate < (new Date())) {
                                $('#editerrormessage_' + projectObject.id).append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to current date</p>');
                            }
                        });
                    });
                },
                error: function() {}
            })



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


    function myjava(total) {
        var input, filter, a, i, txtValue;
        console.log(total);

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
</script>


<!-- Page Wrapper -->
<div class="page-wrapper">
<?php if(!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)): ?>
    <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
        <?php if ($usermodule->module->name == 'Projects' && $usermodule->isRead == true) : ?>
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Projects</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Projects</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <div class="view-icons">
                                <a href="/project-object/index?companyId=<?=$companyId?>&&type=<?=$visibility?>" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                <a href="/project-object/projectlists?companyId=<?=$companyId?>&&type=<?=$visibility?>" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
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
                                <input type="text" id="myInput" onkeyup="myjava(<?= $total ?>)" class="form-control" value="<?= $projectname ?>" name="projectname">
                                <label class="focus-label">Project Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group form-focus">
                                <input type="text" id="searchemp" class="form-control floating" onkeyup="searchEmployee(<?= $total ?>)" value="<?= $employeename ?>" name="employeename">
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
                            <input type="hidden" name="visibility" value="<?= $visibility ?>">
                            <button type="submit" class="btn btn-success btn-block"> Search </button>
                        </div>
                    </div>
                </form>

                <!-- Search Filter -->
                <div class="search-result">

                    <h3>Search Result Found For: <u>
                            <?php if (!empty($projectname) && !empty($employeename) && !empty($projecttype)) : ?>
                                <?= $projectname ?>,<?= $employeename ?>, <?= $projecttype ?>.
                            <?php elseif (!empty($projectname) && !empty($employeename) && empty($projecttype)) : ?>
                                <?= $projectname ?>,<?= $employeename ?>.
                            <?php elseif (!empty($projectname) && empty($employeename) && !empty($projecttype)) : ?>
                                <?= $projectname ?>, <?= $projecttype ?>.
                            <?php elseif (empty($projectname) && !empty($employeename) && !empty($projecttype)) : ?>
                                <?= $employeename ?>, <?= $projecttype ?>.
                            <?php elseif (!empty($projectname) && empty($employeename) && empty($projecttype)) : ?>
                                <?= $projectname ?>.
                            <?php elseif (empty($projectname) && !empty($employeename) && empty($projecttype)) : ?>
                                <?= $employeename ?>.
                            <?php elseif (empty($projectname) && empty($employeename) && !empty($projecttype)) : ?>
                                <?= $projecttype ?>.
                            <?php endif; ?>

                        </u></h3>

                    <?php if ($projectObjects != null) : ?>
                        <?php $totalsearch = (count($projectObjects)); ?>
                    <?php else : ?>
                        <?php $totalsearch = "NO MAATCH FOUND" ?>
                    <?php endif; ?>

                    <p><?= $totalsearch ?> Results found</p>
                </div>



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
            </div>
            <!-- /Page Content -->

            <!-- Create Project Modal -->
            <div id="create_project" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/project-object/add-project" id="add" enctype="multipart/form-data">


                                <div class="form-group form-focus select-focus">
                                    <label for="type"><?= __('Type of Project') ?><span class="text-danger">*</span></label>

                                    <select class="select floating" id="type" name="type" required>
                                        <option id='' disabled selected>-------</option>
                                        <option value="A">Commessa</option>
                                        <option value="B">Ricerca Accadenica</option>
                                        <option value="C">Raccocta Dondi</option>
                                        <option value="D">Venture Capital</option>
                                    </select>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label for="name"><?= __('Project name') ?><span class="text-danger">*</span></label>
                                    <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" required />
                                </div>
                                <div class="form-project">
                                    <label for="description"><?= __('Description') ?></label>
                                    <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10" placeholder="<?= __('Describe your project...') ?>" required></textarea>
                                </div>
                                </br>

                                <div class="form-group">
                                    <label for="expirydate"><?= __('Expire Date') ?><span class="text-danger">*</span></label>
                                    <div class="cal-icon" id="errormessage">
                                        <input type="text" name="expirydate" id="create_expirydate" class="form-control floating datetimepicker" placeholder="dd/mm/yyyy" required />
                                    </div>
                                </div>
                                </br>

                                <div class="form-project">
                                    <label for="visibilityDiv">
                                        <h4><?= __('Project type') ?></h4>
                                    </label>
                                    <div id="visibilityDiv" class="row">
                                        <div class="col">
                                            <input type="radio" name="visibility" id="visibility" value="I" checked required><?= __('Internal') ?>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="visibility" id="visibility" value="E"><?= __('External') ?>
                                        </div>
                                    </div>
                                    </br>
                                    <label for="price">
                                        <h4>Prezzo</h4>
                                        <input name="price" id="price" type="text" class="form-control btn-mod-input" placeholder="<?= __('The price...') ?>" required />
                                    </label>
                                </div>
                                </br>
                                <div class="form-project">
                                    <label>
                                        <h4>Select Project For</h4>
                                    </label>
                                    <div class="row">
                                        <div class="col">
                                            <input type="radio" name="type" id="type" value="P" checked required><?= __('Personal') ?>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="type" id="type" value="C"><?= __('Company') ?>
                                        </div>
                                    </div>

                                </div>

                                </br>

                                <div class="form-project">
                                    <label for="allowedDiv">
                                        <h4><?= __('Permissions') ?></h4>
                                    </label>
                                    <div id="allowedDiv" class="row">
                                        <div id="membership_request_div" class="col-4" style="display: flex;flex-direction: column;">
                                            <label for="membership_request_span"><?= __('Membership requests are allowed') ?></label>
                                            <span class="switch" id="membership_request_span">

                                                <input type="checkbox" class="switch" id="membership_request" name="membership_request" checked="">

                                            </span>
                                        </div>

                                        <div id="ban_div" class="col-4" style="display: flex;flex-direction: column;">
                                            <label for="ban_span"><?= __('Ban is allowed') ?></label>
                                            <span class="switch" id="ban_span">

                                                <input type="checkbox" class="switch" id="ban" name="ban" checked="">

                                            </span>
                                        </div>

                                        <div id="invitation_div" class="col-4" style="display: flex;flex-direction: column;">
                                            <label for="invitation_span"><?= __('Invitations are allowed') ?></label>
                                            <span class="switch" id="invitation_span">
                                                <input type="checkbox" class="switch" id="invitation" name="invitation" checked="">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                </br>
                                <div class="form-project">
                                    <label for="projectIMG"><?= __('Project Image') ?><span class="text-danger">*</span></label>
                                    <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                    <div class='label label-info' id="upload-file-info"></div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Create project') ?></button>
                                    <input type="hidden" name="tagname" value="I">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Create Project Modal -->
        <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>



<!-- /Page Wrapper -->

<!-- /Main Wrapper -->
<script type="text/javascript">
    //Search projecttype

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });


    function searchProjectType(total) {
        var input, filter, tr, td, i, txtValue;
        input = $('#searchprojecttype').val();
        filter = input.toUpperCase();
        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('mytype_' + i);
            var txt = myrow.getElementsByTagName('p')[0].innerHTML;
            if (txt) {
                if (txt.toUpperCase().includes(filter)) {
                    myrow.style.display = "";
                } else {
                    myrow.style.display = "none";
                }
            }
        }
    }


    //delete projectfiles

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
                });

                $('#fileinfo_' + pid).html(filedata);
            },
            error: function() {}
        })
    }


    function updatepriority(pid) {
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
                   location.reload();
                }
            },
            error: function() {}
        })
    }

    function updatestatus(pid) {
        var status = $('#status_project_' + pid).val();
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
                   location.reload();
                }
            },
            error: function(a, b, c) {}
        })

    }
</script>
