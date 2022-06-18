<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeShift[]|\Cake\Collection\CollectionInterface $employeeShifts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee Shift'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeShifts index large-9 medium-8 columns content">
    <h3><?= __('Employee Shifts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isRepeated') ?></th>
                <th scope="col"><?= $this->Paginator->sort('days_to_repeat') ?></th>
                <th scope="col"><?= $this->Paginator->sort('endof_repeating_shift') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isIndefinite') ?></th>
                <th scope="col"><?= $this->Paginator->sort('note') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeShifts as $employeeShift): ?>
            <tr>
                <td><?= $this->Number->format($employeeShift->id) ?></td>
                <td><?= $this->Number->format($employeeShift->company_id) ?></td>
                <td><?= h($employeeShift->name) ?></td>
                <td><?= h($employeeShift->start_time) ?></td>
                <td><?= h($employeeShift->end_time) ?></td>
                <td><?= h($employeeShift->isRepeated) ?></td>
                <td><?= $this->Number->format($employeeShift->days_to_repeat) ?></td>
                <td><?= h($employeeShift->endof_repeating_shift) ?></td>
                <td><?= h($employeeShift->isIndefinite) ?></td>
                <td><?= h($employeeShift->note) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeeShift->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeShift->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeShift->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeShift->id)]) ?>
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
