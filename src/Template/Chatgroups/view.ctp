<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatgroup $chatgroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Chatgroup'), ['action' => 'edit', $chatgroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Chatgroup'), ['action' => 'delete', $chatgroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatgroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Chatgroups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chatgroup'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="chatgroups view large-9 medium-8 columns content">
    <h3><?= h($chatgroup->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($chatgroup->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($chatgroup->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creator') ?></th>
            <td><?= $this->Number->format($chatgroup->creator) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($chatgroup->creation_date) ?></td>
        </tr>
    </table>
</div>
