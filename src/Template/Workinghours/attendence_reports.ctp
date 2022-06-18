	<!-- Page Wrapper -->
	<div class="page-wrapper">

	    <!-- Page Content -->
	    <div class="content container-fluid">

	        <!-- Page Header -->
	        <div class="page-header">
	            <div class="row">
	                <div class="col-sm-12">
	                    <h3 class="page-title">Attendance Reports</h3>
	                    <ul class="breadcrumb">
	                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
	                        <li class="breadcrumb-item active">Attendance Reports</li>
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
	                    <input type="text" class="form-control floating">
	                    <label class="focus-label">Employee Name</label>
	                </div>
	            </div>
	            <div class="col-sm-6 col-md-3">
	                <div class="form-group form-focus">
	                    <div class="cal-icon">
	                        <select class="form-control floating select">
	                            <option>
	                                Jan
	                            </option>
	                            <option>
	                                Feb
	                            </option>
	                            <option>
	                                Mar
	                            </option>
	                        </select>
	                    </div>
	                    <label class="focus-label">Month</label>
	                </div>
	            </div>
	            <div class="col-sm-6 col-md-3">
	                <div class="form-group form-focus">
	                    <div class="cal-icon">
	                        <select class="form-control floating select">
	                            <option>
	                                2020
	                            </option>
	                            <option>
	                                2019
	                            </option>
	                            <option>
	                                2018
	                            </option>
	                        </select>
	                    </div>
	                    <label class="focus-label">Year</label>
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
	                                <th>Employee Name</th>
	                                <th>Date</th>
	                                <th>Clock In</th>
	                                <th>Clock Out</th>
	                                <th>Work Status</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <?php foreach ($companymembers as $index => $companymember) : ?>
	                                <?php if (!empty($companymember->workinghours)) : ?>
	                                    <?php foreach ($companymember->workinghours as $index => $workinghour) : ?>
	                                        <tr>
	                                            <td><?= $index + 1 ?></td>
	                                            <td><?=$workinghour->user->firstname?> <?=$workinghour->user->lastname?></td>
	                                            <td><?=$workinghour->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome')?></td>
	                                            <td><?=$workinghour->start_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome HH:mm:ss')?></td>
	                                            <td><?=$workinghour->end_time->i18nFormat('dd/MM/yyyy', 'Europe/Rome HH:mm:ss')?></td>
                                               <td>
                                               <select class="select2-icon floating" onchange="updateuserstatus(<?= $companymember->user->id ?>,<?= $companymember->company_id ?>)" id="user_status_<?= $companymember->user->id ?>">
                                                <?php if ($companymember->status == 'A') : ?>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                <?php else : ?>
                                                    <option value="I" data-icon="fa fa-dot-circle-o text-danger">Inactive</option>
                                                    <option value="A" data-icon="fa fa-dot-circle-o text-success">Active</option>
                                                <?php endif; ?>
                                            </select>

                                               </td>
	                                        </tr>

	                                    <?php endforeach; ?>
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
