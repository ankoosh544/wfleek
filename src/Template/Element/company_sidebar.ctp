<!--------------Admin/Company/Client Sidebar----------------------------------------------------------->

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <!--Dashboards-->
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="/project-member/privatedashboard/<?= $data->choosen_companyId ?>">Private Dashboard</a></li>
                        <?php if ($data3->designation->name != 'Customer') : ?>
                            <li><a href="/workinghours/attendance?emp_id=<?= $data->id ?>&company_id=<?= $data->choosen_companyId ?>">Attendence Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="/companies-user/companydashboard/<?= $data->choosen_companyId ?>">Company Dashboard</a></li>
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


                <!-----Collaborator Section--------->

                <li class="submenu">
                    <?php if ($data3->designation->name != 'Customer') : ?>
                        <a href="#"><i class="la la-dashboard"></i> <span> Collaborators </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="/leaves/adminleaves/<?= $data->choosen_companyId ?>">Permits</a></li>
                            <li class="submenu"><a href="#"><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="/companies-user/salary/<?= $data->choosen_companyId ?>"> Employee Salary </a></li>
                                    <li><a href="/salaries/payroll/<?= $data->choosen_companyId ?>""> Payroll Items </a></li>
								</ul>
							</li>
                            <li>
                                <a href=" /workinghours/allemployeesattendence/<?= $data->choosen_companyId ?>">Attendance (Admin)</a>
                                    </li>
                                    <li>
                                        <a href="/workinghours/monthlyattendence/<?= $data->choosen_companyId ?>">Monthly Attendence Pdfs</a>
                                    </li>
                                    <li>
                                        <a href="/project-member/privatedashboard/<?= $data->choosen_companyId ?>">Displacements</a>
                                    </li>
                                </ul>
                                <!---/Collaborator Section---------->
                            <li class="submenu">
                                <a href="#" class="noti-dot"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="/companies-user/employees/<?= $data->choosen_companyId ?>"> <span>Employees</span></a></li>
                                    <li><a href="/workinghours/timesheet/<?= $data->choosen_companyId ?>">Time Sheet</a></li>
                                    <li><a href="/departments/view/<?= $data->choosen_companyId ?>">Departments</a></li>
                                    <li><a href="/designations/view/<?= $data->choosen_companyId ?>">Designations</a></li>
                                    <li><a href="/shift-schedules/shift-schedule/<?= $data->choosen_companyId ?>">Shift & Schedule</a></li>
                                </ul>
                            </li>
                            <!---/Employee Section----->

                            <li>
                                <a href="/projecttasks/tickets/<?= $data->id ?>"><i class="la la-ticket"></i> <span>Tickets</span></a>
                            </li>
                            <li><a href="/companies-user/clients/<?= $data->choosen_companyId ?>"><i class="la la-users"></i> <span>Clients</span></a></li>
                            <li><a href="/payslips/payslips/<?= $data->choosen_companyId ?>"><i class="la la-money"></i> <span> PaySlips</span> </a></li>

                            <!------Leads-------------------------------------->
                            <?php if ($data3->designation->name == 'Administrator') : ?>
                                <li>
                                    <a href="/companiesUser/leads/<?= $data->choosen_companyId ?>"><i class="la la-user-secret"></i> <span>Leads</span></a>
                                </li>

                                <li class="submenu">
                                    <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;">
                                        <li><a href="/invoices/invoice-reports/<?= $data->choosen_companyId ?>"> Invoice Report </a></li>
                                        <li><a href="/project-object/project-reports/<?= $data->choosen_companyId ?>"> Project Report </a></li>
                                        <li><a href="/projecttasks/task-reports/<?= $data->choosen_companyId ?>"> Task Report </a></li>
                                        <li><a href="/user/user-reports/<?= $data->choosen_companyId ?>"> User Report </a></li>
                                        <li><a href="/companiesUser/employee-reports/<?= $data->choosen_companyId ?>"> Employee Report </a></li>
                                        <li><a href="/payslips/payslip-reports/<?= $data->choosen_companyId ?>"> Payslip Report </a></li>
                                        <li><a href="/workinghours/attendence-reports/<?= $data->choosen_companyId ?>"> Attendance Report </a></li>
                                        <li><a href="/leaves/leave-reports/<?= $data->choosen_companyId ?>"> Leave Report </a></li>
                                        <li><a href="daily-reports.html"> Daily Report </a></li>
                                        <li><a href="expense-reports.html"> Expense Report </a></li>
                                        <li><a href="payments-reports.html"> Payments Report </a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <!------/Leads----------------------------------------->
                        <?php else : ?>
                            <li>
                                <a href="/projecttasks/tickets/<?= $data->id ?>"><i class="la la-ticket"></i> <span>Tickets</span></a>
                            </li>

                        <?php endif; ?>

                        <li class="submenu">
                            <a href="#"><i class="la la-files-o"></i> <span> Invoices </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="/invoices/invoices/<?= $data->choosen_companyId ?>"> Invoices </a></li>
                                    <li><a href="/invoices/payments/<?= $data->choosen_companyId ?>""> Payments </a></li>
								</ul>
							</li>

                        <li>
                            <a href="/appointments/appointmentspage/<?= $data->choosen_companyId ?>"><i class="la la-clock"></i> <span>Appointments</span></a>
                        </li>
                        <li>
                            <a href="/settings/usercompanysettings/<?= $data->choosen_companyId ?>"><i class="la la-cog"></i> <span>Settings</span></a>
                        </li>




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
                                <li><a href="/chatcontacts/contacts?companyId=<?= $data->choosen_companyId ?>&&type=null">Contacts</a></li>
                                <li><a href="/projectemail/inbox/<?= $data->choosen_companyId ?>">Email</a></li>

                            </ul>
                        </li>
                        <!----------/Apps Section-------------->

                        </ul>
        </div>
    </div>
</div>

<!--------------Admin/Company/Client Sidebar----------------------------------------------------------->
<script>
    // function activediv(){
    //     $('.clients').addClass('active');
    // }
    $(document).ready(function() {
        $("li").click(function(e) {
            // A LI is clicked
            // Set all other li's to not selected
            $("li").removeClass("active");

            // Add selected class to the clicked li
            $(this).addClass("active");
        });
    });
</script>
