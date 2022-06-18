<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employeesdailyworkflow $employeesdailyworkflow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employeesdailyworkflow'), ['action' => 'edit', $employeesdailyworkflow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employeesdailyworkflow'), ['action' => 'delete', $employeesdailyworkflow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeesdailyworkflow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employeesdailyworkflow'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employeesdailyworkflow'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeesdailyworkflow view large-9 medium-8 columns content">
    <h3><?= h($employeesdailyworkflow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $employeesdailyworkflow->has('user') ? $this->Html->link($employeesdailyworkflow->user->id, ['controller' => 'User', 'action' => 'view', $employeesdailyworkflow->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($employeesdailyworkflow->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeesdailyworkflow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fromdate') ?></th>
            <td><?= h($employeesdailyworkflow->fromdate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Todate') ?></th>
            <td><?= h($employeesdailyworkflow->todate) ?></td>
        </tr>
    </table>
</div>
