<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShiftSchedule $shiftSchedule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shiftSchedule->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shiftSchedule->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shift Schedules'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Departments'), ['controller' => 'Departments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Department'), ['controller' => 'Departments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shiftSchedules form large-9 medium-8 columns content">
    <?= $this->Form->create($shiftSchedule) ?>
    <fieldset>
        <legend><?= __('Edit Shift Schedule') ?></legend>
        <?php
            echo $this->Form->control('department_id', ['options' => $departments, 'empty' => true]);
            echo $this->Form->control('user_id');
            echo $this->Form->control('shift_id');
            echo $this->Form->control('shift_date', ['empty' => true]);
            echo $this->Form->control('isAcceptExtrahrs');
            echo $this->Form->control('isPublish');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
