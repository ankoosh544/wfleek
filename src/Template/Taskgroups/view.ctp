<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Taskgroup $taskgroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Taskgroup'), ['action' => 'edit', $taskgroup->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Taskgroup'), ['action' => 'delete', $taskgroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $taskgroup->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Taskgroups'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Taskgroup'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projecttasks'), ['controller' => 'Projecttasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Projecttask'), ['controller' => 'Projecttasks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="taskgroups view large-9 medium-8 columns content">
    <h3><?= h($taskgroup->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($taskgroup->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($taskgroup->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($taskgroup->price) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Percentage') ?></th>
            <td><?= $this->Number->format($taskgroup->tax_percentage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Update') ?></th>
            <td><?= h($taskgroup->last_update) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($taskgroup->creation_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($taskgroup->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Projecttasks') ?></h4>
        <?php if (!empty($taskgroup->projecttasks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Project Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('IsDeleted') ?></th>
                <th scope="col"><?= __('Expiration Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($taskgroup->projecttasks as $projecttasks): ?>
            <tr>
                <td><?= h($projecttasks->id) ?></td>
                <td><?= h($projecttasks->project_id) ?></td>
                <td><?= h($projecttasks->title) ?></td>
                <td><?= h($projecttasks->description) ?></td>
                <td><?= h($projecttasks->status) ?></td>
                <td><?= h($projecttasks->isDeleted) ?></td>
                <td><?= h($projecttasks->expiration_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Projecttasks', 'action' => 'view', $projecttasks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Projecttasks', 'action' => 'edit', $projecttasks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projecttasks', 'action' => 'delete', $projecttasks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projecttasks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
