<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientInfo $clientInfo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Info'), ['action' => 'edit', $clientInfo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Info'), ['action' => 'delete', $clientInfo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientInfo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Info'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Info'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientInfo view large-9 medium-8 columns content">
    <h3><?= h($clientInfo->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($clientInfo->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($clientInfo->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($clientInfo->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientInfo->id) ?></td>
        </tr>
    </table>
</div>
