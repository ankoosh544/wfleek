<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Groupchat $groupchat
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupchat'), ['action' => 'edit', $groupchat->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupchat'), ['action' => 'delete', $groupchat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupchat->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupchats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupchat'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Chatgroups'), ['controller' => 'Chatgroups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Chatgroup'), ['controller' => 'Chatgroups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'User', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'User', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groupchatfiles'), ['controller' => 'Groupchatfiles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupchatfile'), ['controller' => 'Groupchatfiles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Replies'), ['controller' => 'Groupchats', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reply'), ['controller' => 'Groupchats', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupchats view large-9 medium-8 columns content">
    <h3><?= h($groupchat->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $groupchat->has('user') ? $this->Html->link($groupchat->user->id, ['controller' => 'User', 'action' => 'view', $groupchat->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Chatgroup') ?></th>
            <td><?= $groupchat->has('chatgroup') ? $this->Html->link($groupchat->chatgroup->name, ['controller' => 'Chatgroups', 'action' => 'view', $groupchat->chatgroup->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Content') ?></th>
            <td><?= h($groupchat->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupchat->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parentgroupchat Id') ?></th>
            <td><?= $this->Number->format($groupchat->parentgroupchat_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creation Date') ?></th>
            <td><?= h($groupchat->creation_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Update') ?></th>
            <td><?= h($groupchat->last_update) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Groupchatfiles') ?></h4>
        <?php if (!empty($groupchat->groupchatfiles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Group Id') ?></th>
                <th scope="col"><?= __('Groupchat Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Filename') ?></th>
                <th scope="col"><?= __('Filepath') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('IsDeleted') ?></th>
                <th scope="col"><?= __('Creation Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($groupchat->groupchatfiles as $groupchatfiles): ?>
            <tr>
                <td><?= h($groupchatfiles->id) ?></td>
                <td><?= h($groupchatfiles->group_id) ?></td>
                <td><?= h($groupchatfiles->groupchat_id) ?></td>
                <td><?= h($groupchatfiles->user_id) ?></td>
                <td><?= h($groupchatfiles->filename) ?></td>
                <td><?= h($groupchatfiles->filepath) ?></td>
                <td><?= h($groupchatfiles->type) ?></td>
                <td><?= h($groupchatfiles->size) ?></td>
                <td><?= h($groupchatfiles->isDeleted) ?></td>
                <td><?= h($groupchatfiles->creation_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Groupchatfiles', 'action' => 'view', $groupchatfiles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Groupchatfiles', 'action' => 'edit', $groupchatfiles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Groupchatfiles', 'action' => 'delete', $groupchatfiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupchatfiles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Groupchats') ?></h4>
        <?php if (!empty($groupchat->replies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Parentgroupchat Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Group Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Creation Date') ?></th>
                <th scope="col"><?= __('Last Update') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($groupchat->replies as $replies): ?>
            <tr>
                <td><?= h($replies->id) ?></td>
                <td><?= h($replies->parentgroupchat_id) ?></td>
                <td><?= h($replies->user_id) ?></td>
                <td><?= h($replies->group_id) ?></td>
                <td><?= h($replies->content) ?></td>
                <td><?= h($replies->creation_date) ?></td>
                <td><?= h($replies->last_update) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Groupchats', 'action' => 'view', $replies->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Groupchats', 'action' => 'edit', $replies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Groupchats', 'action' => 'delete', $replies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $replies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
