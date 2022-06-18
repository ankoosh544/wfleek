<?= $this->element('projectemail_sidebar') ?>
<style>
    .del-msg {
        color: red;
        display: none;
    }

    .title:hover .del-msg {
        display: block
    }
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Compose</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Compose</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <?php if ($draftMail == null) : ?>

                            <div class="">
                                <div class="form-group form-focus select-focus m-b-30">
                                    <select id="toemailaddresses" placeholder="To" class="select2-icon floating" name="toemail" multiple>
                                        <?php foreach ($allUsers as $singleUser) : ?>
                                            <?php if (in_array($singleUser->id, $allprojectuserIds)) : ?>
                                                <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="focus-label">To</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus select-focus">
                                        <select id="ccemailaddresses" class="select2-icon floating" name="cc" multiple>
                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                <?php if (in_array($singleUser->id, $allprojectuserIds)) : ?>
                                                    <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="focus-label">cc</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus select-focus">
                                        <select id="bccemailaddresses" class="select2-icon floating" name="bcc" multiple>
                                            <?php foreach ($allUsers as $singleUser) : ?>
                                                <?php if (in_array($singleUser->id, $allprojectuserIds)) : ?>
                                                    <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <label class="focus-label">Bcc</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="subject" type="text" id="compose_subject" placeholder="Subject" class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea name="body" rows="4" class="form-control summernote" id="compose_body" placeholder="Enter your message here"></textarea>
                            </div>

                            <div class="form-group mb-0">
                                <div class="form-group">
                                    <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images" name="images" type="file" multiple />
                                    <?php if ($projectfile != null) : ?>
                                        <ul>
                                            <li>
                                                <a href=""><?= $projectfile->filename ?></a>
                                            </li>
                                        </ul>
                                        <input type="hidden" id="sharedfid" name="sharefid" value="<?= $projectfile->id ?>">
                                    <?php endif; ?>
                                    <input type="hidden" id="fileattached" name="sharefid" value="1">
                                    <input type=hidden value="' + pid + '" name=projectId>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" onclick="sendfunction(null)"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>
                                    <button class="btn btn-success m-l-5" onclick="senddraftfunction()"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>
                                    <button class="btn btn-success m-l-5" type="button" onclick="deleteComposeDiv();"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>
                                </div>
                            </div>

                            <!----------------Draft mail--------->
                        <?php else : ?>
                            <div class="">
                                <div class="form-group form-focus select-focus m-b-30">
                                    <select id="toemailaddresses" placeholder="To" class="select2-icon floating" name="toemail" multiple>
                                        <?php if ($draftMail->tousers) : ?>
                                            <?php foreach ($draftMail->tousers as $touser) : ?>
                                                <?php foreach ($allUsers as $singleUser) : ?>
                                                    <?php if ($singleUser->id == $touser->user->id) : ?>
                                                        <option selected value="<?= $touser->user->id ?>"><?= $touser->user->email ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </select>
                                    <label class="focus-label">To</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus select-focus">
                                        <select id="ccemailaddresses" class="select2-icon floating" name="cc" multiple>
                                            <?php if ($draftMail->ccusers) : ?>
                                                <?php foreach ($draftMail->ccusers as $ccuser) : ?>
                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                        <?php if ($singleUser->id == $ccuser->user->id) : ?>
                                                            <option selected value="<?= $ccuser->user->id ?>"><?= $ccuser->user->email ?></option>
                                                        <?php else : ?>
                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <label class="focus-label">cc</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus select-focus">
                                        <select id="bccemailaddresses" class="select2-icon floating" name="bcc" multiple>
                                            <?php if ($draftMail->bccusers) : ?>
                                                <?php foreach ($draftMail->bccusers as $bccuser) : ?>
                                                    <?php foreach ($allUsers as $singleUser) : ?>
                                                        <?php if ($singleUser->id == $bccuser->user->id) : ?>
                                                            <option selected value="<?= $bccuser->user->id ?>"><?= $bccuser->user->email ?></option>
                                                        <?php else : ?>
                                                            <option value="<?= $singleUser->id ?>"><?= $singleUser->email ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <label class="focus-label">Bcc</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="subject" type="text" id="compose_subject" value="<?= $draftMail->subject ?>" placeholder="Subject" class="form-control">
                            </div>
                            <div class="form-group">
                                <textarea name="body" rows="4" class="form-control summernote" id="compose_body" placeholder="Enter your message here"><?= $draftMail->body ?></textarea>
                            </div>

                            <div class="form-group mb-0">
                                <div class="form-group">
                                    <input class="form-control" accept="image/jpeg,image/jpg,image/gif,image/png" id="images" name="images" type="file" multiple />
                                    <div id="allfilelinks">
                                        <?php if ($draftMail->emailfiles) : ?>
                                            <?php foreach ($draftMail->emailfiles as $emailfile) : ?>
                                                <ul class="title">
                                                    <li>
                                                        <a class="titlelink" class="form-control" name="autoattachment" href='/<?= $emailfile->filepath ?>/<?= $emailfile->filename ?>' id="img" alt="img"><?= $emailfile->filename ?></a>

                                                        <a class="del-msg" onclick="deletefile(<?= $emailfile->id ?>,<?= $draftMail->id ?>)"><i class="fa fa-close"></i></a>
                                                        <input type="hidden" value="<?= $emailfile->id ?>">
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" onclick="sendfunction(<?= $draftMail->id ?>)"><span>Send</span> <i class="fa fa-send m-l-5"></i></button>
                                    <button class="btn btn-success m-l-5" onclick="senddraftfunction()"><span>Draft</span> <i class="fa fa-floppy-o m-l-5"></i></button>
                                    <button class="btn btn-success m-l-5" type="button" onclick="deleteComposeDiv();"><span>Delete</span> <i class="fa fa-trash-o m-l-5"></i></button>
                                </div>
                            </div>


                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-alpha14/css/tempus-dominus.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>




<!-- <link rel="stylesheet" href="/path/to/css/jquery.multi-emails.css" />
<script src="/path/to/cdn/jquery.slim.min.js"></script>
<script src="/path/to/js/jquery.multi-emails.js"></script> -->
<script>
    var tovalues;
    var ccvalues;
    var bccvalues;
    $("#toemailaddresses").on("select2:select", function(event) {
        console.log('hi toemails')
        tovalues = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            tovalues[i] = parseInt($(selected).val());
        });
        console.log(tovalues);
    });
    $("#ccemailaddresses").on("select2:select", function(event) {
        console.log('hi ccemails')
        ccvalues = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            ccvalues[i] = parseInt($(selected).val());
        });
    });

    $("#bccemailaddresses").on("select2:select", function(event) {
        console.log('hi bccemails')
        bccvalues = [];

        // copy all option values from selected
        $(event.currentTarget).find("option:selected").each(function(i, selected) {
            bccvalues[i] = parseInt($(selected).val());
        });
    });


    function sendfunction(drafteid) {


        var body = $('#compose_body').val();
        var subject = $('#compose_subject').val();

        var file_data = $("#images").prop("files");
        var attach = $('#fileattached').val();
        console.log(attach, 'fileeeeeeeeeee');


        console.log(attach, 'this is shard');


        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = 123;
        }

        if (tovalues == null && ($('#toemailaddresses').val().length > 0)) {
            var to = $('#toemailaddresses').val();
            tovalues = to;
        }
        if (ccvalues == null && ($('#ccemailaddresses').val().length > 0)) {
            var cc = $('#ccemailaddresses').val();
            ccvalues = cc;
        }
        if (bccvalues == null && ($('#bccemailaddresses').val().length > 0)) {
            var bcc = $('#bccemailaddresses').val();
            bccvalues = bcc;
        }

        if (attach != null) {
            console.log('shared file is not null')
            var sharedfile = $('#sharedfid').val();
            form_data.append('sharedfile', sharedfile);
        }
        form_data.append("drafteid", drafteid);
        form_data.append("subject", subject);
        form_data.append("body", body);
        form_data.append("bccvalues", JSON.stringify(bccvalues));
        form_data.append("ccvalues", JSON.stringify(ccvalues));
        form_data.append("tovalues", JSON.stringify(tovalues));
        form_data.append("isFileNotAttached", isFileNotAttached);
        $.ajax({
            url: '/projectemail/sendemail/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                console.log(data, 'sucessData');
                window.location = '/projectemail/inbox';
            },
            error: function(e) {}
        });
    }

    function formatText(icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        console.log("hh")
    };
    $('.select2-icon').select2({
        width: "100%",
        templateSelection: formatText,
        templateResult: formatText
    });

    function senddraftfunction() {
        var body = $('#compose_body').val();
        var subject = $('#compose_subject').val();
        console.log(subject, 'subject');
        var file_data = $("#images").prop("files");
        console.log(file_data, 'filedata');
        var form_data = new FormData();
        var isFileNotAttached = 0;
        if (file_data.length > 0) {
            for (var i = 0; i < file_data.length; i++) {
                form_data.append("file[]", file_data[i]);
            }
        } else {
            isFileNotAttached = 123;
        }
        form_data.append("subject", subject);
        form_data.append("body", body);
        form_data.append("bccvalues", JSON.stringify(bccvalues));
        form_data.append("ccvalues", JSON.stringify(ccvalues));
        form_data.append("tovalues", JSON.stringify(tovalues));
        console.log(tovalues);
        form_data.append("isFileNotAttached", isFileNotAttached);
        $.ajax({
            url: '/projectemail/senddraft/',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {
                window.location = '/projectemail/inbox';

                console.log(data);

            },
            error: function(e) {}
        });



    }

    function deletefile(fid, eid) {
        $.ajax({
            url: '/emailfiles/deletefile/',
            method: 'post',
            dataType: 'json',
            data: {
                'fid': fid,
                'eid': eid
            },
            success: function(data) {

                $('#allfilelinks').empty();
                var str;

                data.forEach((file) => {

                    str += '<ul class="title">' +
                        '<li>' +
                        '<a class="titlelink" class="form-control" name="autoattachment" href=" / ' + file.filepath + '/' + file.filename + '"   alt="img">' + file.filename + ' </a>' +
                        '<a class="del-msg" onclick="deletefile(' + file.id + ',' + file.email_id + ')"><i class="fa fa-close"></i></a>' +
                        '</li>' +
                        '</ul>';
                });

                $('#allfilelinks').html(str);


            },
            error: function(e) {}
        });
    }
    function deleteComposeDiv(){
        window.location = '/projectemail/inbox';

    }
</script>
