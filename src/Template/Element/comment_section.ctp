
<?php if ($comment->user_id != $user_id) : ?>
    <div class="chat chat-left container">
        <div class="chat-avatar">
            <a href="/user/view/<?= $comment->user->id ?>" class="avatar">
                <?php if ($comment->user->profileFilepath != null && $comment->user->profileFilename != null) : ?>
                    <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                <?php else : ?>
                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                <?php endif; ?>
            </a>
        </div>
        <div class="chat-body">
            <div class="chat-bubble">
                <div class="comment-content">
                    <div class="dropdown kanban-action" style="float: right;transform: translate3d(-50px, 22px, 0px); ">
                        <a href="" data-toggle="dropdown">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="todo_reply_comment(<?= $projecttask->id ?>, <?= $projecttask->projectobject->id ?>, <?= $comment->id ?>)" data-toggle="modal" data-target="#replaymodal"><span class="iconify" data-icon="ic:baseline-replay"></span>Reply</a>
                        </div>
                    </div>
                    <span class="task-chat-user">
                        <p id="todoCommentUsername_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>"> <?= $comment->user->firstname ?> <?= $comment->user->lastname ?></p>
                    </span>

                    <span class="chat-time">
                        <?php if ($comment->last_update == null) : ?>
                            Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                        <?php else : ?>
                            Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                        <?php endif; ?>
                        <?php if ($comment->isSeen == true) : ?>
                            <i class="material-icons">check</i>
                        <?php endif; ?>

                    </span>
                    <p id="todoCommentContent_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
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
                <div class="chat chat-left row replyleftside">
                    <div class="chat-avatar col-3">
                        <a href="/user/view/<?= $reply->user->id ?>" class="avatar">
                            <?php if ($reply->user->profileFilepath != null && $reply->user->profileFilename != null) : ?>
                                <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>">
                            <?php else : ?>
                                <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="chat-bubble col-9">
                        <div class="chat-content" style=" width: 80%;border: 1px solid #e3e3e3;padding: 15px;">
                            <?php if ($reply->user->id == $user_id) : ?>
                                <div class="dropdown kanban-action" style="float: right;">
                                    <a href="" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" onclick="tododeletecomment(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)"></i>Delete</a>

                                    </div>
                                </div>
                            <?php endif; ?>
                            <span class="chat-time">
                                <?php if ($reply->last_update == null) : ?>
                                    Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                <?php else : ?>
                                    Updated At <?= $reply->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                                <?php endif; ?>
                                <?php if ($reply->isSeen == true) : ?>
                                    <i class="material-icons">check</i>
                                <?php endif; ?>
                            </span>
                            <p><?= $reply->content ?></p>
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
            <a href="/user/view/<?= $comment->user->id ?>" class="avatar">
                <?php if ($comment->user->profileFilepath != null && $comment->user->profileFilename != null) : ?>
                    <img alt="" src="<?= $comment->user->profileFilepath ?>/<?= $comment->user->profileFilename ?>">
                <?php else : ?>
                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                <?php endif; ?>
            </a>
        </div>
        <div class="chat-body">
            <div class="chat-bubble">
                <div class="comment-content">
                    <div class="dropdown kanban-action" style="float: right;">
                        <a href="" data-toggle="dropdown">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="todo_replyrightside_comment(<?= $projecttask->id ?>, <?= $projecttask->projectobject->id ?>, <?= $comment->id ?>)">Reply</a>
                            <a class="dropdown-item" data-toggle="modal" data-target="#taskmessage_<?= $comment->id ?>">Edit</a>
                            <a class="dropdown-item" onclick="tododeletecomment(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Delete</a>

                        </div>
                    </div>
                    <!--Edit Comment----->

                    <?= $this->element('edit_taskmessage', [
                        'comment' => $comment,
                        'user_id' => $user_id

                    ])
                    ?>
                    <!----------/Edit Comment---->
                    <span class="task-chat-user">
                        <?php foreach ($allUsers as $singleUser) : ?>
                            <?php if ($comment->user_id == $singleUser->id) : ?>
                                <p id="todorightsideCommentUsername_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </span>
                    <span class="chat-time">
                        <?php if ($comment->last_update == null) : ?>
                            Posted At <?= $comment->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                        <?php else : ?>
                            Updated At <?= $comment->last_update->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                        <?php endif; ?>
                        <?php if ($comment->isSeen == true) : ?>
                            <i class="material-icons">check</i>
                        <?php endif; ?>
                    </span>
                    <p class="commenttasktodo_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>" id="todorightsideCommentContent_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>"><?= $comment->content ?></p>
                    <?php if ($comment->taskfiles) : ?>
                        <ul class="attach-list">
                            <?php foreach ($comment->taskfiles as $taskfile) : ?>
                                <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>


                <div class="modal submodal" id="todoedit_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>" style="display: none;left:25%">
                    <div class="modal-dialog-centered modal-md" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Assign the user to task <?= $projecttask->id ?></h5>
                                <button type="button" class="close" aria-label="Close" onclick="closetodoedit(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $comment->id ?>)">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="reply">Comment</label>
                                    <div id="content_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $comment->id ?>" class="form-control" contenteditable="true"><?= $comment->content ?></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary">Close</button>
                                <input type="hidden" name="pid" id="pid" value="<?= $projecttask->projectobject->id ?>">
                                <input type="hidden" name="commentId" id="commentId" value="<?= $comment->id ?>">
                                <button type="button" class="btn btn-primary " onclick="updatetodocomments(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $comment->id ?>, <?= $user_id ?>)">Update</button>
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
                            <div class="dropdown kanban-action" style="text-align: end;">
                                <a href="" data-toggle="dropdown">
                                    <i class="fa fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="todoeditReplyModal(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $reply->id ?>)" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>
                                    <a class="dropdown-item" onclick="tododeletecomment(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Delete</a>
                                </div>
                            </div>
                        <?php endif; ?>


                        <span class="chat-time" style="text-align:left">
                            <?php if ($comment->last_update == null) : ?>
                                Posted At <?= $reply->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?>
                            <?php else : ?>
                                Updated At <?= $reply->last_update ?>
                            <?php endif; ?>
                        </span>

                        <p><?= $reply->content ?></p>
                        <?php if ($reply->taskfiles) : ?>
                            <ul class="attach-list">
                                <?php foreach ($reply->taskfiles as $taskfile) : ?>
                                    <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $taskfile->id ?>"><?= $taskfile->filename ?></a></li>
                                <?php endforeach; ?>
                                <?php if ($reply->isSeen == true) : ?>
                                    <i class="material-icons">check</i>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                    </div>

                </div>
                <div class="chat-avatar col-3">
                    <a href="profile.html" class="avatar"><img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>"></a><span> <?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>
                </div>
            </div>
            <!---------------------Edit -Reply Modal--------------------------------------------->
            <div class="modal submodal" id="todoeditReply_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $reply->id ?>" style="display: none;left:25%">
                <div class="modal-dialog-centered modal-md" role="dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign the user to task <?= $projecttask->id ?><?= $reply->id ?></h5>
                            <button type="button" class="close" aria-label="Close" onclick="closetodoeditreply(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $reply->id ?>)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="reply">Reply</label>

                                <div id="replycontent_<?= $projecttask->id ?>_<?= $projecttask->projectobject->id ?>_<?= $reply->id ?>" class="form-control" contenteditable="true"><?= $reply->content ?></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary">Close</button>
                            <button type="button" class="btn btn-primary " onclick="updatetodoReply(<?= $projecttask->id ?>,<?= $projecttask->projectobject->id ?>,<?= $reply->id ?>, <?= $user_id ?>)">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
