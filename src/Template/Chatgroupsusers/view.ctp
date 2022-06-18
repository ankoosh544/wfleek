<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatgroupsuser $chatgroupsuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Chatgroupsuser'), ['action' => 'edit', $chatgroupsuser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Chatgroupsuser'), ['action' => 'delete', $chatgroupsuser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatgroupsuser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Chatgroupsusers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chatgroupsuser'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="chatgroupsusers view large-9 medium-8 columns content">
    <h3><?= h($chatgroupsuser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($chatgroupsuser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group Id') ?></th>
            <td><?= $this->Number->format($chatgroupsuser->group_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($chatgroupsuser->user_id) ?></td>
        </tr>
    </table>
</div>
