<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VersionsContract $versionsContract
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Versions Contract'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contracts'), ['controller' => 'Contracts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contract'), ['controller' => 'Contracts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="versionsContract form large-9 medium-8 columns content">
    <?= $this->Form->create($versionsContract) ?>
    <fieldset>
        <legend><?= __('Add Versions Contract') ?></legend>
        <?php
            echo $this->Form->control('project_object_id');
            echo $this->Form->control('contract_id', ['options' => $contracts]);
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('listof_members');
            echo $this->Form->control('content');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('acceptance_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
