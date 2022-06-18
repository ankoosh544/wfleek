<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoiceitem $invoiceitem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Invoiceitem'), ['action' => 'edit', $invoiceitem->itemId]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Invoiceitem'), ['action' => 'delete', $invoiceitem->itemId], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceitem->itemId)]) ?> </li>
        <li><?= $this->Html->link(__('List Invoiceitems'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Invoiceitem'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="invoiceitems view large-9 medium-8 columns content">
    <h3><?= h($invoiceitem->itemId) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($invoiceitem->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ItemId') ?></th>
            <td><?= $this->Number->format($invoiceitem->itemId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('InvoiceId') ?></th>
            <td><?= $this->Number->format($invoiceitem->invoiceId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($invoiceitem->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($invoiceitem->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $invoiceitem->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
