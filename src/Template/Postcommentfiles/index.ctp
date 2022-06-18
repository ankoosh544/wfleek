<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcommentfile[]|\Cake\Collection\CollectionInterface $postcommentfiles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Postcommentfile'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postcommentfiles index large-9 medium-8 columns content">
    <h3><?= __('Postcommentfiles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('comment_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filepath') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filename') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($postcommentfiles as $postcommentfile): ?>
            <tr>
                <td><?= $this->Number->format($postcommentfile->id) ?></td>
                <td><?= $this->Number->format($postcommentfile->post_id) ?></td>
                <td><?= $postcommentfile->has('comment') ? $this->Html->link($postcommentfile->comment->id, ['controller' => 'Comments', 'action' => 'view', $postcommentfile->comment->id]) : '' ?></td>
                <td><?= $postcommentfile->has('group') ? $this->Html->link($postcommentfile->group->name, ['controller' => 'Groups', 'action' => 'view', $postcommentfile->group->id]) : '' ?></td>
                <td><?= $this->Number->format($postcommentfile->user_id) ?></td>
                <td><?= h($postcommentfile->filepath) ?></td>
                <td><?= h($postcommentfile->filename) ?></td>
                <td><?= h($postcommentfile->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $postcommentfile->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $postcommentfile->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $postcommentfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postcommentfile->id)]) ?>
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
