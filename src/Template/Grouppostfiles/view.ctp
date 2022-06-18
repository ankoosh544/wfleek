<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouppostfile $grouppostfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grouppostfile'), ['action' => 'edit', $grouppostfile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grouppostfile'), ['action' => 'delete', $grouppostfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grouppostfile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Grouppostfiles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grouppostfile'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groupposts'), ['controller' => 'Groupposts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grouppost'), ['controller' => 'Groupposts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="grouppostfiles view large-9 medium-8 columns content">
    <h3><?= h($grouppostfile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $grouppostfile->has('group') ? $this->Html->link($grouppostfile->group->name, ['controller' => 'Groups', 'action' => 'view', $grouppostfile->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Grouppost') ?></th>
            <td><?= $grouppostfile->has('grouppost') ? $this->Html->link($grouppostfile->grouppost->id, ['controller' => 'Groupposts', 'action' => 'view', $grouppostfile->grouppost->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filepath') ?></th>
            <td><?= h($grouppostfile->filepath) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($grouppostfile->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($grouppostfile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $grouppostfile->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
