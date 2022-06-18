<?php

use Cake\I18n\Number;

?>


<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
                <div>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#create_project"> Create Project</a>
                    <a href="/project-object/archieve_projectsexternal/<?= $companyId ?>" class="btn btn-info">Archieve Projects</a>
                </div>
                <div class="col-auto float-right ml-auto">
                    <div class="view-icons">
                        <a href="/project-object/externalProjects/<?= $companyId ?>" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="/project-object/projectlists/<?= $companyId ?>" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Search Filter -->
        <form method="POST" action="/project-object/projectsearchfilterexternal/<?= $companyId ?>">

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
                            <?php foreach ($projecttypes as $type) : ?>
                                <option value="<?= $type->id ?>"><?= $type->name ?></option>
                            <?php endforeach; ?>

                        </select>

                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <button type="submit" class="btn btn-success btn-block"> Search </button>
                </div>
            </div>
        </form>
        <!-- Search Filter -->

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
                                    $completedtask = 0 ?>
                                    <?php foreach ($projecttasks as $projecttask) : ?>
                                        <?php if ($projecttask->project_id == $projectObject->id) : ?>
                                            <?php if ($projecttask->isDeleted == false && $projecttask->status != 'A') : ?>
                                                <?php if ($projecttask->status == 'T' or $projecttask->status == 'I') : ?>
                                                    <?php $opentask = $opentask + 1;    ?>
                                                <?php else : ?>
                                                    <?php $completedtask = $completedtask + 1; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php $totaltasks = $opentask + $completedtask ?>
                                    <span class="text-xs"><?= $opentask ?></span> <span class="text-muted">open tasks, </span>
                                    <span class="text-xs"><?= $completedtask ?></span> <span class="text-muted">tasks completed</span>
                                </small>
                                <p class="text-muted"><?= $projectObject->description ?></p>
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
                                        <?php foreach ($managers as $manager) : ?>
                                            <?php if ($manager->projectId == $projectObject->id) : ?>
                                                <?php foreach ($users as $user) : ?>
                                                    <?php if ($manager->memberId == $user->id) : ?>
                                                        <li>
                                                            <a href="#" data-toggle="tooltip" title="<?= $user->firstname ?> <?= $user->lastname ?>">
                                                                <?php if ($user->profileFilepath != null && $user->profileFilename != null) : ?>
                                                                    <img alt="" src="<?= $user->profileFilepath ?>/<?= $user->profileFilename ?>">
                                                                <?php else : ?>
                                                                    <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                <?php endif; ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team :</div>
                                    <ul class="team-members">
                                        <?php foreach ($projectMembers as $projectMember) : ?>
                                            <?php if ($projectMember->projectId == $projectObject->id) : ?>
                                                <?php foreach ($users as $user) : ?>
                                                    <?php if ($projectMember->memberId == $user->id) : ?>
                                                        <li id="myli_<?= $index ?>">
                                                            <?php $allemps = array();
                                                            array_push($allemps, $user->firstname . ' ' . $user->lastname);
                                                            ?>
                                                            <input id="allemps" type="hidden" value="<?= $user->firstname ?> <?= $user->lastname ?>">
                                                            <a href="#" data-toggle="tooltip" title="<?= $user->firstname ?> <?= $user->lastname ?>">

                                                                <?php if ($user->profileFilepath != null && $user->profileFilename != null) : ?>
                                                                    <img alt="" src="<?= $user->profileFilepath ?>/<?= $user->profileFilename ?>">
                                                                <?php else : ?>
                                                                    <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                <?php endif; ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
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

                    <?php $external = $projectObject->id;?>

                    <?= $this->element('edit_projectmodal', [
                        'projectObject' => $projectObject,
                        'companymembers' => $companymembers,
                        'external' => $external
                    ]) ?>

                    <?= $this->element('delete_projectmodal', [
                        'projectObject' => $projectObject,
                        'external' => $external
                    ]) ?>



                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- /Page Content -->
    <?php $external = $projectObjects ?>

    <!---------Create _Modal---------------->
    <?= $this->element('create_projectmodal', ['external' => $external, 'companymembers' => $companymembers]) ?>
    <!---------/Create _Modal---------------->


</div>



<!-- /Page Wrapper -->

<!-- /Main Wrapper -->
<script>
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


    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

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
                $('#fileinfo').empty();
                var fileinfo = "";
                data.forEach((file) => {
                    fileinfo += '<div class="uploaded-img">' +
                        '<a href="">' +
                        '<span class="remove-icon">' +
                        '<a onclick="deletefile(' + file.id + ',' + file.project_id + '" class="del-msg"><i class="fa fa-close"></i></a>' +
                        '</span>' +
                        '</a>' +
                        '</div>' +
                        '<div class="uploaded-img-name">' + file.filename + '</div>';
                });
                $('#fileinfo').html(fileinfo);
            },
            error: function() {}
        })
    }





    $(function() {
        $(document).ready(function() {

            $("#edit_expirydate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();
                //var expiry_date = $("#create_expirydate").val();
                var splittedDate = $("#edit_expirydate").val().split("/");
                //console.log(splittedDate, 'Edited');
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var createExpiryDate = new Date(dateToString);
                // console.log(createExpiryDate, new Date());
                createExpiryDate < (new Date())
                if (createExpiryDate < (new Date())) {

                    $('#editerrormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date cannot be less than or equal to current date</p>');

                }
            });



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
                    window.location = '/project-object/index';
                }
            },
            error: function() {}
        })
    }
</script>
