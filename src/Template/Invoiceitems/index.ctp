<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoiceitem[]|\Cake\Collection\CollectionInterface $invoiceitems
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Invoiceitem'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="invoiceitems index large-9 medium-8 columns content">
    <h3><?= __('Invoiceitems') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('itemId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoiceId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceitems as $invoiceitem): ?>
            <tr>
                <td><?= $this->Number->format($invoiceitem->itemId) ?></td>
                <td><?= $this->Number->format($invoiceitem->invoiceId) ?></td>
                <td><?= h($invoiceitem->description) ?></td>
                <td><?= $this->Number->format($invoiceitem->quantity) ?></td>
                <td><?= $this->Number->format($invoiceitem->price) ?></td>
                <td><?= h($invoiceitem->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $invoiceitem->itemId]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoiceitem->itemId]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoiceitem->itemId], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceitem->itemId)]) ?>
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
