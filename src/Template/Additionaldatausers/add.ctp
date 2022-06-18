<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Additionaldatauser $additionaldatauser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Additionaldatausers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="additionaldatausers form large-9 medium-8 columns content">
    <?= $this->Form->create($additionaldatauser) ?>
    <fieldset>
        <legend><?= __('Add Additionaldatauser') ?></legend>
        <?php
            echo $this->Form->control('company_id');
            echo $this->Form->control('member_role');
            echo $this->Form->control('vat_code');
            echo $this->Form->control('tax_code');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
