<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShiftSchedule $shiftSchedule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Shift Schedule'), ['action' => 'edit', $shiftSchedule->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Shift Schedule'), ['action' => 'delete', $shiftSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shiftSchedule->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Shift Schedules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Shift Schedule'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Departments'), ['controller' => 'Departments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Department'), ['controller' => 'Departments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="shiftSchedules view large-9 medium-8 columns content">
    <h3><?= h($shiftSchedule->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Department') ?></th>
            <td><?= $shiftSchedule->has('department') ? $this->Html->link($shiftSchedule->department->id, ['controller' => 'Departments', 'action' => 'view', $shiftSchedule->department->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($shiftSchedule->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($shiftSchedule->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shift Id') ?></th>
            <td><?= $this->Number->format($shiftSchedule->shift_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Shift Date') ?></th>
            <td><?= h($shiftSchedule->shift_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsAcceptExtrahrs') ?></th>
            <td><?= $shiftSchedule->isAcceptExtrahrs ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsPublish') ?></th>
            <td><?= $shiftSchedule->isPublish ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
