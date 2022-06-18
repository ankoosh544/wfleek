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
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ul>

                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="search-result">
            <h3>Search Result Found For: <u><?= $tagvalue ?></u></h3>

            <?php if ($allusers != null) : ?>
                <?php $totalsearch = (count($allusers)); ?>
            <?php else : ?>
                <?php $totalsearch = "NO" ?>

            <?php endif; ?>
            <p><?= $totalsearch ?> Results found</p>
        </div>



        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registed Date</th>
                                <th>Departments</th>
                                <th>Designation</th>

                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            use Cake\I18n\Time;

                            foreach ($allusers as $employee) : ?>
                                <tr>
                                    <form action="/companies-user/saveemployee" method="post">
                                        <td>
                                            <h2 class="table-avatar">
                                                <?php if ($employee->profileFilepath != null && $employee->profileFilename) : ?>
                                                    <a href="/project-member/userprofile/<?= $employee->id ?>" class="avatar"><img src="<?= $employee->profileFilepath ?>/<?= $employee->profileFilename ?>" alt=""></a>
                                                <?php else : ?>
                                                    <a href="/project-member/userprofile/<?= $employee->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                                <?php endif; ?>
                                                <a href="profile.html"><?= $employee->firstname ?> <?= $employee->lastname ?>
                                                </a>
                                            </h2>
                                        </td>
                                        <td><?= $employee->email ?></td>

                                        <td>
                                            <?php if (!empty($employee->registrationDate)) : ?>
                                                <?= $employee->registrationDate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <div class="form-group form-focus select-focus">
                                                <select class="select2-icon floating" name="departments" id="company_department_<?=$employee->id?>" onchange="filterdesignations(<?=$employee->id?>)">
                                                    <option value="">--Select Department--</option>
                                                   <?php foreach($companydepartments as $department) : ?>
                                                    <option value="<?=$department->id?>"><?=$department->name?></option>
                                                    <?php endforeach ; ?>
                                                </select>
                                                <label class="focus-label">Designation </label>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group form-focus select-focus">
                                                <select class="select2-icon floating" id="company_designations_<?=$employee->id?>" name="designation">
                                                    <option value="">--Select Designation--</option>

                                                </select>
                                                <label class="focus-label">Designation </label>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-info" type="submit">Add</button>
                                            <input type="hidden" name="empId" value="<?= $employee->id ?>">
                                            <input type="hidden" name="companyId" value="<?= $authuser->choosen_companyId ?>">
                                            <input type="hidden" name="tagvalue" value="<?= $tagvalue ?>">
                                        </td>
                                    </form>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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

    function updaterole(userid, companyId) {
        console.log($('#member_role_' + userid).val());
        $.ajax({
            url: '/companies-user/updaterole',
            method: 'post',
            dataType: 'json',
            data: {
                'userid': userid,
                'role': $('#member_role_' + userid).val()
            },
            success: function(data) {

                if (data != null) {
                    window.location = '/companies-user/employees/' + companyId + '';
                }



            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })
    }


    var values;
    $(".multiselector").on("select2:select", function(event) {

        values = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            values[i] = parseInt($(selected).val());

        });
    });

    function filterdesignations(employee_id){

        var departmentId = $('#company_department_'+employee_id).val();
        console.log(departmentId, 'id');

        $.ajax({
            url: '/departments/filterdesignations',
            method: 'post',
            dataType: 'json',
            data: {
                'departmentId': departmentId,
            },
            success: function(data) {
                console.log(data);

                if (data != null) {
                   str = ''
                   data.forEach(function(designation){
                       str += ' <option value="'+designation.id+'">'+designation.name+'</option>'
                   });
                   $('#company_designations_'+employee_id).append(str);

                }
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        })
    }
</script>
