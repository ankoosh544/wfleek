<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Setting'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Usercompanies'), ['controller' => 'Usercompanies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usercompany'), ['controller' => 'Usercompanies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="settings view large-9 medium-8 columns content">
    <h3><?= h($setting->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $setting->has('user') ? $this->Html->link($setting->user->id, ['controller' => 'User', 'action' => 'view', $setting->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usercompany') ?></th>
            <td><?= $setting->has('usercompany') ? $this->Html->link($setting->usercompany->name, ['controller' => 'Usercompanies', 'action' => 'view', $setting->usercompany->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($setting->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Two Factor Authentication') ?></th>
            <td><?= $setting->two_factor_authentication ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
