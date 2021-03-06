<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShiftSchedule[]|\Cake\Collection\CollectionInterface $shiftSchedules
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Shift Schedule'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Departments'), ['controller' => 'Departments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Department'), ['controller' => 'Departments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shiftSchedules index large-9 medium-8 columns content">
    <h3><?= __('Shift Schedules') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('department_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shift_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('shift_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isAcceptExtrahrs') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isPublish') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shiftSchedules as $shiftSchedule): ?>
            <tr>
                <td><?= $this->Number->format($shiftSchedule->id) ?></td>
                <td><?= $shiftSchedule->has('department') ? $this->Html->link($shiftSchedule->department->id, ['controller' => 'Departments', 'action' => 'view', $shiftSchedule->department->id]) : '' ?></td>
                <td><?= $this->Number->format($shiftSchedule->user_id) ?></td>
                <td><?= $this->Number->format($shiftSchedule->shift_id) ?></td>
                <td><?= h($shiftSchedule->shift_date) ?></td>
                <td><?= h($shiftSchedule->isAcceptExtrahrs) ?></td>
                <td><?= h($shiftSchedule->isPublish) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shiftSchedule->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shiftSchedule->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shiftSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shiftSchedule->id)]) ?>
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
