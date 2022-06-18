<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary $salary
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Salaries'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="salaries form large-9 medium-8 columns content">
    <?= $this->Form->create($salary) ?>
    <fieldset>
        <legend><?= __('Add Salary') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('company_id');
            echo $this->Form->control('net_salary');
            echo $this->Form->control('tds');
            echo $this->Form->control('da');
            echo $this->Form->control('esi');
            echo $this->Form->control('hra');
            echo $this->Form->control('pf');
            echo $this->Form->control('tax');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
