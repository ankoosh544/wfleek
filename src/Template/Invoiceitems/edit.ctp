<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoiceitem $invoiceitem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoiceitem->itemId],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceitem->itemId)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Invoiceitems'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="invoiceitems form large-9 medium-8 columns content">
    <?= $this->Form->create($invoiceitem) ?>
    <fieldset>
        <legend><?= __('Edit Invoiceitem') ?></legend>
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
