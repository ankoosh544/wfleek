<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatcontact $chatcontact
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Chatcontact'), ['action' => 'edit', $chatcontact->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Chatcontact'), ['action' => 'delete', $chatcontact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatcontact->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Chatcontacts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chatcontact'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="chatcontacts view large-9 medium-8 columns content">
    <h3><?= h($chatcontact->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($chatcontact->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($chatcontact->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($chatcontact->creation_date) ?></td>
        </tr>
    </table>
</div>
