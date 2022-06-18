<!--------------Admin/Company/Client Sidebar----------------------------------------------------------->

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!--Dashboards-->
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a  href="/project-member/privatedashboard">Private Dashboard</a></li>
                    </ul>
                </li>
                <!-- /Dashboards-->


                    <!-----Projects Section------------>
                    <li class="submenu">
                        <a href="#"><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
                        <ul>
                            <a href="/project-object/index?companyId=<?= $data->choosen_companyId ?>&&type=<?= $type = 'I' ?>"><i class="la la-rocket"></i> InternalProjects </a>

                            <li style="margin-left: 20%;"><a href="/projectfiles/filemanager/<?= $type = 'I' ?>">File Manager</a></li>

                            <a href="/project-object/index?companyId=<?= $data->choosen_companyId ?>&&type=<?= $type = 'E' ?>"><i class=" la la-rocket"></i> External Projects </a>

                            <li style="margin-left: 20%;"><a href="/projectfiles/filemanager/<?= $type = 'E' ?>">File Manager</a></li>

                        </ul>
                    </li>
                    <!-----/Projects Section------------>
                    <!----------Apps Section-------------->
                    <li class="submenu">
                        <a href="#"><i class="la la-cube"></i> <span> Apps</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="/chats/chatsystem/<?= $lastchat_touser ?>">Chat</a></li>
                            <li><a href="/events/index/">Calendar</a></li>
                            <li class="submenu">
                                <a href="#"><span> Calls</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="voice-call.html">Voice Call</a></li>
                                    <li><a href="video-call.html">Video Call</a></li>
                                    <li><a href="outgoing-call.html">Outgoing Call</a></li>
                                    <li><a href="incoming-call.html">Incoming Call</a></li>
                                </ul>
                            </li>
                            <li><a href="/chatcontacts/contacts">Contacts</a></li>
                            <li><a href="/projectemail/inbox">Email</a></li>

                        </ul>
                    </li>
                    <!----------/Apps Section-------------->
            </ul>
        </div>
    </div>
</div>

<!--------------Admin/Company/Client Sidebar----------------------------------------------------------->
