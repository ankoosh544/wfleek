<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsermodulePermission $usermodulePermission
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Usermodule Permission'), ['action' => 'edit', $usermodulePermission->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Usermodule Permission'), ['action' => 'delete', $usermodulePermission->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usermodulePermission->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Usermodule Permissions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usermodule Permission'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Designations'), ['controller' => 'Designations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Designation'), ['controller' => 'Designations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="usermodulePermissions view large-9 medium-8 columns content">
    <h3><?= h($usermodulePermission->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Designation') ?></th>
            <td><?= $usermodulePermission->has('designation') ? $this->Html->link($usermodulePermission->designation->name, ['controller' => 'Designations', 'action' => 'view', $usermodulePermission->designation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($usermodulePermission->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Module Id') ?></th>
            <td><?= $this->Number->format($usermodulePermission->module_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsAccessed') ?></th>
            <td><?= $usermodulePermission->isAccessed ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsRead') ?></th>
            <td><?= $usermodulePermission->isRead ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsWrite') ?></th>
            <td><?= $usermodulePermission->isWrite ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsCreate') ?></th>
            <td><?= $usermodulePermission->isCreate ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDelete') ?></th>
            <td><?= $usermodulePermission->isDelete ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsImport') ?></th>
            <td><?= $usermodulePermission->isImport ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsExport') ?></th>
            <td><?= $usermodulePermission->isExport ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
