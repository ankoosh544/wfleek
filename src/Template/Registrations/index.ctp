<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration[]|\Cake\Collection\CollectionInterface $registrations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Registration'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="registrations index large-9 medium-8 columns content">
    <h3><?= __('Registrations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('email_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gender') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firstname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_of_birth') ?></th>
                <th scope="col"><?= $this->Paginator->sort('validation_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('validation_expirydate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creation_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?= h($registration->email_id) ?></td>
                <td><?= h($registration->title) ?></td>
                <td><?= h($registration->gender) ?></td>
                <td><?= h($registration->firstname) ?></td>
                <td><?= h($registration->lastname) ?></td>
                <td><?= h($registration->password) ?></td>
                <td><?= h($registration->date_of_birth) ?></td>
                <td><?= h($registration->validation_code) ?></td>
                <td><?= h($registration->validation_expirydate) ?></td>
                <td><?= h($registration->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $registration->email_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registration->email_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registration->email_id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->email_id)]) ?>
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
