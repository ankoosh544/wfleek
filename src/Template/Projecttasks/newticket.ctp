<!-- Page Wrapper -->
<div class="page-wrapper">

    <div class="content container-fluid">


        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Create Ticket</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Project Ticket</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0"> New Ticket Form</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/projecttasks/create-ticket" id="addticket" enctype="multipart/form-data">


                            <?php if ($authuser_company_role->designation->name == 'Customer') : ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ticketname"><?= __('Ticket name') ?><span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="ticketname">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="ticketstatus">Ticket Category<span class="text-danger">*</span></label>
                                        <div class="form-group form-focus select-focus">
                                            <select class="select floating" name="category" tabindex="-1" aria-hidden="true" required>
                                                <option id='' disabled selected>---Select----</option>
                                                <option value="General">General</option>
                                                <option value="Work">Work </option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="ticketname"><?= __('Ticket name') ?><span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="ticketname">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="ticketstatus">Ticket Category<span class="text-danger">*</span></label>
                                        <div class="form-group form-focus select-focus">
                                            <select class="select floating" name="category" tabindex="-1" aria-hidden="true" required>
                                                <option id='' disabled selected>---Select----</option>
                                                <option value="General">General</option>
                                                <option value="Work">Work </option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <?php if (!empty($typeticket)) : ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="client">Clients</label>
                                            <div class="form-group form-focus select-focus">
                                                <select class="select floating" data-select2-id="select2-data-4-f7su" tabindex="-1" aria-hidden="true" id="clientid" name="clientid" onchange="filterprojectsofclient(this)">
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
                                            <label for="project-name">Choose Project</label>
                                            <div class="form-group form-focus select-focus">
                                                <select id="project-name" class="select floating" name="projectname" onchange="filterprojects(this)">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="grouptype"><?= __('Select the Task Group') ?></label>
                                            <div class="form-group form-focus select-focus">
                                                <select name="grouptype" id="addtasktsgrouptype" class="select floating grouptypeselected">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <label>Select Group<span class="text-danger">*</span> </label>
                                            <div class="form-group form-focus select-focus">
                                                <select class="select floating" name="grouptype" id="addtasktsgrouptype">
                                                    <option value='' selected>---Select Group Name----</option>
                                                    <?php if (!empty($projectgroups)) : ?>
                                                        <?php foreach ($projectgroups as $group) : ?>
                                                            <?php if (!empty($grouptasks && $group->id == $grouptasks)) : ?>
                                                                <option selected value="<?= $group->id ?>"><?= $group->title ?></option>
                                                            <?php else : ?>
                                                                <option value="<?= $group->id ?>"><?= $group->title ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Client<span class="text-danger">*</span> </label>
                                            <div class="form-group form-focus select-focus">
                                                <select class="select floating" name="clientid" id="clientid">
                                                    <option value='' selected>---Client----</option>
                                                    <?php foreach ($companymembers as $companymember) : ?>
                                                        <?php if ($companymember->designation->name == 'Customer') : ?>
                                                            <?php if ($projectclient->memberId == $companymember->user_id) : ?>
                                                                <option selected value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                            <?php else : ?>
                                                                <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                            <?php endif; ?>

                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="ticketstartdate"><?= __('Start Date') ?><span class="text-danger">*</span></label>
                                        <input type="text" name="ticketstartdate" id="addticketstartdate" class="datetimepicker form-control" placeholder="dd/mm/yyyy" required />
                                        <span class="text-danger" id="ticketstartdateMsg"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="ticketstartdate"><?= __('Expiry Date') ?> <span class="text-danger">*</span></label>
                                        <input class="form-control datetimepicker" name="ticketexpirydate" id="addticketexpirydate" type="text" placeholder="<?= __('dd/mm/yyyy') ?>" required>
                                        <span class="text-danger" id="addticketexpirydateMsg"></span>
                                    </div>
                                </div>
                                </br>
                                </br>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="taskassignees"><?= __('Assign to Employee') ?></label>
                                        <div class="form-group form-focus select-focus">
                                            <select name="taskassignees[]" class="select floating" multiple>
                                                <option id='' disabled>-Select A Member-</option>
                                                <?php foreach ($companymembers as $companymember) : ?>
                                                    <?php if ($companymember->designation->name != 'C') : ?>
                                                        <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="followers"><?= __('Add Followers') ?></label>
                                        <div class="form-group form-focus select-focus">
                                            <select name="followers[]" class="select floating" multiple>
                                                <option id='' disabled>-Select member as Follower-</option>
                                                <?php foreach ($companymembers as $companymember) : ?>
                                                    <option value="<?= $companymember->user_id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="priority"> <?= __('Priority') ?></label>
                                        <div class="form-group form-focus select-focus">
                                            <select class="select floating" name="task_prority">
                                                <option>Select Priority</option>
                                                <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                                <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                                <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="epic"> <?= __('Link to  Epic Task') ?></label>
                                        <div class="form-group form-focus select-focus">
                                            <select id="epic" class="select floating" name="epic_task">
                                                <?php foreach ($epictasks as $epictask) : ?>
                                                    <option value="<?= $epictask->id ?>"><?= $epictask->title ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                                <?php if ($authuser_company_role->designation->name != 'Customer') : ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="price"><?= __('Price') ?></label>
                                            <input type="number" class="form-control" name="ticketprice" placeholder="<?= __('Enter Price...') ?> ">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="ticketprice"><?= __('Tax') ?></label>
                                            <input type="number" class="form-control" name="tickettax" placeholder="<?= __('Enter Tax...') ?> ">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            </br>
                            </br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="description"><?= __('Description') ?><span class="text-danger">*</span></label>
                                    <textarea rows="5" cols="5" class="form-control summernote" placeholder="Enter text here" name="ticketdescription" required></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-form-label col-md-2">File Input</label>
                                <div class="col-md-10">
                                    <?= $this->Form->control('ticketfiles.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-primary margin-t-1 btn-mod-create " type="submit"><?= __('create Ticket') ?></button>
                                    <?php if ($projecttask != null) : ?>
                                        <input type="hidden" name="taskview" value="<?= $projecttask->id ?>">
                                    <?php elseif (!empty($taskboard)) : ?>
                                        <input type="hidden" name="taskboard" value="<?= $taskboard ?>">
                                    <?php elseif ($projectId != null) : ?>
                                        <input type="hidden" name="pid" value="<?= $projectId ?>">
                                        <input type="hidden" name="projectview" value="<?= $projectId ?>">
                                    <?php else : ?>
                                        <input type="hidden" name="tickets" value=" NORMALTICKETS">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- /Main Wrapper -->
<script>
    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };

    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });
    //taskstartdate
    $('#addticketstartdate').on('dp.change', function(ev) {
        var ts = $('#addticketstartdate').val();
        var gid = $('#addtasktsgrouptype').val()
        console.log(gid, 'gid');

        if (gid == "" || gid == undefined) {
            var splittedDate = ts.split("/");
            var error = "";
            var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

            var ticketstartdate = moment(dateToString).format("YYYY-MM-DD");
            var todaydate = moment().format("YYYY-MM-DD");

            $('#ticketstartdateMsg').empty();


            if (ticketstartdate >= todaydate) {

            } else {
                error = "Invalid Date";
            }
            $('#ticketstartdateMsg').html(error);

        } else {
            $.ajax({
                url: '/projecttasks/checkstartdate',
                method: 'post',
                dataType: 'json',
                data: {
                    'groupid': gid,
                },
                success: function(data) {
                    console.log(data, 'group data');
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
                },
                error: function() {}
            });
        }


    });

    // task ExpiryDate
    $('#addticketexpirydate').on('dp.change', function(ev) {
        var str = $('#addticketstartdate').val()
        var exp = $('#addticketexpirydate').val()
        if ($('#addtasktsgrouptype').val() == '' || $('#addtasktsgrouptype').val() == undefined) {
            var error = "";
            var splittedstartDate = str.split("/");
            var splittedexpiryDate = exp.split("/");
            var startdateToString = splittedstartDate[2] + "-" + splittedstartDate[1] + "-" + splittedstartDate[0];
            var expirydateToString = splittedexpiryDate[2] + "-" + splittedexpiryDate[1] + "-" + splittedexpiryDate[0];
            if (moment(expirydateToString).format("YYYY-MM-DD") > moment(startdateToString).format("YYYY-MM-DD")) {

            } else {
                error = 'ExpiryDate not Lessthan StartDate';
            }
            $('#addticketexpirydateMsg').html(error);

        } else {
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
                    $('#addticketexpirydateMsg').html(error);
                },
                error: function() {}
            });
        }
    });

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
</script>
