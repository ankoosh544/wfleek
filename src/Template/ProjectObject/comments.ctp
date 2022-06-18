<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
<script>
    function todorenderComments(data, auth, tid, text) {
        if (text == '') {
            text = 'View all Comments';
        }
        console.log(data, 'this is data');
        $('#textcontent_' + tid).empty();
        $('#ajaxmessages_' + tid).empty();
        var commentsHtml = "";
        console.log(text, 'this is text');
        commentsHtml += '</br> <a class="btn btn-info" href="" style="margin-left: 7%;" onclick=" showComments(' + tid + ',' + auth + '); return false;" id="viewallcomments_' + tid + '">' + text + '</a>';
        data.forEach((comment, index) => {
            var isSeen = comment.isSeen == true ? '<i class="material-icons">check</i>' : '';
            if (index >= (data.length - 3)) {
                commentsHtml += '<div class="todoNewCommentsSection_' + comment.taskId + '_' + comment.id + '">';
                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="chat-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="todoeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="tododeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span class="task-chat-user" id="todorightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    commentsHtml += '<div>' +
                        '<p class="commenttasktodo_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="todorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>' +
                            '</div>';
                    }
                    commentsHtml += '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '<span class="task-chat-user" id="todorightsideCommentUsername_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '">' + reply.user.firstname + ' ' + reply.user.lastname + '</span>';
                            }

                            commentsHtml += '<div>' +
                                '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + reply.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + reply.creation_date + '' + isSeen + ' </span>' +
                                    '</div>';
                            }

                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-1" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                //'<span>'+ reply.user.firstname+'</span>'
                                '</a>' +
                                '</div>' +
                                '</div>';

                                commentsHtml += '</div>';
                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +

                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });

                    }

                    commentsHtml += ' <div class="modal submodal" id="todoedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closetodoedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="content_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updatetodocomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {

                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="chat-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="todoCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + ' </span>';

                    }
                    commentsHtml += '<p id="todoCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-avatar col-1" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';
                }
                commentsHtml += '</div>';

            } else {
                var display = text === "View all Comments" ? "none" : "block";
                commentsHtml += '<div class="todoNewCommentsSection_' + comment.taskId + '_' + comment.id + '"  style="display:' + display + ';">';

                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="chat-content">' +
                        '<div class="dropdown kanban-action" style="text-align: start;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_replyrightside_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Reply</a>' +
                        '<a class="dropdown-item" href="#" onclick="todoeditModal(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')" class="edit-msg">Edit</a>' +
                        '<a class="dropdown-item" onclick="tododeletecomment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + auth + ')">Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="todorightsideCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    commentsHtml += '<div>' +
                        '<p class="commenttasktodo_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="todorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>' +
                            '</div>';
                    }

                    commentsHtml += '<ul class="attach-list">';
                    if (comment.taskfiles.length > 0) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>' +
                                    '<span id="todorightsideCommentUsername_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="task-chat-user">' + reply.user.firstname + ' ' + reply.user.lastname + '</span>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-1" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>'+
                                '</div>';
                                commentsHtml += '</div>';

                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +

                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +

                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }
                    commentsHtml +=' <div class="modal submodal" id="todoedit_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" style="display: none;left:25%">' +
                        '<div class="modal-dialog-centered modal-md" role="dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title">Assign the user to task' + comment.taskId + '</h5>' +
                        '<button type="button" class="close" aria-label="Close" onclick="closetodoedit(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="content_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="form-control" contenteditable="true">' + comment.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary">Close</button>' +
                        '<input type="hidden" name="pid" id="pid" value="' + comment.project_id + '">' +
                        '<input type="hidden" name="commentId" id="content_' + comment.taskId + '_' + comment.id + '" value="' + comment.id + '">' +
                        '<button type="button" class="btn btn-primary " aria-label="Close" onclick="updatetodocomments(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ',' + comment.user_id + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if (comment.user_id != auth) {
                    commentsHtml += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="chat-content">' +
                        '<div class="dropdown kanban-action" style="text-align: end;">' +
                        '<a href="" data-toggle="dropdown">' +
                        '<i class="fa fa-ellipsis-v"></i>' +
                        '</a>' +
                        '<div class="dropdown-menu dropdown-menu-right">' +
                        '<a class="dropdown-item" onclick ="todo_reply_comment(' + comment.taskId + ',' + comment.project_id + ',' + comment.id + ')"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>' +
                        '</div>' +
                        '</div>' +
                        '<span id="todoCommentUsername_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" class="task-chat-user">' + comment.user.firstname + ' ' + comment.user.lastname + '</span>';
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + ' </span>';

                    }
                    commentsHtml += '<p id="todoCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
                    if (comment.taskfiles) {
                        comment.taskfiles.forEach((taskfile) => {
                            commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '" >' + taskfile.filename + '</a></li>';
                        });
                    }
                    commentsHtml += '</ul>' +
                        '</div>' +

                        '</div>' +
                        '</div>';

                    if (comment.replies) {
                        comment.replies.forEach((reply) => {
                            commentsHtml += '<div class="row">' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style="width:80%">';
                            if (reply.user_id == auth) {
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: start;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + ' </span>';
                            }
                            commentsHtml += '</span>';
                            if (reply.taskfiles) {
                                commentsHtml += '<ul class="attach-list">';
                                reply.taskfiles.forEach((taskfile) => {
                                    commentsHtml += '<li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/' + taskfile.id + '">' + taskfile.filename + '</a></li>';
                                });
                            }
                            commentsHtml += '</ul>' +
                                '</div>' +
                                '</div>' +
                                '<div class="chat-avatar col-1" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '</div>';
                            commentsHtml += '<div class="modal submodal" id="todoeditReply_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" style="display: none;left:25%">' +
                                '<div class="modal-dialog-centered modal-md" role="dialog">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header">' +
                                '<h5 class="modal-title">Update Reply</h5>' +
                                '<button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')">' +
                                '<span aria-hidden="true">&times;</span>' +
                                '</button>' +
                                '</div>' +
                                '<div class="modal-body">' +
                                '<div class="form-group">' +
                                '<label for="reply">Comment</label>' +
                                '<div id="replycontent_' + reply.taskId + '_' + reply.project_id + '_' + reply.id + '" class="form-control" contenteditable="true">' + reply.content + '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-secondary">Close</button>' +
                                '<button type="button" class="btn btn-primary " onclick="updatetodoReply(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')">Update</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        });
                    }

                    commentsHtml += '</div>';
                }

                commentsHtml += '</div></div>';

            }


        });
        //  console.log(commentsHtml);
        $('#ajaxmessages_' + tid).html(commentsHtml);

    }

    var replay = 0;

    function submitMessage(pid, tid, auth) {
        var testing = $('#chatBubble_tid').text()
        var content = $('#textcontent_' + tid).val();
        var file_data = $("#todoimages_" + tid).prop("files");
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = pid;
        }
        var content = $('#textcontent_' + tid).val();
        form_data.append("replay", replay);
        form_data.append("pid", pid);
        form_data.append("tid", tid);
        form_data.append("content", content);
        if (replay == 1) {
            var cid = $('#chatBubble_' + tid + ' input').val();
            console.log("Cid", cid);
            form_data.append("cid", cid);
            $('#chatBubble_' + tid).empty()
        }
        form_data.append('isFileNotAttached', isFileNotAttached);
        $('#textcontent_' + tid).val('');
        $.ajax({
            url: '/comments/submit-message',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                todorenderComments(data, auth, tid, $('#viewallcomments').text());
                $("#todoimages_" + tid).replaceWith($("#todoimages_" + tid).val('').clone(true));
            },
            error: function() {}
        });
    }


    //Download files function
    function tododownloadfile(fileId) {
        console.log(fileId, 'fileId');
        $.ajax({

            url: '/taskfiles/downloadtaskfile',
            method: 'post',
            dataType: 'json',
            data: {
                'fileId': fileId
            },
            success: function(data) {
                console.log(data, 'filed downloaded');


            },

            error: function() {

            }
        });
    }

    //update todocomment Section
    function updatetodocomments(tid, pid, cid, auth) {
        var isTaskboard = tid;
        var content = $('#content_' + tid + '_' + pid + '_' + cid).text();
        $.ajax({
            url: '/comments/updatecomment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': cid,
                'content': content
            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#viewallcomments').text());
                $('#todoedit_' + tid + '_' + pid + '_' + cid).modal('hide');
            },
            error: function() {}
        });
    }


    //update reply comment
    function updatetodoReply(tid, pid, rid, auth) {
        var isTaskboard = tid;
        var content = $('#replycontent_' + tid + '_' + pid + '_' + rid).text();
        $.ajax({
            url: '/comments/updateComment',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': tid,
                'pid': pid,
                'commentId': rid,
                'content': content
            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#viewallcomments').text());
                $('#todoeditReply_' + tid + '_' + pid + '_' + rid).modal('hide');
            },
            error: function() {}
        });
    }


    //Delete comment function
    function tododeletecomment(tid, pid, cid, auth) {
        $.ajax({
            url: '/comments/delete',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
                'pid': pid,
                'cid': cid
            },
            success: function(data) {
                todorenderComments(data, auth, tid, $('#viewallcomments').text());
            },
            error: function() {}
        });
    }

    //Reply Comment Section fucntions

    function todo_reply_comment(tid, pid, cid) {
        replay = 1;
        var str = '<input name="cid" id="cid" type="hidden" value="' + cid + '">';
        var replaystr = '<p name="replay" id="replay_' + cid + '" type="hidden">' + replay + '</p>';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="closeReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#chatBubble_" + tid).empty();
        $('#todoreplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#chatBubble_" + tid).append('<div class="form-group" id="todoreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="todoreplayPara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '</div>');
        $('#todoreplayPara_' + tid + '_' + pid + '_' + cid).html($('#todoCommentContent_' + tid + '_' + pid + '_' + cid + '').text());
    }

    function closeReplyModal(tid) {
        $('#chatBubble_' + tid).empty();
    }

    function todo_replyrightside_comment(tid, pid, cid) {
        replay = 1;
        var replaystr = "";
        var replaystr = '<p name="replay" id="replay" type="hidden">' + replay + '</p>';
        var str = '<input name="cid" id="cid" type="hidden" value="' + cid + '">';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="closeReplyModal(' + tid + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';
        $("#chatBubble_" + tid).empty();
        $('#todoreplayPara_' + tid + '_' + pid + '_' + cid).empty();
        $("#chatBubble_" + tid).append('<div class="form-group" id="todoreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="todoreplayrightsidePara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '</div>');
        $('#todoreplayrightsidePara_' + tid + '_' + pid + '_' + cid).html($('#todorightsideCommentContent_' + tid + '_' + pid + '_' + cid + '').text());
    }
    // Reply Comment Sections functions



    var commentvalue = false;

    function showComments(tid, auth) {
        commentvalue = !commentvalue;
        if ($('#viewallcomments_' + tid).text() == 'View all Comments') {
            $('#viewallcomments_' + tid).text('Hide');
        } else {
            $('#viewallcomments_' + tid).text('View all Comments');
        }
        $('.todoNewCommentsSection_' + tid).show();
        $.ajax({
            url: '/comments/updateIsseen',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': tid,
            },
            success: function(data) {
                console.log($('#viewallcomments_' + tid).text(), 'this is text');
                todorenderComments(data, auth, tid, $('#viewallcomments_' + tid).text());
            },
            error: function() {}
        });
    }

    function todoshowModal(tid) {
        $('#todoadd_userforalltask_' + tid).show();
    }

    function todoeditModal(tid, pid, cid) {
        $('#todoedit_' + tid + '_' + pid + '_' + cid).show();
    }

    function todoeditReplyModal(tid, pid, rid) {
        $('#todoeditReply_' + tid + '_' + pid + '_' + rid).show();
    }

    function closetodoeditreply(tid, pid, rid) {
        $('#todoeditReply_' + tid + '_' + pid + '_' + rid).hide();
    }

    function closetodoedit(tid, pid, cid) {
        $('#todoedit_' + tid + '_' + pid + '_' + cid).hide();
    }
</script>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="page-header container">
            <div class="row">
                <div class="form-group form-focus" style="width: 50%;">
                    <input type="text" id="myInput" onkeyup="myfunction(<?= $total ?>)" class="form-control">
                    <label class="focus-label">Task Name</label>
                </div>
                <div class="form-group form-focus select-focus" style="width: 50%;">
                    <label class="focus-label">Select Group </label>
                    <select class="select2-icon floating" id="selecttask" name="selecttask" onchange="displaytaskcomments(<?= $total ?>)">
                        <?php foreach ($totaltasks as $task) : ?>
                            <option value="<?= $task->title ?>"><?= $task->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>


        <?php foreach ($totaltasks as $key => $task) : ?>
            <div class="page-comments" id="mycard_<?= $key ?>">

                <div class="container">
                    <div class="form-group" style="display: flex;">
                        <h3 style="height: 100%;" id="myrow_<?= $key ?>"><a class="btn btn-info" href="/project-object/taskboard/<?= $projectObject->id ?>"><?= $task->title ?></a></h3>
                        <textarea class="form-control" style="width: 100%;" rows="3" disabled><?= $task->description  ?> </textarea>
                    </div>
                    <div class="message-inner row" style="display: flex;">
                        <div class="file-options col-1" id="uploadfileoption" style="padding: 10px;">
                            <span class="btn-file">
                                <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="todoimages_<?= $task->id ?>" name="images" type="file" multiple />
                                <img src="/assets/img/attachment.png" alt="">
                            </span>
                        </div>
                        <div class="message-area col-11" style="margin-left: -55px;">
                            <div id="chatBubble_<?= $task->id ?>" style="background-color: white;">
                            </div>
                            <div class="input-group">
                                <textarea class="form-control" type="text" id="textcontent_<?= $task->id ?>" placeholder="Type message..."></textarea>
                                <span class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="submitMessage(<?= $projectObject->id ?>, <?= $task->id ?>, <?= $user_id ?>);return false;"><i class="fa fa-send"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>




                <div id="ajaxmessages_<?= $task->id ?>">
                    <?php $taskcomments = array();
                    foreach ($allcomments as $index => $comment) {
                        if ($comment->taskId == $task->id) {
                            array_push($taskcomments, $comment);
                        }
                    }
                    ?>
                    </br>
                    <a class="btn btn-info" style="margin-left: 7%;" onclick="showComments(<?= $task->id ?>,<?= $user_id ?>);return false;" id="viewallcomments_<?= $task->id ?>">View all Comments</a>
                    </br>
                    <?php foreach ($taskcomments as $index => $comment) : ?>




                        <!----------------Email-- and hashtag-------------->
                        <?php

                        $test_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";

                        preg_match_all($test_patt, $comment->content, $valid);
                        preg_match_all("/#(\\w+)/", $comment->content, $tags);
                        if (!empty($valid)) {
                            foreach ($valid[0] as $email) {
                                foreach ($userData as $data) {
                                    if ($email == $data->email) {
                                        $comment->content = str_replace($email, "<a href='/user/profile/" . $data->id . "'>" . $email . "</a>", $comment->content);
                                    }
                                }
                            }
                        }

                        foreach ($tags[0] as $hashtag) {
                            $pos = strpos($comment->content, $hashtag);
                            $str = ltrim($hashtag, '#');
                            $link = "/comments/hashtags/$str";

                            $comment->content = str_replace($hashtag, "<a href='" . $link . "'>" . $hashtag . "</a>", $comment->content);
                        }

                        ?>
                        <!----------------Email-- and hashtag-------------->
                        <!----New and top3 Comment--->
                        <?php if ($index >= (count($taskcomments) - 3)) : ?>
                            <div class="todoNewCommentsSection_<?= $task->id ?>" id="todoNewComments_<?= $task->id ?>_<?= $comment->id ?>">

                                <?php if ($comment->user_id != $user_id) : ?>
                                    <div class="chat chat-left container">
                                        <div class="chat-avatar">
                                            <a href="profile.html" class="avatar">
                                                <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-bubble">
                                                <div class="chat-content">
                                                    <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-5px, 22px, 0px); ">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" onclick="todo_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                        </div>
                                                    </div>
                                                    <span class="task-chat-user">
                                                        <p id="todoCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                    </span>
                                                    <div>
                                                        <p id="todoCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                        <span class="chat-time">
                                                            <?php if ($comment->last_update == null) : ?>
                                                                Posted At <?= $comment->creation_date ?>
                                                            <?php else : ?>
                                                                Updated At <?= $comment->last_update ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>
                                                    <?php if ($comment->taskfiles) : ?>
                                                        <ul class="attach-list">
                                                            <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                <li><i class="fa fa-file"></i>
                                                                    <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                        <?= $taskfile->filename ?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($comment->replies) : ?>
                                            <?php foreach ($comment->replies as $reply) : ?>



                                                <?php
                                                    preg_match_all($test_patt, $reply->content, $replyemails);
                                                    preg_match_all("/#(\\w+)/", $reply->content, $replytags);

                                                    if (!empty($replyemails)) {
                                                        foreach ($replyemails[0] as $replyemail) {

                                                            foreach ($userData as $data) {
                                                                if ($replyemail == $data->email) {

                                                                    $reply->content = str_replace($replyemail, "<a href='/user/profile/" . $data->id . "'>" . $replyemail . "</a>", $reply->content);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    foreach ($replytags[0] as $hashtag) {
                                                        $pos = strpos($comment->content, $hashtag);
                                                        $str = ltrim($hashtag, '#');

                                                        $link = "/comments/hashtags/$str";

                                                        //echo $hashtag;
                                                        $reply->content = str_replace($hashtag, "<a href=' " . $link . "'>" . $hashtag . "</a>", $reply->content);
                                                    }

                                                    ?>

                                                <div class="form-group row">
                                                    <div class="chat-avatar col-3">
                                                        <a href="profile.html" class="avatar">
                                                            <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                        </a>
                                                    </div>
                                                    <div class="chat-bubble col-9">
                                                        <div class="chat-content" style="width: 80%;">
                                                            <?php if ($reply->user->id == $user_id) : ?>
                                                                <div class="dropdown kanban-action" style="text-align: start;">
                                                                    <a href="" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                    </div>
                                                                </div>
                                                                <span class="task-chat-user">
                                                                    <p id="todoCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>"> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></p>
                                                                </span>

                                                            <?php endif; ?>
                                                            <div>
                                                                <p><?= $reply->content ?></p>
                                                                <span class="chat-time">
                                                                    <?php if ($reply->last_update == null) : ?>
                                                                        Posted At <?= $reply->creation_date ?>
                                                                    <?php else : ?>
                                                                        Updated At <?= $reply->last_update ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                            </div>

                                                            <?php if ($reply->taskfiles) : ?>
                                                                <ul class="attach-list">
                                                                    <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <!--------Right part------------------>
                                <?php else : ?>
                                    <div class="chat chat-right container">
                                        <div class="chat-avatar">
                                            <a href="profile.html" class="avatar">
                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                        <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-bubble">
                                                <div class="chat-content">
                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" onclick="todo_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                            <a class="dropdown-item" onclick="todoeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                            <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                        </div>
                                                    </div>
                                                    <span class="task-chat-user">
                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                <p id="todorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </span>
                                                    <div>
                                                        <p class="commenttasktodo_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="todorightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                        <span class="chat-time" style="align-items: center">
                                                            <?php if ($comment->last_update == null) : ?>
                                                                Posted At <?= $comment->creation_date ?>
                                                            <?php else : ?>
                                                                Updated At <?= $comment->last_update ?>
                                                            <?php endif; ?>
                                                            <?php if ($comment->isSeen == true) : ?>
                                                                <i class="material-icons">check</i>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>

                                                    <?php if ($comment->taskfiles) : ?>
                                                        <ul class="attach-list">
                                                            <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="modal submodal" id="todoedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                    <div class="modal-dialog-centered modal-md" role="dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                <button type="button" class="close" aria-label="Close" onclick="closetodoedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="form-group">
                                                                    <label for="reply">Comment</label>
                                                                    <!--- <textarea type="text" class="form-control" id="content" name="content"><?= $comment->content ?></textarea>---->
                                                                    <div id="content_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary">Close</button>
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                <button type="button" class="btn btn-primary " onclick="updatetodocomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>); return false;">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($comment->replies) : ?>
                                        <?php foreach ($comment->replies as $reply) : ?>
                                            <div class="chat chat-right row">
                                                <div class="chat-bubble col-9">
                                                    <div class="chat-content" style="width: 80%;">
                                                        <?php if ($reply->user_id == $user_id) : ?>
                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" onclick="todoeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                    <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                </div>
                                                            </div>
                                                            <span class="task-chat-user">
                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                    <?php if ($reply->user_id == $singleUser->id) : ?>
                                                                        <p id="todorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <div>
                                                            <p><?= $reply->content ?></p>
                                                            <span class="chat-time" style="text-align:left">
                                                                <?php if ($comment->last_update == null) : ?>
                                                                    Posted At <?= $reply->creation_date ?>
                                                                <?php else : ?>
                                                                    Updated At <?= $reply->last_update ?>
                                                                <?php endif; ?>
                                                                <?php if ($comment->isSeen == true) : ?>
                                                                    <i class="material-icons">check</i>
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                        <?php if ($reply->taskfiles) : ?>
                                                            <ul class="attach-list">
                                                                <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                    <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>

                                                    </div>

                                                </div>
                                                <div class="chat-avatar col-3">
                                                    <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                </div>
                                            </div>
                                            <!---------------------Edit -Reply Modal--------------------------------------------->
                                            <div class="modal submodal" id="todoeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                <div class="modal-dialog-centered modal-md" role="dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                            <button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label for="reply">Reply</label>

                                                                <div id="replycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary">Close</button>
                                                            <button type="button" class="btn btn-primary " onclick="updatetodoReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>


                                <?php endif; ?>

                            </div>
                        <?php else : ?>
                            <div class="todoNewCommentsSection_<?= $task->id ?>" id="todoRemainingComments_<?= $task->id ?>_<?= $comment->id ?>" style="display: none;">

                                <?php if ($comment->user_id != $user_id) : ?>
                                    <div class="chat chat-left container">
                                        <div class="chat-avatar">
                                            <a href="profile.html" class="avatar">
                                                <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-bubble">
                                                <div class="chat-content">
                                                    <div class="dropdown kanban-action" style="text-align: end;transform: translate3d(-5px, 22px, 0px); ">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" onclick="todo_reply_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                                                        </div>
                                                    </div>
                                                    <span class="task-chat-user">
                                                        <p id="todoCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                                                    </span>
                                                    <div>
                                                        <span class="chat-time">
                                                            <?php if ($comment->last_update == null) : ?>
                                                                Posted At <?= $comment->creation_date ?>
                                                            <?php else : ?>
                                                                Updated At <?= $comment->last_update ?>
                                                            <?php endif; ?>
                                                        </span>
                                                        <p id="todoCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                                                    </div>
                                                    <?php if ($comment->taskfiles) : ?>
                                                        <ul class="attach-list">
                                                            <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                <li><i class="fa fa-file"></i>
                                                                    <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>">
                                                                        <?= $taskfile->filename ?>
                                                                    </a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>



                                            </div>
                                        </div>

                                        <?php if ($comment->replies) : ?>
                                            <?php foreach ($comment->replies as $reply) : ?>
                                                <div class="form-group row">

                                                    <div class="chat-avatar col-3">
                                                        <a href="profile.html" class="avatar">
                                                            <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                                                        </a>
                                                    </div>
                                                    <div class="chat-bubble col-9">
                                                        <div class="chat-content" style="width: 80%;">
                                                            <?php if ($reply->user->id == $user_id) : ?>
                                                                <div class="dropdown kanban-action" style="text-align: start;">
                                                                    <a href="" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                                                    </div>
                                                                </div>
                                                                <span class="task-chat-user">
                                                                    <p id="todoCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>"> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></p>
                                                                </span>

                                                            <?php endif; ?>
                                                            <div>
                                                                <p><?= $reply->content ?></p>
                                                                <span class="chat-time">
                                                                    <?php if ($reply->last_update == null) : ?>
                                                                        Posted At <?= $reply->creation_date ?>
                                                                    <?php else : ?>
                                                                        Updated At <?= $reply->last_update ?>
                                                                    <?php endif; ?>
                                                                </span>
                                                            </div>

                                                            <?php if ($reply->taskfiles) : ?>
                                                                <ul class="attach-list">
                                                                    <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                        <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                        <?php endif; ?>



                                    </div>
                                    <!--------Right part------------------>
                                <?php else : ?>
                                    <div class="chat chat-right container">
                                        <div class="chat-avatar">
                                            <a href="profile.html" class="avatar">
                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                    <?php if ($comment->user_id == $singleUser->id) : ?>
                                                        <img alt="" src="<?= $singleUser->profileFilepath ?>/<?= $singleUser->profileFilename ?>">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-bubble">
                                                <div class="chat-content">
                                                    <div class="dropdown kanban-action" style="text-align: start;">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" onclick="todo_replyrightside_comment(<?= $task->id ?>, <?= $projectObject->id ?>, <?= $comment->id ?>)">Reply</a>
                                                            <a class="dropdown-item" onclick="todoeditModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)" class="edit-msg">Edit</a>
                                                            <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                                                        </div>
                                                    </div>
                                                    <span class="task-chat-user">
                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                                                <p id="todorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </span>
                                                    <div>
                                                        <p class="commenttasktodo_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" id="todorightsideCommentContent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>

                                                        <span class="chat-time">
                                                            <?php if ($comment->last_update == null) : ?>
                                                                Posted At <?= $comment->creation_date ?>
                                                            <?php else : ?>
                                                                Updated At <?= $comment->last_update ?>
                                                            <?php endif; ?>
                                                        </span>
                                                    </div>

                                                    <?php if ($comment->taskfiles) : ?>
                                                        <ul class="attach-list">
                                                            <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="modal submodal" id="todoedit_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                                                    <div class="modal-dialog-centered modal-md" role="dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Assign the user to task <?= $task->id ?></h5>
                                                                <button type="button" class="close" aria-label="Close" onclick="closetodoedit(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>)">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div class="form-group">
                                                                    <label for="reply">Comment</label>
                                                                    <!--- <textarea type="text" class="form-control" id="content" name="content"><?= $comment->content ?></textarea>---->
                                                                    <div id="content_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary">Close</button>
                                                                <input type="hidden" name="pid" id="pid" value="<?= $projectObject->id ?>">
                                                                <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                                                <button type="button" class="btn btn-primary " onclick="updatetodocomments(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $comment->id ?>, <?= $user_id ?>); return false;">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($comment->replies) : ?>
                                        <?php foreach ($comment->replies as $reply) : ?>
                                            <div class="chat chat-right row">
                                                <div class="chat-bubble col-9">
                                                    <div class="chat-content" style="width: 80%;">
                                                        <?php if ($reply->user_id == $user_id) : ?>
                                                            <div class="dropdown kanban-action" style="text-align: start;">
                                                                <a href="" data-toggle="dropdown">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" onclick="todoeditReplyModal(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                                                    <a class="dropdown-item" onclick="tododeletecomment(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                                                </div>
                                                            </div>
                                                            <span class="task-chat-user">
                                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                                    <?php if ($reply->user_id == $singleUser->id) : ?>
                                                                        <p id="todorightsideCommentUsername_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        <div>
                                                            <p><?= $reply->content ?></p>
                                                            <span class="chat-time" style="text-align:left">
                                                                <?php if ($comment->last_update == null) : ?>
                                                                    Posted At <?= $reply->creation_date ?>
                                                                <?php else : ?>
                                                                    Updated At <?= $reply->last_update ?>
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                        <?php if ($reply->taskfiles) : ?>
                                                            <ul class="attach-list">
                                                                <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                                                    <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>

                                                    </div>

                                                </div>
                                                <div class="chat-avatar col-3">
                                                    <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                                                </div>
                                            </div>
                                            <!---------------------Edit -Reply Modal--------------------------------------------->
                                            <div class="modal submodal" id="todoeditReply_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                                                <div class="modal-dialog-centered modal-md" role="dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Assign the user to task <?= $task->id ?><?= $reply->id ?></h5>
                                                            <button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>)">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label for="reply">Reply</label>

                                                                <div id="replycontent_<?= $task->id ?>_<?= $projectObject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary">Close</button>
                                                            <button type="button" class="btn btn-primary " onclick="updatetodoReply(<?= $task->id ?>,<?= $projectObject->id ?>,<?= $reply->id ?>, <?= $user_id ?>); return false;">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>


                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            </br>
            <hr size="30">
            </br>
        <?php endforeach; ?>

    </div>
</div>



<!-- /Page Wrapper -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    function displaytaskcomments(id) {
        var input, filter, a, i, txtValue;
        input = $('#selecttask').val();
        filter = input.toUpperCase();
        for (i = 0; i < id; i++) {
            var myrow = document.getElementById('myrow_' + i);
            var mycard = document.getElementById('mycard_' + i);
            var txt = myrow.getElementsByTagName('a')[0].innerText;
            if (txt) {
                if (txt.toUpperCase().includes(filter)) {
                    mycard.style.display = "";
                } else {
                    mycard.style.display = "none";
                }
            }
        }
    }

    function myfunction(total) {
        var input, filter, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        for (i = 0; i < total; i++) {
            var myrow = document.getElementById('myrow_' + i);
            var mycard = document.getElementById('mycard_' + i);
            var txt = myrow.getElementsByTagName('a')[0].innerText;
            if (txt) {
                if (txt.toUpperCase().includes(filter)) {
                    mycard.style.display = "";
                } else {
                    mycard.style.display = "none";
                }
            }
        }
    }
    //Updatecomments
    function updatecomments(pid, commentId, taskId) {
        $.ajax({
            url: '/comments/updatecomment',
            method: 'post',
            dataType: 'json',
            data: {
                'content': $('#content').text(),
                'pid': pid,
                'commentId': commentId,
                'taskId': taskId,
            },
            success: function(data) {},
            error: function() {}
        });
        var frame;
        setInterval(function() {
            frame = someSortOf.Code();
        });
    }

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };
    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });
</script>
