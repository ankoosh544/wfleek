<style>
    .multipledivs {
        display: flex;
        flex-direction: column;
    }
</style>

<?php

use Cake\I18n\Number;

?>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
                        $("#edit_startdate_" + projectObject.id).datetimepicker().on('dp.change', function() {
                            console.log(projectObject.id, 'this is id');
                            $('#ptagerrorMessage').remove();
                            var splittedDate = $("#edit_startdate_" + projectObject.id).val().split("/");
                            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                            var startdate = new Date(dateToString);
                            startdate < (new Date())
                            if (startdate < (new Date())) {
                                $('#editstartdateerrormessage_' + projectObject.id).append('<p id="ptagerrorMessage" style="color:red;"class="message">Start date cannot be less than or equal to current date</p>');
                            }
                        });


                        $("#edit_expirydate_" + projectObject.id).datetimepicker().on('dp.change', function() {
                            console.log(projectObject.id, 'this is id');
                            $('#ptagerrorMessage').remove();
                            var splittedDate = $("#edit_startdate_" + projectObject.id).val().split("/");
                            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                            var startdate = new Date(dateToString);


                            var splittedDate = $("#edit_expirydate_" + projectObject.id).val().split("/");
                            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                            var createExpiryDate = new Date(dateToString);
                            createExpiryDate < (new Date())
                            if (createExpiryDate < startdate) {
                                $('#editexpirydateerrormessage_' + projectObject.id).append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date must be Greater than Startdate</p>');
                            }
                        });
                    });
                },
                error: function() {}
            })



            $("#create_startdate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();

                var splittedDate = $("#create_startdate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var createstartdate = new Date(dateToString);
                var todaydate = $("#currentdate").val();

                if (createstartdate < (new Date())) {

                    $('#errormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Start date cannot be less than or equal to current date</p>');

                }
            });

            $("#create_expirydate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();

                var splittedDate = $("#create_startdate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var createstartdate = new Date(dateToString);

                var splittedDate = $("#create_expirydate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var createExpiryDate = new Date(dateToString);
                var todaydate = $("#currentdate").val();
                if (createExpiryDate < createstartdate) {
                    $('#errormessage_expirydate').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date Must be Greater than Start Date</p>');
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
        //console.log(total);

        input = document.getElementById("searchemp");
        filter = input.value.toUpperCase();
        //console.log(filter);

        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('myli_' + i);

            var mycard = document.getElementById('mycard_' + i);
            var txt = $('#allemps').val()
            console.log(txt);

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

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Archieve Projects</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/<?=$companyId?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ul>
                </div>


                <div class="col-auto float-right ml-auto">
                    <div class="view-icons">
                        <a href="projects.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="/project-object/projectlists" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->



        <form method="POST" action="/project-object/projectsearchfilter/<?= $companyId ?>">
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
                            <option>Select Type</option>
                            <?php foreach ($projecttypes as $type) : ?>
                                <option><?= $type->name ?></option>
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
        <div class="row" id="searchfilter_result">
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
                    <!-- Edit Project Modal -->
                    <div id="edit_project_<?= $projectObject->id ?>" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Project </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="/project-object/updateproject" enctype="multipart/form-data">

                                        <div class="form-group form-focus select-focus">
                                            <label for="projecttype"><?= __('Type of Project') ?></label>
                                            <select class="select floating" id="projecttype" name="projecttype">
                                                <?php foreach ($projecttypes as $type) : ?>
                                                    <?php if ($projectObject->projecttype->id == $type->id) : ?>
                                                        <option value="<?= $type->id ?>" selected><?= $type->name ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        </br>
                                        <div class="form-group">
                                            <label for="name"><?= __('Project name') ?></label>
                                            <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" value="<?= $projectObject->name ?>" required />
                                        </div>
                                        <div class="form-project">
                                            <label for="description"><?= __('Description') ?></label>
                                            <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10" placeholder="<?= __('Describe your project...') ?>" required><?= $projectObject->description ?></textarea>
                                        </div>
                                        </br>
                                        <div class="form-group">
                                            <label for="startdate"><?= __('Start Date') ?></label>
                                            <div class="cal-icon" id="editstartdateerrormessage_<?= $projectObject->id ?>">
                                                <?php if ($projectObject->startdate != null) : ?>
                                                    <input type="text" name="startdate" id="edit_startdate_<?= $projectObject->id ?>" class="form-control datetimepicker" value="<?= $projectObject->startdate->i18nFormat('dd/MM/yyyy'); ?>" placeholder="dd/mm/yyyy" />
                                                <?php else : ?>
                                                    <input type="text" name="startdate" id="edit_startdate_<?= $projectObject->id ?>" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="expirydate"><?= __('Expire Date') ?></label>
                                            <div class="cal-icon" id="editexpirydateerrormessage_<?= $projectObject->id ?>">
                                                <?php if ($projectObject->expirydate != null) : ?>
                                                    <input type="text" name="expirydate" id="edit_expirydate_<?= $projectObject->id ?>" class="form-control datetimepicker" value="<?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy'); ?>" placeholder="dd/mm/yyyy" />
                                                <?php else : ?>
                                                    <input type="text" name="expirydate" id="edit_expirydate_<?= $projectObject->id ?>" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        </br>

                                        <div class="row">
                                            <div class="form-project col">
                                                <label for="price">
                                                    <h4>Prezzo</h4>
                                                </label>
                                                <input name="price" id="price" type="text" class="form-control btn-mod-input" value="<?= Number::currency(($projectObject->price), 'EUR', ['locale' => 'it_IT']); ?>" required />
                                            </div>
                                            <div class="form-project col">
                                                <label for="slots">
                                                    <h4>Enter Total Group Slots </h4>
                                                </label>
                                                <input class="form-control" type="number" name="group_slots" value="<?= $projectObject->totalgroups ?>">
                                            </div>
                                        </div>
                                        </br>
                                        </br>
                                        <div class="form-group">
                                            <label for="visibilityDiv">
                                                <h4><?= __('Project type') ?></h4>
                                            </label>
                                            <div id="visibilityDiv" class="row">
                                                <?php if ($projectObject->visibility == 'I') : ?>
                                                    <div class="col">
                                                        <input type="radio" name="visibility" id="visibility" value="I" checked><?= __('Internal') ?>
                                                    </div>
                                                    <div class="col">
                                                        <input type="radio" name="visibility" id="visibility" value="E"><?= __('External') ?>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="col">
                                                        <input type="radio" name="visibility" id="visibility" value="I"><?= __('Internal') ?>
                                                    </div>
                                                    <div class="col">
                                                        <input type="radio" name="visibility" id="visibility" value="E" checked><?= __('External') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        </br>
                                        <div class="form-project">
                                            <label>
                                                <h4>Select Project For</h4>
                                            </label>
                                            <div class="row">
                                                <?php if ($projectObject->isPersonal == true) : ?>
                                                    <div class="col">
                                                        <input type="radio" name="type" id="type" value="P" checked required><?= __('Personal') ?>
                                                    </div>
                                                    <div class="col">
                                                        <input type="radio" name="type" id="type" value="C"><?= __('Company') ?>
                                                    </div>

                                                <?php else : ?>
                                                    <div class="col">
                                                        <input type="radio" name="type" id="type" value="P"><?= __('Personal') ?>
                                                    </div>
                                                    <div class="col">
                                                        <input type="radio" name="type" id="type" value="C" checked required><?= __('Company') ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        </br>
                                        <div class="form-project">
                                            <label for="allowedDiv">
                                                <h4><?= __('Permissions') ?></h4>
                                            </label>
                                            <div id="allowedDiv">
                                                <div class="row">
                                                    <div id="membership_request_div" class="col">
                                                        <label for="membership_request"><?= __('Memberships  are allowed') ?></label>
                                                        <span class="switch" id="membership_request_span">
                                                            <?php if ($projectObject->isMembershipRequestAllowed == true) : ?>
                                                                <input type="checkbox" class="switch" id="membership_request" name="membership_request" checked>
                                                            <?php else : ?>
                                                                <input type="checkbox" class="switch" id="membership_request" name="membership_request">
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                    <div id="ban_div" class="col">
                                                        <label for="ban_span"><?= __('Ban is allowed') ?></label>
                                                        <span class="switch" id="ban_span">
                                                            <?php if ($projectObject->isBanAllowed == true) : ?>
                                                                <input type="checkbox" class="switch" id="ban" name="ban_span" checked="">
                                                            <?php else : ?>
                                                                <input type="checkbox" class="switch" id="ban" name="ban_span">
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div id="invitation_div" class="col" >
                                                        <label for="invitation_span"><?= __('Invitations are allowed') ?></label>
                                                        <span class="switch" id="invitation_span">
                                                            <?php if ($projectObject->isInvitationAllowed == true) : ?>
                                                                <input type="checkbox" class="switch" id="invitation" name="invitation_span" checked>
                                                            <?php else : ?>
                                                                <input type="checkbox" class="switch" id="invitation" name="invitation_span">
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>

                                                    <div id="archive_project" class="col">
                                                        <label for="archive_project"><?= __('Archieve Project Allowed') ?></label>
                                                        <span class="switch" id="invitation_span">
                                                            <?php if ($projectObject->isArchieveAllowed == true) : ?>
                                                                <input type="checkbox" class="switch" id="invitation" name="archive_project" checked>
                                                            <?php else : ?>
                                                                <input type="checkbox" class="switch" id="invitation" name="archive_project">
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </br>
                                        <div class="form-project">
                                            <label for="projectIMG"><?= __('Project Files') ?></label>
                                            <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                        </div>
                                        </br>
                                        <div class="form-control">
                                            <div class="uploaded-box" id="fileinfo_<?= $projectObject->id ?>">
                                                <?php foreach ($projectfiles as $projectfile) : ?>
                                                    <?php if ($projectfile->project_id == $projectObject->id) : ?>
                                                        <div class="uploaded-img">
                                                            <a href="">
                                                                <span class="remove-icon">
                                                                    <a onclick="deletefile(<?= $projectfile->id ?>,<?= $projectObject->id ?>)" class="del-msg"><i class="fa fa-close"></i></a>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="uploaded-img-name">
                                                            <?= $projectfile->filename ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                                            <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Update ') ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Edit Project Modal -->



                    <!-- Delete Project Modal -->
                    <div class="modal custom-modal fade" id="delete_project_<?= $projectObject->id ?>" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="form-header">
                                        <h3>Delete Project</h3>
                                        <p>Are you sure want to delete?</p>
                                    </div>
                                    <div class="modal-btn delete-action">
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="/project-object/delete/<?= $projectObject->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Delete Project Modal ---->

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
                            <select class="select floating" id="type" name="projecttype">
                                <?php foreach ($projecttypes as $type) : ?>
                                    <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                <?php endforeach; ?>
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
                            <label for="expirydate"><?= __('Start Date') ?><span class="text-danger">*</span></label>
                            <div class="cal-icon" id="errormessage">
                                <input type="text" name="startdate" id="create_startdate" class="form-control floating datetimepicker" placeholder="dd/mm/yyyy" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="expirydate"><?= __('Expire Date') ?><span class="text-danger">*</span></label>
                            <div class="cal-icon" id="errormessage_expirydate">
                                <input type="text" name="expirydate" id="create_expirydate" class="form-control floating datetimepicker" placeholder="dd/mm/yyyy" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-project col">
                                <label for="price">
                                    <h4>Prezzo</h4>
                                </label>
                                <input name="price" id="price" type="text" class="form-control btn-mod-input" placeholder="<?= __('The price...') ?>" required />
                            </div>
                            <div class="form-project col">
                                <label for="slots">
                                    <h4>Enter Total Group Slots </h4>
                                </label>
                                <input class="form-control" type="number" name="group_slots" placeholder="Total Number of Groups">
                            </div>
                        </div>
                        </br>
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
                                <div id="membership_request_div" class="col-6" style="display: flex;flex-direction: column;">
                                    <label for="membership_request_span"><?= __('Membership requests are allowed') ?></label>
                                    <span class="switch" id="membership_request_span">

                                        <input type="checkbox" class="switch" id="membership_request" name="membership_request" checked>

                                    </span>
                                </div>

                                <div id="ban_div" class="col-6" style="display: flex;flex-direction: column;" checked>
                                    <label for="ban_span"><?= __('Ban is allowed') ?></label>
                                    <span class="switch" id="ban_span">
                                        <input type="checkbox" class="switch" id="ban" name="ban_span">
                                    </span>
                                </div>
                                </br>
                                </br>

                                <div id="invitation_div" class="col-6" style="display: flex;flex-direction: column;">
                                    <label for="invitation_span"><?= __('Invitations are allowed') ?></label>
                                    <span class="switch" id="invitation_span">
                                        <input type="checkbox" class="switch" id="invitation" name="invitation_span" >
                                    </span>
                                </div>


                                <div id="archieve_projects" class="col-6" style="display: flex;flex-direction: column;">
                                    <label for="archieve_projects"><?= __('Archieve Project are allowed') ?></label>
                                    <span class="switch" id="archieve_projects">
                                        <input type="checkbox" class="switch"  name="archieve_projects" >
                                    </span>
                                </div>
                            </div>
                        </div>
                        </br>
                        <div class="form-project">
                            <label for="projectIMG"><?= __('Project Files') ?><span class="text-danger">*</span></label>
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
</div>



<!-- /Page Wrapper -->

<!-- /Main Wrapper -->
<script type="text/javascript">
    //Search projecttype

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });


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
                });

                $('#fileinfo_' + pid).html(filedata);
            },
            error: function() {}
        })
    }



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
                    window.location = '/project-object/index/';
                }
            },
            error: function() {}
        })

    }

    function searchfilter(total) {
        console.log('search filter');
        $.ajax({
            url: '/project-object/searchfilter',
            method: 'post',
            dataType: 'json',
            data: {
                'projectname': $('#myInput').val(),
                'employeename': $('#searchemp').val(),
                'projecttype': $('#searchprojecttype').val()
            },
            success: function(data) {
                $('#searchfilter_result').empty();
                console.log(data);
                var str = "";
                data[0].forEach((projectObject, index) => {
                    str += ' <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">' +
                        '<div class="card" id="mycard_' + index + '">' +
                        '<div class="card-body" id="mytype_' + index + '">' +
                        '<div class="dropdown dropdown-action profile-action">' +
                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_' + projectObject.id + '"><i class="fa fa-pencil m-r-5"></i> Edit</a>' +
                        '<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_' + projectObject.id + '"><i class="fa fa-trash-o m-r-5"></i> Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<h4 id="myrow_' + index + '" class="project-title"><a href="/project-object/view/' + projectObject.id + '" onclick="checkuserType(' + projectObject.id + ', <?= $user_id ?>)">' + projectObject.name + '</a></h4>';
                    if (projectObject.type == 'A') {
                        str += ' <p>Commessa</p>';
                    } else if (projectObject.type == 'B') {
                        str += '<p>Ricerca Accadenica</p>';
                    } else if (projectObject.type == 'C') {
                        str += '<p>Raccocta Fondi</p>';
                    } else {
                        str += '<p>Venture Capital</p>';
                    }
                    str += '<small class="block text-ellipsis m-b-15">' +
                        '<span class="text-xs"></span> <span class="text-muted">open tasks, </span>' +
                        '<span class="text-xs"></span> <span class="text-muted">tasks completed</span>' +
                        '</small>' +
                        '<p class="text-muted">' + projectObject.description + '</p>' +
                        '<div class="pro-deadline m-b-15">' +
                        '<div class="sub-title">' +
                        'Deadline:' +
                        '</div>' +
                        '<div class="text-muted">' +
                        '' + projectObject.expirydate + '' +
                        '</div>' +
                        '</div>' +
                        '<div class="project-members m-b-15">' +

                        '<div>Project Leader :</div>' +
                        '<ul class="team-members">' +

                        '</ul>' +
                        '</div>' +
                        '<div class="project-members m-b-15">' +
                        '<div>Team :</div>' +
                        '<ul class="team-members">';
                    data[1].forEach((projectMember, index) => {
                        if (projectMember.projectId == projectObject.id) {
                            str += '<li id="myli_' + index + '">' +
                                '<input id="allemps" type="hidden" value="' + projectMember.user.firstname + '' + projectMember.user.lastname + '">' +
                                '<a href="#" data-toggle="tooltip" title="' + projectMember.user.firstname + '' + projectMember.user.lastname + '">';
                            if (projectMember.user.profileFilepath != null && projectMember.user.profileFilename != null) {
                                str += '<img alt="" src="/' + projectMember.user.profileFilepath + '/' + projectMember.userprofileFilename + '">';
                            } else {
                                str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg">';
                            }
                            str += '</a>' +
                                '</li>';
                        }
                    });
                    str += '</ul>' +
                        '</div>' +
                        ' <div class="priority m-b-15">' +
                        '<div>Priority :</div>' +
                        '<select class="select2-icon floating" onchange="updatepriority(' + projectObject.id + ')" id="priority_project_' + projectObject.id + '">';
                    if (projectObject.priority == 'H') {
                        str += '<option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>' +
                            '<option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>' +
                            '<option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>';
                    } else if (projectObject.priority == 'M') {
                        str += '<option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>' +
                            '<option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>' +
                            '<option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>';
                    } else {
                        str += '<option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>' +
                            '<option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>' +
                            '<option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>';
                    }
                    str += '</select>' +
                        '</div>' +
                        '</br>' +
                        '<div class="project_status m-b-30">' +
                        '<div>Status :</div>' +
                        '<select class="select2-icon floating" onchange="updatestatus(' + projectObject.id + ')" id="status_project_' + projectObject.id + '">';

                    if (projectObject.status == 'A') {
                        str += '<option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>' +
                            '<option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>';
                    } else {
                        str += '<option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>' +
                            '<option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>';
                    }
                    str += '</select>' +
                        '</div>' +
                        '</br>' +

                        '<p class="m-b-5">Progress <span class="text-success float-right">%</span></p>' +
                        '<div class="progress progress-xs mb-0">' +
                        '<div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="40%" style="width: %"></div>' +
                        '</div>' +

                        '<p class="m-b-5">Progress <span class="text-success float-right">0%</span></p>' +
                        '<div class="progress progress-xs mb-0">' +
                        '<div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="0%" style="width: 0%"></div>' +
                        '</div>' +

                        '</div>' +
                        '</div>' +
                        '</div>';

                });
                console.log("Code: " + str);
                $('#searchfilter_result').html(str);
                $('.select2-icon').select2({
                    width: "100%",
                    templateSelection: formatText,
                    templateResult: formatText
                });
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
                    window.location = '/project-object/index/';
                }



            },
            error: function() {}
        })

    }

    function updatestatus(pid) {
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
                    window.location = '/project-object/index/';
                }



            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })

    }
</script>
