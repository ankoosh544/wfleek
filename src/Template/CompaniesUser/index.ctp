<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Companiesuser[]|\Cake\Collection\CollectionInterface $companiesuser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Companiesuser'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Usercompanies'), ['controller' => 'Usercompanies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Usercompany'), ['controller' => 'Usercompanies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User'), ['controller' => 'User', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="companiesuser index large-9 medium-8 columns content">
    <h3><?= __('Companiesuser') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('company_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('member_role') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($companiesuser as $companiesuser): ?>
            <tr>
                <td><?= $companiesuser->has('usercompany') ? $this->Html->link($companiesuser->usercompany->name, ['controller' => 'Usercompanies', 'action' => 'view', $companiesuser->usercompany->id]) : '' ?></td>
                <td><?= $companiesuser->has('user') ? $this->Html->link($companiesuser->user->id, ['controller' => 'User', 'action' => 'view', $companiesuser->user->id]) : '' ?></td>
                <td><?= h($companiesuser->member_role) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $companiesuser->company_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $companiesuser->company_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $companiesuser->company_id], ['confirm' => __('Are you sure you want to delete # {0}?', $companiesuser->company_id)]) ?>
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
