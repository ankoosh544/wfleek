<?php



use Cake\I18n\Time;
?>






<!-- Page Wrapper -->
<div class="page-wrapper">


    <!------------------>
    <?= $this->element('chat_sidebar', [
        'authuser' => $authuser,
        'allgroups' => $allgroups,
        'contacts' => $contacts,

    ]) ?>
    <!--------------------->

    <!-- Chat Main Row -->
    <div class="chat-main-row">

        <!-- Chat Main Wrapper -->
        <div class="chat-main-wrapper">

            <!-- Chats View -->
            <div class="col-lg-9 message-view task-view">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="navbar">
                            <div class="user-details mr-auto">
                                <?php if ($touserdata != null) : ?>
                                    <div class="float-left user-img">

                                        <a class="avatar" href="profile.html" title="<?= $touserdata->firstname ?> <?= $touserdata->lastname ?>">
                                            <?php if ($touserdata->profileFilepath != null && $touserdata->profileFilename != null) : ?>
                                                <img src="<?= $touserdata->profileFilepath ?>/<?= $touserdata->profileFilename ?>" alt="" class="rounded-circle">
                                            <?php else : ?>
                                                <img src="/assets/img/profiles/avatar-05.jpg" alt="" class="rounded-circle">
                                            <?php endif; ?>
                                            <span class="status online"></span>
                                        </a>
                                    </div>
                                    <div class="user-info float-left">
                                        <a href="profile.html" title="<?= $touserdata->firstname ?> <?= $touserdata->lastname ?>"><span><?= $touserdata->firstname ?> <?= $touserdata->lastname ?></span> <i class="typing-text">Typing...</i></a>
                                        <span class="last-seen">Last seen <?= $touserdata->last_login->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></span>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="search-box">
                                <div class="input-group input-group-sm">
                                    <input type="text" placeholder="Search" class="form-control">
                                    <span class="input-group-append">
                                        <button type="button" class="btn"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                            <ul class="nav custom-menu">
                                <li class="nav-item">
                                    <a class="nav-link task-chat profile-rightbar float-right" id="task_chat" href="#task_window"><i class="fa fa-user"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a href="voice-call.html" class="nav-link"><i class="fa fa-phone"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a href="video-call.html" class="nav-link"><i class="fa fa-video-camera"></i></a>
                                </li>
                                <li class="nav-item dropdown dropdown-action">
                                    <a aria-expanded="false" data-toggle="dropdown" class="nav-link dropdown-toggle" href=""><i class="fa fa-cog"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0)" class="dropdown-item">Delete Conversations</a>
                                        <a href="javascript:void(0)" class="dropdown-item">Settings</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <?php if ($contacts == null && $allgroups == null) : ?>
                                        <div class="chats" id="allmessages">
                                            <h2 style="text-align:center">No Messages Available</h2>
                                        </div>
                                    <?php else : ?>
                                        <?php if ($contactData != null) : ?>
                                            <div class="chats" id="allmessages">
                                                <?php $replies = $contactData;

                                                $dates = array(); ?>
                                                <?php foreach ($contactData as $chat) : ?>
                                                    <?php
                                                    $time = date("m/d/Y", strtotime($chat->creation_date));
                                                    ?>
                                                    <?php if (!empty($dates)) : ?>
                                                        <?php if (!in_array($time, $dates)) {
                                                            array_push($dates, $time);
                                                        ?>
                                                            <div class="chat-line">
                                                                <span class="chat-date"><?= $time ?></span>
                                                            </div><?php
                                                                }
                                                                    ?>
                                                    <?php else : ?>

                                                        <div class="chat-line">
                                                            <span class="chat-date"><?= $time ?></span>
                                                        </div>
                                                        <?php array_push($dates, $time); ?>
                                                    <?php endif; ?>




                                                    <?php if ($chat->fromuser_id == $authuser->id) : ?>
                                                        <div class="chat chat-right">
                                                            <div class="chat-body">
                                                                <div class="chat-bubble">
                                                                    <div class="chat-content">
                                                                        <?php if ($chat->parentchat_id !== null) : ?>
                                                                            <?php foreach ($replies as $reply) : ?>
                                                                                <?php if ($chat->parentchat_id == $reply->id) : ?>
                                                                                    <p id="chatcontent_<?= $reply->id ?>"> <?= $reply->content ?></p>
                                                                                    <div class=form-control style="border-radius: 20px;">
                                                                                        <p id="chatcontent_<?= $chat->id ?>"><?= $chat->content ?></p>
                                                                                        <span><?= $chat->creation_date ?> </span>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                        <p id="chatcontent_<?= $chat->id ?>"><?= $chat->content ?></p>
                                                                        <?php if ($chat->chatfiles) : ?>
                                                                            <?php foreach ($chat->chatfiles as $chatfile) : ?>
                                                                                <ul class="attach-list">
                                                                                    <li><i class="fa fa-file"></i> <a href="/chatfiles/downloadchatfile/<?= $chatfile->id ?>"><?= $chatfile->filename ?></a></li>
                                                                                </ul>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                        <?php if ($chat->last_update == null) : ?>
                                                                            <span class="chat-time">Posted At <?= $chat->creation_date ?></span>
                                                                        <?php else : ?>
                                                                            <span class="chat-time">Updated At <?= $chat->creation_date ?></span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="chat-action-btns">
                                                                        <ul>
                                                                            <li><a href="#" class="edit-msg" onclick="editChatModal(<?= $chat->id ?>, <?= $chat->touser_id ?>,<?= $authuser->id ?>)"><i class="fa fa-pencil"></i></a></li>
                                                                            <li><a href="#" class="del-msg" data-toggle="modal" data-target="#delete_chat_<?= $chat->id ?>"><i class="fa fa-trash-o"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="chat chat-left">
                                                            <div class="chat-avatar">
                                                                <a href="profile.html" class="avatar">
                                                                    <img alt="" src="/assets/img/profiles/avatar-05.jpg">
                                                                </a>
                                                            </div>
                                                            <div class="chat-body">
                                                                <div class="chat-bubble">
                                                                    <div class="chat-content">
                                                                        <?php if ($chat->parentchat_id !== null) : ?>
                                                                            <?php foreach ($replies as $reply) : ?>
                                                                                <?php if ($chat->parentchat_id == $reply->id) : ?>
                                                                                    <p id="chatcontent_<?= $reply->id ?>"> <?= $reply->content ?></p>
                                                                                    <div class=form-control style="border-radius: 20px;">
                                                                                        <p id="chatcontent_<?= $chat->id ?>"><?= $chat->content ?></p>
                                                                                        <span><?= $chat->creation_date ?> </span>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                        <p id="chatcontent_<?= $chat->id ?>"><?= $chat->content ?></p>

                                                                        <?php if ($chat->last_update == null) : ?>
                                                                            <span class="chat-time">Posted At <?= $chat->creation_date ?></span>
                                                                        <?php else : ?>
                                                                            <span class="chat-time">Updated At <?= $chat->creation_date ?></span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="chat-action-btns">
                                                                        <ul>
                                                                            <li><a href="#" onclick="replycomment(<?= $chat->fromuser_id ?>,<?= $chat->id ?>,<?= $authuser->id ?>)" title="Reply">Reply</a></li>
                                                                            <li><a href="#" class="edit-msg" onclick="editChatModal(<?= $chat->id ?>, <?= $chat->touser_id ?>,<?= $authuser->id ?>)"><i class="fa fa-pencil"></i></a></li>
                                                                            <li><a href="#" class="del-msg" data-toggle="modal" data-target="#delete_chat_<?= $chat->id ?>"><i class="fa fa-trash-o"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-----------Edit Modal----------------------------->
                                                    <div class="modal " id="editChat_<?= $chat->id ?>_<?= $chat->touser_id ?>_<?= $authuser->id ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal(<?= $chat->id ?>, <?= $chat->touser_id ?>,<?= $authuser->id ?>)">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="reply">Comment</label>
                                                                        <div id="editcontent_<?= $chat->id ?>" class="form-control" contenteditable="true"><?= $chat->content ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" aria-label="Close" onclick="updatechat(<?= $chat->id ?>, <?= $chat->touser_id ?>,<?= $authuser->id ?>)">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-----------Edit Modal----------------------------->

                                                    <!-----------Delete chat----------------------->

                                                    <?= $this->element('delete_chat', [
                                                        'chat' => $chat,
                                                        'authuser' => $authuser
                                                    ]) ?>
                                                    <!--------/Delete chat--------------------------------------->
                                                <?php endforeach; ?>

                                                <?php
                                                $yesterday = new DateTime('yesterday'); // will use our default timezone, Paris
                                                $day =  $yesterday->format('Y-m-d'); // or whatever format you want
                                                ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer">
                        <div class="message-bar">
                            <div class="message-inner">

                                <span class="btn-file" style="padding:10px">
                                    <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images" name="images" type="file" multiple />
                                    <img src="/assets/img/attachment.png" alt="">
                                </span>
                                <div class="message-area">
                                    <div id="chatBubble_<?= $touser ?>" style="background-color:blue"></div>
                                    <div class="input-group">
                                        <textarea class="form-control" name="msg" id="msg_box_<?= $touser ?>" onkeypress="onEnter(event, <?= $touser ?>, <?= $authuser->id ?>)" placeholder="Type message..."></textarea>
                                        <span class="input-group-append">
                                            <button class="btn btn-custom" type="button" onclick="postmessages(<?= $touser ?>, <?= $authuser->id ?>)"><i class="fa fa-send"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Chats View -->

            <!-- Chat Right Sidebar -->
            <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="task_window">
                <div class="chat-window video-window">
                    <div class="fixed-header">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a class="nav-link" href="#calls_tab" data-toggle="tab">Calls</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#profile_tab" data-toggle="tab">Profile</a></li>
                        </ul>
                    </div>
                    <div class="tab-content chat-contents">
                        <div class="content-full tab-pane" id="calls_tab">
                            <div class="chat-wrap-inner">
                                <div class="chat-box">
                                    <div class="chats">
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">You</span> <span class="chat-time">8:35 am</span>
                                                        <div class="call-details">
                                                            <i class="material-icons">phone_missed</i>
                                                            <div class="call-info">
                                                                <div class="call-user-details">
                                                                    <span class="call-description">Jeffrey Warden missed the call</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">John Doe</span> <span class="chat-time">8:35 am</span>
                                                        <div class="call-details">
                                                            <i class="material-icons">call_end</i>
                                                            <div class="call-info">
                                                                <div class="call-user-details"><span class="call-description">This call has ended</span></div>
                                                                <div class="call-timing">Duration: <strong>5 min 57 sec</strong></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-line">
                                            <span class="chat-date">January 29th, 2019</span>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="/assets/img/profiles/avatar-05.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">Richard Miles</span> <span class="chat-time">8:35 am</span>
                                                        <div class="call-details">
                                                            <i class="material-icons">phone_missed</i>
                                                            <div class="call-info">
                                                                <div class="call-user-details">
                                                                    <span class="call-description">You missed the call</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat chat-left">
                                            <div class="chat-avatar">
                                                <a href="profile.html" class="avatar">
                                                    <img alt="" src="/assets/img/profiles/avatar-02.jpg">
                                                </a>
                                            </div>
                                            <div class="chat-body">
                                                <div class="chat-bubble">
                                                    <div class="chat-content">
                                                        <span class="task-chat-user">You</span> <span class="chat-time">8:35 am</span>
                                                        <div class="call-details">
                                                            <i class="material-icons">ring_volume</i>
                                                            <div class="call-info">
                                                                <div class="call-user-details">
                                                                    <a href="#" class="call-description call-description--linked" data-qa="call_attachment_link">Calling John Smith ...</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-full tab-pane show active" id="profile_tab">
                            <div class="display-table">
                                <div class="table-row">
                                    <div class="table-body">
                                        <div class="table-content">
                                            <div class="chat-profile-img" id="editprofile_img">
                                                <div class="edit-profile-img">
                                                    <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                                        <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>">
                                                    <?php else : ?>
                                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                    <?php endif; ?>

                                                    <span class="change-img" data-toggle="modal" data-target="#editprofile_picture_<?= $authuser->id ?>">Change Image</span>
                                                </div>
                                                <h3 class="user-name m-t-10 mb-0"><?= $authuser->firstname ?><?= $authuser->lastname ?></h3>
                                                <?php foreach ($companymembers as $companymember) : ?>
                                                    <?php if ($companymember->user_id == $authuser->id) : ?>
                                                        <?php if ($companymember->member_role == 'Y') : ?>
                                                            <small class="text-muted">Administrator</small>
                                                        <?php elseif ($companymember->member_role == 'Z') : ?>
                                                            <small class="text-muted">Project Manager</small>
                                                        <?php elseif ($companymember->member_role == 'X') : ?>
                                                            <small class="text-muted">Developer</small>
                                                        <?php elseif ($companymember->member_role == 'A') : ?>
                                                            <small class="text-muted">Functional Analyst</small>
                                                        <?php elseif ($companymember->member_role == 'C') : ?>
                                                            <small class="text-muted">Customer</small>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#editprofile_information_<?= $authuser->id ?>" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>

                                            </div>

                                            <!-------------------------------Edit Profile pic Modal-------------------------------------------------------------------->

                                            <?= $this->element('editprofile_picture', [
                                                'authuser' => $authuser

                                            ]) ?>
                                            <!----------------------------------------------Edit Profile Information----------------------------------------------------------------------------->

                                            <div class="modal" id="editprofile_information_<?= $authuser->id ?>" tabindex="-1" role="dialog" aria-labelledby="editprofile_picture">
                                                <div class="modal-dialog" role="dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Update Profile Picture</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-control">
                                                                <label>User Firstname</label>
                                                                <input type="text" id="firstname" value="<?= $authuser->firstname ?> ">
                                                            </div>
                                                            <div class="form-control">
                                                                <label>User Lastname</label>
                                                                <input type="text" id="lastname" value="<?= $authuser->lastname ?> ">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Date of Birth</label>
                                                                <div class="cal-icon">
                                                                    <input type="text" name="dob" id="dob" class="form-control datetimepicker" value="<?= $authuser->birthday ?>" placeholder="dd/mm/yyyy" />
                                                                </div>
                                                            </div>
                                                            <div class="form-control">
                                                                <label>Email</label>
                                                                <input type="email" id="email" value="<?= $authuser->email ?> ">
                                                            </div>
                                                            <div class="form-control">
                                                                <label>Mobile number </label>
                                                                <input type="text" id="number" value="<?= $authuser->tel ?> ">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateProfileinformation(<?= $authuser->id ?>)">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-------------------------------------------------------------------------------------------------------------------------------------------->
                                            <div class="chat-profile-info" id="chatuser-profiledata">
                                                <ul class="user-det-list">
                                                    <li>
                                                        <span>Username:</span>
                                                        <span class="float-right text-muted"><?= $authuser->firstname ?><?= $authuser->lastname ?></span>
                                                    </li>
                                                    <li>
                                                        <span>DOB:</span>
                                                        <span class="float-right text-muted"><?= $authuser->birthday ?></span>
                                                    </li>
                                                    <li>
                                                        <span>Email:</span>
                                                        <span class="float-right text-muted" style="font-size: 12px;"><?= $authuser->email ?></span>
                                                    </li>
                                                    <li>
                                                        <span>Phone:</span>
                                                        <span class="float-right text-muted"><?= $authuser->tel ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="transfer-files">
                                                <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-0">
                                                    <li class="nav-item"><a class="nav-link active" href="#all_files" data-toggle="tab">All Files</a></li>
                                                    <li class="nav-item"><a class="nav-link" href="#my_files" data-toggle="tab">My Files</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane show active" id="all_files">
                                                        <ul class="files-list">
                                                            <li>
                                                                <?php foreach ($allchatfiles as $file) : ?>
                                                                    <div class="files-cont">
                                                                        <?php
                                                                        $path =  $file->filename;
                                                                        $ext  = (new SplFileInfo($path))->getExtension();
                                                                        ?>
                                                                        <div class="file-type">
                                                                            <span class="files-icon">
                                                                                <?php if ($ext == 'pdf') : ?>
                                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                                <?php elseif ($ext == 'word') : ?>
                                                                                    <i class="fa fa-file-word-o"></i>
                                                                                <?php elseif ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp') : ?>
                                                                                    <i class="fa fa-image"></i>
                                                                                <?php else : ?>
                                                                                    <i class="fa fa-file"></i>
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </div>
                                                                        <div class="files-info">
                                                                            <span class="file-name text-ellipsis"><?= $file->filename ?></span>
                                                                            <span class="file-author"><a href="#"><?= $file->user->firstname ?> <?= $file->user->lastname ?></a></span> <span class="file-date">May 31st at 6:53 PM</span>
                                                                        </div>

                                                                        <ul class="files-action">
                                                                            <li class="dropdown dropdown-action">
                                                                                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="/chatfiles/downloadchatfile/<?= $file->id ?>">Download</a>
                                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files_<?= $file->id ?>">Share</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>

                                                                        <!-- Share Files Modal -->
                                                                        <div id="share_files_<?= $file->id ?>" class="modal custom-modal fade" role="dialog">
                                                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title">Share File</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form method="post" action="/chats/chat_data/" enctype="multipart/form-data">
                                                                                            <div class="files-share-list">
                                                                                                <div class="files-cont">
                                                                                                    <div class="file-type">
                                                                                                        <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                                                    </div>
                                                                                                    <div class="files-info">
                                                                                                        <span class="file-name text-ellipsis"><?= $file->filename ?></span>
                                                                                                        <span class="file-author"><a href="#"><?= $file->user->firstname ?> <?= $file->user->lastname ?></a></span> <span class="file-date"><?= $file->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?></span>
                                                                                                        <input type="hidden" value="<?= $file->id ?>" name="chatfile">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Share With</label>
                                                                                                <select class="select2-icon floating" name="touser">
                                                                                                    <?php foreach ($contacts as $contact) : ?>
                                                                                                        <option value="<?= $contact->to_user->id ?>"><?= $contact->to_user->firstname ?> <?= $contact->to_user->lastname ?> (<?= $contact->to_user->email ?>)</option>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>


                                                                                            </div>
                                                                                            <div class="submit-section">
                                                                                                <button class="btn btn-primary submit-btn" type="submit">Share</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /Share Files Modal -->
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="my_files">
                                                        <ul class="files-list">
                                                            <?php foreach ($mychatfiles as $file) : ?>
                                                                <?php
                                                                $path =  $file->filename;

                                                                $ext  = (new SplFileInfo($path))->getExtension();

                                                                ?>
                                                                <li>
                                                                    <div class="files-cont">
                                                                        <div class="file-type">
                                                                            <span class="files-icon">
                                                                                <?php if ($ext == 'pdf') : ?>
                                                                                    <i class="fa fa-file-pdf-o"></i>
                                                                                <?php elseif ($ext == 'word') : ?>
                                                                                    <i class="fa fa-file-word-o"></i>
                                                                                <?php elseif ($ext == 'jpg' || $ext == 'png' || $ext == 'bmp') : ?>
                                                                                    <i class="fa fa-image"></i>
                                                                                <?php else : ?>
                                                                                    <i class="fa fa-file"></i>
                                                                                <?php endif; ?>
                                                                            </span>
                                                                        </div>
                                                                        <div class="files-info">
                                                                            <span class="file-name text-ellipsis"><?= $file->filename ?></span>
                                                                            <span class="file-author">To:<a href="#"><?= $file->touser->firstname ?> <?= $file->touser->lastname ?></a></span> <span class="file-date"><?= $file->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?></span>
                                                                        </div>
                                                                        <ul class="files-action">
                                                                            <li class="dropdown dropdown-action">
                                                                                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                                                <div class="dropdown-menu">
                                                                                    <a class="dropdown-item" href="/chatfiles/downloadchatfile/<?= $file->id ?>">Download</a>
                                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_files_<?= $file->id ?>">Share</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </li>



                                                                <!-- Share Files Modal -->
                                                                <div id="share_files_<?= $file->id ?>" class="modal custom-modal fade" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Share File</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="files-share-list">
                                                                                    <div class="files-cont">
                                                                                        <div class="file-type">
                                                                                            <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                                        </div>
                                                                                        <div class="files-info">
                                                                                            <span class="file-name text-ellipsis"><?= $file->filename ?></span>
                                                                                            <span class="file-author"><a href="#"><?= $file->touser->firstname ?> <?= $file->touser->lastname ?></a></span> <span class="file-date"><?= $file->creation_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome'); ?></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Share With</label>
                                                                                    <select class="select2-icon floating" name="touser">
                                                                                        <?php foreach ($contacts as $contact) : ?>
                                                                                            <option value="<?= $contact->to_user->id ?>"><?= $contact->to_user->firstname ?> <?= $contact->to_user->lastname ?> (<?= $contact->to_user->email ?>)</option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="submit-section">
                                                                                    <button class="btn btn-primary submit-btn">Share</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- /Share Files Modal -->
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Chat Right Sidebar -->

        </div>
        <!-- /Chat Main Wrapper -->

    </div>
    <!-- /Chat Main Row -->

    <!-- Drogfiles Modal -->
    <div id="drag_files" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Drag and drop files upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="js-upload-form">
                        <div class="upload-drop-zone" id="drop-zone">
                            <i class="fa fa-cloud-upload fa-2x"></i> <span class="upload-text">Just drag and drop files here</span>
                        </div>
                        <h4>Uploading</h4>
                        <ul class="upload-list">
                            <li class="file-list">
                                <div class="upload-wrap">
                                    <div class="file-name">
                                        <i class="fa fa-photo"></i>
                                        photo.png
                                    </div>
                                    <div class="file-size">1.07 gb</div>
                                    <button type="button" class="file-close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                                <div class="progress progress-xs progress-striped">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                </div>
                                <div class="upload-process">37% done</div>
                            </li>
                            <li class="file-list">
                                <div class="upload-wrap">
                                    <div class="file-name">
                                        <i class="fa fa-file"></i>
                                        task.doc
                                    </div>
                                    <div class="file-size">5.8 kb</div>
                                    <button type="button" class="file-close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                                <div class="progress progress-xs progress-striped">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                </div>
                                <div class="upload-process">37% done</div>
                            </li>
                            <li class="file-list">
                                <div class="upload-wrap">
                                    <div class="file-name">
                                        <i class="fa fa-photo"></i>
                                        dashboard.png
                                    </div>
                                    <div class="file-size">2.1 mb</div>
                                    <button type="button" class="file-close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                                <div class="progress progress-xs progress-striped">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                </div>
                                <div class="upload-process">Completed</div>
                            </li>
                        </ul>
                    </form>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Drogfiles Modal -->

    <!-- Add Group Modal -->
    <div id="add_group" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create a group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <form action="/chatgroups/creategroup/" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Group Name <span class="text-danger">*</span></label>
                        <input class="form-control" id="addgroupname" type="text" name="groupname">
                    </div>
                    <div>
                        <label for="groupprofilepic">Upload Group Image</label>
                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="groupprofilepic" name="groupprofilepic" type="file" />

                    </div>
                    <div class="form-group form-focus select-focus m-b-30">
                        <label for="adduser"><?= __('Send invites to: ') ?> <span class="text-danger">*</span></label>
                        <select id="groupuser" class="select2-icon floating" name="groupusers[]" multiple>
                            <?php foreach ($allUsers as $singleUser) : ?>
                                <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Group Modal -->

    <!-- Add Chat User Modal -->
    <div id="add_chat_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Direct Chat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="/chatcontacts/adduser" method="post">
                        <div class="form-group form-focus select-focus m-b-30">
                            <label for="adduser"><?= __('Add User') ?> <span class="text-danger">*</span></label>
                            <select id="alltaskassignuser" class="select2-icon" name="chactuser">
                                <?php foreach ($companymembers as $member) : ?>
                                    <option value="<?= $member->user->id ?>"><?= $member->user->firstname ?> <?= $member->user->lastname ?> (<?= $member->user->email ?>)
                                        </br>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Chat User Modal -->

    <!-- Share Files Modal -->
    <div id="share_files" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Share File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="files-share-list">
                        <div class="files-cont">
                            <div class="file-type">
                                <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                            </div>
                            <div class="files-info">
                                <span class="file-name text-ellipsis">AHA Selfcare Mobile Application Test-Cases.xls</span>
                                <span class="file-author"><a href="#">Bernardo Galaviz</a></span> <span class="file-date">May 31st at 6:53 PM</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Share With</label>
                        <input class="form-control" type="text">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Share</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Share Files Modal -->

</div>
<!-- /Page Wrapper -->


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };

    $('.select2-icon').select2({

        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    //Groupchat

    function grouppersonchat(groupid, authuser) {
        // console.log('auth', authuser, 'groupid', groupid);
        $.ajax({
            url: '/groupchats/groupChat',
            method: 'post',
            dataType: 'json',
            data: {
                'groupid': groupid,
            },
            success: function(data) {

                console.log(data, 'grouppersonchat');
                renderGroupchat(data, groupid, authuser);


            },
            error: function(data) {}
        });
    }

    function onEnter(e, to_user, from_user) {
        console.log(e.which);
        if (e.which === 13) {
            e.preventDefault();
            postmessages(to_user, from_user);
        }
    }
    var replay = 0;

    function postmessages(touserid, authuser) {
        var msg = $('#msg_box_' + touserid).val();
        var testing = $('#chatBubble_' + touserid).text()
        var file_data = $("#images").prop("files");
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = authuser;
        }
        form_data.append("replay", replay);
        form_data.append("msg", msg);
        form_data.append("touserid", touserid);
        form_data.append("isFileNotAttached", isFileNotAttached);
        if (replay == 1) {
            var cid = $('#chatBubble_' + touserid + ' input').val();
            form_data.append("cid", cid);
            $('#chatBubble_' + touserid).empty()
        }
        $.ajax({
            url: '/chats/postmessages/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                renderChat(data, authuser, touserid);
            },
            error: function(data) {}
        });
    }



    function renderChat(data, authuser, touserid) {

        $('#allmessages').empty();
        let replies = [...data];
        console.log("Temp ", replies);
        var header = " ";
        var messages = " ";
        var headerUser = authuser === (data.length && data[0] && data[0].to_user.id) ? data[0].from_user : data[0].to_user;
        var status = headerUser.status === 'A' ? 'Offline' : 'Online';
        data.forEach((contact) => {
            if (contact.content) {
                if ((contact.fromuser_id === authuser)) {
                    messages += '<div class="chat chat-right">' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="chat-content">';
                    if (contact.parentchat_id != null) {
                        replies.forEach((reply) => {
                            console.log(contact.id, reply.parentchat_id, 'ids');
                            if (contact.parentchat_id === reply.id) {
                                console.log(reply.content, 'this is actually reply');
                                messages += '<p>' + reply.content + '</p>';
                                messages += '<div class=form-control style =" border-radius: 20px;background-color: whitesmoke;">' +
                                    '<p>' + contact.content + '</p>' +
                                    '<span>' + contact.creation_date + '</span></div>';
                            }
                        });
                    } else {
                        messages += '<p>' + contact.content + '</p>';
                    }
                    messages += '<ul class="attach-list">';
                    if (contact.chatfiles) {
                        contact.chatfiles.forEach((chatfile) => {
                            messages += '<li><i class="fa fa-file"></i> <a href="/chatfiles/downloadchatfile/' + chatfile.id + '">' + chatfile.filename + '</a></li>';
                        });
                    }
                    messages += '</ul>';
                    if (contact.last_update == null) {
                        messages += '<span class="chat-time">' + 'Posted At ' + contact.creation_date + ' </span>';
                    } else {
                        messages += '<span class="chat-time">' + 'Updated At ' + contact.creation_date + ' </span>';
                    }
                    if (contact.isSeen == true) {
                        messages += '<span class="chat-time"><img src="/assets/img/check-mark.png" style="width: 25px;"> </span>';
                    }

                    messages += '</div>' +
                        '<div class="chat-action-btns">' +
                        '<ul>' +
                        '<li><a href="#"  class="edit-msg" onclick="editChatModal(' + contact.id + ',' + contact.touser_id + ',' + authuser + ')" ><i class="fa fa-pencil"></i></a></li>' +
                        '<li><a href="#" class="del-msg" onclick="deletechat(' + contact.id + ', ' + contact.touser_id + ', ' + authuser + ')"><i class="fa fa-trash-o"></i></a></li>' +
                        '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="files" id="fileinfo">' +
                        '</div>' +
                        '</div>';
                    messages += ' <div class="modal " id="editChat_' + contact.id + '_' + contact.touser_id + '_' + authuser + '">' +
                        '<div class="modal-dialog">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title" id="exampleModalLabel">Update</h5>' +
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal(' + contact.id + ', ' + contact.touser_id + ', ' + authuser + ')">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<div class="form-group">' +
                        '<label for="reply">Comment</label>' +
                        '<div id="editcontent_' + contact.id + '" class="form-control" contenteditable="true">' + contact.content + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
                        '<button type="button" class="btn btn-primary"  aria-label="Close" onclick="updatechat(' + contact.id + ',' + contact.touser_id + ',' + authuser + ')">Update</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }
                if ((contact.touser_id === authuser) /* || (contact.replies.length > 0) */ ) {
                    messages += '<div class="chat chat-left">' +
                        '<div class="chat-avatar">' +
                        '<a href="profile.html" class="avatar">' +
                        '<img alt="" src="' + contact.from_user.profileFilepath + '/' + contact.from_user.profileFilename + '">' +
                        '</a>' +
                        '</div>' +
                        '<div class="chat-body">' +
                        '<div class="chat-bubble">' +
                        '<div class="chat-content">';
                    if (contact.parentchat_id !== null) {
                        replies.forEach((reply) => {
                            if (contact.parentchat_id == reply.id) {
                                messages += '<p id="chatcontent_' + reply.id + '">' + reply.content + '</p>';
                                messages += '<div class=form-control style="border-radius: 20px;">' +
                                    '<p id="chatcontent_' + contact.id + '">' + contact.content + '</p>' +
                                    '<span>' + contact.creation_date + '</span></div>';
                            }
                        });
                    } else {
                        messages += '<p id="chatcontent_' + contact.id + '">' + contact.content + '</p>';
                    }
                    messages += '<ul class="attach-list">';
                    if (contact.chatfiles) {
                        contact.chatfiles.forEach((chatfile) => {
                            messages += '<li><i class="fa fa-file"></i> <a href="/chatfiles/downloadchatfile/' + chatfile.id + '">' + chatfile.filename + '</a></li>';
                        });
                    }
                    messages += '</ul>';
                    if (contact.last_update == null) {
                        messages += '<span class="chat-time">' + 'Posted At ' + contact.creation_date + ' </span>';
                    } else {
                        messages += '<span class="chat-time">' + 'Updated At ' + contact.creation_date + ' </span>';
                    }
                    /* if (contact.isSeen == true) {
                        messages += '<span class="chat-time"><img src="/assets/img/check-mark.png" style="width: 25px;"> </span>';
                    } */

                    messages += '</div>' +

                        '<div class="chat-action-btns">' +
                        '<ul>' +
                        '<li><a href="#"  onclick ="replycomment(' + contact.fromuser_id + ',' + contact.id + ',' + authuser + ')" title="Reply">Reply</a></li>' +
                        '</ul>' +
                        '</div>' +
                        '</div></div>' +
                        '</div>';
                }
                $('#allmessages').html(messages);
                $('#msg_box_' + touserid).val("");
            }
        });

    }

    function replycomment(touser, chatid, auth) {

        replay = 1;
        var replaystr = "";
        var replaystr = '<p name="replay" id="replay_' + touser + '" type="hidden">' + replay + '</p>';
        var str = '<input name="cid" id="cid" type="hidden" value="' + chatid + '">';
        var closebutton = '<button type="button" class="close"  aria-label="Close" onclick="closeReplyModal(' + touser + ')">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>';

        $("#chatBubble_" + touser).empty();
        console.log("chat content", $('#chatcontent_' + chatid + '').text());
        //$('#todoreplayPara_' + chatid + '_' + touser + '_' + auth).empty();

        $("#chatBubble_" + touser).append('<div class="form-group" id="todoreplayDiv_' + chatid + '_' + touser + '_' + auth + '"><p id="todoreplayrightsidePara_' + chatid + '"></p>' + str + '' + closebutton + '</div>');
        console.log("chat bubble", $("#chatBubble_" + touser).innerHTML);
        $('#todoreplayrightsidePara_' + chatid + '').append($('#chatcontent_' + chatid + '').text());


    }

    function closeReplyModal(touser) {
        console.log('closing');
        $('#chatBubble_' + touser).empty();
    }

    function closeReplygroupModal(gid) {
        console.log('closing');
        $('#groupchatBubble_' + gid).empty();
    }



    function updatechat(chatid, touser, authuser) {
        var content = $('#editcontent_' + chatid).text()
        $.ajax({
            url: '/chats/editchat',
            method: 'post',
            dataType: 'json',
            data: {
                'chatid': chatid,
                'touser': touser,
                'content': content
            },
            success: function(data) {
                renderChat(data, authuser, touser)

            },
            error: function(a, b, c) {

            }
        });

    }

    function deletechat(chatid, touser, authuser) {
        $.ajax({
            url: '/chats/deletechat',
            method: 'post',
            dataType: 'json',
            data: {
                'chatid': chatid,
                'touser': touser
            },
            success: function(data) {
                window.location = '/chats/chatsystem/' + touser;

            },
            error: function(a, b, c) {

            }
        });
    }
    var values;
    $(".select2-icon").on("select2:select", function(event) {
        values = [];
        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            values[i] = parseInt($(selected).val());
        });

        // output values (all current values selected)
        console.log("selected values: ", values);

    });

    function select2function(touser, authuser) {

        var file_data = $('#groupprofilepic').prop('files');
        var groupname = $('#addgroupname').val();
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }

        } else {
            isFileNotAttached = 123;
        }
        form_data.append("groupname", groupname);
        form_data.append("isFileNotAttached", isFileNotAttached);
        form_data.append("values", JSON.stringify(values));

        console.log(values, 'Values');
        $.ajax({
            url: '/chatgroups/creategroup',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                console.log(data);
                window.location = '/chats/chatsystem/' + touser;
            },

            error: function(e) {
                console.log(e);


            }
        });
    }


    //modal functions

    function editChatModal(chatid, touser, authuser) {
        console.log("This is Chat System")
        $('#editChat_' + chatid + '_' + touser + '_' + authuser).show();
    }

    function closeModal(chatid, touser, authuser) {
        $('#editChat_' + chatid + '_' + touser + '_' + authuser).hide();

    }

    function updateProfilepic(authuser) {
        var file_data = $("#profilepic").prop("files")[0];
        var form_data = new FormData();
        form_data.append("file", file_data);
        $.ajax({
            url: '/user/updateProfilepic',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(data) {
                var str = "";
                $('#editprofile_img').empty();
                str = '<div class="edit-profile-img">' +
                    '<img alt="" src="' + data.profileFilepath + '/' + data.profileFilename + '">' +
                    '<span class="change-img" data-toggle="modal" data-target="#editprofile_picture_' + data.id + '" >Change Image</span>' +
                    '</div>' +
                    '<h3 class="user-name m-t-10 mb-0">' + data.firstname + ' ' + data.lastname + '</h3>' +
                    '<small class="text-muted"></small>' +
                    '<a href="javascript:void(0);" data-toggle="modal" data-target="#editprofile_information_' + data.id + '" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>' +
                    '</div>';
                $('#editprofile_img').html(str);
            },
            error: function(a, b, c) {}
        });
    }

    function updateProfileinformation(authuser) {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var dob = $('#dob').val();
        var email = $('#email').val();
        var number = $('#number').val();
        $.ajax({
            url: '/user/updateprofile',
            method: 'post',
            dataType: 'json',
            data: {
                'authuser': authuser,
                'firstname': firstname,
                'lastname': lastname,
                'dob': dob,
                'email': email,
                'number': number
            },
            success: function(data) {
                $('#chatuser-profiledata').empty();
                console.log('updated data', data);
                var profile = "";
                profile += ' <ul class="user-det-list">' +
                    '<li>' +
                    '<span>Username:</span>' +
                    '<span class="float-right text-muted">' + data.firstname + ' ' + data.lastname + '</span>' +
                    '</li>' +
                    '<li>' +
                    '<span>DOB:</span>' +
                    '<span class="float-right text-muted">' + data.birthday + '</span>' +
                    '</li>' +
                    '<li>' +
                    '<span>Email:</span>' +
                    '<span class="float-right text-muted" style="font-size: 12px;">' + data.email + '</span>' +
                    '</li>' +
                    '<li>' +
                    '<span>Phone:</span>' +
                    '<span class="float-right text-muted">' + data.tel + '</span>' +
                    '</li>' +
                    '</ul>';
                $('#chatuser-profiledata').html(profile);
            },
            error: function(a, b, c) {

            }
        });
    }
</script>
