<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userbank $userbank
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Userbank'), ['action' => 'edit', $userbank->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Userbank'), ['action' => 'delete', $userbank->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userbank->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Userbanks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Userbank'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="userbanks view large-9 medium-8 columns content">
    <h3><?= h($userbank->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Bank Name') ?></th>
            <td><?= h($userbank->bank_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iban') ?></th>
            <td><?= h($userbank->iban) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State Bankbranch') ?></th>
            <td><?= h($userbank->state_bankbranch) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City Bankbranch') ?></th>
            <td><?= h($userbank->city_bankbranch) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Province Bankbranch') ?></th>
            <td><?= h($userbank->province_bankbranch) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($userbank->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $userbank->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
