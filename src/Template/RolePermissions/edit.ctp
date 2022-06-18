<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RolePermission $rolePermission
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rolePermission->designation_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rolePermission->designation_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Role Permissions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rolePermissions form large-9 medium-8 columns content">
    <?= $this->Form->create($rolePermission) ?>
    <fieldset>
        <legend><?= __('Edit Role Permission') ?></legend>
        <?php
            echo $this->Form->control('company_id');
            echo $this->Form->control('module_id', ['options' => $modules]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
