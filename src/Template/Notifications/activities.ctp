<?php

use Cake\I18n\Number;
use Cake\I18n\Time;


?>



<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Activities</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Activities</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="activity">
                    <div class="activity-box">
                        <ul class="activity-list">

                            <?php foreach ($notifications as $notification) : ?>
                                <?php if ($notification->type == 'leave') : ?>
                                    <li>
                                        <div class="activity-user">
                                            <a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                                <?php if ($notification->fromuser->profileFilepath != null && $notification->fromuser->profileFilename != null) : ?>
                                                    <img src="<?= $notification->fromuser->profileFilepath ?>/<?= $notification->fromuser->profileFilename ?>" alt="">
                                                <?php else : ?>
                                                    <img src="/assets/img/profiles/avatar-01.jpg" alt="">
                                                <?php endif; ?>

                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="profile.html" class="name">
                                                    <?= $notification->fromuser->firstname ?> <?= $notification->fromuser->lastname ?>
                                                </a>
                                                <?php if ($data2->type == 'Y') : ?>
                                                    requested
                                                    <?php if ($notification->action_title == 'M') : ?> Medical Leave
                                                    <?php elseif ($notification->action_title == 'C') : ?> Casual Leave
                                                    <?php else : ?> Loss of Pay Leave
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    Updated your
                                                    <?php if ($notification->action_title == 'M') : ?> Medical Leave
                                                    <?php elseif ($notification->action_title == 'C') : ?> Casual Leave
                                                    <?php else : ?> Loss of Pay Leave
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php $currDateTime = Time::now();
                                                $diff = $currDateTime->diff($notification->creation_date);
                                                $formatted = sprintf('%02d:%02d:%02d', ($diff->days * 24) + $diff->h, $diff->i, $diff->s);
                                                ?>
                                                <span class="time"> <?= $formatted ?></span>
                                            </div>
                                        </div>
                                    </li>

                                <?php elseif ($notification->type == 'task') : ?>

                                    <li>
                                        <div class="activity-user">
                                            <a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                                <?php if ($notification->fromuser->profileFilepath != null && $notification->fromuser->profileFilename != null) : ?>
                                                    <img src="<?= $notification->fromuser->profileFilepath ?>/<?= $notification->fromuser->profileFilename ?>" alt="">
                                                <?php else : ?>
                                                    <img src="/assets/img/profiles/avatar-01.jpg" alt="">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="profile.html" class="name">
                                                    <?= $notification->fromuser->firstname ?> <?= $notification->fromuser->lastname ?>
                                                </a>
                                                <?php if ($data2->type == 'Y') : ?>
                                                    <?php if ($notification->action_status == 'T') : ?>changed the Status of the
                                                    <span class="noti-title"><?= $notification->action_title ?></span> to TODO

                                                    <?php elseif ($notification->action_status == 'I') : ?>changed the Status of the
                                                    <span class="noti-title"><?= $notification->action_title ?></span> to InProgress
                                                <?php else : ?> changed the Status of the <span class="noti-title"><?= $notification->action_title ?> </span> to Completed
                                                <?php endif; ?>


                                            <?php else : ?>
                                                assigned a task <span class="noti-title"><?= $notification->action_title ?></span>
                                            <?php endif; ?>

                                            <?php $currDateTime = Time::now();
                                            $diff = $currDateTime->diff($notification->creation_date);
                                            $formatted = sprintf('%02d:%02d:%02d', ($diff->days * 24) + $diff->h, $diff->i, $diff->s);
                                            ?>
                                            <span class="time"><?= $formatted ?></span>
                                            </div>
                                        </div>
                                    </li>

                                <?php elseif ($notification->type == 'ticket') : ?>

                                    <li>
                                        <div class="activity-user">
                                            <a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                                <img src="assets/img/profiles/avatar-01.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="profile.html" class="name">
                                                <?= $notification->fromuser->firstname ?> <?= $notification->fromuser->lastname ?>
                                                </a>
                                                <?php if ($data2->type == 'Y') : ?>

                                                    Created the ticket <a href="#"><?= $notification->action_title ?></a>
                                                <?php else : ?>
                                                    Updated the ticket <span class="noti-title"><?= $notification->action_title ?></span>
                                                <?php endif; ?>

                                                <?php $currDateTime = Time::now();
                                                $diff = $currDateTime->diff($notification->creation_date);
                                                $formatted = sprintf('%02d:%02d:%02d', ($diff->days * 24) + $diff->h, $diff->i, $diff->s);
                                                ?>
                                                <span class="time"><?= $formatted ?></span>
                                            </div>
                                        </div>
                                    </li>



                                <?php elseif ($notification->type == 'comment') : ?>


                                    <li>
                                        <div class="activity-user">
                                            <a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                                <img src="assets/img/profiles/avatar-01.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="profile.html" class="name">
                                                <?= $notification->fromuser->firstname ?> <?= $notification->fromuser->lastname ?>
                                                </a>

                                                <?php if ($notification->action_status == 'comment') : ?>

                                                    Commented on <a href="#"><?= $notification->action_title ?></a> <?= $notification->action_description ?>
                                                <?php else : ?>
                                                    Replied on <?= $notification->action_status ?> <span class="noti-title"><?= $notification->action_title ?></span>
                                                <?php endif; ?>

                                                <?php $currDateTime = Time::now();
                                                $diff = $currDateTime->diff($notification->creation_date);
                                                $formatted = sprintf('%02d:%02d:%02d', ($diff->days * 24) + $diff->h, $diff->i, $diff->s);
                                                ?>
                                                <span class="time"><?= $formatted ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php elseif ($notification->type == 'project') : ?>

                                    <li>
                                        <div class="activity-user">
                                            <a href="profile.html" title="Lesley Grauer" data-toggle="tooltip" class="avatar">
                                                <img src="assets/img/profiles/avatar-01.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <div class="timeline-content">
                                                <a href="profile.html" class="name">
                                                <?= $notification->fromuser->firstname ?> <?= $notification->fromuser->lastname ?> <?= $notification->type ?>
                                                </a>  <?= $notification->action_status?> <a href="#"><?= $notification->action_title ?></a> <?= $notification->action_description ?>

                                                <?php $currDateTime = Time::now();
                                                $diff = $currDateTime->diff($notification->creation_date);
                                                $formatted = sprintf('%02d:%02d:%02d', ($diff->days * 24) + $diff->h, $diff->i, $diff->s);
                                                ?>
                                                <span class="time"><?= $formatted ?></span>
                                            </div>
                                        </div>
                                    </li>

                                <?php else : ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
