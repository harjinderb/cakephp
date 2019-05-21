<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2 class="text-uppercase"><i class="fa fa-user"> </i> Edit New BSO</h2>
			<?= $this->Flash->render() ?>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-sm-6">
								<h2>
								<?=__('BSO Details')?>
								</h2>
							</div>
							<div class="col-sm-6 text-right">
								<?php echo $this->Html->link(
								'<span>'.__('Go Back').'</span>',
								['controller' => 'users', 'action' => 'index'],
								['escape' => false,'class'=>'btn bg-blue-grey']);
								$counterylisting = $this->Counterylist->countries();
								?>
								
							</div>
						</div>
					</div>
					
					<div class="body">
						<div class="form-common profile-upload-cs">
							<div class="row">
								<?php
								echo $this->Form->create($user,['class'=>'myform form-inline-cs','type'=>'file']);
								?>
								<div class="row">
									<div class="col-sm-4 col-md-3">
										<div class="form-group upload-img">
											<span class="text-info text-small p-b-10"><?=__('Image size should be 1:1')?></span>
											<div class="input-file-outer">
												<div class="input-file-in">
													<?php if(!empty($user['image'])){
																echo $this->Html->link($this->Html->image(USER_PICTURE_FOLDER_URL_PATH.$user['uuid'].'/'.'/thumb/200/'.$user['image'], ['alt' => 'John','class' => 'img-responsive max-width-user-pic','id'=>'UplodImg']),'',['escapeTitle' => false,]);
															}else{ ?>
															
																<img id="UplodImg" src ='<?php echo $this->request->webroot.'img/no-img.jpg';?>' alt="Image Name" />
															<?php }
												?>
												</div>
												<span class="text-info text-small p-t-10"><?=__('Only PNG and JPEG format is allowed.')?></span>
												<input type="file" class="input-file" id="" onchange="readURL(this);">
												<?= $this->Form->control('image', ['label' => false,'onchange'=>'readURL(this);','class'=>'input-file','type' => 'file','accept'=>'image/png, image/jpeg']);?>
												<button class="btn bg-blue input-file-btn"><?=__(' Upload image')?></button>
											</div>
										</div>
									</div>
									<div class="col-sm-8 col-md-8">
										<div class="form-group">
										<label><?=__('Select Countery')?>*</label>
										<?=$this->Form->select('countery',$counterylisting,['multiple' => false,'value' => $GlobalSettings['countery_code'],'label' => false, 'class' => 'form-control select2','id'=>'countery','type'=>'text']);?>
										</div>
										<div class="form-group">
										<label><?=__('Select Timezone Region')?></label>
										<?=$this->Form->select('region',$regions,['multiple' => false,'value' => $regions,'label' => false, 'class' => 'form-control select2','id'=>'region','type'=>'text']);?>
										</div>
										<div class="form-group">
											<label><?=__('BSO Name')?>  *</label>
											<?= $this->Form->control('firstname',   ['label' => false, 'class' => 'form-control', 'placeholder' =>  __('BSO Name'),'value'=> $this->Decryption->mc_decrypt($user['firstname'],$user['encryptionkey'])]); ?>
										</div>
										<div class="form-group">
											<label><?=__('Email Address')?> *</label>
											<?= $this->Form->control('email',     ['label' => false, 'class' => 'form-control', 'placeholder' =>  __('Email Address'),'readonly'=> true,'value'=> $this->Decryption->emailDecode($user['email'])]);?>
										</div>
										<div class="form-group">
											<label><?=__('Mobile Number')?>   *</label>
											<span id="errmsg" style="color:red;"></span>
											<?= $this->Form->control('mobile_no', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxxxxxxxx','value'=> $this->Decryption->mc_decrypt($user['mobile_no'],$user['encryptionkey'])]);?>
										</div>
										
										<div class="form-group">
											<!-- 				<label>Date of Birth *</label>
											-->				<?= $this->Form->control('dob',     ['label' => false, 'class' => 'datepicker form-control', 'placeholder' =>  __('DOB'),'type'=>'hidden']);?>
										</div>
										<div class="form-group">
											<label><?=__('Post Code *')?></label>
											<?= $this->Form->control('post_code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'xxxx-xx-x','id'=>'autocomplete','value'=> $this->Decryption->mc_decrypt($user['post_code'],$user['encryptionkey'])]);?>
											<div class="ui-widget" style="margin-top:2em; font-family:Arial">
												<!-- 				Result:
												-->			<!-- 	<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div> -->
											</div>
										</div>
										<div class="form-group">
											<label><?=__('Address')?>*</label>
											<?= $this->Form->control('address',   ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Address'),'id'=>'address','value'=> $this->Decryption->mc_decrypt($user['address'],$user['encryptionkey'])]);?>
										</div>
										<div class="form-group">
											<label><?=__('Woonplaats')?> *</label>
											<?= $this->Form->control('residence', ['type'=>'textarea','label' => false, 'class' => 'form-control', 'placeholder' => 'Residence','id'=>'city','value'=> $this->Decryption->mc_decrypt($user['residence'],$user['encryptionkey'])]);?>
										</div>
										<div class="form-group">
											<!-- <label for="password">Password  * <i style="font-size:12px">(Password must contain atleast one capital letter and alphanumeric characters.)</i></label> -->
											<?= $this->Form->control('password', ['type'=>'hidden','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Password'),'value'=>'']);?>
										</div>
										<div class="form-group">
											<!-- <label>Confirm Password  *</label> -->
											<?= $this->Form->control('confirm_password', ['type'=>'hidden','label' => false, 'class' => 'form-control', 'placeholder' =>  __('Confirm password'),'value'=>'']);?>
										</div>
										<div class="form-group">
											<!--  -->
											<?= $this->Form->control('parent_id', ['label' => false, 'class' => 'form-control','type'=>'hidden','value'=> '0']);?>
										</div>
										<!-- 	<div class="form-group">
											<label>BSO Image *</label>
											<?php// $this->Form->control('image', ['label' => false, 'type' => 'file']);?>
										</div> -->
										<!-- echo $this->Form->control('field', ['type' => 'file']); -->
										<div class="text-right m-b-10 m-t-30">
											<?= $this->Form->button(__('Save'),['class' => 'btn btn-lg bg-teal']);
											echo $this->Form->end();
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>