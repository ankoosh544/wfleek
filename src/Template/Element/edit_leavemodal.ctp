<!-- Edit Leave Modal -->
<div id="edit_leave_<?= $emp->id ?>" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Leave <?= $emp->id ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/leaves/editleave" method="POST">
                    <div class="form-group form-focus select-focus">
                        <label>Leave Type <span class="text-danger">*</span></label>
                        <select class="select2-icon floating" id="leavetype" name="leavetype" onchange="changeLeaveTypeupdate(this, <?= $emp->id ?>); return false;">

                            <?php if ($emp->leavetype == 'M') : ?>
                                <option value="M" selected> Medical Leave</option>
                                <option value="C"> Casual Leave</option>
                                <option value="P">Loss of Pay</option>

                            <?php elseif ($emp->leavetype == 'C') : ?>
                                <option value="M"> Medical Leave</option>
                                <option value="C" selected> Casual Leave</option>
                                <option value="P">Loss of Pay</option>


                            <?php else : ?>
                                <option value="M"> Medical Leave</option>
                                <option value="C"> Casual Leave</option>
                                <option value="P" selected>Loss of Pay</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <?php if ($emp->leavetype == 'M') : ?>
                        <div class="form-group" id="medicalno">
                            <label for="medicalno"><?= __('Enter Medical Number') ?></label>
                            <input class="form-control" type="text" id="medicalno" name="medicalno" value="<?= $emp->medical_number ?>">

                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>From <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="fromdate" value="<?= $emp->fromdate->i18nFormat('dd-MM-yyyy'); ?>" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>To <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="todate" value="<?= $emp->todate->i18nFormat('dd-MM-yyyy'); ?>" type="text">
                        </div>
                    </div>
                    <?php
                    $diff = abs(strtotime($emp->todate) - strtotime($emp->fromdate));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    $totaldays = $days;
                    ?>
                    <div class="form-group">
                        <label>Number of days <span class="text-danger">*</span></label>
                        <input class="form-control" readonly type="text" value="<?= $totaldays ?>">
                    </div>
                    <div class="form-group">
                        <label>Remaining Leaves <span class="text-danger">*</span></label>
                        <input class="form-control" readonly value="12" type="text">
                    </div>
                    <div class="form-group">
                        <label>Leave Reason <span class="text-danger">*</span></label>
                        <textarea rows="4" name="leavereason" class="form-control summernote"><?= $emp->leavereason ?></textarea>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Leave Modal -->
