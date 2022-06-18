<div id="update-duedate_<?= $projecttask->id ?>" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Due Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/projecttasks/updateduedate">
                    <div class="form-group">
                        <label for="due-date">Due Date</label>
                        <input class="form-control datetimepicker" type="text" name="duedate" value="<?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>">
                    </div>

                    <div class="submit-section">
                        <input type="hidden" name="taskId" value="<?= $projecttask->id ?>">
                        <button class="btn btn-primary submit-btn">Update</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
