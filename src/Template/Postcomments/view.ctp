<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcomment $postcomment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Postcomment'), ['action' => 'edit', $postcomment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Postcomment'), ['action' => 'delete', $postcomment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postcomment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Postcomments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Postcomment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Postcomments'), ['controller' => 'Postcomments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Postcomment'), ['controller' => 'Postcomments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Postcomments'), ['controller' => 'Postcomments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Postcomment'), ['controller' => 'Postcomments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="postcomments view large-9 medium-8 columns content">
    <h3><?= h($postcomment->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Parent Postcomment') ?></th>
            <td><?= $postcomment->has('parent_postcomment') ? $this->Html->link($postcomment->parent_postcomment->id, ['controller' => 'Postcomments', 'action' => 'view', $postcomment->parent_postcomment->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $postcomment->has('group') ? $this->Html->link($postcomment->group->name, ['controller' => 'Groups', 'action' => 'view', $postcomment->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comment Data') ?></th>
            <td><?= h($postcomment->comment_data) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($postcomment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Id') ?></th>
            <td><?= $this->Number->format($postcomment->post_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($postcomment->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($postcomment->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $postcomment->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Postcomments') ?></h4>
        <?php if (!empty($postcomment->child_postcomments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Group Id') ?></th>
                <th scope="col"><?= __('Post Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Comment Data') ?></th>
                <th scope="col"><?= __('IsDeleted') ?></th>
                <th scope="col"><?= __('Creation Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($postcomment->child_postcomments as $childPostcomments): ?>
            <tr>
                <td><?= h($childPostcomments->id) ?></td>
                <td><?= h($childPostcomments->parent_id) ?></td>
                <td><?= h($childPostcomments->group_id) ?></td>
                <td><?= h($childPostcomments->post_id) ?></td>
                <td><?= h($childPostcomments->user_id) ?></td>
                <td><?= h($childPostcomments->comment_data) ?></td>
                <td><?= h($childPostcomments->isDeleted) ?></td>
                <td><?= h($childPostcomments->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Postcomments', 'action' => 'view', $childPostcomments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Postcomments', 'action' => 'edit', $childPostcomments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Postcomments', 'action' => 'delete', $childPostcomments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childPostcomments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
