<?php

use Cake\I18n\Number;
?>
<style>
    .group-post {
        float: right;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<a href="https://www.flaticon.com/free-icons/like" title="like icons">Like icons created by Freepik - Flaticon</a>
<script src="https://code.iconify.design/2/2.1.1/iconify.min.js"></script>

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
                    <li class="nav-item"><a class="nav-link " href="/groups/companygroups/<?= $group->id ?>">Groups</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/groups/files/<?= $group->id ?>">Files</a></li>
                    <li class="nav-item"><a class="nav-link" href="/groups/notes/<?= $group->id ?>">Notes</a></li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="GET" action="/groups/searchdata/<?= $group->id ?>">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchkey">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
         <!-- Update Group background image -->
         <?= $this->element('updategroup_backgroundimage') ?>
        <!---/Update Group background image-->

        <div class="row" style="padding: 22px;">
            <div class="col-11">
                <button type="button" data-toggle="modal" data-target="#upload_file" class="btn btn-secondary"> <i class="fa fa-upload m-r-5"></i> Upload</button>
            </div>
            <div>
                <a class="btn btn-light" data-toggle="dropdown"><img style="width: 25px; float:right" src="/assets/img/filter.png" alt=""></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/groups/files/<?= $group->id ?>">All File Types</a>
                    <a class="dropdown-item" href="/groups/documentfiles/<?= $group->id ?>">Documents</a>
                    <a class="dropdown-item" href="/groups/imagefiles/<?= $group->id ?>">Images</a>
                    <a class="dropdown-item" href="/groups/videofiles/<?= $group->id ?>"> Videos</a>
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

                            <?php foreach ($groupfiles as $file) : ?>
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
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share_file_<?= $file->id ?>_<?= $group->id ?>"><i class="fa fa-share m-r-5"></i> Share</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_file_<?= $file->id ?>_<?= $group->id ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                    <!-- Share File Modal -->
                                    <div class="modal fade" id="share_file_<?= $file->id ?>_<?= $group->id ?>" role="dialog" style="z-index: 999 important!;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <form method="post" action="/groups/sharefile/<?= $group->id ?>">
                                                    <div class="modal-body">
                                                        <div class="form-header">
                                                            <h3>Share this File with</h3>
                                                        </div>
                                                        <div class="groups-list">
                                                            <div class="form-group form-focus select-focus m-b-30">
                                                                <label for="group"><?= __('Select a Group') ?> <span class="text-danger">*</span></label>
                                                                <select id="groupid" class="select2-icon floating" name="groupid">
                                                                    <?php foreach ($companygroups as $companygroup) : ?>
                                                                        <option value="<?= $companygroup->group->id ?>"> <?= $companygroup->group->name ?> </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <hr>Or
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input class="form-control" type="email" placeholder="Enter Email" name="email">

                                                        </div>
                                                        </br>
                                                        <div class="modal-btn delete-action">
                                                            <div class="row" style="width: 100%;">
                                                                <div class="col-6">
                                                                    <button class="btn btn-primary continue-btn" type="submit">Share</button>
                                                                    <input type="hidden" name="fileid" value="<?= $file->id ?>">
                                                                </div>
                                                                <div class="col-6">
                                                                    <button href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Share file Modal -->





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
                                                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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


</script>
