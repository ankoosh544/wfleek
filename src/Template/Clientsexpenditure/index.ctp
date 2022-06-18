<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clientsexpenditure[]|\Cake\Collection\CollectionInterface $clientsexpenditure
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Clientsexpenditure'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientsexpenditure index large-9 medium-8 columns content">
    <h3><?= __('Clientsexpenditure') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('typeof_transport') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transportation_file') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accomodation_hotel_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accomodation_file') ?></th>
                <th scope="col"><?= $this->Paginator->sort('restaurant_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('restaurant_file') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientsexpenditure as $clientsexpenditure): ?>
            <tr>
                <td><?= $this->Number->format($clientsexpenditure->id) ?></td>
                <td><?= $this->Number->format($clientsexpenditure->user_id) ?></td>
                <td><?= h($clientsexpenditure->typeof_transport) ?></td>
                <td><?= h($clientsexpenditure->transportation_file) ?></td>
                <td><?= h($clientsexpenditure->accomodation_hotel_name) ?></td>
                <td><?= h($clientsexpenditure->accomodation_file) ?></td>
                <td><?= h($clientsexpenditure->restaurant_name) ?></td>
                <td><?= h($clientsexpenditure->restaurant_file) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientsexpenditure->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientsexpenditure->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientsexpenditure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientsexpenditure->id)]) ?>
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
