<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EpictasksProjecttask $epictasksProjecttask
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Epictasks Projecttask'), ['action' => 'edit', $epictasksProjecttask->epictask_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Epictasks Projecttask'), ['action' => 'delete', $epictasksProjecttask->epictask_id], ['confirm' => __('Are you sure you want to delete # {0}?', $epictasksProjecttask->epictask_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Epictasks Projecttasks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Epictasks Projecttask'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['controller' => 'Projecttasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Projecttask'), ['controller' => 'Projecttasks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="epictasksProjecttasks view large-9 medium-8 columns content">
    <h3><?= h($epictasksProjecttask->epictask_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Projecttask') ?></th>
            <td><?= $epictasksProjecttask->has('projecttask') ? $this->Html->link($epictasksProjecttask->projecttask->title, ['controller' => 'Projecttasks', 'action' => 'view', $epictasksProjecttask->projecttask->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Epictask Id') ?></th>
            <td><?= $this->Number->format($epictasksProjecttask->epictask_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ProjectId') ?></th>
            <td><?= $this->Number->format($epictasksProjecttask->projectId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $epictasksProjecttask->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
