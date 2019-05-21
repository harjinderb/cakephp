<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $employee->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parent Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employees form large-9 medium-8 columns content">
    <?= $this->Form->create($employee) ?>
    <fieldset>
        <legend><?= __('Edit Employee') ?></legend>
        <?php
            echo $this->Form->control('firstname');
            echo $this->Form->control('email');
            echo $this->Form->control('address');
            echo $this->Form->control('residence');
            echo $this->Form->control('token');
            echo $this->Form->control('image');
            echo $this->Form->control('mobile_no');
            echo $this->Form->control('post_code');
            echo $this->Form->control('is_active');
            echo $this->Form->control('password');
            echo $this->Form->control('role_id', ['options' => $roles, 'empty' => true]);
            echo $this->Form->control('flag');
            echo $this->Form->control('bso_id');
            echo $this->Form->control('parent_id', ['options' => $parentEmployees, 'empty' => true]);
            echo $this->Form->control('group_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('lastname');
            echo $this->Form->control('gender');
            echo $this->Form->control('dob');
            echo $this->Form->control('joining_date');
            echo $this->Form->control('bsn_no');
            echo $this->Form->control('uuid');
            echo $this->Form->control('name');
            echo $this->Form->control('bank_name');
            echo $this->Form->control('account');
            echo $this->Form->control('relation');
            echo $this->Form->control('school');
            echo $this->Form->control('workstart_date', ['empty' => true]);
            echo $this->Form->control('workend_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
