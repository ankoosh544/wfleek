<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcommentlike[]|\Cake\Collection\CollectionInterface $postcommentlikes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Postcommentlike'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postcommentlikes index large-9 medium-8 columns content">
    <h3><?= __('Postcommentlikes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reply_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isLiked') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($postcommentlikes as $postcommentlike): ?>
            <tr>
                <td><?= $this->Number->format($postcommentlike->id) ?></td>
                <td><?= $postcommentlike->has('comment') ? $this->Html->link($postcommentlike->comment->id, ['controller' => 'Comments', 'action' => 'view', $postcommentlike->comment->id]) : '' ?></td>
                <td><?= $this->Number->format($postcommentlike->reply_id) ?></td>
                <td><?= $postcommentlike->has('group') ? $this->Html->link($postcommentlike->group->name, ['controller' => 'Groups', 'action' => 'view', $postcommentlike->group->id]) : '' ?></td>
                <td><?= $this->Number->format($postcommentlike->user_id) ?></td>
                <td><?= h($postcommentlike->isLiked) ?></td>
                <td><?= $this->Number->format($postcommentlike->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $postcommentlike->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $postcommentlike->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $postcommentlike->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postcommentlike->id)]) ?>
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
