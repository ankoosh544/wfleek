<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupmember $groupmember
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupmember'), ['action' => 'edit', $groupmember->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupmember'), ['action' => 'delete', $groupmember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupmember->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupmembers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupmember'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupmembers view large-9 medium-8 columns content">
    <h3><?= h($groupmember->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $groupmember->has('group') ? $this->Html->link($groupmember->group->name, ['controller' => 'Groups', 'action' => 'view', $groupmember->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Member Role') ?></th>
            <td><?= h($groupmember->member_role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupmember->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($groupmember->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $groupmember->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
