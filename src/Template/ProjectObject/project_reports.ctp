<?php

use Cake\I18n\Number;
use Cake\I18n\Time;


?>


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
                    <h3 class="page-title">Project Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Project Reports</li>
                    </ul>
                    <div class="col-auto float-right ml-auto">
                        <a href="/project-object/projectcategoryview?companyId=<?= $companyId ?>&&status=<?= 'A' ?>" class="btn btn-info"> Active Projects</a>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="/project-object/projectcategoryview?companyId=<?= $companyId ?>&&status=<?= 'I' ?>" class="btn btn-info"> Inactive Projects</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <!-- Search Filter -->
        <form  action="/project-object/projectsearchfilter">
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

        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#ProjectId</th>
                                <th>Project Title</th>
                                <th>Client Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Team</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projectObjects as $projectObject) : ?>
                                <tr>
                                    <td><?= $projectObject->id ?></td>
                                    <td>
                                        <a href="/projectobject/view/<?= $projectObject->id ?>"><?= $projectObject->name ?></a>
                                    </td>
                                    <td>
                                        <h2 class="table-avatar">


                                            <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                                <?php if ($projectmember->type == 'C') : ?>
                                                    <?php if ($projectmember->user->profileFilename != null && $projectmember->user->profileFilepath != null) : ?>
                                                        <a href="/user/view/<?= $projectmember->user->id ?>" class="avatar"><img src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>" alt=""></a>
                                                    <?php else : ?>
                                                        <a href="/user/view/<?= $projectmember->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-19.jpg" alt=""></a>
                                                    <?php endif; ?>

                                                    <a href="/user/view/<?= $projectmember->user->id ?>"><?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?></a>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        </h2>
                                    </td>
                                    <td><?= $projectObject->createDate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                    <td><?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
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
                                    <td>
                                        <ul class="team-members">
                                            <?php foreach ($projectObject->projectmembers as $projectmember) : ?>

                                                <li>
                                                    <a href="#" title="" data-toggle="tooltip" data-original-title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>"><img alt="" src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>"></a>
                                                </li>
                                            <?php endforeach; ?>
                                            <li>
                                                <a href="#" class="all-users">+15</a>
                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project_<?= $projectObject->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project_<?=$projectObject->id?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!--------------------Edit Project--------------------------------------------->

                                <?php $projectreports = $projectObject->id; ?>
                                <!-- Edit Project Modal -->
                                <?= $this->element('edit_projectmodal', [
                                    'projectObject' => $projectObject,
                                    'projecttypes' => $projecttypes,
                                    'projectreports' => $projectreports,

                                ]) ?>
                                <!-- /Edit Project Modal -->

                                <!---------Delete Project Modal--------------------->
                                <?= $this->element('delete_projectmodal', [
                                    'projectObject' => $projectObject,
                                    'projectreports' => $projectreports,

                                ]) ?>
                                <!---------/Delete Project Modal--------------------->
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

    };


    $('.select2-icon').select2({

        width: "90%",
        templateSelection: formatText,
        templateResult: formatText
    });

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
                    location.reload();
                }



            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })

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
</script>
