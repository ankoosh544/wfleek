	<!-- Page Wrapper -->
	<div class="page-wrapper">

	    <!-- Page Content -->
	    <div class="content container-fluid">

	        <!-- Page Header -->
	        <div class="page-header">
	            <div class="row align-items-center">
	                <div class="col">
	                    <h3 class="page-title">Appointments</h3>
	                    <ul class="breadcrumb">
	                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
	                        <li class="breadcrumb-item active">Appointments</li>
	                    </ul>
	                </div>
	                <div class="col-auto float-right ml-auto">
	                    <a href="/appointments/bookingpage?companyId=<?= $companyId ?>" class="btn add-btn"><i class="fa fa-plus"></i> Book Appointment</a>
	                </div>
	            </div>
	        </div>
	        <!-- /Page Header -->

	        <div class="row">
	            <div class="col-md-12">
	                <div class="table-responsive">
	                    <table class="table table-striped custom-table mb-0 datatable">
	                        <thead>
	                            <tr>
	                                <th style="width: 30px;">#</th>
	                                <th>Name </th>
	                                <th>Title</th>
	                                <th>Email </th>
	                                <th>Subject </th>
	                                <th>Status </th>
	                                <th class="text-right">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <?php foreach ($appointments as $index => $appointment) : ?>
	                                <tr>
	                                    <td><?= $index+1?></td>
	                                    <td>
	                                        <h2 class="table-avatar">
	                                            <a href="/user/view/<?=$appointment->candidate->id?>" class="avatar">
	                                                <?php if ($appointment->candidate->profileFilename != null && $appointment->candidate->profileFilepath != null) : ?>
	                                                    <img alt="" src="<?= $appointment->candidate->profileFilepath ?>/<?= $appointment->candidate->profileFilename ?>">
	                                                <?php else : ?>
	                                                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
	                                                <?php endif; ?>
	                                            </a>
	                                            <a href="/user/view/<?=$appointment->candidate->id?>"><?= $appointment->candidate->firstname ?> <?= $appointment->candidate->lastname ?> </a>
	                                        </h2>
	                                    </td>
                                        <td><?=$appointment->title?></td>
                                        <td><?= $appointment->candidate->email ?></td>
                                        <td><?= $appointment->subject ?></td>
	                                    <td>
	                                        <select class="select2-icon floating" id="appointmentstatus" onchange="updateappointmentstatus(<?= $appointment->id ?>)">
	                                            <?php if ($appointment->status == true) : ?>
	                                                <option selected value="1" data-icon="fa fa-dot-circle-o text-success">Accepted</option>
	                                                <option value="0" data-icon="fa fa-dot-circle-o text-warning">Pending</option>
	                                            <?php else : ?>
	                                                <option value="1" data-icon="fa fa-dot-circle-o text-success">Accepted</option>
	                                                <option selected value="0" data-icon="fa fa-dot-circle-o text-warning">Pending</option>

	                                            <?php endif; ?>
	                                        </select>
	                                    </td>
	                                    <td class="text-right">
	                                        <div class="dropdown dropdown-action">
	                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
	                                            <div class="dropdown-menu dropdown-menu-right">
	                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_type"><i class="fa fa-pencil m-r-5"></i> Edit</a>
	                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_type"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
	    </div>
	    <!-- /Page Content -->

	    <!-- Add Trainers List Modal -->
	    <div id="add_trainer" class="modal custom-modal fade" role="dialog">
	        <div class="modal-dialog modal-dialog-centered" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title">Add New Trainer</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <form>
	                        <div class="row">
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">First Name <span class="text-danger">*</span></label>
	                                    <input class="form-control" type="text">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Last Name</label>
	                                    <input class="form-control" type="text">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Role <span class="text-danger">*</span></label>
	                                    <input class="form-control" type="text">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
	                                    <input class="form-control" type="email">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Phone </label>
	                                    <input class="form-control" type="text">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Status</label>
	                                    <select class="select">
	                                        <option>Active</option>
	                                        <option>Inactive</option>
	                                    </select>
	                                </div>
	                            </div>
	                            <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label>Description <span class="text-danger">*</span></label>
	                                    <textarea class="form-control" rows="4"></textarea>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="submit-section">
	                            <button class="btn btn-primary submit-btn">Submit</button>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- /Add Trainers List Modal -->

	    <!-- Edit Trainers List Modal -->
	    <div id="edit_type" class="modal custom-modal fade" role="dialog">
	        <div class="modal-dialog modal-dialog-centered" role="document">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title">Edit Trainer</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <form>
	                        <div class="row">
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">First Name <span class="text-danger">*</span></label>
	                                    <input class="form-control" type="text" value="John">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Last Name</label>
	                                    <input class="form-control" type="text" value="Doe">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Role <span class="text-danger">*</span></label>
	                                    <input class="form-control" type="text" value="Web Developer">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
	                                    <input class="form-control" type="email" value="johndoe@example.com">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Phone </label>
	                                    <input class="form-control" type="text" value="9876543210">
	                                </div>
	                            </div>
	                            <div class="col-sm-6">
	                                <div class="form-group">
	                                    <label class="col-form-label">Status</label>
	                                    <select class="select">
	                                        <option>Active</option>
	                                        <option>Inactive</option>
	                                    </select>
	                                </div>
	                            </div>
	                            <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label>Description <span class="text-danger">*</span></label>
	                                    <textarea class="form-control" rows="4">Lorem ipsum ismap</textarea>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="submit-section">
	                            <button class="btn btn-primary submit-btn">Save</button>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- /Edit Trainers List Modal -->

	    <!-- Delete Trainers List Modal -->
	    <div class="modal custom-modal fade" id="delete_type" role="dialog">
	        <div class="modal-dialog modal-dialog-centered">
	            <div class="modal-content">
	                <div class="modal-body">
	                    <div class="form-header">
	                        <h3>Delete Trainers List</h3>
	                        <p>Are you sure want to delete?</p>
	                    </div>
	                    <div class="modal-btn delete-action">
	                        <div class="row">
	                            <div class="col-6">
	                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
	    <!-- /Delete Trainers List Modal -->

	</div>
	<!-- /Page Wrapper -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
        function updateappointmentstatus(id){
            status = $('#appointmentstatus').val()
            $.ajax({
            url: '/appointments/updateappointmentstatus',
            method: 'post',
            dataType: 'json',
            data: {
                'status': status,
                'id': id,
            },
            success: function(data) {
                console.log(data);
                location.reload();
            },
            error: function() {}
        });
        var frame;
        setInterval(function() {
            frame = someSortOf.Code();
        });

        }
	</script>
