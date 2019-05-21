<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user-circle-o"> </i>User Profile</h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="row clearfix">
			<!-- Task Info -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card data-table-outer">
					<div class="header">
							<h2 class="text-uppercase"><?=$profile->firstname .' '. $profile->lastname;?></h2>
					</div>
					<div class="body">
						<div class="row">
							<div class="col-md-3 sol-sm-4">
								<?php
								if(!empty($profile['image'])){
									echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$profile['uuid'].'/'.$profile['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic']),'',['escapeTitle' => false,]);
								}else{								
									echo $this->Html->link($this->Html->image('blank-avatar.png', ['alt' => 'John','class' => 'img-responsive max-width-user-pic']),'',['escapeTitle' => false,]);
								}
								?>
							</div>
							<div class="col-md-9 col-sm-8">
								<div class="user-info-row">
									<label><?=__('First Name')?> </label>
									<p><?=$profile->firstname;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Last Name')?> </label>
									<p><?=$profile->lastname;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Email Address')?></label>
									<p><?=$profile->email;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Mobile Number')?> </label>
									<p><?=$profile->mobile_no;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('BSN No')?> </label>
									<p><?=$profile->bsn_no;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Employee Id')?></label>
									<p><?=$profile->id;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Date of Birth')?></label>
									<p><?=date('d-m-Y', strtotime($profile->dob));?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Joining Date')?></label>
									<p><?=$profile->joining_date;?></p>
								</div>
								<div class="user-info-row">
									<label>Gender</label>
									<p><?php if($profile->gender == 1){?>
										<?=__('Male')?>
										<?php } else {?>
										<?=__('Female')?>
									<?php }?></p>
									
								</div>
								<div class="user-info-row">
									<label><?=__('Postcode')?></label>
									<p><?=$profile->post_code;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Residance')?></label>
									<p><?=$profile->residence;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Address')?></label>
									<p><?=$profile->address;?></p>
								</div>
								<div class="user-info-row">
									<label><?=__('Status')?></label>
									<p><?php if($profile->is_active == 0){?>
										<span class="label bg-red"><?=__('Not Activated Yet')?></span>
										<?php } else {?>
										<span class="label bg-green"><?=__('Activated')?></span>
									<?php }?></p>
									
								</div> 
							</div>
						</div>
						
						<div class="back-btn text-right cs-btn-group">
							<?php
								echo $this->Html->link('<span>'__('Go Back').'</span>',['controller' => 'users', 'action' => 'employees','prefix'=>false],['escape' => false,'class'=>'btn bg-deep-purple waves-effect']);
								echo $this->Html->link('<span>'__('Edit').'</span>',['controller' => 'users', 'action' => 'empEdit',$profile['uuid']],['escape' => false,'class'=>'btn bg-deep-orange waves-effect']);
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Task Info -->
		</div>
	</div>
</section>