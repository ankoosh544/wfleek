<div id="taskmessage_<?= $comment->id ?>" class="modal custom-modal fade" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="reply">Comment</label>
                    <div class="form-control summernote" id="content_<?=$comment->id?>_<?=$comment->taskId?>" contenteditable="true"> <?= $comment->content ?> </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Close</button>
                <a class="btn btn-primary " aria-label="Close" onclick="updatemessage(<?= $comment->id ?>, <?= $comment->taskId?>, <?=$user_id?>)">Update</a>
            </div>
        </div>
    </div>
</div>

<script>
    function updatemessage(cid, tid, auth) {

        console.log(cid);
        var content = $('#content_' + cid +'_'+ tid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'commentId': cid,
                'tid' : tid,
                'content': content
            },
            success: function(data) {
                location.reload();
               // todorenderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());

            },
            error: function() {}
        });
    }
</script>
