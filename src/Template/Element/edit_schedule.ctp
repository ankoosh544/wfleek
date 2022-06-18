<!-- Edit Schedule Modal -->
<div id="edit_schedule_<?= $todayschedule->id ?>_<?= $date ?>" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/shift-schedules/editshift" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="col-form-label">Department <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" id="editdepartmentId" onchange="editfilteremployees(<?= $companyId ?>)" name="editdepartmentId">
                                    <option value="">Select</option>
                                    <?php foreach ($departments as $department) : ?>
                                        <?php if ($todayschedule->department_id == $department->id) : ?>
                                            <option selected value="<?= $department->id ?>"><?= $department->name ?></option>
                                        <?php else : ?>
                                            <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-form-label">Employee Name <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" id="editdepartmentemployees" name="editemployeeId">
                                    <option value="">Select </option>
                                    <?php foreach ($companymembers as $companymember) : ?>
                                        <?php if ($companymember->user_id == $todayschedule->user_id) : ?>
                                            <option selected value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                        <?php else : ?>
                                            <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="col-form-label">Shifts <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="select" name="editshift">
                                    <option value="">Select </option>
                                    <?php foreach ($shifts as $shift) : ?>
                                        <?php if ($todayschedule->shift_id == $shift->id) : ?>
                                            <option selected value="<?= $shift->id ?>"><?= $shift->name ?></option>
                                        <?php else : ?>
                                            <option value="<?= $shift->id ?>"><?= $shift->name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Start Time <span class="text-danger">*</span></label>
                                <div class="input-group date" sdata-target-input="nearest">
                                    <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker1" data-target="#datetimepicker1" value="<?= $todayschedule->scheduledshift_startdate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>" name="editstartdate" />
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">End Time <span class="text-danger">*</span></label>
                                <div class="input-group date" sdata-target-input="nearest">
                                    <input type="text" data-date-format="DD/MM/YYYY HH:mm:ss" class="form-control datetimepicker-input" id="datetimepicker2" data-target="#datetimepicker2" value="<?= $todayschedule->scheduledshift_enddate->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>" name="editenddate" />
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="custom-control custom-checkbox">
                                <?php if ($todayschedule->employee_shift->isRepeated == true) : ?>
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" checked name="isRepeated">
                                <?php else : ?>
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="isRepeated">
                                <?php endif; ?>
                                <label class="custom-control-label" for="customCheck1">Recurring Shift</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label">Repeat Every (Weeks)</label>
                            <div class="form-group">
                                <select class="select" name="daystorepeate">
                                    <?php if ($todayschedule->employee_shift->weeks_to_repeat == 1) : ?>
                                        <option selected value="1">1 </option>
                                        <option value="2">2 </option>
                                        <option value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option value="6">6 </option>
                                    <?php elseif ($todayschedule->employee_shift->weeks_to_repeat == 2) : ?>
                                        <option value="1">1 </option>
                                        <option selected value="2">2</option>
                                        <option value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option value="6">6 </option>
                                    <?php elseif ($todayschedule->employee_shift->weeks_to_repeat == 3) : ?>
                                        <option value="1">1</option>
                                        <option value="2">2 </option>
                                        <option selected value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option value="6">6 </option>
                                    <?php elseif ($todayschedule->employee_shift->weeks_to_repeat == 4) : ?>
                                        <option value="1">1</option>
                                        <option value="2">2 </option>
                                        <option value="3">3 </option>
                                        <option selected value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option value="6">6 </option>
                                    <?php elseif ($todayschedule->employee_shift->weeks_to_repeat == 5) : ?>
                                        <option value="1">1</option>
                                        <option value="2">2 </option>
                                        <option value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option selected value="5">5 </option>
                                        <option value="6">6 </option>
                                    <?php elseif ($todayschedule->employee_shift->weeks_to_repeat == 6) : ?>
                                        <option value="1">1</option>
                                        <option value="2">2 </option>
                                        <option value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option selected value="6">6 </option>
                                    <?php else : ?>
                                        <option value="1">1</option>
                                        <option value="2">2 </option>
                                        <option value="3">3 </option>
                                        <option value="4">4 </option>
                                        <option value="5">5 </option>
                                        <option value="6">6 </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group wday-box">

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="monday" class="days recurring" checked="" onclick="return false;"><span class="checkmark">M</span></label>

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="tuesday" class="days recurring" checked="" onclick="return false;"><span class="checkmark">T</span></label>

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="wednesday" class="days recurring" checked="" onclick="return false;"><span class="checkmark">W</span></label>

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="thursday" class="days recurring" checked="" onclick="return false;"><span class="checkmark">T</span></label>

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="friday" class="days recurring" checked="" onclick="return false;"><span class="checkmark">F</span></label>

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="saturday" class="days recurring" onclick="return false;"><span class="checkmark">S</span></label>

                                <label class="checkbox-inline"><input type="checkbox" name="week_days[]" value="sunday" class="days recurring" onclick="return false;"><span class="checkmark">S</span></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">End On <span class="text-danger">*</span></label>

                                <div class="cal-icon">
                                    <?php if ($todayschedule->employee_shift->endof_repeating_shift != null) : ?>
                                        <input class="form-control datetimepicker" type="text" name="endofshift" value="<?= $todayschedule->employee_shift->endof_repeating_shift ?>">
                                    <?php else : ?>
                                        <input class="form-control datetimepicker" name="endofshift" type="text">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-control custom-checkbox">
                                <?php if ($todayschedule->employee_shift->isIndefinite == true) : ?>
                                    <input type="checkbox" class="custom-control-input" id="customCheck2" checked name="isIndefinite">
                                <?php else : ?>
                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name="isIndefinite">
                                <?php endif; ?>
                                <label class="custom-control-label" for="customCheck2">Indefinite</label>
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
<!-- /Edit Schedule Modal -->

<script>
    function editfilteremployees(companyId) {
        departmentId = $('#editdepartmentId').val();
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
                $('#editdepartmentemployees').empty();
                var str = '<option value="">--Select Employee-- </option>';
                data.forEach(function(employee) {
                    str += '<option value="' + employee.user.id + '">' + employee.user.firstname + ' ' + employee.user.lastname + ' </option>'
                });

                $('#editdepartmentemployees').html(str);
            },
            error: function() {}
        });
    }
</script>
