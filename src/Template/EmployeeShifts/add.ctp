<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeShift $employeeShift
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Employee Shifts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="employeeShifts form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeShift) ?>
    <fieldset>
        <legend><?= __('Add Employee Shift') ?></legend>
        <?php
            echo $this->Form->control('company_id');
            echo $this->Form->control('name');
            echo $this->Form->control('start_time', ['empty' => true]);
            echo $this->Form->control('end_time', ['empty' => true]);
            echo $this->Form->control('isRepeated');
            echo $this->Form->control('days_to_repeat');
            echo $this->Form->control('endof_repeating_shift', ['empty' => true]);
            echo $this->Form->control('isIndefinite');
            echo $this->Form->control('note');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
