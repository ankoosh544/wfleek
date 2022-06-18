<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contract $contract
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contract'), ['action' => 'edit', $contract->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contract'), ['action' => 'delete', $contract->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contract->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contracts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contract'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractlines'), ['controller' => 'Contractlines', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractline'), ['controller' => 'Contractlines', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contracts view large-9 medium-8 columns content">
    <h3><?= h($contract->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($contract->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contract->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= $this->Number->format($contract->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($contract->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Acceptance Date') ?></th>
            <td><?= h($contract->acceptance_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Listof Members') ?></h4>
        <?= $this->Text->autoParagraph(h($contract->listof_members)); ?>
    </div>
    <div class="row">
        <h4><?= __('Content') ?></h4>
        <?= $this->Text->autoParagraph(h($contract->content)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Contractlines') ?></h4>
        <?php if (!empty($contract->contractlines)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Contract Id') ?></th>
                <th scope="col"><?= __('Grouptitle') ?></th>
                <th scope="col"><?= __('Tasktitle') ?></th>
                <th scope="col"><?= __('Description Task') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Tax Percentage') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($contract->contractlines as $contractlines): ?>
            <tr>
                <td><?= h($contractlines->id) ?></td>
                <td><?= h($contractlines->contract_id) ?></td>
                <td><?= h($contractlines->grouptitle) ?></td>
                <td><?= h($contractlines->tasktitle) ?></td>
                <td><?= h($contractlines->description_task) ?></td>
                <td><?= h($contractlines->price) ?></td>
                <td><?= h($contractlines->tax_percentage) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Contractlines', 'action' => 'view', $contractlines->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Contractlines', 'action' => 'edit', $contractlines->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Contractlines', 'action' => 'delete', $contractlines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractlines->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
