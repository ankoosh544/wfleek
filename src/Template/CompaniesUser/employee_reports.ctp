<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">


        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Employee Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Report</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="/companies-user/generatepdf?companyId=<?=$companyId?>" class="btn btn-primary">PDF</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->

        <!-- Search Filter -->
        <div class="row filter-row mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <input class="form-control floating" type="text">
                    <label class="focus-label">Employee</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus select-focus">
                    <select class="select floating">
                        <option>Select Department</option>
                        <option>Designing</option>
                        <option>Development</option>
                        <option>Finance</option>
                        <option>Hr & Finance</option>
                    </select>
                    <label class="focus-label">Department</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <div class="cal-icon">
                        <input class="form-control floating datetimepicker" type="text">
                    </div>
                    <label class="focus-label">To</label>
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
                                <th>Employee Name</th>
                                <th>Employee Type</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Joining Date</th>
                                <th>DOB</th>
                                <th>Martial Status</th>
                                <th>Gender</th>
                                <th>Terminated Date</th>
                                <th>Relieving Date</th>
                                <th>Salary</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Emercency Contact Details</th>
                                <th>Experience</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companymembers as $companymember) : ?>
                                <?php if ($companymember->designation->name != 'Customer') : ?>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">

                                                <a href="profile.html" class="avatar">
                                                    <?php if ($companymember->user->profileFilepath != null && $companymember->user->profileFilename != null) : ?>
                                                        <img alt="" src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>">
                                                    <?php else : ?>
                                                        <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                    <?php endif; ?>
                                                </a>
                                                <a href="profile.html" class="text-primary"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?> <span>#<?= $companymember->user->id ?></span></a>
                                            </h2>
                                        </td>
                                        <td>Employee</td>
                                        <td class="text-info"><?= $companymember->user->email ?></td>
                                        <td><?=$companymember->designation->department->name?></td>
                                        <td>
                                           <?=$companymember->designation->name?>
                                        </td>
                                        <td><?= $companymember->user->registrationDate->i18nFormat('dd/MM/yyyy ', 'Europe/Rome') ?></td>
                                        <td><?= $companymember->user->birthday->i18nFormat('dd/MM/yyyy ', 'Europe/Rome') ?></td>
                                        <td>Married</td>
                                        <td><?= $companymember->user->gender ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>$20000</td>
                                        <td>
                                            <?= $companymember->user->address ?>
                                        </td>
                                        <td><?= $companymember->user->tel ?></td>
                                        <td>7894561235</td>
                                        <td>0 years 4 months and 9 days</td>
                                        <td>
                                            <!-- <button class="btn btn-outline-success btn-sm">Active</button> -->
                                            <select class="select2-icon floating" onchange="updateuserstatus(<?= $companymember->user->id ?>,<?= $companymember->company_id ?>)" id="user_status_<?= $companymember->user->id ?>">
                                                <?php if ($companymember->status == 'A') : ?>
                                                    <option selected value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                <?php else : ?>
                                                    <option selected value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                <?php endif; ?>
                                            </select>

                                        </td>
                                    </tr>
                                <?php endif; ?>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };


    $('.select2-icon').select2({

        width: "90%",
        templateSelection: formatText,
        templateResult: formatText
    });
      function updateuserstatus(userId, companyId) {
        var status = $('#user_status_' + userId).val();
        $.ajax({
            url: '/companies-user/updateuserstatus',
            method: 'post',
            dataType: 'json',
            data: {
                'userId': userId,
                'companyId': companyId,
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
</script>
