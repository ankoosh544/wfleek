<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatgroup[]|\Cake\Collection\CollectionInterface $chatgroups
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Chatgroup'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="chatgroups index large-9 medium-8 columns content">
    <h3><?= __('Chatgroups') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creator') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chatgroups as $chatgroup): ?>
            <tr>
                <td><?= $this->Number->format($chatgroup->id) ?></td>
                <td><?= h($chatgroup->name) ?></td>
                <td><?= $this->Number->format($chatgroup->creator) ?></td>
                <td><?= h($chatgroup->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $chatgroup->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatgroup->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatgroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatgroup->id)]) ?>
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
