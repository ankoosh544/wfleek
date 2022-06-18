<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouppost $grouppost
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $grouppost->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $grouppost->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groupposts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="groupposts form large-9 medium-8 columns content">
    <?= $this->Form->create($grouppost) ?>
    <fieldset>
        <legend><?= __('Edit Grouppost') ?></legend>
        <?php
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('user_id');
            echo $this->Form->control('post_data');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
