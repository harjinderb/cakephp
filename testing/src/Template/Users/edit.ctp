<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user"> </i> Edit</h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="m-t-30 back-btn text-right">			
			<?php echo $this->Html->link('<span>Go Back</span>',['controller' => 'users', 'action' => 'index',$user->role],['escape' => false,'class'=>'btn bg-deep-purple waves-effect']); ?>
		</div>
		
		<div class="card m-t-30">
			<div class="body">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 p-t-30">
						<?php
						echo $this->Form->create($user,['class'=>'form-inline-cs','type'=>'file']);
						?>
						<div class="form-group">
							<label>Name  *</label>
							<?= $this->Form->control('name',   ['label' => false, 'class' => 'form-control', 'placeholder' => 'BSO Name']); ?>
						</div>
						<div class="form-group">
							<label>Email Address  *</label>
							<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' => 'Email Address']);?>
						</div>
						<div class="form-group">
							<label>Mobile Number  *</label>
							<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx']);?>
						</div>
						<div class="form-group">
							<label>Post Code *</label>
							<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x']);?>
						</div>							
						<div class="form-group">
							<label>Address *</label>
							<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Address']);?>
						</div>
						<div class="form-group">
							<label>Residence *</label>
							<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Residence']);?>
						</div>
						<div class="form-group">
							<label for="password">Password  * <i style="font-size:12px">(Password must contain atleast one capital letter and alphanumeric characters.)</i></label>
							<?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Password','value'=>'']);?>
						</div>
						<div class="form-group">
							<label>Confirm Password  *</label>
							<?= $this->Form->control('confirm_password', ['type'=>'password','label' => false, 'class' => 'form-control', 'placeholder' => 'Confirm password','value'=>'']);?>
						</div>
						<div class="form-group">
							<label>Image *</label>
							<?= $this->Form->control('image', ['label' => false, 'type' => 'file']);?>
						</div>
						<!-- echo $this->Form->control('field', ['type' => 'file']); -->
						<div class="text-right m-b-10 m-t-30">
						<?= $this->Form->button('Create User',['class' => 'btn bg-deep-purple']);
						echo $this->Form->end();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>