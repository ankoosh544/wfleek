<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary[]|\Cake\Collection\CollectionInterface $salaries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Salary'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="salaries index large-9 medium-8 columns content">
    <h3><?= __('Salaries') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('net_salary') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tds') ?></th>
                <th scope="col"><?= $this->Paginator->sort('da') ?></th>
                <th scope="col"><?= $this->Paginator->sort('esi') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hra') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pf') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salaries as $salary): ?>
            <tr>
                <td><?= $this->Number->format($salary->id) ?></td>
                <td><?= $this->Number->format($salary->user_id) ?></td>
                <td><?= $this->Number->format($salary->company_id) ?></td>
                <td><?= $this->Number->format($salary->net_salary) ?></td>
                <td><?= $this->Number->format($salary->tds) ?></td>
                <td><?= $this->Number->format($salary->da) ?></td>
                <td><?= $this->Number->format($salary->esi) ?></td>
                <td><?= $this->Number->format($salary->hra) ?></td>
                <td><?= $this->Number->format($salary->pf) ?></td>
                <td><?= $this->Number->format($salary->tax) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $salary->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salary->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salary->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salary->id)]) ?>
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
