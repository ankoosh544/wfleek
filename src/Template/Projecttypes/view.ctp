<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projecttype $projecttype
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Projecttype'), ['action' => 'edit', $projecttype->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Projecttype'), ['action' => 'delete', $projecttype->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projecttype->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Projecttypes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Projecttype'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projecttypes view large-9 medium-8 columns content">
    <h3><?= h($projecttype->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($projecttype->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projecttype->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Number') ?></th>
            <td><?= $this->Number->format($projecttype->order_number) ?></td>
        </tr>
    </table>
</div>
