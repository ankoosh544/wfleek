<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractline $contractline
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contractlines'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contracts'), ['controller' => 'Contracts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contract'), ['controller' => 'Contracts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractlines form large-9 medium-8 columns content">
    <?= $this->Form->create($contractline) ?>
    <fieldset>
        <legend><?= __('Add Contractline') ?></legend>
        <?php
            echo $this->Form->control('contract_id', ['options' => $contracts, 'empty' => true]);
            echo $this->Form->control('grouptitle');
            echo $this->Form->control('tasktitle');
            echo $this->Form->control('description_task');
            echo $this->Form->control('price');
            echo $this->Form->control('tax_percentage');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
