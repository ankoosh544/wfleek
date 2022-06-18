<?php

use Cake\I18n\Number;
?>


<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <div class="card mb-0" style="background-color: cadetblue;">
            <div class="card-body">




                <div class="row">
                    <!-- <div class="col-md-6">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#">

                                    <img alt="" src="/assets/img/profiles/avatar-16.jpg">

                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <h3><?= $group->name ?></h3>
                        </br>
                        <div class="form-group">
                            <div style="display: flex;">
                                <a href="#" data-toggle="tooltip" title="<?= $authuser->firstname ?> <?= $authuser->lastname ?>" style="width:5%">
                                    <?php if ($authuser->profileFilepath != null && $authuser->profileFilename != null) : ?>
                                        <img alt="" src="<?= $authuser->profileFilepath ?>/<?= $authuser->profileFilename ?>" style="width:100% ;">
                                    <?php else : ?>
                                        <img alt="" src="/assets/img/profiles/avatar-16.jpg" style="width:100% ;">
                                    <?php endif; ?>
                                </a>
                                <a data-toggle="modal" data-target="#create_post"><input class="form-control" type="text" placeholder="Write Something..." style="border-radius: 20px;width:100%"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-tabs nav-tabs-bottom">

                            <li class="nav-item "><a class="nav-link" href="/groups/view/<?= $group->id ?>"> All Conversation</a></li>
                            <li class="nav-item"><a class="nav-link" href="/groups/groupmembers/<?= $group->id ?>">Members</a></li>
                            <li class="nav-item"><a class="nav-link" href="/groups/companygroups/<?= $group->id ?>">Groups</a></li>
                            <li class="nav-item"><a class="nav-link active" href="/groups/files/<?= $group->id ?>">Files</a></li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </nav>
            </div>
            <div class="modal custom-modal fade" id="create_post" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="/groupposts/add/" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Create a post</h3>
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

                                    <textarea class="form-control" type="text" placeholder="Write Something..." name="post_message"></textarea>
                                </div>
                                <div class="form-group">
                                    <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <button style="width: 100%;" type="submit" class="btn btn-primary continue-btn">post</button>
                                        <input type="hidden" name="groupId" value="<?= $group->id ?>">
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding: 22px;">
            <div class="col-11">
                <button type="button" data-toggle="modal" data-target="#upload_file" class="btn btn-secondary"> <i class="fa fa-upload m-r-5"></i> Upload</button>
            </div>
            <div>
                <a class="btn btn-light" data-toggle="dropdown"><img style="width: 25px; float:right" src="/assets/img/filter.png" alt=""></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/groups/files/<?=$group->id?>">All File Types</a>
                    <a class="dropdown-item" href="/groups/documentfiles/<?=$group->id?>">Documents</a>
                    <a class="dropdown-item" href="/groups/imagefiles/<?=$group->id?>">Images</a>
                    <a class="dropdown-item" href="/groups/videofiles/<?=$group->id?>"> Videos</a>
                </div>
            </div>
        </div>

        <!----------------------File upload Modal----------------------------------------->

        <div class="modal custom-modal fade" id="upload_file" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="/grouppostfiles/uploadfile/" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-header">
                                <h3>Upload Files</h3>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button style="width: 100%;" type="submit" class="btn btn-primary continue-btn">post</button>
                                    <input type="hidden" name="groupId" value="<?= $group->id ?>">
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!------------------------------------------------------------------>


        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable">
                        <thead>
                            <tr>
                                <th>#Id</th>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Creator</th>
                                <th>Uploaded Date</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                                <?php foreach ($videofiles as $file) : ?>
                                    <?php if ($file->isDeleted == false) : ?>

                                        <?php $ext = (new SplFileInfo($file->filename))->getExtension(); ?>
                                        <tr>
                                            <td><?= $file->id ?></td>
                                            <td>
                                                <a href="/grouppostfiles/downloadfile/<?= $file->id ?>"><?= $file->filename ?></a>
                                            </td>
                                            <td><?= Number::toReadableSize($file->size); ?></td>

                                            <td><?= $file->type ?></td>


                                            <td>
                                                <h2 class="table-avatar">
                                                    <?php if ($file->user->profileFilepath != null && $file->user->profileFilename) : ?>
                                                        <a href="/project-member/userprofile/<?= $file->user->id ?>" class="avatar"><img src="<?= $file->user->profileFilepath ?>/<?= $file->user->profileFilename ?>" alt=""></a>
                                                    <?php else : ?>
                                                        <a href="/project-member/userprofile/<?= $file->user->id ?>" class="avatar"><img src="/assets/img/profiles/avatar-21.jpg" alt=""></a>
                                                    <?php endif; ?>
                                                    <a href="profile.html"><?= $file->user->firstname ?> <?= $file->user->lastname ?>

                                                    </a>
                                                </h2>
                                            </td>
                                            <td><?= $file->creation_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?></td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_file_<?= $file->id ?>_<?= $group->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>





                                        <!-- Delete File Modal -->
                                        <div class="modal" id="delete_file_<?= $file->id ?>_<?= $group->id ?>" role="dialog" style="z-index: 999 important!;">
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
                                                                    <a href="/grouppostfiles/deletefile?fileId=<?= $file->id ?>&groupId=<?= $group->id ?>" class="btn btn-primary continue-btn">Delete</a>
                                                                </div>
                                                                <div class="col-6">
                                                                    <a href="javascript:void(0);" onclick="closedeletealertModal(<?= $file->id ?>,<?= $group->id ?>)" class="btn btn-primary cancel-btn">Cancel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete file Modal -->
                                    <?php endif; ?>

                                <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>


</script>
