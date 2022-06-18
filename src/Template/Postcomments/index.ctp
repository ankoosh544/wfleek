<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcomment[]|\Cake\Collection\CollectionInterface $postcomments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Postcomment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postcomments index large-9 medium-8 columns content">
    <h3><?= __('Postcomments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment_data') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($postcomments as $postcomment): ?>
            <tr>
                <td><?= $this->Number->format($postcomment->id) ?></td>
                <td><?= $postcomment->has('parent_postcomment') ? $this->Html->link($postcomment->parent_postcomment->id, ['controller' => 'Postcomments', 'action' => 'view', $postcomment->parent_postcomment->id]) : '' ?></td>
                <td><?= $postcomment->has('group') ? $this->Html->link($postcomment->group->name, ['controller' => 'Groups', 'action' => 'view', $postcomment->group->id]) : '' ?></td>
                <td><?= $this->Number->format($postcomment->post_id) ?></td>
                <td><?= $this->Number->format($postcomment->user_id) ?></td>
                <td><?= h($postcomment->comment_data) ?></td>
                <td><?= h($postcomment->isDeleted) ?></td>
                <td><?= h($postcomment->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $postcomment->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $postcomment->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $postcomment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postcomment->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
