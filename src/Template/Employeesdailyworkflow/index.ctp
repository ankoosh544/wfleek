<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employeesdailyworkflow[]|\Cake\Collection\CollectionInterface $employeesdailyworkflow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employeesdailyworkflow'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeesdailyworkflow index large-9 medium-8 columns content">
    <h3><?= __('Employeesdailyworkflow') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fromdate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('todate') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeesdailyworkflow as $employeesdailyworkflow): ?>
            <tr>
                <td><?= $this->Number->format($employeesdailyworkflow->id) ?></td>
                <td><?= $employeesdailyworkflow->has('user') ? $this->Html->link($employeesdailyworkflow->user->id, ['controller' => 'User', 'action' => 'view', $employeesdailyworkflow->user->id]) : '' ?></td>
                <td><?= h($employeesdailyworkflow->status) ?></td>
                <td><?= h($employeesdailyworkflow->fromdate) ?></td>
                <td><?= h($employeesdailyworkflow->todate) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeesdailyworkflow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeesdailyworkflow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeesdailyworkflow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeesdailyworkflow->id)]) ?>
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
