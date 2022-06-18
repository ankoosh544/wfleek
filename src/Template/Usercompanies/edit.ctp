<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Usercompany $usercompany
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $usercompany->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $usercompany->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Usercompanies'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="usercompanies form large-9 medium-8 columns content">
    <?= $this->Form->create($usercompany) ?>
    <fieldset>
        <legend><?= __('Edit Usercompany') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('name');
            echo $this->Form->control('address');
            echo $this->Form->control('country');
            echo $this->Form->control('city');
            echo $this->Form->control('state');
            echo $this->Form->control('postal_code');
            echo $this->Form->control('email');
            echo $this->Form->control('phone_number');
            echo $this->Form->control('mobile_number');
            echo $this->Form->control('website');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
