<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projectemail $projectemail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $projectemail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectemail->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Projectemail'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="projectemail form large-9 medium-8 columns content">
    <?= $this->Form->create($projectemail) ?>
    <fieldset>
        <legend><?= __('Edit Projectemail') ?></legend>
        <?php
            echo $this->Form->control('fromuser');
            echo $this->Form->control('touser');
            echo $this->Form->control('subject');
            echo $this->Form->control('body');
            echo $this->Form->control('bcc');
            echo $this->Form->control('cc');
            echo $this->Form->control('creation_date');
            echo $this->Form->control('send_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
