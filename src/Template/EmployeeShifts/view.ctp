<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeShift $employeeShift
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee Shift'), ['action' => 'edit', $employeeShift->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee Shift'), ['action' => 'delete', $employeeShift->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeShift->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employee Shifts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Shift'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeeShifts view large-9 medium-8 columns content">
    <h3><?= h($employeeShift->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($employeeShift->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= h($employeeShift->note) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeShift->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($employeeShift->company_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Days To Repeat') ?></th>
            <td><?= $this->Number->format($employeeShift->days_to_repeat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($employeeShift->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($employeeShift->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Endof Repeating Shift') ?></th>
            <td><?= h($employeeShift->endof_repeating_shift) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsRepeated') ?></th>
            <td><?= $employeeShift->isRepeated ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsIndefinite') ?></th>
            <td><?= $employeeShift->isIndefinite ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
