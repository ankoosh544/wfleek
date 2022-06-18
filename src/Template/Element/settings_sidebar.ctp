<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="/companies-user/companydashboard/<?= $companyId ?>"><i class="la la-home"></i> <span>Back to Home</span></a>
                </li>
                <li class="menu-title">Settings</li>
                <li class="active">
                    <a href="/settings/usercompanysettings/<?= $companyId ?>"><i class="la la-building"></i> <span>Company Settings</span></a>
                </li>
                <li>
                    <a href="localization.html"><i class="la la-clock-o"></i> <span>Localization</span></a>
                </li>
                <li>
                    <a href="theme-settings.html"><i class="la la-photo"></i> <span>Theme Settings</span></a>
                </li>

                <li>
                    <?php if (!empty($lastaddedrole)) : ?>
                        <a href="/role-permissions/roles-permissions?companyId=<?= $companyId ?>&&roleId=<?= $lastaddedrole->designation_id ?>"><i class="la la-key"></i> <span>Roles & Permissions</span></a>
                    <?php else : ?>
                        <a href="/role-permissions/roles-permissions?companyId=<?= $companyId ?>"><i class="la la-key"></i> <span>Roles & Permissions</span></a>
                    <?php endif; ?>
                </li>

                <li>
                    <a href="/projectemail/email_settings/<?= $companyId?>"><i class="la la-at"></i> <span>Email Settings</span></a>
                </li>
                <li>
                    <a href="performance-setting.html"><i class="la la-chart-bar"></i> <span>Performance Settings</span></a>
                </li>
                <li>
                    <a href="approval-setting.html"><i class="la la-thumbs-up"></i> <span>Approval Settings</span></a>
                </li>
                <li>
                    <a href="/invoices/invoice_settings/<?=$companyId?>"><i class="la la-pencil-square"></i> <span>Invoice Settings</span></a>
                </li>
                <li>
                    <a href="/salaries/salary_settings/<?=$companyId?>"><i class="la la-money"></i> <span>Salary Settings</span></a>
                </li>
                <li>
                    <a href="/notifications/notification_settings/<?=$companyId?>"><i class="la la-globe"></i> <span>Notifications</span></a>
                </li>
                <li>
                    <a href="/user/changepassword_settings/<?=$companyId?>"><i class="la la-lock"></i> <span>Change Password</span></a>
                </li>
                <li>
                    <a href="/leaves/leave_settings/<?=$companyId?>"><i class="la la-cogs"></i> <span>Leave Type</span></a>
                </li>
                <li>
                    <a href="toxbox-setting.html"><i class="la la-comment"></i> <span>ToxBox Settings</span></a>
                </li>
                <li>
                    <a href="cron-setting.html"><i class="la la-rocket"></i> <span>Cron Settings</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar -->
