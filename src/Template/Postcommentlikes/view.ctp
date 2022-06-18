<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcommentlike $postcommentlike
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Postcommentlike'), ['action' => 'edit', $postcommentlike->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Postcommentlike'), ['action' => 'delete', $postcommentlike->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postcommentlike->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Postcommentlikes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Postcommentlike'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="postcommentlikes view large-9 medium-8 columns content">
    <h3><?= h($postcommentlike->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= $postcommentlike->has('comment') ? $this->Html->link($postcommentlike->comment->id, ['controller' => 'Comments', 'action' => 'view', $postcommentlike->comment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $postcommentlike->has('group') ? $this->Html->link($postcommentlike->group->name, ['controller' => 'Groups', 'action' => 'view', $postcommentlike->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($postcommentlike->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reply Id') ?></th>
            <td><?= $this->Number->format($postcommentlike->reply_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($postcommentlike->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $this->Number->format($postcommentlike->isDeleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsLiked') ?></th>
            <td><?= $postcommentlike->isLiked ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
