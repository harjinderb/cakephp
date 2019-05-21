<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employees view large-9 medium-8 columns content">
    <h3><?= h($employee->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Firstname') ?></th>
            <td><?= h($employee->firstname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($employee->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($employee->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Residence') ?></th>
            <td><?= h($employee->residence) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($employee->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mobile No') ?></th>
            <td><?= h($employee->mobile_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post Code') ?></th>
            <td><?= h($employee->post_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($employee->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $employee->has('role') ? $this->Html->link($employee->role->name, ['controller' => 'Roles', 'action' => 'view', $employee->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employee->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employee->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Employee') ?></th>
            <td><?= $employee->has('parent_employee') ? $this->Html->link($employee->parent_employee->name, ['controller' => 'Employees', 'action' => 'view', $employee->parent_employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Group') ?></th>
            <td><?= $employee->has('group') ? $this->Html->link($employee->group->name, ['controller' => 'Groups', 'action' => 'view', $employee->group->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lastname') ?></th>
            <td><?= h($employee->lastname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dob') ?></th>
            <td><?= h($employee->dob) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Joining Date') ?></th>
            <td><?= h($employee->joining_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Uuid') ?></th>
            <td><?= h($employee->uuid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($employee->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bank Name') ?></th>
            <td><?= h($employee->bank_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Account') ?></th>
            <td><?= h($employee->account) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Relation') ?></th>
            <td><?= h($employee->relation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('School') ?></th>
            <td><?= h($employee->school) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employee->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $this->Number->format($employee->is_active) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Flag') ?></th>
            <td><?= $this->Number->format($employee->flag) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bso Id') ?></th>
            <td><?= $this->Number->format($employee->bso_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gender') ?></th>
            <td><?= $this->Number->format($employee->gender) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bsn No') ?></th>
            <td><?= $this->Number->format($employee->bsn_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Workstart Date') ?></th>
            <td><?= h($employee->workstart_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Workend Date') ?></th>
            <td><?= h($employee->workend_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Token') ?></h4>
        <?= $this->Text->autoParagraph(h($employee->token)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Employees') ?></h4>
        <?php if (!empty($employee->child_employees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Firstname') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Residence') ?></th>
                <th scope="col"><?= __('Token') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Mobile No') ?></th>
                <th scope="col"><?= __('Post Code') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Role Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Flag') ?></th>
                <th scope="col"><?= __('Bso Id') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Group Id') ?></th>
                <th scope="col"><?= __('Lastname') ?></th>
                <th scope="col"><?= __('Gender') ?></th>
                <th scope="col"><?= __('Dob') ?></th>
                <th scope="col"><?= __('Joining Date') ?></th>
                <th scope="col"><?= __('Bsn No') ?></th>
                <th scope="col"><?= __('Uuid') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Bank Name') ?></th>
                <th scope="col"><?= __('Account') ?></th>
                <th scope="col"><?= __('Relation') ?></th>
                <th scope="col"><?= __('School') ?></th>
                <th scope="col"><?= __('Workstart Date') ?></th>
                <th scope="col"><?= __('Workend Date') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->child_employees as $childEmployees): ?>
            <tr>
                <td><?= h($childEmployees->id) ?></td>
                <td><?= h($childEmployees->firstname) ?></td>
                <td><?= h($childEmployees->email) ?></td>
                <td><?= h($childEmployees->address) ?></td>
                <td><?= h($childEmployees->residence) ?></td>
                <td><?= h($childEmployees->token) ?></td>
                <td><?= h($childEmployees->image) ?></td>
                <td><?= h($childEmployees->mobile_no) ?></td>
                <td><?= h($childEmployees->post_code) ?></td>
                <td><?= h($childEmployees->is_active) ?></td>
                <td><?= h($childEmployees->password) ?></td>
                <td><?= h($childEmployees->role_id) ?></td>
                <td><?= h($childEmployees->created) ?></td>
                <td><?= h($childEmployees->modified) ?></td>
                <td><?= h($childEmployees->flag) ?></td>
                <td><?= h($childEmployees->bso_id) ?></td>
                <td><?= h($childEmployees->parent_id) ?></td>
                <td><?= h($childEmployees->group_id) ?></td>
                <td><?= h($childEmployees->lastname) ?></td>
                <td><?= h($childEmployees->gender) ?></td>
                <td><?= h($childEmployees->dob) ?></td>
                <td><?= h($childEmployees->joining_date) ?></td>
                <td><?= h($childEmployees->bsn_no) ?></td>
                <td><?= h($childEmployees->uuid) ?></td>
                <td><?= h($childEmployees->name) ?></td>
                <td><?= h($childEmployees->bank_name) ?></td>
                <td><?= h($childEmployees->account) ?></td>
                <td><?= h($childEmployees->relation) ?></td>
                <td><?= h($childEmployees->school) ?></td>
                <td><?= h($childEmployees->workstart_date) ?></td>
                <td><?= h($childEmployees->workend_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $childEmployees->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $childEmployees->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $childEmployees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childEmployees->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
