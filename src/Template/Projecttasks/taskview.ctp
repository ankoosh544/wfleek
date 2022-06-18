<style>
    .replyleftside {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .leftreply-chatcontent {
        width: 80%;
        border: 1px solid #e3e3e3;
        padding: 15px;
    }
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-4 message-view task-view">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="float-left ticket-view-details">
                                <div class="ticket-header">
                                    <span>Status: </span> <span class="badge badge-warning">
                                        <?php if ($projecttask->status == 'T') : ?>ToDo
                                        <?php elseif ($projecttask->status == 'I') : ?>InProgress
                                        <?php else : ?>Completed<?php endif; ?>
                                    </span>
                                    <span class="m-l-15 text-muted">Start Date: </span>
                                    <span><?= $projecttask->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?> </span>
                                    <span class="m-l-15 text-muted">Expiry Date: </span>
                                    <span><?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?> </span>
                                    <?php
                                    $diff = abs(strtotime($projecttask->expiration_date) - strtotime($projecttask->startdate));
                                    $years = floor($diff / (365 * 60 * 60 * 24));
                                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                    $totaldays = $days;
                                    ?>

                                    <span class="m-l-15 text-muted">Duration Days: </span>
                                    <span><?= $totaldays ?> </span>
                                    <span class="m-l-15 text-muted">Created by:</span>
                                    <span><a href="profile.html"><?= $projecttask->createduser->firstname ?> <?= $projecttask->createduser->lastname ?></a></span>
                                </div>
                            </div>
                            <a class="task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i class="fa fa fa-comment"></i></a>
                        </div>
                    </div>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="task-wrapper">
                                        <div class="task-list-container">

                                            <ul id="task-list">
                                                <div class="container">
                                                    <form method="post" action="/projecttasks/updatetask" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label for="name"><?= __('Task title') ?></label>
                                                            <input class="form-control" type="text" name="name" value="<?= $projecttask->title ?>">
                                                        </div>
                                                        <div class="form-group form-focus select-focus">
                                                            <label for="type"><?= __('Select Group') ?></label>
                                                            <select class="select floating" id="edittasktsgrouptype_<?= $projecttask->id ?>" name="type">
                                                                <?php foreach ($manyObject as $object) : ?>
                                                                    <?php if ($projecttask->id === $object->projecttask_id) : ?>
                                                                        <?php foreach ($taskgroups as $group) : ?>
                                                                            <?php if ($object->taskgroup_id == $group->id) : ?>

                                                                                <option selected value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        </br>
                                                        <div class="form-group">
                                                            <label for="startdate"><?= __('Start Date') ?></label>
                                                            <input type="text" name="startdate" id="editstartdateTodo_<?= $projecttask->id ?>" class="datetimepicker tododatetimepicker form-control" value="<?= $projecttask->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                            <span class="text-danger" id="errorstartdateMsg_<?= $projecttask->id ?>"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="expirydate"><?= __('Expire Date') ?></label>
                                                            <input type="text" name="expirydate" id="editexpirydateTodo_<?= $projecttask->id ?>" class="datetimepicker todoexpirydatetimepicker form-control" value="<?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>" placeholder="dd/mm/yyyy" />
                                                            <span class="text-danger" id="errorexpirydateMsg_<?= $projecttask->id ?>"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price"><?= __('Price') ?></label>
                                                            <input class="form-control" type="number" name="price" id="price" value="<?= $projecttask->price ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tax"><?= __('Tax') ?></label>
                                                            <input class="form-control" type="number" name="tax" id="tax" value="<?= $projecttask->tax_percentage ?>">
                                                        </div>
                                                        <div class="form-group form-focus select-focus">
                                                            <label for="priority"><?= __('Priority ') ?></label><span class="text-success" id="successDiv_<?= $projecttask->id ?>"></span>
                                                            <select class="select floating" id="taskStatus" name="priority">
                                                                <?php if ($projecttask->priority == 'H') : ?>
                                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger" selected>High</option>
                                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                                <?php elseif ($projecttask->priority == 'M') : ?>
                                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning" selected>Medium</option>
                                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                                <?php else : ?>
                                                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                                    <option value="L" data-icon="fa fa-dot-circle-o text-success" selected>Low</option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        </br>
                                                        <?php if ($projecttask->isEpic == true) : ?>
                                                            <div class=form-group>
                                                                <label for="subtasks">Link/UnLink Sub-Tasks</label>
                                                                <div id="linksforsubtask_<?= $projecttask->id ?>">
                                                                    <?php if ($projecttask->epictasks_projecttasks) : ?>
                                                                        <?php foreach ($projecttask->epictasks_projecttasks as $epic) : ?>
                                                                            <li>
                                                                                <a href=""> <?= $epic->projecttask->title ?></a>
                                                                                <span class="action-circle large delete-btn" title="Delete Task">
                                                                                    <a onclick="deletesubtask(<?= $projecttask->id ?>,<?= $epic->projecttask->id ?>)" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                </span>
                                                                            </li>

                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <select id="tasks" class="select floating" name="epic_tasks[]" multiple>
                                                                    <?php foreach ($projecttasks as $singletask) : ?>
                                                                        <?php if ($singletask->id != $projecttask->id && empty($singletask->subtasks)) : ?>
                                                                            <option value="<?= $singletask->id ?>"><?= $singletask->title ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        <?php else : ?>
                                                            <?php if (!empty($projecttask->subtasks)) : ?>
                                                                <div class="form-group">
                                                                    <label>Linked Epic Task </label>
                                                                    <div id="epictasks_<?= $projecttask->id ?>">
                                                                        <?php foreach ($projecttask->subtasks as $subtask) : ?>
                                                                            <li>
                                                                                <a href=""> <?= $subtask->epictask->title ?></a>
                                                                                <span class="action-circle large delete-btn" title="Delete Task">
                                                                                    <a onclick="unlinktoepic(<?= $projecttask->id ?>,<?= $subtask->epictask->id ?>)" class="del-msg"><i class="material-icons">delete</i></a>
                                                                                </span>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                    </br>
                                                                    <div class="form-group form-focus select-focus" id="epicblock_<?= $projecttask->id ?>" style="display:none">
                                                                        <label for="tasks"><?= __('Add Tasks to Epic Task') ?><span class="text-danger">*</span></label>
                                                                        <select id="tasks" class="select floating" name="epic_task">
                                                                            <?php foreach ($epictasks as $epictask) : ?>
                                                                                <option value="<?= $epictask->id ?>"><?= $epictask->title ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            <?php else : ?>
                                                                <div class="form-group form-focus select-focus" id="epicblock_<?= $projecttask->id ?>">
                                                                    <label for="tasks"><?= __('Add Tasks to Epic Task') ?><span class="text-danger">*</span></label>
                                                                    <select id="tasks" class="select floating" name="epic_task">
                                                                        <?php foreach ($epictasks as $epictask) : ?>
                                                                            <option value="<?= $epictask->id ?>"><?= $epictask->title ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        </br>
                                                        <div class="form-group">
                                                            <label for="description"><?= __('Description') ?></label>
                                                            <textarea name="description" id="description" type="text" class="form-control btn-mod-input height10 summernote"><?= $projecttask->description ?></textarea>
                                                        </div>
                                                        </br>

                                                        <input type="hidden" name="id" id="id" value="<?= $projecttask->id ?>">
                                                        <input type="hidden" name="pid" id="pid" value="<?= $projecttask->projectobject->id ?>">
                                                        <button type="submit" class=" btn btn-info" name="update" value="Update">Update</button>

                                                    </form>
                                                </div>
                                            </ul>
                                            <div class="task-list-footer">
                                                <div class="new-task-wrapper">
                                                    <textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
                                                    <span class="error-message hidden">You need to enter a task first</span>
                                                    <span class="add-new-task-btn btn" id="add-task">Add Task</span>
                                                    <span class="btn" id="close-task-panel">Close</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-popup hide">
                                        <p>
                                            <span class="task"></span>
                                            <span class="notification-text"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 message-view task-chat-view task-right-sidebar" id="task_window">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="form-group form-focus select-focus task-assign">
                                <select class="select floating" id="taskStatus_<?= $projecttask->id ?>" onchange="changestatusoftask(<?= $projecttask->id ?>)">
                                    <?php if ($projecttask->status == 'T') : ?>
                                        <option selected value="T"> Todo </option>
                                        <option value="I">In-Progress</option>
                                        <option value="D">Complete</option>
                                    <?php elseif ($projecttask->status == 'I') : ?>
                                        <option value="T"> Todo </option>
                                        <option selected value="I">In-Progress</option>
                                        <option value="D">Complete</option>
                                    <?php else : ?>
                                        <option value="T"> Todo </option>
                                        <option value="I">In-Progress</option>
                                        <option selected value="D">Complete</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <a class="btn btn-info" href="/projecttasks/newticket?taskId=<?= $projecttask->id ?>">Create Ticket</a>
                            <ul class="nav float-right custom-menu">
                                <li class="dropdown dropdown-action">
                                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="javascript:void(0)">Delete Task</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats">
                                        <h4><?= $projecttask->title ?></h4>
                                        <div class="task-header">
                                            <div class="assignee-info" id="todoassigneeinfo_<?= $projecttask->id ?>">
                                                <?php if (!empty($projecttask->taskusers)) : ?>
                                                    <?php foreach ($projecttask->taskusers as $taskuser) : ?>
                                                        <span class="remove-icon" onclick="tododeletetaskuser(<?= $projecttask->id ?>, <?= $projecttask->projectobject->id ?>, <?= $taskuser->user->id ?>)">
                                                            <a class="del-msg" data-toggle="modal" data-target="#delete_alltaskuser_<?= $projecttask->id ?>"><i class="fa fa-close"></i></a>
                                                        </span>
                                                        <a href="#" data-toggle="modal" data-target="#update_taskusers_<?= $projecttask->id ?>">
                                                            <div class="avatar">
                                                                <?php if ($taskuser->user->profileFilepath != null && $taskuser->user->profileFilename != null) : ?>
                                                                    <img alt="" src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>">
                                                                <?php else : ?>
                                                                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="assigned-info">
                                                                <div class="task-head-title">Assigned To</div>
                                                                <div class="task-assignee"><?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?></div>
                                                            </div>
                                                        </a>
                                                    <?php endforeach; ?>

                                                <?php else : ?>
                                                    <span class="remove-icon">
                                                        <a class="del-msg"><i class="fa fa-close"></i></a>
                                                    </span>
                                                    <a href="#" data-toggle="modal" data-target="#update_taskusers_<?= $projecttask->id ?>">
                                                        <div class="avatar">
                                                            <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                        </div>
                                                        <div class="assigned-info">
                                                            <div class="task-head-title">Click to Assign</div>
                                                        </div>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="task-due-date">
                                                <a href="#" data-toggle="modal" data-target="#update-duedate_<?= $projecttask->id ?>">
                                                    <div class="due-icon">
                                                        <span>
                                                            <i class="material-icons">date_range</i>
                                                        </span>
                                                    </div>
                                                    <div class="due-info">
                                                        <div class="task-head-title">Due Date</div>
                                                        <div class="due-date"><?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></div>
                                                    </div>
                                                </a>
                                                <span class="remove-icon">
                                                    <i class="fa fa-close"></i>
                                                </span>
                                            </div>
                                            <!-------------------------->

                                            <?= $this->element('modify_duedate', [
                                                'projecttask' => $projecttask,

                                            ]) ?>
                                            <!----------------------------->

                                            <!-------------------------->

                                            <?= $this->element('update_taskusers', [
                                                'projecttask' => $projecttask,

                                            ]) ?>
                                            <!----------------------------->

                                            <!--------------------Delete All taskusers------------------------->

                                            <?= $this->element('delete_alltaskusers', [
                                                'projecttask' => $projecttask,

                                            ]) ?>
                                            <!-------------------/Delete All taskusers-------------------------------->


                                        </div>
                                        <hr class="task-line">
                                        <div class="task-desc">
                                            <div class="task-desc-icon">
                                                <i class="material-icons">subject</i>
                                            </div>
                                            <div class="task-textarea">
                                                <textarea class="form-control summernote"><?= $projecttask->description ?></textarea>
                                            </div>
                                        </div>
                                        <hr class="task-line">
                                        <div class="task-information">
                                            <span class="task-info-line"><a class="task-user" href="#"><?= $projecttask->createduser->firstname ?> <?= $projecttask->createduser->lastname ?></a> <span class="task-info-subject">created task</span></span>
                                            <div class="task-time"><?= $projecttask->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?></div>
                                        </div>

                                        <?php foreach ($projecttask->taskusers as $taskuser) : ?>
                                            <div class="task-information">
                                                <span class="task-info-line"><a class="task-user" href="#"><?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?></a> <span class="task-info-subject">added to <?= $projecttask->title ?></span></span>
                                                <div class="task-time"><?= $taskuser->assigned_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?></div>
                                            </div>
                                        <?php endforeach; ?>


                                        <?php if (!empty($projecttask->task_comments)) : ?>
                                            <div id="ajaxmessages_<?= $projecttask->id ?>">
                                                </br>
                                                <a class="btn btn-info" style="font-size: 12px;" onclick=" showComments(<?= $projecttask->id ?>,<?= $user_id ?>); return false;" id="todoviewcomments_<?= $projecttask->id ?>">View all Comments</a>


                                                <?php foreach ($projecttask->task_comments as $index => $comment) : ?>


                                                    <!----New and top3 Comment--->
                                                    <?php if ($comment->comment_id == null && $index >= (count($projecttask->task_comments) - 3)) : ?>
                                                        <div class="todoNewCommentsSection_<?= $projecttask->id ?>" id="todoNewComments_<?= $projecttask->id ?>_<?= $comment->id ?>">

                                                            <?= $this->element('comment_section', [
                                                                'projecttask' => $projecttask,
                                                                'comment' => $comment

                                                            ]) ?>

                                                        </div>
                                                    <?php else : ?>
                                                        <div class="todoNewCommentsSection_<?= $projecttask->id ?>" id="todoRemainingComments_<?= $projecttask->id ?>_<?= $comment->id ?>" style="display: none;">
                                                            <?= $this->element('comment_section', [
                                                                'projecttask' => $projecttask,
                                                                'comment' => $comment
                                                            ]) ?>

                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>

                                            </div>
                                        <?php else : ?>
                                            <div id="ajaxmessages_<?= $projecttask->id ?>">
                                                </br>
                                                <a class="btn btn-info" style="font-size: 12px;" onclick=" showComments(<?= $projecttask->id ?>,<?= $user_id ?>); return false;" id="todoviewcomments_<?= $projecttask->id ?>">View all Comments</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="message-bar">
                            <div class="message-inner">
                                <div class="file-options" id="uploadfileoption">
                                    <span class="btn-file">
                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="todoimages_<?= $projecttask->id ?>" name="images" type="file" multiple />
                                        <img src="/assets/img/attachment.png" alt="">
                                    </span>
                                </div>
                                <div class="message-area">
                                    <div id="chatBubble_<?= $projecttask->id ?>" style="height: 60px;"">

                                    </div>
                                    <div class="input-group">
                                        <textarea class="form-control" type="text" onkeypress="onEnter(event,<?= $projecttask->projectobject->id ?>, <?= $projecttask->id ?>, <?= $user_id ?>)" id="textcontent_<?= $projecttask->id ?>" placeholder="Type message..."></textarea>
                                        <span class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="submitMessage(<?= $projecttask->projectobject->id ?>, <?= $projecttask->id ?>, <?= $user_id ?>);return false;"><i class="fa fa-send"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--------Task followers-------------------------------------------------->
                        <div class="project-members task-followers">
                            <span class="followers-title">Followers</span>
                            <div id="todotask_followersinfo_<?= $projecttask->id ?>">
                                <?php foreach ($projecttask->followers as $follower) : ?>
                                    <span class="remove-icon" onclick="tododeletefollower(<?= $projecttask->id ?>, <?= $projecttask->projectobject->id ?>, <?= $follower->user->id ?>)">
                                        <a class="del-msg"><i class="fa fa-close"></i></a>
                                    </span>
                                    <a class="avatar" href="#" data-toggle="tooltip" title="<?= $follower->user->firstname ?> <?= $follower->user->lastname ?>">
                                        <img alt="" src="<?= $follower->user->profileFilepath ?>/<?= $follower->user->profileFilename ?>">
                                    </a>
                                <?php endforeach; ?>
                            </div>

                            <a href="#" data-toggle="modal" data-target="#task_followers_<?= $projecttask->id ?>" class="followers-add"><i class="material-icons">add</i></a>
                        </div>

                        <!--------------Modal for Task followers----------------------->

                        <?= $this->element('add_taskfollowers', [
                            'projecttask' => $projecttask,

                        ]) ?>

                        <!--------------/Modal for Task followers------------------------->



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Wrapper -->
<script>
    function onEnter(e, pid, tid, auth) {
        console.log(e.which, 'enter key');
        if (e.which === 13) {
            e.preventDefault();
            submitMessage(pid, tid, auth);
        }
    }


    var replay = 0;

    function submitMessage(pid, tid, auth) {

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
                console.log(data);
                renderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
                $("#todoimages_" + tid).replaceWith($("#todoimages_" + tid).val('').clone(true));
            },
            error: function() {

            }
        });
    }

    function renderComments(data, auth, tid, text) {
        console.log(auth, 'userid', tid, 'taskid', text)
        console.log(data, 'inrenderfun');

        $('#textcontent_' + tid).empty();
        $('#ajaxmessages_' + tid).empty();
        var commentsHtml = "";


        commentsHtml += ' <a style="font-size: 12px;" class="btn btn-info" onclick=" showComments(' + tid + ',' + auth + '); return false;" id="todoviewcomments_' + tid + '">' + text + '</a>';
        data.forEach((comment, index) => {
            var isSeen = comment.isSeen == true ? '<i class="material-icons">check</i>' : '';
            if (index >= (data.length - 3)) {
                commentsHtml += '<div class="todoNewCommentsSection_' + comment.taskId + '">';
                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +

                        '<div class="dropdown kanban-action" style="text-align: end;">' +
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
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + '</span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                    }

                    commentsHtml += '<p class="commenttasktodo_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="todorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
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
                                commentsHtml += '<div class="dropdown kanban-action" style="text-align: end;">' +
                                    '<a href="" data-toggle="dropdown">' +
                                    '<i class="fa fa-ellipsis-v"></i>' +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-right">' +
                                    '<a class="dropdown-item" href="#" onclick="todoeditReplyModal(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ')" class="edit-msg"><i class="fa fa-pencil"></i>Edit</a>' +
                                    '<a class="dropdown-item" onclick="tododeletecomment(' + reply.taskId + ',' + reply.project_id + ',' + reply.id + ',' + auth + ')"> <i class="fa fa-trash-o"></i>Delete</a>' +
                                    '</div>' +
                                    '</div>';
                            }


                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
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
                                '<div class="chat-avatar col-3" >' +
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

                    commentsHtml += '<div class="chat chat-left container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +

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
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
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
                            commentsHtml += '<div class="chat chat-left row replyleftside">' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style=" width: 80%;border: 1px solid #e3e3e3;padding: 15px;">';
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

                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                            }

                            commentsHtml += '<p>' + reply.content + '</p>';
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
                commentsHtml += '<div class="todoNewCommentsSection_' + comment.taskId + '"  style="display:' + display + ';">';

                if (comment.user_id == auth) {
                    commentsHtml += '<div class="chat chat-right container">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + comment.user.profileFilepath + '/' + comment.user.profileFilename + ' ">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="comment-content">' +
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
                    if (comment.last_update == null) {
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                    }
                    commentsHtml += '<p class="commenttasktodo_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '" id="todorightsideCommentContent_' + comment.taskId + '_' + comment.project_id + '_' + comment.id + '">' + comment.content + '</p>' +
                        '<ul class="attach-list">';
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
                                    '</div>';
                            }


                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
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
                                '<div class="chat-avatar col-3" >' +
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
                        '<div class="comment-content">' +
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
                        commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';

                    } else {
                        commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';

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
                            commentsHtml += '<div class="chat chat-left row replyleftside">' +
                                '<div class="chat-avatar col-3" >' +
                                '<a href="profile.html" class="avatar">' +
                                '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + ' ">' +
                                '</a>' +
                                '</div>' +
                                '<div class="chat-bubble col-9">' +
                                '<div class="chat-content" style=" width: 80%;border: 1px solid #e3e3e3;padding: 15px;">';
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
                            if (reply.last_update == null) {
                                commentsHtml += '<span class="chat-time">' + 'Posted At ' + comment.creation_date + '' + isSeen + ' </span>';
                            } else {
                                commentsHtml += '<span class="chat-time">' + 'Updated At ' + comment.creation_date + '' + isSeen + ' </span>';
                            }
                            commentsHtml += '<p>' + reply.content + '</p>';
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
            }
        });
        $('#ajaxmessages_' + tid).html(commentsHtml);

    }
    var commentvalue = false;

    function showComments(tid, auth) {
        commentvalue = !commentvalue;
        if ($('#todoviewcomments_' + tid).text() == 'View all Comments') {
            $('#todoviewcomments_' + tid).text('Hide');
        } else {
            $('#todoviewcomments_' + tid).text('View all Comments');
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
                renderComments(data, auth, tid, $('#todoviewcomments_' + tid).text());
            },
            error: function() {}
        });
    }

    function updatepriorityTodo(taskId) {
        var priority = $('#task_prority').val();
        $.ajax({
            url: '/projecttasks/updatepriority',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'priority': priority
            },
            success: function(data) {
                if (data != null) {
                    window.location = '/projecttasks/view/' + taskId
                }
            },
            error: function() {}
        })
    }

    function deletesubtask(taskId, subtaskid) {
        $.ajax({
            url: '/projecttasks/deletesubtask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'subtaskid': subtaskid
            },
            success: function(data) {
                $('#linksforsubtask_' + taskId).empty();
                var str = "";

                if (data.epictasks_projecttasks) {
                    data.epictasks_projecttasks.forEach((epic) => {

                        str += '<li>' +
                            '<a href=""> ' + epic.projecttask.title + '</a>' +
                            '<span class="action-circle large delete-btn" title="Delete Task">' +
                            '<a onclick="deletesubtask(' + taskId + ',' + epic.projecttask.id + ')" class="del-msg"><i class="material-icons">delete</i></a>' +
                            '</span>' +
                            '</li>';

                    });
                    $('#linksforsubtask_' + taskId).html(str);

                }
            },
            error: function() {}
        })

    }

    function unlinktoepic(taskId, epictaskid) {
        $.ajax({
            url: '/projecttasks/unlinktoepic',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId,
                'epictaskid': epictaskid
            },
            success: function(data) {
                $('#epictasks_' + taskId).empty();
                $('#epicblock_' + taskId).show();
            },
            error: function() {}
        })

    }

    function changestatusoftask(taskId) {
        var status = $('#taskStatus_' + taskId).val();
        $.ajax({
            url: '/projecttasks/changestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': status,
            },
            success: function(data) {
                location.reload();

            },
            error: function() {

            }
        })

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
        $("#chatBubble_" + tid).append('<div class="form-group" style="width:100%" id="todoreplayDiv_' + tid + '_' + pid + '_' + cid + '"><p id="todoreplayrightsidePara_' + tid + '_' + pid + '_' + cid + '"></p>' + str + '' + closebutton + '</div>');
        $('#todoreplayrightsidePara_' + tid + '_' + pid + '_' + cid).html($('#todorightsideCommentContent_' + tid + '_' + pid + '_' + cid + '').text());
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
                renderComments(data, auth, tid, $('#viewallcomments').text());
            },
            error: function() {}
        });
    }

    function todoeditReplyModal(tid, pid, rid) {
        $('#todoeditReply_' + tid + '_' + pid + '_' + rid).show();
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
                renderComments(data, auth, tid, $('#viewallcomments').text());
                $('#todoeditReply_' + tid + '_' + pid + '_' + rid).modal('hide');
            },
            error: function() {}
        });
    }

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

    function closetodoeditreply(tid, pid, rid) {
        $('#todoeditReply_' + tid + '_' + pid + '_' + rid).hide();
    }
</script>
