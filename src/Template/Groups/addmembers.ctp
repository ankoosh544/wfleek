<?php

use Cake\I18n\Number;

?>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>--->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title"></h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Group Page</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="card mb-0">
            <div class="card-body">
                <form action="/groupmembers/add/" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <h3></h3>
                        <div class="form-group form-focus select-focus">
                            <label>Select Group</label>
                            <select class="select2-icon floating multiselector" name="groupid" id="groupid">
                                <?php foreach ($companygroups as $group) : ?>
                                    <option value="<?= $group->id ?>"> <?= $group->name ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        </br>
                        <div class="form-group form-focus select-focus">
                            <label>Select Memeber</label>
                            <select class="select2-icon floating multiselector" name="memberIds[]" multiple>
                                <?php foreach ($companymembers as $member) : ?>
                                    <option value="<?= $member->user->id ?>"> <?= $member->user->firstname ?> <?= $member->user->lastname ?>(<?= $member->user->email ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        </br>

                        <div class="form-group form-focus select-focus m-b-30">
                            <label for="adddesignation"><?= __('Add Designation') ?><span class="text-danger">*</span></label>
                            <select id="selecteddesignation" class="select2-icon floating" name="adddesignation">
                                <option value="W">COORDINATOR</option>
                                <option value="X">DEVELOPER</option>
                                <option value="Y">ADMINISTRATOR</option>
                                <option value="Z">PROJECT MANAGER</option>
                                <option value="H">HR</option>
                            </select>
                        </div>
                        </br>

                        <div class="form-group footer">
                            <button type="submit" class="btn btn-info">Add</button>

                        </div>


                    </div>
                </div>

                </form>

            </div>
        </div>


    </div>

    <!-- /Page Wrapper -->
    <script>
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
        $(".multiselector").on("select2:select", function(event) {
            values = [];
            // copy all option values from selected
            $(event.currentTarget).find("option:selected").each(function(i, selected) {
                values[i] = parseInt($(selected).val());
                console.log('hi alltasks', values)
            });
        });

        function addmember() {
            role = $('#selecteddesignation').val();
            groupid = $('#groupid').val();

            var form_data = new FormData();
            form_data.append("users", JSON.stringify(values));
            form_data.append("role", role);
            form_data.append('groupid',groupid);

            $.ajax({
                url: '/groupmembers/add',
                method: 'post',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    window.location = '/groups/view/'+groupid


                },
                error: function(e) {}
            })


        }
    </script>
