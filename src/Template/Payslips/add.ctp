<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip $payslip
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Payslips'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="payslips form large-9 medium-8 columns content">
    <?= $this->Form->create($payslip) ?>
    <fieldset>
        <legend><?= __('Add Payslip') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('company_id');
            echo $this->Form->control('month');
            echo $this->Form->control('year');
            echo $this->Form->control('payslip');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
