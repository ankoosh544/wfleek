<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employeesdailyworkflow $employeesdailyworkflow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Employeesdailyworkflow'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeesdailyworkflow form large-9 medium-8 columns content">
    <?= $this->Form->create($employeesdailyworkflow) ?>
    <fieldset>
        <legend><?= __('Add Employeesdailyworkflow') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $user]);
            echo $this->Form->control('status');
            echo $this->Form->control('fromdate', ['empty' => true]);
            echo $this->Form->control('todate', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
