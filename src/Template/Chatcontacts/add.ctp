<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatcontact $chatcontact
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Chatcontacts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chatcontacts form large-9 medium-8 columns content">
    <?= $this->Form->create($chatcontact) ?>
    <fieldset>
        <legend><?= __('Add Chatcontact') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
