<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Workinghour $workinghour
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $workinghour->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $workinghour->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Workinghours'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="workinghours form large-9 medium-8 columns content">
    <?= $this->Form->create($workinghour) ?>
    <fieldset>
        <legend><?= __('Edit Workinghour') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('start_time', ['empty' => true]);
            echo $this->Form->control('end_time', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
