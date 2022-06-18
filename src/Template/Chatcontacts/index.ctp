<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Chatcontact[]|\Cake\Collection\CollectionInterface $chatcontacts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Chatcontact'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="chatcontacts index large-9 medium-8 columns content">
    <h3><?= __('Chatcontacts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chatcontacts as $chatcontact): ?>
            <tr>
                <td><?= $this->Number->format($chatcontact->id) ?></td>
                <td><?= $this->Number->format($chatcontact->user_id) ?></td>
                <td><?= h($chatcontact->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $chatcontact->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $chatcontact->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $chatcontact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $chatcontact->id)]) ?>
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
