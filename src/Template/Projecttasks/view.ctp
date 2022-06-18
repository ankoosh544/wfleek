<?php

use Cake\I18n\Number;

?>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="chat-main-row">
        <div class="chat-main-wrapper">
            <div class="col-lg-8 message-view task-view">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="float-left ticket-view-details">
                                <div class="ticket-header">
                                    <span>Status: </span> <span class="badge badge-warning">
                                        <?php if ($projecttask->status == 'T') : ?> New(To Do)
                                        <?php elseif ($projecttask->status == 'I') : ?> In-Progress
                                        <?php else : ?> Completed
                                        <?php endif; ?>

                                    </span>
                                    <span class="m-l-15 text-muted">Start Date: </span>
                                    <span><?= $projecttask->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?> </span>
                                    <span class="m-l-15 text-muted">Expiry Date: </span>
                                    <?php if($projecttask->expiration_date != null): ?>
                                    <span><?= $projecttask->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?> </span>
                                    <?php endif ; ?>
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
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="project-title">
                                                    <div class="m-b-20">
                                                        <span class="h5 card-title "><?= $projecttask->title ?></span>
                                                        <div class="float-right ticket-priority"><span>Priority:</span>
                                                            <select class="select2-icon floating" onchange="updatepriority(<?= $projecttask->id ?>)" id="task_prority">
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
                                                    </div>
                                                </div>
                                                <p><?= $projecttask->description ?>. </p>

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
            <div class="col-lg-4 message-view task-chat-view ticket-chat-view" id="task_window">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="task-assign">
                                <span class="assign-title">Assigned to </span>
                                <?php foreach ($taskusers as $taskuser) : ?>
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?= $taskuser->user->firstname ?> <?= $taskuser->user->lastname ?>" class="avatar">
                                        <?php if ($taskuser->user->profileFilepath != null && $taskuser->user->profileFilename != null) : ?>
                                            <img src="<?= $taskuser->user->profileFilepath ?>/<?= $taskuser->user->profileFilename ?>" alt="">
                                        <?php else : ?>
                                            <img src="/assets/img/profiles/avatar-02.jpg" alt="">
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                                <!--  <a href="#" class="followers-add" title="Add Assignee" data-toggle="modal" data-target="#assignee"><i class="material-icons">add</i></a> -->
                            </div>
                            <ul class="nav float-right custom-menu">
                                <li class="nav-item dropdown dropdown-action">
                                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_ticket">Edit Ticket</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_ticket">Delete Ticket</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents task-chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="card-body">
                                    <h5 class="card-title m-b-20">Uploaded files</h5>
                                    <ul class="files-list">
                                        <?php foreach ($taskfiles as $file) : ?>

                                            <?php
                                            $path = $file->filename;
                                            $ext  = (new SplFileInfo($path))->getExtension();

                                            ?>
                                            <li>
                                                <div class="files-cont">
                                                    <div class="file-type">
                                                        <?php if ($ext == 'pdf') : ?>
                                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                        <?php elseif ($ext == 'word') : ?>
                                                            <span class="files-icon"><i class="fa fa-file-word-o"></i></span>
                                                        <?php elseif ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp') : ?>
                                                            <span class="files-icon"><i class="fa fa-image"></i></span>
                                                        <?php else : ?>
                                                            <span class="files-icon"><i class="fa fa-file"></i></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="files-info">
                                                        <span class="file-name text-ellipsis"><a href="#"><?= $file->filename ?></a></span>
                                                        <span class="file-author"><a href="#"><?= $file->user->firstname ?> <?= $file->user->lastname ?></a></span> <span class="file-date"><?= $file->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?></span>

                                                        <div class="file-size">Size: <?= str_replace('.', ',', Number::toReadableSize($file->size)) ?></div>
                                                    </div>
                                                    <ul class="files-action">
                                                        <li class="dropdown dropdown-action">
                                                            <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="/taskfiles/downloadtaskfile/<?= $file->id ?>">Download</a>
                                                                <a class="dropdown-item" href="/projectemail/composeEmail?fileid=<?= $file->id ?>&pid=<?= $file->pid ?>">Share</a>
                                                                <a class="dropdown-item" onclick="opendeletealertModal(<?= $file->id ?>)">Delete</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <!-- Delete File Modal -->
                                            <div class="modal" id="delete_approvefile_<?= $file->id ?>" role="dialog" style="z-index: 999 important!;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-header">
                                                                <h3>Delete File</h3>
                                                                <p>Are you sure want to Delete this File?</p>
                                                            </div>
                                                            <div class="modal-btn delete-action">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <a href="/project-object/delete/<?= $file->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="javascript:void(0);" onclick="closedeletealertModal(<?= $file->id ?>)" class="btn btn-primary cancel-btn">Cancel</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Delete file Modal -->
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="project-members task-followers">
                            <span class="followers-title">Followers</span>

                            <?php foreach ($followers as $follower) : ?>
                                <a href="#" data-toggle="tooltip" title="<?= $follower->user->firstname ?> <?= $follower->user->lastname ?>" class="avatar">

                                    <?php if ($follower->user->profileFilepath != null && $follower->user->profileFilename != null) : ?>
                                        <img src="<?= $follower->user->profileFilepath ?>/<?= $follower->user->profileFilename ?>" alt="">
                                    <?php else : ?>
                                        <img src="/assets/img/profiles/avatar-09.jpg" alt="">
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>

                            <!--   <a href="#" class="followers-add" data-toggle="modal" data-target="#task_followers"><i class="material-icons">add</i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Ticket Modal -->
    <div id="edit_ticket" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ticket Subject</label>
                                    <input class="form-control" type="text" value="Laptop Issue">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ticket Id</label>
                                    <input class="form-control" type="text" readonly value="TKT-0001">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign Staff</label>
                                    <select class="select">
                                        <option>-</option>
                                        <option selected>Mike Litorus</option>
                                        <option>John Smith</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client</label>
                                    <select class="select">
                                        <option>-</option>
                                        <option>Delta Infotech</option>
                                        <option selected>International Software Inc</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Priority</label>
                                    <select class="select">
                                        <option>High</option>
                                        <option selected>Medium</option>
                                        <option>Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CC</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ticket Assignee</label>
                                    <div class="project-members">
                                        <a title="John Smith" data-toggle="tooltip" href="#">
                                            <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Add Followers</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ticket Followers</label>
                                    <div class="project-members">
                                        <a title="Richard Miles" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-09.jpg" alt="">
                                        </a>
                                        <a title="John Smith" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                        </a>
                                        <a title="Mike Litorus" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-05.jpg" alt="">
                                        </a>
                                        <a title="Wilmer Deluna" data-toggle="tooltip" href="#" class="avatar">
                                            <img src="assets/img/profiles/avatar-11.jpg" alt="">
                                        </a>
                                        <span class="all-team">+2</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload Files</label>
                                    <input class="form-control" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Ticket Modal -->

    <!-- Delete Ticket Modal -->
    <div class="modal custom-modal fade" id="delete_ticket" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Ticket</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Ticket Modal -->

    <!-- Assignee Modal -->
    <div id="assignee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign to this task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group m-b-30">
                        <input placeholder="Search to add" class="form-control search-input" type="text">
                        <span class="input-group-append">
                            <button class="btn btn-primary">Search</button>
                        </span>
                    </div>
                    <div>
                        <ul class="chat-user-list">
                            <li>
                                <a href="#">
                                    <div class="media">
                                        <span class="avatar">
                                            <img src="assets/img/profiles/avatar-09.jpg" alt="">
                                        </span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">Richard Miles</div>
                                            <span class="designation">Web Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media">
                                        <span class="avatar">
                                            <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                        </span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">John Smith</div>
                                            <span class="designation">Android Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media">
                                        <span class="avatar">
                                            <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                        </span>
                                        <div class="media-body align-self-center text-nowrap">
                                            <div class="user-name">Jeffery Lalor</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Assign</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Assignee Modal -->

    <!-- Task Followers Modal -->
    <div id="task_followers" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add followers to this task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group m-b-30">
                        <input placeholder="Search to add" class="form-control search-input" type="text">
                        <span class="input-group-append">
                            <button class="btn btn-primary">Search</button>
                        </span>
                    </div>
                    <div>
                        <ul class="chat-user-list">
                            <li>
                                <a href="#">
                                    <div class="media">
                                        <span class="avatar">
                                            <img src="assets/img/profiles/avatar-10.jpg" alt="">
                                        </span>
                                        <div class="media-body media-middle text-nowrap">
                                            <div class="user-name">Jeffery Lalor</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media">
                                        <span class="avatar">
                                            <img src="assets/img/profiles/avatar-08.jpg" alt="">
                                        </span>
                                        <div class="media-body media-middle text-nowrap">
                                            <div class="user-name">Catherine Manseau</div>
                                            <span class="designation">Android Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="media">
                                        <span class="avatar">
                                            <img src="assets/img/profiles/avatar-11.jpg" alt="">
                                        </span>
                                        <div class="media-body media-middle text-nowrap">
                                            <div class="user-name">Wilmer Deluna</div>
                                            <span class="designation">Team Leader</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Add to Follow</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Task Followers Modal -->

</div>
<!-- /Page Wrapper -->
<script>
    function opendeletealertModal(fid) {
        $('#delete_approvefile_' + fid).show();
    }

    function closedeletealertModal(fid) {
        $('#delete_approvefile_' + fid).hide();
    }



    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };


    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });


    function updatepriority(taskId){

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
                    window.location = '/projecttasks/view/'+taskId
                }



            },
            error: function() {}
        })


    }
</script>
