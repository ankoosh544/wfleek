<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcomment $postcomment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Postcomments'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parent Postcomments'), ['controller' => 'Postcomments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Postcomment'), ['controller' => 'Postcomments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postcomments form large-9 medium-8 columns content">
    <?= $this->Form->create($postcomment) ?>
    <fieldset>
        <legend><?= __('Add Postcomment') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['options' => $parentPostcomments, 'empty' => true]);
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('post_id');
            echo $this->Form->control('user_id');
            echo $this->Form->control('comment_data');
            echo $this->Form->control('isDeleted');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
