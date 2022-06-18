<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Taskgroup[]|\Cake\Collection\CollectionInterface $taskgroups
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Taskgroup'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['controller' => 'Projecttasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Projecttask'), ['controller' => 'Projecttasks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="taskgroups index large-9 medium-8 columns content">
    <h3><?= __('Taskgroups') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_percentage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_update') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($taskgroups as $taskgroup): ?>
            <tr>
                <td><?= $this->Number->format($taskgroup->id) ?></td>
                <td><?= h($taskgroup->title) ?></td>
                <td><?= $this->Number->format($taskgroup->price) ?></td>
                <td><?= $this->Number->format($taskgroup->tax_percentage) ?></td>
                <td><?= h($taskgroup->last_update) ?></td>
                <td><?= h($taskgroup->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $taskgroup->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $taskgroup->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $taskgroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $taskgroup->id)]) ?>
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
