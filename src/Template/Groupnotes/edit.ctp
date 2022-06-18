<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupnote $groupnote
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $groupnote->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $groupnote->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groupnotes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupnotes form large-9 medium-8 columns content">
    <?= $this->Form->create($groupnote) ?>
    <fieldset>
        <legend><?= __('Edit Groupnote') ?></legend>
        <?php
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('user_id');
            echo $this->Form->control('post_data');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('last_update', ['empty' => true]);
            echo $this->Form->control('isShared');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
