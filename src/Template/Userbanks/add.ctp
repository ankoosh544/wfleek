<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userbank $userbank
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Userbanks'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="userbanks form large-9 medium-8 columns content">
    <?= $this->Form->create($userbank) ?>
    <fieldset>
        <legend><?= __('Add Userbank') ?></legend>
        <?php
            echo $this->Form->control('bank_name');
            echo $this->Form->control('iban');
            echo $this->Form->control('state_bankbranch');
            echo $this->Form->control('city_bankbranch');
            echo $this->Form->control('province_bankbranch');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
