<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupposttagmember $groupposttagmember
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupposttagmember'), ['action' => 'edit', $groupposttagmember->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupposttagmember'), ['action' => 'delete', $groupposttagmember->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupposttagmember->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupposttagmembers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupposttagmember'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupposttagmembers view large-9 medium-8 columns content">
    <h3><?= h($groupposttagmember->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $groupposttagmember->has('group') ? $this->Html->link($groupposttagmember->group->name, ['controller' => 'Groups', 'action' => 'view', $groupposttagmember->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupposttagmember->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Id') ?></th>
            <td><?= $this->Number->format($groupposttagmember->post_id) ?></td>
        </tr>
    </table>
</div>
