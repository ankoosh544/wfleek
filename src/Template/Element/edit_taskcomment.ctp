<!-- Edit Task Comment Modal -->
<div class="modal custom-modal fade" id="editcomment_<?= $ticket->id ?>_<?= $comment->id ?>" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="/user/deleteuser/" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <div id="edit_comment_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary">Close</button>
                    <button type="button" class="btn btn-primary " onclick="updatecomment(<?= $comment->id ?>)">Update</button>
                </div>
            </form>


        </div>

    </div>
</div>

<!-- /Delete User Modal -->
<script>
    function updatecomment(commentId) {
        console.log(commentId, 'commentId');
        var content = $('#edit_comment_' + commentId).text();
        $.ajax({
            url: '/comments/updatecomment',
            method: 'post',
            dataType: 'json',
            data: {
                'content': content,
                'commentId': commentId
            },
            success: function(data) {
                location.reload();

            },
            error: function() {}
        });



    }
</script>
