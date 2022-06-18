<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Taskgroup $taskgroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $taskgroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $taskgroup->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Taskgroups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['controller' => 'Projecttasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Projecttask'), ['controller' => 'Projecttasks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="taskgroups form large-9 medium-8 columns content">
    <?= $this->Form->create($taskgroup) ?>
    <fieldset>
        <legend><?= __('Edit Taskgroup') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('price');
            echo $this->Form->control('tax_percentage');
            echo $this->Form->control('last_update', ['empty' => true]);
            echo $this->Form->control('creation_date', ['empty' => true]);
            echo $this->Form->control('projecttasks._ids', ['options' => $projecttasks]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
