<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clientsexpenditure $clientsexpenditure
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Clientsexpenditure'), ['action' => 'edit', $clientsexpenditure->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clientsexpenditure'), ['action' => 'delete', $clientsexpenditure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientsexpenditure->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Clientsexpenditure'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clientsexpenditure'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientsexpenditure view large-9 medium-8 columns content">
    <h3><?= h($clientsexpenditure->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Typeof Transport') ?></th>
            <td><?= h($clientsexpenditure->typeof_transport) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transportation File') ?></th>
            <td><?= h($clientsexpenditure->transportation_file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accomodation Hotel Name') ?></th>
            <td><?= h($clientsexpenditure->accomodation_hotel_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accomodation File') ?></th>
            <td><?= h($clientsexpenditure->accomodation_file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Restaurant Name') ?></th>
            <td><?= h($clientsexpenditure->restaurant_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Restaurant File') ?></th>
            <td><?= h($clientsexpenditure->restaurant_file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientsexpenditure->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($clientsexpenditure->user_id) ?></td>
        </tr>
    </table>
</div>
