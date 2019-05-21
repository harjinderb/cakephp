<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user-circle-o"> </i><?= __('User Profile')?></h2>
		</div>
		<div class="row clearfix">
			<!-- Task Info -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="card data-table-outer">
					<div class="header">
						<h2 class="text-uppercase"><?=$this->Decryption->mc_decrypt($profile->firstname,$profile->encryptionkey).' '.$this->Decryption->mc_decrypt($profile->lastname,$profile->encryptionkey);?></h2>
						
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
									<label><?= __('BSO Name')?></label>
									<p><?=$this->Decryption->mc_decrypt($profile->firstname,$profile->encryptionkey);?></p>
								</div>
								
								<div class="user-info-row">
									<label><?= __('Email Address')?></label>
									<p><?=$this->Decryption->emailDecode($profile->email);?></p>
								</div>
								<div class="user-info-row">

									<label><?= __('Mobile Number')?></label>
									<p><?=$this->Decryption->mc_decrypt($profile->mobile_no,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label><?= __('Postcode')?></label>
									<p><?=$this->Decryption->mc_decrypt($profile->post_code,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label><?= __('Address')?></label>
									<p><?=$this->Decryption->mc_decrypt($profile->address,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label><?= __('Woonplaats')?></label>
									<p><?=$this->Decryption->mc_decrypt($profile->residence,$profile->encryptionkey);?></p>
								</div>
								<div class="user-info-row">
									<label><?= __('Status')?></label>
									<p><?php if($profile->is_active == 0){?>
										<span class="label bg-red">Not Activated Yet</span>
										<?php } else {?>
										<span class="label bg-green">Activated</span>
									<?php }?></p>
								</div>
								
							</div>

						</div>
						<div class="back-btn text-right cs-btn-group">
							<?php
								echo $this->Html->link('<span>'.__('Go Back').'</span>',['controller' => 'users', 'action' => 'index'],['escape' => false,'class'=>'btn bg-deep-purple waves-effect']);
								if($profile['id']== $this->request->getSession()->read('Auth.User.id')){
									echo $this->Html->link('<span>Edit</span>',['controller' => 'users', 'action' => 'profileEdit',$profile['uuid']],['escape' => false,'class'=>'btn bg-deep-orange waves-effect']);
								}else{
									echo $this->Html->link('<span>'.__('Edit').'</span>',['controller' => 'users', 'action' => 'edit',$profile['uuid']],['escape' => false,'class'=>'btn bg-deep-orange waves-effect']);
								}
								
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Task Info -->
		</div>
	</div>
</section>