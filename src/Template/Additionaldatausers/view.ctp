<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Additionaldatauser $additionaldatauser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Additionaldatauser'), ['action' => 'edit', $additionaldatauser->user_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Additionaldatauser'), ['action' => 'delete', $additionaldatauser->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $additionaldatauser->user_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Additionaldatausers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Additionaldatauser'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="additionaldatausers view large-9 medium-8 columns content">
    <h3><?= h($additionaldatauser->user_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Member Role') ?></th>
            <td><?= h($additionaldatauser->member_role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vat Code') ?></th>
            <td><?= h($additionaldatauser->vat_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Code') ?></th>
            <td><?= h($additionaldatauser->tax_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($additionaldatauser->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($additionaldatauser->company_id) ?></td>
        </tr>
    </table>
</div>
