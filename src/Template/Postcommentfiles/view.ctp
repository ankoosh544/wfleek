<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcommentfile $postcommentfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Postcommentfile'), ['action' => 'edit', $postcommentfile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Postcommentfile'), ['action' => 'delete', $postcommentfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postcommentfile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Postcommentfiles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Postcommentfile'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="postcommentfiles view large-9 medium-8 columns content">
    <h3><?= h($postcommentfile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Comment') ?></th>
            <td><?= $postcommentfile->has('comment') ? $this->Html->link($postcommentfile->comment->id, ['controller' => 'Comments', 'action' => 'view', $postcommentfile->comment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $postcommentfile->has('group') ? $this->Html->link($postcommentfile->group->name, ['controller' => 'Groups', 'action' => 'view', $postcommentfile->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filepath') ?></th>
            <td><?= h($postcommentfile->filepath) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($postcommentfile->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($postcommentfile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Id') ?></th>
            <td><?= $this->Number->format($postcommentfile->post_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($postcommentfile->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $postcommentfile->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
