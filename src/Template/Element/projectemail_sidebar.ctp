 <!-- Sidebar -->
<?= $this->element('settings_sidebar',[
    'companyId' => $companyId
]) ?>
<!-- Sidebar -->
 <!-- Sidebar -->

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="/companies-user/companydashboard/<?=$data->choosen_companyId ?>"><i class="la la-home"></i> <span>Back to Home</span></a>
                        </li>
                        <li>
                            <?php if ($unreademails != null) : ?>
                                <?php $totalinbox = count($unreademails); ?>
                                <?php if ($totalinbox > 0) : ?>
                                    <a href="/projectemail/inbox">Inbox <span class="mail-count">(<?= $totalinbox ?>)</span></a>
                                <?php else : ?>
                                    <a href="/projectemail/inbox">Inbox <span class="mail-count"></span></a>
                                <?php endif; ?>
                            <?php else : ?>
                                <a href="/projectemail/inbox">Inbox <span class="mail-count"></span></a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <a href="/projectemail/starred">Starred</a>
                        </li>
                        <li>
                            <a href="/projectemail/sentMails">Sent Mail</a>
                        </li>
                        <li>
                            <a href="/projectemail/trashMails">Trash</a>
                        </li>

                        <li>
                            <?php if ($draftmails != null) : ?>
                                <?php $totaldraft = count($draftmails); ?>
                                <?php if ($draftmails > 0) : ?>
                                    <a href="/projectemail/draftMails">Draft <span class="mail-count">(<?= $totaldraft ?>)</span></a>
                                <?php else : ?>
                                    <a href="/projectemail/draftMails">Draft <span class="mail-count"></span></a>
                                <?php endif; ?>
                            <?php else : ?>
                                <a href="/projectemail/draftMails">Draft <span class="mail-count"></span></a>
                            <?php endif; ?>
                        </li>

                        <li class="menu-title">Label <a href="#"><i class="fa fa-plus"></i></a></li>
                        <li>
                            <a href="/projectemail/workEmails"><i class="fa fa-circle text-success mail-label"></i> Work</a>
                        </li>

                        <li>
                            <a href="/projectemail/personalEmails"><i class="fa fa-circle text-warning mail-label"></i> Personal</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- /Sidebar -->
