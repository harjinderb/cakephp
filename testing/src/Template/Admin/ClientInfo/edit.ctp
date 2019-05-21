<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\ClientInfo $clientInfo
*/
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $clientInfo->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $clientInfo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Info'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="clientInfo form large-9 medium-8 columns content">
    <?= $this->Form->create($clientInfo) ?>
    <fieldset>
        <legend><?= __('Edit Client Info') ?></legend>
        <?php
        echo $this->Form->control('name');
        echo $this->Form->control('email');
        echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>