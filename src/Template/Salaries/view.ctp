<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary $salary
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Salary'), ['action' => 'edit', $salary->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Salary'), ['action' => 'delete', $salary->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salary->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Salaries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Salary'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="salaries view large-9 medium-8 columns content">
    <h3><?= h($salary->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($salary->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($salary->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($salary->company_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Net Salary') ?></th>
            <td><?= $this->Number->format($salary->net_salary) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tds') ?></th>
            <td><?= $this->Number->format($salary->tds) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Da') ?></th>
            <td><?= $this->Number->format($salary->da) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Esi') ?></th>
            <td><?= $this->Number->format($salary->esi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hra') ?></th>
            <td><?= $this->Number->format($salary->hra) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pf') ?></th>
            <td><?= $this->Number->format($salary->pf) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax') ?></th>
            <td><?= $this->Number->format($salary->tax) ?></td>
        </tr>
    </table>
</div>
