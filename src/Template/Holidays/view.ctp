<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Holiday $holiday
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Holiday'), ['action' => 'edit', $holiday->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Holiday'), ['action' => 'delete', $holiday->id], ['confirm' => __('Are you sure you want to delete # {0}?', $holiday->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Holidays'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Holiday'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="holidays view large-9 medium-8 columns content">
    <h3><?= h($holiday->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Holiday Name') ?></th>
            <td><?= h($holiday->holiday_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($holiday->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Holiday Date') ?></th>
            <td><?= h($holiday->holiday_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($holiday->creation_date) ?></td>
        </tr>
    </table>
</div>
