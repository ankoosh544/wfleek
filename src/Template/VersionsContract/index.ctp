<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VersionsContract[]|\Cake\Collection\CollectionInterface $versionsContract
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Versions Contract'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contracts'), ['controller' => 'Contracts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contract'), ['controller' => 'Contracts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="versionsContract index large-9 medium-8 columns content">
    <h3><?= __('Versions Contract') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_object_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contract_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('acceptance_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($versionsContract as $versionsContract): ?>
            <tr>
                <td><?= $this->Number->format($versionsContract->id) ?></td>
                <td><?= $this->Number->format($versionsContract->project_object_id) ?></td>
                <td><?= $versionsContract->has('contract') ? $this->Html->link($versionsContract->contract->title, ['controller' => 'Contracts', 'action' => 'view', $versionsContract->contract->id]) : '' ?></td>
                <td><?= h($versionsContract->title) ?></td>
                <td><?= h($versionsContract->creation_date) ?></td>
                <td><?= h($versionsContract->acceptance_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $versionsContract->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $versionsContract->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $versionsContract->id], ['confirm' => __('Are you sure you want to delete # {0}?', $versionsContract->id)]) ?>
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
