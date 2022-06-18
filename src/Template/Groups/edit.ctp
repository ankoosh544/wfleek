<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $group->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $group->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Chatgroups'), ['controller' => 'Chatgroups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Chatgroup'), ['controller' => 'Chatgroups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Chatgroupsusers'), ['controller' => 'Chatgroupsusers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Chatgroupsuser'), ['controller' => 'Chatgroupsusers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groupchatfiles'), ['controller' => 'Groupchatfiles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Groupchatfile'), ['controller' => 'Groupchatfiles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groupchats'), ['controller' => 'Groupchats', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Groupchat'), ['controller' => 'Groupchats', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groups form large-9 medium-8 columns content">
    <?= $this->Form->create($group) ?>
    <fieldset>
        <legend><?= __('Edit Group') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('creation_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
