<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dailyattendencepdf $dailyattendencepdf
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Dailyattendencepdf'), ['action' => 'edit', $dailyattendencepdf->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Dailyattendencepdf'), ['action' => 'delete', $dailyattendencepdf->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dailyattendencepdf->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Dailyattendencepdfs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dailyattendencepdf'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="dailyattendencepdfs view large-9 medium-8 columns content">
    <h3><?= h($dailyattendencepdf->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Filepath') ?></th>
            <td><?= h($dailyattendencepdf->filepath) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($dailyattendencepdf->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($dailyattendencepdf->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company Id') ?></th>
            <td><?= $this->Number->format($dailyattendencepdf->company_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($dailyattendencepdf->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($dailyattendencepdf->creation_date) ?></td>
        </tr>
    </table>
</div>
