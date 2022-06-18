<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupfile $groupfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $groupfile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $groupfile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groupfiles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupfiles form large-9 medium-8 columns content">
    <?= $this->Form->create($groupfile) ?>
    <fieldset>
        <legend><?= __('Edit Groupfile') ?></legend>
        <?php
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('company_id');
            echo $this->Form->control('user_id');
            echo $this->Form->control('filename');
            echo $this->Form->control('filepath');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
