<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatgroupsuser $chatgroupsuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Chatgroupsusers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chatgroupsusers form large-9 medium-8 columns content">
    <?= $this->Form->create($chatgroupsuser) ?>
    <fieldset>
        <legend><?= __('Add Chatgroupsuser') ?></legend>
        <?php
            echo $this->Form->control('group_id');
            echo $this->Form->control('user_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
