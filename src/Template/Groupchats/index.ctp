<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupchat[]|\Cake\Collection\CollectionInterface $groupchats
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Groupchat'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Chatgroups'), ['controller' => 'Chatgroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Chatgroup'), ['controller' => 'Chatgroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'User', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groupchatfiles'), ['controller' => 'Groupchatfiles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Groupchatfile'), ['controller' => 'Groupchatfiles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupchats index large-9 medium-8 columns content">
    <h3><?= __('Groupchats') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parentgroupchat_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('content') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_update') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupchats as $groupchat): ?>
            <tr>
                <td><?= $this->Number->format($groupchat->id) ?></td>
                <td><?= $this->Number->format($groupchat->parentgroupchat_id) ?></td>
                <td><?= $groupchat->has('user') ? $this->Html->link($groupchat->user->id, ['controller' => 'User', 'action' => 'view', $groupchat->user->id]) : '' ?></td>
                <td><?= $groupchat->has('chatgroup') ? $this->Html->link($groupchat->chatgroup->name, ['controller' => 'Chatgroups', 'action' => 'view', $groupchat->chatgroup->id]) : '' ?></td>
                <td><?= h($groupchat->content) ?></td>
                <td><?= h($groupchat->creation_date) ?></td>
                <td><?= h($groupchat->last_update) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $groupchat->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $groupchat->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $groupchat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupchat->id)]) ?>
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
