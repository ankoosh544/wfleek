<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupfilepost $groupfilepost
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupfilepost'), ['action' => 'edit', $groupfilepost->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupfilepost'), ['action' => 'delete', $groupfilepost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupfilepost->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupfileposts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupfilepost'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupfileposts view large-9 medium-8 columns content">
    <h3><?= h($groupfilepost->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $groupfilepost->has('group') ? $this->Html->link($groupfilepost->group->name, ['controller' => 'Groups', 'action' => 'view', $groupfilepost->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupfilepost->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($groupfilepost->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($groupfilepost->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $groupfilepost->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
