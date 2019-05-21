<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('email');
            echo $this->Form->control('address');
            echo $this->Form->control('residence');
            echo $this->Form->control('token');
            echo $this->Form->control('image');
            echo $this->Form->control('mobile_no');
            echo $this->Form->control('post_code');
            echo $this->Form->control('is_active');
            echo $this->Form->control('password');
            echo $this->Form->control('role');
            echo $this->Form->control('flag');
            echo $this->Form->control('bso_id');
            echo $this->Form->control('parent_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
