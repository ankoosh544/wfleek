<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Favoritepost $favoritepost
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $favoritepost->post_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $favoritepost->post_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Favoriteposts'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="favoriteposts form large-9 medium-8 columns content">
    <?= $this->Form->create($favoritepost) ?>
    <fieldset>
        <legend><?= __('Edit Favoritepost') ?></legend>
        <?php
            echo $this->Form->control('user_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
