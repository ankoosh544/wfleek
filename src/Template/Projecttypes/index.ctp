<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projecttype[]|\Cake\Collection\CollectionInterface $projecttypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Projecttype'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projecttypes index large-9 medium-8 columns content">
    <h3><?= __('Projecttypes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projecttypes as $projecttype): ?>
            <tr>
                <td><?= $this->Number->format($projecttype->id) ?></td>
                <td><?= $this->Number->format($projecttype->order_number) ?></td>
                <td><?= h($projecttype->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projecttype->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projecttype->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projecttype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projecttype->id)]) ?>
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
