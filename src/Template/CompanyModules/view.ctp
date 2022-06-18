<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyModule $companyModule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Company Module'), ['action' => 'edit', $companyModule->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Company Module'), ['action' => 'delete', $companyModule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyModule->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Company Modules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company Module'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companyModules view large-9 medium-8 columns content">
    <h3><?= h($companyModule->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($companyModule->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($companyModule->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($companyModule->company_id) ?></td>
        </tr>
    </table>
</div>
