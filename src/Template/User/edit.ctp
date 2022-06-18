<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List User'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List E Given Answers'), ['controller' => 'EGivenAnswers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New E Given Answer'), ['controller' => 'EGivenAnswers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List E Lesson Completed'), ['controller' => 'ELessonCompleted', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New E Lesson Completed'), ['controller' => 'ELessonCompleted', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organizatio Users Years'), ['controller' => 'OrganizatioUsersYears', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organizatio Users Year'), ['controller' => 'OrganizatioUsersYears', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Roles'), ['controller' => 'OrganizationRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Role'), ['controller' => 'OrganizationRoles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List School Transcripts'), ['controller' => 'SchoolTranscripts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New School Transcript'), ['controller' => 'SchoolTranscripts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sl Roles'), ['controller' => 'SlRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sl Role'), ['controller' => 'SlRoles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Support Emails'), ['controller' => 'SupportEmails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Support Email'), ['controller' => 'SupportEmails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List E Course'), ['controller' => 'ECourse', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New E Course'), ['controller' => 'ECourse', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization'), ['controller' => 'Organization', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization'), ['controller' => 'Organization', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Role'), ['controller' => 'Role', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Role', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subscription'), ['controller' => 'Subscription', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subscription'), ['controller' => 'Subscription', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="user form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('isDeleted');
            echo $this->Form->control('firstname');
            echo $this->Form->control('lastname');
            echo $this->Form->control('email');
            echo $this->Form->control('email2');
            echo $this->Form->control('langId');
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('passwordExpirationDate');
            echo $this->Form->control('lastChangePwdTime');
            echo $this->Form->control('isOrganization');
            echo $this->Form->control('nickname');
            echo $this->Form->control('isBlocked');
            echo $this->Form->control('blockReason');
            echo $this->Form->control('tel');
            echo $this->Form->control('registrationDate');
            echo $this->Form->control('expirationDate', ['empty' => true]);
            echo $this->Form->control('lastUpdate');
            echo $this->Form->control('imageFileName');
            echo $this->Form->control('imageFilePath');
            echo $this->Form->control('note');
            echo $this->Form->control('anagId');
            echo $this->Form->control('isReferral');
            echo $this->Form->control('referralPrivateUserId');
            echo $this->Form->control('level');
            echo $this->Form->control('isAuthByReferral');
            echo $this->Form->control('birthday', ['empty' => true]);
            echo $this->Form->control('address');
            echo $this->Form->control('gender');
            echo $this->Form->control('e_course._ids', ['options' => $eCourse]);
            echo $this->Form->control('organization._ids', ['options' => $organization]);
            echo $this->Form->control('role._ids', ['options' => $role]);
            echo $this->Form->control('subscription._ids', ['options' => $subscription]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
