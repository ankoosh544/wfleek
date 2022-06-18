<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EpictasksProjecttask $epictasksProjecttask
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Epictasks Projecttasks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['controller' => 'Projecttasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Projecttask'), ['controller' => 'Projecttasks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="epictasksProjecttasks form large-9 medium-8 columns content">
    <?= $this->Form->create($epictasksProjecttask) ?>
    <fieldset>
        <legend><?= __('Add Epictasks Projecttask') ?></legend>
        <?php
            echo $this->Form->control('projectId');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
