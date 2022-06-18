<?php

use Cake\I18n\Number;

?>
<style>
    .mycss {
        padding: 15px;
    }
</style>

<!-- Edit Project Modal -->
<div id="edit_project_<?= $projectObject->id ?>" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/project-object/updateproject?companyId=<?= $projectObject->company_id ?>&&type=<?= $projectObject->visibility ?>" enctype="multipart/form-data" novalidate>

                    <div class="row">
                        <div class="col-sm-6">
                        <label for="type"><?= __('Type of Project') ?><span class="text-danger">*</span></label>
                            <div class="form-group form-focus select-focus">
                                <select class="select floating" id="type" name="projecttype">
                                    <?php foreach ($projecttypes as $type) : ?>
                                        <?php if ($projectObject->projecttype->id == $type->id) : ?>
                                            <option value="<?= $type->id ?>" selected><?= $type->name ?></option>
                                        <?php else : ?>
                                            <option value="<?= $type->id ?>"><?= $type->name ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php
                        $client = array();
                        foreach ($projectObject->projectmembers as $projectmember) {
                            if ($projectmember->designation->name == 'Customer') {
                                array_push($client, $projectmember->memberId);
                            }
                        }

                        ?>
                        <div class="col-sm-6">
                        <label>Client</label>
                            <div class="form-group form-focus select-focus">
                                <select class="select floating" name="editclient">
                                    <option disabled value="">--Select Client--</option>
                                    <?php if (!empty($client)) : ?>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <?php if (in_array($companymember->user_id, $client)) : ?>
                                                <option selected value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                            <?php else : ?>
                                                <?php if ($companymember->designation->name == 'Customer') : ?>
                                                    <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    <?php else : ?>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <?php if ($companymember->designation->name == 'Customer') : ?>
                                                <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row">
                        <div class="col-sm-6">
                        <label for="name"><?= __('Project name') ?><span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input name="name" id="name" type="text" class="form-control btn-mod-input" value="<?= nl2br($projectObject->name)  ?>" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Priority</label>
                            <div class="form-group">
                                <select class="select" name="priority">
                                    <option>--Select Priority--</option>
                                    <?php if ($projectObject->priority == 'H') : ?>
                                        <option value="H" selected>High</option>
                                        <option value="M">Medium</option>
                                        <option value="L">Low</option>
                                    <?php elseif ($projectObject->priority == 'M') : ?>
                                        <option value="H">High</option>
                                        <option value="M" selected>Medium</option>
                                        <option value="L">Low</option>
                                    <?php else : ?>
                                        <option value="H">High</option>
                                        <option value="M">Medium</option>
                                        <option value="L" selected>Low</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="startdate"><?= __('Start Date') ?></label>
                                <div class="cal-icon" id="editstartdateerrormessage_<?= $projectObject->id ?>">
                                    <?php if ($projectObject->startdate != null) : ?>
                                        <input type="text" name="startdate" id="edit_startdate_<?= $projectObject->id ?>" class="form-control datetimepicker" value="<?= $projectObject->startdate->i18nFormat('dd/MM/yyyy'); ?>" placeholder="dd/mm/yyyy" />
                                    <?php else : ?>
                                        <input type="text" name="startdate" id="edit_startdate_<?= $projectObject->id ?>" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="expirydate"><?= __('Expire Date') ?></label>
                                <div class="cal-icon" id="editexpirydateerrormessage_<?= $projectObject->id ?>">
                                    <?php if ($projectObject->expirydate != null) : ?>
                                        <input type="text" name="expirydate" id="edit_expirydate_<?= $projectObject->id ?>" class="form-control datetimepicker" value="<?= $projectObject->expirydate->i18nFormat('dd/MM/yyyy'); ?>" placeholder="dd/mm/yyyy" />
                                    <?php else : ?>
                                        <input type="text" name="expirydate" id="edit_expirydate_<?= $projectObject->id ?>" class="form-control datetimepicker" placeholder="dd/mm/yyyy" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-project">
                                <label>
                                    <h4>Select Project For</h4>
                                </label>

                                <?php if ($projectObject->isPersonal == true) : ?>
                                    <div class="row">
                                        <div class="col">
                                            <input class="radioButtons" type="radio" name="typeproject" id="radiobtn-personal_<?= $projectObject->id ?>" value="P" checked required><?= __('Personal') ?>
                                        </div>
                                        <div class="col">
                                            <input class="radioButtons" type="radio" name="typeproject" id="radiobtn-company_<?= $projectObject->id ?>" value="C"><?= __('Company') ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="row">
                                        <div class="col">
                                            <input class="radioButtons" type="radio" name="typeproject" id="radiobtn-personal_<?= $projectObject->id ?>" value="P"><?= __('Personal') ?>
                                        </div>
                                        <div class="col">
                                            <input class="radioButtons" type="radio" name="typeproject" id="radiobtn-company_<?= $projectObject->id ?>" value="C" checked required><?= __('Company') ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="visibilityDiv">
                                    <h4><?= __('Project type') ?></h4>
                                </label>

                                <?php if ($projectObject->visibility == 'I') : ?>
                                    <div id="visibilityDiv" class="row">
                                        <div class="col">
                                            <input type="radio" name="visibility" id="visibility" value="I" checked><?= __('Internal') ?>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="visibility" id="visibility" value="E"><?= __('External') ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div id="visibilityDiv" class="row">
                                        <div class="col">
                                            <input type="radio" name="visibility" id="visibility" value="I"><?= __('Internal') ?>
                                        </div>
                                        <div class="col">
                                            <input type="radio" name="visibility" id="visibility" value="E" checked><?= __('External') ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                    </br>
                    <div class="row" id="project_priceblock_<?= $projectObject->id ?>" style="display: none;">
                        <div class="form-project col">
                            <label for="price">
                                <h4>Prezzo<span class="text-danger">*</span>
                            </label></h4>
                            </label>
                            <input style="height: 55%;" class="form-control" name="price" id="price" type="text" placeholder="<?= __('Price...') ?>" required />
                        </div>
                        <div class="form-project col">
                            <label for="tax">
                                <h4>Tax <span class="text-danger">*</span>
                            </label></h4>
                            </label>
                            <input style="height: 55%;" class="form-control" name="tax" type="number" placeholder="<?= __('Tax...') ?>" required />
                        </div>
                        <div class="form-project col">
                            <label for="slots">
                                <h4>Enter Total Group Slots <span class="text-danger">*</span>
                            </label> </h4>
                            </label>
                            <input style="height: 55%;" class="form-control" type="number" name="group_slots" placeholder="<?= __('Total Number of Groups') ?>" required>
                        </div>
                    </div>

                    <?php if ($projectObject->isPersonal == false) : ?>
                        <div class="row" id="editcompanyproject_priceblock_<?= $projectObject->id ?>">
                            <div class="form-project col">
                                <label for="price">
                                    <h4>Prezzo</h4>
                                </label>
                                <input style="height: 55%;" name="price" id="price" type="text" class="form-control" value="<?= Number::currency(($projectObject->price), 'EUR', ['locale' => 'it_IT']); ?>" required />
                            </div>
                            <div class="form-project col">
                                <label for="tax">
                                    <h4>Tax <span class="text-danger">*</span>
                                </label></h4>
                                </label>
                                <input style="height: 55%;" class="form-control" name="tax" type="number" value="<?= $projectObject->tax ?>" />
                            </div>
                            <div class="form-project col">
                                <label for="slots">
                                    <h4>Enter Total Group Slots </h4>
                                </label>
                                <input style="height: 55%;" class="form-control" type="number" name="group_slots" value="<?= $projectObject->totalgroups ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    </br>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-project">
                                <label for="allowedDiv">
                                    <h4><?= __('Permissions') ?></h4>
                                </label>
                                <div id="allowedDiv">
                                    <div class="row">
                                        <div id="membership_request_div" class="col">
                                            <span class="switch mycss" id="membership_request_span">
                                                <?php if ($projectObject->isMembershipRequestAllowed == true) : ?>
                                                    <input type="checkbox" class="switch" id="membership_request" name="membership_request" checked>
                                                <?php else : ?>
                                                    <input type="checkbox" class="switch" id="membership_request" name="membership_request">
                                                <?php endif; ?>
                                            </span>
                                            <label for="membership_request"><?= __('Memberships  are allowed') ?></label>

                                        </div>
                                        <div id="ban_div" class="col">
                                            <span class="switch mycss" id="ban_span">
                                                <?php if ($projectObject->isBanAllowed == true) : ?>
                                                    <input type="checkbox" class="switch" id="ban" name="ban_span" checked="">
                                                <?php else : ?>
                                                    <input type="checkbox" class="switch" id="ban" name="ban_span">
                                                <?php endif; ?>
                                            </span>
                                            <label for="ban_span"><?= __('Ban is allowed') ?></label>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="invitation_div" class="col">
                                            <span class="switch mycss" id="invitation_span">
                                                <?php if ($projectObject->isInvitationAllowed == true) : ?>
                                                    <input type="checkbox" class="switch" id="invitation" name="invitation_span" checked>
                                                <?php else : ?>
                                                    <input type="checkbox" class="switch" id="invitation" name="invitation_span">
                                                <?php endif; ?>
                                            </span>
                                            <label for="invitation_span"><?= __('Invitations are allowed') ?></label>
                                        </div>
                                        <div id="archive_project" class="col">
                                            <span class="switch mycss" id="invitation_span">
                                                <?php if ($projectObject->isArchieveAllowed == true) : ?>
                                                    <input type="checkbox" class="switch" id="invitation" name="archive_project" checked>
                                                <?php else : ?>
                                                    <input type="checkbox" class="switch" id="invitation" name="archive_project">
                                                <?php endif; ?>
                                            </span>
                                            <label for="archive_project"><?= __('Archieve Project Allowed') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row">
                        <div class="col-sm-6">
                        <label>Add Project Leader</label>
                            <div class="form-group form-focus select-focus">
                                <select class="select floating" name="editprojectleader" id="editteamleader_<?= $projectObject->id ?>" onchange="editteamleader(<?= $projectObject->id ?>)">
                                    <option disabled>-Select Project Manager-</option>
                                    <?php
                                    $pm = array();
                                    foreach ($projectObject->projectmembers as $projetmember) {
                                        if ($projetmember->type == 'Z') {
                                            array_push($pm, $projectmember->memberId);
                                        }
                                    }
                                    ?>
                                    <?php if (!empty($pm)) : ?>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <?php if (in_array($companymember->user_id, $pm)) : ?>
                                                <option selected value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                            <?php else : ?>
                                                <?php if ($companymember->designation->name == 'Project Manager') : ?>
                                                    <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <?php if ($companymember->designation->name == 'Project Manager') : ?>
                                            <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Team Leader</label>
                            <div class="form-group">
                                <div class="project-leader" id="editteamleaderdata_<?= $projectObject->id ?>">
                                    <?php if ($projectObject->projectmembers) : ?>
                                        <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                            <?php if ($projectmember->designation->name == 'Project Manager') : ?>
                                                <a href="#" data-toggle="tooltip" title="" class="avatar" data-original-title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>">
                                                    <?php if ($projectmember->user->profileFilepath != null && $projectmember->user->profileFilename != null) : ?>
                                                        <img src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>" alt="">
                                                    <?php else : ?>
                                                        <img src="/assets/img/profiles/avatar-16.jpg" alt="">
                                                    <?php endif; ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row">
                        <div class="col-sm-6">
                        <label>Add Team</label>
                            <div class="form-group form-focus select-focus">
                                <select class="select floating" id="editmultiplemembers_<?= $projectObject->id ?>" name="editprojectmembers[]" multiple>
                                    <option disabled>-Select Project Team-</option>
                                    <?php if (!empty($companymembers)) : ?>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                        <label>Team Members</label>
                            <div class="form-group">
                                <div class="editproject-members" id="addmembers_<?= $projectObject->id ?>">
                                    <?php if ($projectObject->projectmembers) : ?>
                                        <?php foreach ($projectObject->projectmembers as $projectmember) : ?>
                                            <?php if ($projectmember->designation->name != 'Project Manager' && $projectmember->designation->name != 'Customer') : ?>
                                                <a href="#" data-toggle="tooltip" title="" class="avatar" data-original-title="<?= $projectmember->user->firstname ?> <?= $projectmember->user->lastname ?>">
                                                    <?php if ($projectmember->user->profileFilepath != null && $projectmember->user->profileFilename != null) : ?>
                                                        <img src="<?= $projectmember->user->profileFilepath ?>/<?= $projectmember->user->profileFilename ?>" alt="">
                                                    <?php else : ?>
                                                        <img src="/assets/img/profiles/avatar-16.jpg" alt="">
                                                    <?php endif; ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" name="description" class="form-control"><?= nl2br($projectObject->description) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="projectIMG"><?= __('Project Files') ?><span class="text-danger">*</span></label>
                        <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                        <div class='label label-info' id="upload-file-info"></div>
                    </div>

                    <div class="form-control">
                        <div class="uploaded-box" id="fileinfo_<?= $projectObject->id ?>">
                            <?php foreach ($projectObject->projectfiles as $projectfile) : ?>
                                <div class="uploaded-img">
                                    <a href="">
                                        <span class="remove-icon">
                                            <a onclick="deletefile(<?= $projectfile->id ?>,<?= $projectObject->id ?>)" class="del-msg"><i class="fa fa-close"></i></a>
                                        </span>
                                    </a>
                                </div>
                                <ul>
                                    <li> <a href="/projectfiles/downloadfile?fileid=<?= $projectfile->id ?>&pid=<?= $projectObject->id ?>"><?= $projectfile->filename ?></a></li>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                        <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Update ') ?></button>
                        <?php if (!empty($view)) : ?>
                            <input type="hidden" name="url" value="<?= $projectObject->id ?>">
                        <?php elseif (!empty($archieveprojects)) : ?>
                            <input type="hidden" name="archieveprojects" value="<?= $archieveprojects->id ?>">
                        <?php elseif (!empty($projectlists)) : ?>
                            <input type="hidden" name="projectlists" value="<?= $projectObject->id ?>">
                        <?php elseif (!empty($rendercompanyId)) : ?>
                            <input type="hidden" name="rendercompanyId" value="<?= $rendercompanyId ?>">
                        <?php elseif (!empty($userprofile)) : ?>
                            <input type="hidden" name="userprofile" value="<?= $userprofile ?>">
                        <?php elseif (!empty($projectreports)) : ?>
                            <input type="hidden" name="projectreports" value="<?= $projectreports ?>">
                        <?php elseif (!empty($projectcategoryview)) : ?>
                            <input type="hidden" name="projectcategoryview" value="<?= $projectcategoryview ?>">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Edit Project Modal -->

<script>
    $(function() {
        $(document).ready(function() {
            $.ajax({
                url: '/project-object/docallprojects',
                dataType: 'json',
                success: function(data) {
                    console.log('allprojects', data);
                    data.forEach((projectObject) => {

                        $("#edit_startdate_" + projectObject.id).datetimepicker().on('dp.change', function() {
                            $('#ptagerrorMessage').remove();
                            var splittedDate = $("#edit_startdate_" + projectObject.id).val().split("/");
                            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                            var startdate = moment(dateToString).format("YYYY-MM-DD");
                            var todaydate = moment().format("YYYY-MM-DD");



                            if ((startdate) < (todaydate)) {
                                $('#editstartdateerrormessage_' + projectObject.id).append('<p id="ptagerrorMessage" style="color:red;"class="message">Start date cannot be less than to current date</p>');
                            }
                        });

                        $("#edit_expirydate_" + projectObject.id).datetimepicker().on('dp.change', function() {
                            $('#ptagerrorMessage').remove();
                            var splittedDate = $("#edit_startdate_" + projectObject.id).val().split("/");
                            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                            var startdate = moment(dateToString).format("YYYY-MM-DD");
                            var splittedDate = $("#edit_expirydate_" + projectObject.id).val().split("/");
                            var expirydate = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                            var createExpiryDate = moment(expirydate).format("YYYY-MM-DD");

                            if (createExpiryDate <= startdate) {
                                $('#editexpirydateerrormessage_' + projectObject.id).append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date must be Greater than Startdate</p>');
                            }
                        });

                        var values;

                        $("#editmultiplemembers_" + projectObject.id).on("select2:select", function(event) {
                            values = [];
                            // copy all option values from selected
                            $(event.currentTarget).find("option:selected").each(function(i, selected) {
                                values[i] = parseInt($(selected).val());
                                console.log(values, 'multiple');

                            });
                            $.ajax({
                                url: '/project-object/addedmembers',
                                method: 'post',
                                dataType: 'json',
                                data: {
                                    'values': JSON.stringify(values)
                                },
                                success: function(data) {
                                    console.log(data, 'data');
                                    var str = "";
                                    data.forEach((user) => {
                                        str += '<a href="#" data-toggle="tooltip" title="" class="avatar" data-original-title="' + user.firstname + ' ' + user.lastname + '">';
                                        if (user.profileFilepath != null && user.profileFilename != null) {
                                            str += '<img src="' + user.profileFilepath + '/' + user.profileFilename + '" alt="">';
                                        } else {
                                            str += '<img src="/assets/img/profiles/avatar-09.jpg" alt="">';
                                        }
                                        str += '</a>';

                                    });
                                    $('#addmembers_' + projectObject.id).html(str);
                                },
                                error: function() {}
                            })
                        });




                        $('.radioButtons').click(function() {

                            if ($("#radiobtn-company_" + projectObject.id).prop("checked")) {
                                $('#project_priceblock_' + projectObject.id).show();
                            }
                            if ($("#radiobtn-personal_" + projectObject.id).prop("checked")) {
                                $('#project_priceblock_' + projectObject.id).hide();
                                $('#editcompanyproject_priceblock_' + projectObject.id).hide();
                            }

                        });
                    });
                },
                error: function() {}
            })
        });
    });




    function editteamleader(pid) {

        var teamleaderid = $('#editteamleader_' + pid).val();

        $.ajax({
            url: '/project-object/addedmembers',
            method: 'post',
            dataType: 'json',
            data: {
                'values': teamleaderid
            },
            success: function(data) {
                console.log(data, 'data');
                $('#editteamleaderdata_' + pid).empty();

                var str = "";
                data.forEach((user) => {
                    str += '<a href="#" data-toggle="tooltip" title="" class="avatar" data-original-title="' + user.firstname + ' ' + user.lastname + '">';
                    if (user.profileFilepath != null && user.profileFilename != null) {
                        str += '<img src="' + user.profileFilepath + '/' + user.profileFilename + '" alt="">';
                    } else {
                        str += '<img src="/assets/img/profiles/avatar-09.jpg" alt="">';
                    }
                    str += '</a>';
                });
                $('#editteamleaderdata_' + pid).html(str);
            },
            error: function() {}
        })

    }
</script>
