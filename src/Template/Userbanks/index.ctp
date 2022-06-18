<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Userbank[]|\Cake\Collection\CollectionInterface $userbanks
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Userbank'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="userbanks index large-9 medium-8 columns content">
    <h3><?= __('Userbanks') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bank_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('iban') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state_bankbranch') ?></th>
                <th scope="col"><?= $this->Paginator->sort('city_bankbranch') ?></th>
                <th scope="col"><?= $this->Paginator->sort('province_bankbranch') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isDeleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userbanks as $userbank): ?>
            <tr>
                <td><?= $this->Number->format($userbank->id) ?></td>
                <td><?= h($userbank->bank_name) ?></td>
                <td><?= h($userbank->iban) ?></td>
                <td><?= h($userbank->state_bankbranch) ?></td>
                <td><?= h($userbank->city_bankbranch) ?></td>
                <td><?= h($userbank->province_bankbranch) ?></td>
                <td><?= h($userbank->isDeleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $userbank->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $userbank->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $userbank->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userbank->id)]) ?>
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
