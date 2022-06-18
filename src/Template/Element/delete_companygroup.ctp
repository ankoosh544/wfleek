<!-- Delete Project Modal -->
<div class="modal custom-modal fade" id="delete_group_<?= $companygroup->id ?>" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Group</h3>
                    <p>Are you sure want to delete?</p>
                </div>

                <form action="/groups/delete/" method="POST">
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" style="width: 100%;" class="btn btn-primary continue-btn">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="companygroup_id" value="<?=$companygroup->id ?>">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Project Modal ---->
