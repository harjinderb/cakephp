<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee[]|\Cake\Collection\CollectionInterface $employees
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employees index large-9 medium-8 columns content">
    <h3><?= __('Employees') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('firstname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('residence') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mobile_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('password') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('flag') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bso_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lastname') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gender') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dob') ?></th>
                <th scope="col"><?= $this->Paginator->sort('joining_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bsn_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uuid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bank_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('account') ?></th>
                <th scope="col"><?= $this->Paginator->sort('relation') ?></th>
                <th scope="col"><?= $this->Paginator->sort('school') ?></th>
                <th scope="col"><?= $this->Paginator->sort('workstart_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('workend_date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= $this->Number->format($employee->id) ?></td>
                <td><?= h($employee->firstname) ?></td>
                <td><?= h($employee->email) ?></td>
                <td><?= h($employee->address) ?></td>
                <td><?= h($employee->residence) ?></td>
                <td><?= h($employee->image) ?></td>
                <td><?= h($employee->mobile_no) ?></td>
                <td><?= h($employee->post_code) ?></td>
                <td><?= $this->Number->format($employee->is_active) ?></td>
                <td><?= h($employee->password) ?></td>
                <td><?= $employee->has('role') ? $this->Html->link($employee->role->name, ['controller' => 'Roles', 'action' => 'view', $employee->role->id]) : '' ?></td>
                <td><?= h($employee->created) ?></td>
                <td><?= h($employee->modified) ?></td>
                <td><?= $this->Number->format($employee->flag) ?></td>
                <td><?= $this->Number->format($employee->bso_id) ?></td>
                <td><?= $employee->has('parent_employee') ? $this->Html->link($employee->parent_employee->name, ['controller' => 'Employees', 'action' => 'view', $employee->parent_employee->id]) : '' ?></td>
                <td><?= $employee->has('group') ? $this->Html->link($employee->group->name, ['controller' => 'Groups', 'action' => 'view', $employee->group->id]) : '' ?></td>
                <td><?= h($employee->lastname) ?></td>
                <td><?= $this->Number->format($employee->gender) ?></td>
                <td><?= h($employee->dob) ?></td>
                <td><?= h($employee->joining_date) ?></td>
                <td><?= $this->Number->format($employee->bsn_no) ?></td>
                <td><?= h($employee->uuid) ?></td>
                <td><?= h($employee->name) ?></td>
                <td><?= h($employee->bank_name) ?></td>
                <td><?= h($employee->account) ?></td>
                <td><?= h($employee->relation) ?></td>
                <td><?= h($employee->school) ?></td>
                <td><?= h($employee->workstart_date) ?></td>
                <td><?= h($employee->workend_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employee->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employee->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?>
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
