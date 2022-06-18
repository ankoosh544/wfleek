<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projectfile $projectfile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Projectfile'), ['action' => 'edit', $projectfile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Projectfile'), ['action' => 'delete', $projectfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectfile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Projectfiles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Projectfile'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projectfiles view large-9 medium-8 columns content">
    <h3><?= h($projectfile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($projectfile->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filepath') ?></th>
            <td><?= h($projectfile->filepath) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectfile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Project Id') ?></th>
            <td><?= $this->Number->format($projectfile->project_id) ?></td>
        </tr>
    </table>
</div>
