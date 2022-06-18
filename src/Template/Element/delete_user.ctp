<!-- Delete User Modal -->
<div class="modal custom-modal fade" id="delete_user_<?= $companymember->user->id ?>" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="/user/deleteuser/" method="post">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete User</h3>
                        <p>Are you sure want to delete?</p>
                    </div>

                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary continue-btn">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="userid" value="<?= $companymember->user->id ?>">
                    <input type="hidden" name="companyId" value="<?=$companymember->company_id?>"

                    <?php if(!empty($user_companyId)) : ?>
                        <input type="hidden" name="user_companyId" value="<?= $user_companyId ?>" >
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Delete User Modal -->
