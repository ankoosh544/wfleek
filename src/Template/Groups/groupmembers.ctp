<?php

use Cake\I18n\Number;
?>
<style>
    .group-post {
        float: right;
    }
</style>

<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="card mb-0" style="background-image: url('/<?= $group->group_backgroundimagepath ?>/<?= $group->group_backgroundimagename ?>')">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php if ($group->group_profileFilepath != null && $group->group_profileFilename != null) : ?>
                                <img alt="" src="/<?= $group->group_profileFilepath ?>/<?= $group->group_profileFilename ?>" style="width:25% ;">
                            <?php else : ?>
                                <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:25% ;">
                            <?php endif; ?>
                            <label for="">
                                <h3><?= $group->name ?></h3>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6" onclick="changebackgroundimage(<?= $group->id ?>);">

                    </div>
                    <div class="col-sm-2">
                        <?php if ($authuser->id == $group->creatorId) : ?>
                            <a href="/groups/addmembers/<?= $group->id ?>" class="btn btn-info group-post" type="submit">ADD MEMBERS</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update Group background image -->
        <?= $this->element('updategroup_backgroundimage') ?>
        <!---/Update Group background image-->

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item "><a class="nav-link" href="/groups/view/<?= $group->id ?>"> All Conversation</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/groups/groupmembers/<?= $group->id ?>">Members</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/companygroups/<?= $group->id ?>">Groups</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/files/<?= $group->id ?>">Files</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/notes/<?= $group->id ?>">Notes</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="GET" action="/groups/searchdata/<?= $group->id ?>">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchkey">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <!-- Change Background Image Modal -->
        <div class="modal custom-modal fade" id="background_image_<?= $group->id ?>" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="/groups/updatebackgroundimg" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Update Background Image</h3>
                            </div>
                            <div class=" form-group">
                                <label for="image"> Image</label>
                                <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" name="background_image" type="file" />
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary continue-btn">Update</button>

                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                            <input type="hidden" name="group_id" value="<?= $group->id ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Change Background Image Modal ---->
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php foreach ($groupmembers as $groupmember) : ?>
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="dash-sidebar">
                                <section>
                                    <h5 class="dash-title"></h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <?php if ($authuser->id == $groupmember->user_id || $authuser->id == $group->creatorId) : ?>
                                                <div class="dropdown kanban-action group-post">
                                                    <a href="" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">

                                                        <a class="dropdown-item" data-toggle="modal" href="#" data-target="#exit_group_<?= $groupmember->group_id ?>"><i class="fa fa-sign-out" aria-hidden="true"></i>Exit</a>
                                                    </div>
                                                </div>

                                                <!-- Exit Member Modal -->
                                                <div class="modal custom-modal fade" id="exit_group_<?= $groupmember->group_id ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Exit Group</h3>
                                                                    <p>Are you sure want to Exit and Delete Group?</p>
                                                                </div>
                                                                <div class="modal-btn delete-action">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <a href="/groupmembers/deletemember?memberid=<?= $groupmember->user->id ?>&groupid=<?= $groupmember->group_id ?>" type="submit" style="width: 100%;" class="btn btn-primary continue-btn">Delete</a>
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
                                                <!-- /Exit Member Modal ---->

                                            <?php endif; ?>
                                            <div class="form-group">
                                                <a href="/user/view/<?= $groupmember->user->id ?>" data-toggle="tooltip" title="<?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?>">
                                                    <?php if ($groupmember->user->profileFilepath != null && $groupmember->user->profileFilename != null) : ?>
                                                        <img alt="" src="<?= $groupmember->user->profileFilepath ?>/<?= $groupmember->user->profileFilename ?>" style=" width: 7%;">
                                                    <?php else : ?>
                                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width: 10%;">
                                                    <?php endif; ?>
                                                    <label><?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?></label>
                                                </a>

                                                </br>
                                                </br>
                                                <?php if ($groupmember->member_role == 'Y') : ?>
                                                    <p><span><img src="/assets/img/admin.png" alt="" style="width: 25px;"></span>Group Admin</p>
                                                <?php else : ?>
                                                    <p><span><img src="/assets/img/group.png" alt="" style="width: 25px;"></span>Group Member</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </section>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
