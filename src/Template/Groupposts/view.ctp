<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouppost $grouppost
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grouppost'), ['action' => 'edit', $grouppost->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grouppost'), ['action' => 'delete', $grouppost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grouppost->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupposts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grouppost'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupposts view large-9 medium-8 columns content">
    <h3><?= h($grouppost->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $grouppost->has('group') ? $this->Html->link($grouppost->group->name, ['controller' => 'Groups', 'action' => 'view', $grouppost->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Data') ?></th>
            <td><?= h($grouppost->post_data) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($grouppost->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($grouppost->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $grouppost->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
