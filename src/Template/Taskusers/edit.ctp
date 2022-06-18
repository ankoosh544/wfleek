<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Taskuser $taskuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $taskuser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $taskuser->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Taskusers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="taskusers form large-9 medium-8 columns content">
    <?= $this->Form->create($taskuser) ?>
    <fieldset>
        <legend><?= __('Edit Taskuser') ?></legend>
        <?php
            echo $this->Form->control('taskId');
            echo $this->Form->control('assignee_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
