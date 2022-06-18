<!-- Add Schedule Modal -->

<div id="add_schedule" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/shift-schedules/add-schedule" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" name="departmentId" id="company_departmentId" onchange="filteremployees(<?= $companyId ?>)">
                                    <option selected disabled>--Select Department--</option>
                                    <?php foreach ($departments as $department) : ?>
                                        <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Employee Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" id="departmentemployees" name="employeeId">

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Shifts <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" name="shiftId">
                                    <option value="">Select </option>
                                    <?php foreach ($shifts as $shift) : ?>
                                        <option value="<?= $shift->id ?>"><?= $shift->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php if (!empty($shiftsrender)) : ?>
                            <div class="col-sm-6">
                                <label class="col-form-label">Start Time <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <!-- <div class="input-group date" sdata-target-input="nearest">
                                        <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker3" data-target="#datetimepicker3" name="startschedule" />
                                        <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->

                                    <div class="input-group date">
                                        <input type="text" class="form-control datetimepicker" name="startschedule" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">End Time <span class="text-danger">*</span></label>
                                <div class="form-group">
                                   <!--  <div class="input-group date" sdata-target-input="nearest">
                                        <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker4" data-target="#datetimepicker4" name="endschedule" />
                                        <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->
                                    <div class="input-group date">
                                        <input type="text" class="form-control datetimepicker" name="endschedule" />
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col-sm-6">
                                <label class="col-form-label">Start Time <span class="text-danger">*</span></label>
                                <div class="form-group">
                                   <!--  <div class="input-group date" sdata-target-input="nearest">
                                        <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker001" data-target="#datetimepicker001" name="startschedule" />
                                        <div class="input-group-append" data-target="#datetimepicker001" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->
                                    <div class="input-group date">
                                        <input type="text" class="form-control datetimepicker" name="startschedule" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label">End Time <span class="text-danger">*</span></label>
                                <div class="form-group">
                                   <!--  <div class="input-group date" sdata-target-input="nearest">
                                        <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker002" data-target="#datetimepicker002" name="endschedule" />
                                        <div class="input-group-append" data-target="#datetimepicker002" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->
                                    <div class="input-group date">
                                        <input type="text" class="form-control datetimepicker" name="endschedule" />
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="submit-section">
                        <input type="hidden" name="companyId" value="<?= $companyId ?>">
                        <?php if (!empty($shiftsrender)) : ?>
                            <input type="hidden" name="shifts" value="<?= $shiftsrender ?>">
                        <?php endif; ?>
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Schedule Modal -->

<script>
    function filteremployees(companyId) {
        departmentId = $('#company_departmentId').val();
        console.log(departmentId, 'departmentId');
        $.ajax({
            url: '/employee-shifts/filteremployees/',
            method: 'post',
            dataType: 'json',
            data: {
                ' departmentId': departmentId,
                'companyId': companyId
            },
            success: function(data) {
                // console.log(data);
                var str = '<option value="">--Select Employee-- </option>';
                data.forEach(function(employee) {
                    str += '<option value="' + employee.user.id + '">' + employee.user.firstname + ' ' + employee.user.lastname + ' </option>'
                });

                $('#departmentemployees').html(str);
            },
            error: function() {}
        });
    }
</script>
