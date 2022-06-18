<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dailyattendencepdf $dailyattendencepdf
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Dailyattendencepdfs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="dailyattendencepdfs form large-9 medium-8 columns content">
    <?= $this->Form->create($dailyattendencepdf) ?>
    <fieldset>
        <legend><?= __('Add Dailyattendencepdf') ?></legend>
        <?php
            echo $this->Form->control('company_id');
            echo $this->Form->control('date', ['empty' => true]);
            echo $this->Form->control('filepath');
            echo $this->Form->control('filename');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
