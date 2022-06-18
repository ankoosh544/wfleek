<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payslip $payslip
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payslip'), ['action' => 'edit', $payslip->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payslip'), ['action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payslips'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payslip'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payslips view large-9 medium-8 columns content">
    <h3><?= h($payslip->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Month') ?></th>
            <td><?= h($payslip->month) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Payslip') ?></th>
            <td><?= h($payslip->payslip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($payslip->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($payslip->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($payslip->company_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Year') ?></th>
            <td><?= $this->Number->format($payslip->year) ?></td>
        </tr>
    </table>
</div>
