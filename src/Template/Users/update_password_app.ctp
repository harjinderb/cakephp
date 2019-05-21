<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user"> </i><?=__('Reset Your Password')?></h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="m-t-30 back-btn text-right">
			
			<?php // echo $this->Html->link('<span>Sign in</span>',['controller' => 'users', 'action' => 'login'],['escape' => false,'class'=>'btn bg-deep-purple waves-effect']); ?>
		</div>
		
		<div class="card m-t-30">
			<div class="body">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 p-t-30">
						<?php
						echo $this->Form->create($user ,['class'=>'form-inline-cs']);
						?>
						<div class="form-group_">
							<label for="password"><?=__('New Password  * ')?></label>
							<?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'']);?>
							<i style="font-size:12px">(<?=__('Password must contain atleast one capital letter and alphanumeric characters.')?></i>
						</div>
						<div class="form-group_">
							<label><?=__('Confirm Password  *')?></label>
							<?= $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password']);?>
						</div>
						<div class="text-right m-b-10 m-t-30">
							<?= $this->Form->button(__('Reset Password'),['class' => 'btn bg-deep-purple']);
								echo $this->Form->end();
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>