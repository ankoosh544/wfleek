<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projecttask $projecttask
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="projecttasks form large-9 medium-8 columns content">
    <?= $this->Form->create($projecttask) ?>
    <fieldset>
        <legend><?= __('Add Projecttask') ?></legend>
        <?php
            echo $this->Form->control('project_id');
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('expiration_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
