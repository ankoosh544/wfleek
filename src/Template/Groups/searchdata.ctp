<?php

use Cake\I18n\Number;
use Cake\I18n\Time;

?>
<style>
    .group-post {
        float: right;
    }

    .liked-botton {
        color: blue;
    }

    .unliked-botton {
        color: black;
    }

    .post-area {
        margin: 20px;
        /*  border-radius: 16px;
        background-color: white;
        padding: 10px; */
    }
</style>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>--->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<a href="https://www.flaticon.com/free-icons/like" title="like icons">Like icons created by Freepik - Flaticon</a>
<script src="https://code.iconify.design/2/2.1.1/iconify.min.js"></script>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="card mb-0 shape" style="background-image: url('/<?= $group->group_backgroundimagepath ?>/<?= $group->group_backgroundimagename ?>')" onclick="changebackgroundimage(<?= $group->id ?>);">
            <div class="card-body">
                <?php if ($authuser->id == $group->creatorId) : ?>
                    <a href="/groups/addmembers/<?= $group->id ?>" class="btn btn-info group-post" type="submit">ADD MEMBERS</a>
                <?php endif; ?>
                <div class="row">
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


            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <!--  <li class="nav-item "><a class="nav-link" href="/groups/newconversation/<?= $group->id ?>">New Conversation</a></li> -->
                    <li class="nav-item "><a class="nav-link active" href="/groups/view/<?= $group->id ?>"> All Conversation</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/groupmembers/<?= $group->id ?>">Members</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/companygroups/<?= $group->id ?>">Groups</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/files/<?= $group->id ?>">Files</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/notes/<?= $group->id ?>">Notes</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="GET" action="/groups/searchdata/<?= $group->id ?>">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchkey" value="<?= $search_key ?>">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>


        <div class="row">
            <div class="col-lg-12">
                <div class="search-result">
                    <h3>Search Result Found For: <u><?= $search_key ?></u></h3>

                    <?php if ($allgroupposts != null) : ?>
                        <?php $totalsearch = (count($allgroupposts)); ?>
                    <?php else : ?>
                        <?php $totalsearch = "NO MAATCH FOUND" ?>

                    <?php endif; ?>
                    <p><?= $totalsearch ?> Results found</p>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-9 col-md-9">
                                <!------------Form to Create a Post----------------------------------->
                                <form method="post" action="/groupposts/add/<?= $group->id ?>" enctype="multipart/form-data">
                                    <div class="postmessage-form" id="toggablediv">
                                        <div>
                                            <textarea class="form-control" type="text" placeholder="Write Something..." name="post_message" id="textdiv" onclick="togglediv()"></textarea>
                                        </div>
                                        <div class="form-group form-focus select-focus m-b-30 tagpeopledive" style="display: none;">
                                            <img id="input_img" src="/assets/img/group.png" alt="" style="width: 20px;">
                                            <select id="tagusers1" class="select2-icon floating" name="tagedusers[]" multiple>
                                                <?php foreach ($groupmembers as $groupmember) : ?>
                                                    <option style="padding-left:30px" value="<?= $groupmember->user->id ?>"><?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="btn-file form-group" style="padding:10px">
                                                <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'images', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                                <img src="/assets/img/upload.png" alt="" style="width: 20px;">
                                            </span>
                                            <button style="width: 20%;" type="submit" class="btn btn-primary continue-btn">post</button>
                                        </div>
                                    </div>
                                </form>
                                <!------------/Form to Create a Post----------------------------------->

                                <div class="groupposts-block">
                                    <section>
                                        <h5 class="dash-title"></h5>
                                        <?php foreach ($allgroupposts as $post) : ?>
                                            <div class="card" id="cardsettings">
                                                <div class="card-body">
                                                    <?php if ($post->user_id == $authuser->id || $group->creatorId == $authuser->id) : ?>
                                                        <div class="dropdown kanban-action group-post">
                                                            <a href="" data-toggle="dropdown">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_post_<?= $post->id ?>">Edit</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_post_<?= $post->id ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="form-group">
                                                        <a href="#" data-toggle="tooltip" title="<?= $post->user->firstname ?> <?= $post->user->lastname ?>">
                                                            <?php if ($post->user->profileFilepath != null && $post->user->profileFilename != null) : ?>
                                                                <img alt="" src="<?= $post->user->profileFilepath ?>/<?= $post->user->profileFilename ?>" style=" width: 7%;">
                                                            <?php else : ?>
                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width: 10%;">
                                                            <?php endif; ?>
                                                        </a>
                                                        <label><?= $post->user->firstname ?> <?= $post->user->lastname ?>

                                                            <!----------------Sharred file part---------------------->
                                                            <?php if ($post->isShared == true) : ?> <span style="color: rgb(34 32 32 / 50%);"> - Sharred a File </span><?php endif; ?>
                                                            <!----------------/Sharred file part---------------------->

                                                            <!---------------------Tagged people part------------------>
                                                            <?php if (!empty($post->groupposttagmembers)) : ?>
                                                                <span style="color: rgb(34 32 32 / 50%);"> - is Tagged </span>
                                                                <?php foreach ($post->groupposttagmembers as $tagmember) : ?>
                                                                    <?php if ($tagmember->isPost == true) : ?>
                                                                        <a href="/user/view/<?= $tagmember->user->id ?>"><?= $tagmember->user->firstname ?> <?= $tagmember->user->lastname ?> </a>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            <!------------------/Tagged people part------------------>
                                                            <span class="chat-time">Posted At <?= $post->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?> </span>
                                                        </label>
                                                        </br>
                                                        <div class="post-area">
                                                            <p>
                                                                <?= $post->post_data ?>
                                                            </p>
                                                        </div>
                                                        <?php if ($post->grouppostfiles) : ?>
                                                            <div class="post-files">
                                                                <?php foreach ($post->grouppostfiles as $file) : ?>
                                                                    <?php $ext  = (new SplFileInfo($file->filename))->getExtension(); ?>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="/grouppostfiles/downloadfile/<?= $file->id ?>">
                                                                                <?php if ($ext == 'mp4') : ?>
                                                                                    <video width="500px" height="250px" controls>
                                                                                        <source src="/<?= $file->filepath ?>/<?= $file->filename ?>" type="video/mp4">
                                                                                    </video>
                                                                                <?php elseif ($ext == 'jpg') : ?>
                                                                                    <img style="width: 500px;height:250px" src="/<?= $file->filepath ?>/<?= $file->filename ?>" alt="">
                                                                                <?php else : ?>
                                                                                    <span><?= $file->filename ?></span>
                                                                                <?php endif; ?>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>


                                                    <div class="row" style="height: 25px;">
                                                        <div class="likecount" id="postlikes_<?= $post->id ?>">
                                                            <?php if (!empty($post->postlikes)) : ?>
                                                                <span class="iconify" data-icon="uiw:like-o" style="color: blue;"></span>
                                                                <?= count($post->postlikes) ?>
                                                                <a class="likedpeoples" data-toggle="modal" data-target="#post_likedpeople_<?= $post->id ?>">Peoples</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <!------------Post Liked peoples------------------------------>

                                                    <div class="modal custom-modal fade" id="post_likedpeople_<?= $post->id ?>" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="form-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                        <span>Members(<?= count($post->postlikes) ?>)</span>
                                                                    </div>
                                                                    <?php foreach ($post->postlikes as $like) : ?>
                                                                        <?php if ($like->isReply == false) : ?>
                                                                            <div class="card">
                                                                                <h4 class="table-avatar">
                                                                                    <?php if ($like->user->profileFilepath != null && $like->user->profileFilename) : ?>
                                                                                        <a href="/user/view/<?= $like->user->id ?>" class="avatar"><img src="<?= $like->user->profileFilepath ?>/<?= $like->user->profileFilename ?>" alt=""></a>
                                                                                    <?php else : ?>
                                                                                        <a href="/user/view/<?= $like->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                                                                    <?php endif; ?>
                                                                                    <a href="/user/view/<?= $like->user->id ?>"><?= $like->user->firstname ?> <?= $like->user->lastname ?>
                                                                                    </a>
                                                                                    </h2>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </br>
                                                    <!----------------Post Liked------------------------------------------------>

                                                    <div class="row ">
                                                        <div class="col" style="text-align: center;cursor: pointer;">

                                                            <?php if (!empty($post->postlikes)) : ?>

                                                                <?php
                                                                $authuserlikes = array();
                                                                foreach ($post->postlikes as $postlike) {
                                                                    if ($postlike->user_id == $authuser->id && $postlike->isLiked == true) {
                                                                        array_push($authuserlikes, $postlike);
                                                                    }
                                                                }
                                                                ?>

                                                                <?php if (!empty($authuserlikes)) : ?>
                                                                    <a id="check_like_<?= $post->id ?>" style="text-align: center;cursor: pointer; color:blue" onclick="postliked(<?= $post->id ?>,<?= $authuser->id ?>,<?= $postlike->id ?>)">
                                                                        <div>
                                                                            <span class="iconify" data-icon="uiw:like-o" style="color:blue;"></span> <span>Like</span>
                                                                        </div>
                                                                    </a>
                                                                <?php else : ?>

                                                                    <a id="check_like_<?= $post->id ?>" style="text-align: center;cursor: pointer;color:black" onclick="postliked(<?= $post->id ?>,<?= $authuser->id ?>,<?= $postlike->id ?>)">
                                                                        <div>
                                                                            <span class="iconify" data-icon="uiw:like-o" style="color: black;"></span> <span>Like</span>
                                                                        </div>
                                                                    </a>
                                                                <?php endif; ?>

                                                            <?php else : ?>
                                                                <a id="check_like_<?= $post->id ?>?>" onclick="postliked(<?= $post->id ?>,<?= $authuser->id ?>)">
                                                                    <div>
                                                                        <span class="iconify" data-icon="uiw:like-o"></span> <span> Like</span>
                                                                    </div>
                                                                </a>
                                                            <?php endif; ?>

                                                        </div>
                                                        <?php if (!empty($post->favoriteposts)) : ?>
                                                            <?php foreach ($post->favoriteposts as $favoritepost) : ?>
                                                                <?php if ($favoritepost->user_id == $authuser->id) : ?>
                                                                    <div class="col">
                                                                        <a id="add_favourite_<?= $post->id ?>?>" onclick="addFavourite(<?= $post->id ?>,<?= $authuser->id ?>, <?= $post->group_id ?>)">
                                                                            <div style="cursor:pointer;">
                                                                                <span class="iconify" data-icon="akar-icons:heart" style="color: red;"></span> <span style="color: red;"> Add to favourite</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                <?php else : ?>
                                                                    <div class="col">
                                                                        <a id="add_favourite_<?= $post->id ?>?>" onclick="addFavourite(<?= $post->id ?>,<?= $authuser->id ?>, <?= $post->group_id ?>)">
                                                                            <div style="cursor:pointer;">
                                                                                <span class="iconify" data-icon="akar-icons:heart"></span> <span> Add to favourite</span>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php else : ?>
                                                            <div class="col">
                                                                <a id="add_favourite_<?= $post->id ?>?>" onclick="addFavourite(<?= $post->id ?>,<?= $authuser->id ?>, <?= $post->group_id ?>)">
                                                                    <div style="cursor:pointer;">
                                                                        <span class="iconify" data-icon="akar-icons:heart"></span> <span> Add to favourite</span>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="col">
                                                            <a href="#msg_<?= $post->id ?>" style="text-align: center;cursor: pointer;color:black">
                                                                <span>Comment</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    </br>


                                                    <div class="comments-mainsection" id="cmts_<?= $post->id ?>">
                                                        <?php foreach ($post->postcomments as $postcomment) : ?>
                                                            <div class="comment-section">
                                                                <div class="dropdown kanban-action group-post">
                                                                    <a href="" data-toggle="dropdown">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_comment_<?= $postcomment->id ?>">Edit</a>
                                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_comment_<?= $postcomment->id ?>">Delete</a>
                                                                    </div>
                                                                </div>
                                                                <div class="inner-commentsection" style="display: flex;">
                                                                    <div class="form-group">
                                                                        <a href="#" data-toggle="tooltip" title="<?= $postcomment->user->firstname ?> <?= $postcomment->user->lastname ?>" style="width:7%">
                                                                            <?php if ($postcomment->user->profileFilepath != null && $postcomment->user->profileFilename != null) : ?>
                                                                                <img alt="" src="<?= $postcomment->user->profileFilepath ?>/<?= $postcomment->user->profileFilename ?>" style="width:25px;">
                                                                            <?php else : ?>
                                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:26px ;">
                                                                            <?php endif; ?>
                                                                        </a>
                                                                    </div>
                                                                    <div class="form-control" style="border-radius: 24px;">
                                                                        <span><?= $postcomment->user->firstname ?> <?= $postcomment->user->lastname ?></span>

                                                                        <!------------------/Tagged people part for Comment------------------>
                                                                        <?php if (!empty($postcomment->groupposttagmembers)) : ?>

                                                                            <span style="color: rgb(34 32 32 / 50%);"> -in Comment to </span>
                                                                            <?php foreach ($postcomment->groupposttagmembers as $tagmember) : ?>
                                                                                <?php if ($postcomment->id == $tagmember->comment_id && $tagmember->isComment == true) : ?>
                                                                                    <a href="/user/view/<?= $tagmember->user->id ?>"><?= $tagmember->user->firstname ?> <?= $tagmember->user->lastname ?> </a>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                        <!------------------/Tagged people part for Comment------------------>

                                                                        <p><?= $postcomment->comment_data ?></p>

                                                                        <?php if ($postcomment->postcommentfiles) : ?>
                                                                            <?php foreach ($postcomment->postcommentfiles as $file) : ?>
                                                                                <ul class="attach-list">
                                                                                    <li><i class="fa fa-file"></i> <a href="/postcommentfiles/downloadfile/<?= $file->id ?>"><?= $file->filename ?></a></li>
                                                                                </ul>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>

                                                                        <?php if ($postcomment->creation_date != null) : ?>
                                                                            <span class="chat-time">Commented At <?= $postcomment->creation_date ?></span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>


                                                                <div class="row" style="height: 25px;">
                                                                    <div class="commentlikescount" id="commentlikes_<?= $postcomment->id ?>">
                                                                        <?php if (!empty($postcomment->postcommentlikes)) : ?>
                                                                            <span class="iconify" data-icon="uiw:like-o" style="color:blue;"></span>
                                                                            <?= count($postcomment->postcommentlikes) ?>
                                                                            <a class="likedpeoples" data-toggle="modal" data-target="#comment_likedpeople_<?= $postcomment->id ?>">Peoples</a>
                                                                        <?php endif; ?>

                                                                        <!------------Comment Liked peoples------------------------------>

                                                                        <div class="modal custom-modal fade" id="comment_likedpeople_<?= $postcomment->id ?>" role="dialog">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">

                                                                                    <div class="modal-body">
                                                                                        <div class="form-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                            <h3>Members</h3>
                                                                                        </div>
                                                                                        <?php foreach ($postcomment->postcommentlikes as $like) : ?>
                                                                                            <?php if ($like->isReply == false) : ?>
                                                                                                <div class="card">
                                                                                                    <h4 class="table-avatar">
                                                                                                        <?php if ($like->user->profileFilepath != null && $like->user->profileFilename) : ?>
                                                                                                            <a href="/user/view/<?= $like->user->id ?>" class="avatar"><img src="<?= $like->user->profileFilepath ?>/<?= $like->user->profileFilename ?>" alt=""></a>
                                                                                                        <?php else : ?>
                                                                                                            <a href="/user/view/<?= $like->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                                                                                        <?php endif; ?>
                                                                                                        <a href="/user/view/<?= $like->user->id ?>"><?= $like->user->firstname ?> <?= $like->user->lastname ?>
                                                                                                        </a>
                                                                                                        </h2>
                                                                                                </div>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!---------------------------------------------------------------->
                                                                    </div>
                                                                </div>
                                                                <div class="comment-buttons">
                                                                    <a href="#reply_<?= $postcomment->id ?>" style="cursor: pointer;color:black" onclick="showreplyform(<?= $postcomment->id ?>);">Reply</a>
                                                                    <?php if (!empty($postcomment->postcommentlikes)) : ?>
                                                                        <?php
                                                                        $authusercommentlikes = array();
                                                                        foreach ($postcomment->postcommentlikes as $commentlike) {
                                                                            if ($commentlike->comment_id == $postcomment->id && $commentlike->isLiked == true && $commentlike->user_id == $authuser->id) {
                                                                                array_push($authusercommentlikes, $commentlike);
                                                                            }
                                                                        }
                                                                        ?>

                                                                        <?php if (!empty($authusercommentlikes)) : ?>
                                                                            <a class="liked-botton" id="commentlike_<?= $postcomment->id ?>" style="cursor: pointer;" onclick="addcommentlike(<?= $postcomment->id ?>,<?= $authuser->id ?>,<?= $post->id ?>)">Like</a>
                                                                        <?php else : ?>
                                                                            <a class="unliked-botton" id="commentlike_<?= $postcomment->id ?>" style="cursor: pointer;" onclick="addcommentlike(<?= $postcomment->id ?>,<?= $authuser->id ?>,<?= $post->id ?>)">Like</a>
                                                                        <?php endif; ?>

                                                                    <?php else : ?>
                                                                        <a class="unliked-botton" id="commentlike_<?= $postcomment->id ?>" style="cursor: pointer;" onclick="addcommentlike(<?= $postcomment->id ?>,<?= $authuser->id ?>,<?= $post->id ?>)">Like</a>
                                                                    <?php endif; ?>

                                                                </div>

                                                                <?php if ($postcomment->replies) : ?>

                                                                    <?php foreach ($postcomment->replies as $reply) : ?>
                                                                        <div class="replies-firstsection" style="margin-left: 5%;">
                                                                            <div class="dropdown kanban-action group-post">
                                                                                <a href="" data-toggle="dropdown">
                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_post_<?= $post->id ?>">Edit</a>
                                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_post_<?= $post->id ?>">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="replies-section" style="display: flex;">
                                                                                <div class="form-group">
                                                                                    <a href="#" data-toggle="tooltip" title="<?= $reply->user->firstname ?> <?= $reply->user->lastname ?>" style="width:7%">
                                                                                        <?php if ($reply->user->profileFilepath != null && $reply->user->profileFilename != null) : ?>
                                                                                            <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>" style="width:25px;">
                                                                                        <?php else : ?>
                                                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width: 26px;">
                                                                                        <?php endif; ?>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="form-control" style="border-radius: 24px;">
                                                                                    <span><?= $reply->user->firstname ?> <?= $reply->user->lastname ?></span>

                                                                                    <!------------------/Tagged people part for Comment------------------>

                                                                                    <?php if (!empty($reply->replytagmembers)) : ?>
                                                                                        <span style="color: rgb(34 32 32 / 50%);"> -in Reply to </span>
                                                                                        <?php foreach ($reply->replytagmembers as $tagmember) : ?>
                                                                                            <?php if ($reply->id == $tagmember->reply_id && $tagmember->isReply == true) : ?>
                                                                                                <a href="/user/view/<?= $tagmember->user->id ?>"><?= $tagmember->user->firstname ?> <?= $tagmember->user->lastname ?> </a>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endif; ?>
                                                                                    <!------------------/Tagged people part for Comment------------------>
                                                                                    <p><?= $reply->comment_data ?></p>

                                                                                    <?php if ($reply->replyfiles) : ?>
                                                                                        <?php foreach ($reply->replyfiles as $file) : ?>
                                                                                            <?php if ($reply->id == $file->reply_id) : ?>
                                                                                                <ul class="attach-list">
                                                                                                    <li><i class="fa fa-file"></i> <a href="/postcommentfiles/downloadfile/<?= $file->id ?>"><?= $file->filename ?></a></li>
                                                                                                </ul>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($reply->creation_date != null) : ?>
                                                                                        <span class="chat-time">Replied At <?= $reply->creation_date ?></span>
                                                                                    <?php endif; ?>

                                                                                </div>
                                                                            </div>
                                                                            <div class="row" style="height: 25px;">
                                                                                <div class="replieslikecount" id="replylikes_<?= $reply->id ?>">
                                                                                    <?php if (!empty($reply->replylikes)) : ?>
                                                                                        <span class="iconify" data-icon="uiw:like-o" style="color:blue;"></span>
                                                                                        <?= count($reply->replylikes) ?>
                                                                                        <a class="likedpeoples" data-toggle="modal" data-target="#reply_likedpeople_<?= $reply->id ?>">Peoples</a>
                                                                                    <?php endif; ?>

                                                                                </div>
                                                                            </div>
                                                                            <div class="reply-buttons">
                                                                                <a href="#reply_<?= $postcomment->id ?>" style="cursor: pointer;color:black" onclick="showreplyform(<?= $postcomment->id ?>);">Reply</a>
                                                                                <?php if (!empty($reply->replylikes)) : ?>
                                                                                    <?php
                                                                                    $authuserreplylikes = array();
                                                                                    foreach ($reply->replylikes as $replylike) {
                                                                                        if ($replylike->user_id == $authuser->id && $replylike->isLiked == true && $replylike->reply_id == $reply->id) {
                                                                                            array_push($authuserreplylikes, $replylike);
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                    <?php if (!empty($authuserreplylikes)) : ?>
                                                                                        <a id="replylike_<?= $reply->id ?>" style="cursor: pointer; color:blue" onclick="addreplylike(<?= $reply->id ?>, <?= $reply->post_id ?>)">Like</a>
                                                                                    <?php else : ?>
                                                                                        <a id="replylike_<?= $reply->id ?>" style="cursor: pointer; color:black" onclick="addreplylike(<?= $reply->id ?>, <?= $reply->post_id ?>)">Like</a>
                                                                                    <?php endif; ?>



                                                                                <?php else : ?>
                                                                                    <a class="unliked-botton" id="replylike_<?= $reply->id ?>" style="cursor: pointer; color:black" onclick="addreplylike(<?= $reply->id ?>, <?= $reply->post_id ?>)">Like</a>
                                                                                <?php endif; ?>


                                                                            </div>
                                                                        </div>
                                                                        <!--------------------Reply Liked Peoples------------------------------------------------->
                                                                        <div class="modal custom-modal fade" id="reply_likedpeople_<?= $reply->id ?>" role="dialog">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">

                                                                                    <div class="modal-body">
                                                                                        <div class="form-header">
                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                <span aria-hidden="true">&times;</span>
                                                                                            </button>
                                                                                            <h3>Members</h3>
                                                                                        </div>
                                                                                        <?php foreach ($reply->replylikes as $like) : ?>
                                                                                            <div class="card">
                                                                                                <h4 class="table-avatar">
                                                                                                    <?php if ($like->user->profileFilepath != null && $like->user->profileFilename) : ?>
                                                                                                        <a href="/user/view/<?= $like->user->id ?>" class="avatar"><img src="<?= $like->user->profileFilepath ?>/<?= $like->user->profileFilename ?>" alt=""></a>
                                                                                                    <?php else : ?>
                                                                                                        <a href="/user/view/<?= $like->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                                                                                    <?php endif; ?>
                                                                                                    <a href="/user/view/<?= $like->user->id ?>"><?= $like->user->firstname ?> <?= $like->user->lastname ?>
                                                                                                    </a>
                                                                                                    </h2>
                                                                                            </div>
                                                                                        <?php endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-------------------/Reply Liked Peoples---------------------------------------->

                                                                        </br>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>

                                                                <div class="reply-block" id="reply-block_<?= $postcomment->id ?>" style="display: none;margin-left: 5%;">
                                                                    <div class="row" style="padding: 10px;">
                                                                        <div class="form-group">
                                                                            <div style="display: flex;">
                                                                                <a href="#" data-toggle="tooltip" title="<?= $authuser->firstname ?> <?= $authuser->lastname ?>" style="width:7%">
                                                                                    <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                                                                        <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>" style="width:100% ;">
                                                                                    <?php else : ?>
                                                                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">
                                                                                    <?php endif; ?>
                                                                                </a>

                                                                                <div style="display: flex;">
                                                                                    <input class="form-control" type="text" id="reply_<?= $postcomment->id ?>" placeholder="Write a Reply..." style="border-radius: 20px;width:100%" onkeypress="onEnter(event, <?= $post->id ?>, <?= $authuser->id ?>, <?= $postcomment->id ?>)">
                                                                                    <span class="btn-file" style="padding:10px">
                                                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="reply_img_<?= $postcomment->id ?>" name="images" type="file" multiple />
                                                                                        <img src="/assets/img/upload.png" alt="" style="width: 20px;">
                                                                                    </span>
                                                                                </div>
                                                                                <div class="btn-file" style="padding:10px">
                                                                                    <a data-toggle="modal" data-target="#tagpeople">
                                                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images_<?= $post->id ?>" name="images" type="file" multiple />
                                                                                        <img src="/assets/img/group.png" alt="" style="width: 20px;">
                                                                                    </a>
                                                                                </div>

                                                                                <div class="btn-file" style="padding:10px">
                                                                                    <button type="submit" class="btn btn-info" onclick="postreply(<?= $post->id ?>, <?= $authuser->id ?>, <?= $postcomment->id ?>)">Post</button>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </br>
                                                            </div>


                                                            <!-- Edit Comment Modal -->
                                                            <div class="modal custom-modal " id="edit_comment_<?= $postcomment->id ?>" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">

                                                                        <div class="modal-body">
                                                                            <div class="form-header">
                                                                                <h3>Edit a Comment</h3>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <a href="#" data-toggle="tooltip" title="<?= $authuser->firstname ?> <?= $authuser->lastname ?>">
                                                                                    <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                                                                        <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>" style=" width: 10%;">
                                                                                    <?php else : ?>
                                                                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width: 10%;">
                                                                                    <?php endif; ?>
                                                                                </a>
                                                                                <label><?= $authuser->firstname ?> <?= $authuser->lastname ?></label>
                                                                                </br>

                                                                                <div class="form-control" contenteditable="true" id="editcomment_message_<?= $postcomment->id ?>"> <?= $postcomment->comment_data ?></div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <?= $this->Form->control('editcommentfiles.',  ['type' => 'file', 'id' => 'editcommentfiles', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <button style="width: 100%;" type="submit" onclick="updatecomment(<?= $postcomment->id ?>,<?= $postcomment->group_id ?>,<?= $postcomment->post_id ?>,<?= $authuser->id ?>)" class="btn btn-primary continue-btn">post</button>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /Edit Comment Modal ---->

                                                            <!-- Delete Comment Modal -->
                                                            <div class="modal custom-modal " id="delete_comment_<?= $postcomment->id ?>" role="dialog">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="form-header">
                                                                                <h3>Delete Comment</h3>
                                                                                <p>Are you sure want to delete?</p>
                                                                            </div>
                                                                            <div class="modal-btn delete-action">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <a href="/postcomments/deletecomment/<?= $postcomment->id ?>" class="btn btn-primary continue-btn">Delete</a>
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
                                                            <!-- /Delete Comment Modal ---->

                                                        <?php endforeach; ?>
                                                    </div>

                                                    <div class="input-block">
                                                        <div style="padding: 10px;display:flex;">
                                                            <div>
                                                                <a href="#" data-toggle="tooltip" title="<?= $authuser->firstname ?> <?= $authuser->lastname ?>" style="width:7%">
                                                                    <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                                                        <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>" style="width:26px ;">
                                                                    <?php else : ?>
                                                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:26px ;">
                                                                    <?php endif; ?>
                                                                </a>
                                                            </div>
                                                            <div class="postmessage-form" id="toggablecommentdiv" style="width:100%">
                                                                <div>
                                                                    <textarea class="form-control" type="text" placeholder="Write Something..." name="post_message" id="msg_<?= $post->id ?>" onclick="toggledcommentdiv(<?= $post->id ?>)" onkeypress="onEnter(event, <?= $post->id ?>, <?= $authuser->id ?>)"></textarea>
                                                                </div>

                                                                <div class="form-group form-focus select-focus m-b-30 tagpeoplecommentdiv" style="display: none;">
                                                                    <img id="input_img" src="/assets/img/group.png" alt="" style="width: 20px;">
                                                                    <select id="tagusers1" class="select2-icon floating" name="tagedusers[]" multiple style="width: 76%;">
                                                                        <?php foreach ($groupmembers as $groupmember) : ?>
                                                                            <option style="padding-left:30px" value="<?= $groupmember->user->id ?>"><?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>

                                                                    <span class="btn-file" style="padding:10px">
                                                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images_<?= $post->id ?>" name="images" type="file" multiple />
                                                                        <img src="/assets/img/upload.png" alt="" style="width: 20px;">
                                                                    </span>
                                                                    <button type="submit" class="btn btn-info" onclick="postcomment(<?= $post->id ?>, <?= $authuser->id ?>)">Post</button>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-----Tag People--------->
                                                <div class="modal custom-modal fade" id="tagpeople" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">

                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Tag Members</h3>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="form-group form-focus select-focus m-b-30">
                                                                    <label for="tagusers"><?= __('Tag User') ?> <span class="text-danger">*</span></label>
                                                                    <select class="select2-icon floating" name="users" multiple>

                                                                        <?php foreach ($groupmembers as $groupmember) : ?>
                                                                            <option value="<?= $groupmember->user->id ?>"><?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <button style="width: 100%;" type="button" data-dismiss="modal" class="btn btn-primary continue-btn">Add people</button>
                                                                        <input type="hidden" name="groupId" value="<?= $group->id ?>">
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!----------/Tag People----------------->

                                                <!-- Delete Post Modal -->
                                                <div class="modal custom-modal fade" id="delete_post_<?= $post->id ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Delete Post</h3>
                                                                    <p>Are you sure want to delete?</p>
                                                                </div>
                                                                <div class="modal-btn delete-action">
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <a href="/groupposts/deletepost/<?= $post->id ?>" class="btn btn-primary continue-btn">Delete</a>
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
                                                <!-- /Delete Post Modal ---->

                                                <!-- Edit Post Modal -->
                                                <div class="modal custom-modal fade" id="edit_post_<?= $post->id ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">

                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <h3>Edit a post</h3>
                                                                </div>
                                                                <div class="form-group">
                                                                    <a href="#" data-toggle="tooltip" title="<?= $authuser->firstname ?> <?= $authuser->lastname ?>">
                                                                        <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                                                            <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>" style=" width: 10%;">
                                                                        <?php else : ?>
                                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width: 10%;">
                                                                        <?php endif; ?>
                                                                    </a>
                                                                    <label><?= $authuser->firstname ?> <?= $authuser->lastname ?></label>
                                                                    </br>

                                                                    <div class="form-control" contenteditable="true" id="editpost_message"> <?= $post->post_data ?></div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?= $this->Form->control('editimages.',  ['type' => 'file', 'id' => 'editimages', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <button style="width: 100%;" type="submit" onclick="updatepost(<?= $post->id ?>,<?= $post->group_id ?>,<?= $authuser->id ?>)" class="btn btn-primary continue-btn">post</button>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /Edit Post Modal ---->
                                            </div>
                                        <?php endforeach; ?>
                                    </section>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="filter_posts">
                                    <a class="btn btn-light" data-toggle="dropdown"><img style="width: 25px; float:right" src="/assets/img/filter.png" alt=""></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="/groups/postscreationdate_asc/<?= $group->id ?>">Post Creation Date Ascending Order</a>
                                        <a class="dropdown-item" href="/groups/postscreationdate_desc/<?= $group->id ?>">Post Creation Date Descending Order</a>
                                        <a class="dropdown-item" href="/groups/postsupdate_asc/<?= $group->id ?>">Post Last Update Date Ascending Order</a>
                                        <a class="dropdown-item" href="/groups/postsupdate_desc/<?= $group->id ?>"> Post Last Update Date Descending Order</a>
                                        <a class="dropdown-item" href="/groups/postsalphabets_asc/<?= $group->id ?>"> Post Alphabets Ascending Order</a>
                                        <a class="dropdown-item" href="/groups/postsalphabets_desc/<?= $group->id ?>"> Post Alphabets Descending Order</a>
                                    </div>
                                </div>
                                <div class="group-members">
                                    <p>Admin </p>
                                    <hr>
                                    <?php foreach ($group->groupmembers as $groupmember) : ?>
                                        <?php if ($groupmember->member_role == 'Y') : ?>
                                            <div class="avatar">
                                                <img data-toggle="tooltip" title="<?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" <?php if ($groupmember->user->profileFilepath != null &&  $groupmember->user->profileFilename != null) : ?> src="<?= $groupmember->user->profileFilepath ?>/<?= $groupmember->user->profileFilename ?>" <?php else : ?> src="/assets/img/profiles/avatar-12.jpg">
                                            <?php endif; ?>

                                            >
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <a href="/groups/groupmembers/<?= $group->id ?>" class="btn btn-light"> <i class="fa fa-eye"></i> View All</a>
                                </div>


                                <div class="group-members">
                                    <p>Group Members <span>(<?= count($group->groupmembers) ?>)</span></p>
                                    <hr>
                                    <?php foreach ($group->groupmembers as $groupmember) : ?>
                                        <div class="avatar">
                                            <img data-toggle="tooltip" title="<?= $groupmember->user->firstname ?> <?= $groupmember->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" <?php if ($groupmember->user->profileFilepath != null &&  $groupmember->user->profileFilename != null) : ?> src="<?= $groupmember->user->profileFilepath ?>/<?= $groupmember->user->profileFilename ?>" <?php else : ?> src="/assets/img/profiles/avatar-12.jpg">
                                        <?php endif; ?>
                                        >
                                        </div>
                                    <?php endforeach; ?>
                                    <a href="/groups/groupmembers/<?= $group->id ?>" class="btn btn-light"> <i class="fa fa-eye"></i> View All</a>
                                </div>
                                </br>
                                <?php if (!empty($clients)) : ?>
                                    <div class="clients">
                                        <p>Clients <span>(<?= count($clients) ?>)</span></p>
                                        <hr>
                                        <?php foreach ($clients as $client) : ?>
                                            <div class="avatar">
                                                <img data-toggle="tooltip" title="<?= $client->user->firstname ?> <?= $client->user->lastname ?>" class="avatar-img rounded-circle border border-white" alt="User Image" <?php if ($client->user->profileFilepath != null &&  $client->user->profileFilename != null) : ?> src="<?= $client->user->profileFilepath ?>/<?= $client->user->profileFilename ?>" <?php else : ?> src="/assets/img/profiles/avatar-12.jpg">
                                            <?php endif; ?>
                                            >
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- /Page Wrapper -->
<script>
    function onEnter(e, postid, userid, commentid = null) {
        console.log(commentid, 'commentid');
        console.log(e.which);
        if (e.which === 13) {
            e.preventDefault();
            if (commentid != null) {

                postreply(postid, userid, commentid);
            } else {
                postcomment(postid, userid);
            }
        }
    }

    function postliked(postid, userid) {

        $.ajax({
            url: '/groupposts/updatelikes',
            method: 'post',
            dataType: 'json',
            data: {
                'postid': postid,
                'userid': userid,

            },
            success: function(data) {
                $('#postlikes_' + postid).empty();

                if (data['count'] != 0) {
                    var str = '<span class="iconify" data-icon="uiw:like-o" style="color: blue;"></span>' + data['count'];
                }
                //  location.reload();
                if (data['likes'].isLiked == true) {

                    $("#check_like_" + postid).attr("style", "color: blue;");
                } else {
                    $("#check_like_" + postid).attr("style", "color: black;");

                }
                $('#postlikes_' + postid).html(str);
            },
            error: function() {

            }
        });
    }

    function postcomment(postid, userid) {
        msg = $('#msg_' + postid).val();

        var file_data = $("#images_" + postid).prop("files");
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = userid;
        }

        form_data.append("msg", msg);
        //  form_data.append("commentid", commentid);
        form_data.append("postid", postid);
        form_data.append("isFileNotAttached", isFileNotAttached);

        $.ajax({
            url: '/postcomments/sendcomment/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                $('#cmts_' + postid).empty();
                var str = "";
                data.forEach((postcomment) => {
                    str += '<div class="comment-section">' +
                        '<div class="inner-commentsection" style="display: flex;">' +
                        '<div class="form-group">' +
                        '<a href="#" data-toggle="tooltip" title="' + postcomment.user.firstname + ' ' + postcomment.user.lastname + '" style="width:7%">';
                    if (postcomment.user.profileFilepath != null && postcomment.user.profileFilename != null) {
                        str += '<img alt="" src="' + postcomment.user.profileFilepath + '/' + postcomment.user.profileFilename + '" style="width:25px;">';
                    } else {
                        str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                    }
                    str += '</a>' +
                        '</div>' +
                        '<div class="form-control" style="border-radius: 24px;">' +
                        '<span>' + postcomment.user.firstname + '  ' + postcomment.user.lastname + '</span>' +
                        '</br>' +
                        '<p>' + postcomment.comment_data + '</p>';
                    if (postcomment.postcommentfiles) {
                        postcomment.postcommentfiles.forEach((file) => {
                            str += '<ul class="attach-list">' +
                                '<li><i class="fa fa-file"></i> <a href="/postcommentfiles/downloadfile/' + file.id + '">' + file.filename + '</a></li>' +
                                '</ul>';
                        });
                    }
                    str += '</div>' +
                        '</div>' +
                        '<div class="comment-buttons">' +

                        '<a href="">Like</a> <a style="cursor: pointer;" onclick="showreplyform(' + postcomment.id + ');">Reply</a>' +
                        '</div>';

                    if (postcomment.replies) {
                        postcomment.replies.forEach((reply) => {
                            str += '<div class="replies-firstsection" style="margin-left: 5%;">' +
                                '<div class="replies-section" style="display: flex;">' +
                                '<div class="form-group">' +
                                '<a href="#" data-toggle="tooltip" title="' + reply.user.firstname + ' ' + reply.user.lastname + '" style="width:7%">';
                            if (reply.user.profileFilepath != null && reply.user.profileFilename != null) {
                                str += '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + '" style="width:25px;">';
                            } else {
                                str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                            }
                            str += '</a>' +
                                '</div>' +
                                '<div class="form-control" style="border-radius: 24px;">' +
                                '<span>' + reply.user.firstname + ' ' + reply.user.lastname + '</span>' +
                                '<p>' + reply.comment_data + '</p>' +
                                '</div>' +
                                '</div>' +
                                '<div class="comment-buttons">' +
                                '<a style="cursor: pointer;">Like</a> <a href="#reply_' + postcomment.id + '" style="cursor: pointer;color:black" onclick="showreplyform(' + postcomment.id + ');">Reply</a>' +
                                '</div>' +
                                '</div>' +
                                '</br>';
                        });
                    }
                    str += '<div class="reply-block" id="reply-block_' + postcomment.id + '" style="display: none;margin-left: 5%;">' +
                        '<div class="row" style="padding: 10px;">' +
                        '<div class="form-group">' +
                        '<div style="display: flex;">' +
                        '<a href="#" data-toggle="tooltip" title="' + postcomment.user.firstname + '  ' + postcomment.user.lastname + '" style="width:7%">';
                    if (postcomment.user.profileFilepath != null && postcomment.user.profileFilename != null) {
                        str += '<img alt="" src="' + postcomment.user.profileFilepath + '/' + postcomment.user.profileFilename + '" style="width:100% ;">';
                    } else {
                        str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                    }
                    console.log(postcomment.id, 'commentid');
                    str += '</a>' +
                        '<div style="display: flex;">' +
                        '<input class="form-control" type="text" id="reply_' + postcomment.id + '" placeholder="Write a Reply..." style="border-radius: 20px;width:100%" onkeypress="onEnter(event, ' + postcomment.post_id + ', ' + postcomment.user_id + ',' + postcomment.id + ')">' +
                        '<span class="btn-file" style="padding:10px">' +
                        '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="reply_img_' + postcomment.id + '" name="images" type="file" multiple />' +
                        '<img src="/assets/img/upload.png" alt="" style="width: 20px;">' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</br>' +
                        '</div>';
                });

                $('#cmts_' + postid).html(str);
                $('#msg_' + postid).val("");


            },
            error: function(data) {}
        });
    }



    function postreply(postid, userid, commentid) {
        msg = $('#reply_' + commentid).val();
        var file_data = $("#reply_img_" + commentid).prop("files");
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = userid;
        }
        form_data.append("msg", msg);
        form_data.append("postid", postid);
        form_data.append("commentid", commentid);
        form_data.append("isFileNotAttached", isFileNotAttached);

        $.ajax({
            url: '/postcomments/sendcomment/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                $('#cmts_' + postid).empty();
                var str = "";

                data.forEach((postcomment) => {

                    str += '<div class="comment-section">' +
                        '<div class="inner-commentsection" style="display: flex;">' +
                        '<div class="form-group">' +
                        '<a href="#" data-toggle="tooltip" title="' + postcomment.user.firstname + ' ' + postcomment.user.lastname + '" style="width:7%">';
                    if (postcomment.user.profileFilepath != null && postcomment.user.profileFilename != null) {
                        str += '<img alt="" src="' + postcomment.user.profileFilepath + '/' + postcomment.user.profileFilename + '" style="width:25px;">';
                    } else {
                        str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                    }
                    str += '</a>' +
                        '</div>' +
                        '<div class="form-control" style="border-radius: 24px;">' +
                        '<span>' + postcomment.user.firstname + '  ' + postcomment.user.lastname + '</span>' +
                        '</br>' +
                        '<p>' + postcomment.comment_data + '</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="comment-buttons">' +
                        '<a style="cursor: pointer;">Like</a> <a href="#reply_' + postcomment.id + '" style="cursor: pointer;" onclick="showreplyform(' + postcomment.id + ');">Reply</a>' +
                        '</div>';
                    if (postcomment.replies) {
                        postcomment.replies.forEach((reply) => {
                            str += '<div class="replies-firstsection" style="margin-left: 5%;">' +
                                '<div class="replies-section" style="display: flex;">' +
                                '<div class="form-group">' +
                                '<a href="#" data-toggle="tooltip" title="' + reply.user.firstname + ' ' + reply.user.lastname + '" style="width:7%">';
                            if (reply.user.profileFilepath != null && reply.user.profileFilename != null) {
                                str += '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + '" style="width:25px;">';
                            } else {
                                str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                            }
                            str += '</a>' +
                                '</div>' +
                                '<div class="form-control" style="border-radius: 24px;">' +
                                '<span>' + reply.user.firstname + ' ' + reply.user.lastname + '</span>' +
                                '<p>' + reply.comment_data + '</p>' +
                                '</div>' +
                                '</div>' +
                                '<div class="comment-buttons">' +
                                '<a style="cursor: pointer;">Like</a> <a href="#reply_' + postcomment.id + '" style="cursor: pointer;color:black" onclick="showreplyform(' + postcomment.id + ');">Reply</a>' +
                                '</div>' +
                                '</div>' +
                                '</br>';
                        });
                    }

                    if (postcomment.replies) {
                        postcomment.replies.forEach((reply) => {
                            str += '<div class="replies-firstsection" style="margin-left: 5%;">' +
                                '<div class="replies-section" style="display: flex;">' +
                                '<div class="form-group">' +
                                '<a href="#" data-toggle="tooltip" title="' + reply.user.firstname + ' ' + reply.user.lastname + '" style="width:7%">';
                            if (reply.user.profileFilepath != null && reply.user.profileFilename != null) {
                                str += '<img alt="" src="' + reply.user.profileFilepath + '/' + reply.user.profileFilename + '" style="width:25px;">';
                            } else {
                                str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                            }
                            str += '</a>' +
                                '</div>' +
                                '<div class="form-control" style="border-radius: 24px;">' +
                                '<span>' + reply.user.firstname + ' ' + reply.user.lastname + '</span>' +
                                '<p>' + reply.comment_data + '</p>' +
                                '</div>' +
                                '</div>' +
                                '<div class="comment-buttons">' +
                                '<a style="cursor: pointer;">Like</a> <a href="#reply_' + postcomment.id + '" style="cursor: pointer;color:black" onclick="showreplyform(' + postcomment.id + ');">Reply</a>' +
                                '</div>' +
                                '</div>' +
                                '</br>';
                        });
                    }
                    str += '<div class="reply-block" id="reply-block_' + postcomment.id + '"  style="display: none;margin-left: 5%;">' +
                        '<div class="row" style="padding: 10px;">' +
                        '<div class="form-group">' +
                        '<div style="display: flex;">' +
                        '<a href="#" data-toggle="tooltip" title="' + postcomment.user.firstname + '  ' + postcomment.user.lastname + '" style="width:7%">';
                    if (postcomment.user.profileFilepath != null && postcomment.user.profileFilename != null) {
                        str += '<img alt="" src="' + postcomment.user.profileFilepath + '/' + postcomment.user.profileFilename + '" style="width:100% ;">';
                    } else {
                        str += '<img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">';
                    }
                    str += '</a>' +
                        '<div style="display: flex;">' +
                        '<input class="form-control" type="text" id="' + postcomment.id + '" placeholder="Write Something..." style="border-radius: 20px;width:100%" onkeypress="onEnter(event, ' + postcomment.post_id + ', ' + postcomment.user_id + ',' + postcomment.id + ')">' +
                        '<span class="btn-file" style="padding:10px">' +
                        '<input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="" name="images" type="file" multiple />' +
                        '<img src="/assets/img/upload.png" alt="" style="width: 20px;">' +
                        '</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</br>' +
                        '</div>';

                });

                $('#cmts_' + postid).html(str);
                $('#msg_' + postid).val('');


            },
            error: function(data) {}
        });
    }

    function addcommentlike(commentid, userid, postid) {
        console.log(commentid, 'CommentId');
        $.ajax({
            url: '/postcommentlikes/updatecommentlikes',
            method: 'post',
            dataType: 'json',
            data: {
                'commentid': commentid,
                'postid': postid
            },
            success: function(data) {

                $('#commentlikes_' + commentid).empty();
                if (data['count'] != 0) {
                    var str = '<span class="iconify" data-icon="uiw:like-o" style="color: blue;"></span>' + data['count'];
                }
                if (data['commentlikes'].isLiked == true) {
                    $("#commentlike_" + commentid).attr("style", "color: blue;");
                } else {
                    $("#commentlike_" + commentid).attr("style", "color: black;");
                }


                $('#commentlikes_' + commentid).html(str);
            },
            error: function(a, b, c) {
                console.log(a);
                console.log(b);
                console.log(c);
            }
        });
    }

    function addFavourite(postid, userid, group_id) {
        $.ajax({
            url: '/groupposts/addfavourite',
            method: 'post',
            dataType: 'json',
            data: {
                'postid': postid,
                'userid': userid,

            },
            success: function(data) {
                location.reload();

                console.log(data['favourite']);
                if (data['favourite'] != null) {
                    $('#add_favourite_' + postid).attr("style", "color: blue;");
                } else {
                    $('#add_favourite_' + postid).attr("style", "color: black;");
                }

            },
            error: function() {

            }
        });

    }



    function showreplyform(commentid) {
        $('#reply-block_' + commentid).show();
    }
</script>
