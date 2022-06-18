<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip[]|\Cake\Collection\CollectionInterface $payslips
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payslip'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payslips index large-9 medium-8 columns content">
    <h3><?= __('Payslips') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('month') ?></th>
                <th scope="col"><?= $this->Paginator->sort('year') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payslip') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payslips as $payslip): ?>
            <tr>
                <td><?= $this->Number->format($payslip->id) ?></td>
                <td><?= $this->Number->format($payslip->user_id) ?></td>
                <td><?= $this->Number->format($payslip->company_id) ?></td>
                <td><?= h($payslip->month) ?></td>
                <td><?= $this->Number->format($payslip->year) ?></td>
                <td><?= h($payslip->payslip) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $payslip->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payslip->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id)]) ?>
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
