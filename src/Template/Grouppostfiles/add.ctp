<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouppostfile $grouppostfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Grouppostfiles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groupposts'), ['controller' => 'Groupposts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Grouppost'), ['controller' => 'Groupposts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grouppostfiles form large-9 medium-8 columns content">
    <?= $this->Form->create($grouppostfile) ?>
    <fieldset>
        <legend><?= __('Add Grouppostfile') ?></legend>
        <?php
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('grouppost_id', ['options' => $groupposts, 'empty' => true]);
            echo $this->Form->control('filepath');
            echo $this->Form->control('filename');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
