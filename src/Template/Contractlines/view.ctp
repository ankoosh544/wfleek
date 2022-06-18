<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractline $contractline
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contractline'), ['action' => 'edit', $contractline->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contractline'), ['action' => 'delete', $contractline->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractline->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contractlines'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractline'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contracts'), ['controller' => 'Contracts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contract'), ['controller' => 'Contracts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contractlines view large-9 medium-8 columns content">
    <h3><?= h($contractline->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contract') ?></th>
            <td><?= $contractline->has('contract') ? $this->Html->link($contractline->contract->title, ['controller' => 'Contracts', 'action' => 'view', $contractline->contract->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractline->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($contractline->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Percentage') ?></th>
            <td><?= $this->Number->format($contractline->tax_percentage) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Grouptitle') ?></h4>
        <?= $this->Text->autoParagraph(h($contractline->grouptitle)); ?>
    </div>
    <div class="row">
        <h4><?= __('Tasktitle') ?></h4>
        <?= $this->Text->autoParagraph(h($contractline->tasktitle)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description Task') ?></h4>
        <?= $this->Text->autoParagraph(h($contractline->description_task)); ?>
    </div>
</div>
