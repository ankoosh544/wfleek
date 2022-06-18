<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Contact Main Row -->
    <div class="chat-main-row">

        <!-- Contact Wrapper -->
        <div class="chat-main-wrapper">
            <div class="col-lg-12 message-view">
                <div class="chat-window">
                    <div class="fixed-header">
                        <div class="row">
                            <div class="col-6">
                                <h4 class="page-title mb-0">Contacts</h4>
                            </div>
                            <div class="col-6">
                                <div class="navbar justify-content-end">
                                    <div class="search-box m-t-0">
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <span class="input-group-append">
                                                <button class="btn" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    <ul class="nav float-right custom-menu">
                                        <li class="nav-item dropdown dropdown-action">
                                            <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cog"></i></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0)">Menu 1</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Menu 2</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-contents">
                        <div class="chat-content-wrap">
                            <div class="chat-wrap-inner">
                                <div class="contact-box">
                                    <div class="row">
                                        <div class="contact-cat col-sm-4 col-lg-3">
                                            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_contact"><i class="fa fa-plus"></i> Add Contact</a>
                                            <div class="roles-menu">
                                                <ul>
                                                    <li class="active" onclick="allcontacts();"><a href="javascript:void(0);">All</a></li>
                                                    <li><a href="#" >Company</a></li>
                                                    <li><a href="#" onclick="clients();">Client</a></li>
                                                    <li><a href="#" onclick="employeescontacts();">Staff</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="contacts-list col-sm-8 col-lg-9">
                                            <ul class="contact-list">
                                                <?php foreach ($allusers as $singleUser) : ?>

                                                    <li>
                                                        <div class="contact-cont">
                                                            <div class="float-left user-img">
                                                                <a href="/projectmember/userprofile/<?= $singleUser->id ?>" class="avatar">
                                                                    <img class="rounded-circle" alt="" src="<?= $singleUser->to_user->profileFilepath ?>/<?= $singleUser->to_user->profileFilename ?>">
                                                                    <span class="status online"></span>
                                                                </a>
                                                            </div>
                                                            <div class="contact-info">
                                                                <span class="contact-name text-ellipsis"><?= $singleUser->to_user->firstname ?><?= $singleUser->to_user->lastname ?></span>
                                                                <!-- <?php foreach ($projectMembers as $member) : ?>
                                                                    <?php if ($member->memberId == $singleUser->id) : ?>
                                                                        <?php if ($member->type == 'Y') : ?>
                                                                            <span class="message-content">Administrator</span>
                                                                        <?php elseif ($member->type == 'X') : ?>
                                                                            <span class="message-content">Developer</span>
                                                                        <?php elseif ($member->type == 'Z') : ?>
                                                                            <span class="message-content">ProjectManager</span>
                                                                        <?php elseif ($member->type == 'H') : ?>
                                                                            <span class="message-content">HR</span>
                                                                        <?php elseif ($member->type == 'W') : ?>
                                                                            <span class="message-content">Co-Ordinator</span>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?> -->
                                                                </br>
                                                            </div>
                                                            <ul class="contact-action">
                                                                <li class="dropdown dropdown-action">
                                                                    <a href="" class="dropdown-toggle action-icon" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#edit_contact_<?= $singleUser->id ?>">Edit</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete_contact_<?= $singleUser->id ?>">Delete</a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>


                                                    <!-- Edit Contact Modal -->
                                                    <div class="modal custom-modal fade" id="edit_contact_<?= $singleUser->id ?>" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Contact</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form>
                                                                        <div class="form-group">
                                                                            <label>Name <span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text" value="<?= $singleUser->to_user->firstname ?> <?= $singleUser->to_user->lastname ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Email Address</label>
                                                                            <input class="form-control" type="email" value="<?= $singleUser->to_user->email ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Contact Number <span class="text-danger">*</span></label>
                                                                            <input class="form-control" type="text" value="<?= $singleUser->to_user->tel ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="d-block">Status</label>
                                                                            <div class="status-toggle">
                                                                                <input type="checkbox" id="edit_contact_status" class="check">
                                                                                <label for="edit_contact_status" class="checktoggle">checkbox</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="submit-section">
                                                                            <button class="btn btn-primary submit-btn">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /Edit Contact Modal -->


                                                    <!-- Delete Contact Modal -->
                                                    <div class="modal custom-modal fade" id="delete_contact_<?=$singleUser->id?>" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="form-header">
                                                                        <h3>Delete Contact</h3>
                                                                        <p>Are you sure want to delete?</p>
                                                                    </div>
                                                                    <div class="modal-btn delete-action">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <a href="/chatcontacts/deletecontact/<?=$singleUser->id?>" class="btn btn-primary continue-btn">Delete</a>
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
                                                    <!-- /Delete Contact Modal -->

                                                <?php endforeach; ?>

                                            </ul>
                                        </div>
                                        <div class="contact-alphapets">
                                            <div class="alphapets-inner">
                                                <a href="#">A</a>
                                                <a href="#">B</a>
                                                <a href="#">C</a>
                                                <a href="#">D</a>
                                                <a href="#">E</a>
                                                <a href="#">F</a>
                                                <a href="#">G</a>
                                                <a href="#">H</a>
                                                <a href="#">I</a>
                                                <a href="#">J</a>
                                                <a href="#">K</a>
                                                <a href="#">L</a>
                                                <a href="#">M</a>
                                                <a href="#">N</a>
                                                <a href="#">O</a>
                                                <a href="#">P</a>
                                                <a href="#">Q</a>
                                                <a href="#">R</a>
                                                <a href="#">S</a>
                                                <a href="#">T</a>
                                                <a href="#">U</a>
                                                <a href="#">V</a>
                                                <a href="#">W</a>
                                                <a href="#">X</a>
                                                <a href="#">Y</a>
                                                <a href="#">Z</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Contact Wrapper -->

    </div>
    <!-- /Contact Main Row -->


    <!-- Add Chat User Modal -->
    <div id="add_contact" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="/chatcontacts/adduser" method="post">
                        <div class="form-group form-focus select-focus m-b-30">
                            <label for="adduser"><?= __('Add Contact') ?> <span class="text-danger">*</span></label>
                            <select id="alltaskassignuser" class="select2-icon" name="chactuser">
                                <?php foreach ($alluserData as $singleUser) : ?>
                                    <?php if (!in_array($singleUser->id, $addedcids)) : ?>
                                        <option value="<?= $singleUser->id ?>"><?= $singleUser->firstname ?> <?= $singleUser->lastname ?>
                                        <?php endif; ?>

                                        </option>
                                    <?php endforeach; ?>
                            </select>

                        </div>
                        </br>
                        <div class="form-group">
                            <label class="d-block">Status</label>
                            <div class="status-toggle">
                                <input type="checkbox" id="contact_status" class="check">
                                <label for="contact_status" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <input type="hidden" name="rendertocontact" value="rendertocontact">


                        </div>

                    </form>
                </div>
            </div>
            <br />
        </div>
    </div>
    <!-- /Add Chat User Modal -->

    <!-- Add Contact Modal
    <div class="modal custom-modal fade" id="add_contact" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="email">
                        </div>
                        <div class="form-group">
                            <label>Contact Number <span class="text-danger">*</span></label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Status</label>
                            <div class="status-toggle">
                                <input type="checkbox" id="contact_status" class="check">
                                <label for="contact_status" class="checktoggle">checkbox</label>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     /Add Contact Modal -->




</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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

    function companyEmployeesData() {
        $.ajax({
            url: '/projecttasks/companyEmployees',
            /*   method: 'post', */
            dataType: 'json',
            /*  data: {
                 'taskId': taskId, //taskid
                 'status': taskStatus,
             }, */
            success: function(data) {
                $('#todotaskinfo').append(taskdata);
            },
            error: function() {

            }
        })


    }

    function clients(){
        window.location = '/chatcontacts/clientcontacts';

    }

    function employeescontacts(){
        window.location = '/chatcontacts/employeescontacts';
    }

    function allcontacts(){
        window.location = '/chatcontacts/contacts';

    }
</script>
