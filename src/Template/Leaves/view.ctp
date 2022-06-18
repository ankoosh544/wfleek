<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

<style>
    #employeeLeaves {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #employeeLeaves td,
    #employeeLeaves th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #employeeLeaves tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #employeeLeaves tr:hover {
        background-color: #ddd;
    }

    #employeeLeaves th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }






    #taskbtns {
        background: white;
        color: black;
        border: 2px solid black;
        /* Green */
        border-radius: 31px;
    }

    #taskbtns:hover {
        background-color: black;
        /* Green */
        color: white;
    }

    /*this is draggable code
    #mydiv {
        position: absolute;
        z-index: 9;

        border: 1px solid #d3d3d3;
        text-align: center;
    }

    #mydivheader {
        padding: 10px;
        cursor: move;
        z-index: 10;

    }*/
    /* background: url('https://api.iconify.design/fluent:text-description-24-filled.svg') no-repeat center center / contain;
    content: url('https://api.iconify.design/fluent:text-description-24-filled.svg?height=24');
vertical-align: -0.125em;*/

    /* block belongs to hide the tabcontent on click create*/
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .sub-project-comments {
        border-bottom: 1px solid #e6e6e6;
        overflow: hidden;
        padding-bottom: 1em
    }

    .sub-project-comment {
        display: inline-block;
        clear: both;
        padding: 20px;
        border-radius: 30px;
        margin: 0em 2em 0.5em 2em;
        font-family: Helvetica, Arial, sans-serif;
        float: left;
        background: #eee
    }

    .comment-wrapper {
        display: flex;
        margin-top: 1em;
    }

    .slcomment {
        margin-right: 1em
    }

    .project-info1 {
        /*white-space: nowrap;*/
        overflow: hidden;
        /*border-left:1em solid transparent;
    border-right:1em solid transparent;*/
        text-overflow: ellipsis;
    }

    .attachment {
        border: 1px solid #bbbbbb;
        border-radius: 7px;
        padding: 0.5em 0.5em 0.5em 1em;
        margin-bottom: 0.5em;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .attachmentName {
        margin: 0 0 0 1em
    }
</style>

<div class="topbar-wrapper">

    <div class="logo"><a href="/"><img src="/images/epebook-logo.png" alt="epebook" title="epebook" width="179"> <img src="/images/epebook-icon.png" alt="epebook" title="epebook" width="42" class="icon"></a></div>
    <div class="container">
        <div class="flex-box">
            <div class="page-title">
                <?= __('Projects') ?>
            </div>
            <div class="search-wrapper has-other-icons">
                <!--<form action="#">-->
                <input id="searchBoxInput" name="searchBoxInput" type="text" class="form-control search-input" placeholder="Cerca Progetti">
                <!--</form>-->
                <div class="other-actions">

                </div>
            </div>

            <div class="icons-wrapper">
                <ul>
                    <li> <a href="user-profile.html"><span class="counter">1</span> <img src="/images/user-icon.png" width="17" alt="User" title="User"></a> </li>
                    <li> <a href="#"><span class="counter">1</span> <img src="/images/notification-icon.png" width="16" alt="Notifications" title="Notifications"></a> </li>
                    <li> <a href="mail.html"><span class="counter">1</span> <img src="/images/mail-icon.png" alt="messages" title="messages" width="20"></a> </li>
                    <li> <a href="settings.html"><span class="counter">1</span> <img src="/images/settings-icon.png" alt="settings" title="settings" width="21"></a> </li>
                </ul>
            </div>
            <div class="user-options">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="profile-icon">
                            <img src="/images/small-profile-picture.png" alt="username" title="username">
                        </span>
                        <span class="username">
                            User Name
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <a class="dropdown-item" href="/user/clientProfile"><?= __('Your Profile') ?></a>
                        <a class="dropdown-item" href="/user/logout"><?= __('Logout') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Header Ends -->

<!-- Custom Sidebar menu starts -->
<!--<= $this->element('menu/sidebar')?>-->
<!--<div class="sidebar-wrapper">
                <div class="sidebar">
        <ul class="menu">
            <li class="custom-menu-toggle"><a href="#" class="close-menu"> <span class="icon"><img src="images/menu-icons/Close-X.png" alt="Menu toggle" title="Menu toggle"> </span> <span class="menu-title"> <i>close</i> menu</span>  </a> </li>
            <li><a href="desktop.html"> <span class="icon"><img src="images/menu-icons/Scrivania.png" alt="scrivania" title="scrivania"> </span> <span class="menu-title">scrivania</span>  </a> </li>
                <li><a href="projects.html"> <span class="icon"><img src="images/menu-icons/progetti.png" alt="progetti" title="progetti"> </span> <span class="menu-title">GRUPPI</span>  </a> </li>
                <li><a href="calendar.html"> <span class="icon"><img src="images/menu-icons/Calendario.png" alt="calendario" title="calendario"> </span> <span class="menu-title">calendario</span>  </a> </li>
            <li><a href="public-library.html"> <span class="icon"><img src="images/menu-icons/biblio-generale.png" alt="biblio generale" title="biblio generale"> </span> <span class="menu-title">biblio generale</span>  </a> </li>
            <li><a href="private-library.html"> <span class="icon"><img src="images/menu-icons/biblio-privata.png" alt="biblio privata" title="biblio privata"> </span> <span class="menu-title">biblio privata</span>  </a> </li>
            <li><a href="hoot.html"> <span class="icon"><img src="images/menu-icons/Hoots.png" alt="Hoots" title="Hoots"> </span> <span class="menu-title">Hoots</span>  </a> </li>
            <li><a href="user-profile.html"> <span class="icon"><img src="images/menu-icons/Il-mio-Profilo.png" alt="il mio profilo" title="il mio profilo"> </span> <span class="menu-title">il mio profilo</span>  </a> </li>
            <li><a href="e-learning-listing.html"> <span class="icon"><img src="images/menu-icons/E-learning.png" alt="e-learning" title="e-learning"> </span> <span class="menu-title">e-learning</span>  </a> </li>
        </ul>
    </div>
</div>-->
<!-- Custom Sidebar menu Ends -->


<!-- Innerpage content wrapper starts------>
<div class="innerpage-content-wrapper" style="margin-top: 7.375rem">
    <!-- Innerpage contnet starts ----->
    <div class="innerpage-content container">
        <div class="container">
            <div class="project-view-wrapper row">
                <div class="project-sidebar col-md-3">
                    <!-- project Sidebar Starts -->
                    <div class="project-info">
                        <div class="project-info1">
                            <p id="projectname" style="font-size: 1.5em;" title=<?= $projectObject['name'] ?>><b><?= $projectObject['name'] ?></b></p>
                            <!--<img id="projectimage" src="<?= $projectObject['imageFilePath'] ?>">
                             <img id ="projectimage" src="<?= $item->imageFilePath . $item->imageFileName ?>">-->


                            <?php

                            use Cake\I18n\Date;

                            if ($projectObject["type"] == 'A') : ?>
                                <span>Commessa</span>
                            <?php elseif ($projectObject["type"] == 'B') : ?>
                                <span>Ricerca Accadenica</span>
                            <?php elseif ($projectObject["type"] == 'C') : ?>
                                <span>Raccocta Fondi</span>

                            <?php else : ?>
                                <span>Venture Capital</sp>

                                <?php endif; ?>

                        </div>


                        <p id="projectdescription" style="padding: 1em 0 0 0;"><?= $projectObject['description'] ?></p>


                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inviteModalCenter" style="width: 100%; padding:5px">Invite Collaborators</button>

                        <div class="modal fade" id="inviteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLongTitle">Invite Member</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="/projectObject/inviteMembers/" id="add" enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $projectObject['id'] ?>">
                                            <input type="text" name="email" placeholder="Enter Email Id">
                                            <label for="type"><?= __('Type of Member') ?></label>

                                            <select id="type" name="type">
                                                <option id='' disabled selected>-------</option>
                                                <option value="X">Developer</option>
                                                <option value="Y">Business</option>
                                                <option value="Z"> Economic</option>
                                            </select>
                                            <button type="submit" id brnShow> Add</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div><br><br>
                            <h6>Projct Member Details</h6><br>
                            <?php foreach ($res as $item) : ?>
                                <section style="font-size: 10px;">
                                    <!---  <label for="fname">First name:</label>--->
                                    First Name : <input type="text" id="fname" name="fname" value="<?= $item->firstname ?>" readonly>
                                    <!-- <label for="lname">Last name:</label>--->
                                    Last Name : <input type="text" id="lname" name="lname" value="<?= $item->lastname ?>" readonly>
                                    <!---<label for="email">Email:</label>----->
                                    Email : <input type="email" id="email" name="email" value="<?= $item->email ?>" readonly>
                                    <div>

                                    </div>
                                </section><br>
                            <?php endforeach ?>
                        </div>



                        <style type="text/css">
                            .template {
                                display: none !important;
                            }

                            #course-proposals img {
                                padding: 0px;
                                width: 45px;
                                height: 45px;
                            }

                            #course-proposals a {
                                margin-left: 30px;
                                color: black;
                                font-weight: normal;
                            }

                            #course-proposals .single-proposal-tab {
                                margin-bottom: 10px;
                                margin-top: 10px;
                            }

                            #course-proposals .single-proposal-tab h5 {
                                border-bottom: none !important;
                                margin-top: 0 !important;
                            }

                            #course-proposals .projects-tabs {
                                padding-top: 0px !important;
                                padding-bottom: 0px !important;
                                margin-bottom: 0;
                            }

                            #proposals .nav-tabs {
                                border-bottom: 0px !important;
                            }
                        </style>
                        <br>
                        <div role="tabpanel" class="tab-pane" id="proposals" style="display: none;">
                            <!-- Title formatted as nav link -->
                            <ul class="nav nav-tabs nav-justified" style="margin-left: 0;" role="tablist">
                                <li class="nav-item">
                                    <p class="nav-link active">PROPOSTE</p>
                                </li>
                            </ul>
                            <!-- Generated list -->
                            <div class="proposal-list-wrapper">
                                <div class="proposals">
                                    <div class="w3-content w3-display-container">
                                        <div class="row">
                                            <ul id="course-proposals" class="projects-tabs col-md-12" style=" padding-left: 0; list-style-type: none">
                                                <li class="single-proposal-tab template" template>
                                                    <div>
                                                        <img src="">
                                                        <span class="name"></span>
                                                        <span class="priceMin"></span>
                                                        <span class="priceMax"></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- project Sidebar ENDs -->
                </div>
                <!-- Project Activity Starts -->

                <style type="text/css">
                    #modSendProposal {
                        float: right;
                        display: none;
                    }
                </style>

                <div class="project-activity-wrapper col-md-9">




                    <div class="container" style="background: whitesmoke;">
                        <br>
                        <div class='row' style="display:flex;">

                            <div class="col-2">
                                <input type="text" name="ename" placeholder="Employee Name">
                            </div>
                            <div class="col-2">
                                <select id="leavetype" name="leavetype" placeholder="LeaveType" onchange="searchLeaveType(this); return false;">
                                    <option> Select Leave Type</option>
                                    <option value="M"> Medical Leave Type</option>
                                    <option value="C">Casual Leave Type 12days</option>
                                    <option value="L">Loss of Pay</option>
                                </select>

                            </div>
                            <div class="col-2">
                                <select id="status" name="status" placeholder="Status Type">
                                    <option> Select Status Type</option>
                                    <option value="M"> New</option>
                                    <option value="M"> Approved</option>
                                    <option value="C">Pending</option>
                                    <option value="L">Rejected</option>
                                </select>

                            </div>
                            <div class="col-2">

                                <input type="text" id="fromdate" name="fromdate" placeholder="From" class="datepicker" placeholder="DD/MM/YYYY" />

                            </div>
                            <div class="col-2">

                                <input type="text" id="fromdate" name="fromdate" placeholder="To" class="datepicker" placeholder="DD/MM/YYYY" />

                            </div>
                            <div class="col-2">

                                <button type="button" style="padding: 5px;">Search</button>


                            </div>

                            <br>
                        </div>
                        <table id="employeeLeaves">

                            <thead>
                                <tr>

                                    <th>Employee</th>
                                    <th>LeaveType</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>No of Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>

                            </thead>
                            <tbody>
                                <?php foreach ($leave as $item) : ?>
                                    <tr>

                                        <?php foreach ($res as $data) : ?>
                                            <?php if ($item->user_id == $data->id) : ?>
                                                <td><?= $data->firstname ?></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <td>
                                            <?php if ($item->leavetype == 'M') : ?>
                                                Medical Leave
                                            <?php elseif ($item->leavetype == 'C') : ?>
                                                Casual Leave
                                            <?php else : ?>
                                                Loss of Pay
                                            <?php endif; ?>
                                        </td>
                                        <td id="fromdate">
                                            <?= $item->fromdate->i18nFormat('dd-MM-yyyy'); ?>
                                        </td>
                                        <td id="todate">
                                            <?= $item->todate->i18nFormat('dd-MM-yyyy'); ?>
                                        </td>
                                        <?php $difference = date_diff($item->fromdate, $item->todate) ?>
                                        <td>
                                            <?= $difference->format("%a days");  ?>
                                        </td>
                                        <td>
                                            <?= $item->leavereason ?>
                                        </td>
                                        <td>
                                            <select id="leavereason" name="leavereason" onchange="updateLeavestatus(this, <?= $item->user_id ?>); return false;">

                                                <?php if ($item->status == 'N') : ?>
                                                    <option value="N" selected> New</option>
                                                    <option value="A">approved</option>
                                                    <option value="P">Pending</option>
                                                    <option value="R">Rejected</option>
                                                <?php elseif ($item->status == 'A') : ?>
                                                    <option value="N"> New</option>
                                                    <option value="A" selected>approved</option>
                                                    <option value="P">Pending</option>
                                                    <option value="R">Rejected</option>
                                                <?php elseif ($item->status == 'P') : ?>
                                                    <option value="N"> New</option>
                                                    <option value="A">approved</option>
                                                    <option value="P" selected>Pending</option>
                                                    <option value="R">Rejected</option>
                                                <?php else : ?>
                                                    <option value="N"> New</option>
                                                    <option value="A">approved</option>
                                                    <option value="P" selected>Pending</option>
                                                    <option value="R" selected>Rejected</option>
                                                <?php endif; ?>


                                            </select>
                                        </td>


                                        <td>
                                            <button type="submit" style="padding:0px" class="btn btn-primary" data-toggle="modal" data-target="#leaveupdate_<?= $item->id ?>">Edit</button>

                                            <form method="post" action="/leaves/delete" enctype="multipart/form-data">
                                                <button type="submit" style="padding: 0px;">Delete</button>
                                                <input type="hidden" name="leaveid" value="<?= $item->id ?>">

                                            </form>
                                        </td>

                                    </tr>

                                    <!-- Modal  edit Update -->
                                    <div class="modal fade" id="leaveupdate_<?= $item->id ?>" tabindex="-1" role="dialog" aria-labelledby="leaveupdate" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                                                    <?= $item->id ?>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="/leaves/updateleave" enctype="multipart/form-data">


                                                        <div>
                                                            <label for="leavetype"><?= __('Leave Type ') ?></label>
                                                            <select id="leavetype" name="leavetype" onchange="changeLeaveType(this, <?=$item->id ?>); return false;">
                                                                <?php if ($item->leavetype == 'M') : ?>
                                                                    <option value="M" selected> Medical Leave</option>
                                                                    <option value="C"> Casual Leave</option>
                                                                    <option value="P">Loss of Pay</option>
                                                                <?php endif; ?>

                                                                <?php if ($item->status == 'C') : ?>
                                                                    <option value="M" > Medical Leave</option>
                                                                    <option value="C" selected> Casual Leave</option>
                                                                    <option value="P">Loss of Pay</option>
                                                                    <?php endif; ?>

                                                                <?php if($item->status == 'P') : ?>
                                                                    <option value="M" > Medical Leave</option>
                                                                    <option value="C" > Casual Leave</option>
                                                                    <option value="P" selected>Loss of Pay</option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <?php if ($item->leavetype == 'M') : ?>
                                                            <div id="medicalno" style="margin-left:10%;">
                                                                <label for="medicalno"><?= __('Enter Medical Number') ?></label>
                                                                <input type="number" id="medicalno" name="medicalno" value="<?= $item->medical_number ?>">

                                                            </div>
                                                        <?php endif; ?>
                                                        <div id="medicalno" style="margin-left:10%;display:none">
                                                                <label for="medicalno"><?= __('Enter Medical Number') ?></label>
                                                                <input type="number" id="medicalno" name="medicalno" value="<?= $item->medical_number ?>">

                                                            </div>


                                                        <label for="fromdate"><?= __('From') ?></label>
                                                        <input type="text" id="fromdate_edit" name="fromdate" class="datepicker" placeholder="DD/MM/YYYY" value="<?= $item->fromdate->i18nFormat('dd-MM-yyyy'); ?>" />


                                                        <div>
                                                            <label for="todate"><?= __('To') ?></label>
                                                            <input type="text" id="todate_edit" name="todate" class="datepicker" placeholder="DD/MM/YYYY" value="<?= $item->todate->i18nFormat('dd-MM-yyyy'); ?>" />

                                                        </div>

                                                        <?php $difference = date_diff($item->fromdate, $item->todate) ?>

                                                        <div>
                                                            <label for="ndays"><?= __('Number of Days') ?></label>
                                                            <input type="number" id="ndays" name="ndays" value=" <?= $difference->format("%a");  ?>"/>

                                                        </div>

                                                        <div>
                                                            <label for="rdays"><?= __('Remaining Leaves') ?></label>
                                                            <input type="number" name="rdays" value="20">

                                                        </div>
                                                        <div>
                                                            <label for="reason"><?= __('Leave Reason') ?></label>
                                                            <textarea type="text" name="reason"><?= $item->leavereason ?></textarea>

                                                        </div>


                                                </div>

                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <input type="hidden" name="lid" id="lid" value="<?= $item->id ?>">
                                                </form>


                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            </tbody>
                        </table>



                    </div>

                </div>
            </div>
        </div>
        <!-- Innerpage contnet END ----->

    </div>

    <!-- Innerpage content wrapper END ------>

</div>

<!-- Modal -->
<div class="modal fade text-left" id="manage-users-modal" tabindex="-1" role="dialog" aria-labelledby="manage-users-modalLabel" aria-hidden="true">

</div>


<!-- Modal send proposal -->
<div class="modal fade text-left" id="send-proposal-modal" tabindex="-1" role="dialog" aria-labelledby="send-proposal-modalLabel" aria-hidden="true">

</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- Bootstrap CSS -->
<link rel="icon" type="" href="/images/favicon.png">

<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"> <!-- TEMP! Need to be set correctly -->
<link rel="stylesheet" type="text/css" href="../../css/style.css"> <!-- TEMP! Need to be set correctly -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript" src="../../js/jquery.bootcalendar.js"></script> <!-- TEMP! Need to be set correctly -->

<script type="text/javascript" src="../../js/custom.js"></script> <!-- TEMP! Need to be set correctly -->


<!--$('#modCreateProject').click(function() {
modCreateProject();
});-->

<script type="text/javascript">

function changeLeaveType(event, lid) {
        //window.location.reload();
        var leavetype = event.value;

        console.log(leavetype);
        if (leavetype === "M") {
            $("#medicalno").show()
        } else {
            $("#medicalno").hide()
        }


        // ajax call


    }



    var ndays = 0;

    $(function() {

        $(document).ready(function() {
            $("#fromdate_edit").datepicker({
                dateFormat: "dd/mm/yy"
            }).val();

            $("#todate_edit").datepicker({
                dateFormat: "dd/mm/yy"
            }).val();
        });

        var start = $("#fromdate").datepicker("getDate").val();
        console.log(start);
        var end = $("#todate").datepicker("getDate").val();
        days = (end - start) / (1000 * 60 * 60 * 24);
        ndays = Math.round(days);
        $("#ndays").val(ndays);

    });


    function myfunc() {

    }




    function updateLeavestatus(event, $id) {

        //window.location.reload();
        var $leavereason = event.value;
        console.log($id);
        console.log($leavereason);

        // ajax call
        $.ajax({

            url: '/leaves/updateLeavestatus',
            method: 'post',
            dataType: 'json',
            data: {
                'eid': $id, //userid
                'leavestatus': $leavereason,


            },

            success: function(data) {
                // window.location.href = "/projectobject/view/";
                // close popup click event trigger
                // div show $("#id").show();
            },
            error: function() {

            }
        })

    }

    function searchLeaveType(event) {

        //window.location.reload();
        var $leavereason = event.value;

        console.log($leavereason);

        // ajax call
        $.ajax({

            url: '/leaves/searchLeaveType',
            method: 'post',
            dataType: 'json',
            data: {

                'leavestatus': $leavereason,


            },

            success: function(data) {
                // window.location.href = "/projectobject/view/";
                // close popup click event trigger
                // div show $("#id").show();
            },
            error: function() {

            }
        })

    }
</script>


<script type="text/javascript">
    $("#btnShow").click(function() {

        $(".alert").toggle();
    });


    function modalProjectClose() {
        $('#create-project-modal').modal('hide');

    }

    showProjectMessages();

    var isMyProject = isMyProject();

    var isUserSchool = isUserSchool();

    function sendMessage(subMessage = false, idSender = null, createDate = null, index = null) {
        console.log(subMessage)

        if (index != null && subMessage) {
            textPost = $('#input-' + index).val()
        } else {
            textPost = $('#textPost').val()
        }

        console.log('prima dell\' ajax')

        $.ajax({
            method: 'post',
            dataType: 'json',
            url: '/project-message/add',
            data: {
                'idProject': <?= ($projectObject['id']) ?>,
                'textPost': textPost,
                'subMessage': subMessage,
                'idSender': idSender,
                'createDate': createDate
            },
            success: function(data) {
                console.log(data)
                if (data == 'No text') {
                    location.reload();
                    return false;
                }
                $('#textPost').val('')
                showProjectMessages(!subMessage);
            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }
        })


    }


    function showProjectMessages(scroll = false) {

        $.ajax({
            method: 'post',
            dataType: 'json',
            url: '/project-message/getMessages',
            data: {
                'fromPage': 'GOview',
                'idProject': <?= ($projectObject['id']) ?>,
                'aaa': 'aaa',
                'bbb': 'bbb',
            },
            success: function(data) {
                console.log(data)

                html = "";

                for (i = 0; i < data.length; i++) {

                    if (data[i]['favorite'] == 0) {
                        favorite = ""
                    } else {
                        favorite = "1"
                    }


                    var dataPostDay = new Date(data[i]['createDate']).getDate() + "";
                    var dataPostMonth = new Date(data[i]['createDate']).getMonth() + 1 + "";
                    if (dataPostDay.length == 1) dataPostDay = "0" + dataPostDay
                    if (dataPostMonth.length == 1) dataPostMonth = "0" + dataPostMonth
                    var dataPostYear = new Date(data[i]['createDate']).getFullYear();
                    var dataPostHour = new Date(data[i]['createDate']).getHours();
                    var dataPostMinute = new Date(data[i]['createDate']).getMinutes();
                    var fullDate = dataPostDay + "-" + dataPostMonth + "-" + dataPostYear + " " + dataPostHour + ":" + dataPostMinute;


                    html += '<div class="project-comment" id="comment' + data[i]['projectId'] + '-' + data[i]['senderId'] + '" style="border-bottom: 0px; padding: 2rem 2.3rem">'
                    html += '<div class="img-wrapper">'
                    html += '<div class="img">'
                    html += '<img src="/img/profilephotoimages/user-<?= $userId ?>.jpg?refresh=<?= time() ?>" alt="username" title="username">'
                    html += '</div>'
                    html += '</div>'
                    html += '<div class="details">'
                    html += '<div class="title">' + data[i]['u']['firstname'] + ' ' + data[i]['u']['lastname'] + '</div>'
                    html += '<div class="description">' + data[i]['text'] + '</div>'
                    if (data[i]['attachment'][0] != null) {
                        html += '<div class="attachment" id="attachment" onclick="startDownload(\'' + data[i]['attachment'][0]['fileMarker'] + '\', \'' + data[i]['attachment'][0]['fileCnt'] + '\')"><i class="fa fa-file-image-o fa-2x" aria-hidden="true"></i><p class="attachmentName">' + data[i]['attachment'][0]['fo']['displayFileName'] + '</p></div>'
                    }
                    html += '<div class="date">' + fullDate + '</div>'
                    html += '<div class="comment-actions" style="display:block!important">'
                    html += '<div class="share-like-wrapper">'
                    html += '<a href="#" onclick="likeComment(event, ' + data[i]['projectId'] + ', ' + data[i]['senderId'] + ', \'' + data[i]['createDate'] + '\')"><span class="img-wrapper"><img id="like-image-' + data[i]['projectId'] + '-' + data[i]['senderId'] + '-' + data[i]['createDate'] + '" src="/images/like-icon' + favorite + '.png" alt="like" title="like" width="25"> </span> <span>Like</span></a>'
                    html += '<a href="#"><span class="img-wrapper"><img src="/images/share-icon-gray.png" alt="Share" title="Share" width="19"> </span> <span>Share</span></a>'
                    html += '</div>'
                    html += '<div class="comment-wrapper">'
                    html += '<input id="input-' + i + '" class="form-control slcomment" type="text" placeholder="Insert your text here" style="border-radius:1.5rem">'
                    html += '<div class="btn-wrapper">'
                    html += '<button class="btn btn-secondary" onClick="sendMessage(' + true + ',' + data[i]['senderId'] + ', \'' + data[i]['createDate'] + '\', ' + i + ')">Comment</button>'
                    html += '</div>'
                    html += '</div>'
                    html += '</div>'
                    html += '</div>'
                    html += '</div>'
                    html += '<div class="sub-project-comments" id="subcomments' + data[i]['projectId'] + '-' + data[i]['senderId'] + '">'

                    for (j = 0; j < data[i]['responses'].length; j++) {
                        html += '<div class="sub-project-comment" id="subcomment' + data[i]['responses'][j]['projectId'] + '-' + data[i]['responses'][j]['senderId'] + '">'
                        html += '<p style="font-size: 0.75em; margin-bottom:0.5em">' + data[i]['responses'][j]['u']['firstname'] + ' ' + data[i]['responses'][j]['u']['lastname'] + '</p>'
                        //html += '</br>'
                        html += data[i]['responses'][j]['text']
                        html += '</div>'


                    }
                    html += '</div>'

                }
                html += '<div id="bottom" style="display: hidden"></div>'

                $('.project-comments-wrapper').html(html)

                if (scroll) {
                    location.href = '#bottom'
                }
            },
            error: function(a, b, c) {
                console.log(a['responseText']);
                console.log(JSON.parse(a['responseText']));
                console.log(a)
                console.log(b)
                console.log(c)
            }
        })

    }


    function validateFileSize() {
        $('#errorFileSize').text("");
        var fileTag = document.getElementById('postAttachment');


        for (var i = 0; i < fileTag.files.length; i++) {
            var fileName = fileTag.value.split('\\')[2];
            console.log(fileName)
            $('#hiddenFileName').text(fileName)
            $('#hiddenFileName').show()
            if (fileTag.files[i].size > 1048576) {
                $('#projectIMG').val('');
                $('#errorFileSize').text("<?= __('File size is too big') ?>");
            }
        }

    }

    function likeComment(e, projectId = null, senderId = null, createDate = null) {

        e.preventDefault();

        if (projectId != null && senderId != null && createDate != null) {
            $.ajax({
                method: 'post',
                dataType: 'json',
                url: '/project-message/likeComment',
                data: {
                    'projectId': projectId,
                    'senderId': senderId,
                    'createDate': createDate
                },
                success: function(data) {
                    console.log(data[2])
                    if (data[0] == 0 && data[1] == 1) {
                        document.getElementById('like-image-' + projectId + '-' + senderId + '-' + createDate).src = "/images/like-icon1.png";
                    } else if (data[0] == 1 && data[1] == 1) {
                        document.getElementById('like-image-' + projectId + '-' + senderId + '-' + createDate).src = "/images/like-icon.png";
                    }

                },
                error: function(a, b, c) {
                    console.log(a)
                    console.log(b)
                    console.log(c)
                }
            })
        }
    }


    function membershipRequest() {
        $.ajax({
            method: 'post',
            //dataType: 'json',
            url: '/project-member/membershipRequest',
            data: {
                'projectId': <?= $projectObject['id'] ?>,
                'aaa': 'aaa',
                'bbb': 'bbb'
            },
            success: function(data) {
                console.log(data)
                location.reload();
            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }
        })
    }


    toggleTabList()

    function toggleTabList(type = 'inviti') {

        projectId = <?= $projectObject['id'] ?>

        invito = 0;
        richiesta = 0;
        evento = 0;

        if (type == 'inviti') {
            invito = 1
            error = "<?= __("There aren\'t any invites") ?>"
            console.log('iii')
        } else if (type == 'richieste') {
            richiesta = 1
            error = "<?= __('There aren\'t any requests') ?>"
            console.log('rrr')
        } else if (type == 'eventi') {
            evento = 1
        }

        $.ajax({
            method: 'post',
            dataType: 'json',
            url: '/projectObject/getProjectTabList',
            data: {
                'page': 'view',
                'projectId': projectId,
                'invito': invito,
                'richiesta': richiesta,
                'evento': evento,
            },
            success: function(data) {
                console.log(data)
                var onclick = ''
                //console.log('onclickprima ' + onclick)


                html = '<ul class="list-unstyled">'

                if (data.length == 0) {
                    html += '<li>' + error + '</li>'
                }

                for (i = 0; i < data.length; i++) {


                    if (type == 'inviti') {
                        date = 'invitationDate'
                        onclick = 'acceptInvitation()'
                        button = ''
                    } else if (type == 'richieste') {
                        date = 'membershipRequestDate'
                        onclick = 'acceptRequest(' + data[i]['memberId'] + ', ' + data[i]['projectId'] + ', \'' + data[i]['memberType'] + '\')'
                        button = '<button class="btn btn-sm btn-secondary" onclick="' + onclick + '">Accetta</button>'
                    }


                    var dataPostDay = new Date(data[i]['createDate']).getDate() + "";
                    var dataPostMonth = new Date(data[i]['createDate']).getMonth() + 1 + "";
                    if (dataPostDay.length == 1) dataPostDay = "0" + dataPostDay
                    if (dataPostMonth.length == 1) dataPostMonth = "0" + dataPostMonth
                    var dataPostYear = new Date(data[i]['createDate']).getFullYear();
                    var dataPostHour = new Date(data[i]['createDate']).getHours();
                    var dataPostMinute = new Date(data[i]['createDate']).getMinutes();
                    var fullDate = dataPostDay + "-" + dataPostMonth + "-" + dataPostYear + " " + dataPostHour + ":" + dataPostMinute;

                    html += '<li>'
                    html += '<div class="img-wrapper">'
                    html += '<div class="img">'
                    html += '</div>'
                    html += '</div>'
                    html += '<div class="details">'
                    html += '<div class="title">' + data[i]['u']['firstname'] + ' ' + data[i]['u']['lastname'] + '</div>'
                    //html +=             '<div class="project-name">Nome Progetto</div>'
                    html += '<div class="date">' + fullDate + '</div>'
                    html += '</div>'
                    html += '<div class="btn-wrapper">'
                    html += button
                    html += '</div>'
                    html += '</li>'

                }

                html += '</ul>'
                $('#' + type).html(html)

            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }
        })

    }



    function acceptRequest(memberId, projectId, memberType) {

        $.ajax({
            method: 'post',
            dataType: 'json',
            url: '/projectObject/acceptRequest',
            data: {
                'projectId': projectId,
                'memberId': memberId,
                'memberType': memberType
            },
            success: function(data) {

                console.log(data)
                location.reload()

            },
            error: function(a, b, c) {
                console.log(a)
                console.log(b)
                console.log(c)
            }
        })

    }

    function getCourseProposals() {
        $.ajax({
            url: '/projectObject/getCourseProposals',
            dataType: 'json',
            method: 'post',
            data: {
                'projectId': <?= ($projectObject['id']) ?>
            },
            success: function(data) {
                //response( data );
                console.log('getCourseProposals - success');
                console.log(data);

                for (i = 0; i < data.length; i++) {
                    // pick details from ajax call
                    name = data[i]['a']['name1'];
                    priceMin = data[i]['cp']['priceMin'];
                    priceMax = data[i]['cp']['priceMax'];
                    imgServer = data[i]['o']['imageFileServer'];
                    imgPath = data[i]['o']['imageFilePath'];
                    console.log(name + " | " + priceMin + " | " + priceMax + " | " + imgServer + " | " + imgPath);
                    // create node
                    node = $('#course-proposals .template').first().clone()[0];
                    // define node properties
                    if (imgPath == null) {
                        $(node).find('img').attr("src", "/images/project-placeholder-image.png")
                    } else {
                        $(node).find('img').attr("src", imgServer + "/" + imgPath);
                    }
                    $(node).find('.name').text(name);
                    $(node).find('.priceMin').text(priceMin);
                    $(node).find('.priceMax').text(priceMax);
                    // show and append the new element
                    $(node).removeClass('template');
                    $(node).removeAttr('template');
                    $(node).appendTo('#course-proposals');
                }
            },
            error: function(a, b, c) {
                console.log('getCourseProposals - error');
                console.log(a);
                console.log(b);
                console.log(c);
            }
        });
    }


    function modManageUsers(projectId) {
        $.ajax({
            url: '/projectObject/manage-users-modal/' + projectId,
            method: 'get',
            success: function(data) {

                $('#manage-users-modal').html('');
                $('#manage-users-modal').html(data);
                $('#manage-users-modal').modal('show');
                $('body').attr("class", "innerpage");
                $('body').attr("style", "");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR: ' + jqXHR + ' textStatus: ' + textStatus + ' errorThrown: ' + errorThrown);
                console.log(jqXHR)
            }
        });
    }

    function modSendProposal() {
        $.ajax({
            url: '/projectObject/send-proposal-modal/' + projectId,
            method: 'get',
            data: {
                'projectId': projectId
            },
            success: function(data) {
                $('#send-proposal-modal').html('');
                $('#send-proposal-modal').html(data);
                $('#send-proposal-modal').modal('show');
                $('body').attr("class", "innerpage");
                $('body').attr("style", "");
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('jqXHR: ' + jqXHR + ' textStatus: ' + textStatus + ' errorThrown: ' + errorThrown);
                console.log(jqXHR)
            }
        });
    }

    function isMyProject() {
        var ret;
        $.ajax({
            url: "/projectObject/isMyProject",
            dataType: "json",
            method: 'post',
            async: false,
            data: {
                'projectId': <?= ($projectObject['id']) ?>
            },
            success: function(data) {
                //response( data );
                console.log("IMP" + data);
                ret = data;
            },
            error: function(a, b, c) {
                console.log('isMyProject - error');
                console.log(a);
                console.log(b);
                console.log(c);
            }
        });
        return ret;

    }

    function isUserSchool() {
        var ret;
        $.ajax({
            url: "/user/isSchool",
            dataType: "json",
            method: 'post',
            async: false,
            success: function(data) {
                //response( data );
                console.log("isUserSchool - " + data);
                ret = data;
            },
            error: function(a, b, c) {
                console.log('isUserSchool - error');
                console.log(a);
                console.log(b);
                console.log(c);
            }
        });
        return ret;
    }

    function startDownload(marker, cnt) {
        //var final = file.replace(/\\/g,"/");
        location.href = '/project-message/downloadFile/' + marker + '/' + cnt
    }
</script>

<script>
    $(function() {

        $('#modSendProposal').click(function() {
            modSendProposal(<?= ($projectObject['id']) ?>);
        });

        // if it's my public project, show the proposals
        if (isMyProject && <?= ($projectObject['isSchool']) ?> == 1) {
            $("#proposals").show();
            getCourseProposals();
        }

        // if isMyProject, hide the send proposal button
        if (!isMyProject && <?= ($projectObject['isSchool']) ?> == 1 && isUserSchool) {
            $("#modSendProposal").show();
        }

        $("#searchBoxInput").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "/projectObject/searchProject",
                    dataType: "json",
                    method: 'post',
                    data: {
                        'term': request.term
                    },
                    success: function(data) {
                        //response( data );
                        console.log('data')

                        console.log(data)

                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                location.href = '/projectObject/view/' + ui.item.id
                console.log(ui.item.value)
                console.log(ui.item.id)
            }
        });

        console.log(isUserSchool);
    });

    /*This is draggable code*/
    // Make the DIV element draggable:
    dragElement(document.getElementById("myDiv"));

    function dragElement(elmnt) {
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            // if present, the header is where you move the DIV from:
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            // otherwise, move the DIV from anywhere inside the DIV:
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }

    /*this */

    function serviceOf(evt, service) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(service).style.display = "block";
        evt.currentTarget.className += " active";
    }



    function changeStatus(taskId) {
        console.log("hi");
        location.reload();
        // ajax call
        $.ajax({

            url: '/projecttasks/changeStatusOfTask',
            method: 'post',
            dataType: 'json',
            data: {
                'taskId': taskId, //taskid
                'status': $("#taskStatus").val(),


            },

            success: function(data) {
                // window.location.href = "/projectobject/view/";
                // close popup click event trigger
                // div show $("#id").show();
            },
            error: function() {

            }
        })



    }


    /* function suggestedData(taskId) {
         console.log("hi");
         //location.reload();
         // ajax call
         $.ajax({

             url: '/projecttasks/suggestedData',
             method: 'post',
             dataType: 'json',
             data: {
                 'taskId': taskId, //taskid
                 'status': $("#taskStatus").val(),


             },

             success: function(data) {
                 // window.location.href = "/projectobject/view/";
                 // close popup click event trigger
                 // div show $("#id").show();
             },
             error: function() {

             }
         })


     }*/
</script>


<!---<script type="text/javascript">
    function add(myDiv) {
        document.getElementById('myDiv').style.display = 'block';
    }
</script>-->
