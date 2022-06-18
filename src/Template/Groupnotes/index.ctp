<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupnote[]|\Cake\Collection\CollectionInterface $groupnotes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Groupnote'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupnotes index large-9 medium-8 columns content">
    <h3><?= __('Groupnotes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_update') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isShared') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupnotes as $groupnote): ?>
            <tr>
                <td><?= $this->Number->format($groupnote->id) ?></td>
                <td><?= $groupnote->has('group') ? $this->Html->link($groupnote->group->name, ['controller' => 'Groups', 'action' => 'view', $groupnote->group->id]) : '' ?></td>
                <td><?= $this->Number->format($groupnote->user_id) ?></td>
                <td><?= h($groupnote->creation_date) ?></td>
                <td><?= h($groupnote->last_update) ?></td>
                <td><?= h($groupnote->isShared) ?></td>
                <td><?= h($groupnote->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $groupnote->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $groupnote->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $groupnote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupnote->id)]) ?>
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
