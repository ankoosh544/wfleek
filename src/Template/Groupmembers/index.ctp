<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupmember[]|\Cake\Collection\CollectionInterface $groupmembers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Groupmember'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupmembers index large-9 medium-8 columns content">
    <h3><?= __('Groupmembers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('member_role') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupmembers as $groupmember): ?>
            <tr>
                <td><?= $this->Number->format($groupmember->id) ?></td>
                <td><?= $groupmember->has('group') ? $this->Html->link($groupmember->group->name, ['controller' => 'Groups', 'action' => 'view', $groupmember->group->id]) : '' ?></td>
                <td><?= $this->Number->format($groupmember->user_id) ?></td>
                <td><?= h($groupmember->member_role) ?></td>
                <td><?= h($groupmember->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $groupmember->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $groupmember->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $groupmember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupmember->id)]) ?>
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
