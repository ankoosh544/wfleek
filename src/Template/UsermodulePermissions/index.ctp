<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsermodulePermission[]|\Cake\Collection\CollectionInterface $usermodulePermissions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Usermodule Permission'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Designations'), ['controller' => 'Designations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Designation'), ['controller' => 'Designations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usermodulePermissions index large-9 medium-8 columns content">
    <h3><?= __('Usermodule Permissions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('designation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('module_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isAccessed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isRead') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isWrite') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isCreate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDelete') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isImport') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isExport') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usermodulePermissions as $usermodulePermission): ?>
            <tr>
                <td><?= $this->Number->format($usermodulePermission->id) ?></td>
                <td><?= $usermodulePermission->has('designation') ? $this->Html->link($usermodulePermission->designation->name, ['controller' => 'Designations', 'action' => 'view', $usermodulePermission->designation->id]) : '' ?></td>
                <td><?= $this->Number->format($usermodulePermission->module_id) ?></td>
                <td><?= h($usermodulePermission->isAccessed) ?></td>
                <td><?= h($usermodulePermission->isRead) ?></td>
                <td><?= h($usermodulePermission->isWrite) ?></td>
                <td><?= h($usermodulePermission->isCreate) ?></td>
                <td><?= h($usermodulePermission->isDelete) ?></td>
                <td><?= h($usermodulePermission->isImport) ?></td>
                <td><?= h($usermodulePermission->isExport) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $usermodulePermission->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usermodulePermission->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usermodulePermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usermodulePermission->id)]) ?>
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
