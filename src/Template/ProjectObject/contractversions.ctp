<?php

use Cake\I18n\Number;

?>
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Contract Versions</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/project-member/privatedashboard/">Dashboard</a></li>
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
                            <?php if (!empty($previousversions)) : ?>
                                <?php foreach ($previousversions as $version) : ?>
                                    <li>
                                        <div class="activity-user">
                                            <a href="/versions-contract/view/<?= $version->id ?>" title="<?= $version->title ?>" data-toggle="tooltip" class="avatar">
                                                <?php if ($version->acceptance_date != null) : ?>
                                                    <img alt="" style="background-color: red;">
                                                <?php else : ?>
                                                    <img alt="" style="background-color: gray;">
                                                <?php endif; ?>

                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <?php foreach ($projectmembers as $member) : ?>
                                                <div class="timeline-content">
                                                    <a href="/user/view/<?= $member->memberId ?>" class="name"><?= $member->user->firstname ?> <?= $member->user->lastname ?></a>
                                                    <?php if ($version->acceptance_date != null) : ?>
                                                        signed at
                                                        <?= $version->acceptance_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                                    <?php else : ?>
                                                        Not Signed
                                                    <?php endif; ?>
                                                    <a href="/versions-contract/downloadfile/<?=$version->id?>"><?= $version->title ?></a>
                                                    <?php if ($version->price != null) : ?>
                                                        <span class="time">Total Amount = <?= Number::currency($version->price, 'EUR', ['locale' => 'it_IT']); ?> </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>



                            <?php if (!empty($currentversion)) : ?>
                                <li>
                                    <div class="activity-user">
                                        <a href="/versions-contract/view/<?= $currentversion->id ?>" title="<?= $currentversion->title ?>" data-toggle="tooltip" class="avatar">
                                            <?php if ($currentversion->acceptance_date != null) : ?>
                                                <img alt="" style="background-color: green;">
                                            <?php else : ?>
                                                <img alt="" style="background-color: gray;">
                                            <?php endif; ?>

                                        </a>
                                    </div>
                                    <div class="activity-content">
                                        <?php foreach ($projectmembers as $member) : ?>
                                            <div class="timeline-content">
                                                <a href="/user/view/<?= $member->memberId ?>" class="name"><?= $member->user->firstname ?> <?= $member->user->lastname ?></a>
                                                <?php if ($currentversion->acceptance_date != null) : ?>
                                                    signed at
                                                    <?= $currentversion->acceptance_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                                <?php else : ?>
                                                    Not Signed
                                                <?php endif; ?>

                                                <a href="/versions-contract/downloadfile/<?=$currentversion->id?>"><?= $currentversion->title ?></a>

                                                <?php if ($currentversion->price != null) : ?>
                                                    <span class="time">Total Amount = <?= Number::currency($currentversion->price, 'EUR', ['locale' => 'it_IT']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($unsignedfutureversions)) : ?>
                                <?php foreach ($unsignedfutureversions as $futureversion) : ?>
                                    <li>
                                        <div class="activity-user">
                                            <a href="/versions-contract/view/<?= $futureversion->id ?>" title="<?= $futureversion->title ?>" data-toggle="tooltip" class="avatar">
                                                <img alt="" style="background-color: gray;">
                                            </a>
                                        </div>
                                        <div class="activity-content">
                                            <?php foreach ($projectmembers as $member) : ?>
                                                <div class="timeline-content">
                                                    <a href="/user/view/<?= $member->memberId ?>" class="name"><?= $member->user->firstname ?> <?= $member->user->lastname ?></a>
                                                    <?php if ($futureversion->acceptance_date != null) : ?>
                                                        signed at
                                                        <?= $futureversion->acceptance_date->i18nFormat('dd/MM/yyyy', 'Europe/Rome'); ?>
                                                    <?php else : ?>
                                                        Not Signed
                                                    <?php endif; ?>
                                                    <a href="/versions-contract/downloadfile/<?=$futureversion->id?>"><?= $futureversion->title ?></a>
                                                    <?php if ($futureversion->price != null) : ?>
                                                        <span class="time">Total Amount = <?= Number::currency($futureversion->price, 'EUR', ['locale' => 'it_IT']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
