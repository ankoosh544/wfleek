<?php

use Cake\I18n\Number;
?>
<style>
    .group-post {
        float: right;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="card mb-0 shape" style="background-image: url('/<?= $group->group_backgroundimagepath ?>/<?= $group->group_backgroundimagename ?>')" onclick="changebackgroundimage(<?= $group->id ?>);">
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

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item "><a class="nav-link" href="/groups/view/<?= $group->id ?>"> All Conversation</a></li>
                    <li class="nav-item"><a class="nav-link " href="/groups/groupmembers/<?= $group->id ?>">Members</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/groups/companygroups/<?= $group->id ?>">Groups</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/files/<?= $group->id ?>">Files</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/notes/<?= $group->id ?>">Notes</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="GET" action="/groups/searchdata/<?= $group->id ?>">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchkey">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        </br>
         <!-- Update Group background image -->
         <?= $this->element('updategroup_backgroundimage') ?>
        <!---/Update Group background image-->

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php foreach ($companygroups as $companygroup) : ?>

                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="dash-sidebar">
                                <section>
                                    <h5 class="dash-title"></h5>
                                    <?php
                                    $totalmembers = array();
                                    foreach ($allmembers as $groupmember) {

                                        if ($groupmember->group_id == $companygroup->id) {
                                            array_push($totalmembers, $groupmember);
                                        }
                                    }
                                    ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="dropdown kanban-action group-post">
                                                <a href="" data-toggle="dropdown">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_task_board"><i class="fa fa-pencil m-r-5"></i>Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_group_<?= $companygroup->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>

                                            <?= $this->element('delete_companygroup', [
                                                'companygroup' => $companygroup,
                                            ]) ?>

                                            <div class="form-group">
                                                <a href="/groups/view/<?= $companygroup->id ?>">
                                                    <h3><?= $companygroup->name ?></h3>
                                                </a>
                                                <p><span><img src="/assets/img/lock-in-a-circle.png" alt="" style="width: 25px;"></span> Private group</p>
                                                <p>
                                                    </br>
                                                    <span><img src="/assets/img/admin.png" alt="" style="width: 25px;"></span>
                                                    <?= $companygroup->user->firstname ?> <?= $companygroup->user->lastname ?>
                                                </p>
                                                <p><span><img src="/assets/img/group.png" alt="" style="width: 25px;"></span><?= count($totalmembers) ?> Members</p>
                                                </br>
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
<script>
    function changebackgroundimage(group_id) {
        $('#background_image_' + group_id).modal('show');

    }
</script>
