<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
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
<div class="user index large-9 medium-8 columns content">
    <h3><?= __('User') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firstname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email2') ?></th>
                <th scope="col"><?= $this->Paginator->sort('langId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('passwordExpirationDate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastChangePwdTime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isOrganization') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nickname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isBlocked') ?></th>
                <th scope="col"><?= $this->Paginator->sort('blockReason') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tel') ?></th>
                <th scope="col"><?= $this->Paginator->sort('registrationDate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expirationDate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastUpdate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('imageFileName') ?></th>
                <th scope="col"><?= $this->Paginator->sort('imageFilePath') ?></th>
                <th scope="col"><?= $this->Paginator->sort('anagId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isReferral') ?></th>
                <th scope="col"><?= $this->Paginator->sort('referralPrivateUserId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('level') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isAuthByReferral') ?></th>
                <th scope="col"><?= $this->Paginator->sort('birthday') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->isDeleted) ?></td>
                <td><?= h($user->firstname) ?></td>
                <td><?= h($user->lastname) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->email2) ?></td>
                <td><?= h($user->langId) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->password) ?></td>
                <td><?= h($user->passwordExpirationDate) ?></td>
                <td><?= h($user->lastChangePwdTime) ?></td>
                <td><?= h($user->isOrganization) ?></td>
                <td><?= h($user->nickname) ?></td>
                <td><?= h($user->isBlocked) ?></td>
                <td><?= h($user->blockReason) ?></td>
                <td><?= h($user->tel) ?></td>
                <td><?= h($user->registrationDate) ?></td>
                <td><?= h($user->expirationDate) ?></td>
                <td><?= h($user->lastUpdate) ?></td>
                <td><?= h($user->imageFileName) ?></td>
                <td><?= h($user->imageFilePath) ?></td>
                <td><?= $this->Number->format($user->anagId) ?></td>
                <td><?= h($user->isReferral) ?></td>
                <td><?= $this->Number->format($user->referralPrivateUserId) ?></td>
                <td><?= $this->Number->format($user->level) ?></td>
                <td><?= h($user->isAuthByReferral) ?></td>
                <td><?= h($user->birthday) ?></td>
                <td><?= h($user->address) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
