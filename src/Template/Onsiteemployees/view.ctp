<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Onsiteemployee $onsiteemployee
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Onsiteemployee'), ['action' => 'edit', $onsiteemployee->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Onsiteemployee'), ['action' => 'delete', $onsiteemployee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $onsiteemployee->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Onsiteemployees'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Onsiteemployee'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="onsiteemployees view large-9 medium-8 columns content">
    <h3><?= h($onsiteemployee->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($onsiteemployee->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Id') ?></th>
            <td><?= $this->Number->format($onsiteemployee->client_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ProjectId') ?></th>
            <td><?= $this->Number->format($onsiteemployee->projectId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($onsiteemployee->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $onsiteemployee->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
