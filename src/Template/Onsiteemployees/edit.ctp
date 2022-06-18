<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Onsiteemployee $onsiteemployee
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $onsiteemployee->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $onsiteemployee->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Onsiteemployees'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="onsiteemployees form large-9 medium-8 columns content">
    <?= $this->Form->create($onsiteemployee) ?>
    <fieldset>
        <legend><?= __('Edit Onsiteemployee') ?></legend>
        <?php
            echo $this->Form->control('client_id');
            echo $this->Form->control('projectId');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('isDeleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
