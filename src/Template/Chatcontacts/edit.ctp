<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatcontact $chatcontact
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $chatcontact->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $chatcontact->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Chatcontacts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="chatcontacts form large-9 medium-8 columns content">
    <?= $this->Form->create($chatcontact) ?>
    <fieldset>
        <legend><?= __('Edit Chatcontact') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('creation_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
