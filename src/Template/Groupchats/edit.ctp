<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupchat $groupchat
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $groupchat->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $groupchat->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groupchats'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Chatgroups'), ['controller' => 'Chatgroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Chatgroup'), ['controller' => 'Chatgroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'User', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groupchatfiles'), ['controller' => 'Groupchatfiles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Groupchatfile'), ['controller' => 'Groupchatfiles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Replies'), ['controller' => 'Groupchats', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reply'), ['controller' => 'Groupchats', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupchats form large-9 medium-8 columns content">
    <?= $this->Form->create($groupchat) ?>
    <fieldset>
        <legend><?= __('Edit Groupchat') ?></legend>
        <?php
            echo $this->Form->control('parentgroupchat_id');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('group_id', ['options' => $chatgroups]);
            echo $this->Form->control('content');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('last_update', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
