<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Companiesuser $companiesuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Companiesuser'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Usercompanies'), ['controller' => 'Usercompanies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Usercompany'), ['controller' => 'Usercompanies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="companiesuser form large-9 medium-8 columns content">
    <?= $this->Form->create($companiesuser) ?>
    <fieldset>
        <legend><?= __('Add Companiesuser') ?></legend>
        <?php
            echo $this->Form->control('member_role');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
