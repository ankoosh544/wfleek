<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>
    @media screen and (max-width: 433px) {
        .uploaded-image {
            width: 250px;
            height: 250px;
        }

    }

    @media screen and (min-width: 768px) and (max-width: 1366px) {
        .uploaded-image {
            width: 500px;
            height: 250px;
        }
    }

    .tagpeopledive {
        position: relative;
        padding: 0;
        margin: 0;
        display: flex;
        float: right;
    }
    .cssfortime {
        padding: 1px;
        margin-left: 5px;
    }
</style>


<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-body">
                <?php if ($status != 'D') : ?>
                    <form method="post" action="/projecttasks/updateticket/<?= $ticket->id ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ticketname"><?= __('Ticket name') ?><span class="text-danger">*</span></label>
                                    <input name="editticketname" type="text" class="form-control" value="<?= $ticket->title ?>" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="ticketstatus">Ticket Category<span class="text-danger">*</span></label>
                                <div class="form-group form-focus select-focus">
                                    <select class="select2-icon floating" data-select2-id="select2-data-4-f7su" id="ticketstatus" name="editcategory" tabindex="-1" aria-hidden="true">
                                        <option id='' disabled selected>---Select----</option>
                                        <?php if ($ticket->category == 'General') : ?>
                                            <option selected value="General">General</option>
                                            <option value="Work">Work</option>
                                        <?php else : ?>
                                            <option value="Work" selected>Work</option>
                                            <option value="General">General</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if ($companyrole->designation->name == 'Administrator' || $companyrole->designation->name == 'Functional Analyst') : ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="client">Clients</label>
                                    <div class="form-group form-focus select-focus">
                                        <select class="select2-icon floating" data-select2-id="select2-data-4-f7su" tabindex="-1" aria-hidden="true" id="clientid" name="clientid" onchange="filterprojectsofclient(this)">
                                            <option value="">--Select Client--</option>
                                            <?php foreach ($companymembers as $companymember) : ?>
                                                <?php if ($companymember->designation->name == 'Customer') : ?>
                                                    <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->lastname ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="ticketstatus">Ticket Status<span class="text-danger">*</span></label>
                                    <div class="form-group form-focus select-focus">
                                        <select class="select2-icon floating" data-select2-id="select2-data-4-f7su" id="ticketstatus" name="editticketstatus" tabindex="-1" aria-hidden="true">
                                            <option id='' disabled selected>---Select----</option>
                                            <?php if ($ticket->status == 'T') : ?>
                                                <option selected value="T">Inviato</option>
                                                <option value="I">In lavorazione</option>
                                                <option value="D">Risolto</option>
                                            <?php elseif ($ticket->status == 'I') : ?>
                                                <option value="T">Inviato</option>
                                                <option selected value="I">In lavorazione</option>
                                                <option value="D">Risolto</option>
                                            <?php elseif ($ticket->status == 'D') : ?>
                                                <option value="T">Inviato</option>
                                                <option value="I">In lavorazione</option>
                                                <option selected value="D">Risolto</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="project-name">Choose Project</label>
                                    <div class="form-group form-focus select-focus">
                                        <select id="project-name" class="select2-icon floating" name="projectname" onchange="filterprojects(this)">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="grouptype"><?= __('Select the Task Group') ?></label>
                                    <div class="form-group form-focus select-focus">
                                        <select name="editgrouptype" id="addtasktsgrouptype" class="select floating grouptypeselected">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if (empty($alltickets)) : ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="grouptype"><?= __('Select the Task Group') ?></label>
                                        <div class="form-group form-focus select-focus">
                                            <select name="editgrouptype" id="addtasktsgrouptype" class="select2-icon floating grouptypeselected">
                                                <option id='' selected>---Select Group Name----</option>
                                                <?php foreach ($taskgroups as $group) : ?>
                                                    <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Assign to Employee</label>
                                    <div class="form-group">
                                        <select name="edittaskassignees[]" class="select2-icon floating" multiple>
                                            <option id='' disabled>-Select A Member-</option>
                                            <?php foreach ($companymembers as $companymember) : ?>

                                                <?php if (!empty($ticket->taskusers)) : ?>
                                                    <?php
                                                    $taskuserids = array();
                                                    foreach ($ticket->taskusers as $taskuser) {
                                                        array_push($taskuserids, $taskuser->assignee_id);
                                                    }
                                                    ?>
                                                    <?php if (in_array($companymember->user_id, $taskuserids)) : ?>
                                                        <option selected value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                    <?php endif; ?>

                                                <?php else : ?>

                                                    <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label>Add Followers </label>
                                    <div class="form-group">
                                        <select name="editfollowers[]" class="select2-icon floating" multiple>
                                            <option id='' disabled>-Select member as Follower-</option>
                                            <?php foreach ($companymembers as $companymember) : ?>
                                                <?php if (!empty($ticket->followers)) : ?>
                                                    <?php foreach ($ticket->followers as $follower) : ?>
                                                        <?php if ($follower->user_id == $companymember->user_id) : ?>
                                                            <option selected value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                        <?php else : ?>
                                                            <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ticketstartdate"><?= __('Start Date') ?><span class="text-danger">*</span></label>
                                        <?php if ($ticket->startdate != null) : ?>
                                            <input type="text" name="editticketstartdate" id="editticketstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" value="<?= $ticket->startdate->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>" required />
                                        <?php endif; ?>
                                        <span class="text-danger" id="ticketstartdateMsg"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Expire Date <span class="text-danger">*</span></label>
                                        <div class="cal-icon">
                                            <?php if ($ticket->expiration_date != null) : ?>
                                                <input class="form-control datetimepicker" name="editticketexpirydate" id="editticketexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" value="<?= $ticket->expiration_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome') ?>" required>
                                            <?php else : ?>
                                                <input class="form-control datetimepicker" name="editticketexpirydate" id="editticketexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                            <?php endif; ?>
                                            <span class="text-danger" id="editticketexpirydateMsg"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="price"><?= __('Price') ?></label>
                                        <input type="number" class="form-control" name="editticketprice" placeholder="<?= __('Enter Price...') ?> " value="<?= $ticket->price ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="ticketprice"><?= __('Tax') ?></label>
                                        <input type="number" class="form-control" name="edittickettax" placeholder="<?= __('Enter Tax...') ?> " value="<?= $ticket->tax_percentage ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="priority"><?= __('Priority') ?></label>
                                    <div class="form-group form-focus select-focus">
                                        <select class="select2-icon floating" name="edittask_prority">
                                            <option>Select Priority</option>
                                            <?php if ($ticket->priority == 'H') : ?>
                                                <option selected value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                            <?php elseif ($ticket->priority == 'M') : ?>
                                                <option selected value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                            <?php elseif ($ticket->priority == 'L') : ?>
                                                <option selected value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                            <?php endif; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="epic"><?= __('Link to  Epic Task') ?></label>
                                    <div class="form-group form-focus select-focus">

                                        <select id="epic" class="select2-icon floating" name="editepic_task">
                                            <?php foreach ($epictasks as $epictask) : ?>
                                                <option value="<?= $epictask->id ?>"><?= $epictask->title ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="ticketdescription"><?= __('Description') ?><span class="text-danger">*</span></label>
                                    <textarea name="editticketdescription" id="description" type="text" class="form-control summernote btn-mod-input height10" required><?= $ticket->description ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Upload Files <span style="color:red">(It will override your previous ticket files)</span></label>
                                    <?= $this->Form->control('editticketfiles.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                                </div>
                            </div>
                            <?php if (!empty($ticket->taskfiles)) : ?>
                                <ul>
                                    <?php foreach ($ticket->taskfiles as $taskfile) : ?>
                                        <li><a href=""><?= $taskfile->filename ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <a href="/projecttasks/tickets/<?= $authuser->id ?>" class="btn btn-primary"> <img src="/assets/img/back.png" alt="" style="width: 25px;"> Go Back</a>
                            <a href="/projecttasks/updateticketStatus?ticketId=<?= $ticket->id ?>&&closeticket=<?= $ticket->id ?>" class="btn btn-danger">Close Ticket</a>
                            <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Update Ticket') ?></button>
                        </div>
                        <?php if (!empty($alltickets)) : ?>
                            <input type="hidden" name="alltickets" value="<?= $alltickets ?>">
                        <?php else : ?>
                            <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                        <?php endif; ?>
                    </form>
                <?php else : ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ticketname"><?= __('Ticket name') ?><span class="text-danger">*</span></label>
                                <input name="editticketname" type="text" class="form-control" value="<?= $ticket->title ?>" disabled />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="ticketstatus">Ticket Status<span class="text-danger">*</span></label>
                            <div class="form-group form-focus select-focus">
                                <select class="select2-icon floating" data-select2-id="select2-data-4-f7su" id="ticketstatus_<?= $ticket->id ?>" name="editticketstatus" tabindex="-1" aria-hidden="true" onchange="updateticketStatus(<?= $ticket->id ?>, <?=$authuser->id?>)">
                                    <option id='' disabled selected>---Select----</option>
                                    <?php if ($ticket->status == 'T') : ?>
                                        <option value="T" selected data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                        <option value="I" data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                        <option value="D" data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                    <?php elseif ($ticket->status == 'I') : ?>
                                        <option value="T" data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                        <option value="I" selected data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                        <option value="D" data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                    <?php else : ?>
                                        <option value="T" data-icon="fa fa-dot-circle-o text-purple">Inviato</option>
                                        <option value="I" data-icon="fa fa-dot-circle-o text-info">In lavorazione</option>
                                        <option value="D" selected data-icon="fa fa-dot-circle-o text-danger">Risolto</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ticketdescription"><?= __('Description') ?><span class="text-danger">*</span></label>
                                <textarea name="editticketdescription" id="description" type="text" class="form-control summernote btn-mod-input height10" disabled><?= $ticket->description ?></textarea>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </br>
                <hr>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="avatar">
                        <img data-toggle="tooltip" title="" class="avatar-img rounded-circle border border-white" alt="User Image" src="/assets/img/profiles/avatar-12.jpg" data-original-title="Nawaz shek">
                        &gt;
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <!------------Post Comment---------------------------------->

                            <div class="postmessage-form" id="toggablediv">
                                <div>
                                    <textarea class="form-control" type="text" placeholder="Write Something..." onkeypress="onEnter(event)" id="textdiv_<?= $ticket->id ?>" onclick="togglediv(<?= $ticket->id ?>)"></textarea>
                                </div>
                                <div class="form-group form-focus select-focus m-b-30 tagpeopledive" style="display: none;">
                                    <span class="btn-file" style="padding: 15px;">
                                        <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="ticketimages_<?= $ticket->id ?>" name="images" type="file" multiple />
                                        <img src="/assets/img/attachment.png" alt="">
                                    </span>
                                    <span class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="submitMessage(<?= $ticket->id ?>)"><i class="fa fa-send"></i></button>
                                    </span>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </br>
        <div class="card">
            <div class="card-body">
                <?php if (!empty($ticket->task_comments)) : ?>

                    <?php foreach ($ticket->task_comments as $comment) : ?>
                        <div class="chat chat-left">
                            <div class="chat-avatar">
                                <a href="profile.html" class="avatar">
                                    <?php if ($comment->user->profileFilepath != null && $comment->user->profileFilename != null) : ?>
                                        <img src="<?= $comment->user->profilefilepath ?>/<?= $comment->user->profileFilename ?>" alt="">
                                    <?php else : ?>
                                        <img src="/assets/img/profiles/avatar-02.jpg" alt="">
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="chat-body">
                                <div class="chat-bubble">
                                    <div class="chat-content">
                                        <a href="" style="display: flex;">
                                            <span class="task-chat-user"><?= $comment->user->firstname ?> <?= $comment->user->lastname ?></span> <span class="chat-time cssfortime"> <?= $comment->creation_date ?> </span>
                                        </a>
                                        <p><?= $comment->content ?></p>

                                        <?php if ($comment->taskfiles) : ?>
                                            <ul class="attach-list">
                                                <?php foreach ($comment->taskfiles as $file) : ?>
                                                    <li><i class="fa fa-file"></i> <a href="/taskfiles/downloadtaskfile/<?= $file->id ?>"><?= $file->filename ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <?php if ($companyrole->designation->name == 'Administrator' || $companyrole->designation->name == 'Functional Analyst') : ?>
                                    <a href="" data-toggle="modal" data-target="#editcomment_<?= $ticket->id ?>_<?= $comment->id ?>">Edit</a>
                                    <a href="" data-toggle="modal" data-target="#deletecomment_<?= $ticket->id ?>_<?= $comment->id ?>">Delete</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!--------------------Edit TaskComment----------->
                        <?= $this->element('edit_taskcomment',[
                            'ticket' => $ticket,
                            'comment' => $comment

                        ]) ?>
                        <!-------------------Edit TaskComment------------->

                        <!---------Delete Task Commet------------>

                        <?= $this->element('delete_taskcomment',[
                            'ticket' => $ticket,
                            'comment' => $comment

                        ]) ?>
                        <!--------------/Delete Taskcomment--------------->


                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
    function filterprojectsofclient() {
        console.log($('#clientid').val(), 'client id')
        $.ajax({
            url: '/projecttasks/filterprojectsofclient',
            method: 'post',
            dataType: 'json',
            data: {
                'clientid': $('#clientid').val(),
            },
            success: function(data) {
                console.log(data);
                var htmlCode = "<option id='' disabled selected>--Select Projects--</option>";

                for (var i = 0; i < data.length; i++) {

                    htmlCode += "<option value='" + data[i].ProjectObject.id + "'>" + data[i].ProjectObject.name + "</option>";
                }
                $("#project-name").html(htmlCode);
            },
            error: function() {}
        });
    }

    function filterprojects() {
        console.log($('#project-name').val(), 'Project id')
        $.ajax({
            url: '/projecttasks/filterprojects',
            method: 'post',
            dataType: 'json',
            data: {
                'tagvalue': $('#project-name').val(),
            },
            success: function(data) {
                console.log(data);
                var htmlCode = "<option id='' disabled selected>--Select Group Name--</option>";
                for (var i = 0; i < data.length; i++) {

                    htmlCode += "<option value='" + data[i].id + "'>" + data[i].title + "</option>";
                }
                $("#addtasktsgrouptype").html(htmlCode);
            },
            error: function() {}
        });
    }



    //taskstartdate
    $('#editticketstartdate').on('dp.change', function(ev) {
        var ts = $('#editticketstartdate').val();
        console.log(ts, 'startdate');
        var gid = $('#addtasktsgrouptype').val()

        $.ajax({
            url: '/projecttasks/checkstartdate',
            method: 'post',
            dataType: 'json',
            data: {
                'groupid': gid,
            },
            success: function(data) {
                if (data != null) {
                    var error = "";
                    var splittedDate = ts.split("/");
                    var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                    var ticketstartdate = moment(dateToString).format("YYYY-MM-DD");
                    var todaydate = moment().format("YYYY-MM-DD");
                    $('#ticketstartdateMsg').empty();
                    if (ticketstartdate >= todaydate) {
                        if ((moment(data.startdate).format("YYYY-MM-DD") <= ticketstartdate) && (moment(data.expirydate).format("YYYY-MM-DD") > ticketstartdate)) {

                            console.log('Valid Date');
                        } else {
                            error = "Invalid Date";
                        }
                    } else {
                        error = "Invalid Date";
                    }
                    $('#ticketstartdateMsg').html(error);
                }
            },
            error: function() {}
        });

    });

    // task ExpiryDate
    $('#editticketexpirydate').on('dp.change', function(ev) {
        var str = $('#editticketstartdate').val();
        var exp = $('#editticketexpirydate').val();
      var groupid =  $('#addtasktsgrouptype').val();
      console.log(groupid, 'groupid');
        $.ajax({
            url: '/projecttasks/checkexpirydate',
            method: 'post',
            dataType: 'json',
            data: {
                'groupid': $('#addtasktsgrouptype').val(),

            },
            success: function(data) {
                var error = "";
                var splittedstartDate = str.split("/");
                var splittedexpiryDate = exp.split("/");
                var startdateToString = splittedstartDate[2] + "-" + splittedstartDate[1] + "-" + splittedstartDate[0];
                var expirydateToString = splittedexpiryDate[2] + "-" + splittedexpiryDate[1] + "-" + splittedexpiryDate[0];
                if (new Date(expirydateToString) > new Date(startdateToString)) {
                    if (((new Date(data.startdate)) <= (new Date(expirydateToString))) && ((new Date(data.expirydate)) >= (new Date(expirydateToString)))) {} else {
                        error = 'ExpiryDate Invalid';
                    }
                } else {
                    error = 'ExpiryDate not Lessthan StartDate';
                }
                $('#editticketexpirydateMsg').html(error);
            },
            error: function() {}
        });
    });
    var selectedvalues;

    $(".grouptypeselected").on("select2:select", function(event) {
        $('#addtasktsgrouptype').val(event.params.data.id);
    });

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };

    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });


    function togglediv(ticketId) {
        if ($('#textdiv_' + ticketId).height() < 100) {
            $('#textdiv_' + ticketId).height("100px");
            $('.tagpeopledive').show();
        } else {
            $('#textdiv_' + ticketId).height("32px");
            $('.tagpeopledive').hide();
        }
    }

    function toggledcommentdiv(postid) {
        if ($('#msg_' + postid).height() < 100) {
            $('#msg_' + postid).height("100px");
            $('#tagpeoplecommentdiv_' + postid).show();
        } else {
            $('#msg_' + postid).height("32px");
            $('#tagpeoplecommentdiv_' + postid).hide();
        }

    }

    function onEnter(e, pid, tid, auth) {
        console.log(e.which, 'enter key');
        if (e.which === 13) {
            e.preventDefault();
            submitMessage(tid);
            console.log(tid, 'ticket id')
        }
    }

    function submitMessage(tid) {
        var file_data = $("#ticketimages_" + tid).prop("files");

        console.log(tid, 'ticket id')

        var generalticket = tid;

        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = tid;
        }
        var content = $('#textdiv_' + tid).val();
        form_data.append("tid", tid);
        form_data.append("content", content);
        form_data.append("generalticket", generalticket);
        form_data.append('isFileNotAttached', isFileNotAttached);

        $.ajax({
            url: '/comments/submit-message',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                console.log(data, 'data');
                location.reload();


            },
            error: function() {

            }
        });
    }

    function updateticketStatus(ticketId, user_id) {
        var status = $('#ticketstatus_' + ticketId).val();
        $.ajax({
            url: '/projecttasks/updateticketStatus',
            method: 'post',
            dataType: 'json',
            data: {
                'tid': ticketId,
                'status': status
            },
            success: function(data) {
                window.location = '/projecttasks/tickets/'+user_id;
            },
            error: function() {}
        });


    }
</script>
