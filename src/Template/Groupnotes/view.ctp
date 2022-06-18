<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupnote $groupnote
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupnote'), ['action' => 'edit', $groupnote->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupnote'), ['action' => 'delete', $groupnote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupnote->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupnotes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupnote'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupnotes view large-9 medium-8 columns content">
    <h3><?= h($groupnote->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $groupnote->has('group') ? $this->Html->link($groupnote->group->name, ['controller' => 'Groups', 'action' => 'view', $groupnote->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupnote->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($groupnote->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($groupnote->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Update') ?></th>
            <td><?= h($groupnote->last_update) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsShared') ?></th>
            <td><?= $groupnote->isShared ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IsDeleted') ?></th>
            <td><?= $groupnote->isDeleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Post Data') ?></h4>
        <?= $this->Text->autoParagraph(h($groupnote->post_data)); ?>
    </div>
</div>
