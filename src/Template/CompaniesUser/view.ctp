<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Companiesuser $companiesuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Companiesuser'), ['action' => 'edit', $companiesuser->company_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Companiesuser'), ['action' => 'delete', $companiesuser->company_id], ['confirm' => __('Are you sure you want to delete # {0}?', $companiesuser->company_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Companiesuser'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Companiesuser'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Usercompanies'), ['controller' => 'Usercompanies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Usercompany'), ['controller' => 'Usercompanies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companiesuser view large-9 medium-8 columns content">
    <h3><?= h($companiesuser->company_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Usercompany') ?></th>
            <td><?= $companiesuser->has('usercompany') ? $this->Html->link($companiesuser->usercompany->name, ['controller' => 'Usercompanies', 'action' => 'view', $companiesuser->usercompany->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $companiesuser->has('user') ? $this->Html->link($companiesuser->user->id, ['controller' => 'User', 'action' => 'view', $companiesuser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Member Role') ?></th>
            <td><?= h($companiesuser->member_role) ?></td>
        </tr>
    </table>
</div>
