<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projecttask[]|\Cake\Collection\CollectionInterface $projecttasks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Projecttask'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projecttasks index large-9 medium-8 columns content">
    <h3><?= __('Projecttasks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expiration_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projecttasks as $projecttask): ?>
            <tr>
                <td><?= $this->Number->format($projecttask->id) ?></td>
                <td><?= $this->Number->format($projecttask->project_id) ?></td>
                <td><?= h($projecttask->title) ?></td>
                <td><?= h($projecttask->expiration_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projecttask->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projecttask->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projecttask->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projecttask->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
