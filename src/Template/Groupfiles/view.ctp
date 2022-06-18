<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupfile $groupfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupfile'), ['action' => 'edit', $groupfile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupfile'), ['action' => 'delete', $groupfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupfile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupfiles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupfile'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupfiles view large-9 medium-8 columns content">
    <h3><?= h($groupfile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $groupfile->has('group') ? $this->Html->link($groupfile->group->name, ['controller' => 'Groups', 'action' => 'view', $groupfile->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($groupfile->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filepath') ?></th>
            <td><?= h($groupfile->filepath) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupfile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($groupfile->company_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($groupfile->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($groupfile->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $groupfile->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
