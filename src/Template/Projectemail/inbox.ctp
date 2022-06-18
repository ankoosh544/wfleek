<?= $this->element('projectemail_sidebar') ?>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Inbox</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="/projectemail/composeEmail" class="btn add-btn"><i class="fa fa-plus"></i> Compose</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="email-header">
                            <div class="row">

                                <div class="col top-action-left">
                                    <div class="float-left">
                                        <div class="btn-group dropdown-action">
                                            <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">Select <i class="fa fa-angle-down "></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" onclick="allmails();" href="#">All</a>
                                                <a class="dropdown-item" onclick="nonemails();" href="#">None</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" onclick="readmails();" href="#">Read</a>
                                                <a class="dropdown-item" onclick="unreadmails();" href="#">Unread</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-action">
                                            <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">Actions <i class="fa fa-angle-down "></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" onclick="replytomail();" href="#">Reply</a>
                                                <a class="dropdown-item" onclick="forwardmail();" href="#">Forward</a>
                                                <!--  <a class="dropdown-item" href="#">Archive</a> -->
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" onclick="markasRead();" href="#">Mark As Read</a>
                                                <a class="dropdown-item" onclick="markasUnread();" href="#">Mark As Unread</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" onclick="deleteallmails();" href="#">Delete</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-action">
                                            <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown"><i class="fa fa-folder"></i> <i class="fa fa-angle-down"></i></button>
                                            <div role="menu" class="dropdown-menu">
                                                <a class="dropdown-item" onclick="starredmails();" href="#">Starred</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" onclick="sentmails();" href="#">Sent</a>
                                                <a class="dropdown-item" onclick="trashmails();" href="#">Trash</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" onclick="newmails();" href="#">New</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-action">
                                            <button type="button" data-toggle="dropdown" class="btn btn-white dropdown-toggle"><i class="fa fa-tags"></i> <i class="fa fa-angle-down"></i></button>
                                            <div role="menu" class="dropdown-menu">
                                                <a class="dropdown-item" onclick="workrelated();" href="#">Work</a>
                                                <a class="dropdown-item" onclick="personalrelated();" href="#">Personal</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="float-left d-none d-sm-block">
                                        <input type="text" id="myInput" onkeyup="myFunction(this)" placeholder="Search Messages" class="form-control search-message">
                                    </div>
                                </div>

                                <div class="col-auto top-action-right">
                                    <div class="text-right">
                                        <button type="button" title="Refresh" data-toggle="tooltip" id="refresh" class="btn btn-white d-none d-md-inline-block"><i class="fa fa-refresh"></i></button>
                                        <div class="btn-group">
                                            <a class="btn btn-white"><i class="fa fa-angle-left"></i></a>
                                            <a class="btn btn-white"><i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-muted d-none d-md-inline-block">Showing 10 of 112 </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!------------------------------------------------------------------------------>

                        <div class="email-content" id="inbox" style="background: azure;">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-inbox table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="6">
                                                <input type="checkbox" id="parentcheckbox" class="checkbox-all">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody">

                                        <!----- Parent mail id is null----->
                                        <?php if (!empty($projectemails )) : ?>
                                            <?php foreach ($projectemails as $key => $projectemail) : ?>

                                                <?php if (/* $projectemail->fromuser_id != $user_id &&   */$projectemail->parentemail_id == null) : ?>
                                                    <?php $total = 0;
                                                    $total = count($projectemail->childmails);
                                                    ?>
                                                    <?php if ($projectemail->isRead == false) : ?>
                                                        <tr id="myrow_<?= $key ?>" class="unreadmails">
                                                            <td>
                                                                <input type="checkbox" id="unreadcheckbox_<?= $projectemail->id ?>" class="checkmail" value="<?= $projectemail->id ?>" />
                                                            </td>
                                                            <td><span class="mail-importlant">
                                                                    <?php if ($projectemail->isStarred == 0) : ?>
                                                                        <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star-o" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                    <?php else : ?>
                                                                        <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                    <?php endif; ?>

                                                                </span></td>

                                                            <?php if ($projectemail->from_user) : ?>

                                                                <td class="name"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                        <div style="color: black;" onclick="isread(<?= $projectemail->id ?>)"><?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?></div>
                                                                    </a></td>
                                                            <?php endif; ?>
                                                            <?php if ($total > 0) : ?>
                                                                <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                        <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: black;"> <?= $projectemail->subject ?> <span style="color: black;"></span></div>
                                                                    </a></td>
                                                            <?php else : ?>
                                                                <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                        <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: black;"><?= $projectemail->subject ?></div>
                                                                    </a></td>
                                                            <?php endif; ?>



                                                            <td><i class="fa fa-paperclip"></i></td>
                                                            <td class="mail-date"><?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                                            <td> <span class="action-circle large delete-btn" title="Delete EMail">
                                                                    <a href="/projectemail/deleteEmail/<?= $projectemail->id ?>"> <i class="material-icons">delete</i></a>
                                                                </span></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php if ($projectemail->isRead == true) : ?>
                                                        <tr id="myrow_<?= $key ?>" class="readmails" style="color: blueviolet;">
                                                            <td>

                                                                <input id="readcheckbox_<?= $projectemail->id ?>" type="checkbox" class="checkmail" value="<?= $projectemail->id ?>">
                                                            </td>
                                                            <td><span class="mail-important">
                                                                    <?php if ($projectemail->isStarred == 0) : ?>
                                                                        <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star-o" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                    <?php else : ?>
                                                                        <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                    <?php endif; ?>

                                                                </span></td>

                                                            <?php if ($projectemail->from_user) : ?>
                                                                <td class="name"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                        <div style="color: blueviolet;" onclick="isread(<?= $projectemail->id ?>)"><?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?></div>
                                                                    </a></td>
                                                            <?php endif; ?>




                                                            <?php if ($total > 0) : ?>
                                                                <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                        <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: blueviolet;"> <?= $projectemail->subject ?> <span style="color: black;"><!-- (<?= $total ?>) --></span></div>
                                                                    </a></td>
                                                            <?php else : ?>
                                                                <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                        <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: blueviolet;"><?= $projectemail->subject ?></div>
                                                                    </a></td>
                                                            <?php endif; ?>



                                                            <td><i class="fa fa-paperclip"></i></td>
                                                            <td class="mail-date"><?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                                            <td> <span class="action-circle large delete-btn" title="Delete EMail">
                                                                    <a href="/projectemail/deleteEmail/<?= $projectemail->id ?>"> <i class="material-icons">delete</i></a>
                                                                </span></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <?php $total = 0;
                                                    $total = count($projectemail->childmails) ?>
                                                        <?php if ($projectemail->isRead == false) : ?>
                                                            <tr id="myrow_<?= $key ?>" class="unreadmails">
                                                                <td>
                                                                    <input type="checkbox" id="unreadcheckbox_<?= $projectemail->id ?>" class="checkmail" value="<?= $projectemail->id ?>" />
                                                                </td>
                                                                <td><span class="mail-importlant">
                                                                        <?php if ($projectemail->isStarred == 0) : ?>
                                                                            <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star-o" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                        <?php else : ?>
                                                                            <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                        <?php endif; ?>

                                                                    </span></td>

                                                                <?php if ($projectemail->from_user) : ?>

                                                                    <td class="name"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                            <div style="color: black;" onclick="isread(<?= $projectemail->id ?>)"><?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?></div>
                                                                        </a></td>
                                                                <?php endif; ?>


                                                                <?php if ($total > 0) : ?>
                                                                    <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                            <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: black;"> <?= $projectemail->subject ?> <span style="color: black;"></span></div>
                                                                        </a></td>
                                                                <?php else : ?>
                                                                    <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                            <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: black;"><?= $projectemail->subject ?></div>
                                                                        </a></td>
                                                                <?php endif; ?>



                                                                <td><i class="fa fa-paperclip"></i></td>
                                                                <td class="mail-date"><?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                                                <td> <span class="action-circle large delete-btn" title="Delete EMail">
                                                                        <a href="/projectemail/deleteEmail/<?= $projectemail->id ?>"> <i class="material-icons">delete</i></a>
                                                                    </span></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        <?php if ($projectemail->isRead == true) : ?>
                                                            <tr id="myrow_<?= $key ?>" class="readmails" style="color: blueviolet;">
                                                                <td>
                                                                    <input id="readcheckbox_<?= $projectemail->id ?>" type="checkbox" class="checkmail" value="<?= $projectemail->id ?>">
                                                                </td>
                                                                <td><span class="mail-important">
                                                                        <?php if ($projectemail->isStarred == 0) : ?>
                                                                            <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star-o" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                        <?php else : ?>
                                                                            <i id="star_for_email_<?= $projectemail->id ?>" class="fa fa-star" onclick="toggleStar(<?= $projectemail->id ?>); return false;"></i>
                                                                        <?php endif; ?>
                                                                    </span></td>
                                                                <?php if ($projectemail->from_user) : ?>
                                                                    <td class="name"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                            <div style="color: blueviolet;" onclick="isread(<?= $projectemail->id ?>)"><?= $projectemail->from_user->firstname ?> <?= $projectemail->from_user->lastname ?></div>
                                                                        </a></td>
                                                                <?php endif; ?>



                                                                <?php if ($total > 0) : ?>
                                                                    <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                            <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: blueviolet;"> <?= $projectemail->subject ?> <span style="color: black;"><!-- (<?= $total ?>) --></span></div>
                                                                        </a></td>
                                                                <?php else : ?>
                                                                    <td class="subject"> <a href="/projectemail/view/<?= $projectemail->id ?>">
                                                                            <div onclick="isread(<?= $projectemail->id ?>)" style="width: 100%;height: 100%;color: blueviolet;"><?= $projectemail->subject ?></div>
                                                                        </a></td>
                                                                <?php endif; ?>



                                                                <td><i class="fa fa-paperclip"></i></td>
                                                                <td class="mail-date"><?= $projectemail->send_date->i18nFormat('dd/MM/yyyy HH:mm:ss', 'Europe/Rome') ?></td>
                                                                <td> <span class="action-circle large delete-btn" title="Delete EMail">
                                                                        <a href="/projectemail/deleteEmail/<?= $projectemail->id ?>"> <i class="material-icons">delete</i></a>
                                                                    </span></td>
                                                            </tr>
                                                        <?php endif; ?>


                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

</div>
<!-- /Page Content -->

</div>
<!-- /Page Wrapper -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            console.log(td);
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
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


    $('#refresh').click(function() {
        location.reload();
        console.log('Refresh Done');
    });

    function toggleStar(mid) {
        var realClass = $("#star_for_email_" + mid).attr("class");
        var controlsEnabled = 0;

        if (realClass == "fa fa-star") {
            controlsEnabled = 0;
        } else {
            controlsEnabled = 1;
        }

        $.ajax({
            url: '/projectemail/starredemails',
            method: 'post',
            dataType: 'json',
            data: {
                'mid': mid,
                'controlsEnabled': controlsEnabled
            },
            success: function(data) {
                console.log(data);
                if (data.isStarred) {
                    controlsEnabled = true;
                    $("#star_for_email_" + mid).attr("class", "fa fa-star");
                } else {
                    controlsEnabled = false;
                    $("#star_for_email_" + mid).attr("class", "fa fa-star-o");
                }
            },

            error: function() {

            }
        });
    }

    function isread(mid) {

        $.ajax({
            url: '/projectemail/isreadInbox',
            method: 'post',
            dataType: 'json',
            data: {
                'mid': mid
            },
            success: function(data) {
                console.log(data);

            },

            error: function() {

            }
        });


    }

    function searchMails() {
        var mailtype = $('#mailtype').val();
        if (mailtype == 'all') {
            $('#inbox').hide()
            $('#allEmails').show()

        }

        if (mailtype == 'read') {


            $('#inbox').hide()
            $('#readMails').show();
        }

        if (mailtype == 'unread') {

            $('#inbox').hide()
            $('#unreadMails').show();
        }

        console.log(mailtype);
    }


    $("#parentcheckbox").on("click", function() {
        var temp;
        console.log('check function');

        $('input:checkbox').prop('checked', this.checked);

        console.log(temp, 'checking');


        // $("#checkbox").prop("checked", false);


    });

    var i = 0;
    $('#parentcheckbox').click(function() {
        var arr = [];

        $('.checkmail:checked').each(function() {
            arr[i++] = $(this).val();
        });
        console.log(arr, 'This is all checked mails');
    });


    function allmails() {

        $('input:checkbox').prop('checked', true);

    }

    function nonemails() {
        $('input:checkbox').prop('checked', false);

    }

    function readmails() {
        $('.readmails').show();
        $('.unreadmails').hide();
        $('input:checkbox').prop('checked', true);
        $('.unreadmails input:checkbox').prop('checked', false);

    }

    function unreadmails() {
        $('.readmails').hide();
        $('.unreadmails').show();
        $('input:checkbox').prop('checked', true);
        $('.readmails input:checkbox').prop('checked', false);
    }


    //deleteall mails
    var j;

    function deleteallmails() {

        var deletemail = [];

        $('.checkmail:checked').each(function() {
            deletemail.push($(this).val());
        });


        $.ajax({
            url: '/projectemail/deleteallmails',
            method: 'post',
            dataType: 'json',
            data: {
                'deletemail': deletemail
            },
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'result');

                var str = "";
                data.forEach((mail, key) => {

                    if (mail.isRead == false) {
                        str += ' <tr id="myrow_' + key + '" class="unreadmails">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color:black;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies.length >= 1) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';
                    } else {
                        str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';


                    }



                });
                $('#tablebody').html(str);

            },

            error: function() {

            }
        });


    }


    function markasRead() {
        console.log('markasRead');
        var readmails = [];

        $('.checkmail:checked').each(function() {
            readmails.push($(this).val());
        });
        console.log(readmails, 'readmails');

        $.ajax({
            url: '/projectemail/markasReadandUnreadmails',
            method: 'post',
            dataType: 'json',
            data: {
                'readmails': readmails
            },
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'result');

                var str = "";
                data.forEach((mail, key) => {

                    if (mail.isRead == false) {
                        str += ' <tr id="myrow_' + key + '" class="unreadmails">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color:black;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies.length > 0) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';
                    } else {
                        str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies.length > 0) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';


                    }

                });
                $('#tablebody').html(str);

            },

            error: function() {

            }
        });



    }

    function markasUnread() {
        console.log('Markas unread');

        var unreadmails = [];

        $('.checkmail:checked').each(function() {
            unreadmails.push($(this).val());
        });
        console.log(unreadmails, 'markas Unreadmails');

        $.ajax({
            url: '/projectemail/markasReadandUnreadmails',
            method: 'post',
            dataType: 'json',
            data: {
                'unreadmails': unreadmails
            },
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'result');

                var str = "";
                data.forEach((mail, key) => {


                    if (mail.isRead == false) {
                        str += ' <tr id="myrow_' + key + '" class="unreadmails">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color:black;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';
                    } else {
                        str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';


                    }



                });
                $('#tablebody').html(str);

            },

            error: function() {

            }
        });

    }














    ////////////////////////////////////////////////////////////////

    function starredmails() {
        $.ajax({
            url: '/projectemail/allmaildata',
            /*  method: 'post', */
            dataType: 'json',
            /*  data: {
                 'mid': mid
             }, */
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'result');

                var str = "";
                data.forEach((mail, key) => {
                    if (mail.isStarred == true) {
                        console.log(mail, 'starred');
                        if (mail.isRead == false) {
                            str += ' <tr id="myrow_' + key + '" class="unreadmails">' +
                                '<td>' +
                                '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                                '</td>' +
                                '<td><span class="mail-important">';
                            if (mail.isStarred == false) {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            } else {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            }
                            str += '</span></td>' +
                                '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div style="color:black;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                                '</a></td>';


                            if (mail.replies > 0) {
                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                    '</a></td>';
                            } else {

                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + '</div>' +
                                    '</a></td>';

                            }
                            str += '<td><i class="fa fa-paperclip"></i></td>' +
                                '<td class="mail-date">' + mail.send_date + '</td>' +
                                '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                                '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                                '</span></td>' +
                                '</tr>';
                        } else {
                            str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                                '<td>' +
                                '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                                '</td>' +
                                '<td><span class="mail-important">';
                            if (mail.isStarred == false) {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            } else {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            }
                            str += '</span></td>' +
                                '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                                '</a></td>';


                            if (mail.replies > 0) {
                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                    '</a></td>';
                            } else {

                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                    '</a></td>';

                            }
                            str += '<td><i class="fa fa-paperclip"></i></td>' +
                                '<td class="mail-date">' + mail.send_date + '</td>' +
                                '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                                '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                                '</span></td>' +
                                '</tr>';


                        }
                    }

                });
                $('#tablebody').html(str);

            },

            error: function() {

            }
        });


    }


    function sentmails() {
        $.ajax({
            url: '/projectemail/sentMails',
            /*  method: 'post', */
            dataType: 'json',
            /*  data: {
                 'mid': mid
             }, */
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'result');

                var str = "";
                data.forEach((mail, key) => {
                    if (mail.isSent == true) {
                        str += ' <tr id="myrow_' + key + '" class="unreadmails">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';


                        if (mail.replies > 0) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {

                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + '</div>' +
                                '</a></td>';

                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';
                    }

                });
                $('#tablebody').html(str);

            },

            error: function() {

            }
        });

    }
    function trashmails() {
        $.ajax({
            url: '/projectemail/deletedmails',
            /*  method: 'post', */
            dataType: 'json',
            /*  data: {
                 'mid': mid
             }, */
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'trashmails');

                var str = "";
                data.forEach((mail, key) => {

                    console.log('delete');
                    if (mail.isDeleted == 1) {
                        console.log(mail, 'thisis deleted');
                        if (mail.isRead == false) {
                            str += ' <tr id="myrow_' + key + '" class="unreadmails">' +
                                '<td>' +
                                '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                                '</td>' +
                                '<td><span class="mail-important">';
                            if (mail.isStarred == false) {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            } else {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            }
                            str += '</span></td>' +
                                '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div style="color:black;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                                '</a></td>';


                            if (mail.replies.length > 0) {
                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                    '</a></td>';
                            } else {

                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%">' + mail.subject + '</div>' +
                                    '</a></td>';

                            }
                            str += '<td><i class="fa fa-paperclip"></i></td>' +
                                '<td class="mail-date">' + mail.send_date + '</td>' +
                                '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                                '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                                '</span></td>' +
                                '</tr>';
                        } else {
                            str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                                '<td>' +
                                '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                                '</td>' +
                                '<td><span class="mail-important">';
                            if (mail.isStarred == false) {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            } else {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            }
                            str += '</span></td>' +
                                '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                                '</a></td>';


                            if (mail.replies > 0) {
                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                    '</a></td>';
                            } else {

                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                    '</a></td>';

                            }
                            str += '<td><i class="fa fa-paperclip"></i></td>' +
                                '<td class="mail-date">' + mail.send_date + '</td>' +
                                '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                                '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                                '</span></td>' +
                                '</tr>';


                        }
                    }
                });
                $('#tablebody').html(str);
            },
            error: function() {}
        });
    }





    //work label

    function workrelated() {
        $.ajax({
            url: '/projectemail/allmaildata',
            /*  method: 'post', */
            dataType: 'json',
            /*  data: {
                 'mid': mid
             }, */
            success: function(data) {
                $('#tablebody').empty();
                console.log(data, 'work');
                var str = "";
                data.forEach((mail, key) => {
                    console.log('work relates');
                    if (mail.worklable == 'W') {
                        str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                            '<td>' +
                            '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                            '</td>' +
                            '<td><span class="mail-important">';
                        if (mail.isStarred == false) {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        } else {
                            str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                        }
                        str += '</span></td>' +
                            '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                            '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                            '</a></td>';
                        if (mail.replies > 0) {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                '</a></td>';
                        } else {
                            str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                '</a></td>';
                        }
                        str += '<td><i class="fa fa-paperclip"></i></td>' +
                            '<td class="mail-date">' + mail.send_date + '</td>' +
                            '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                            '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                            '</span></td>' +
                            '</tr>';
                    }
                });
                $('#tablebody').html(str);
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        });

    }



    function personalrelated() {
        $.ajax({
            url: '/projectemail/allmaildata',
            /*  method: 'post', */
            dataType: 'json',
            /*  data: {
                 'mid': mid
             }, */
            success: function(data) {
                $('#tablebody').empty();

                var str = "";
                data.forEach((mail, key) => {
                    console.log(data, 'personal relates');
                    if (mail.worklable == 'P') {
                            str += ' <tr id="myrow_' + key + '" class="readmails" style="color: blueviolet;">' +
                                '<td>' +
                                '<input type="checkbox" id="unreadcheckbox_' + mail.id + '" class="checkmail" value="' + mail.id + '" />' +
                                '</td>' +
                                '<td><span class="mail-important">';
                            if (mail.isStarred == false) {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star-o" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            } else {
                                str += '<i id="star_for_email_' + mail.id + '" class="fa fa-star" onclick="toggleStar(' + mail.id + '); return false;"></i>';
                            }
                            str += '</span></td>' +
                                '<td class="name"> <a href="/projectemail/view/' + mail.id + '">' +
                                '<div style="color: blueviolet;" onclick="isread(' + mail.id + ')">' + mail.from_user.firstname + ' ' + mail.from_user.lastname + '</div>' +
                                '</a></td>';
                            if (mail.replies > 0) {
                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + ' <span style="color: black;">(' + mail.replies.length + ')</span></div>' +
                                    '</a></td>';
                            } else {
                                str += '<td class="subject"> <a href="/projectemail/view/' + mail.id + '">' +
                                    '<div onclick="isread(' + mail.id + ')" style="width: 100%;height: 100%";color: blueviolet;>' + mail.subject + '</div>' +
                                    '</a></td>';
                            }
                            str += '<td><i class="fa fa-paperclip"></i></td>' +
                                '<td class="mail-date">' + mail.send_date + '</td>' +
                                '<td> <span class="action-circle large delete-btn" title="Delete EMail">' +
                                '<a href="/projectemail/deleteEmail/' + mail.id + '"> <i class="material-icons">delete</i></a>' +
                                '</span></td>' +
                                '</tr>';
                    }
                });
                $('#tablebody').html(str);
            },
            error: function(a, b, c) {
                console.log(a, b, c);
            }
        });

    }


    function replytomail() {
        var mailid = $('.checkmail').prop('checked', true).val();
        console.log(mailid, 'checkedmail');


    }
</script>
