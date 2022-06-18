<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouppostfile[]|\Cake\Collection\CollectionInterface $grouppostfiles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Grouppostfile'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groupposts'), ['controller' => 'Groupposts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grouppost'), ['controller' => 'Groupposts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grouppostfiles index large-9 medium-8 columns content">
    <h3><?= __('Grouppostfiles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('grouppost_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filepath') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filename') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grouppostfiles as $grouppostfile): ?>
            <tr>
                <td><?= $this->Number->format($grouppostfile->id) ?></td>
                <td><?= $grouppostfile->has('group') ? $this->Html->link($grouppostfile->group->name, ['controller' => 'Groups', 'action' => 'view', $grouppostfile->group->id]) : '' ?></td>
                <td><?= $grouppostfile->has('grouppost') ? $this->Html->link($grouppostfile->grouppost->id, ['controller' => 'Groupposts', 'action' => 'view', $grouppostfile->grouppost->id]) : '' ?></td>
                <td><?= h($grouppostfile->filepath) ?></td>
                <td><?= h($grouppostfile->filename) ?></td>
                <td><?= h($grouppostfile->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $grouppostfile->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $grouppostfile->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $grouppostfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grouppostfile->id)]) ?>
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
