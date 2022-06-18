<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Favoritepost[]|\Cake\Collection\CollectionInterface $favoriteposts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Favoritepost'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="favoriteposts index large-9 medium-8 columns content">
    <h3><?= __('Favoriteposts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($favoriteposts as $favoritepost): ?>
            <tr>
                <td><?= $this->Number->format($favoritepost->post_id) ?></td>
                <td><?= $this->Number->format($favoritepost->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $favoritepost->post_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $favoritepost->post_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $favoritepost->post_id], ['confirm' => __('Are you sure you want to delete # {0}?', $favoritepost->post_id)]) ?>
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
