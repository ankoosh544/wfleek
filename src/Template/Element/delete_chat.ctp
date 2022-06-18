<!-- Delete Project Modal -->
<div class="modal custom-modal fade" id="delete_chat_<?= $chat->id ?>" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Project</h3>
                    <p>Are you sure want to delete?</p>
                </div>

                <form action="/chats/deletechat" method="POST">
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" style="width: 100%;" class="btn btn-primary continue-btn">Delete</button>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                        <input type="hidden" name="chatid" value="<?=$chat->id?>">
                        <input type="hidden" name="touser" value="<?=$chat->touser_id?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Project Modal ---->
