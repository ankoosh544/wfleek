<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Postlike $postlike
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Postlikes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="postlikes form large-9 medium-8 columns content">
    <?= $this->Form->create($postlike) ?>
    <fieldset>
        <legend><?= __('Add Postlike') ?></legend>
        <?php
            echo $this->Form->control('post_id');
            echo $this->Form->control('user_id');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
