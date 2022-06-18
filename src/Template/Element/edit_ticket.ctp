
<!-- Add Ticket Modal -->

<div id="edit_ticket_<?= $ticket->id ?>" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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

                    <?php if ($companyrole->member_role == 'Y' || $companyrole->member_role == 'A') : ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="client">Clients</label>
                                <div class="form-group form-focus select-focus">
                                    <select class="select2-icon floating" data-select2-id="select2-data-4-f7su" tabindex="-1" aria-hidden="true" id="clientid" name="clientid" onchange="filterprojectsofclient(this)">
                                        <option value="">--Select Client--</option>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <?php if ($companymember->member_role == 'C') : ?>
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

                        <?php if(empty($alltickets)) : ?>
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
                                                <?php foreach ($ticket->taskusers as $taskuser) : ?>
                                                    <?php if ($companymember->user_id == $taskuser->assignee_id) : ?>
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

                            <div class="col-sm-6">
                                <label>Add Followers </label>
                                <div class="form-group">
                                    <select name="editfollowers[]" class="select2-icon floating" multiple>
                                        <option id='' disabled>-Select member as Follower-</option>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <?php foreach ($ticket->followers as $follower) : ?>

                                                <?php if ($follower->user_id == $companymember->user_id) : ?>
                                                    <option selected value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
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
                                    <label for="price"><?= __('Price') ?><span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="editticketprice" placeholder="<?= __('Enter Price...') ?> " value="<?= $ticket->price ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ticketprice"><?= __('Tax') ?><span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="edittickettax" placeholder="<?= __('Enter Tax...') ?> " value="<?= $ticket->tax_percentage ?>" required>
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
                                <label>Upload Files</label>
                                <?= $this->Form->control('editticketfiles.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>

                            </div>
                        </div>
                    </div>


                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"><?= __('Update Ticket') ?></button>
                    </div>

                    <?php if (!empty($alltickets)) : ?>
                        <input type="hidden" name="alltickets" value="<?= $alltickets ?>">
                    <?php else : ?>
                        <input type="hidden" name="pid" value="<?= $projectObject->id ?>">
                    <?php endif; ?>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- /Add Ticket Modal -->
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
                            // if (((new Date(data.startdate).toDateString()) <= (new Date(dateToString).toDateString())) && ((new Date(data.expirydate).toDateString()) >= (new Date(dateToString).toDateString()))) {
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
        var str = $('#editticketstartdate').val()
        var exp = $('#editticketexpirydate').val()
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
</script>
