<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">User Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Reports</li>
                    </ul>
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
                    <label class="focus-label">User Role</label>
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
                                <th>#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companymembers as $index => $companymember) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="profile.html" class="avatar">
                                                <?php if ($companymember->user->profileFilepath != null && $companymember->user->profileFilename != null) : ?>
                                                    <img src="<?= $companymember->user->profileFilepath ?>/<?= $companymember->user->profileFilename ?>" alt="">
                                                <?php else : ?>
                                                    <img src="/assets/img/profiles/avatar-19.jpg" alt="">
                                                <?php endif; ?>
                                            </a>
                                            <a href="/user/view/<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?> <span><?= $companymember->usercompany->name ?></span></a>
                                        </h2>
                                    </td>
                                    <td><?= $companymember->usercompany->name ?></td>
                                    <td><?= $companymember->user->email ?></td>
                                    <td>
                                        <span class="badge bg-inverse-info"><?= $companymember->designation->name ?></span>
                                    </td>

                                    <td>
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
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_user_<?= $companymember->user->id ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user_<?= $companymember->user->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
