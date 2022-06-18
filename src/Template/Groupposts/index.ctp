<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouppost[]|\Cake\Collection\CollectionInterface $groupposts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Grouppost'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupposts index large-9 medium-8 columns content">
    <h3><?= __('Groupposts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_data') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupposts as $grouppost): ?>
            <tr>
                <td><?= $this->Number->format($grouppost->id) ?></td>
                <td><?= $grouppost->has('group') ? $this->Html->link($grouppost->group->name, ['controller' => 'Groups', 'action' => 'view', $grouppost->group->id]) : '' ?></td>
                <td><?= $this->Number->format($grouppost->user_id) ?></td>
                <td><?= h($grouppost->post_data) ?></td>
                <td><?= h($grouppost->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $grouppost->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $grouppost->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $grouppost->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grouppost->id)]) ?>
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
