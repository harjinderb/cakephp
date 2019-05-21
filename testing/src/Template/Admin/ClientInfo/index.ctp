<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\ClientInfo[]|\Cake\Collection\CollectionInterface $clientInfo
*/
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2 class="text-uppercase"><i class="fa fa-user"> </i> BSO Listing</h2>
        </div>
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card data-table-outer">
                    
                    <div class="body">
                        <nav class="large-3 medium-4 columns" id="actions-sidebar">
                            <ul class="side-nav">
                                <li class="heading"><?= __('Actions') ?></li>
                                <li><?= $this->Html->link(__('New Client Info'), ['action' => 'add']) ?></li>
                            </ul>
                        </nav>
                        <div class="clientInfo index large-9 medium-8 columns content">
                            <h3><?= __('Client Info') ?></h3>
                            <table cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clientInfo as $clientInfo): ?>
                                    <tr>
                                        <td><?= $this->Number->format($clientInfo->id) ?></td>
                                        <td><?= h($clientInfo->name) ?></td>
                                        <td><?= h($clientInfo->email) ?></td>
                                        <td><?= h($clientInfo->password) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('View'), ['action' => 'view', $clientInfo->id]) ?>
                                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientInfo->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientInfo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientInfo->id)]) ?>
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
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
    </div>
</section>