<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projecttype $projecttype
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $projecttype->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projecttype->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Projecttypes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="projecttypes form large-9 medium-8 columns content">
    <?= $this->Form->create($projecttype) ?>
    <fieldset>
        <legend><?= __('Edit Projecttype') ?></legend>
        <?php
            echo $this->Form->control('order_number');
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
