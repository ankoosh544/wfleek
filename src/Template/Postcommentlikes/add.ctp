<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcommentlike $postcommentlike
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Postcommentlikes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postcommentlikes form large-9 medium-8 columns content">
    <?= $this->Form->create($postcommentlike) ?>
    <fieldset>
        <legend><?= __('Add Postcommentlike') ?></legend>
        <?php
            echo $this->Form->control('comment_id', ['options' => $comments, 'empty' => true]);
            echo $this->Form->control('reply_id');
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('user_id');
            echo $this->Form->control('isLiked');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
