<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyModule $companyModule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $companyModule->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $companyModule->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Company Modules'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="companyModules form large-9 medium-8 columns content">
    <?= $this->Form->create($companyModule) ?>
    <fieldset>
        <legend><?= __('Edit Company Module') ?></legend>
        <?php
            echo $this->Form->control('company_id');
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
