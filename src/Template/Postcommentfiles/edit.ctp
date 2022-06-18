<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postcommentfile $postcommentfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $postcommentfile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $postcommentfile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Postcommentfiles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="postcommentfiles form large-9 medium-8 columns content">
    <?= $this->Form->create($postcommentfile) ?>
    <fieldset>
        <legend><?= __('Edit Postcommentfile') ?></legend>
        <?php
            echo $this->Form->control('post_id');
            echo $this->Form->control('comment_id', ['options' => $comments, 'empty' => true]);
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('user_id');
            echo $this->Form->control('filepath');
            echo $this->Form->control('filename');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
