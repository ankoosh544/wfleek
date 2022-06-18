<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatgroup $chatgroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $chatgroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chatgroup->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Chatgroups'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chatgroups form large-9 medium-8 columns content">
    <?= $this->Form->create($chatgroup) ?>
    <fieldset>
        <legend><?= __('Edit Chatgroup') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('creator');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
