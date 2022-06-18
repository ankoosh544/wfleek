<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clientsexpenditure $clientsexpenditure
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Clientsexpenditure'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clientsexpenditure form large-9 medium-8 columns content">
    <?= $this->Form->create($clientsexpenditure) ?>
    <fieldset>
        <legend><?= __('Add Clientsexpenditure') ?></legend>
        <?php
            echo $this->Form->control('user_id');
            echo $this->Form->control('typeof_transport');
            echo $this->Form->control('transportation_file');
            echo $this->Form->control('accomodation_hotel_name');
            echo $this->Form->control('accomodation_file');
            echo $this->Form->control('restaurant_name');
            echo $this->Form->control('restaurant_file');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
