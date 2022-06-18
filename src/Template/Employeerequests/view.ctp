<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employeerequest $employeerequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employeerequest'), ['action' => 'edit', $employeerequest->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employeerequest'), ['action' => 'delete', $employeerequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeerequest->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employeerequests'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employeerequest'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeerequests view large-9 medium-8 columns content">
    <h3><?= h($employeerequest->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Request Type') ?></th>
            <td><?= h($employeerequest->request_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($employeerequest->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeerequest->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($employeerequest->user_id) ?></td>
        </tr>
    </table>
</div>
