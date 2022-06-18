<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EpictasksProjecttask[]|\Cake\Collection\CollectionInterface $epictasksProjecttasks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Epictasks Projecttask'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['controller' => 'Projecttasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Projecttask'), ['controller' => 'Projecttasks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="epictasksProjecttasks index large-9 medium-8 columns content">
    <h3><?= __('Epictasks Projecttasks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('epictask_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('projecttask_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('projectId') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($epictasksProjecttasks as $epictasksProjecttask): ?>
            <tr>
                <td><?= $this->Number->format($epictasksProjecttask->epictask_id) ?></td>
                <td><?= $epictasksProjecttask->has('projecttask') ? $this->Html->link($epictasksProjecttask->projecttask->title, ['controller' => 'Projecttasks', 'action' => 'view', $epictasksProjecttask->projecttask->id]) : '' ?></td>
                <td><?= $this->Number->format($epictasksProjecttask->projectId) ?></td>
                <td><?= h($epictasksProjecttask->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $epictasksProjecttask->epictask_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $epictasksProjecttask->epictask_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $epictasksProjecttask->epictask_id], ['confirm' => __('Are you sure you want to delete # {0}?', $epictasksProjecttask->epictask_id)]) ?>
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
