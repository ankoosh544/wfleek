<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupposttagmember $groupposttagmember
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $groupposttagmember->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $groupposttagmember->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groupposttagmembers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupposttagmembers form large-9 medium-8 columns content">
    <?= $this->Form->create($groupposttagmember) ?>
    <fieldset>
        <legend><?= __('Edit Groupposttagmember') ?></legend>
        <?php
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('post_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
