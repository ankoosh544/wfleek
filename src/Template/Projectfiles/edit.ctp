<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projectfile $projectfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $projectfile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectfile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Projectfiles'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="projectfiles form large-9 medium-8 columns content">
    <?= $this->Form->create($projectfile) ?>
    <fieldset>
        <legend><?= __('Edit Projectfile') ?></legend>
        <?php
            echo $this->Form->control('project_id');
            echo $this->Form->control('filename');
            echo $this->Form->control('filepath');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
