<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dailyattendencepdf[]|\Cake\Collection\CollectionInterface $dailyattendencepdfs
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Dailyattendencepdf'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dailyattendencepdfs index large-9 medium-8 columns content">
    <h3><?= __('Dailyattendencepdfs') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filepath') ?></th>
                <th scope="col"><?= $this->Paginator->sort('filename') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dailyattendencepdfs as $dailyattendencepdf): ?>
            <tr>
                <td><?= $this->Number->format($dailyattendencepdf->id) ?></td>
                <td><?= $this->Number->format($dailyattendencepdf->company_id) ?></td>
                <td><?= h($dailyattendencepdf->date) ?></td>
                <td><?= h($dailyattendencepdf->filepath) ?></td>
                <td><?= h($dailyattendencepdf->filename) ?></td>
                <td><?= h($dailyattendencepdf->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $dailyattendencepdf->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dailyattendencepdf->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dailyattendencepdf->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dailyattendencepdf->id)]) ?>
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
