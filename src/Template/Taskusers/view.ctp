<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Taskuser $taskuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Taskuser'), ['action' => 'edit', $taskuser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Taskuser'), ['action' => 'delete', $taskuser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $taskuser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Taskusers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Taskuser'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="taskusers view large-9 medium-8 columns content">
    <h3><?= h($taskuser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($taskuser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('TaskId') ?></th>
            <td><?= $this->Number->format($taskuser->taskId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Assignee Id') ?></th>
            <td><?= $this->Number->format($taskuser->assignee_id) ?></td>
        </tr>
    </table>
</div>
