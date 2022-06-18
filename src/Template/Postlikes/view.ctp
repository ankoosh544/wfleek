<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postlike $postlike
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Postlike'), ['action' => 'edit', $postlike->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Postlike'), ['action' => 'delete', $postlike->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postlike->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Postlikes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Postlike'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="postlikes view large-9 medium-8 columns content">
    <h3><?= h($postlike->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($postlike->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Id') ?></th>
            <td><?= $this->Number->format($postlike->post_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($postlike->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $postlike->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
