<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoiceitem $invoiceitem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Invoiceitems'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="invoiceitems form large-9 medium-8 columns content">
    <?= $this->Form->create($invoiceitem) ?>
    <fieldset>
        <legend><?= __('Add Invoiceitem') ?></legend>
        <?php
            echo $this->Form->control('invoiceId');
            echo $this->Form->control('description');
            echo $this->Form->control('quantity');
            echo $this->Form->control('price');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
