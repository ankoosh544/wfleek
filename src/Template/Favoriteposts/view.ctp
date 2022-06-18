<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Favoritepost $favoritepost
 */
?>
<?php

use Cake\I18n\Number;
?>
<style>
    /* modal backdrop fix */
    .modal-backdrop {
        visibility: hidden !important;
    }

    .modal.in {
        background-color: rgba(0, 0, 0, 0.5);
    }

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

    .likebuttoncss {
        cursor: pointer;
        padding: 10px;

    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<a href="https://www.flaticon.com/free-icons/like" title="like icons">Like icons created by Freepik - Flaticon</a>
<script src="https://code.iconify.design/2/2.1.1/iconify.min.js"></script>

<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">


        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="">
                            <section>
                                <h5 class="dash-title"></h5>
                                <?php if (!empty($myfavoriteposts)) : ?>
                                    <?php foreach ($myfavoriteposts as $post) : ?>

                                        <div class="card" style="width:100%;">
                                            <div class="card-body">
                                                <?php if ($post->post->user_id == $authuser->id || $group->creatorId == $authuser->id) : ?>
                                                    <div class="dropdown kanban-action group-post">
                                                        <a href="" data-toggle="dropdown">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_post_<?= $post->post->id ?>">Edit</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_post_<?= $post->post->id ?>">Delete</a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="form-group">
                                                    <a href="#" data-toggle="tooltip" title="<?= $post->post->user->firstname ?> <?= $post->post->user->lastname ?>">
                                                        <?php if ($post->post->user->profileFilepath != null && $post->post->user->profileFilename != null) : ?>
                                                            <img alt="" src="<?= $post->post->user->profileFilepath ?>/<?= $post->post->user->profileFilename ?>" style=" width: 7%;">
                                                        <?php else : ?>
                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width: 10%;">
                                                        <?php endif; ?>

                                                    </a>
                                                    <label><?= $post->post->user->firstname ?> <?= $post->post->user->lastname ?>

                                                        <!----------------Sharred file part---------------------->
                                                        <?php if ($post->post->isShared == true) : ?> <span style="color: rgb(34 32 32 / 50%);"> - Sharred a File </span><?php endif; ?>
                                                        <!----------------/Sharred file part---------------------->


                                                        <!---------------------Tagged people part------------------>
                                                        <?php if (!empty($post->post->groupposttagmembers)) : ?>
                                                            <span style="color: rgb(34 32 32 / 50%);"> - is Tagged </span>
                                                            <?php foreach ($post->post->groupposttagmembers as $tagmember) : ?>
                                                                <?php if ($tagmember->isPost == true) : ?>
                                                                    <a href="/user/view/<?= $tagmember->user->id ?>"><?= $tagmember->user->firstname ?> <?= $tagmember->user->lastname ?> </a>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        <!------------------/Tagged people part------------------>
                                                        <?php if ($post->post->creation_date != null) : ?>
                                                            <span class="chat-time">Posted At <?= $post->post->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?> </span>
                                                        <?php endif; ?>
                                                    </label>
                                                    </br>
                                                    <div class="post-area">


                                                        <p>
                                                            <?php if($post->post->groupnote == null): ?>
                                                            <?= $post->post->post_data ?>
                                                            <?php else: ?>

                                                                <?= $post->post->groupnote->post_data ?>
                                                                <?php endif ; ?>

                                                        </p>
                                                    </div>
                                                    <?php if ($post->post->grouppostfiles) : ?>
                                                        <div class="post-files">
                                                            <?php foreach ($post->post->grouppostfiles as $file) : ?>
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
                                                    <div class="likecount" id="postlikes_<?= $post->post->id ?>">

                                                        <?php if (!empty($post->post->postlikes)) : ?>
                                                            <span class="iconify" data-icon="akar-icons:heart" style="color:blue;"></span> </span>
                                                            <?= count($post->post->postlikes) ?>

                                                            <a style=" text-decoration: underline;cursor: pointer; color:blue" data-toggle="modal" data-target="#post_likedpeople_<?= $post->post->id ?>" style="cursor: pointer;">Peoples</a>

                                                        <?php endif; ?>


                                                    </div>
                                                </div>

                                                <!------------Post Liked peoples------------------------------>

                                                <div class="modal custom-modal fade" id="post_likedpeople_<?= $post->post->id ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="form-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <span>Members(<?= count($post->post->postlikes) ?>)</span>
                                                                </div>
                                                                <?php foreach ($post->post->postlikes as $like) : ?>
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

                                                <div class="comments-mainsection" id="cmts_<?= $post->post->id ?>">
                                                    <?php if (!empty($post->post->postcomments)) : ?>
                                                        <?php foreach ($post->post->postcomments as $postcomment) : ?>
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
                                                                                <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">
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
                                                                            <span class="iconify" data-icon="akar-icons:heart" style="color:blue;"></span>
                                                                            <?= count($postcomment->postcommentlikes) ?>

                                                                            <a data-toggle="modal" data-target="#comment_likedpeople_<?= $postcomment->id ?>" style="cursor: pointer;text-decoration: underline;color:blue">Peoples</a>


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
                                                                        </br>
                                                                        <!---------------------------------------------------------------->

                                                                    </div>
                                                                </div>

                                                                <?php if ($postcomment->replies) : ?>
                                                                    <?php foreach ($postcomment->replies as $reply) : ?>
                                                                        <div class="replies-firstsection" style="margin-left: 5%;">
                                                                            <div class="dropdown kanban-action group-post">
                                                                                <a href="" data-toggle="dropdown">
                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                </a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_reply_<?= $reply->id ?>">Edit</a>
                                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_reply_<?= $reply->id ?>">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="replies-section" style="display: flex;">
                                                                                <div class="form-group">
                                                                                    <a href="#" data-toggle="tooltip" title="<?= $reply->user->firstname ?> <?= $reply->user->lastname ?>" style="width:7%">
                                                                                        <?php if ($reply->user->profileFilepath != null && $reply->user->profileFilename != null) : ?>
                                                                                            <img alt="" src="<?= $reply->user->profileFilepath ?>/<?= $reply->user->profileFilename ?>" style="width:25px;">
                                                                                        <?php else : ?>
                                                                                            <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">
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
                                                                                        <span class="iconify" data-icon="akar-icons:heart" style="color: blue;"></span>
                                                                                        <?= count($reply->replylikes) ?>
                                                                                        <a data-toggle="modal" data-target="#reply_likedpeople_<?= $reply->id ?>" style="cursor: pointer;">Peoples</a>
                                                                                    <?php endif; ?>
                                                                                </div>
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
                                                                        <!-----*------------- Edit Reply Modal ---------------------------------->
                                                                        <div class="modal custom-modal " id="edit_reply_<?= $reply->id ?>" role="dialog">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">

                                                                                    <div class="modal-body">
                                                                                        <div class="form-header">
                                                                                            <h3>Edit a Reply</h3>
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

                                                                                            <div class="form-control" contenteditable="true" id="editreply_message_<?= $reply->id ?>"> <?= $reply->comment_data ?></div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <?= $this->Form->control('editcommentfiles.',  ['type' => 'file', 'id' => 'editcommentfiles', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-6">
                                                                                                <button style="width: 100%;" type="submit" onclick="updatereply(<?= $reply->id ?>,<?= $reply->group_id ?>,<?= $reply->post_id ?>,<?= $authuser->id ?>)" class="btn btn-primary continue-btn">Update</button>
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

                                                                        </br>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
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
                                                    <?php endif; ?>
                                                </div>
                                            </div>


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

                                                                <div class="form-control" contenteditable="true" id="editpost_message"> <?= nl2br($post->post_data) ?></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <?= $this->Form->control('editimages.',  ['type' => 'file', 'id' => 'editimages', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <button style="width: 100%;" type="submit" onclick="updatepost(<?= $post->id ?>,<?= $post->group_id ?>)" class="btn btn-primary continue-btn">post</button>
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
                                <?php endif; ?>
                            </section>

                        </div>
                    </div>

                </div>
            </div>
        </div>




    </div>
</div>

<script type="text/javascript">
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };
    $('.select2-icon').select2({
        width: "50%",
        templateSelection: formatText,
        templateResult: formatText
    });



    function updatepost(postid, group_id) {
        editpost_message = $('#editpost_message').text();

        var file_data = $('#editimages').prop('files');
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }

        } else {
            isFileNotAttached = 123;
        }
        form_data.append("postid", postid);
        form_data.append("isFileNotAttached", isFileNotAttached);
        form_data.append("editpost_message", editpost_message);

        $.ajax({
            url: '/groupposts/updatepost',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                console.log(data);
                window.location = '/favoriteposts/view/';
            },

            error: function(e) {
                console.log(e);


            }
        });


    }




    function updatecomment(comment_id, group_id, postid, userid) {
        editcomment_message = $('#editcomment_message_' + comment_id).text();

        var file_data = $('#editcommentfiles').prop('files');
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }

        } else {
            isFileNotAttached = 123;
        }
        form_data.append("comment_id", comment_id);
        form_data.append("isFileNotAttached", isFileNotAttached);
        form_data.append("editcomment_message", editcomment_message);

        $.ajax({
            url: '/postcomments/updatecomment',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                window.location = '/favoriteposts/view/';

            },

            error: function(e) {
                console.log(e);


            }
        });


    }

    function updatereply(reply_id, group_id, postid, userid) {
        editcomment_message = $('#editreply_message_' + reply_id).text();

        var file_data = $('#editcommentfiles').prop('files');
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }

        } else {
            isFileNotAttached = 123;
        }
        form_data.append("reply_id", reply_id);
        form_data.append("isFileNotAttached", isFileNotAttached);
        form_data.append("editcomment_message", editcomment_message);

        $.ajax({
            url: '/postcomments/updatecomment',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                window.location = '/favoriteposts/view/';

            },

            error: function(e) {
                console.log(e);


            }
        });


    }
</script>
