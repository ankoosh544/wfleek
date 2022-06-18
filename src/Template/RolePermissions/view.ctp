<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RolePermission $rolePermission
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Role Permission'), ['action' => 'edit', $rolePermission->designation_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role Permission'), ['action' => 'delete', $rolePermission->designation_id], ['confirm' => __('Are you sure you want to delete # {0}?', $rolePermission->designation_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Role Permissions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role Permission'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rolePermissions view large-9 medium-8 columns content">
    <h3><?= h($rolePermission->designation_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Module') ?></th>
            <td><?= $rolePermission->has('module') ? $this->Html->link($rolePermission->module->name, ['controller' => 'Modules', 'action' => 'view', $rolePermission->module->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Designation Id') ?></th>
            <td><?= $this->Number->format($rolePermission->designation_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($rolePermission->company_id) ?></td>
        </tr>
    </table>
</div>
