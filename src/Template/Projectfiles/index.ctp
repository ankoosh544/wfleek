<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projectfile[]|\Cake\Collection\CollectionInterface $projectfiles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Projectfile'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectfiles index large-9 medium-8 columns content">
    <h3><?= __('Projectfiles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filename') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filepath') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectfiles as $projectfile): ?>
            <tr>
                <td><?= $this->Number->format($projectfile->id) ?></td>
                <td><?= $this->Number->format($projectfile->project_id) ?></td>
                <td><?= h($projectfile->filename) ?></td>
                <td><?= h($projectfile->filepath) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projectfile->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectfile->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projectfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectfile->id)]) ?>
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
