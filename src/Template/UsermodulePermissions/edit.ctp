<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsermodulePermission $usermodulePermission
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $usermodulePermission->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usermodulePermission->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Usermodule Permissions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Designations'), ['controller' => 'Designations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Designation'), ['controller' => 'Designations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usermodulePermissions form large-9 medium-8 columns content">
    <?= $this->Form->create($usermodulePermission) ?>
    <fieldset>
        <legend><?= __('Edit Usermodule Permission') ?></legend>
        <?php
            echo $this->Form->control('designation_id', ['options' => $designations]);
            echo $this->Form->control('module_id');
            echo $this->Form->control('isAccessed');
            echo $this->Form->control('isRead');
            echo $this->Form->control('isWrite');
            echo $this->Form->control('isCreate');
            echo $this->Form->control('isDelete');
            echo $this->Form->control('isImport');
            echo $this->Form->control('isExport');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
