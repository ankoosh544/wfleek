<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractline[]|\Cake\Collection\CollectionInterface $contractlines
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contractline'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contracts'), ['controller' => 'Contracts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contract'), ['controller' => 'Contracts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractlines index large-9 medium-8 columns content">
    <h3><?= __('Contractlines') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contract_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_percentage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contractlines as $contractline): ?>
            <tr>
                <td><?= $this->Number->format($contractline->id) ?></td>
                <td><?= $contractline->has('contract') ? $this->Html->link($contractline->contract->title, ['controller' => 'Contracts', 'action' => 'view', $contractline->contract->id]) : '' ?></td>
                <td><?= $this->Number->format($contractline->price) ?></td>
                <td><?= $this->Number->format($contractline->tax_percentage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contractline->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contractline->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractline->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractline->id)]) ?>
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
