<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Workinghour $workinghour
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Workinghour'), ['action' => 'edit', $workinghour->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Workinghour'), ['action' => 'delete', $workinghour->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workinghour->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Workinghours'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Workinghour'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="workinghours view large-9 medium-8 columns content">
    <h3><?= h($workinghour->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($workinghour->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($workinghour->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($workinghour->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($workinghour->end_time) ?></td>
        </tr>
    </table>
</div>
