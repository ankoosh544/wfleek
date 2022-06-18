<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Contact Main Row -->
    <div class="chat-main-row">
        <?php if (!empty($authcompanymember->designation) && !empty($authcompanymember->designation->usermodulepermissions)) : ?>
            <?php foreach ($authcompanymember->designation->usermodulepermissions as $usermodule) : ?>
                <?php if ($usermodule->module->name == 'Contacts' && $usermodule->isRead == true) : ?>
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
                                                        <?php if ($usermodule->isCreate == true) : ?>
                                                            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_contact"><i class="fa fa-plus"></i> Add Contact</a>
                                                        <?php endif; ?>
                                                        <div class="roles-menu">
                                                            <ul>
                                                                <li class="active"><a href="/chatcontacts/contacts?companyId=<?= $companyId ?>&&type=null">All</a></li>
                                                                <li><a href="/chatcontacts/contacts?companyId=<?= $companyId ?>&&type='company'">Company</a></li>
                                                                <li><a href="/chatcontacts/contacts?companyId=<?= $companyId ?>&&type='client'" onclick="clients();">Client</a></li>
                                                                <li><a href="/chatcontacts/contacts?companyId=<?= $companyId ?>&&type='staff'" onclick="employeescontacts();">Staff</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="contacts-list col-sm-8 col-lg-9">
                                                        <ul class="contact-list">
                                                            <?php foreach ($alluserData as $singleUser) : ?>

                                                                <li>
                                                                    <div class="contact-cont">
                                                                        <div class="float-left user-img">
                                                                            <a href="/projectmember/userprofile/<?= $singleUser->id ?>" class="avatar">

                                                                                <?php if ($singleUser->to_user->profileFilepath != null && $singleUser->to_user->profileFilename != null) : ?>
                                                                                    <img class="rounded-circle" alt="" src="<?= $singleUser->to_user->profileFilepath ?>/<?= $singleUser->to_user->profileFilename ?>">
                                                                                <?php else : ?>
                                                                                    <img alt="" src="/assets/img/profiles/avatar-16.jpg">
                                                                                <?php endif; ?>
                                                                                <span class="status online"></span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="contact-info">
                                                                            <span class="contact-name text-ellipsis"><?= $singleUser->to_user->firstname ?> <?= $singleUser->to_user->lastname ?></span>

                                                                            <!--   <span class="message-content">Administrator</span> -->

                                                                            </br>
                                                                        </div>
                                                                        <ul class="contact-action">
                                                                            <li class="dropdown dropdown-action">
                                                                                <a href="" class="dropdown-toggle action-icon" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#delete_contact_<?= $singleUser->id ?>">Delete</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </li>




                                                                <!-- Delete Contact Modal -->
                                                                <div class="modal custom-modal fade" id="delete_contact_<?= $singleUser->id ?>" role="dialog">
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
                                                                                            <a href="/chatcontacts/deletecontact?contactId=<?= $singleUser->id ?>&&type=<?= $type ?>&&companyId=<?= $companyId ?>" class="btn btn-primary continue-btn">Delete</a>
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
                <?php endif; ?>
                <!-- /Contact Wrapper -->
            <?php endforeach; ?>
        <?php endif; ?>

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
                            <select id="alltaskassignuser" class="select2-icon" name="chatcontacts[]" multiple>
                                <?php foreach ($companymembers as $companymember) : ?>
                                    <?php if (!in_array($companymember->user_id, $addedcids)) : ?>
                                        <option value="<?= $companymember->user->id ?>"><?= $companymember->user->firstname ?> <?= $companymember->user->lastname ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <input type="hidden" name="rendertocontact" value="rendertocontact">
                            <input type="hidden" name="companyId" value="<?= $companyId ?>">
                            <input type="hidden" name="contacttype" value="<?= $type ?>">
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
</script>
