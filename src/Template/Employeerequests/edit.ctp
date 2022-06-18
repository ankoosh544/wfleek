<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employeerequest $employeerequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $employeerequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $employeerequest->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Employeerequests'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="employeerequests form large-9 medium-8 columns content">
    <?= $this->Form->create($employeerequest) ?>
    <fieldset>
        <legend><?= __('Edit Employeerequest') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('request_type');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
