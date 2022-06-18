<style>
    .mycss {
        padding: 15px;
    }
</style>


<!-- Create Project Modal -->
<div id="create_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/project-object/add-project?type=<?= $type ?>" id="add" enctype="multipart/form-data" novalidate>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-focus select-focus">
                                <label for="type"><?= __('Type of Project') ?><span class="text-danger">*</span></label>
                                <select class="select floating" id="type" name="projecttype">
                                    <?php foreach ($projecttypes as $projecttype) : ?>
                                        <option value="<?= $projecttype->id ?>"><?= $projecttype->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group form-focus select-focus">
                                <label>Client</label>
                                <select class="select floating" name="client">
                                    <option>--Select Client--</option>
                                    <?php foreach ($companymembers as $companymember) : ?>
                                        <?php if ($companymember->designation->name == 'Customer') : ?>
                                            <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name"><?= __('Project name') ?><span class="text-danger">*</span></label>
                                <input name="name" id="name" type="text" class="form-control btn-mod-input" placeholder="<?= __('Your project\'s name...') ?>" required />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="select2-icon" name="priority">
                                    <option selected>--Select Priority--</option>
                                    <option value="H" data-icon="fa fa-dot-circle-o text-danger">High</option>
                                    <option value="M" data-icon="fa fa-dot-circle-o text-warning">Medium</option>
                                    <option value="L" data-icon="fa fa-dot-circle-o text-success">Low</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="expirydate"><?= __('Start Date') ?><span class="text-danger">*</span></label>
                                <div class="cal-icon" id="errormessage">
                                    <input type="text" name="startdate" id="create_startdate" class="form-control floating datetimepicker" placeholder="dd/mm/yyyy" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="expirydate"><?= __('Expire Date') ?><span class="text-danger">*</span></label>
                                <div class="cal-icon" id="errormessage_expirydate">
                                    <input type="text" name="expirydate" id="create_expirydate" class="form-control floating datetimepicker" placeholder="dd/mm/yyyy" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-project">
                                <label>
                                    <h4>Select Project For</h4>
                                </label>
                                <div class="row">
                                    <div class="col">
                                        <input class="radioButtons" type="radio" name="typeproject" id="radiobtn-personal" value="P" checked required><?= __('Personal') ?>
                                    </div>
                                    <div class="col">
                                        <input class="radioButtons" type="radio" name="typeproject" id="radiobtn-company" value="C"><?= __('Company') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-project">
                                <label for="visibilityDiv">
                                    <h4><?= __('Project type') ?></h4>
                                </label>
                                <div id="visibilityDiv" class="row">
                                    <div class="col">
                                        <input type="radio" name="visibility" id="visibility" value="I" checked required><?= __('Internal') ?>
                                    </div>
                                    <div class="col">
                                        <input type="radio" name="visibility" id="visibility" value="E"><?= __('External') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row" id="project_priceblock" style="display: none;">
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
                    </br>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-project">
                                <label for="allowedDiv">
                                    <h4><?= __('Permissions') ?></h4>
                                </label>
                                <div id="allowedDiv" class="row">
                                    <div id="membership_request_div" class="col-6">
                                        <span class="switch mycss" id="membership_request_span">
                                            <input type="checkbox" class="switch" id="membership_request" name="membership_request">
                                        </span>
                                        <label for="membership_request_span"><?= __('Membership requests are allowed') ?></label>
                                    </div>

                                    <div id="ban_div" class="col-6">
                                        <span class="switch mycss" id="ban_span">
                                            <input type="checkbox" class="switch" id="ban" name="ban_span">
                                        </span>
                                        <label for="ban_span"><?= __('Ban is allowed') ?></label>

                                    </div>
                                    </br>
                                    <div id="invitation_div" class="col-6">
                                        <span class="switch mycss" id="invitation_span">
                                            <input type="checkbox" class="switch" id="invitation" name="invitation_span">
                                        </span>
                                        <label for="invitation_span"><?= __('Invitations are allowed') ?></label>
                                    </div>
                                    <div id="archieve_projects" class="col-6">
                                        <span class="switch mycss" id="archieve_projects">
                                            <input type="checkbox" class="switch" name="archieve_projects">
                                        </span>
                                        <label for="archieve_projects"><?= __('Archieve Project are allowed') ?></label>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-focus select-focus">
                                <label>Add Project Leader</label>
                                <select class="select floating addteamleader" name="projectleader" id="projectleader" onselect="addprojectleader()">
                                    <option disabled selected>-Select Project Leader-</option>
                                    <?php if (!empty($companymembers)) : ?>
                                        <?php foreach ($companymembers as $companymember) : ?>
                                            <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Team Leader</label>
                                <div class="project-leader" id="addteamleader">
                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-focus select-focus">
                                <label>Add Team</label>
                                <select class="select floating multiplemembers" name="projectmembers[]" multiple>
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
                            <div class="form-group">
                                <label>Team Members</label>
                                <div class="project-members">

                                </div>
                            </div>
                        </div>
                    </div>
                    </br>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" name="description" class="form-control" placeholder="<?= __('Describe your project...') ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="projectIMG"><?= __('Project Files') ?><span class="text-danger">*</span></label>
                        <?= $this->Form->control('images.',  ['type' => 'file', 'id' => 'image', 'multiple' => 'multiple', 'accept' => 'image/jpg, image/jpeg', 'label' => false]) ?>
                        <div class='label label-info' id="upload-file-info"></div>
                    </div>

            </div>
            </br>

            <div class="text-center">
                <button class="btn btn-primary margin-t-1 btn-mod-create" type="submit"> <?= __('Create project') ?> </button>
                <?php if (!empty($keyforrender)) : ?>
                    <input type="hidden" name="keyforrender" value="<?= $keyforrender ?>">
                <?php elseif (!empty($allprojects)) : ?>
                    <input type="hidden" name="allprojects" value="allprojects">
                <?php elseif (!empty($futureorojects)) : ?>
                    <input type="hidden" name="futureprojects" value="<?= $futureorojects ?>">
                <?php endif; ?>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- /Create Project Modal -->
<script>
    $(function() {
        $(document).ready(function() {
            function formatText(icon) {
                return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
                console.log("hh")
            };


            $('.select2-icon').select2({

                width: "100%",
                templateSelection: formatText,
                templateResult: formatText
            });

            var values;

            $(".multiplemembers").on("select2:select", function(event) {
                values = [];
                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    values[i] = parseInt($(selected).val());
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
                            $('.project-members').html(str);
                        },
                        error: function() {}
                    })
                });
            });

            var teamleader

            $(".addteamleader").on("select2:select", function(event) {
                teamleader = [];
                // copy all option values from selected
                $(event.currentTarget).find("option:selected").each(function(i, selected) {
                    teamleader[i] = parseInt($(selected).val());
                    $.ajax({
                        url: '/project-object/addedmembers',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            'values': JSON.stringify(teamleader)
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
                            $('#addteamleader').html(str);
                        },
                        error: function() {}
                    })
                });
            });







            $("#create_startdate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();

                var splittedDate = $("#create_startdate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];

                var createstartdate = moment(dateToString).format("YYYY-MM-DD");
                var todaydate = moment().format("YYYY-MM-DD");


                if ((createstartdate) < (todaydate)) {

                    $('#errormessage').append('<p id="ptagerrorMessage" style="color:red;"class="message">Start date cannot be less than Today date</p>');

                }
            });

            $("#create_expirydate").datetimepicker().on('dp.change', function() {
                $('#ptagerrorMessage').remove();

                var splittedDate = $("#create_startdate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var createstartdate = new Date(dateToString);

                var splittedDate = $("#create_expirydate").val().split("/");
                var dateToString = splittedDate[2] + "-" + splittedDate[1] + "-" + splittedDate[0];
                var createExpiryDate = new Date(dateToString);
                var todaydate = $("#currentdate").val();
                if (createExpiryDate <= createstartdate) {
                    $('#errormessage_expirydate').append('<p id="ptagerrorMessage" style="color:red;"class="message">Expiry date Must be Greater than Start Date</p>');
                }
            });



            //00000000000000000000000000


            $('.radioButtons').click(function() {
                if ($("#radiobtn-company").prop("checked")) {
                    $('#project_priceblock').show();
                }
                if ($("#radiobtn-personal").prop("checked")) {
                    $('#project_priceblock').hide();
                }
            });
        });
    });
</script>
