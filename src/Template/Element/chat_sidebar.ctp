<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="/project-member/privatedashboard/<?= $authuser->choosen_companyId ?>"><i class="la la-home"></i> <span>Back to Home</span></a>
                </li>
                <li class="menu-title"><span>Chat Groups</span> <a href="#" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i></a></li>
                <div id="chatgroupDiv">

                    <?php if ($allgroups != null) : ?>



                        <?php foreach ($allgroups as $group) : ?>

                            <?php
                            $totalnotseen = array();
                            foreach ($allgroupchatData as $chat) {

                                if ($chat->group_id == $group->id) {
                                    if ($chat->isSeen == false) {

                                        array_push($totalnotseen, $chat->id);
                                    }
                                }
                            } ?>

                            <li>
                                <a href="/groupchats/group-chat/<?= $group->id ?>" onclick="updatelastseengroup(<?= $group->id ?>)">
                                    <span class="chat-avatar-sm user-img">
                                        <?php if ($group->groupimagepath != null && $group->groupimagename != null) : ?>
                                            <img class="rounded-circle" alt="" src="/<?= $group->groupimagepath ?>/<?= $group->groupimagename ?>">
                                        <?php else : ?>
                                            <img class="rounded-circle" alt="" src="/assets/img/user.jpg">
                                        <?php endif; ?>
                                    </span>
                                    <span class="chat-user">#<?= $group->name ?></span><span style="float: right;" class="badge badge-pill bg-danger"><?= count($totalnotseen) ?></span>
                                </a>
                            </li>
                            </br>
                            <!-- Delete Group Modal -->
                            <div class="modal" id="delete_approve_<?= $group->id ?>_<?= $user_id ?>" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="form-header">
                                                <h3>Delete Group</h3>
                                                <p>Are you sure want to Delete this Group?</p>
                                            </div>
                                            <div class="modal-btn delete-action">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a onclick="deletegroup(<?= $group->id ?>,<?= $user_id ?>)" class="btn btn-primary continue-btn">Delete</a>
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
                            <!-- /Delete Group Modal ---------------------------------->

                            <!------Delete Group user Modal ----------------------------->
                            <div class="modal submodal" id="delete_groupmember_<?= $group->id ?>_<?= $user_id ?>" style="display: none;left:25%">
                                <div class="modal-dialog-centered modal-md" role="dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Group User</h5>
                                            <button type="button" class="close" aria-label="Close" onclick="closedeletegroupmember(<?= $group->id ?>,<?= $user_id ?>)">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-control">
                                                <label for="groupname">Groupname</label>
                                                <input type="text" id="deletegroupname_<?= $group->id ?>" value="<?= $group->name ?>">
                                            </div>

                                            <div class="form-group form-focus select-focus m-b-30">
                                                <label for="groupuser"><?= __('Add Group Chat User') ?> <span class="text-danger">*</span></label>
                                                <select id="deletegroupuser_<?= $group->id ?>" class="select2-icon floating" multiple>

                                                    <?php foreach ($groupusers as $groupuser) : ?>
                                                        <?php foreach ($allUsers as $singleUser) : ?>
                                                            <?php if ($groupuser->user_id == $singleUser->id) : ?>
                                                                <option selected value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary">Close</button>

                                                <button type="button" class="btn btn-primary " aria-label="Close" onclick="deletegroupuser(<?= $group->id ?>,<?= $user_id ?>)">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-------Delete Group user Modal --------------------------->

                            <!------Group Edit Modal ------------------------------------>
                            <div class="modal submodal" id="editgroup_<?= $group->id ?>_<?= $user_id ?>" style="display: none;left:25%">
                                <div class="modal-dialog-centered modal-md" role="dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Assign the user to task</h5>
                                            <button type="button" class="close" aria-label="Close" onclick="closegroupedit(<?= $group->id ?>,<?= $user_id ?>)">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-control">
                                                <label for="groupname">Goupname</label>
                                                <input type="text" id="editgroupname_<?= $group->id ?>" value="<?= $group->name ?>">
                                            </div>
                                            <div class="form-control">
                                                <label for="grouppic">Choose Groupchat Image</label>
                                                <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="editgroupimage_<?= $group->id ?>" name="images" type="file" />

                                            </div>
                                            <div class="form-group form-focus select-focus m-b-30">
                                                <label for="groupuser"><?= __('Add Group Chat User') ?> <span class="text-danger">*</span></label>
                                                <select id="groupuser_<?= $group->id ?>" class="select2-icon floating" multiple>
                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                        <option value="<?= $singleUser->id ?>"> <?= $singleUser->firstname ?> <?= $singleUser->lastname ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary " aria-label="Close" onclick="updategroupData(<?= $group->id ?>,<?= $user_id ?>)">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------Group Edit Modal ------------------------------------->
                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>

                <li class="menu-title">Direct Chats <a href="#" data-toggle="modal" data-target="#add_chat_user"><i class="fa fa-plus"></i></a></li>


                <?php if ($contacts != null) : ?>
                    <?php foreach ($contacts as $contact) : ?>

                        <?php
                        $totalnotseen = array();
                        if (!empty($allcontactData)) {
                            foreach ($allcontactData as $chat) {

                                if ($chat->fromuser_id == $contact->touser_id && $chat->touser_id == $contact->fromuser_id) {
                                    if ($chat->isSeen == false) {

                                        array_push($totalnotseen, $chat->id);
                                    }
                                }
                            }
                        } ?>

                        <?php if ($lastchat_touser == $contact->touser_id) : ?>
                            <li class="active">
                                <a href="/chats/chatsystem/<?= $contact->touser_id ?>" onclick="updatelastseenchat(<?= $contact->touser_id ?>)">
                                    <span class="chat-avatar-sm user-img">
                                        <?php if ($contact->to_user->profileFilepath != null && $contact->to_user->profileFilename != null) : ?>
                                            <img class="rounded-circle" alt="" src="<? $contact->to_user->profileFilepath ?>/<?= $contact->to_user->profileFilename ?>"><span class="status online"></span>
                                        <?php else : ?>
                                            <img class="rounded-circle" alt="" src="/assets/img/profiles/avatar-05.jpg"><span class="status online"></span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="chat-user"><?= $contact->to_user->firstname ?> <?= $contact->to_user->lastname ?></span> <span class="badge badge-pill bg-danger"><?= count($totalnotseen) ?></span>
                                </a>
                            </li>
                        <?php else : ?>
                            <li>
                                <a href="/chats/chatsystem/<?= $contact->touser_id ?>">
                                    <span class="chat-avatar-sm user-img">
                                        <?php if ($contact->to_user->profileFilepath != null && $contact->to_user->profileFilename != null) : ?>
                                            <img class="rounded-circle" alt="" src="<? $contact->to_user->profileFilepath ?>/<?= $contact->to_user->profileFilename ?>"><span class="status online"></span>
                                        <?php else : ?>
                                            <img class="rounded-circle" alt="" src="/assets/img/profiles/avatar-02.jpg"><span class="status online"></span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="chat-user"><?= $contact->to_user->firstname ?> <?= $contact->to_user->lastname ?></span> <span class="badge badge-pill bg-danger"><?= count($totalnotseen) ?></span>
                                </a>
                            </li>

                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
<script>
    function updatelastseengroup(group_id) {

        console.log(group_id);
        $.ajax({
            url: '/groupchats/updatelastseen',
            method: 'post',
            dataType: 'json',
            data: {
                'group_id': group_id
            },
            success: function(data) {
                //  window.location = '/chats/chatsystem/' + touser;

            },
            error: function(a, b, c) {

            }
        });
    }

    function updatelastseenchat(touser) {
        $.ajax({
            url: '/chats/updatelastseenchat',
            method: 'post',
            dataType: 'json',
            data: {
                'touser': touser
            },
            success: function(data) {
                //  window.location = '/chats/chatsystem/' + touser;

            },
            error: function(a, b, c) {

            }
        });

    }
</script>
