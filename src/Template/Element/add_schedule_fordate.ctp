<!-- Add Schedule Modal -->


<div id="add_schedule_fordate_<?= $companymember->user->id ?>_<?= $listdate ?>" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Schedule <?=$listdate?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $date = strtotime($listdate); $datetime = date('d/m/Y', $date); $newdate=strtotime($datetime);  ?>
            <div class="modal-body">
                <form action="/shift-schedules/add-schedule" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" name="departmentId" id="company_departmentId_<?= $companymember->user->id ?>" onchange="filteremployeesdate(<?= $companyId ?>, <?= $companymember->user->id ?>,<?= $listdate ?>)">
                                    <option selected disabled>--Select Department--</option>
                                    <?php foreach ($departments as $department) : ?>
                                        <?php if($companymember->department_id == $department->id): ?>
                                        <option selected value="<?= $department->id ?>"><?= $department->name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Employee Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" id="departmentemployees_<?= $companymember->user->id ?>_<?= $newdate ?>" name="employeeId">
                                <option selected value="<?=$companymember->user->id?>"><?=$companymember->user->firstname?> <?=$companymember->user->lastname?></option>
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

                        <div class="col-sm-6">
                            <label class="col-form-label">Start Time <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="input-group date">
                                    <input type="text" class="form-control datetimepicker" id="startdate_<?=$companymember->user->id?>" name="startschedule" value="<?= $datetime ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Start Time <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="input-group date">
                                    <input type="text" class="form-control datetimepicker" id="enddate_<?=$companymember->user->id?>" name="endschedule" value="<?= $datetime ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <input type="hidden" name="companyId" value="<?= $companyId ?>">
                        <?php if (!empty($shiftsrender)) : ?>
                            <input type="hidden" name="shifts" value="<?= $shiftsrender ?>">
                        <?php endif; ?>
                        <button class="btn btn-primary submit-btn">Submit</button>
                        <input type="hidden" value="<?=$newdate?>" name="datetime" id="mydate">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Schedule Modal -->

<script>
    function filteremployeesdate(companyId, userId) {
var mydate = $('#mydate').val();

console.log(mydate, 'date');
        departmentId = $('#company_departmentId_'+userId).val();
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
                 console.log(data);
                var str = '<option value="">--Select Employee-- </option>';
                data.forEach(function(employee) {
                    str += '<option value="' + employee.user.id + '">' + employee.user.firstname + ' ' + employee.user.lastname + ' </option>'
                });

                $('#departmentemployees_'+userId+'_'+mydate).html(str);
            },
            error: function() {}
        });
    }
</script>
